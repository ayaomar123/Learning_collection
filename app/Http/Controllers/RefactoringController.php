<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function binaryToDecimal()
    {
        $binary = '100110101'; // total equals 309

       /* $expo = Str::length($binary) - 1;
        $decimal = 0;

        for ($i = 0; $i < Str::length($binary) ; $i++)
        {
            $decimal += $binary[$i] * (2 ** $expo);
            $expo--;
        }*/
        $decimal = collect(str_split($binary))->reverse()->values()->map(function ($binary, $exp){
            return $binary * (2 ** $exp);
        })->sum();

        dd($decimal);
    }

    public function getEvents()
    {
        return json_decode(Storage::disk('public')->get('events.json'), true);
    }

    public function totalScore()
    {
        $events = $this->getEvents();

        $score = [];
        foreach ($events as $event)
        {
            switch ($event['type']){
                case 'PushEvent':
                    $score[] = 5;
                    break;
                case 'CreateEvent':
                    $score[] = 4;
                    break;
                case 'IssuesEvent':
                    $score[] = 3;
                    break;
                case 'CommitCommentEvent':
                    $score[] = 2;
                    break;
                default:
                    $score[] = 1;
                    break;
            }
        }

        dd(collect($score)->sum());
    }
}
