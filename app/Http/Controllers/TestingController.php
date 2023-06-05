<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CustomCaptions;
use App\Models\MOHeader;
use App\Models\MODetail;

use DB;

class TestingController extends Controller
{
    public function create(Request $request)
    {
        return view("testing.main");
    }
}
