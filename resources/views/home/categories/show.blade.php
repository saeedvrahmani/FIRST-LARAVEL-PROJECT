@extends('home.layouts.home')

@section('title')
    صفحه ای فروشگاه
@endsection
@section('script')
    <script>
        $('.variation-select').on('chenge', function() {
            let variation = JSON.parse(this.value);
            let variationPriceDiv = $('.variation-price');
            variationPriceDiv.empty();

            if (variation.is_sale) {
                let spanSale = $('<span/>', {
                    class: 'new',
                    text: toPersianNum(number_format(variation.sale_price)) + ' تومان'

                });
                let spanPrice = $('<span/>', {

                    class: 'old',
                    text: toPersianNum(number_format(variation.price)) + ' تومان'
                });
                variationPriceDiv.append(spanSale);
                variationPriceDiv.append(spanPrice);

            } else {
                let spanPrice = $('<span/>', {
                    class: 'new',
                    text: toPersianNum(number_format(variation.price)) + ' تومان'
                });
                variationPriceDiv.append(spanPrice);
            }
            $('.quantity-input').attr('data-max', variation.quantity);
            $('.quantity-input').val(1);
        });

        function filter() {

            let attributes = @json($attributes);
            attributes.map(attribute => {

                let valueAttribute = $(`.attribute-${attribute.id}:checked`).map(function() {
                    return this.value;
                }).get().join('-');

                if (valueAttribute == "") {
                    $(`#filter-attribute-${attribute.id}`).prop('disabled', true);
                } else {
                    $(`#filter-attribute-${attribute.id}`).val(valueAttribute);
                }

            });
            let sortBy = $('#sort-by').val();

            if (sortBy == "default") {
                $('#filter-sort-by').prop('disabled', true);
            } else {
                $('#filter-sort-by').val(sortBy);
            }

            let variation = $('.variation:checked').map(function() {
                return this.value;
            }).get().join('-');
            if (variation == "") {
                $('#filter-variation').prop('disabled', true);
            } else {
                $('#filter-variation').val(variation);
            }

            $('#filter-form').submit();

        }

        $('#filter-form').on('submit', function(event) {
            event.preventDefault();
            let currentUrl = '{{ url()->current() }}';
            let url = currentUrl + '?' + decodeURIComponent($(this).serialize())
            $(location).attr('href', url);
        });
    </script>
@endsection
@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}">صفحه ای فروشگاه</a>
                    </li>
                    <li class="active">فروشگاه </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="shop-area pt-95 pb-100">
        <div class="container">
            <div class="row flex-row-reverse text-right">

                <!-- sidebar -->
                <div class="col-lg-3 order-2 order-sm-2 order-md-1">
                    <div class="sidebar-style mr-30">
                        <div class="sidebar-widget">
                            <h4 class="pro-sidebar-title">جستجو </h4>
                            <div class="pro-sidebar-search mb-50 mt-25">
                                <form class="pro-sidebar-search-form" action="">
                                    <input type="text" name="search" placeholder="... جستجو ">
                                    <button>
                                        <i class="sli sli-magnifier"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="sidebar-widget">
                            <h4 class="pro-sidebar-title"> دسته بندی </h4>
                            <div class="sidebar-widget-list mt-30">
                                <ul>
                                    {{ $category->parent->name }}
                                    @foreach ($category->parent->children as $childCategory)
                                        <li>
                                            <a href="{{ route('home.categories.show', ['category' => $childCategory->slug]) }}"
                                                style="{{ $childCategory->slug == $category->slug ? 'color: #ff3535' : '' }}">
                                                {{ $childCategory->name }}
                                            </a>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                        <hr>


                        <div class="sidebar-widget mt-30">
                            <h4 class="pro-sidebar-title">{{ $variation->name }} </h4>
                            <div class="sidebar-widget-list mt-20">
                                <ul>
                                    @foreach ($variation->variationValues as $value)
                                        <li>
                                            <div class="sidebar-widget-list-left">
                                                <input type="checkbox" class="variation" value="{{ $value->value }}"
                                                    onchange="filter()"
                                                    {{ request()->has('variation') && in_array($value->value, explode('-', request()->variation)) ? 'checked' : '' }}>
                                                <a href="#"> {{ $value->value }} </a>
                                                <span class="checkmark"></span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- content -->
                <div class="col-lg-9 order-1 order-sm-1 order-md-2">
                    <!-- shop-top-bar -->
                    <div class="shop-top-bar" style="direction: rtl;">

                        <div class="select-shoing-wrap">
                            <div class="shop-select">
                                <select onchange="filter()" id="sort-by">
                                    <option value="default"> مرتب سازی </option>
                                    <option value="max"
                                        {{ request()->has('sortBy') && request()->sortBy == 'max' ? 'selected' : '' }}>
                                        بیشترین قیمت
                                    </option>
                                    <option value="min"
                                        {{ request()->has('sortBy') && request()->sortBy == 'min' ? 'selected' : '' }}>
                                        کم
                                        ترین قیمت </option>
                                    <option value="latset"
                                        {{ request()->has('sortBy') && request()->sortBy == 'latset' ? 'selected' : '' }}>
                                        جدیدترین </option>
                                    <option value="oldest"
                                        {{ request()->has('sortBy') && request()->sortBy == 'oldest' ? 'selected' : '' }}>
                                        قدیمی ترین </option>
                                </select>
                            </div>

                        </div>

                    </div>

                    <div class="shop-bottom-area mt-35">
                        <div class="tab-content jump">

                            <div class="row ht-products" style="direction: rtl;">
                                <!--Product Start-->
                                @foreach ($products as $product)
                                    <div class="col-xl-4 col-md-6 col-lg-6 col-sm-6">
                                        <div
                                            class="ht-product ht-product-action-on-hover ht-product-category-right-bottom mb-30">
                                            <div class="ht-product-inner">
                                                <div class="ht-product-image-wrap">
                                                    <a href="{{ route('home.products.show', ['product' => $product->slug]) }}"
                                                        class="ht-product-image">
                                                        <img src="{{ url(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->primary_image) }}"
                                                            alt="Universal Product Style" />
                                                    </a>
                                                    <div class="ht-product-action">
                                                        <ul>
                                                            <li>
                                                                <a href="#" data-toggle="modal"
                                                                    data-target="#exampleModal-{{ $product->id }}"><i
                                                                        class="sli sli-magnifier"></i><span
                                                                        class="ht-product-action-tooltip"> مشاهده سریع
                                                                    </span></a>
                                                            </li>
                                                            <li>
                                                                <a href="#"><i class="sli sli-heart"></i><span
                                                                        class="ht-product-action-tooltip"> افزودن به
                                                                        علاقه مندی ها </span></a>
                                                            </li>
                                                            <li>
                                                                <a href="#"><i class="sli sli-refresh"></i><span
                                                                        class="ht-product-action-tooltip"> مقایسه
                                                                    </span></a>
                                                            </li>
                                                            <li>
                                                                <a href="#"><i class="sli sli-bag"></i><span
                                                                        class="ht-product-action-tooltip"> افزودن به سبد
                                                                        خرید </span></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="ht-product-content">
                                                    <div class="ht-product-content-inner">
                                                        <div class="ht-product-categories">
                                                            <a href="#">{{ $product->name }}</a>
                                                        </div>
                                                        <h4 class="ht-product-title text-right">
                                                            <a
                                                                href="{{ route('home.products.show', ['product' => $product->slug]) }}">
                                                                {{ $product->name }}</a>
                                                        </h4>
                                                        <div class="ht-product-price">
                                                            @if ($product->quantity_check)
                                                                @if ($product->sale_check)
                                                                    <span class="new">
                                                                        {{ number_format($product->sale_check->sale_price) }}
                                                                        تومان
                                                                    </span>
                                                                    <span class="old">
                                                                        {{ number_format($product->sale_check->price) }}
                                                                        تومان
                                                                    </span>
                                                                @else
                                                                    <span class="new">
                                                                        {{ number_format($product->price_check->price) }}
                                                                        تومان
                                                                    </span>
                                                                @endif
                                                            @else
                                                                <div class="not-in-stock">
                                                                    <p class="text-white">ناموجود</p>
                                                                </div>
                                                            @endif


                                                        </div>
                                                        <div class="ht-product-ratting-wrap mt-4">
                                                            <div data-rating-stars="5" data-rating-readonly="true"
                                                                data-rating-value="{{ ceil($product->rates->avg('rate')) }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <!--Product End-->
                            </div>
                        </div>

                        <div class="pro-pagination-style text-center mt-30">
                            <ul class="d-flex justify-content-center">
                                <li><a class="prev" href="#"><i class="sli sli-arrow-left"></i></a></li>
                                <li><a class="active" href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a class="next" href="#"><i class="sli sli-arrow-right"></i></a></li>
                            </ul>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <form id="filter-form">
        @foreach ($attributes as $attribute)
            <input id="filter-attribute-{{ $attribute->id }}" type="hidden" name="attribute[{{ $attribute->id }}]">
        @endforeach
        <input id="filter-variation" type="hidden" name="variation">
        <input id="filter-sort-by" type="hidden" name="sortBy">


    </form>



    <!-- Modal -->
    <div class="modal fade" id="exampleModal-{{ $product->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-7 col-sm-12 col-xs-12" style="direction: rtl;">
                            <div class="product-details-content quickview-content">
                                <h2 class="text-right mb-4">{{ $product->name }} </h2>
                                <div class="product-details-price variation-price">
                                    @if ($product->quantity_check)
                                        @if ($product->sale_check)
                                            <span class="new">
                                                {{ number_format($product->sale_check->sale_price) }}
                                                تومان
                                            </span>
                                            <span class="old">
                                                {{ number_format($product->sale_check->price) }}
                                                تومان
                                            </span>
                                        @else
                                            <span class="new">
                                                {{ number_format($product->price_check->price) }}
                                                تومان
                                            </span>
                                        @endif
                                    @else
                                        <div class="not-in-stock ">
                                            <p class="text-white">ناموجود</p>
                                        </div>
                                    @endif

                                </div>
                                <div class="pro-details-rating-wrap">
                                    <div class="pro-details-rating">
                                        <div data-rating-stars="5" data-rating-readonly="true"
                                            data-rating-value="{{ ceil($product->rates->avg('rate')) }}">
                                        </div>
                                    </div>
                                    <span>3 دیدگاه</span>
                                </div>
                                <p class="text-right">
                                    {{ $product->description }} </p>
                                <div class="pro-details-list text-right">
                                    <ul class="text-right">
                                        @foreach ($product->attributes()->with('attribute')->get() as $attribute)
                                            <li>-
                                                {{ $attribute->attribute->name }}
                                                :
                                                {{ $attribute->value }}
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                                <div class="pro-details-size-color text-right">
                                    <div class="pro-details-size  w-50">
                                        <span>{{ App\Models\Attribute::find($product->variations->first()->attribute_id)->name }}</span>
                                        <div class="pro-details-size-content">
                                            <select class="form-control variation-select">
                                                @foreach ($product->variations()->where('quantity', '>', 0)->get() as $variation)
                                                    <option
                                                        value="{{ json_encode($variation->only(['id', 'quantity', 'sale_price', 'price', 'is_sale'])) }}">
                                                        {{ $variation->value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="pro-details-quality">
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box quantity-input" type="text" name="qtybutton"
                                            data-max="5" value="2" />
                                    </div>
                                    <div class="pro-details-cart">
                                        <a href="#">افزودن به سبد خرید</a>
                                    </div>
                                    <div class="pro-details-wishlist">
                                        @auth

                                            @if ($product->checkUserwishlist(auth()->id()))
                                                <a href="{{ route('home.wishlist.remove', ['product' => $product->id]) }}"><i
                                                        class="fa fa-heart" style="color:red"></i></a>
                                            @else
                                                <a href="{{ route('home.wishlist.add', ['product' => $product->id]) }}"><i
                                                        class="sli sli-heart"></i></a>
                                            @endif
                                        @else
                                            <a href="{{ route('home.wishlist.add', ['product' => $product->id]) }}"><i
                                                    class="sli sli-heart"></i></a>

                                        @endauth
                                    </div>
                                    <div class="pro-details-compare">
                                        <a title="Add To Compare" href="#"><i class="sli sli-refresh"></i></a>
                                    </div>
                                </div>
                                <div class="pro-details-meta">
                                    <span>دسته بندی :</span>
                                    <ul>

                                        <li><a
                                                href="#">{{ $product->category->parent->name }},{{ $product->category->name }}</a>
                                        </li>

                                    </ul>
                                </div>
                                <div class="pro-details-meta">
                                    <span>تگ ها :</span>
                                    <ul>
                                        @foreach ($product->tags as $tage)
                                            <li><a href="#">{{ $tage->name }}{{ $loop->last ? '' : ',' }} </a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-12 col-xs-12">
                            <div class="tab-content quickview-big-img">
                                <div id="pro-primary-{{ $product->id }}" class="tab-pane fade show active">
                                    <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->primary_image) }}"
                                        alt="" />
                                </div>
                                @foreach ($product->images as $image)
                                    <div id="pro-{{ $image->id }}" class="tab-pane fade">
                                        <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH') . $image->image) }}"
                                            alt="" />
                                    </div>
                                @endforeach
                            </div>
                            <!-- Thumbnail Large Image End -->
                            <!-- Thumbnail Image End -->
                            <div class="quickview-wrap mt-15">
                                <div class="quickview-slide-active owl-carousel nav nav-style-2" role="tablist">
                                    <a class="active" data-toggle="tab" href="#pro-primary-{{ $product->id }}"><img
                                            src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH') . $product->primary_image) }}"
                                            alt="" /></a>
                                    @foreach ($product->images as $image)
                                        <a data-toggle="tab" href="#pro-{{ $image->id }}">
                                            <img src="{{ asset(env('PRODUCT_IMAGES_UPLOAD_PATH') . $image->image) }}"
                                                alt="" />
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
@endsection
