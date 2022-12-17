<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Change;

class ChangeController extends Controller
{
    public function index()
    {
        $logs = Change::select('item_id')->groupBy('item_id')->get();
        return view('changes.mainlogscreen', compact('logs'));
    }

    public function show($id)
    {
        $logs = Change::where('item_id', $id)->get();
        return view('changes.logscreen', compact('logs'));
    }
}
