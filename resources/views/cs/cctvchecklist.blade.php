<!--@extends('layouts.app')
@section('title', 'CCTV SYSTEM')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
			<a class="nav-item nav-link" href="{!!route("cs.checklistmain",["id"=>$record->getKey()])!!}"><img class="img-logo" alt="Back" src="{{ asset('icon/back.png?v=1.0.0') }}" style="width: 25px; height: 25px;"></a>
            <a style="float:right; margin-top:-30px;" href="{!!route("cs.signature",["id"=>$record->getKey()])!!}"><img class="img-logo" alt="Refresh" src="{{ asset('icon/next.png?v=1.0.0') }}" style="width: 25px; height: 25px;"></a>
			<div class="card">
                <div class="card-header bg-cyan large">{{ __('CHECKLISTS / CCTV CAMERA DETAIL') }}</div>

				<div class="card-body border border-secondary">
					<div>Case Id : {!! $record->Case_ReferenceId !!}</div>
					<div>Srvc Order :  {!! optional($record->ServiceOrder)->svor_RefNo !!}</div>
					<div>Srvc Date : {!! optional($record->ServiceOrder)->svor_ServiceOrderDate->format("d/m/Y") !!} </div>
					<div>Customer : {!! $record->Company->Comp_Name !!} </div>

				</div>
				<div class="card-header bg-cyan large">{{ __('DVR') }}</div>
				<div class="card-body border border-secondary">
					<div>No.: <input type="text" id="" value="" class="form-control input-md"></div>
					<div>Monitor :  <select class="form-control form-control-sm" name="" id="">

					<option value="Pass" selected>Pass</option>
					<option value="Fail" >Fail</option>

					</select></div>

					<div>Function : <select class="form-control form-control-sm" name="" id="">

					<option value="Pass" selected>Pass</option>
					<option value="Fail" >Fail</option>

					</select>

					<div>Sys Time : <select class="form-control form-control-sm" name="" id="">

					<option value="Pass" selected>Pass</option>
					<option value="Fail" >Fail</option>

					</select>

					<div>Playback : <select class="form-control form-control-sm" name="" id="">

					<option value="Pass" selected>Pass</option>
					<option value="Fail" >Fail</option>

					</select>

					<div>Oldest Rec Date :   <input type="date" id="" name=""> </div>
					<div>Remarks :  <textarea id="svor_FaultReported" class="form-control input-md" rows="4"></textarea> </div>

				</div>


            </div>

        </div>
    </div>
</div>
@endsection
@section("script")
<script>



</script>

@endsection-->
