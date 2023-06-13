@extends('site.layouts.app')
@section('center_content')

<x-laravelDateRangePicker format="YYYY-MM-DD" reportId="8" route="{{ route('site.report.index','8') }}"/>
<x-laravelYajra language="ru" tableId="report8" stateSave="true" dom='QBlfrtip'
                serverSide="true" scrollX="true" getData="{{ route('report','8') }}"
                exportId="{{ \App\Reports\Eight::class }}"
                tableTitle="{{__('8 - Отчет по видам закупки')}}"
                startDate="{{request()->input('startDate')}}"
                endDate="{{request()->input('endDate')}}"/>
@endsection
