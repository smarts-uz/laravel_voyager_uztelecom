<?php

namespace App\Http\Controllers\Site;

use App\DataTables\DraftDataTable;
use App\Models\StatusExtented;
use Illuminate\Support\Facades\Schema;
use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\VoteApplicationRequest;
use App\Jobs\UpdateApplicationJob;
use App\Jobs\VoteJob;
use App\Models\Application;
use App\Models\Branch;
use App\Models\Country;
use App\Models\Draft;
use App\Models\Notification;
use App\Models\PermissionRole;
use App\Models\Purchase;
use App\Models\Resource;
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
    /**
     * @var ApplicationService
     */
    private ApplicationService $service;

    public function __construct(ApplicationService $service){
        $this->middleware('auth');
        $this->service = $service;
//        $this->eimzoService = new EimzoService();

    }

    public function show_status($status)
    {
        Cache::put('status', $status);
        return view('site.applications.status');
    }

    public function status_table()
    {
        $data = Application::where('status', Cache::get('status'))->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('user_id', function($docs) {
                return $docs->user ? $docs->user->name:"";
            })
            ->editColumn('role_id', function($docs) {
                return $docs->role ? $docs->role->display_name:"";
            })
            ->editColumn('created_at', function ($data) {
                return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
            })
            ->editColumn('updated_at', function ($data) {
                return $data->updated_at ? with(new Carbon($data->updated_at))->format('Y/m/d') : '';
            })
            ->editColumn('status', function ($query){
                $status_new = __('lang.status_new');
                $status_in_process = __('lang.status_in_process');
                $status_accepted = __('lang.status_accepted');
                $status_refused = __('lang.status_refused');
                $status_agreed = __('lang.status_agreed');
                $status_rejected = __('lang.status_rejected');
                $status_distributed = __('lang.status_distributed');
                $status_cancelled = __('lang.status_cancelled');
                $status_performed = __('lang.performed');
                $status_overdue = 'просрочен';
                if($query->status === 'new'){
                    return $status_new;
                }elseif($query->status === 'in_process'){
                    return $status_in_process;
                }elseif($query->status === 'Overdue'){
                    return "<input value='{$status_overdue}' class='text-center m-1 col edit bg-danger btn-sm' disabled>";
                }elseif($query->status === 'accepted'){
                    return $status_accepted;
                }elseif($query->status === 'refused'){
                    return $status_refused;
                }elseif($query->status === 'agreed'){
                    return $status_agreed;
                }elseif($query->status === 'rejected'){
                    return $status_rejected;
                }elseif($query->status === 'distributed'){
                    return $status_distributed;
                }elseif($query->status === 'canceled'){
                    return $status_cancelled;
                }elseif($query->status === 'performed'){
                    return "<input value='{$status_performed}' class='text-center m-1 col edit bg-green btn-sm' disabled>";
                }else{
                    return $query->status;
                }
            })
            ->addColumn('action', function($row){
                $edit_e = route('site.applications.edit', $row->id);
                $clone_e = route('site.applications.clone', $row->id);
                $show_e = route('site.applications.show', $row->id);
                $destroy_e = route('site.applications.destroy', $row->id);
                $app_edit = __('lang.edit');
                $app_show= __('lang.show');;
                $app_clone= __('lang.clone');;
                $app_delete= __('lang.delete');;

                if($row->user_id == auth()->user()->id||auth()->user()->hasPermission('Branch_Performer')||auth()->user()->hasPermission('Company_Performer')||auth()->user()->hasPermission('Plan_Budget')||auth()->user()->hasPermission('Plan_Business')||auth()->user()->hasPermission('Number_Change'))
                {
                    $edit = "<a href='{$edit_e}' class='m-1 col edit btn btn-success btn-sm'>$app_edit</a>";
                }else{
                    $edit = "";
                }
                $show = "<a href='{$show_e}' class='m-1 col show btn btn-warning btn-sm'>$app_show</a>";
                if($row->user_id == auth()->user()->id)
                {
                    $destroy = "<a href='{$destroy_e}' class='m-1 col show btn btn-danger btn-sm'>$app_delete</a>";
                }else{
                    $destroy = "";
                }
                if($row->user_id == auth()->user()->id && $row->status == 'cancelled' || $row->user_id == auth()->user()->id && $row->status == 'refused')
                {
                    $clone = "<a href='{$clone_e}' class='m-1 col show btn btn-primary btn-sm'>$app_clone</a>";
                }else{
                    $clone = "";
                }

                return "<div class='row'>
                        {$edit}
                        {$show}
                        {$clone}
                        {$destroy}
                        </div>";
            })
            ->rawColumns(['action','status'])
            ->make(true);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Application::query()
                ->where('draft', '!=',null)
                ->orWhere('draft','!=', 0)
                ->latest('id')
                ->get();
            $user = auth()->user();

            if($user->hasPermission('ЦУЗ'))
            {
                $a = 'branch_initiator_id';
                $operator = '!=';
                $b = null;
            }else{
                $a = 'branch_initiator_id';
                $operator = '=';
                $b = $user->branch_id;
            }
            if($user->hasPermission('Add_Company_Signer') && $user->hasPermission('Add_Branch_Signer'))
            {

                $query = Application::query()
                    ->where($a,$operator,$b)
                    ->where('draft','!=',1)->where('signers','like',"%{$user->role_id}%")->orWhere('performer_role_id', $user->role->id)->where('draft','!=',1)->orWhere('user_id',auth()->user()->id)->where('draft','!=',1);
            }
            elseif($user->hasPermission('Warehouse'))
            {
                $status = 'товар доставлен';
                $query = Application::query()->where('draft','!=',1)->where('status','like',"%{$status}%")->orWhere('user_id',auth()->user()->id);
            }
            elseif($user->hasPermission('Company_Leader') && $user->hasPermission('Branch_Leader'))
            {
                $query = Application::query()->where('draft','!=',1)->where('is_more_than_limit',1)->where('status','agreed')->orWhere('is_more_than_limit', 0)->where('draft','!=',1)->where('status','accepted')->orWhere('status','distributed')->where('draft','!=',1)->orWhere('user_id',auth()->user()->id)->where('draft','!=',1);
            }
        elseif($user->role_id == 7)
            {
            $query = Application::query()->where('branch_initiator_id',auth()->user()->branch_id)->where('draft','!=',1)->where('status', "accepted")->orWhere('status','overdue');
        }
        elseif ($user->hasPermission('Company_Signer') || $user->hasPermission('Add_Company_Signer')||$user->hasPermission('Branch_Signer') || $user->hasPermission('Add_Branch_Signer'))
            {
            $query = Application::query()
                ->where($a,$operator,$b)
                ->where('draft','!=',1)
                ->where('signers','like',"%{$user->role_id}%")
                ->orWhere('performer_role_id', $user->role->id)
                ->where('draft','!=',1)
                ->orWhere('user_id',auth()->user()->id)
                ->where('draft','!=',1);
        }
        elseif ($user->hasPermission('Company_Performer') || $user->hasPermission('Branch_Performer'))
            {
                $query = Application::query()->where('draft','!=',1)->where('performer_role_id', $user->role->id)->orWhere('user_id',auth()->user()->id)->where('draft','!=',1);
            }
            elseif($user->hasPermission('Company_Leader'))
            {
                $query =  Application::query()->where('draft','!=',1)->where('status','agreed')->orWhere('status','distributed')->where('draft','!=',1)->orWhere('user_id',auth()->user()->id)->where('draft','!=',1);
            }
            elseif($user->hasPermission('Branch_Leader'))
            {
                $query = Application::query()->where('draft','!=',1)->where('is_more_than_limit', 0)->where('status', 'accepted')->orWhere('is_more_than_limit', 0)->where('draft','!=',1)->where('status', 'distributed')->orWhere('user_id',auth()->user()->id)->where('draft','!=',1);
            }

            else {
                $query = Application::query()->where('draft','!=',1)->where('user_id',$user->id);
            }

            return Datatables::of($query)
                ->editColumn('created_at', function ($query) {
                    return $query->created_at ? with(new Carbon($query->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('updated_at', function ($query) {
                    return $query->updated_at ? with(new Carbon($query->updated_at))->format('Y/m/d') : '';;
                })
                ->editColumn('status', function ($query){
                    $status_new = __('lang.status_new');
                    $status_in_process = __('lang.status_in_process');
                    $status_accepted = __('lang.status_accepted');
                    $status_refused = __('lang.status_refused');
                    $status_agreed = __('lang.status_agreed');
                    $status_rejected = __('lang.status_rejected');
                    $status_distributed = __('lang.status_distributed');
                    $status_cancelled = __('lang.status_cancelled');
                    $status_performed = __('lang.performed');
                    $status_overdue = 'просрочен';
                    if($query->status === 'new'){
                        return $status_new;
                    }elseif($query->status === 'in_process'){
                        return $status_in_process;
                    }elseif($query->status === 'overdue'||$query->status === 'Overdue'){
                        return "<input value='{$status_overdue}' class='text-center m-1 col edit bg-danger btn-sm' disabled>";
                    }elseif($query->status === 'accepted'){
                        return $status_accepted;
                    }elseif($query->status === 'refused'){
                        return $status_refused;
                    }elseif($query->status === 'agreed'){
                        return $status_agreed;
                    }elseif($query->status === 'rejected'){
                        return $status_rejected;
                    }elseif($query->status === 'distributed'){
                        return $status_distributed;
                    }elseif($query->status === 'canceled'){
                        return $status_cancelled;
                    }elseif($query->status === 'performed'){
                        return "<div class='row'>
                        <input type='text' value='{$status_performed}' style='background-color: green'>
                        </div>";
                    }else{
                        return $query->status;
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $edit_e = route('site.applications.edit', $row->id);
                    $clone_e = route('site.applications.clone', $row->id);
                    $show_e = route('site.applications.show', $row->id);
                    $destroy_e = route('site.applications.destroy', $row->id);
                    $app_edit = __('lang.edit');
                    $app_show= __('lang.show');;
                    $app_clone= __('lang.clone');;
                    $app_delete= __('lang.delete');;

                    if(auth()->user()->hasPermission('Warehouse') || $row->user_id == auth()->user()->id||auth()->user()->hasPermission('Branch_Performer')||auth()->user()->hasPermission('Company_Performer')||auth()->user()->hasPermission('Plan_Budget')||auth()->user()->hasPermission('Plan_Business')||auth()->user()->hasPermission('Number_Change'))
                    {
                        $edit = "<a href='{$edit_e}' class='m-1 col edit btn btn-success btn-sm'>$app_edit</a>";
                    }else{
                        $edit = "";
                    }
                    $show = "<a href='{$show_e}' class='m-1 col show btn btn-warning btn-sm'>$app_show</a>";
                    if($row->user_id == auth()->user()->id)
                    {
                        $destroy = "<a href='{$destroy_e}' class='m-1 col show btn btn-danger btn-sm'>$app_delete</a>";
                    }else{
                        $destroy = "";
                    }
                    if($row->user_id == auth()->user()->id && $row->status == 'cancelled' || $row->user_id == auth()->user()->id && $row->status == 'refused'||$row->user_id == auth()->user()->id && $row->status == 'rejected')
                    {
                        $clone = "<a href='{$clone_e}' class='m-1 col show btn btn-primary btn-sm'>$app_clone</a>";
                    }else{
                        $clone = "";
                    }

                    return "<div class='row'>
                        {$edit}
                        {$show}
                        {$clone}
                        {$destroy}
                        </div>";
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }
        return view('site.applications.index');
    }

    public function clone($id){
        $clone = Application::find($id);
        $application = $clone->replicate();
        $application->signers = null;
        $application->status = null;
        $application->save();
        return redirect()->back();
    }

    public function show(Application $application, $view = false)
    {
        if ($view == true) {
            Notification::query()
                ->where('application_id', $application->id)
                ->where('user_id', auth()->id())
                ->increment('is_read');
        }
        return $this->service->show($application);
    }

    public function SignedDocs($application)
    {
        $data = SignedDocs::where('application_id',$application)->get();
        return Datatables::of($data)
            ->addIndexColumn()
            ->editColumn('user_id', function($docs) {
                return $docs->user ? $docs->user->name:"";
            })
            ->editColumn('role_id', function($docs) {
                return $docs->role ? $docs->role->display_name:"";
            })
            ->editColumn('updated_at', function ($query) {
                    return $query->updated_at ? with(new Carbon($query->updated_at))->format('Y/m/d') : '';;
                })
            ->editColumn('status', function ($status){
                $status_agreed = __('lang.status_agreed');
                $status_refused = __('lang.status_refused');
                $status_not_signed = __('lang.status_not_signed');
                if($status->status == "1"){
                    return $status_agreed;
                }elseif($status->status == "0"){
                    return $status_refused;
                }else{
                    return $status_not_signed;
                }
            })
            ->make(true);
    }

    public function uploadImage(Request $request, Application $application)
    {
        $file_basis = json_decode($application->file_basis);
        $file_tech_spec = json_decode($application->file_tech_spec);
        $other_files = json_decode($application->other_files);
        $performer_file = json_decode($application->performer_file);
        if ($request->hasFile('file_basis')) {
            $fileName = time() . '_' .$request->file_basis->getClientOriginalName();
            $filePath = $request->file('file_basis')
                ->move(public_path("storage/uploads/"), $fileName);

            $file_basis[] = $fileName;
        }
        if ($request->hasFile('file_tech_spec')) {
            $fileName = time() . '_' .$request->file_tech_spec->getClientOriginalName();
            $filePath = $request->file('file_tech_spec')
                ->move(public_path("storage/uploads/"), $fileName);

            $file_tech_spec[] = $fileName;
        }
        if ($request->hasFile('other_files')) {
            $fileName = time() . '_' .$request->other_files->getClientOriginalName();
            $filePath = $request->file('other_files')
                ->move(public_path("storage/uploads/"), $fileName);

            $other_files[] = $fileName;
        }
        if ($request->hasFile('performer_file')) {
            $fileName = time() . '_' .$request->performer_file->getClientOriginalName();
            $filePath = $request->file('performer_file')
                ->move(public_path("storage/uploads/"), $fileName);

            $performer_file[] = $fileName;
        }

        $application->file_basis = json_encode($file_basis);
        $application->performer_file = json_encode($performer_file);
        $application->file_tech_spec = json_encode($file_tech_spec);
        $application->other_files = json_encode($other_files);
        $application->update();
    }

    public function create()
    {
        $latest = Application::latest('id')->first();
        $application = new Application();
        $application->user_id = auth()->user()->id;
        $application->status = Application::NEW;
        $application->save();
        $data = Application::query()->latest('id')->first();
        return redirect()->route('site.applications.edit',$data->id);
    }

    public function edit(Application $application)
    {
            return $this->service->edit($application);
    }

    public function update(Application $application, ApplicationRequest $request)
    {
        return $this->service->update($application,$request);
    }

    public function store(ApplicationRequest $request)
    {

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

    public function show_draft(Request $request)
    {
        if ($request->ajax()) {
            $user = auth()->user();
            $data = Application::query()
                ->where('user_id', $user->id)
                ->where('draft', !null)
                ->latest('id')
                ->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($data) {
                    return $data->created_at ? with(new Carbon($data->created_at))->format('m/d/Y') : '';
                })
                ->editColumn('updated_at', function ($data) {
                    return $data->updated_at ? with(new Carbon($data->updated_at))->format('Y/m/d') : '';;
                })
                ->addColumn('action', function($row){
                    $edit = route('site.applications.edit', $row->id);
                    $show = route('site.applications.show', $row->id);
                    $destroy = route('site.applications.destroy', $row->id);
                    $app_edit = __('lang.edit');
                    $app_show = __('lang.show');;
                    $app_clone = __('lang.clone');;
                    $app_delete = __('lang.delete');;
                    if($row->status == 'accepted' || $row->status =='refused')
                    {
                        $clone = route('site.applications.clone', $row->id);
                    }else{
                        $clone = '#';
                    }

                    return "<div class='row'>
                        <a href='{$edit}' class='m-1 col edit btn btn-success btn-sm'>$app_edit</a>
                        <a href='{$show}' class='m-1 col show btn btn-warning btn-sm'>$app_show</a>
                        <a href='{$clone}' class='m-1 col show btn btn-primary btn-sm'>$app_clone</a>
                        <a href='{$destroy}' class='m-1 col show btn btn-danger btn-sm'>$app_delete</a></div>";
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('site.applications.draft');
    }

    /**
     * soft delete post
     *
     * @return void
     */
    public function destroy($application)
    {
        Application::find($application)->delete();

        return redirect()->back();
    }

    /**
     * restore specific post
     *
     * @return void
     */
    public function restore($id)
    {
//        Application::withTrashed()->find($id)->restore();
//
//        return redirect()->back();
    }

    /**
     * restore all post
     *
     * @return response()
     */
    public function restoreAll()
    {
//        Application::onlyTrashed()->restore();
//
//        return redirect()->back();
    }
}
