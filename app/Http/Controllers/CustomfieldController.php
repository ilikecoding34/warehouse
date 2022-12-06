<?php

namespace App\Http\Controllers;

use App\Models\Customfield;
use Illuminate\Http\Request;

class CustomfieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customfields = Customfield::orderBy('name')->get();
        $trashed = Customfield::onlyTrashed()->get();
        return view('customfields.index', compact('customfields', 'trashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customfields.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $type = new Customfield;
        $type->name = $request->name;
        $type->save();

        return redirect()->route('customfields.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customfield  $customfield
     * @return \Illuminate\Http\Response
     */
    public function show(Customfield $customfield)
    {
        return view('customfields.show', compact('customfield'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customfield  $customfield
     * @return \Illuminate\Http\Response
     */
    public function edit(Customfield $customfield)
    {
        return view('customfields.edit', compact('customfield'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customfield  $customfield
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customfield $customfield)
    {
        $customfield->name = $request->name;
        $customfield->save();

        return redirect()->route('customfields.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customfield  $customfield
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customfield $customfield)
    {
        $customfield->delete($customfield->id);
        return redirect()->route('customfields.index');
    }

    public function modal($id)
    {
        $picture = Customfield::find($id);
	    return response()->json([
	      'data' => $picture
	    ]);
    }

    public function restore($id)
    {
        Customfield::withTrashed()->find($id)->restore();
	    return redirect()->route('customfields.index');
    }
}
