<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cases;
use App\Models\ServiceOrder;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Library;
use App\Models\NewProduct;
use App\Models\ServiceOrderItem;
use App\Models\User;
use Validator;

use Illuminate\Support\Facades\Storage;


use Illuminate\Http\File;

use Illuminate\Support\Facades\Log;

use DB;

class CaseSummaryController extends Controller
{
    public function index(Request $response)
    {

		$data = $response->input();
		$records = Cases::query();
        $channelid = User::select('User_PrimaryChannelId')->where("User_UserId",auth()->user()->getKey())->first();


        $records = Cases::whereNull("Case_AssignedUserId")->whereIn("case_type",["Preplanned", "Adhoc"])->where("Case_Status", "In Progress")
        ->orderBy("Case_Opened", "asc");


        $channel = $channelid["User_PrimaryChannelId"];

        // if($channelid["User_PrimaryChannelId"] == null){

		// 	$records=$records;
		// }else if ($channelid["User_PrimaryChannelId"]!=null &&  $records->where("Case_ChannelId", $channelid["User_PrimaryChannelId"])){

		// 	$records = $records->where("Case_ChannelId", $channelid["User_PrimaryChannelId"]);
		// }else{
        //     $records = [];
        // }
        if(!empty(auth()->user()->User_PrimaryChannelId)){
            $records->where( function($w){
                $w->where("Case_ChannelId", auth()->user()->User_PrimaryChannelId)
                ->orWhereNull("Case_ChannelId");
            } ) ;
        }
        $records = $records->get();
        // dd($records);

        return view("cs.index", compact("records", "channel"));

    }

	public function prevent(Request $response)
    {
		$data = $response->input();
		$records = Cases::query();


        $records = Cases::where("case_type","Preventive")->where("Case_Status", "In Progress")
        ->orderBy("Case_Opened", "asc");

        $channelid = User::select('User_PrimaryChannelId')->where("User_UserId",auth()->user()->getKey())->first();

        $channel = $channelid["User_PrimaryChannelId"];

        // if($channelid["User_PrimaryChannelId"] == null){

		// 	$records=$records;
		// }else if ($channelid["User_PrimaryChannelId"]!=null &&  $records->where("Case_ChannelId", $channelid["User_PrimaryChannelId"])){

		// 	$records = $records->where("Case_ChannelId", $channelid["User_PrimaryChannelId"]);
		// }else{
        //     $records = [];
        // }
        if(!empty(auth()->user()->User_PrimaryChannelId)){
            $records->where( function($w){
                $w->where("Case_ChannelId", auth()->user()->User_PrimaryChannelId)
                ->orWhereNull("Case_ChannelId");
            } ) ;
        }
        $records = $records->get();

        return view("cs.prevent", compact("records","channel"));

    }

	public function accept(Request $response)
    {
		$data = $response->input();
		$records = Cases::query();


        $records = Cases::whereNotNull("Case_AssignedUserId")->where("Case_Status", "In Progress")->whereIn("case_type",["Preplanned", "Adhoc"])
        // ->whereIn("Case_CaseId",ServiceOrder::select(["svor_CaseId"])->whereNotNull("svor_CaseId"))
        ->orderBy("Case_Opened", "asc");


        $channelid = User::select('User_PrimaryChannelId')->where("User_UserId",auth()->user()->getKey())->first();

        $channel = $channelid["User_PrimaryChannelId"];

        if(!empty(auth()->user()->User_PrimaryChannelId)){
            $records->where( function($w){
                $w->where("Case_ChannelId", auth()->user()->User_PrimaryChannelId)
                ->orWhereNull("Case_ChannelId");
            } ) ;
        }
        $records = $records->get();

		return view("cs.accept", compact("records","channel"));


    }


// select * from [Cases]
// left join (select svor_CaseId, max(svor_datefrom) as svor_datefrom from ServiceOrder where Svor_Deleted is null and svor_datefrom is
// not null and svor_dateto is null group by svor_CaseId)
// AS SO
// on [svor_CaseId] = [Case_CaseId]
// where [Case_Status] = 'In Progress' and [case_type] = 'Adhoc' and [Case_AssignedUserId] = 121 and [Case_Deleted] is null
// order by [svor_datefrom] desc, [Case_Opened] desc;



	public function onhand(Request $response)
    {
		$data = $response->input();
		$records = Cases::query();

        $subrecords =  ServiceOrder::whereNotNull("svor_datefrom")->whereNull("svor_dateto")->whereNotNull("svor_CaseId")->groupBy("svor_CaseId")->select(
            ["svor_CaseId",DB::raw("max(svor_datefrom) as svor_datefrom")]
        );
        $records = Cases::where("Case_Status", "In Progress")->where("case_type","Adhoc")->where("Case_AssignedUserId", auth()->user()->getKey())
        ->leftJoinSub($subrecords, "SO",'svor_CaseId', '=', 'Case_CaseId')
        ->orderBy("svor_datefrom", "DESC")
        // ->whereIn("Case_CaseId",ServiceOrder::select(["svor_CaseId"])->whereNotNull("svor_CaseId"))
        ->orderBy("Case_Opened", "desc")->get();

        // dd($records);

        return view("cs.onhand", compact("records"));

    }

    public function project(Request $response)
    {
		$data = $response->input();
		$records = Cases::query();


        $records = Cases::where("Case_Status", "In Progress")->where(function($w){
            $w->where("Case_ChannelId", 13)
            ->orWhereNull("Case_ChannelId");
        })
        ->orderBy("Case_Opened", "asc")->whereIn('case_type',['Preplanned', 'Adhoc'])->get();

        $channelid = User::select('User_PrimaryChannelId')->where("User_UserId",auth()->user()->getKey())->first();

        $channel = $channelid["User_PrimaryChannelId"];



        return view("cs.project", compact("records","channel"));

    }


    public function cabling(Request $response)
    {
		$data = $response->input();
		$records = Cases::query();


        $records = Cases::where("Case_Status", "In Progress")->where(function($w){
            $w->where("Case_ChannelId", 16)
            ->orWhereNull("Case_ChannelId");
        })
        ->orderBy("Case_Opened", "asc")->whereIn('case_type',['Preplanned', 'Adhoc'])->get();

        $channelid = User::select('User_PrimaryChannelId')->where("User_UserId",auth()->user()->getKey())->first();

        $channel = $channelid["User_PrimaryChannelId"];

        return view("cs.cabling", compact("records","channel"));

    }


    public function service(Request $response)
    {
		$data = $response->input();
		$records = Cases::query();


        $records = Cases::where("Case_Status", "In Progress")->where(function($w){
            $w->where("Case_ChannelId", 15)
            ->orWhereNull("Case_ChannelId");
        })
        ->orderBy("Case_Opened", "asc")->get();

        $channelid = User::select('User_PrimaryChannelId')->where("User_UserId",auth()->user()->getKey())->first();

        $channel = $channelid["User_PrimaryChannelId"];


        return view("cs.service", compact("records", "channel"));

    }

	public function checklistmain($id)
    {
		$record = Cases::find($id);
        $type = request()->input("type");
        $sorecord =  ServiceOrder::where("svor_CaseId",$id)->orderBy("Svor_ServiceOrderID","DESC")->first();



        if(empty($sorecord)){
            if($type == "onhand"){
                return redirect()->route("vtc.aor",["id"=>$id])->with("msg.fail","Case has no Service Order, proceed to accept case.");
            }
        }
        else if(empty($sorecord->svor_datefrom)){
            return redirect()->route("cs.servicecheckin",["id"=>$id]);
        }

		return view("cs.checklistmain", compact("record"));
    }

	public function servicedetails($id)
    {
		$record = Cases::find($id);

		return view("cs.servicedetails", compact("record"));
    }

	public function servicecheckin($id)
    {
		$now = now();
		$record = Cases::find($id);
        if(ServiceOrder::where("svor_CaseId",$id)->whereNotNull("svor_datefrom")->whereNull("svor_dateto")->count()>0)
        {
            return redirect(route('cs.checklistmain',$id));
        }
        else if(ServiceOrder::where("svor_CaseId",$id)->whereNull("svor_datefrom")->whereNull("svor_dateto")->count()>0)
        {
            return view("cs.servicecheckin", compact("record"));
        }
        else{
		    return view("cs.servicecheckin", compact("record"));
        }
    }

	public function servicecheckinnow($id)
    {
		$now = now();
		$record = ServiceOrder::where("svor_CaseId",$id)->orderBy("Svor_ServiceOrderID","DESC")->first();
        $firstrecord = ServiceOrder::where("svor_CaseId",$id)->orderBy("Svor_ServiceOrderID")->first();
        $message = "Service Order Record Not Found.";

        if(!empty($record)){
            $record->svor_datefrom = $now;
            $record->Svor_Status = 'In Progress';
            if($record->getKey()!=$firstrecord->getKey()){
                $record->svor_ServiceOrderDate = $now;
            }
            $record->save();
        }else{
            return response()->json([
                "message" => $message
            ]);

        }
		return "";
    }

	public function serviceorderlist($customer)
    {
		$records = ServiceOrder::where("svor_CompanyId",$customer)->orderBy("Svor_ServiceOrderID","desc")->take(90)->get();
		$svorcaseid;
		if(!empty($records[0]->svor_CaseId)){
			$svorcaseid = $records[0]->svor_CaseId;
		}else{
			$svorcaseid = "";
		}

		$casecontract = Cases::where("Case_CaseId",$svorcaseid)->first();
		$casectra;
		if(!empty($casecontract[0]->case_contractid)){
			$casectra = $casecontract[0]->case_contractid;
		}else{
			$casectra = "";
		}

		$contract = Contract::where("Ctra_ContractID", $casectra)->first();

		if(empty($contract))
		{
			$contract = [];

		}

		return view("cs.serviceorderlist", compact("records", "contract"));
    }

	public function equipmentlist($customer)
    {
		$records = ServiceOrder::where("svor_CompanyId",$customer)->orderBy("Svor_ServiceOrderID","desc")->take(90)->get();

		return view("cs.equipmentlist", compact("records"));
    }


	public function images($id)
    {

        if($id == ""){
			return redirect()->back();
		}else{

		    $record = ServiceOrder::where("svor_CaseId",$id)->orderBy("Svor_ServiceOrderID","desc")->first();
            $filelists = [];
			$storage = Storage::disk('public');
            $libraries = Library::where("Libr_ServiceOrderId", $record->getKey())->get();

            foreach($libraries as $library){
				$libraryid = $library->getKey();
				$documentType = $library->Libr_Type;
				$filepath = $library->Libr_FilePath;
				$filename = $library->Libr_FileName;
				$size = $library->Libr_FileSize;

				$fullfilepath = $filepath . "/" . $filename;

				$mime = "";

				if($storage->exists($fullfilepath)){
					$mime = $storage->mimeType($fullfilepath);
				}

				$fileAttr = compact("libraryid", "filename", "size", "mime");

				if(empty($filelists[$documentType])){
					$filelists[$documentType] = [$fileAttr];
				}else{
					array_push($filelists[$documentType], $fileAttr);
				}
			}

            $datalist = ["record" => $record, "filelists" => $filelists, "libraries" => $libraries];
            return view("cs.images")->with($datalist);
        }

    }


    public function imagesdetails($id){
        if($id == ""){
			return redirect()->back();
		}else{

		    $record = ServiceOrder::where("svor_CaseId",$id)->orderBy("Svor_ServiceOrderID","desc")->first();
			$storage = Storage::disk('public');
            $storagepath = Storage::disk('public')->getDriver()->getAdapter()->getPathPrefix();
            $libraries = Library::where("Libr_ServiceOrderId", $record->getKey())->whereNull("Libr_Deleted")->get();


            $datalist = ["records" => $record, "libraries" => $libraries];
            return view("cs.imagesdetails")->with($datalist);
        }
    }



	public function save($id)
    {
        $data = request()->input();
		$record = ServiceOrder::where("svor_CaseId",$id)->orderBy("Svor_ServiceOrderID","desc")->first();
		$record->svor_FaultReported = $data["svor_FaultReported"];
		$record->svor_WorkCarriedOut = $data["svor_WorkCarriedOut"];
        $record->svor_Observation = $data["svor_Observation"];

		$record->save();

		return "";
    }

	public function items($id)
    {

		$record = Cases::find($id);
        $sorecord = ServiceOrder::where("svor_CaseId",$id)->orderBy("Svor_ServiceOrderID","desc")->first();

        $products = NewProduct::where("prod_webappusage", "=", "Y")->leftJoin("ServiceOrderItem",function($join) use($sorecord) {

            $join->on("svit_productid","Prod_ProductID")->where("svit_serviceorderid",$sorecord->getKey())->whereNull("svit_Deleted");
        }  )->get();

        // dd($products);




        return view("cs.items1", compact("record","products", "id"));

    }

    public function itemssummary($id)
    {
        $record = Cases::find($id);
        $sorecord = ServiceOrder::where("svor_CaseId",$id)->orderBy("Svor_ServiceOrderID","desc")->first();
        $products = ServiceOrderItem::where("svit_serviceorderid",$sorecord->getKey())->get();

        return view("cs.items2", compact("id","sorecord", "record","products"));
    }


    public function itemssave($id){


        $sumtotalprice=0;

        $record = ServiceOrder::where("svor_CaseId",$id)->orderBy("Svor_ServiceOrderID","desc")->first();

        $datas = request()->input();
        // try{
        for($i=0; $i<count($datas["quantity"]); $i++){
            $noquantity = round($datas["quantity"][$i],2) == 0;

                $newserviceorderiditem;

                if(!empty($datas["soitemid"][$i])){

                    $newserviceorderiditem = $datas["soitemid"][$i];
                    $serviceorderitem = ServiceOrderItem::find($newserviceorderiditem);  // if got quantity , use the serviceorder item id
                    if(!empty($serviceorderitem) && $noquantity){
                        $serviceorderitem->delete(); // if quantity is zero set that service order item is deleted.
                        // $serviceorderitem->save();
                    }


                }


                else if(!$noquantity){


                    $serviceorderiditem =  ServiceOrderItem::select('svit_ServiceOrderItemID')->orderby('svit_ServiceOrderItemID','DESC')->first();

                    if($serviceorderiditem != []){

                        $newserviceorderiditem = $serviceorderiditem['svit_ServiceOrderItemID'] + 1;

                    }else{

                        $newserviceorderiditem = 1;

                    }
                    $serviceorderitem = new ServiceOrderItem; // if quantity and service order item id is null and zero, add new Service Order Item id.
                    $serviceorderitem->svit_ServiceOrderItemID= $newserviceorderiditem;
                }

                $productfam =  NewProduct::select('*')->where("Prod_ProductID",$datas["product"][$i])->first();

                //svit_Status
                //svit_UserId
                //svit_noofhours

                //if condition below if got service order item id
                if(!empty($serviceorderitem) && !$noquantity){
                    $serviceorderitem->svit_quantity=$datas["quantity"][$i];

                    $serviceorderitem->svit_Name = $datas["productname"][$i];
                    $serviceorderitem->svit_productid =  $datas["product"][$i];
                    $serviceorderitem->svit_productfamilyid = $productfam['prod_productfamilyid'];
                    $serviceorderitem->svit_description = $productfam['prod_Remarks'];
                    $serviceorderitem->svit_pricetotal = $datas["quantity"][$i] * $datas["unitprice"][$i];
                    $serviceorderitem->svit_serviceorderid = $record->getKey();
                    $serviceorderitem->svit_unitprice = $datas["unitprice"][$i];
                    $serviceorderitem->save();

                    $sumtotalprice=$sumtotalprice + $serviceorderitem->svit_pricetotal;
                }

        }
        $record->svor_totalprice = $sumtotalprice;
        $record->save();

        return response()->json([]);
        // }catch(\Exception $ex){

        //     Log::error($ex); // Log the error (optional)
        // }
    }
	/*
	public function cctvchecklist($id)
    {
		$record = Cases::find($id);

		return view("cs.cctvchecklist", compact("record"));
    }*/


	public function signature($id)
    {

		$record = Cases::find($id);

        $totalamount = 0;

        $hascontractid = !empty($record->case_contractid);
        $type = "";
        if($hascontractid){
            $contract = Contract::find($record->case_contractid);
            if(!empty($contract)){
                $type = $contract->ctra_Type;

            }
            else{
                $hascontractid=false;
            }
        }
        $sorecord = ServiceOrder::where("svor_CaseId",$id)->orderBy("Svor_ServiceOrderID","desc")->first();

        $items = ServiceOrderItem::where("svit_serviceorderid",$sorecord->getKey());

        // dd($type);
        $totalitemamount = $items->sum("svit_pricetotal");
        // dd($items->sum("svit_pricetotal"),$items->get());
        $paidamount = 0 ;
        if($type=="NonComprehensive" || !$hascontractid){
            $datefrom = $sorecord->svor_datefrom;
            $now = now();

            $diffInMinutes = $datefrom->diffInMinutes($now);
            // if($diffInMinutes < 60){
            //     $diffInMinutes = 60;
            // }
            // dd($diffInMinutes);
            $firsthour = true;

            // variable to store diff in minute, check out date should be $now, do a for loop
            while($diffInMinutes > 0){

                $daydatefrom = $datefrom->dayOfWeek;
                $time = (int)$datefrom->format("Hi");
                if($diffInMinutes>30){
                    if($daydatefrom == 0 ){
                        if($hascontractid){
                            if($firsthour){
                                $paidamount += 275;
                            }
                            else{
                                $paidamount += 200;
                            }
                        }
                        else{
                            if($firsthour){
                                $paidamount += 350;
                            }
                            else{
                                $paidamount += 250;
                            }
                        }
                    }
                    else if($daydatefrom >= 1 &&  $daydatefrom<=5 && $time>=830 && $time<1800){
                        if($hascontractid){
                            if($firsthour){
                                $paidamount += 150;
                            }
                            else{
                                $paidamount += 100;
                            }
                        }
                        else{
                            if($firsthour){
                                $paidamount += 200;
                            }
                            else{
                                $paidamount += 150;
                            }
                        }
                    }
                    else{
                        if($hascontractid){
                            if($firsthour){
                                $paidamount += 225;
                            }
                            else{
                                $paidamount += 175;
                            }
                        }
                        else{
                            if($firsthour){
                                $paidamount += 300;
                            }
                            else{
                                $paidamount += 225;
                            }
                        }

                    }
                    $firsthour = false;
                }
                $datefrom = $datefrom->addMinutes(60);
                $diffInMinutes -= 60;

            }

        }
        $totalamount = $paidamount + $totalitemamount;

        $items = ServiceOrderItem::where("svit_serviceorderid",$sorecord->getKey())->get();

        $checkin = $sorecord->svor_datefrom;
        $checkout = now();



        //create model for Holiday set and Holiday set item
        // dd($items);
		return view("cs.signature", compact("record","paidamount","totalamount","items","type","checkin","checkout","totalitemamount"));
    }




	public function close($id)
    {

		$caserecord = Cases::where("Case_CaseId", $id)->first();
		$caserecord->Case_Status="Closed";
		$caserecord->case_Stage='Completed';
		$caserecord->save();

        $sorecord = ServiceOrder::where("svor_CaseId",$id)->orderBy("Svor_ServiceOrderID","desc")->first();
        $sorecord->Svor_Status = "Closed";

		return "";
    }

	public function notclose($id)
    {

		$record = Cases::where("Case_CaseId", $id)->first();
		// $record->case_type=$record->case_typecopy;
		$record->Case_Status="In Progress";
		// $record->Case_AssignedUserId = null;
		$record->save();

        //$data = request()->input();
        $newserviceorderid;

		//Auto Create Service Order Record
		$serviceorderid = ServiceOrder::select('Svor_ServiceOrderID')->orderby('Svor_ServiceOrderID','DESC')->first();

		if($serviceorderid != []){

			$newserviceorderid = $serviceorderid['Svor_ServiceOrderID'] + 1;

		}else{

			$newserviceorderid = 1;

		}

        $serviceorder = new ServiceOrder;

		$serviceorder->Svor_ServiceOrderID = $newserviceorderid;

		$serviceorder->Svor_Status = "In Progress";
		$serviceorder->svor_CaseId = $record->Case_CaseId;
		$serviceorder->svor_ServiceOrderDate = now();


		$serviceorder->svor_SystemType = $record->case_SystemType;
		$serviceorder->svor_CompanyId = $record->Case_PrimaryCompanyId;
    	$serviceorder->svor_PersonId = $record->Case_PrimaryPersonId;
		$serviceorder->svor_FaultReported = $record->case_description;
		$serviceorder->svor_UserId = $record->Case_AssignedUserId;


		$serviceorder->svor_ServiceType = "Contract";
		$serviceorder->svor_btnEdit = "Edit";
		$serviceorder->svor_btnDelete = "Delete";


		$serviceorder->save();

        // $sorecord = ServiceOrder::where("svor_CaseId",$id)->latest()->first();
        // $sorecord->Svor_Status = "In Progress";

		return "";
    }

	public function finish($id)
    {
        try{
		$data = request()->input();
		$year = 23;
		$refno = "SR".(string)$year;
        $count = 0;
        // $refnolatest = ; //SR230001

        $sorecord = ServiceOrder::where("svor_RefNo", "LIKE",  "%"  .$refno. "%")->orderBy("svor_RefNo","DESC")->first();
        if(!empty($sorecord)){
            $refcount = explode($refno, $sorecord->svor_RefNo);
            $count = (int)$refcount[1] + 1;
        }else{
            $count = 1;
        }


        if($count>9999){
            $count = 1;
        }


		$newrefno = $refno.sprintf("%04d", $count);

		$now = now();


        $rules = [
            'name'=>'required',
            'email' => 'required|regex:/(.+)@(.+)\.(.+)/i',
            'phone' => 'numeric'

		];

		$validator = Validator::make($data, $rules);

        if($validator->fails()){
            return response()->json(['errors'=>$validator->errors()->all()]);
        }



		$record = ServiceOrder::where("svor_CaseId",$id)->orderBy("Svor_ServiceOrderID","desc")->first();
		$record->svor_RefNo = $newrefno;

		$record->svor_dateto = $now;

        $record->Svor_Status = "Closed";

        if(!empty($data["Pic"])){
		    $record->svor_sign = $data["Pic"];
        }
		$record->svor_signname = $data["name"];
		$record->svor_signdesignation = $data["Svor_Signdesignation"];
		$record->svor_signemail = $data["email"];
		$record->svor_signcontactnum = $data["phone"];
		$record->svor_signcc = $data["cc"];
		$record->save();




        $db = DB::connection("sqlsrv")->getPdo();


        $query = "Update ServiceOrder set svor_binarysign=".
		"(select " .
		"CAST('' AS XML).value('xs:base64Binary(sql:column(\"signdata\"))' " .
		", 'VARBINARY(MAX)') AS img from " .
		" (" .
		"select replace(svor_sign,'data:image/svg;base64,','') as signdata, * from ServiceOrder where svor_ServiceOrderId= ?) " .
		"x ) " .
		"where svor_ServiceOrderId= ?";

        $stmt = $db->prepare($query);
        $stmt->execute([ $record->getKey(), $record->getKey() ]);

        $newserviceorderitemid;
        $serviceorderitemid = ServiceOrderItem::select('svit_ServiceOrderItemID')->orderby('svit_ServiceOrderItemID','DESC')->first();

		if($serviceorderitemid != []){

			$newserviceorderitemid = $serviceorderitemid['svit_ServiceOrderItemID'] + 1;

		}else{

			$newserviceorderitemid = 1;

		}


        $recordsvit = new ServiceOrderItem;
        $recordsvit->svit_ServiceOrderItemID = $newserviceorderitemid;
        $recordsvit->svit_quantity = 1;
        $recordsvit->svit_pricetotal = $data["paidamount"];
        $recordsvit->svit_unitprice = $data["paidamount"];
        $recordsvit->svit_productid= 67;
        $recordsvit->svit_productfamilyid = 7;
        $recordsvit->svit_serviceorderid = $record["Svor_ServiceOrderID"];
        $recordsvit->svit_Name = "Labour Charge";
        $recordsvit->svit_description = "Labour Charge";
        $recordsvit->save();


        }catch(\Exception $ex){
            Log::error($ex);
        }
        return response()->json([]);
    }

	public function release()
	{

		$id = request()->input("id");
		$record = Cases::where("Case_CaseId", $id)->first();
		// $record->case_type=$record->case_typecopy;
		$record->Case_Status="In Progress";
		$record->Case_AssignedUserId = null;
        $record->Case_ChannelId = null;

        $sorecord = ServiceOrder::where("svor_CaseId",$id)->orderBy("Svor_ServiceOrderID","desc")->first();

        if($sorecord != []){
            DB::delete('delete from ServiceOrderItem where svit_serviceorderid = ?',[$sorecord->getKey()]);
            DB::delete('delete from ServiceOrder where svor_CaseId = ?',[$id]);
        }

		$record->save();

		return "";
	}


    public function cancel()
	{

		$id = request()->input("id");
		$record = Cases::where("Case_CaseId", $id)->first();
		// $record->case_type=$record->case_typecopy;
		$record->Case_Status="Cancelled";
        $record->Case_Stage="Cancelled";

        $sorecord = ServiceOrder::where("svor_CaseId",$id)->whereNull("svor_RefNo")->orderBy("Svor_ServiceOrderID","desc")->first();

        if($sorecord != []){
            DB::delete('delete from ServiceOrderItem where svit_serviceorderid = ?',[$sorecord->getKey()]);
            DB::delete('delete from ServiceOrder where Svor_ServiceOrderID = ?',[$sorecord->getKey()]);
        }

        $contract = Contract::where("Ctra_ContractID", $record->case_contractid)->orderBy("Ctra_ContractID","desc")->first();

        if($contract != []){
            if($record->case_type =='Adhoc'){
                $totalcall = $contract->ctra_numofsvcall + 1;
                $contract->ctra_numofsvcall = $totalcall ;
                $contract->save();
            }
            else if($record->case_type =='Preventive'){
                $totalcall = $contract->ctra_numofpm + 1;
                $contract->ctra_numofpm = $totalcall;
                $contract->save();
            }
        }

		$record->save();

		return "";
	}


}
