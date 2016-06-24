<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
class GalleryController extends Controller
{

    private $table = 'galleries';

    //List the Galleries
    public function index()
    {
        //Get all galleries
        $galleries = DB::table($this->table)->get();
        return view('gallery/index', compact('galleries'));
    }

    //Show create form
    public function create()
    {
       if (!Auth::check()){
           //Redirect
           return Redirect::route('gallery.index');
       }
        return view('gallery/create', compact('test'));
    }

    //store gallery
    public function store(Request $request)
    {
        //get the request input
        $name = $request->input('name');
        $description = $request->input('description');
        $cover_image = $request->file('cover_image');
        $owner_id = 1;

        //check to see if image was uploaded
        if ($cover_image) {
            $cover_image_filename = $cover_image->getClientOriginalName();
            $cover_image->move(public_path('images'), $cover_image_filename);

        } else {
            $cover_image_filename = 'noimage.jpg';
        }
        //Insert Gallery
        DB::table($this->table)->insert(
            [
                'name' => $name,
                'description' => $description,
                'cover_image' => $cover_image_filename,
                'owner_id' => $owner_id
            ]
        );
        //Set message
        Session::flash('message', 'Gallery Added');
        //Redirect
        return Redirect::route('gallery.index');
    }

    //show gallery photos
    public function show($id)
    {
        //get gallery infoo
        $gallery = DB::table($this->table)->where('id', $id)->first();

        //Get photos
        $photos = DB::table('photos')->where('gallery_id', $id)->get();

        return view('gallery/show', compact('gallery', 'photos'));

    }
}
