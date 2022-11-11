@extends('site.layouts.app')
@section('center_content')
    <div id="section" class="pt-6">
        <a href="{{route('site.applications.create')}}"
           class="ml-12 bg-blue-500 hover:bg-blue-700 p-2 transition duration-300 rounded-md text-white mb-8">
            {{ __('Создать') }}
        </a>
        <div class="w-11/12 mx-auto pt-8 pb-16">

            {{ Aire::open()
      ->route('site.applications.performer_status_post')
      ->enctype("multipart/form-data")
      ->post() }}
            <div
                style="text-align: center; display: flex; justify-content: end; align-items: center; column-gap: 10px; margin-right: 20px">
                {{Aire::select($status, 'select', 'Статус')->value(setting('admin.performer_status_get'))->name('performer_status_get')}}

                <button type="submit" class="btn btn-success" style="margin-top: 8px;">{{ __("Выбрать") }}</button>
            </div>
            {{ Aire::close() }}
                <table id="yajra-datatable">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>{{ __('Статус заявки') }}</th>
                        <th>{{__('Визирование заявки через:') }}</th>
                        <th>{{ __('Заявки')}}</th>
                        <th>{{ __('Дата заявки')}}</th>
                        <th>{{ __('Инициатор (наименование подразделения заказчика)') }}</th>
                        <th>{{ __('Филиал') }}</th>
                        <th>{{ __('Наименование предмета закупки(товар, работа, услуги)') }}</th>
                        <th>{{ __('Ожидаемый срок поставки') }}</th>
                        <th>{{ __('Планируемый бюджет закупки (сумма)') }}</th>
                        <th>{{ __('Условия поставки по INCOTERMS') }}</th>
                        <th>{{ __('Действие') }}</th>
                    </tr>
                    </thead>
                </table>
        </div>
    </div>
    @push('scripts')
        <script>
            $(function () {
                var table = $('#yajra-datatable').DataTable({
                    order: [[0, "desc"]],
                    processing: true,
                    serverSide: true,
                    ajax:
                        "{{ route('site.applications.performer_status') }}",

                    columns: [
                        {data: 'id', name: 'id'},
                        {
                            data: 'status', name: 'status', render: function (data, type, row) {
                                var details = JSON.parse(row.status).backgroundColor;
                                var color = JSON.parse(row.status).color;
                                var app = JSON.parse(row.status).app;

                                return `<button style='background-color: ${details};color:${color};' class='btn-sm '>`+app+`</button>`;
                            }
                        },
                        {data: 'is_more_than_limit', name: 'is_more_than_limit'},
                        {data: 'number', name: 'number'},
                        {data: 'date', name: 'date'},
                        {data: 'initiator', name: 'initiator'},
                        {data: 'branch_initiator_id', name: 'branch_initiator_id'},
                        {data: 'name', name: 'name'},
                        {data: 'delivery_date', name: 'delivery_date'},
                        {data: 'planned_price_curr', name: 'planned_price_curr'},
                        {data: 'incoterms', name: 'incoterms'},
                        {
                            data: 'action',
                            render: function (link) {
                                return JSON.parse(link).link;
                            },
                            name: 'action',
                        },
                    ]
                });


            });
        </script>
    @endpush
@endsection
