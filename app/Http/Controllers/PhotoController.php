<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
class PhotoController extends Controller
{
    private $table = 'photos';
    //Show create form
    public function create($gallery_id)
    {
        //check if logged in
        if (!Auth::check()){
            //Redirect
            return Redirect::route('gallery.index');
        }
      return view('photo.create',compact('gallery_id'));
    }

    //store photo
    public function store(Request $request)
    {

        //get the request input
        $gallery_id = $request->input('gallery_id');
        $title = $request->input('title');
        $description = $request->input('description');
        $location = $request->input('location');
        $image = $request->file('image');
        $owner_id = 1;


        //check to see if image was uploaded
        if ($image) {
            $image_filename = $image->getClientOriginalName();
            $image->move(public_path('images'), $image_filename);

        } else {
            $image_filename = 'noimage.jpg';
        }
        //Insert Photo
        DB::table($this->table)->insert(
            [
                'title' => $title,
                'description' => $description,
                'location' => $location,
                'gallery_id' => $gallery_id,
                'image' => $image_filename,
                'owner_id' => $owner_id
            ]
        );
        //Set message
        Session::flash('message', 'Photo Added');
        //Redirect
        return Redirect::route('gallery.show',array('id'=>$gallery_id));
    }

    //show photo details
    public function details($id)
    {
       //get Photo
        $photo = DB::table($this->table)->where('id',$id)->first();

        //render template
        return view('photo/details',compact('photo'));
    }
}
