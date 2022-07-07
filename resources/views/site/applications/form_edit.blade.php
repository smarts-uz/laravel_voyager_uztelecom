
<div class="mt-6">
    <div class="w-full flex">
        <div class="p-6">
            <h5><strong>{{ __('Визирование заявки через :') }} </strong>
                @if($application->is_more_than_limit == 1)
                    Компанию
                @elseif($application->is_more_than_limit == '0')
                    Филиала
                @endif
            </h5>
            <div class="mb-3 row">
                <label class="col-sm-6" for="initiator" class="col-sm-2 col-form-label">{{ __('Инициатор (наименование подразделения заказчика)') }}</label>
                <div class="col-sm-6">
                    {{Aire::input()
                        ->name("initiator")
                        ->value($application->initiator)
                        ->class("form-control")
                        ->required()
                    }}
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-6" for="purchase_basis" class="col-sm-2 col-form-label">{{ __('Цель / содержание закупки (обоснование необходимости закупки)') }}</label>
                <div class="col-sm-6">
                    {{Aire::textArea()
                        ->rows(3)
                        ->name("purchase_basis")
                        ->value($application->purchase_basis)
                        ->cols(40)
                        ->class("form-control")
                        ->required()
                    }}
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-6" for="basis" class="col-sm-2 col-form-label">{{ __('Основания (план закупок, рапорт,распоряжение руководства)') }}</label>
                <div class="col-sm-6">
                    {{Aire::textArea()
                        ->rows(3)
                        ->name("basis")
                        ->value($application->basis)
                        ->cols(40)
                        ->class("form-control")
                        ->required()
                    }}
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-6" for="name" class="col-sm-2 col-form-label">{{ __('Наименование предмета закупки(товар, работа, услуги)') }}</label>
                <div class="col-sm-6">
                    {{Aire::input()
                        ->name("name")
                        ->value($application->name)
                        ->class("form-control")
                        ->required()
                    }}
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-6" for="specification" class="col-sm-2 col-form-label">{{ __('Описание предмета закупки (технические характеристики)') }}</label>
                <div class="col-sm-6">
                    {{Aire::textArea()
                        ->rows(3)
                        ->name("specification")
                        ->value($application->specification)
                        ->cols(40)
                        ->class("form-control")
                        ->required()
                    }}
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-6" for="date" class="col-sm-2 col-form-label">{{ __('Ожидаемый срок поставки') }}</label>
                <div class="col-sm-6">
                    <input class="form-control" id="date" name="delivery_date" value="{{ $application->delivery_date }}" type="date"/>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-6" for="separate_requirements" class="col-sm-2 col-form-label">{{ __('Особые требования') }}</label>
                <div class="col-sm-6">
                    {{Aire::textArea()
                        ->rows(3)
                        ->name("separate_requirements")
                        ->value($application->separate_requirements)
                        ->cols(40)
                        ->class("form-control")
                        ->required()
                    }}
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-6" for="other_requirements" class="col-sm-2 col-form-label">{{ __('Дополнительные требования') }}</label>
                <div class="col-sm-6">
                    {{Aire::textArea()
                        ->rows(3)
                        ->name("other_requirements")
                        ->value($application->other_requirements)
                        ->cols(40)
                        ->class("form-control")
                        ->required()
                    }}
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-6" for="date" class="col-sm-2 col-form-label">{{ __('Гарантийный срок качества товара (работ, услуг)') }}</label>
                <div class="col-sm-6">
                    <input class="form-control" id="date" name="expire_warranty_date" value="{{$application->expire_warranty_date}}" type="date"/>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-6" for="planned_price" class="col-sm-2 col-form-label">{{ __('Планируемый бюджет закупки (сумма)') }}</label>
                <div class="col-sm-6">
                    {{Aire::number()
                        ->name("planned_price")
                        ->id("planned_price")
                        ->value($application->planned_price , 0 , '' , ' ')
                        ->class("form-control")
                        ->required()
                    }}
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-6" for="incoterms" class="col-sm-2 col-form-label">{{ __('Условия поставки по INCOTERMS (самовывоз со склада/доставка до покупателя)') }}</label>
                <div class="col-sm-6">
                    {{Aire::textArea()
                        ->rows(3)
                        ->name("incoterms")
                        ->value($application->incoterms)
                        ->cols(40)
                        ->class("form-control")
                        ->required()
                    }}
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-6" for="info_business_plan" class="col-sm-2 col-form-label">{{ __('Департамент по планированию бюджета - информация о существовании товара закупок в бизнес-плане') }}</label>
                <div class="col-sm-6">
                    {{Aire::input()
                        ->name("info_business_plan")
                        ->value($application->info_business_plan)
                        ->class("form-control")
                    }}
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-6" for="info_purchase_plan" class="col-sm-2 col-form-label">{{ __('Информация о наличии в «Плане закупок» приобретаемых товаров') }}</label>
                <div class="col-sm-6">
                    {{Aire::textArea()
                        ->rows(3)
                        ->name("info_purchase_plan")
                        ->value($application->info_purchase_plan)
                        ->cols(40)
                        ->class("form-control")
                    }}
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-6" for="comment" class="col-sm-2 col-form-label">{{ __('Комментарий') }}</label>
                <div class="col-sm-6">
                    {{Aire::textArea()
                        ->rows(3)
                        ->name("comment")
                        ->value($application->comment)
                        ->cols(40)
                        ->class("form-control")
                        ->required()
                    }}
                </div>
                @if($application->with_nds == 1)
                {{Aire::checkbox('checkbox', __('lang.performer_nds'))
                            ->checked()
                       ->name('with_nds')
                    }}
                @else
                {{Aire::checkbox('checkbox', __('lang.performer_nds'))
                   ->name('with_nds')
                   }}
                  @endif
        </div>
            @if(isset($application->resource_id))
                <b>{{ __('lang.resource')}}</b>:
                @foreach(json_decode($application->resource_id) as $product)
                    <br> {{\App\Models\Resource::find($product)->name}}
                @endforeach
            @endif
        <div class="mb-3 row">
            <label for="currency" class="col-sm-6 col-form-label">{{ __('lang.valyuta') }}</label>
                <select class="form-control col-sm-6" name="currency" id="currency">
                    <option value="UZS" @if($application->currency === "UZS") selected @endif>UZS</option>
                    <option value="USD" @if($application->currency === "USD") selected @endif>USD</option>
                </select>
            </div>

            @if($application->is_more_than_limit == '1')
                {{Aire::checkboxGroup($company_signers, 'radio', __('lang.signers'))
                    ->name('signers[]')
                    ->value(json_decode($application->signers))
                    ->multiple()
                }}
            @elseif($application->is_more_than_limit != '1' )
                {{Aire::checkboxGroup($branch_signers, 'radio', __('lang.signers'))
                    ->name('signers[]')
                    ->value(json_decode($application->signers))
                    ->multiple()
                }}
            @endif
        </div>
        <div class="flex-direction: column">
            @if($application->file_basis === 'null' ||$application->file_basis === null)
                <div class="mx-1">
                    <h6 class="my-3">{{ __('lang.base') }}</h6>
                    <div id="file_basis"></div>
                </div>
            @endif
            @if($application->file_tech_spec === 'null' ||$application->file_tech_spec === null)
                <div class="mx-1">
                    <h6 class="my-3">{{ __('lang.tz') }}</h6>
                    <div id="file_tech_spec"></div>
                </div>
            @endif
            @if($application->other_files === 'null' ||$application->other_files === null)
                <div class="mx-1">
                    <h6 class="my-3">{{ __('Другие файлы') }}</h6>
                    <div id="other_files"></div>
                </div>
            @endif
        </div>
    </div>
</div>
@if($application->resource_id === null)
    <input id="resource_id" name="resource_id" value=null class="hidden" type="text">
    <table id="table"></table>
@endif
<script src="https://unpkg.com/jquery.appendgrid@2.0.0/dist/AppendGrid.js"></script>
{{--@dd(json_encode($products,JSON_UNESCAPED_UNICODE))--}}
<script>
    const resource_id = document.getElementById('resource_id').value = {};
    var myAppendGrid = new AppendGrid({
        element: "table",
        uiFramework: "bootstrap4",
        iconFramework: "fontawesome5",
        columns: [
            {
                name: "resource_id",
                display: "Product",
                type: "select",
                ctrlOptions: {!! json_encode($products,JSON_UNESCAPED_UNICODE)!!},
                afterRowRemoved: function(rowIndex) {
                    if (removeRow(rowIndex)){
                        console.log(document.getElementById('resource_id').value)
                        document.getElementById('resource_id').value = null
                        console.log(document.getElementById('resource_id').value)
                    }

                },
                events: {
                    // Add change event
                    change: function(e) {
                        if (e.target.value) {
                            e.target.style.backgroundColor = "#99FF99";
                            resource_id[e.uniqueIndex] = e.target.value;
                            console.log(resource_id)
                        } else {
                            e.target.style.backgroundColor = null;
                        }
                    }
                }
            },
        ],
        // Optional CSS classes, to make table slimmer!
        sectionClasses: {
            table: "table-sm",
            control: "form-control-sm",
            buttonGroup: "btn-group-sm"
        }
    });
    function functionMy()
    {
            var thestring = "";
            for (let i in resource_id) {
                thestring += resource_id[i] + ",";
            }
            thestring = thestring.substring(0, thestring.length -2);

            console.log(document.getElementById('resource_id').value = thestring);
            console.log(typeof thestring);
    }
</script>
<div class="px-6">
    <table id="yajra-datatable">
        <thead>
        <tr>
            <th>ID</th>
            <th>{{ __('Статус заявки') }}</th>
            <th>{{ __('Роль') }}</th>
            <th>{{ __('Комментарий') }}</th>
            <th>{{ __('Пользователь') }}</th>
            <th>Дата подписи</th>
        </tr>
        </thead>
    </table>
</div>

<script>
    $(function () {
        var table = $('#yajra-datatable').DataTable({
            "language": {
                "emptyTable": "Нет информации в таблица"
            },
            processing: true,
            serverSide: true,
            ajax: "{{ route('site.applications.list.signedocs',$application->id) }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'status', name: 'status'},
                {data: 'role_id', name: 'role_id'},
                {data: 'comment', name: 'comment'},
                {data: 'user_id', name: 'user_id'},
                {data: 'updated_at', name: 'updated_at'},
            ]
        });
    })
</script>
<div class="w-full text-center pb-8 ">
    <button class="bg-blue-500 hover:bg-blue-700 mx-4 p-2 transition duration-300 rounded-md text-white"
            name="draft" value="1">
        {{ __('lang.save_close') }}
    </button>
    <button onclick="functionMy()" class="bg-blue-500 hover:bg-blue-700 mx-4 p-2 transition duration-300 rounded-md text-white"
            name="draft" value="0">
        {{ __('lang.save_send') }}
    </button>
</div>
<div class="w-full text-center pb-8 ">

</div>
<script src="https://releases.transloadit.com/uppy/v2.4.1/uppy.min.js"></script>
<script src="https://releases.transloadit.com/uppy/v2.4.1/uppy.legacy.min.js" nomodule></script>
<script src="https://releases.transloadit.com/uppy/locales/v2.0.5/ru_RU.min.js"></script>
<x-laravelUppy url="{{route('uploadImage', $application->id)}}" target="#file_basis"/>
<x-laravelUppy url="{{route('uploadImage', $application->id)}}" target="#file_tech_spec"/>
<x-laravelUppy url="{{route('uploadImage', $application->id)}}" target="#other_files"/>
