@extends('home.layouts.home')
@section('title')
    صفحه ای مقایسه
@endsection

@section('content')
    <!-- compare main wrapper start -->
    <div class="compare-page-wrapper pt-100 pb-100" style="direction: rtl;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Compare Page Content Start -->
                    <div class="compare-page-content-wrap">
                        <div class="compare-table table-responsive">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    <tr>
                                        <td class="first-column"> محصول </td>
                                        @foreach ($products as $product)
                                            <td class="product-image-title">
                                                <a href="single-product.html" class="image">
                                                    <img class="img-fluid"
                                                        src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->primary_image) }}"
                                                        alt="Compare Product">
                                                </a>
                                                <a href="#" class="category">{{ $product->category->name }} </a>
                                                <a href="single-product-sale.html" class="title"> {{ $product->name }} </a>
                                            </td>
                                        @endforeach


                                    </tr>
                                    <tr>
                                        <td class="first-column"> توضیحات </td>
                                        @foreach ($products as $product)
                                            <td class="pro-desc">
                                                <p class="text-right">
                                                    {{ $product->description }}
                                                </p>
                                            </td>
                                        @endforeach


                                    </tr>

                                    <tr>
                                        <td class="first-column"> ویژگی متغییر </td>
                                        @foreach ($products as $product)
                                            <td>
                                                <ul class="text-right">
                                                    {{ App\Models\Attribute::find($product->variations->first()->attribute_id)->name }}:
                                                    <li>
                                                        @foreach ($product->variations()->where('quantity', '>', 0)->get() as $variation)
                                                            <option>
                                                                {{ $variation->value }}</option>
                                                        @endforeach
                                                    </li>
                                                </ul>
                                            </td>
                                        @endforeach

                                    </tr>
                                    <tr>
                                        <td class="first-column"> ویژگی </td>
                                        @foreach ($products as $product)
                                            <td>
                                                @foreach ($product->attributes()->with('attribute')->get() as $attribute)
                                                    <ul class="text-right">
                                                        <li>-
                                                            {{ $attribute->attribute->name }}
                                                            :
                                                            {{ $attribute->value }}
                                                        </li>
                                                    </ul>
                                                @endforeach
                                            </td>
                                        @endforeach

                                    </tr>
                                    <tr>
                                        <td class="first-column"> امتیاز </td>
                                        @foreach ($products as $product)
                                            <td class="pro-ratting">
                                                <div id="dataReadonlyReview" data-rating-stars="5"
                                                    data-rating-value="{{ ceil($product->rates->avg('rate')) }}"
                                                    data-rating-input="#rateInput">
                                                </div>
                                            </td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td class="first-column"> حذف </td>
                                        @foreach ($products as $product )
                                          <td class="pro-remove">
                                            <a href="{{route('home.compare.remove',['product' => $product->id])}}"><i class="sli sli-trash"></i></a>
                                        </td>  
                                        @endforeach
                                        
                                       
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Compare Page Content End -->
                </div>
            </div>
        </div>
    </div>
    <!-- compare main wrapper end -->
@endsection
