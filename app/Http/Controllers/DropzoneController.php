<?php

namespace App\Http\Controllers;

use App\Models\Library;
use App\Models\ServiceOrder;

use Illuminate\Http\Request;

use File;
use Illuminate\Support\Facades\Storage;

use DB;
use Image;


class DropzoneController extends Controller
{
    public function upload(){
        $id = request()->input("id");
        $path = request()->input("path");

        $data = request()->file("file");
        $originalFileName = $data->getClientOriginalName();
        $originalFileNameWithoutExtension = pathinfo($originalFileName, PATHINFO_FILENAME);
        $extension = $data->getClientOriginalExtension();

        $filename = $originalFileName;
        $uploadPath = 'ServiceOrderImages/' . $id . '/' . $path;

        $storage = Storage::disk('temp');

        $index = 0;
        while($storage->exists($uploadPath . "/" . $filename)){
            $index++;
            $filename = $originalFileNameWithoutExtension . "_" . $index . "." . $extension;
        }

		$storage->putFileAs($uploadPath, $data, $filename);

        return response()->json([
            "id" => 0,
            "filename" => $filename
        ]);
    }

    public function delete($id){
        $path = request()->input("path");
        $filename = request()->input("dzid");

        $uploadPath = 'ServiceOrderImages/' . $id . '/' . $path;
        $storage = Storage::disk('temp');

        $status = "fail";
        $message = "";

        $filePath = $uploadPath . "/" . $filename;

        if($storage->exists($filePath)){
            $storage->delete($filePath);
            $status = "ok";
        }else{
            $status = "ok";
        }

        return response()->json([
            "status" => $status,
            "message" => $message
        ]);
    }

    public function uploadServiceOrderImage(){
        $id = request()->input("id");
        $path = request()->input("path");


        $data = request()->file("file");
        $originalFileName = $data->getClientOriginalName();
        $originalFileNameWithoutExtension = pathinfo($originalFileName, PATHINFO_FILENAME);
        $extension = $data->getClientOriginalExtension();

        $filename = $originalFileName;
        $uploadPath = 'ServiceOrderImage/' . $id . '/' . $path;


        $storage = Storage::disk('crm');

        $storagepath = $storage->path($uploadPath);
        if(!File::exists($storagepath)) {
            File::makeDirectory($storagepath, 0777, true);
        }


        $index = 0;
        while($storage->exists($uploadPath . "/" . $filename)){
            $index++;
            $filename = $originalFileNameWithoutExtension . "_" . $index . "." . $extension;
        }


        $img = Image::make($data)->orientate();

        $h = $img->height();
        $w = $img->width();

        // if($w > $h){
        $img->resize(190, null, function($constraint){ //if want large image put 1000, 1024 or larger value, if smaller then reduce
            $constraint->aspectRatio();
        });
        // }else{
        //     $img->resize(null, 190, function($constraint){ //if want large image put 1000, 1024 or larger value,
        //         $constraint->aspectRatio();
        //     });
        // }
        // $img->encode("jpg"); change image format

        $img->save($storage->path($uploadPath . "/" . $filename), 100); //60 percentage of quality



		// $storage->putFileAs($uploadPath, $data, $filename);

        $record = ServiceOrder::find($id);

        $library = new Library;
        $getId = DB::select("DECLARE @nextid as INT; EXEC @nextid = eware_get_identity_id 'Library';SELECT @nextid as nextID;");
        $libraryid = $getId[0]->nextID;

        $library->Libr_LibraryId = $libraryid;
        $library->Libr_Type = $path;
        $library->Libr_FilePath = $uploadPath;
        $library->Libr_FileName = $filename;
        $library->Libr_Status = "Final";
        $library->Libr_FileSize = $storage->size($uploadPath . "/" . $filename);
        $library->Libr_ServiceOrderId = $id;
        $library->save();

        return response()->json([
            "id" => $libraryid,
            "filename" => $filename
        ]);
    }

    public function deleteServiceOrderImage(){
        $id = request()->input("dzid");
        $path = request()->input("path");

        $library = Library::find($id);

        $storage = Storage::disk('crm');

        $status = "fail";
        $message = "";

        if($library != null){
            $uploadPath = 'ServiceOrderImage/' . $library->Libr_ServiceOrderId . '/' . $path;

            $filePath = $uploadPath . "/" . $library->Libr_FileName;

            if($storage->exists($filePath)){
                $storage->delete($filePath);
            }

            $library->libr_Deleted = 1;
            $library->save();

            $status = "ok";
        }else{
            $status = "ok";
        }

        return response()->json([
            "status" => $status,
            "message" => $message
        ]);
    }
}
