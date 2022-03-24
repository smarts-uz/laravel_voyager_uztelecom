@extends('site.layouts.wrapper')

@section('center_content')


    <div class="mt-6">
    <div class="w-full flex">
        <div class="p-6">
            <div class="flex items-baseline">
                <div class="mr-4 pt-2 pb-2 w-50">
                    {{Aire::input('bio','Ташаббускор (буюртмачи номи )')
                        ->name('initiator')
                        ->value($application->initiator)
                        ->disabled()
                    }}
                    {{Aire::textArea('bio','Харид мазмуни (сотиб олиш учун асос)')
                        ->name('purchase_basis')
                        ->value($application->purchase_basis)
                        ->rows(3)
                        ->cols(40)
                        ->disabled()
                    }}
                    {{Aire::textArea('bio','Сотиб олинадиган махсулот тавсифи (техник характери)')
                        ->name('specification')
                        ->value($application->specification)
                        ->rows(3)
                        ->cols(40)
                        ->disabled()
                    }}
                    {{Aire::input('bio','Махсулот келишининг муддати')
                        ->name('delivery_date')
                        ->value($application->delivery_date)
                        ->disabled()
                    }}
                </div>
                <div class="pt-2 pb-2 w-50">
                    {{Aire::input('bio','Сотиб олинадиган махсулот номи (махсулот, иш, хизмат)')
                        ->name('name')
                        ->value($application->name)
                        ->disabled()
                    }}
                    {{Aire::textArea('bio','Асос (харидлар режаси, раҳбарият томонидан билдирги)')
                        ->name('basis')
                        ->value($application->basis)
                        ->rows(3)
                        ->cols(40)
                        ->disabled()
                    }}
                    {{Aire::textArea('bio','Алоҳида талаблар')
                        ->name('separate_requirements')
                        ->value($application->separate_requirements)
                        ->rows(3)
                        ->cols(40)
                        ->disabled()
                    }}
                    {{Aire::input('bio','Махсулот сифати учун кафолат муддати (иш, хизмат)')
                        ->name('expire_warranty_date')
                        ->value($application->expire_warranty_date)
                        ->disabled()
                    }}
                </div>
            </div>
            <div class="flex items-baseline">
                <div class="mr-4 pt-2 pb-2 w-50">
                    {{Aire::input('bio','Харид режаси (сумма)')
                        ->name('planned_price')
                        ->value($application->planned_price)
                        ->id('summa')
                        ->disabled()
                    }}
                    {{Aire::input()
                        ->name('more_than_limit')
                        ->value($application->more_than_limit)
                        ->value('false')
                        ->class('hidden')
                        ->disabled()
                    }}
                    {{Aire::select(['USD' => 'USD', 'UZS' => 'UZS'], 'select', 'Валюта')
                    ->name('currency')
                    ->value($application->currency)
                    ->id('valyuta')
                    ->disabled()
                    }}
                </div>
                <div class="pt-2 pb-2 w-50">
                    {{Aire::input('bio','Бюджетни режалаштириш бўлими - харид қилинадиган махсулотни бизнес режада мавжудлиги бўйича маълумот')
                        ->name('info_business_plan')
                        ->value($application->info_business_plan)
                        ->disabled()
                    }}
                </div>

            </div>
            <div class="flex items-baseline">
                <div class="mr-4 pt-2 pb-2 w-50">
                    {{Aire::input('bio','Эквивалентная Планируемая сумма')
                        ->name('equal_planned_price')
                        ->value($application->equal_planned_price)
                        ->disabled()
                    }}
                </div>
                <div class="pt-2 pb-2 w-50">
                    {{Aire::input('bio','Наименование поставщика')
                        ->name('supplier_name')
                        ->value($application->supplier_name)
                        ->disabled()
                    }}
                </div>
            </div>
            <div class="flex items-baseline">
                <div class="mr-4 pt-2 pb-2 w-50">
                    {{Aire::select([1 => 'товар', 2 => 'работа', 3 => 'услуга'], 'select', 'Предмет закупки')
                        ->name('subject')
                        ->value($application->subject)
                        ->disabled()
                    }}
                </div>
                <div class="pt-2 pb-2 w-50">
                    {{Aire::select([1 => 'тендер', 2 => 'отбор', 3 => 'Eshop'], 'select', 'Вид закупки')
                        ->name('type_of_purchase_id')
                        ->value($application->type_of_purchase_id)
                        ->disabled()
                    }}
                </div>
            </div>
            <div class="flex items-baseline">
                <div class="mr-4 pt-2 pb-2 w-50">
                    {{Aire::textArea('bio','Харид килинадиган махсулотни "Харидлар режаси"да мавжудлиги буйича маълумот')
                        ->name('info_purchase_plan')
                        ->value($application->info_purchase_plan)
                        ->rows(3)
                        ->cols(40)
                        ->disabled()
                    }}
                </div>
                <div class="pt-2 pb-2 w-50">
                    {{Aire::textArea('bio','Коментарий к заявке')
                        ->name('comment')
                        ->value($application->comment)
                        ->rows(3)
                        ->cols(40)
                        ->disabled()
                    }}
                </div>
            </div>
            <div class="flex items-baseline">
                <div class="mr-4 pt-2 pb-2 w-50">
                    <h6><b>Филиални танланг</b></h6>
                    <select class="custom-select" name="filial_initiator_id" id="filial_initiator_id">
                            <option value="{{$application->filial_initiator_id}}" selected disabled>{{$branch->name}}</option>
                    </select>
                </div>
                <div class="pt-2 pb-2 w-50">
                    <h6><b>Товар (хизмат) ишлаб чиқарилган мамлакат</b></h6>
                    <select class="col-md-6 custom-select" name="country_produced_id" id="country_produced_id">
                            <option value="{{$application->country_produced_id}}" selected disabled>{{$countries->name}}</option>
                    </select>
                </div>
            </div>
            @if($application->with_nds == 1)
            {{Aire::checkbox('checkbox', 'QQS bilan')->name('with_nds')->checked()->disabled()}}
            @else
            {{Aire::checkbox('checkbox', 'QQS bilan emas')->disabled()}}
            @endif
            </div>
        </div>
                <form name="testform" action="{{route('site.applications.imzo.sign')}}" method="POST">
                    @csrf
                    <label id="message"></label>
                    <div class="form-group">
                        <label for="select1">Выберите ключ</label>
                        <select name="key" id="select1" onchange="cbChanged(this)"></select><br />
                    </div>
                    <div class="form-group hidden">
                        <label for="exampleFormControlTextarea1">Текст для подписи</label>
                        <textarea class="form-control" id="eri_data" name="data" rows="3"></textarea>
                    </div>
                    {{Aire::textArea('bio','Коментария')
                        ->name('comment')
                        ->rows(3)
                        ->cols(40)
                    }}
                    ID ключа <label id="keyId"></label><br />

                    <button onclick="generatekey()" class="hidden btn btn-success" type="button">Подписаться</button><br />

                    <div class="form-group hidden">
                        <label for="exampleFormControlTextarea3">Подписанный документ PKCS#7</label>
                        <textarea class="form-control" readonly required name="pkcs7" id="exampleFormControlTextarea3"
                                  rows="3"></textarea>
                    </div><br /> 
                    <div class="row ml-4">
                        <button value="1" name="status" type="submit" class="btn btn-success col-md-2" >Accept</button>
                        <button value="0" name="status" type="submit" class="btn btn-danger col-md-2" >Reject</button>
                    </div>
                </form>
    </div>
    <script>
        function generatekey()
        {
            var data = "application_{{$application->id}}"
            document.getElementById('eri_data').value = data;
            console.log(data);
            sign();
        }
            
        function functionBack()
        {
            window.history.back();
        }
    </script>

@endsection
    <script src="{{asset("assets/js/eimzo/e-imzo.js")}}"></script>
    <script src="{{asset("assets/js/eimzo/e-imzo-client.js")}}"></script>
    <script src="{{asset("assets/js/eimzo/eimzo.js")}}"></script>
