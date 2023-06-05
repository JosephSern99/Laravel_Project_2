<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-cyan large">{{ __('Create New Manufacturing Order Step 2') }}</div>

                <div class="card-body border-bottom">
                    <div class="row">
                        <div class="col-10">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_Name">{!! __('columns.maoh_Name') !!}:</label>
                                    <div>(Auto Generated)</div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_enddate">{!! __('columns.maoh_enddate') !!}:</label>
                                    <div><input class="form-control form-control-sm input-datepicker" id="maoh_enddate" name="maoh_enddate" value="{!! $data["formatenddate"] ?? (now()->format(config("custom.DATE_FORMAT"))) !!}" /></div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_productionwaste">{!! __('columns.maoh_productionwaste') !!}:</label>
                                    <div><input class="form-control form-control-sm " id="maoh_productionwaste" name="maoh_productionwaste" value="{!! $data["productionwaste"] ?? null !!}" /></div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-md-4 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_morequiredtemperature">{!! __('columns.maoh_morequiredtemperature') !!}:</label>
                                    <div><input class="form-control form-control-sm text-right" id="maoh_morequiredtemperature" name="maoh_morequiredtemperature" value="{!! $data["maoh_morequiredtemperature"] ?? null !!}" /></div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_morequiredtimeduration">{!! __('columns.maoh_morequiredtimeduration') !!}:</label>
                                    <div><input class="form-control form-control-sm text-right" id="maoh_morequiredtimeduration" name="maoh_morequiredtimeduration" value="{!! $data["maoh_morequiredtimeduration"] ?? null !!}" /></div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_shelflife">{!! __('columns.maoh_shelflife') !!}:</label>
                                    <div><input class="form-control form-control-sm text-right" id="maoh_shelflife" name="maoh_shelflife" value="{!! $data["maoh_shelflife"] ?? null !!}" /></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 text-right">
                            <div class="mb-2">
                                <button type="button" class="btn btn-primary" id="btnStep2to3"><i class="fas fa-arrow-right"></i></button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-warning" id="btnStep2to1"><i class="fas fa-arrow-left"></i></button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row justify-content-end mb-2">
                        <div class="col-10">
                            <h6 class="font-weight-bold large">Finished Product</h6>
                        </div>

                        <div class="col-2 text-right">
                            <button id="btnAddItem2" class="btn btn-success btn-modal-add btn-step2" type="button"><i class="fas fa-fw fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="tableFG" class="table table-bordered">
                                    <thead class="bg-primary text-white">
                                    <tr>
                                        <th scope="col">@lang("Product Code")</th>
                                        <th scope="col">@lang("Description")</th>
                                        <th scope="col">@lang("Qty On Hand")</th>
                                        <th scope="col">@lang("Qty Produced")</th>
                                        <th scope="col" style="width: 1%"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="product-tbody">
                                        @if(!empty($data) && !empty($data["finish-productcode"]))
                                        @for($i = 0; $i < count($data["finish-productcode"]); $i++)
                                        <tr>
                                            <td scope="row">
                                                <a href="#" class="btn-modal btn-step2 edit" data-id="0"><span class="span-product-code">{{ $data["finish-productcode"][$i] }}</span></a>
                                                <input type="hidden" class="detailid" value="{!! 0 !!}" />
                                                <input type="hidden" class="product-code" value="{!!  $data["finish-productcode"][$i] !!}" />
                                                <input type="hidden" class="product-id" value="{!! $data["finish-productid"][$i] !!}" />
                                            </td>
                                            <td scope="row">
                                                <span class="span-product-description">{!! $data["finish-description"][$i] !!}</span>
                                                <input type="hidden" class="product-description" value="{!! $data["finish-description"][$i] !!}" />
                                            </td>
                                            <td scope="row" class="text-right">
                                                <span class="span-product-qtyonhand">{!! $data["finish-qtyonhand"][$i] !!}</span>
                                                <input type="hidden" class="product-qtyonhand" value="{!! $data["finish-qtyonhand"][$i] !!}" />
                                            </td>
                                            <td scope="row" class="text-right">
                                                <input type="text" class="form-control form-control-sm product-qtyused text-right" value="{!! $data["finish-qtyused"][$i] !!}" />
                                            </td>
                                            <td scope="row" class="text-right"><button type="menu" class="btn btn-danger btnDelete"><i class="fas fa-trash"></i></button></td>
                                        </tr>
                                        @endfor
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
