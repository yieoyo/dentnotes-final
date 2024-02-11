<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Note;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(auth()->user()){
            $notesByCategory = Note::where('user_id', auth()->user()->id)->with('category')->get()->groupBy('category.name')->toArray();
            $categoryDropdown = Category::where('user_id', config('panel.super_admin'))->orWhere('user_id', auth()->user()->id ?? '')->pluck('id', 'name')->toArray();
            return view('home',compact('categoryDropdown','notesByCategory'));
        }
        return view('home');
    }
}
