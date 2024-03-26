@extends('layouts.frontend.app')

@section('content')
    <section id="ts-features" class="ts-features pb-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="ts-service-box">
                        <div class="ts-service-image-wrapper">
                            <img loading="lazy" class="w-100"
                                src="{{ asset('/frontend_theme') }}/images/services/service1.jpg" alt="service-image">
                        </div>
                        <div class="d-flex">
                            <div class="ts-service-box-img">
                                <img loading="lazy" src="{{ asset('/frontend_theme') }}/images/icon-image/service-icon1.png"
                                    alt="service-icon">
                            </div>
                            <div class="ts-service-info">
                                <h3 class="service-box-title"><a href="service-single.html">Zero Harm Everyday</a></h3>
                                <p>You have ideas, goals, and dreams. We have a culturally diverse, forward thinking team
                                    looking for talent like. Lorem ipsum dolor suscipit.</p>
                                <a class="learn-more d-inline-block" href="service-single.html"
                                    aria-label="service-details"><i class="fa fa-caret-right"></i> Learn more</a>
                            </div>
                        </div>
                    </div><!-- Service1 end -->
                </div><!-- Col 1 end -->

                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="ts-service-box">
                        <div class="ts-service-image-wrapper">
                            <img loading="lazy" class="w-100"
                                src="{{ asset('/frontend_theme') }}/images/services/service2.jpg" alt="service-image">
                        </div>
                        <div class="d-flex">
                            <div class="ts-service-box-img">
                                <img loading="lazy" src="{{ asset('/frontend_theme') }}/images/icon-image/service-icon2.png"
                                    alt="service-icon">
                            </div>
                            <div class="ts-service-info">
                                <h3 class="service-box-title"><a href="service-single.html">Virtual Construction</a></h3>
                                <p>You have ideas, goals, and dreams. We have a culturally diverse, forward thinking team
                                    looking for talent like. Lorem ipsum dolor suscipit.</p>
                                <a class="learn-more d-inline-block" href="service-single.html"
                                    aria-label="service-details"><i class="fa fa-caret-right"></i> Learn more</a>
                            </div>
                        </div>
                    </div><!-- Service2 end -->
                </div><!-- Col 2 end -->

                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="ts-service-box">
                        <div class="ts-service-image-wrapper">
                            <img loading="lazy" class="w-100"
                                src="{{ asset('/frontend_theme') }}/images/services/service3.jpg" alt="service-image">
                        </div>
                        <div class="d-flex">
                            <div class="ts-service-box-img">
                                <img loading="lazy" src="{{ asset('/frontend_theme') }}/images/icon-image/service-icon3.png"
                                    alt="service-icon">
                            </div>
                            <div class="ts-service-info">
                                <h3 class="service-box-title"><a href="service-single.html">Build To Last</a></h3>
                                <p>You have ideas, goals, and dreams. We have a culturally diverse, forward thinking team
                                    looking for talent like. Lorem ipsum dolor suscipit.</p>
                                <a class="learn-more d-inline-block" href="service-single.html"
                                    aria-label="service-details"><i class="fa fa-caret-right"></i> Learn more</a>
                            </div>
                        </div>
                    </div><!-- Service3 end -->
                </div><!-- Col 3 end -->
            </div><!-- Content row end -->
        </div><!-- Container end -->
    </section>
@endsection
