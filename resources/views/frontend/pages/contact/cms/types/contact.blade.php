@php
$fb = config('app.fallback_locale', 'en');
$locale = app()->getLocale();
$st = $section->translation($locale) ?? $section->translation($fb);
$secTitle = $st?->title ?: __('Contact');
$secSubtitle = $st?->subtitle ?: __('Contact');
$secDescription = $st?->description ?: __('Contact description');
$items = $section->relationLoaded('items') ? $section->items->where('is_active', true)->sortBy('order')->values() :
collect();

@endphp


	<div class="space overflow-hidden" id="contact-sec">
        <div class="container">
            <div class="row gy-4">
                <div class="col-xl-4">
                    <div class="contact-media-wrap">
                        <div class="contact-media">
                            <div class="icon-btn">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="media-body">
                                <h5 class="box-title">Our Current Location</h5>
                                <p class="box-text">4517 Washington Ave. Manchester, Kentucky 39495. USA</p>
                            </div>
                        </div>
                        <div class="contact-media">
                            <div class="icon-btn">
                                <i class="fa-light fa-phone"></i>
                            </div>
                            <div class="media-body">
                                <h5 class="box-title">Phone Number</h5>
                                <p class="box-text">
                                    <a href="tel:+00123666000666">+00 (123) 666 000 666</a>
                                    <a href="tel:+00123888000222">+00 (123) 888 000 222</a>
                                </p>
                            </div>
                        </div>
                        <div class="contact-media">
                            <div class="icon-btn">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="media-body">
                                <h5 class="box-title">Email Address</h5>
                                <a href="mailto:info@examplemail.edu">info@examplemail.edu</a>
                                <a href="mailto:admission@examplemail.edu">admission@examplemail.edu</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <form action="mail.php" method="POST" class="contact-form ajax-contact">
                        <h3 class="h4 mb-30 mt-n3">Do you have questions? Contact Us</h3>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="name" id="name" placeholder=" {{ __('main.name') }}">
                                <i class="fal fa-user"></i>
                            </div>
                            <div class="form-group col-md-6">
                                <input type="tel" class="form-control" name="number" id="number" placeholder=" {{ __('main.phone_number') }}">
                                <i class="fal fa-phone"></i>
                            </div>
                            <div class="form-group col-12">
                                <input type="email" class="form-control" name="email" id="email" placeholder=" {{ __('main.email_address') }}">
                                <i class="fal fa-envelope"></i>
                            </div>

                            <div class="form-group col-12">
                                <select name="subject" id="subject" class="form-select nice-select">
                                    <option value="" disabled selected hidden> {{ __('main.select') }}</option>
                                    <option value="General Medicinet"> {{ __('main.general_medicine') }}</option>
                                    <option value="Heart Specialists"> {{ __('main.heart_specialists') }}</option>
                                    <option value="Skin & Hair Specialists"> {{ __('main.skin_hair_specialists') }}</option>
                                    <option value="Child Specialists"> {{ __('main.child_specialists') }}</option>
                                </select>
                            </div>
                            <div class="form-group col-12">
                                <textarea name="message" id="message" cols="30" rows="3" class="form-control" placeholder=" {{ __('main.your_message') }}"></textarea>
                                <i class="fal fa-comment"></i>
                            </div>
                            <div class="form-btn mt-20 col-12">
                                <button class="th-btn"> {{ __('main.send_message') }}</button>
                            </div>
                        </div>
                        <p class="form-messages mb-0 mt-3"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
	
 <div class="">
        <div class="contact-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3644.7310056272386!2d89.2286059153658!3d24.00527418490799!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39fe9b97badc6151%3A0x30b048c9fb2129bc!2sAngfuztheme!5e0!3m2!1sen!2sbd!4v1651028958211!5m2!1sen!2sbd" allowfullscreen="" loading="lazy"></iframe>
            <div class="contact-icon">
                <img src="assets/img/icon/location-dot.svg" alt="">
            </div>
        </div>
    </div>