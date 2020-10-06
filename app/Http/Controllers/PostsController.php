<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use function PHPUnit\Framework\returnArgument;

use App\Http\Controllers\Controller;

use App\Models\User;

class PostsController extends Controller
{
    public function __construct()
    {
        // redirect user to login if they don't login yet
        $this->middleware('auth');
    }

    public function create(){
        //each method have => a view
        return view('posts.create');
    }

    public function store(){
        $data = request()->validate([
            'another' => '', // other fields which don't need validation
            'caption' => 'required',
            'image' => ['required', 'image'],
        ]);

        // Authentical user
        //Login to run create

        $imagePath = dd(request('image')->store('uploads', 'public'));

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        return redirect("/profile/".auth()->user()->id);
    }
}
