<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Picture;
use App\Models\Type;
use App\Models\Category;
use App\Models\Company;
use App\Models\Customfield;
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
    function __construct()
    {
         $this->middleware('permission:item-list|item-create|item-edit|item-delete', ['only' => ['index','show']]);
         $this->middleware('permission:item-create', ['only' => ['create','store']]);
         $this->middleware('permission:item-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:item-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::with('pictures', 'quantity', 'company')->get();
        $trashed = Item::onlyTrashed()->get();

        $totalquantity = 0;
        $totalvalue = 0;
        /*
        foreach ($items as $value) {
            $totalquantity += $value->quantity;
            $totalvalue += $value->price*$value->quantity;
        }
        */
        return view('items.index', compact('items','trashed', 'totalquantity', 'totalvalue'));
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
        $companies = Company::all();

        return view('items.create', compact('pictures', 'types', 'companies'));
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
            'company' => $request->company_select,
            'type' => $request->type_select,
            'created_by_user' => auth()->user()->name,
        ]);

        $item->save();

        $item->customfields()->sync($request->customfields);

        if(isset($request->category_select)){
            $item->categories()->sync(explode( ',', $request->category_select));
        }
        if(isset($request->picture_select)){
            $item->pictures()->syncWithoutDetaching($request->picture_select);
        }

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
        $unitsdiff = [];
        $dates = [];
        if(count($item->quantity)>0){
            array_push($unitsdiff, 0);
            for ($i=1; $i < count($item->quantity); $i++) {
                array_push($unitsdiff, $item->quantity[$i]->value - $item->quantity[$i-1]->value);
            }
            foreach ($item->quantity as $quantity) {
                array_push($units, $quantity->value);
                array_push($dates, '"'.$quantity->created_at->format('Y-m-d').'"');
            }
        }

        return view('items.show', compact('item', 'units', 'unitsdiff', 'dates'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $checked = $item->customfields->pluck('id');

        $unckeckedtypes = Customfield::whereNotIn('id', $checked)->get();

        $types = Type::all();
        $pictures = Picture::all();
        $companies = Company::all();

        return view('items.edit', compact('item', 'pictures', 'unckeckedtypes', 'types', 'companies'));
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
        foreach ($item->customfields as $value) {
            static $i = 0;
            $item->customfields()->updateExistingPivot($value->pivot->customfield_id, ['value' => $request->customfieldsdatas[$i]]);
            $i++;
        }

        if($item->getLatestQuantity == null || $request->quantity != $item->quantity_value){
            $quantity = new Quantity();

            $quantity->item_id = $item->id;
            $quantity->user_id = auth()->user()->id;
            $quantity->value = $request->quantity;

            $quantity->save();
        }
        if(isset($request->category_select)){
            $item->categories()->sync(explode( ',', $request->category_select));
        }
        if(isset($request->picture_select)){
            $item->pictures()->syncWithoutDetaching($request->picture_select);
        }

        $item->update([
            'uniquename' => $request->uniquename,
            'serialnumber' => $request->serialnumber,
            'minimumlevel' => $request->minimumlevel,
            'price' => $request->price,
            'company' => $request->company_select,
            'type' => $request->type_select,
            'updated_by_user' => auth()->user()->name,
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

        $savedtypes = $item->customfields->pluck('id');
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
        if($request->customfields){
            $changed = typediff($savedtypes, $request->customfields);
        }

        $item->customfields()->sync($request->customfields);
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
