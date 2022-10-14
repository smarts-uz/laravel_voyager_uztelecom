@extends('site.layouts.app')
@section('center_content')
    <!doctype html>
<html lang="en">
<head>
    <link href="https://releases.transloadit.com/uppy/v2.4.1/uppy.min.css" rel="stylesheet">
    <!--Regular Datatables CSS-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchbuilder/1.3.2/css/searchBuilder.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchpanes/2.0.0/css/searchPanes.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.4/css/select.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.2/css/dataTables.dateTime.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.0/css/jquery.dataTables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css"/>

</head>

<div id="fortext"></div>

<table id="example" class="display wrap table-bordered " style="border-collapse: collapse; width: 100%; padding-top: 10px">
    <thead class="border border-dark">
    <tr class="border border-dark">
        <th style="text-align: center;" class="border border-dark" rowspan="2">{{ __('ID') }}</th>
        <th style="text-align: center;" class="border border-dark" rowspan="2">{{ __('Наименование заказчика') }}</th>
        <th style="text-align: center;" class="border border-dark" rowspan="2">{{ __('СТИР') }}</th>
        <th style="text-align: center;" class="border border-dark" colspan="2">{{ __('Договоры') }}</th>
        <th style="text-align: center;" class="border border-dark" colspan="2">{{ __('Через электронный магазин (E-shop)') }}</th>
        <th style="text-align: center;" class="border border-dark" colspan="2">{{ __('Через национальный магазин') }}</th>
        <th style="text-align: center;" class="border border-dark" colspan="2">{{ __('Через электронный аукцион')  }}</th>
        <th style="text-align: center;" class="border border-dark" colspan="2">{{ __('Через кооперационный портал') }}</th>
        <th style="text-align: center;" class="border border-dark" colspan="2">{{ __('Через платформы "Шаффоф қурилиш"') }}</th>
        <th style="text-align: center;" class="border border-dark" colspan="2">{{ __('Через электронные биржевые торги на специальных торговых площадках') }}</th>
        <th style="text-align: center;" class="border border-dark" colspan="2">{{ __('Через конкурс(выбор)') }}</th>
        <th style="text-align: center;" class="border border-dark" colspan="2">{{ __('Через тендер')}}</th>
        <th style="text-align: center;" class="border border-dark" colspan="2">{{ __('Выбор наиболее приемлемых предложений') }}</th>
        <th style="text-align: center;" class="border border-dark" colspan="2">{{ __('С едиными поставщиками') }} </th>
        <th style="text-align: center;" class="border border-dark" colspan="2">{{ __('Прямые (ПП-3988 и др. ПП, УП, РП)') }}</th>
    </tr>
    <tr>
        <th>{{ __('Количество') }}</th>
        <th>{{ __('Сумма') }}</th>
        <th>{{ __('Количество') }}</th>
        <th>{{ __('Сумма') }}</th>
        <th>{{ __('Количество') }}</th>
        <th>{{ __('Сумма') }}</th>
        <th>{{ __('Количество') }}</th>
        <th>{{ __('Сумма') }}</th>
        <th>{{ __('Количество') }}</th>
        <th>{{ __('Сумма') }}</th>
        <th>{{ __('Количество') }}</th>
        <th>{{ __('Сумма') }}</th>
        <th>{{ __('Количество') }}</th>
        <th>{{ __('Сумма') }}</th>
        <th>{{ __('Количество') }}</th>
        <th>{{ __('Сумма') }}</th>
        <th>{{ __('Количество') }}</th>
        <th>{{ __('Сумма') }}</th>
        <th>{{ __('Количество') }}</th>
        <th>{{ __('Сумма') }}</th>
        <th>{{ __('Количество') }}</th>
        <th>{{ __('Сумма') }}</th>
        <th>{{ __('Количество') }}</th>
        <th>{{ __('Сумма') }}</th>
    </tr>
    </thead>
</table>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.21/sorting/datetime-moment.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/searchbuilder/1.3.2/js/dataTables.searchBuilder.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/searchpanes/2.0.0/js/dataTables.searchPanes.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/datetime/1.1.2/js/dataTables.dateTime.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.12.0/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
<script defer src="https://use.fontawesome.com/releases/v5.4.1/js/all.js" integrity="sha384-L469/ELG4Bg9sDQbl0hvjMq8pOcqFgkSpwhwnslzvVVGpDjYJ6wJJyYjvG3u8XW7" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/af-2.3.2/b-1.5.4/b-colvis-1.5.4/b-flash-1.5.4/b-html5-1.5.4/b-print-1.5.4/cr-1.5.0/fc-3.2.5/fh-3.1.4/kt-2.5.0/r-2.2.2/rg-1.1.0/rr-1.2.4/sc-1.5.0/sl-1.2.6/datatables.min.js"></script>


<script>
    var columns = [
        {data: "id", name: 'id'},
        {data: "name", name: 'name'},

        {data: "supplier_inn", name: 'supplier_inn'},

        {data: "contract_count", name: 'contract_count'},
        {data: "contract_sum", name: 'contract_sum'},

        {data: "eshop_count", name: 'eshop_count'},
        {data: "eshop_sum", name: 'eshop_sum'},

        {data: "nat_eshop_count", name: 'nat_eshop_count'},
        {data: "nat_eshop_sum", name: 'nat_eshop_sum'},

        {data: "auction_count", name: 'auction_count'},
        {data: "auction_sum", name: 'auction_sum'},

        {data: "coop_count", name: 'coop_count'},
        {data: "coop_sum", name: 'coop_sum'},

        {data: "shaffof_count", name: 'shaffof_count'},
        {data: "shaffof_sum", name: 'shaffof_sum'},


        {data: "exchange_count", name: 'exchange_count'},
        {data: "exchange_sum", name: 'exchange_sum'},


        {data: "konkurs_count", name: 'konkurs_count'},
        {data: "konkurs_sum", name: 'konkurs_sum'},

        {data: "tender_count", name: 'tender_count'},
        {data: "tender_sum", name: 'tender_sum'},

        {data: "offers_count", name: 'offers_count'},
        {data: "offers_sum", name: 'offers_sum'},

        {data: "sole_supplier_count", name: 'sole_supplier_count'},
        {data: "sole_supplier_sum", name: 'sole_supplier_sum'},

        {data: "direct_count", name: 'direct_count'},
        {data: "direct_sum", name: 'direct_sum'},

    ];
</script>
<x-laravelYajra getData="{{ route('report','9') }}" tableTitle="{{__('9 - Ойлик харидлар илова плановый')}}"/>
@endsection
