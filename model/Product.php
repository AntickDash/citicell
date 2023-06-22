<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'category', 'brand', 'price', 'image', 'description'];

    private static $product, $image, $imageName, $directory, $imageUrl;

    public static function imageUpload($request)
    {
        self::$image      = $request->file('image');
        self::$imageName  = self::$image->getClientOriginalName();
        self::$directory  = "upload/product-images/";
        self::$image->move(self::$directory, self::$imageName);
        return self::$directory.self::$imageName; // img/upload/fising-coupe.jpeg
    }

    public static function newProduct($request)
    {
        self::$imageUrl = self::imageUpload($request);

        self::$product = new Product();
        self::$product->name        = $request->name;
        self::$product->category    = $request->category;
        self::$product->brand       = $request->brand;
        self::$product->price       = $request->price;
        self::$product->image       = self::$imageUrl;
        self::$product->description = $request->description;
        self::$product->save();
    }

    public static function updateProduct($request, $id)
    {
        self::$product = Product::find($id);
        if ($request->file('image'))
        {
            if (file_exists(self::$product->image))
            {
                unlink(self::$product->image);
            }
            self::$imageUrl = self::imageUpload($request);
        }
        else
        {
            self::$imageUrl = self::$product->image;
        }
        self::$product->name        = $request->name;
        self::$product->category    = $request->category;
        self::$product->brand       = $request->brand;
        self::$product->price       = $request->price;
        self::$product->image       = self::$imageUrl;
        self::$product->description = $request->description;
        self::$product->save();
    }

    public static function deleteProduct($id)
    {
        self::$product = Product::find($id);
        if (file_exists(self::$product->image))
        {
            unlink(self::$product->image);
        }
        self::$product->delete();
    }
}
