@extends('site.layouts.app')
@section('center_content')
@if(auth()->user()->branch_id != null)
<div id="section" class="pt-6">
    <a href="{{route('site.applications.create')}}"
        class="ml-12 bg-blue-500 hover:bg-blue-700 p-2 transition duration-300 rounded-md text-white mb-8">
        {{ __('lang.create') }}
    </a>
    <div class="w-11/12 mx-auto pt-8 pb-16">
        <table id="yajra-datatable">
            <thead  class="text-center">
            <tr>
                <th>ID</th>
                <th>№</th>
                <th>{{ __('lang.table_1') }}</th>
                <th>{{ __('lang.table_2') }}</th>
                <th>{{ __('lang.table_3') }}</th>
                <th>{{ __('lang.table_4') }}</th>
                <th>{{ __('lang.table_5') }}</th>
                <th>{{ __('lang.table_6') }}</th>
                <th>{{ __('lang.table_61') }}</th>
                <th>{{ __('lang.table_7') }}</th>
                <th>{{ __('lang.table_8') }}</th>
            </tr>
            </thead>
        </table>
    </div>
</div>
@else
<h1 style="color: red;">Вы не выбрали ваш Филиал<br>Вы можете выбрать от профиля</h1>
@endif
@push('scripts')
<script>
    $(function () {
        var table = $('#yajra-datatable').DataTable({
            order: [[ 0, "desc" ]],
            processing: true,
            serverSide: true,
            ajax:
                 "{{ route('site.applications.index') }}",

            columns: [
                {data: 'id', name: 'id'},
                {data: 'number', name: 'number'},
                {data: 'initiator', name: 'initiator'},
                {data: 'name', name: 'name'},
                {data: 'delivery_date', name: 'delivery_date'},
                {
                    "data": "",
                    render: function (data, type, row) {
                            var details = row.planned_price + " " + row.currency ;
                                return details;
                        }
                },
                {data: 'incoterms', name: 'incoterms'},

                {data: 'created_at', name: 'created_at'},
                {data: 'updated_at', name: 'updated_at'},
                {data: 'status', name: 'status'},
                {
                    data: 'action',
                    name: 'action',
                    orderable: true,
                    searchable: true
                },
            ]
        });


  });
    if(document.getElementById('status').value === '{{__('lang.performed')}}')
    {
        document.getElementById('status').style.backgroundColor = green;
    }
</script>
@endpush
@endsection
