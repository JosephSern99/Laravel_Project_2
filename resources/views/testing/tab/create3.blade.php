<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-cyan large">{{ __('Create New Manufacturing Order Step 3') }}</div>

                <div class="card-body border-bottom">
                    <div class="row">
                        <div class="col-10">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_Name">{!! __('columns.maoh_Name') !!}:</label>
                                    <div>(Auto Generated)</div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_startdate">{!! __('columns.maoh_startdate') !!}:</label>
                                    <div></div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_enddate">{!! __('columns.maoh_enddate') !!}:</label>
                                    <div></div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-md-4 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_Status">{!! __('columns.maoh_Status') !!}</label>
                                    <select class="form-control form-control-sm" name="maoh_Status" id="maoh_Status">
                                    </select>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_Yield">{!! __('Yield Loss (Gain)') !!}:</label>
                                    <div></div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-md-4 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_morequiredtemperature">{!! __('columns.maoh_morequiredtemperature') !!}:</label>
                                    <div></div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_morequiredtimeduration">{!! __('columns.maoh_morequiredtimeduration') !!}:</label>
                                    <div></div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_shelflife">{!! __('columns.maoh_shelflife') !!}:</label>
                                    <div></div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-md-4 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_rawwaste">{!! __('columns.maoh_rawwaste') !!}:</label>
                                    <div></div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_productionwaste">{!! __('columns.maoh_productionwaste') !!}:</label>
                                    <div></div>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-md-8 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_Remarks">{!! __('columns.maoh_Remarks') !!}:</label>
                                    <div><textarea class="form-control" id="remarks" name="remarks"></textarea></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 text-right">
                            <form action="{!! route("mo.store") !!}" method="POST" id="frmSubmit" class="inprogress mb-3" enctype="application/x-www-form-urlencoded">
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i></button>
                            </form>
                            <button type="button" class="btn btn-warning" id="btnStep3to2"><i class="fas fa-arrow-left"></i></button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row justify-content-end mb-2">
                        <div class="col-12">
                            <h6 class="font-weight-bold large">Raw Material</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="tableRaw2" class="table table-bordered">
                                    <thead class="bg-primary text-white">
                                    <tr>
                                        <th scope="col">@lang("Product Code")</th>
                                        <th scope="col">@lang("Description")</th>
                                        <th scope="col">@lang("Qty On Hand")</th>
                                        <th scope="col">@lang("Qty Used")</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row justify-content-end mb-2">
                        <div class="col-12">
                            <h6 class="font-weight-bold large">Finished Product</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="tableFG2" class="table table-bordered">
                                    <thead class="bg-primary text-white">
                                    <tr>
                                        <th scope="col">@lang("Product Code")</th>
                                        <th scope="col">@lang("Description")</th>
                                        <th scope="col">@lang("Qty On Hand")</th>
                                        <th scope="col">@lang("Qty Produced")</th>
                                    </tr>
                                    </thead>
                                    <tbody>
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
