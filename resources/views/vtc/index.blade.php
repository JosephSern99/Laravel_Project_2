@extends('layouts.app')
@section('title', 'View Case Today')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/vtc.css?v=1.0.0') }}">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6" style="top: 20px;">
            <div class="card">
                <div class="card-header bg-cyan large">{{ __('Pending Cases for Today') }}</div>
				@foreach($records as $record)

				<div class="card-body border border-secondary">
					<div>Case ID : <a href="{!!route("vtc.aor",["id"=>$record->getKey()])!!}"> {!! $record->Case_ReferenceId !!} </a></div>
					<div>Date :  {!! optional($record->Case_Opened)->format("d/m/Y") !!}</div>
					<div>Customer : {!! $record->Company->Comp_Name !!} </div>

				</div>


				@endforeach
			 </div>
				<a href="{{ route("cs.index") }}"><img class="img-logo" alt="back" src="{{ asset('icon/cross.png?v=1.0.0') }}" style="width: 25px; height: 25px;"></a>




        </div>
    </div>
</div>
@endsection
