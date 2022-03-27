<?php

namespace App\Http\Controllers\Site;

use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\VoteApplicationRequest;
use App\Jobs\CreateApplicationJob;
use App\Jobs\UpdateApplicationJob;
use App\Jobs\VoteJob;
use App\Models\Application;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Purchase;
use App\Models\Roles;
use App\Models\Subject;
use App\Models\User;
use App\Services\ApplicationService;
use App\Structures\ApplicationData;
use Illuminate\Support\Carbon;
use App\Models\SignedDocs;
use Exception;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Teamprodev\Eimzo\Services\EimzoService;
use Yajra\DataTables\DataTables;

class ApplicationController extends Controller
{
//    private EimzoService $eimzoService;
    public function __construct(){
        $this->middleware('auth');
//        $this->eimzoService = new EimzoService();

    }
    public function index(Request $request)
    {
        return view('site.applications.index');
    }

    public function getdata(Request $request)
    {
        $user = auth()->user();
        $query = Application::query();

        switch ($user->role_id) {
            // APPLICATION CREATOR
            case 1:
                {
                    $query = $query->where('user_id', auth()->id());
                }
                break;
            case 5: {
                $query = $query->where('user_id', auth()->id())->orWhere('status', Application::ACCEPTED);
            } break;
            default:
                {
                    $query = Application::all();
                }
                break;
        }
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $edit = route('site.applications.edit', $row->id);
                $show = route('site.applications.show', $row->id);
                return "<a href='{$edit}' class='edit btn btn-success btn-sm'>Edit</a> <a href='{$show}' class='show btn btn-warning btn-sm'>Show</a>";
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function show(Application $application)
    {
        return ApplicationService::show($application);
    }
    public function SignedDocs()
    {
        $data = SignedDocs::where('application_id',Cache::get('application_id'))->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('status', '@if($status == 0) Rejected @elseif($status == 1) Accepted @endif')
            ->editColumn('user_id', " @php echo auth()->user()->name @endphp ")
            ->make(true);
    }

    public function uploadImage(Request $request, Application $application)
    {
        $file_basis = json_decode($application->file_basis);
        $file_tech_spec = json_decode($application->file_tech_spec);
        $other_files = json_decode($application->other_files);
        if ($request->hasFile('file_basis')) {
            $files = $request->file('file_basis');
            $name = Storage::put('public/uploads', $files);
            $name = str_replace('public/','', $name);
            $file_basis[] = $name;
        }
        if ($request->hasFile('file_tech_spec')) {
            $files = $request->file('file_tech_spec');
            $name = Storage::put('public/uploads', $files);
            $name = str_replace('public/','', $name);
            $file_tech_spec[] = $name;
        }
        if ($request->hasFile('other_files')) {
            $files = $request->file('other_files');
            $name = Storage::put('public/uploads', $files);
            $name = str_replace('public/','', $name);
            $other_files[] = $name;
        }

        $application->file_basis = json_encode($file_basis);
        $application->file_tech_spec = json_encode($file_tech_spec);
        $application->other_files = json_encode($other_files);
        $application->update();
    }
    public function create()
    {
        $application = new Application();
        $application->user_id = auth()->user()->id;
        $result = $application->save();
        $data = Application::latest('id')->first();
        return redirect()->route('site.applications.edit',$data->id);
    }
    public function edit(Application $application)
    {
        return ApplicationService::edit($application);
    }
    public function update(Application $application, ApplicationRequest $request){
        $data = $request->validated();
        $result = $application->update($data);
        if ($result)
            return redirect()->route('site.applications.index')->with('success', trans('site.application_success'));

        return redirect()->back()->with('danger', trans('site.application_failed'));
    }
    public function store(ApplicationRequest $request)
    {
        try{
            $this->dispatchNow(new CreateApplicationJob($request));
            return redirect()->route('site.applications.index')->with('success', trans('site.application_success'));
        } catch(Exception $exception){
            dd($exception);
            return redirect()->back()->with('danger', trans('site.application_failed'));
        }
    }
    public function getAll(){
        $applications = Application::all();
        return response()->json($applications);
    }
    public function form(Application $application , Request $request){
        return route('site.applications.form', compact($application));
    }
    public function vote(Application $application, VoteApplicationRequest $request){
        try{
            $this->dispatchNow(new VoteJob($application, $request));
            return redirect()->route('site.applications.index')->with('success', 'Voted!');
        } catch (Exception $exception){
            dd($exception);
            return redirect()->route('site.applications.index')->with('danger', 'Something went wrong!');

        }
    }

}
