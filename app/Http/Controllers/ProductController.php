<?php

namespace App\Http\Controllers;

use App\Models\Product;
use http\Client\Response;


class ProductController extends Controller
{
    const BOOT_CATEGORY = 'boots';
    const SKU = '00003';
    const CURRENCY = 'EUR';

    public function get()
    {
        $results = [];
        $products = Product::all();

        foreach ($products as $product) {
            $discount = null;
            $final = null;

            if ($product->sku == self::SKU && $product->category !==self::BOOT_CATEGORY) {
                $discount = 15;
            }
            if ($product->category == self::BOOT_CATEGORY) {
                $discount = 30;
            }

            if ($discount !== null) {
                $final = $product->price - ($product->price * ($discount / 100));
            }

            $results [] = [
                'sku' => $product->sku,
                'name' => $product->name,
                'category' => $product->category,
                'price' => [
                    'final' => $final ?? $product->price,
                    'original' => $product->price,
                    'discount_percentage' => $discount != null ? $discount . "%" : null ,
                    'currency' => self::CURRENCY
                ]
            ];

        }

        return response(['results' => $results, 'message' => 'Successful'], 200);
    }


}
