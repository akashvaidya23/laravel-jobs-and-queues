<?php

namespace App\Http\Controllers;

use App\Jobs\ArticleJob;
use App\Models\Article;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate();
        return response()->json(["products" => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required|numeric|max:999'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->save();
        return response()->json(["status" => true, "message" => "Product created successfully"], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product = Product::find($product->id);
        if ($product) {
            return response()->json(["status" => true, "data" => $product->get()], 200);
        } else {
            return response()->json(["message" => "Product not found"], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required|numeric|max:255'
        ]);

        $product = Product::find($product->id);
        if ($product) {

            $product->name = $request->name;
            $product->slug = $request->slug;
            $product->description = $request->description;
            $product->price = $request->price;
            $product->save();
            return response()->json(["status" => true, "message" => "Product updated successfully"], 200);
        } else {
            return response()->json(["status" => false, "message" => "Product not found"], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product = Product::find($product->id);
        if ($product) {
            $product->delete();
            return response()->json(["status" => true, "message" => "Product deleted successfully"], 200);
        } else {
            return response()->json(["status" => false, "message" => "Product not found"], 500);
        }
    }

    /**
     * Search the specified resource from storage.
     */
    public function search(Request $request)
    {
        $products = Product::where("name", "like", "%" . $request->name . "%")
            ->get();
        return response()->json(["products " => $products], 200);
    }

    public function upload_products(Request $request)
    {
        $products = DB::table("products")
            ->get()
            ->toArray();

        $products = array_chunk(
            $products,
            1000
        );
        foreach ($products as $product) {
            foreach ($product as $product) {
                ArticleJob::dispatch($product);
            }
        }
        return redirect("/product/upload");
    }
}
