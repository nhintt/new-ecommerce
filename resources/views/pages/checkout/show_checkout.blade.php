@extends('layout')
@section('content')

<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li class="active">Thanh toán giỏ hàng</li>
				</ol>
			</div>

			<div class="register-req">
				<p>Làm ơn đăng ký hoặc đăng nhập để thanh toán giỏ hàng và xem lại lịch sử mua hàng</p>
			</div><!--/register-req-->

			<div class="shopper-informations">
				<div class="row">

					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<p>Điền thông tin gửi hàng</p>
							<div class="form-one">
								<form method="POST">
									@csrf
									<input type="text" name="shipping_email" class="shipping_email" placeholder="Điền email">
									<input type="text" name="shipping_name" class="shipping_name" placeholder="Họ và tên người gửi">
									<input type="text" name="shipping_address" class="shipping_address" placeholder="Địa chỉ gửi hàng">
									<input type="text" name="shipping_phone" class="shipping_phone" placeholder="Số điện thoại">
									<textarea name="shipping_notes" class="shipping_notes" placeholder="Ghi chú đơn hàng của bạn" rows="5"></textarea>

									@if(Session::get('fee'))
										<input type="hidden" name="order_fee" class="order_fee" value="{{Session::get('fee')}}">
									@else
										<input type="hidden" name="order_fee" class="order_fee" value="10000">
									@endif

									@if(Session::get('coupon'))
										@foreach(Session::get('coupon') as $key => $cou)
											<input type="hidden" name="order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
										@endforeach
									@else
										<input type="hidden" name="order_coupon" class="order_coupon" value="no">
									@endif



									<div class="">
										 <div class="form-group">
		                                    <label for="exampleInputPassword1">Chọn hình thức thanh toán</label>
		                                      <select name="shipping_method"  class="form-control input-sm m-bot15 shipping_method">
		                                            <option value="0">COD</option>
                                                    <option value="1">Paypal</option>
                                                    <option value="2">Ngân lượng</option>
		                                    </select>
		                                </div>
									</div>

									<input type="button" value="Xác nhận đơn hàng" name="send_order" class="btn btn-primary btn-sm send_order">
								</form>

							</div>

						</div>
					</div>
					<div class="col-sm-12 clearfix">
						  @if(session()->has('message'))
			                    <div class="alert alert-success">
			                        {!! session()->get('message') !!}
			                    </div>
			                @elseif(session()->has('error'))
			                     <div class="alert alert-danger">
			                        {!! session()->get('error') !!}
			                    </div>
			                @endif
						<div class="table-responsive cart_info">

							<form action="{{url('/update-cart')}}" method="POST">
								@csrf
							<table class="table table-condensed">
								<thead>
									<tr class="cart_menu">
										<td class="image">Hình ảnh</td>
										<td class="description">Tên sản phẩm</td>
										<td class="price">Giá sản phẩm</td>
										<td class="quantity">Số lượng</td>
										<td class="total">Thành tiền</td>
										<td></td>
									</tr>
								</thead>
								<tbody>
									@if(Session::get('cart')==true)
									@php
											$total = 0;
											$itemList = array();
									@endphp
									@foreach(Session::get('cart') as $key => $cart)
										@php
											$subtotal = $cart['product_price']*$cart['product_qty'];
											$total+=$subtotal;
											$thisPriceToUSD = round($cart['product_price']/23200,2);
										@endphp
										<?php
											$subunit = ['value'=>$thisPriceToUSD.'','currency_code'=>'USD'];
											$item = ['name'=>$cart['product_name'],'unit_amount'=>$subunit,'quantity'=>$cart['product_qty'] ];
											array_push($itemList,$item);

										?>

									<tr>
										<td class="cart_product">
											<img src="{{asset('public/uploads/product/'.$cart['product_image'])}}" width="90" alt="{{$cart['product_name']}}" />
										</td>
										<td class="cart_description">
											<h4><a href=""></a></h4>
											<p>{{$cart['product_name']}}</p>
										</td>
										<td class="cart_price">
											<p>{{number_format($cart['product_price'],0,',','.')}}đ</p>
										</td>
										<td class="cart_quantity">
											<div class="cart_quantity_button">


												<input class="cart_quantity" type="number" min="1" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}"  >


											</div>
										</td>
										<td class="cart_total">
											<p class="cart_total_price">
												{{number_format($subtotal,0,',','.')}}đ

											</p>
										</td>
										<td class="cart_delete">
											<a class="cart_quantity_delete" href="{{url('/del-product/'.$cart['session_id'])}}"><i class="fa fa-times"></i></a>
										</td>
									</tr>

									@endforeach
									<tr>
										<td><input type="submit" value="Cập nhật giỏ hàng" name="update_qty" class="check_out btn btn-default btn-sm"></td>
										<td><a class="btn btn-default check_out" href="{{url('/del-all-product')}}">Xóa tất cả</a></td>
										<td>
											@if(Session::get('coupon'))
				                          	<a class="btn btn-default check_out" href="{{url('/unset-coupon')}}">Xóa mã khuyến mãi</a>
											@endif
										</td>


										<td colspan="2">
										<li>Tổng tiền :<span>{{number_format($total,0,',','.')}}đ</span></li>
										@if(Session::get('coupon'))
										<li>

												@foreach(Session::get('coupon') as $key => $cou)
													@if($cou['coupon_condition']==1)
														Mã giảm : {{$cou['coupon_number']}} %
														<p>
															@php
															$total_coupon = ($total*$cou['coupon_number'])/100;

															@endphp
														</p>
														<p>
														@php
															$total_after_coupon = $total-$total_coupon;
														@endphp
														</p>
													@elseif($cou['coupon_condition']==2)
														Mã giảm : {{number_format($cou['coupon_number'],0,',','.')}} k
														<p>
															@php
															$total_coupon = $total - $cou['coupon_number'];

															@endphp
														</p>
														@php
															$total_after_coupon = $total_coupon;
														@endphp
													@endif
												@endforeach



										</li>
										@endif

										@if(Session::get('fee'))
										<li>
											<a class="cart_quantity_delete" href="{{url('/del-fee')}}"><i class="fa fa-times"></i></a>

											Phí vận chuyển <span>{{number_format(Session::get('fee'),0,',','.')}}đ</span></li>
											<?php $total_after_fee = $total + Session::get('fee'); ?>
										@endif
										<li>Tổng còn:
										@php
											if(Session::get('fee') && !Session::get('coupon')){
												$total_after = $total_after_fee;
												echo number_format($total_after,0,',','.').'đ';
											}elseif(!Session::get('fee') && Session::get('coupon')){
												$total_after = $total_after_coupon;
												echo number_format($total_after,0,',','.').'đ';
											}elseif(Session::get('fee') && Session::get('coupon')){
												$total_after = $total_after_coupon;
												$total_after = $total_after + Session::get('fee');
												echo number_format($total_after,0,',','.').'đ';
											}elseif(!Session::get('fee') && !Session::get('coupon')){
												$total_after = $total;
												echo number_format($total_after,0,',','.').'đ';
											}



										@endphp
										<div id="smart-button-container">
											<div style="text-align: center;">
											  <div id="paypal-button-container"></div>
											</div>
										  </div>
                                            <!-- Paypal -->
										<script src="https://www.paypal.com/sdk/js?client-id=AVygrTpVjXIDJKIEVU8JV37gni6-E0a-8lyTkEikYac46fQVLb-sQAF2ESbibX-NYRcv-MsUyMH78uvP&currency=USD" data-sdk-integration-source="button-factory"></script>
										<script>
										  function initPayPalButton() {

											var gia = <?=json_encode($total_after)?>;
											var list = <?=json_encode($itemList)?>;
											var totalToUSD  =(gia/23200).toFixed(2)+"";
											console.log(list);
											console.log((gia/23200).toFixed(2));

											paypal.Buttons({
											  style: {
												shape: 'pill',
												color: 'gold',
												layout: 'vertical',
												label: 'paypal',

											  },

											  createOrder: function(data, actions) {
												return actions.order.create({
													purchase_units: [{
														amount: {
															value: totalToUSD,
															currency_code: 'USD',
															breakdown: {
																item_total: {value: totalToUSD, currency_code: 'USD'}
															}
														},
														items:list

													}]
												}
												);
											  },

											  onApprove: function(data, actions) {
												return actions.order.capture().then(function(details) {
                                                  alert('Giao dịch được hoàn thành bởi ' + details.payer.name.given_name + '!');
                                                  var shipping_email = $('.shipping_email').val();
                                                  var shipping_name = $('.shipping_name').val();
                                                  var shipping_address = $('.shipping_address').val();
                                                  var shipping_phone = $('.shipping_phone').val();
                                                  var shipping_notes = $('.shipping_notes').val();
                                                  var shipping_method = $('.shipping_method').val();
                                                  var order_fee = $('.order_fee').val();
                                                  var order_coupon = $('.order_coupon').val();
                                                  var _token = $('input[name="_token"]').val();

                                                  $.ajax({
                                                      url: '{{url('/confirm-order')}}',
                                                      method: 'POST',
                                                      data:{shipping_email:shipping_email,shipping_name:shipping_name,shipping_address:shipping_address,shipping_phone:shipping_phone,shipping_notes:shipping_notes,_token:_token,order_fee:order_fee,order_coupon:order_coupon,shipping_method:shipping_method},
                                                      success:function(){
                                                         swal("Đơn hàng", "Đơn hàng của bạn đã được gửi thành công", "success");
                                                      }
                                                  });

                                                  window.setTimeout(function(){
                                                      location.reload();
                                                  } ,3000);
												});
											  },

											  onError: function(err) {
												console.log(err);
											  }
											}).render('#paypal-button-container');
										  }
										  initPayPalButton();
										</script>
										<!-- End Paypal -->

										</li>

									</td>
									</tr>
									@else
									<tr>
										<td colspan="5"><center>
										@php
										echo 'Làm ơn thêm sản phẩm vào giỏ hàng';
										@endphp
										</center></td>
									</tr>
									@endif
								</tbody>



							</form>
								@if(Session::get('cart'))
								<tr><td>

										<form method="POST" action="{{url('/check-coupon')}}">
											@csrf
												<input type="text" class="form-control" name="coupon" placeholder="Nhập mã giảm giá"><br>
				                          		<input type="submit" class="btn btn-default check_coupon" name="check_coupon" value="Tính mã giảm giá">

			                          		</form>
			                          	</td>
								</tr>
								@endif

							</table>

						</div>
					</div>

				</div>
            </div>
            <div>

                <div class="container">
                    <div class="header clearfix">
                        <h3 class="text-muted">Thanh toán với Vnpay</h3>
                    </div>
                    <h3>Xác Nhận đơn hàng</h3>
                    <div class="table-responsive">
                        <form action="/vnpay_php/vnpay_create_payment.php" id="create_form" method="post">

                            <div class="form-group">
                                <label for="language"></label>
                                <select name="order_type" id="order_type" class="form-control">
                                    <option value="topup">Thanh toán</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="order_id">Mã hóa đơn</label>
                                <input class="form-control" id="order_id" name="order_id" type="text" value="<?php echo date("YmdHis") ?>" />
                            </div>
                            <div class="form-group">

                                <label for="amount">Tổng tiền</label>
                                <input class="form-control" id="amount"
                                       name="amount" type="number" value="10000" />

                            </div>
                            <div class="form-group">
                                <label for="order_desc">Ghi Chú</label>
                                <textarea class="form-control" cols="20" id="order_desc" name="order_desc" rows="2">Nội dung</textarea>
                            </div>
                            <div class="form-group">
                                <label for="bank_code">Ngân hàng</label>
                                <select name="bank_code" id="bank_code" class="form-control">
                                    <option value="">Không chọn</option>
                                    <option value="NCB"> Ngan hang NCB</option>
                                    <option value="AGRIBANK"> Ngan hang Agribank</option>
                                    <option value="SCB"> Ngan hang SCB</option>
                                    <option value="SACOMBANK">Ngan hang SacomBank</option>
                                    <option value="EXIMBANK"> Ngan hang EximBank</option>
                                    <option value="MSBANK"> Ngan hang MSBANK</option>
                                    <option value="NAMABANK"> Ngan hang NamABank</option>
                                    <option value="VNMART"> Vi dien tu VnMart</option>
                                    <option value="VIETINBANK">Ngan hang Vietinbank</option>
                                    <option value="VIETCOMBANK"> Ngan hang VCB</option>
                                    <option value="HDBANK">Ngan hang HDBank</option>
                                    <option value="DONGABANK"> Ngan hang Dong A</option>
                                    <option value="TPBANK"> Ngân hàng TPBank</option>
                                    <option value="OJB"> Ngân hàng OceanBank</option>
                                    <option value="BIDV"> Ngân hàng BIDV</option>
                                    <option value="TECHCOMBANK"> Ngân hàng Techcombank</option>
                                    <option value="VPBANK"> Ngan hang VPBank</option>
                                    <option value="MBBANK"> Ngan hang MBBank</option>
                                    <option value="ACB"> Ngan hang ACB</option>
                                    <option value="OCB"> Ngan hang OCB</option>
                                    <option value="IVB"> Ngan hang IVB</option>
                                    <option value="VISA"> Thanh toan qua VISA/MASTER</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="language">Ngôn ngữ</label>
                                <select name="language" id="language" class="form-control">
                                    <option value="vn">Tiếng Việt</option>
                                    <option value="en">English</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary send_order" id="btnPopup" >Thanh toán </button>
                            <input type="submit" value="Xác nhận đơn hàng" name="send_order" id="btnPopup"  class="btn btn-primary btn-sm send_order">

                        </form>
                    </div>

                </div>
                <link href="https://sandbox.vnpayment.vn/paymentv2/lib/vnpay/vnpay.css" rel="stylesheet"/>
                <script src="https://sandbox.vnpayment.vn/paymentv2/lib/vnpay/vnpay.js"></script>
                <script type="text/javascript">
                    $("#btnPopup").click(function () {
                        var postData = $("#create_form").serialize();
                        var submitUrl = $("#create_form").attr("action");
                        return redirect::to($url);
                        $.ajax({
                            type: "POST",
                            url: submitUrl,
                            data: postData,
                            dataType: 'JSON',
                            success: function (x) {
                                if (x.code === '00') {
                                    if (window.vnpay) {
                                        vnpay.open({width: 768, height: 600, url: x.data});
                                    } else {
                                        location.href = x.data;
                                    }
                                    return false;
                                } else {
                                    alert(x.Message);
                                }
                            }
                        });
                        return false;
                    });
                </script>


            </div>




		</div>
	</section> <!--/#cart_items-->

@endsection
