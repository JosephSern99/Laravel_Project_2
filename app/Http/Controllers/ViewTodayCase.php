<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Cases;
use App\Models\ServiceOrder;
use App\Models\User;


use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Log;


class ViewTodayCase extends Controller
{
    public function index(Request $response)
    {
		$records = Cases::whereDate("Case_Opened",now()->format("Y-m-d"))
		->orderBy("Case_Opened", "asc")->WhereNull('case_type')->get();

		//dd($records,now());

        return view("vtc.index", compact("records"));

    }

	public function aor($id)
    {
        //
		$record = Cases::find($id);

		return view("vtc.aor", compact("record"));
    }


	/*public function reject($id)
    {
        //
		$record = Cases::find($id);
		$record->case_type = 'Rejected';
		$record->save();

		return "";

    }*/

	public function accept($id)
    {

		//$data = request()->input();
        $newserviceorderid;

		//Auto Create Service Order Record
		$serviceorderid = ServiceOrder::select('Svor_ServiceOrderID')->orderby('Svor_ServiceOrderID','DESC')->first();

		if($serviceorderid != []){

			$newserviceorderid = $serviceorderid['Svor_ServiceOrderID'] + 1;

		}else{

			$newserviceorderid = 1;

		}

		//Case Type Assign to Accepted
        $now = now();
		$record = Cases::find($id);
		// $record->case_typecopy = $record->case_type;
		//$record->case_type = 'Accepted';
		//case
		$record->Case_AssignedUserId = auth()->user()->getKey();

        $team = User::find(auth()->user()->getKey());
        $record->Case_ChannelId = $team['User_PrimaryChannelId'];
		$record->case_serviceorderid = $newserviceorderid;
		$record->save();



		$serviceorder = new ServiceOrder;

		$serviceorder->Svor_ServiceOrderID = $newserviceorderid;

		$serviceorder->Svor_Status = "In Progress";
		$serviceorder->svor_CaseId = $record->Case_CaseId;
		$serviceorder->svor_ServiceOrderDate = $now;

		if(!empty($record->case_SystemType)){
			$serviceorder->svor_SystemType = $record->case_SystemType;
		}else{
			$serviceorder->svor_SystemType = null;
		}

		if(!empty($record->Case_PrimaryCompanyId)){
			$serviceorder->svor_CompanyId = $record->Case_PrimaryCompanyId;
		}else{
			$serviceorder->svor_CompanyId  = null;
		}

        if(!empty($record->Case_PrimaryPersonId)){
			$serviceorder->svor_PersonId = $record->Case_PrimaryPersonId;
		}else{
			$serviceorder->svor_PersonId  = null;
		}

		if(!empty($record->Case_ProblemNote)){
			$serviceorder->svor_FaultReported = $record->case_description;
		}else{
			$serviceorder->svor_FaultReported = null;
		}

		if(!empty($record->Case_AssignedUserId)){
			$serviceorder->svor_UserId = $record->Case_AssignedUserId;
		}else{
			$serviceorder->svor_UserId = null;
		}

		$serviceorder->svor_ServiceType = "Contract";
		$serviceorder->svor_btnEdit = "Edit";
		$serviceorder->svor_btnDelete = "Delete";


		$serviceorder->save();

		return redirect(route('cs.accept',$id));
    }

}
