<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gallery;
use App\Image;

class GalleriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Gallery::with('user', 'image')->take(10)->latest()->get();
    }

    public function getMore(Request $request)
    {

        $search = $request['search'];
        $skip = $request['skip'];

        $gallery = Gallery::query();

        $gallery->with('user','image');
        if($search !== ''){
            $gallery->whereHas('user', function($query) use ($search){
                $query->where('name', 'Like', '%'.$search.'%')
                ->orWhere('description', 'Like', '%'.$search.'%')
                ->orWhere('first_name', 'Like', '%'.$search.'%')
                ->orWhere('last_name', 'Like', '%'.$search.'%');
                });
        }
        return $gallery->skip($skip)->take(11)->get();
    }

    public function getUser($id, Request $request)
    {
        $search = $request['search'];
        $skip = $request['skip'];

        if($search != ''){
        return Gallery::with('user', 'image')
        ->where('user_id', $id)
        ->where('name', 'like', '%'.$search.'%')
        ->orWhere('description', 'like', '%'.$search.'%')
        ->orderBy('created_at', 'DESC')
        ->skip($skip)->take(11)->get();
        }
        else
        {
            return Gallery::with('user', 'image')->where('user_id', $id)->skip($skip)->take(11)->get();
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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
        $request->validate([
            'name' => 'required|min:2|max:255',
            'description' => 'max:1000',
            'images' => 'required',
            'images.*' => ['required' ,'url']
        ]);




        $gallery = Gallery::create([

            'name' => request('name'),
            'description' => request('description'),
            'user_id' => auth()->user()->id

        ]);

        $images = $request['images'];

        foreach($images as $image){

            $newimage = Image::create([

            'imageUrl' => $image,
            'gallery_id' => $gallery->id

            ]);

            $gallery->image()->save($newimage);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Gallery::with('user', 'image', 'comment.user' )->find($id);
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
        $gallery = Gallery::find($id);

        if($gallery->user_id == auth()->user()->id)
        {
            return Gallery::destroy($id);
        }
        else
        {
            return response()->json(['message' => 'You can only delete gallery that is yours']);
        }
    }
}
