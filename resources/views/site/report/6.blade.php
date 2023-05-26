@extends('site.layouts.app')
@section('center_content')
<x-laravelDateRangePicker format="YYYY-MM-DD" reportId="6" route="{{ route('site.report.index','6') }}"/>
<x-laravelYajra language="ru" tableId="report6" stateSave="true" :dtColumns=$dtColumns :dtHeaders=$dtHeaders dom='QBlfrtip' serverSide="true" getData="{{ route('report','6') }}" exportId="{{ \App\Reports\Six::class }}" tableTitle="{{__('6 - Отчет свод')}}" startDate="{{request()->input('startDate')}}" endDate="{{request()->input('endDate')}}"/>
@endsection
