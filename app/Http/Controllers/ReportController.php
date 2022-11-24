<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationMagicNumber;
use App\Http\Requests\ReportDateRequest;
use App\Models\ReportDate;
use App\Models\StatusExtended;
use App\Services\ApplicationService;
use App\Services\ReportService;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Branch;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    const Quarterly_Planned_Report = 22;
    const Report_Statuses_Quantity = 10;

    private ReportService $service;

    public function __construct(ReportService $service)
    {
        $this->middleware('auth');
        $this->service = $service;
    }
    /**
     * Request da Reportlar date keladi.
     * Shuni Cache ga put qiladi.
    **/
    public function request(ReportDateRequest $request)
    {
        $data = $request->validated();
        foreach($data as $key=>$value)
        {
            $report = ReportDate::UpdateOrCreate(['report_key' => $key]);
            $report->report_value = $value;
            $report->save();
        }
        return redirect()->back();
    }
    /**
     * Nechinchi Reportligiga qarab blade korsatiladi.
     **/
    public function index($id)
    {
        $report = ReportDate::all();
            if($id == self::Quarterly_Planned_Report)
                return view("site.report.{$id}",compact('report'));
            elseif($id < self::Report_Statuses_Quantity){
                return view("site.report.{$id}",compact('report'));
            }
            return view("site.report.10",compact('report'));
    }
    /**
     * Nechinchi Report ligiga qarab data chiqadi.
     **/
    public function report($id)
    {
        switch ($id)
        {
            case ApplicationMagicNumber::one:
            return $this->service->report_1();
            break;
            case ApplicationMagicNumber::two:
            return $this->service->report_2();
            break;
            case ApplicationMagicNumber::twentyTwo:
            return $this->service->report_2_2();
            break;
            case ApplicationMagicNumber::three:
            return $this->service->report_3();
            break;
            case ApplicationMagicNumber::four:
            return $this->service->report_4();
            break;
            case ApplicationMagicNumber::five:
            return $this->service->report_5();
            break;
            case ApplicationMagicNumber::six:
            return $this->service->report_6();
            break;
            case ApplicationMagicNumber::seven:
            return $this->service->report_7();
            break;
            case ApplicationMagicNumber::eight:
            return $this->service->report_8();
            break;
            case ApplicationMagicNumber::nine:
            return $this->service->report_9();
            break;
            default:
            return $this->service->report_10();
        }


    }
}
