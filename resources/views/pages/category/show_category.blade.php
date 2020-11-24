@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
                       <div class="fb-share-button" data-href="http://localhost/tutorial_youtube/shopbanhanglaravel" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{$url_canonical}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                       <div class="fb-like" data-href="{{$url_canonical}}" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="false"></div>
                        @foreach($category_name as $key => $name)

                        <h2 class="title text-center">{{$name->category_name}}</h2>

                        @endforeach

                        <div class="row">
                            <div class="col-md-12">
                                <label for="amount">Sắp xếp theo</label>
                                <form>
                                    @csrf
                                    <select name="sort" id="sort" class="form-control price-sort">
                                        <option value="{{Request::url()}}?sort_by=none">--Lọc--</option>
                                        <option value="{{Request::url()}}?sort_by=tang_dan">Giá tăng dần</option>
                                        <option value="{{Request::url()}}?sort_by=giam_dan">Giá giảm dần</option>
                                        <option value="{{Request::url()}}?sort_by=kytu_az">A đến Z</option>
                                        <option value="{{Request::url()}}?sort_by=kytu_za">Z đến A</option>
                                    </select>
                                </form>
                            </div>

                        @foreach($category_by_id as $key => $product)
                        <a href="{{URL::to('/chi-tiet/'.$product->product_slug)}}">
                        <div class="col-sm-4">
                             <div class="product-image-wrapper">

                                <div class="single-products">
                                        <div class="productinfo text-center">
                                            <form>
                                                @csrf
                                            <input type="hidden" value="{{$product->product_id}}" class="cart_product_id_{{$product->product_id}}">
                                            <input type="hidden" id="wishlist_productname{{$product->product_id}}" value="{{$product->product_name}}" class="cart_product_name_{{$product->product_id}}">
                                            <input type="hidden" value="{{$product->product_image}}" class="cart_product_image_{{$product->product_id}}">
                                            <input type="hidden" value="{{$product->product_quantity}}" class="cart_product_quantity_{{$product->product_id}}">
                                            <input type="hidden" id="wishlist_productprice{{$product->product_id}}" value="{{$product->product_price}}" class="cart_product_price_{{$product->product_id}}">
                                            <input type="hidden" value="1" class="cart_product_qty_{{$product->product_id}}">

                                            <a id="wishlist_producturl{{$product->product_id}}" href="{{URL::to('/chi-tiet/'.$product->product_slug)}}">
                                                <img id="wishlist_productimage{{$product->product_id}}" src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                                                <h2>{{number_format($product->product_price,0,',','.').' '.'VNĐ'}}</h2>
                                                <p>{{$product->product_name}}</p>


                                             </a>
                                             <style type="text/css">
                                                    .xemnhanh {
                                                    background:#F5F5ED;
                                                    border: 0 none;
                                                    border-radius: 0;
                                                    color: #696763;
                                                    font-family: 'Roboto', sans-serif;
                                                    font-size: 15px;
                                                    margin-bottom: 25px;
                                                    }
                                                </style>

                                                    <input type="button" value="Thêm giỏ hàng" class="btn btn-default add-to-cart" data-id_product="{{$product->product_id}}" name="add-to-cart">
                                                    <input type="button" data-toggle="modal" data-target="#xemnhanh" value="Xem nhanh" class="btn btn-default xemnhanh" data-id_product="{{$product->product_id}}" name="add-to-cart">

                                            </form>

                                        </div>

                                </div>

                                <div class="choose">
                                    <ul class="nav nav-pills nav-justified">
                                    <style type="text/css">
                                        ul.nav.nav-pills.nav-justified li{
                                            text-align: center;
                                            font-size: 13px;
                                        }
                                        .button_wishlist{
                                            border: none;
                                            background: #ffff;
                                            color: #B3AFA8;
                                        }
                                        ul.nav.nav-pills.nav-justified{
                                            color: #B3AFA8;
                                        }
                                        .button_wishlist span:hover{
                                            color: #d70018;
                                        }
                                        .button_wishlist:focus{
                                            border:none;
                                            outline:none;
                                        }
                                    </style>
                                        <li>
                                            <i class="fa fa-plus-square"></i>
                                            <button class="button_wishlist" id="{{$product->product_id}}" onclick="add_wishlist(this.id);"><span>Yêu thích</span></button>
                                        </li>
                                        <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        </a>
                        @endforeach
                    </div><!--features_items-->
<!-- Modal xem nhanh -->
<div class="modal fade" id="xemnhanh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title product_quickview_title" id="">
                    <span id="product_quickview_title"></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <span id="product_quickview_image"></span>
                        <span id="product_quickview_gallery"></span>
                    </div>
                    <div class="col-md-7">
                            <style type="text/css">
                                span#product_quickview_content img {
                                    width: 100%;
                                }
                                @media screen and (min-width: 768px) {
                                        .modal-dialog {
                                            width: 700px;
                                        }
                                        .modal-sm {
                                            width: 350px;
                                        }
                                    }
                                        @media screen and (min-width: 992px) {
                                            .modal-lg {
                                                width: 1200px;
                                            }
                                        }

                            </style>

                            <h2><span id="product_quickview_title"></span></h2>
                            <p>Mã ID: <span id="product_quickview_id"></span></p>


                                <p style="color: #d70018 ; font-size: 20px; font-weight: bold">Giá sản phẩm: <span id="product_quickview_price"></span></p><br/>
                                <!--<label>Số lượng: </label>-->
                                <!--<input type="number" name="qty" min="1" class="cart_product_qty_" value="1" />-->
                                <!--<input name="product_hidden" type="hidden" value="" />-->

                            <h5 style="color: #d70018; font-size: 20px; font-weight: bold">Mô tả sản phẩm</h5>
                            <hr>
                                <p><span id="product_quickview_desc"></span></p>
                                <p><span id="product_quickview_content"></span><p>

                            <!-- <input type="button" value="Mua ngay" class="btn btn-primary btn-sm add-to-cart" name="add-to-cart"> -->

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <!-- <button type="button" class="btn btn-default">Đi tới giỏ hàng</button> -->
            </div>
        </div>
    </div>
</div>
<!-- End Modal xem nhanh -->
                   <ul class="pagination pagination-sm m-t-none m-b-none">
                       {!!$category_by_id->links()!!}
                    </ul>

        <!--/recommended_items-->
@endsection
