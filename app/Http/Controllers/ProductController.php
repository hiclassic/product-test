<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    private $filePath = 'products.json';

    public function index()
    {
        $products = $this->getProducts();
        return view('products', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $products = $this->getProducts();

        $newProduct = [
            'id' => uniqid(),
            'product_name' => $request->product_name,
            'quantity' => (int)$request->quantity,
            'price' => (float)$request->price,
            'submitted_at' => now()->toDateTimeString(),
        ];

        $products[] = $newProduct;
        $this->saveProducts($products);

        return response()->json(['success' => 'Product saved successfully!', 'data' => $this->getSortedData()]);
    }

    private function getProducts()
    {
        if (!Storage::disk('local')->exists($this->filePath)) {
            return [];
        }
        return json_decode(Storage::disk('local')->get($this->filePath), true) ?? [];
    }

    private function saveProducts($products)
    {
        Storage::disk('local')->put($this->filePath, json_encode($products, JSON_PRETTY_PRINT));
    }

    public function getSortedData()
    {
        $products = $this->getProducts();
        
        usort($products, function ($a, $b) {
            return strtotime($b['submitted_at']) - strtotime($a['submitted_at']);
        });
        return $products;
    }

public function edit($id)
{
    $products = $this->getProducts();
    $product = collect($products)->firstWhere('id', $id);
    return response()->json($product);
}


public function update(Request $request)
{
    $products = $this->getProducts();
    
    foreach ($products as &$product) {
        if ($product['id'] == $request->id) {
            $product['product_name'] = $request->product_name;
            $product['quantity'] = (int)$request->quantity;
            $product['price'] = (float)$request->price;
        }
    }

    $this->saveProducts($products);
    return response()->json(['success' => 'Product updated successfully!', 'data' => $this->getSortedData()]);
}
}

