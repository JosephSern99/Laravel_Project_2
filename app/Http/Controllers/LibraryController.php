<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Library;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;



use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

use DB;
use Image;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $record = Library::find($id);
        $filepath = $record->Libr_FilePath;
        $filename = $record->Libr_FileName;

        $storage = Storage::disk('crm');

        $fullPath = $filepath . "/" . $filename;

        return response()->file($storage->path($fullPath));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showByServiceOrer(Request $request, $id){
        $record = Library::where("Libr_ServiceOrderId", $id)->select(["Libr_LibraryId", "Libr_Type", "Libr_FileName"])->get();

        $librariesArr = [];

        foreach($record as $library){
            array_push($librariesArr, [
                "recordid" => $library->getKey(),
                "recordtype" => $library->Libr_Type,
                "filename" => $library->Libr_FileName]);
        }

        return response()->json($librariesArr);
    }

    public function list(Request $request)
    {
        $url = env("REMOTE_API_URL") . "/library/api/list";

        $data = [
			"fields" => $request->input("fields"),
			"values" => $request->input("values"),
			"path" => $request->input("path"),
		];

		$response = Http::post($url, $data);

        if($response->getStatusCode() == 200){
            return $response->json();
        }else{
            return response()->json($response->json(), $response->getStatusCode());
        }
    }

    public function apiList(Request $request){
		try{
			$fields = explode(",", decrypt64($request->input("fields")));
			$values = explode(",", decrypt64($request->input("values")));
			$path = $request->input("path");

			$libraries = Library::query();

			$index = 0;
			foreach($fields as $field){
				$libraries->where($field, $values[$index]);

				$index++;
			}

			$libraries = $libraries->get();
			$filelists = [];

			$storage = Storage::disk('crm');

			foreach($libraries as $library){
				$filename = $library->Libr_FileName;
				$size = $library->Libr_FileSize;

				$filePath = $library->Libr_FilePath;
                $indicator = encrypt64($library->getKey());

				$mimetype = "text/plain";

				if($storage->exists($filePath . "/" . $filename)){
					$mimetype =  $storage->mimeType($filePath . "/" . $filename);
				}

				$fileAttr = compact("filename", "size", "mimetype", "indicator");

				array_push($filelists, $fileAttr);
			}

			return response()->json([
				"fields" => $fields,
				"values" => $values,
				"path" => $path,
				"result" => $filelists
			]);

		}catch(\Exception $ex){
			Log::error($ex);

            return response()->json([
				"status" => "error",
				"message" => "Invalid Data",
			], 500);
		}
    }

    public function upload(Request $request){

        $url = env("REMOTE_API_URL") . "/library/api/upload";

        $data = [
            "fields" => $request->input("fields"),
			"values" => $request->input("values"),
			"path" => $request->input("path"),
            "type" => $request->input("type"),
		];

        $file = request()->file("file");
        /*
        $teststring = "iVBORw0KGgoAAAANSUhEUgAAADIAAAAtCAYAAADsvzj/AAAFDUlEQVR4Ac2ZS0xcVRjHvTN3hisw0GIRZ3AeLWHQWqdVsRqgA86AUmpqoy20Whd2YYhprJq45BVAF7yJkQQTluDGiEhBF5qYRsIjYYMKQxNNMO4gQHgjZfxP8pF8ufEe0qQ5pyf5BTKcWfzyff/vnHt5xLQ0wgbsQCfswEY80BWPxx8I5sUlHMBJP0nm4RfRWAUMkAqOgseII8AFDNqjPYwiGuEAySADeEEuOEkE6bNjIIX22riQchHWSo+SRACc1nU9ahjGG+ASfn8Vn+WT0BNUMV0so04kFTwJTodCoeuTk5N3dnd397a3t/8dHx+fzM7OvoG/nQPPADdwscqoF2HBPgJynE5nZGFhYTZuWlNTU3/4fL6b2FMMnmUyTpJRLqKTSAbIQyu9vrW1tRv/n4Uqzfv9/g+x7xUQAh6QxmVUV0SnKRWESMXm5uZ63GJNT0//GQgEPsHeUibD20xTLeKioBdUV1e3rKysrFrJzM3N/eP1ej/F3jImIxgAcsOeDLLAKRAtLCz8HDKWlZmdnf3b4/F8zCojGADyz5F04AUvgPJoNNq2tLS0YSUzNjY2iwHwEWXmFHCzymiqRGwgiaaXD7wIysvKytqWl5e3rGQwAO4iM7ewt4SmmYfLqLpr2U0yZ0FFaWlp597e3r6VDEbzXapMlGQEA0COiEYyTmozP8lcKC4u7lhdXV2zksGhOZeVlXWLy5gHgDwRJsMqE6A2qygoKGhBm60L2izmdruZjGkAyBShxTNzlGTOgvMYAO2iAYDKxKjNSgQDQI6IRWb8VJnXMADaUZlNK5mJiYl5DAC6AQgGgCwRWjaWGR/IB+fD4XDr2trahqDN5lEZ3mbZ5gEgW4QPAD6aK3BotmIArAsqE2MDIMTajGTkinAZ3mb5NAAS58zGIQPgJvaGwVMgk5597ECTLcJl+AB4GVyKRCJfLi4uijLzGzLzHrWYj1pMVyXCB4BBz/J5oAzcwDT7OhaLWZ4zMzMzvyNX79rt9uOUNyewqRSxsbzk0Jh9H3w2MDDwV1yw+vv7Ox0OR4C+q1REAzr1+ON0TpSDD+rq6n7d2dmxusbs9/T0fJOUlBTRNO2gIg6lGSGJYyAXFIFrtbW1P4oq0dnZOYR9F8EZdqaoCDtVgrJBEoXgck1Nzfciia6urlHsu0rSOSADJEkXYRK8EufAlYaGhtsiiba2thFk4kAij75Po1fiOcIkkplEGFQ2NTWNCBz2W1tbb9tstkrsLaDvcQlN5hWFS2SyTFxubGwcFUl0dHT8gH1VTCITJHMJWSLmYAcPMlFfXy9sJ0gkMnGNpEnCXAkJIhYSReAtBHvosGCTRBgEWSV0qc8jPNhMIgyutLS0/CSSSGRC1/Uqkg5aZUKGiDkTQVAMqtrb238+RGJUHGyZb1F4Je4/2FfFwZYr4qRb7QnwEngTwR4+5JxIZOJtcbDlv2lMAR5wBjfUi7h2fCuS6Ovru6Np2nVqvzwmQcFW9+43HeSg10twix0RSfT29v5iGMY7dMLniTOh+N8KghN7lKZTIQgKMiG/IkwkCJELFiL7uMWOYE+lWUL8elRNa51APoqGh4cTN9p7TOJed3f3d4nz5P4l1ITdDU66XK5Ic3PzF0NDQ1ODg4NT+P0rCFbQM3qu4MRWLsIfX7PB0yAEngPP089TwA8yBMFWKmJ+qZBGj7FecJzw0mfpwBBLqBexseAbIBWkESnAEPybQLnIf4JfIzSb+FymAAAAAElFTkSuQmCC";
        $db = DB::connection("sqlsrv")->getPdo();

        $stmt = $db->prepare("UPDATE Library SET libr_testing = CAST(? AS VARBINARY(MAX)) WHERE Libr_LibraryId = 10054 ");
        $stmt->execute([ $base64string ]);
        dd("HI");*/


        $originalFileName = $file->getClientOriginalName();

        $response = Http::attach("file", file_get_contents($file), $originalFileName)
        ->post($url, $data);

        if($response->getStatusCode() == 200){
            return $response->json();
        }else{
            return response()->json($response->json(), $response->getStatusCode());
        }

    }

    public function apiUpload(Request $request){

        $fields = $request->input("fields");
        $values = $request->input("values");

        $path = $request->input("path");
        $type = $request->input("type");
        $file = $request->file("file");

		if(empty($fields)){
			return response()->json([
				'status' => "fail",
				"message" => "Missing Parameter: fields",
				"input" => $request->all(),
			], 500);
		}else if(empty($values)){
			return response()->json([
				'status' => "fail",
				"message" => "Missing Parameter: values",
				"input" => $request->all(),
			], 500);
		}else if(empty($path)){
			return response()->json([
				'status' => "fail",
				"message" => "Missing Parameter: path",
				"input" => $request->all(),
			], 500);
		}else if(empty($file)){
			return response()->json([
				'status' => "fail",
				"message" => "Missing File",
				"input" => $request->all(),
			], 500);
		}

        $fields = explode(",", decrypt64($fields));
        $values = explode(",", decrypt64($values));

        $originalFileName = $file->getClientOriginalName();
        $originalFileNameWithoutExtension = pathinfo($originalFileName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();

        $filename = $originalFileName;

        $uploadPath = decrypt64($path);

        $storage = Storage::disk('crm');

        $index = 0;

        while($storage->exists($uploadPath . "/" . $filename)){
            $index++;
            $filename = $originalFileNameWithoutExtension . "_" . $index . "." . $extension;
        }

        $size = $file->getSize();

        if(substr($file->getMimeType(), 0, 5) == 'image') {
            $file = Image::make($file);

            if (!file_exists($storage->path($uploadPath))) {
                mkdir($storage->path($uploadPath), 666, true);
            }

            $file->save($storage->path($uploadPath . "/" . $filename), 60);

            $size = $file->filesize();
        }else{

            $storage->putFileAs($uploadPath, $file, $filename);

        }

        $libraryid = 0;

        if(empty($type) || ($type != "norecord")){
            $getId = DB::select("DECLARE @nextid as INT; EXEC @nextid = eware_get_identity_id 'Library';SELECT @nextid as nextID;");
            $libraryid = $getId[0]->nextID;

            $library = new Library;
            $library->Libr_LibraryId = $libraryid;
            if(!empty($type)){
                $library->Libr_Type = $type;
            }
            $library->Libr_FilePath = $uploadPath;
            $library->Libr_FileName = $filename;
            $library->Libr_Status = "Final";
            $library->Libr_FileSize = $size;

            $index = 0;
            foreach($fields as $f){
                $library->{$f} = $values[$index];
                $index++;
            }
            $library->save();
        }

        return response()->json([
            "indicator" => encrypt64($libraryid),
            "filename" => $filename
        ]);
    }

    public function preview(Request $request){
        $data = $request->input();

        try{
            $indicator = $request->input("indicator");
            $path = $request->input("path");
            $filename = $request->input("filename");
            $nocheck = $request->input("nocheck") ?? "N";

            $url = env("REMOTE_API_URL", '') . "/library/api/preview";

            $client = new \GuzzleHttp\Client([
                'stream' => true
            ]);

            $response = $client->request("post", $url, [
                "form_params" => [
                    "filename" => $filename,
                    "indicator" => $indicator,
                    "path" => $path,
                    "nocheck" => $nocheck,
                ],
            ]);

            if($response->getStatusCode() == 200){
                $headers = $response->getHeaders();

                return response()->stream(function() use ($response){
                    $stream = $response->getBody()->detach();
                    fpassthru($stream);
                    fclose($stream);
                }, 200, $headers);

            }else{
                return response()->json($response->json(), $response->getStatusCode());
            }

        }catch(\Exception $ex){
            Log::error($ex);

            return "Error";
        }
    }

    public function apiPreview(Request $request){
        try{
            $indicator = decrypt64($request->input("indicator"));
            $path = $request->input("path");
            $filename = $request->input("filename");
            $nocheck = $request->input("nocheck");

			if($indicator == "0"){
				$storage = Storage::disk('crm');
			}else{
                $library = Library::find($indicator);
                $libraryPath = $library->Libr_FilePath;
                $libraryFileName = $library->Libr_FileName;

                if($nocheck != "Y"){
                    $path = decrypt64($path);
                    if($path != $libraryPath){
                        Log::error($path);
                        Log::error($libraryPath);

                        return response()->json([
                            "status" => "error",
                            "message" => "Incorrect Path.",
                        ], 400);
                    }else if($filename != $libraryFileName){
                        Log::error("FileName: " . $filename);
                        Log::error("FileName: " . $libraryFileName);
                        return response()->json([
                            "status" => "error",
                            "message" => "Incorrect File Name.",
                        ], 400);
                    }
                }else{
                    $path = $libraryPath;
                    $filename = $libraryFileName;
                }

				$storage = Storage::disk('crm');
			}

			$fullPath = $path . "/" . $filename;

			if($storage->exists($fullPath)){
				$headers = [
					'Content-Type' => $storage->mimeType($fullPath),
					'Content-Length' => $storage->size($fullPath),
					'Content-Disposition' => 'inline; filename="' . $filename . '"',
				];

				// Return the streamed file
				return response()->stream(function () use ($storage, $fullPath) {
					$stream = $storage->readStream($fullPath);
					fpassthru($stream);
					fclose($stream);
				}, 200, $headers);
			}else{
                Log::error("File not found for: " . $fullPath);

                $storage = Storage::disk("upload_public");
                $fullPath = "images/notfound.jpg";
                $filename = "notfound.jpg";

                $headers = [
					'Content-Type' => $storage->mimeType($fullPath),
					'Content-Length' => $storage->size($fullPath),
					'Content-Disposition' => 'inline; filename="' . $filename . '"',
				];

                return response()->stream(function () use ($storage, $fullPath){
					$stream = $storage->readStream($fullPath);
					fpassthru($stream);
					fclose($stream);
				}, 200, $headers);
			}

		}catch(\Exception $ex){
			Log::error($ex);

            return response()->json([
				"status" => "error",
				"message" => "Invalid Token",
			], 500);
		}
    }

    public function delete(Request $request){
        $data = $request->input();

        try{
            $indicator = $request->input("indicator");
            $path = $request->input("path");
            $filename = $request->input("filename");
            $nocheck = $request->input("nocheck") ?? "N";

            $url = env("REMOTE_API_URL", '') . "/library/api/delete";

            $client = new \GuzzleHttp\Client([
                'stream' => true
            ]);

            $response = $client->request("post", $url, [
                "form_params" => [
                    "filename" => $filename,
                    "indicator" => $indicator,
                    "path" => $path,
                    "nocheck" => $nocheck,
                ],
            ]);

            if($response->getStatusCode() == 200){
                return response()->json([
                    "status" => "ok"
                ], 200);
            }else{
                return response()->json($response->json(), $response->getStatusCode());
            }


        }catch(\Exception $ex){
            Log::error($ex);

            return "Invalid Token";
        }
    }

    public function apiDelete(Request $request){
        try{
            $indicator = decrypt64($request->input("indicator"));
            $path = $request->input("path");
            $filename = $request->input("filename");
            $nocheck = $request->input("nocheck");

			if($indicator == "0"){
				$storage = Storage::disk('crm');
			}else{
                $library = Library::find($indicator);
                $libraryPath = $library->Libr_FilePath;
                $libraryFileName = $library->Libr_FileName;

                if($nocheck != "Y"){
                    $path = decrypt64($path);
                    if($path != $libraryPath){
                        return response()->json([
                            "status" => "error",
                            "message" => "Invalid Path",
                        ], 500);
                    }else if($filename != $libraryFileName){
                        return response()->json([
                            "status" => "error",
                            "message" => "Invalid FileName",
                        ], 500);
                    }
                }else{
                    $path = $libraryPath;
                    $filename = $libraryFileName;
                }

                $library->Libr_Deleted = 1;
                $library->save();

				$storage = Storage::disk('crm');
			}

			$fullPath = $path . "/" . $filename;

			if($storage->exists($fullPath)){
				$storage->delete($fullPath);
			}

            return response()->json([
                "status" => "ok",
            ]);

		}catch(\Exception $ex){
			Log::error($ex);

            return response()->json([
				"status" => "error",
				"message" => "Invalid Token",
			], 500);
		}
    }
}
