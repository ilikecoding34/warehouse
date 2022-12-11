<?php

namespace App\Http\Controllers;

use App\Models\Picture;
use App\Models\Item;
use Illuminate\Http\Request;
use Storage;

class PictureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pictures = Picture::orderBy('name')->get();
        $trashed = Picture::onlyTrashed()->get();
        return view('pictures.index', compact('pictures', 'trashed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pictures.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png|max:2048'
            ]);
        $picture = new Picture;
        if($request->file()) {
            $fileName = $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads/pictures', $fileName, 'public');
            $picture->name = $request->name;
            $picture->name_en = $request->name_en;
            $picture->file_path = '/storage/' . $filePath;
            $picture->save();
        }

        return redirect()->route('pictures.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function show(Picture $picture)
    {
        return view('pictures.show', compact('picture'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function edit(Picture $picture)
    {
        return view('pictures.edit', compact('picture'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Picture $picture)
    {
        if($request->file()) {
            $request->validate([
                'file' => 'required|mimes:jpg,jpeg,png|max:2048'
            ]);
            $fileName = $request->file->getClientOriginalName();
            $filePath = $request->file('file')->storeAs('uploads/pictures', $fileName, 'public');
            $picture->file_path = '/storage/' . $filePath;
        }

        $picture->name = $request->name;
        $picture->name_en = $request->name_en;

        $picture->save();

        return redirect()->route('pictures.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Picture  $picture
     * @return \Illuminate\Http\Response
     */
    public function destroy(Picture $picture)
    {
        Picture::find($picture->id) ? Picture::destroy($picture->id) : Picture::onlyTrashed()->find($picture->id)->forceDelete();

        return redirect()->route('pictures.index');
    }

    public function modal($id)
    {
        $picture = Picture::find($id);
	    return response()->json([
	      'data' => $picture
	    ]);
    }

    public function restore($id)
    {
        Picture::withTrashed()->find($id)->restore();
	    return redirect()->route('pictures.index');
    }

    public function storetoitem(Request $request, $id)
    {
        $request->validate([
            'files' => 'required',
            'files.*' => 'required|mimes:jpg,jpeg,png,pdf,xlx,csv|max:102048',
        ]);

        $files = [];
        if ($request->file('files')){
            foreach($request->file('files') as $key => $file)
            {
                $picture = new Picture;
                $fileName = time().'_'.$file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/pictures/'.$id, $fileName, 'public');
                $picture->name = $fileName;
                $picture->name_en = $fileName;
                $picture->file_path = '/storage/' . $filePath;
                $picture->save();

                $item = Item::find($id);
                $item->pictures()->attach($picture->id);
            }
        }

        return redirect()->route('items.edit', $item);
    }

    public function deletefromitem(Request $request)
    {
        $item = Item::find($request->item_id);
        $item->pictures()->detach($request->pic_id);

        return redirect()->route('items.edit', $item);
    }

    public function webcamstore(Request $request)
    {
        $id = $request->item_id;
        $img = $request->image;
        $folderPath = 'uploads/pictures/'.$id.'/';

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';

        $file = 'public/'.$folderPath . $fileName;
        Storage::put($file, $image_base64);

        $picture = new Picture;
        $picture->name = $fileName;
        $picture->name_en = $fileName;
        $picture->file_path = '/storage/' . $folderPath . $fileName;
        $picture->save();

        $item = Item::find($id);
        $item->pictures()->attach($picture->id);

        return redirect()->route('items.edit', $item);
    }
}
