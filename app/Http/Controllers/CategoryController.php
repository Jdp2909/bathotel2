<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){

    }
    public function store(Request $request){
        Category::create(
                [
                    'name'=> $request->name,
                ]
                );
                return redirect('/category/create')->with('success',
                'Category created successfully!');
    }
}
