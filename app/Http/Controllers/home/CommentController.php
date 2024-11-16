<?php

namespace App\Http\Controllers\home;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Product;
use App\Models\ProductRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\TryCatch;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.

  
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {

        $validator = Validator::make($request->all(), [
            'text' => 'required|max:7000|min:10',
            'rate' => 'required|digits_between:0,5',
        ]);

        if ($validator->fails()) {
            return   redirect()->to(url()->previous() . '#comments')->withErrors($validator);
        }
        if (auth()->check()) {
            try {
                DB::beginTransaction();


                Comment::create([

                    'text' => $request->text,
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,

                ]);
                if (

                    $product->rates()->where('user_id', auth()->id())->exists()
                ) {

                    $ProductRate = $product->rates()->where('user_id', auth()->id())->first();
                    $ProductRate->updated([
                        'rate' => $request->rate,
                    ]);
                } else {

                    ProductRate::create([
                        'rate' => $request->rate,
                        'user_id' => auth()->id(),
                        'product_id' => $product->id,
                    ]);
                }
                DB::commit();
            } catch (\Exception $ex) {

                DB::rollBack();
                alert()->error('مشکل در ثبت نظر', $ex->getMessage())->persistent('حله');
                return redirect()->back();
            }
            alert()->success('نظر ارزشمند شما با موفقیت ثبت شد', 'باتشکر');
            return redirect()->back();
        } else {
            alert()->error('برای ثبت نظر باید ابتدا وارد لاگین شوید', 'دقت کنید')->persistent('حله');
        }
    }
    public function usersProfileIndex()  {
        $comments = Comment::where('user_id' , auth()->id())->where('approved', 1)->get();
        return view('home.users_profile.comments' , compact('comments'));
    }
}
