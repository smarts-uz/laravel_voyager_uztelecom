<div class="pt-6">
    <div class="w-full flex">
        <div class="p-6">
            <div class="flex items-baseline">
                <div class="mr-4 pt-2 pb-2 w-50">
                    {{Aire::select($branch, 'select', __('lang.performer_branch'))
                        ->name('branch_customer_id')
                        ->value($application->branch_customer_id)
                        }}
                    {{Aire::input('bio', __('lang.performer_lot'))
                        ->name('lot_number')
                        ->value($application->lot_number)
                    }}
                    {{Aire::input('bio', __('lang.performer_contract_num'))
                        ->name('contract_number')
                        ->value($application->contract_number)
                    }}.
                    {{Aire::dateTimeLocal('bio', __('lang.performer_contract_date'))
                        ->name('contract_date')
                        ->value($application->contract_date)
                    }}
                    {{Aire::dateTimeLocal('bio', __('lang.performer_protocol_date'))
                        ->name('protocol_date')
                        ->value($application->protocol_date)
                    }}
                    {{Aire::input('bio', __('lang.performer_protocol_num'))
                        ->name('protocol_number')
                        ->value($application->protocol_number)
                    }}
                    {{Aire::textArea('bio', __('lang.performer_contract_info'))
                        ->name('contract_info')
                        ->value($application->contract_info)
                        ->rows(3)
                        ->cols(40)
                    }}
                    {{Aire::checkbox('checkbox', __('lang.performer_nds'))
                       ->name('with_nds')
                    }}
                    {{Aire::input('bio', __('lang.performer_price'))
                        ->name('contract_price')
                        ->value($application->contract_price)
                    }}
                </div>
                <div class="pt-2 pb-2 w-50">
                    {{Aire::select($countries,'bio', __('lang.performer_country'))
                        ->name('country_produced_id')
                        ->value($application->country_produced_id)
                    }}


                    {{Aire::input('bio', __('lang.performer_supplier'))
                        ->name('supplier_name')
                        ->value($application->supplier_name)
                    }}
                    {{Aire::input('bio', __('lang.performer_inn'))
                        ->name('supplier_inn')
                        ->value($application->supplier_inn)
                    }}
                    {{Aire::textArea('bio', __('lang.performer_info'))
                        ->name('product_info')
                        ->value($application->product_info)
                        ->rows(3)
                        ->cols(40)
                    }}

                    <div class="mr-4 pt-2 pb-2 w-50">
                        {{Aire::select($subject, 'select', __('lang.table_18'))
                            ->name('subject')
                            ->value($application->subject)
                        }}
                        @if($performer_file != 'null' && $performer_file != null)
                            <div class="mb-5" style="width: 80%">
                                <h5 class="text-left">Performer File</h5>
                                @foreach($performer_file as $file)
                                    @if(\Illuminate\Support\Str::contains($file,'jpg')||\Illuminate\Support\Str::contains($file,'png')||\Illuminate\Support\Str::contains($file,'svg'))
                                        <img src="/storage/uploads/{{$file}}" width="500" height="500" alt="not found">
                                    @else
                                        <button type="button" class="btn btn-primary"><a style="color: white;" href="/storage/uploads/{{$file}}">{{preg_replace('/[0-9]+_/', '', $file)}}</a></button>
                                        <p class="my-2">{{preg_replace('/[0-9]+_/', '', $file)}}</p>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="pt-2 pb-2 w-50">
                        {{Aire::select($purchase, 'select', __('lang.table_19'))
                            ->name('type_of_purchase_id')
                            ->value($application->type_of_purchase_id)
                        }}
                    </div>
                    {{Aire::select($status_extented, 'select')
                        ->name('performer_status')
                        ->value($application->status)
                        }}
                    <div id="file"></div>
                    <div id="a" class="hidden mb-3">
                        <label for="message-text" class="col-form-label">{{ __('lang.table_23') }}:</label>
                        <input class="form-control" name="report_if_cancelled" id="report_if_cancelled">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row ml-4 pb-4">
        <button type="submit" class="btn btn-success">{{ __('lang.save') }}</button>
    </div>
    <script src="https://releases.transloadit.com/uppy/v2.4.1/uppy.min.js"></script>
    <script src="https://releases.transloadit.com/uppy/v2.4.1/uppy.legacy.min.js" nomodule></script>
    <script src="https://releases.transloadit.com/uppy/locales/v2.0.5/ru_RU.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        var uppy = new Uppy.Core({
            debug: true,
            autoProceed: true,
            restrictions: {
                minFileSize: null,
                maxFileSize: 10000000,
                maxTotalFileSize: null,
                maxNumberOfFiles: 10,
                minNumberOfFiles: 0,
                allowedFileTypes: null,
                requiredMetaFields: [],
            },
            meta: {},
            onBeforeFileAdded: (currentFile, files) => currentFile,
            onBeforeUpload: (files) => {
            },
            locale: {
                strings: {
                    browseFiles: 'прикрепить файл',
                    dropPasteFiles: '%{browseFiles}',
                }
            },
            store: new Uppy.DefaultStore(),
            logger: Uppy.justErrorsLogger,
            infoTimeout: 5000,
        })
            .use(Uppy.Dashboard, {
                trigger: '.UppyModalOpenerBtn',
                inline: true,
                target: '#file',
                showProgressDetails: true,
                note: 'Все типы файлов, до 10 МБ',
                width: 300,
                height: 200,
                metaFields: [
                    {id: 'name', name: 'Name', placeholder: 'file name'},
                    {id: 'caption', name: 'Caption', placeholder: 'describe what the image is about'}
                ],
                browserBackButtonClose: true
            })
            .use(Uppy.XHRUpload, {
                endpoint: '{{route('uploadImage', $application->id)}}',
                formData: true,
                fieldName: 'performer_file',
                headers: file => ({
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                }),
            });
        uppy.on('upload-success', (file, response) => {
            const httpStatus = response.status // HTTP status code
            const httpBody = response.body   // extracted response data
            // do something with file and response
        });
        uppy.on('file-added', (file) => {
            uppy.setFileMeta(file.id, {
                size: file.size,
            })
            console.log(file.name);
        });
        uppy.on('complete', result => {
            console.log('successful files:', result.successful)
            console.log('failed files:', result.failed)
        });
    </script>
</div>


