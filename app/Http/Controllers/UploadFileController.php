<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ServiceOrder;
use App\Models\Images;

use Illuminate\Support\Facades\Storage; // Storage path (refer to config/filesystem.php)

class UploadFileController extends Controller {
	
	public function index() {
		return view('uploadfile');
	}
	
	
	// need to make "windows/temp" and "public" folder ,  set IIS_ISURS to full control to allow image to be uploaded.
	public function UploadFile(Request $request, $id) {
		
		$this->validate($request, [
         'file' => 'required',
         //'files.*' =>  'required|max:4096',
		]);
		
		$image_code = '';
		$images = $request->file('file');
		foreach($images as $image)
		{
			$new_name = $image->getClientOriginalName();
			$image->move(public_path('images'), $new_name);
			$image_code .= '<div class="col-md-3" style="margin-bottom:24px;"><img src="/apro/images/'.$new_name.'" class="img-thumbnail" /></div>';
			
		}

		$output = array(
		  'success'  => 'Images uploaded successfully',
		  'image'   => $image_code
		);
		
		$record = ServiceOrder::find($id);
		$record->svor_image = $output['image'];
		$record->save();
			
		
		

		return response()->json($output);
		 
		
		/*$record = ServiceOrder::find($id);
		$record->svor_image = $destinationPath."\\".$file->getClientOriginalName();
		$record->save();*/
		
		//$idreturn = "/cs/".$record->svor_CaseId."/main";
		
	
	
	}
		

		
		  
	  
	  
	
}