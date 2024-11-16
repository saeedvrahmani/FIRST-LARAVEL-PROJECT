@extends('home.layouts.home')
@section('title')
    صفحه ای پروفایل
@endsection

@section('content')
    <div class="breadcrumb-area pt-35 pb-35 bg-gray" style="direction: rtl;">
        <div class="container">
            <div class="breadcrumb-content text-center">
                <ul>
                    <li>
                        <a href="{{ route('home.index') }}">صفحه ای اصلی</a>
                    </li>
                    <li class="active"> پروفایل </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- my account wrapper start -->
    <div class="my-account-wrapper pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        @include('home.sections.users_profile')
                        <!-- My Account Tab Content Start -->
                        <div class="col-lg-9 col-md-8">
                            <div class="tab-content" id="myaccountContent">




                                <!-- Single Tab Content Start -->
                                <div class="tab-pane fade  show  active " id="comments" role="tabpanel">
                                    <div class="myaccount-content">
                                        <h3> نظرات </h3>
                                        <div class="review-wrapper">

                                            <div class="single-review">
                                                <div class="review-img">
                                                    <img src="assets/img/product-details/client-1.jpg" alt="">
                                                </div>

                                            </div>
                                            @if ($comments->isEmpty())
                                                <div class="alert  alert-danger">

                                                    لیست علاقه مندی خالی میباشد

                                                </div>
                                            @else
                                            @foreach ($comments as $comment)
                                                <div class="single-review">
                                                    <div class="review-img">
                                                        <img src="{{ $comment->user->avatar == null ? asset('/images/home/users.png') : $comment->user->avatar }}"
                                                            alt="">
                                                    </div>
                                                    <div class="review-content w-100 text-right">
                                                        <p class="text-right">
                                                            {{ $comment->text }}
                                                        </p>
                                                        <div class="review-top-wrap text-right">
                                                            <div class="review-name d-flex align-items-center">
                                                                <h4>
                                                                    برای محصول :
                                                                    <a class="mr-1" href="#" style="color:#ff3535;">
                                                                        {{ $comment->product->name }}</a>
                                                                </h4>
                                                            </div>
                                                            <div>
                                                                در تاریخ
                                                                :{{ verta($comment->created_at)->format('%d %B , %Y') }}

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            @endif
                                            


                                        </div>
                                    </div>
                                </div> <!-- Single Tab Content End -->

                            </div>
                        </div> <!-- My Account Tab Content End -->
                    </div>
                </div> <!-- My Account Page End -->
            </div>
        </div>
    </div>
    </div>
    <!-- my account wrapper end -->

    <!-- Modal Order -->
    <div class="modal fade" id="ordersDetiles" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">x</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12" style="direction: rtl;">
                            <form action="#">
                                <div class="table-content table-responsive cart-table-content">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th> تصویر محصول </th>
                                                <th> نام محصول </th>
                                                <th> فی </th>
                                                <th> تعداد </th>
                                                <th> قیمت کل </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr>
                                                <td class="product-thumbnail">
                                                    <a href="#"><img src="assets/img/cart/cart-3.svg"
                                                            alt=""></a>
                                                </td>
                                                <td class="product-name"><a href="#"> لورم ایپسوم </a></td>
                                                <td class="product-price-cart"><span class="amount">
                                                        20000
                                                        تومان
                                                    </span></td>
                                                <td class="product-quantity">
                                                    2
                                                </td>
                                                <td class="product-subtotal">
                                                    40000
                                                    تومان
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="product-thumbnail">
                                                    <a href="#"><img src="assets/img/cart/cart-4.svg"
                                                            alt=""></a>
                                                </td>
                                                <td class="product-name"><a href="#"> لورم ایپسوم متن ساختگی </a>
                                                </td>
                                                <td class="product-price-cart"><span class="amount">
                                                        10000
                                                        تومان
                                                    </span></td>
                                                <td class="product-quantity">
                                                    3
                                                </td>
                                                <td class="product-subtotal">
                                                    30000
                                                    تومان
                                                </td>
                                            </tr>

                                            <tr>
                                                <td class="product-thumbnail">
                                                    <a href="#"><img src="assets/img/cart/cart-5.svg"
                                                            alt=""></a>
                                                </td>
                                                <td class="product-name"><a href="#"> لورم ایپسوم </a></td>
                                                <td class="product-price-cart"><span class="amount">
                                                        40000
                                                        تومان
                                                    </span></td>
                                                <td class="product-quantity">
                                                    2
                                                </td>
                                                <td class="product-subtotal">
                                                    80000
                                                    تومان
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal end -->
@endsection
