<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product.index');
    }

    public function create(Request $request)
    {
        Product::newProduct($request);
        return back()->with('message', 'Product info create successfully.');
    }

    public function manage()
    {
        return view('admin.product.manage', ['products' => Product::all()]);
    }

    public function edit($id)
    {
        return view('admin.product.edit', ['product' => Product::find($id)]);
    }

    public function update(Request $request, $id)
    {
        Product::updateProduct($request, $id);
        return redirect('/product/manage')->with('message', 'Product info update successfully.');
    }

    public function delete($id)
    {
        Product::deleteProduct($id);
        return redirect('/product/manage')->with('message', 'Product info delete successfully.');
    }
}
