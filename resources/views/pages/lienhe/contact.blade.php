@extends('layout')
@section('content')
<div class="features_items"><!--features_items-->
<h2 class="title text-center">Liên hệ với chúng tôi</h2>

                    <form action="#" method="post" class="tm-contact-form">
                        <div>
                            <div class="form-group">
                                <input type="text" id="contact_name" class="form-control rounded-0" placeholder="Họ và tên" />
                            </div>
                            <div class="form-group">
                                <input type="email" id="contact_email" class="form-control rounded-0" placeholder="Email" />
                            </div>
                            <div class="form-group">
                                <input type="text" id="contact_subject" class="form-control rounded-0" placeholder="Số điện thoại " />
                            </div>
                            <div class="form-group">
                                <textarea id="contact_message" class="form-control rounded-0" rows="6"
                                    placeholder="Nội dung"></textarea>
                            </div>
                            <div class="form-group">
                                <button class="tm-more-button" type="submit" name="submit">Gửi</button>
                            </div>
                        </div>


                        <div style="margin-top: 5%">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.651036532008!2d106.6800195148365!3d10.761354662414242!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f1b888ab357%3A0xc469f6e800231314!2zMjgwIEFuIEQuIFbGsMahbmcsIFBoxrDhu51uZyA0LCBRdeG6rW4gNSwgVGjDoG5oIHBo4buRIEjhu5MgQ2jDrSBNaW5oLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1605424636249!5m2!1svi!2s"
                        width="100%" height="400" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0">
                            </iframe>
                        </div>

                    </form>

</div>
@endsection
