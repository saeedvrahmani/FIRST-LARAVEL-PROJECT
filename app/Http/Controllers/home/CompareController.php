<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function add(Product $product)
    {

        if (session()->has('compareProducts')) {

            if (in_array($product->id, session()->get('compareProducts'))) {
                alert()->warning('محصول مورد نظر درلیست مقایسه موجود میباشد', 'دقت کنید');
                return redirect()->back();
            } else {
                session()->push('compareProducts', $product->id);
            }
        } else {
            session()->put('compareProducts', [$product->id]);
        }

        alert()->success('محصول مورد نظر به لیست مقایسه اضافه گردید');

        return redirect()->back();
    }
    public function index(Product $product)
    {
        if (session()->has('compareProducts')) {
            $products = Product::findOrFail(session()->get('compareProducts'));

            return view('home.compare.index', compact('products'));
        }
        alert()->warning('ابتدا محصولی را لیست مقایسه اضافه کنید');
        return redirect()->back();
    }
    public function remove($productId)
    {

        if (session()->has('compareProducts')) {

            foreach (session()->get('compareProducts') as $key => $item) {
                if ($item == $productId) {
                    session()->pull('compareProducts.' . $key);
                }
            }
            if (session()->get('compareProducts') == []) {
                session()->forget('compareProducts');
              return  redirect()->route('home.index');
            }

            return redirect()->route('home.compare.index');
        }
        alert()->success('محصولی در لیست مقایسه موجود نمیباشد');
        return redirect()->back();
    }
}
