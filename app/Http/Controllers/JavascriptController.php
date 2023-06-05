<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JavascriptController extends Controller
{
    public function ssa(){
        $data = request()->all();
        $datalist['u'] = $data['u'] ?? '';
        return $this->setHeader('javascript.ssa', $datalist);
    }

    public function setHeader($view, $datalist = []){
        $response = response(view($view)->with($datalist));
        $response->header('Content-Type', 'application/javascript');
        return $response;
    }
}
