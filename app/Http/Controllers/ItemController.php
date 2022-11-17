<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Picture;
use App\Models\Type;
use App\Models\Quantity;
use Illuminate\Http\Request;
use DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::with('picture', 'quantity')->get();
        $trashed = Item::onlyTrashed()->get();
        
        $totalquantity = 0;
        $totalvalue = 0;
        /*
        foreach ($items as $value) {
            $totalquantity += $value->quantity;
            $totalvalue += $value->price*$value->quantity;
        }
        */
        return view('item_pages.index', compact('items','trashed', 'totalquantity', 'totalvalue'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $pictures = Picture::all();
        return view('item_pages.create', compact('pictures', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Item();

        $item->fill([
            'uniquename' => $request->uniquename,
            'serialnumber' => $request->serialnumber,
            'minimumlevel' => $request->minimumlevel,
            'price' => $request->price,
            'picture_id' => $request->picture_select,
        ]);

        $item->save();

        $item->types()->sync($request->types);

        $quantity = new Quantity();

        $quantity->value = $request->quantity;
        $quantity->item_id = $item->id;

        $quantity->save();

        return redirect()->route('items.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        $units = [];
        $dates = [];
        foreach ($item->quantity as $quantity) {
            array_push($units, $quantity->value);
            array_push($dates, '"'.$quantity->created_at->format('Y-m-d').'"');
        }
        
        return view('item_pages.show', compact('item', 'units', 'dates'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $tmparr = array();
        foreach ($item->types as $value) {
            array_push($tmparr, $value->id);
        }
        $unckeckedtypes = Type::whereNotIn('id', $tmparr)->get();

        $pictures = Picture::all();

        return view('item_pages.edit', compact('item', 'pictures', 'unckeckedtypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $quantityid = null;

        foreach ($item->types as $value) {
            static $i = 0;
            $item->types()->updateExistingPivot($value->pivot->type_id, ['value' => $request->typedatas[$i]]);
            $i++;
        }

        if($item->getLatestQuantity->isEmpty() || $request->quantity != $item->getLatestQuantity->first()->value){
            $quantity = new Quantity();

            $quantity->item_id = $item->id;
            $quantity->value = $request->quantity;
            
            $quantity->save();

            $quantityid = $quantity->id;
        }else{
            $quantityid = $item->quantity_id;
        }
        
        $item->update([
            'uniquename' => $request->uniquename,
            'serialnumber' => $request->serialnumber,
            'minimumlevel' => $request->minimumlevel,
            'price' => $request->price,
            'picture_id' => $request->picture_select,
        ]);
        
        return redirect()->route('items.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Item::find($request->id) ? Item::destroy($request->id) : Item::onlyTrashed()->find($request->id)->forceDelete();

        return redirect()->route('items.index');
    }

    public function addtype(Request $request, Item $item)
    {
        
        $savedtypes = $item->types->pluck('id');
        $changed = '';
        function typediff($old, $new){
            $diffarr = [];
            for($i = 0; $i < count($new); $i++){
                if(!$old->contains($new[$i])){
                    array_push($diffarr, $new[$i]);
                }
            }
            return $diffarr;
        }
        if($request->types){
            $changed = typediff($savedtypes, $request->types);
        }
        
        $item->types()->sync($request->types);
        return redirect()->route('items.edit', $item->id)->with('success', $changed);
    }

    public function modal($id)
    {
        $item = Item::find($id);
	    return response()->json([
	      'data' => $item
	    ]);
    }

    public function restore($id)
    {
        Item::withTrashed()->find($id)->restore();
	    return redirect()->route('items.index');
    }
}
