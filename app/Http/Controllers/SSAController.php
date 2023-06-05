<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Schema;

class SSAController extends Controller
{
    public function getSSA(){
        $data = request()->all(); $datalist = [];
		$connection = $data["connection"] ?? null;
        $table = $data["model"] ?? ""; $columns = $data["column"] ?: []; $caption = $data["caption"] ?? "";
        $value = $data["value"] ?? ""; $filter = $data["filter"] ?? ""; $where = $data["whereClause"] ?? "";

        $datalist = $this->checkResult($connection, $table, $columns, $caption, $value, $filter, $where);

        $datalist["columns_def"] = $columns;

        if(!in_array($caption, $columns)){
            array_push($columns, $caption);
        }

        if(!in_array($value, $columns)){
            array_push($columns, $value);
        }

        $datalist["columns"] = $columns;
        $datalist["caption"] = $caption;
        $datalist["primary"] = $value;
        return view("ssaresult")->with($datalist);
    }

    public function checkResult($connection = null, $table = "", $columns = [], $caption = "", $value = "", $filter = "", $where){
        try{
            $records = "null";
			
            if(empty($table) || !is_string($table)){
                return ["fail" => "Table not found"];
            }
			
            if(is_array($columns) && count($columns) > 0){
				
                foreach($columns as $col){
					$checkCol = $this->checkColumn($table, $col, $connection);
                    if (!$checkCol) {
                        return ["fail" => "Column(s) " . $col . " in table " . $table . " not found"];
                    }
                }
            }else{
                return ["fail" => "Please define Column(s)"];
            }

            if(!$this->checkColumn($table, $caption, $connection)){
                return ["fail" => "Caption not found."];
            }

            if(!$this->checkColumn($table, $value, $connection)){
                return ["fail" => "Value not found."];
            }

            if(!in_array($caption, $columns)){
                array_push($columns, $caption);
            }

            if(!in_array($value, $columns)){
                array_push($columns, $value);
            }

            $records = DB::connection($connection)->table($table)->take(25)->orderBy($columns[0])->select($columns);

            $records->where(function($query) use ($columns, $filter){
                foreach($columns as $col){
                    $query->orWhere(DB::raw("ISNULL([$col], '')"), 'LIKE', "%" . $filter . "%");
                }
            });

            if(!empty($where)){
                $records->whereRaw($where);
            }
			
            $count = $records->count();
			//dd($records->toSql(), $records->getBindings());
			
            return ["records" => $records->get(), "count" => $count];
        }catch(\Exception $e){
            return ["fail" => $e->getMessage()];
        }
    }
	
	public function checkColumn($table, $col, $connection = null){
		if(empty($col)){
			return false;
		}
		$base_sql = "SELECT col.name FROM sys.columns AS col JOIN sys.objects AS obj ON col.object_id = obj.object_id WHERE obj.type = 'V' and obj.name = '" . $table . "' AND col.name = '" . $col . "'";
		
		$checkCol = !empty($connection) ? (DB::connection($connection)->getSchemaBuilder()->hasColumn($table, $col)) : (Schema::hasColumn($table, $col));
		if(!$checkCol){
			$checkCol = count(DB::select($base_sql)) > 0;
		}
		
		return $checkCol;
	}
}
