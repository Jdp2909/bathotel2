<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class ProductController extends Controller
{
    //
    public function create(){
        $categories =\App\Models\Category::all();    
        return view('product.create',['title'=>'Add Product','categories' => $categories]);
    }
    public function store(Request $request){
        $path =$request->file('image')->store('products','public');
        Product::create(
            [
            'name'=> $request->name,
            'description' =>$request->description,
            'category_id'=>$request->category_id,
            'price'=> $request->price,
            'image'=>   $path,
            ]
            );
            return  redirect('/product/index')->with('success','Product Created successfully!');
    }
    public function index(){
        $products =\App\Models\Product::all();
        return view('product.index',['title'=>'List Of Products','products' => $products]);
    }
    public function delete(Request $request){
        $product = Product::find($request->id);
        if($request){
            $product->delete();
            return redirect('/product/index')->with('success','Product Deleted Successfully');
        }
        return redirect('/product/index')->with('error','product not found');
    }
   public function edit($id){
        $categories =\App\Models\Category::all();    
        $product =Product::find($id);
        if(!$product){
            return redirect('/product')->with('error','Product not found');
        }
        return view('product.edit',['title'=> 'Edit Product','product'=> $product,'categories'=> $categories    ]);
    }
    public function update (Request $request, $id){
        $product = Product::find($id);
        if (!$product) {
        return redirect('/product')->with('error', 'Product not found!');
        }
        $data = $request->only(['name', 'description', 'category_id', 'price']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
            if ($product->image) {
                FacadesStorage::disk('public')->delete($product->image);
          }
        }
        $product->update($data);
        return redirect('/product')->with('success', 'Product updated successfully!');
        }
}
