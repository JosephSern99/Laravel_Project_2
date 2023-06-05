<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-cyan large">{{ __('Create New Manufacturing Order Step 1') }}</div>

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
                                    <div>
                                        <input class="form-control form-control-sm input-datepicker" id="maoh_startdate" name="maoh_startdate" value="{!! empty($previous) ? now()->format(config("custom.DATE_FORMAT")) : $previous["formatstartdate"] !!}" />
                                    </div>
                                </div>
                                <div class="col-md-4 mb-2">
                                    <label class="mb-0 font-weight-bold" for="maoh_rawwaste">{!! __('columns.maoh_rawwaste') !!}:</label>
                                    <div><input class="form-control form-control-sm " id="maoh_rawwaste" name="maoh_rawwaste" value="{!! empty($previous) ? "" : $previous["rawwaste"] !!}" /></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 text-right">
                            <button type="button" class="btn btn-primary" id="btnStep1to2"><i class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row justify-content-end mb-2">
                        <div class="col-10">
                            <h6 class="font-weight-bold large">Raw Material</h6>
                        </div>

                        <div class="col-2 text-right">
                            <button id="btnAddItem" class="btn btn-success btn-modal-add btn-step1" type="button"><i class="fas fa-fw fa-plus"></i></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="tableRaw" class="table table-bordered">
                                    <thead class="bg-primary text-white">
                                    <tr>
                                        <th scope="col">@lang("Product Code")</th>
                                        <th scope="col">@lang("Description")</th>
                                        <th scope="col">@lang("Qty On Hand")</th>
                                        <th scope="col">@lang("Qty Used")</th>
                                        <th scope="col" style="width: 1%"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="product-tbody">
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
