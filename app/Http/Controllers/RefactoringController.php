<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RefactoringController extends Controller
{
    public function getProducts()
    {
        return json_decode(Storage::disk('public')->get('products.json'), true)['products'];
    }

    public function sumPriceForProductTypeLampAndWallet()
    {
        // Imperative Programming

        $products = collect($this->getProducts());

        /*$totalPrice = 0;

        foreach ($products as $product)
        {
            if ($product['product_type'] == 'Wallet' || $product['product_type'] == 'Lamp')
            {
                foreach ($product['variants'] as $variant)
                {
                    $totalPrice += $variant['price'];
                }
            }
        }
        return $totalPrice;*/


        // Declarative Programming
        $totalPrice = $products->filter(function ($product){
//            return in_array($product['product_type'], ['Wallet', 'Pants']);
            return collect(['Wallet', 'Pants'])->contains($product['product_type']);
        })->flatMap(function ($product){
            return $product['variants'];
        })->sum('price');

        return $totalPrice;

    }

    public function getCsv()
    {
        $shifts = [
            'Shipping_Steve_A7',
            'Sales_B9',
            'Support_Tara_K11',
            'J15',
            'Warehouse_B2',
            'Shipping_Dave_A6',
        ];

    /*    $newShifts = [];
        foreach ($shifts as $shift)
        {
            $newShifts[] = last(explode('_', $shift));
        }*/

        $shifts = collect($shifts)->map(function ($shift){
            return collect(explode('_', $shift))->last();
        });

        dd($shifts);
    }
}
