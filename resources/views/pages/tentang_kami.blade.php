@extends('layouts.frontend.app')

@section('content')
    <section id="main-container" class="main-container">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h3 class="section-sub-title">{{ $title ?? '-' }}</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <h3 class="column-title">Who We Are</h3>
                    <p>when Gregor Samsa woke from troubled dreams, he found himself transformed in his bed into a horrible
                        vermin.</p>
                    <blockquote>
                        <p>Semporibus autem quibusdam et aut officiis debitis aut rerum est aut optio cumque nihil
                            necessitatibus autemn ec tincidunt nunc posuere ut</p>
                    </blockquote>
                    <p>He lay on his armour-like back, and if he lifted. ultrices ultrices sapien, nec tincidunt nunc
                        posuere ut. Lorem ipsum dolor sit amet, consectetur adipiscing elit. If you are going to use a
                        passage of Lorem Ipsum, you need to be sure there isn’t anything embarrassing.</p>

                </div><!-- Col end -->

                <div class="col-lg-6 mt-5 mt-lg-0">

                    <div id="page-slider" class="page-slider small-bg slick-initialized slick-slider"><button type="button"
                            class="carousel-control left slick-arrow" aria-label="carousel-control" style=""><i
                                class="fas fa-chevron-left"></i></button>

                        <div class="slick-list draggable">
                            <div class="slick-track" style="opacity: 1; width: 1620px;">
                                <div class="item slick-slide"
                                    style="background-image: url(&quot;images/slider-pages/slide-page1.jpg&quot;); width: 540px; position: relative; left: 0px; top: 0px; z-index: 998; opacity: 0; transition: opacity 600ms ease 0s;"
                                    data-slick-index="0" aria-hidden="true" tabindex="0">
                                    <div class="container">
                                        <div class="box-slider-content">
                                            <div class="box-slider-text">
                                                <h2 class="box-slide-title">Leadership</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item slick-slide slick-current slick-active"
                                    style="background-image: url(&quot;images/slider-pages/slide-page2.jpg&quot;); width: 540px; position: relative; left: -540px; top: 0px; z-index: 1000; opacity: 1; transition: opacity 600ms ease 0s;"
                                    data-slick-index="1" aria-hidden="false" tabindex="-1">
                                    <div class="container">
                                        <div class="box-slider-content">
                                            <div class="box-slider-text">
                                                <h2 class="box-slide-title">Relationships</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item slick-slide"
                                    style="background-image: url(&quot;images/slider-pages/slide-page3.jpg&quot;); width: 540px; position: relative; left: -1080px; top: 0px; z-index: 998; opacity: 0; transition: opacity 600ms ease 0s;"
                                    data-slick-index="2" aria-hidden="true" tabindex="-1">
                                    <div class="container">
                                        <div class="box-slider-content">
                                            <div class="box-slider-text">
                                                <h2 class="box-slide-title">Performance</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- Item 1 end -->

                        <!-- Item 1 end -->

                        <!-- Item 1 end -->
                        <button type="button" class="carousel-control right slick-arrow" aria-label="carousel-control"
                            style=""><i class="fas fa-chevron-right"></i></button>
                    </div><!-- Page slider end-->


                </div><!-- Col end -->
            </div><!-- Content row end -->

        </div><!-- Container end -->
    </section>
@endsection
