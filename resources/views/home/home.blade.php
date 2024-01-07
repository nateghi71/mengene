@extends('layouts.home')

@section('title' , 'منگنه')

@section('head')
@endsection

@section('scripts')
@endsection

@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
        <div class="container" id="home">
            <div class="row">
                <div
                    class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                    data-aos="fade-up"
                    data-aos-delay="200"
                >
                    <h1>مِنگِنه دستیاری حرفه ای برای خرید، فروش و اجاره ملک</h1>
                    <h2>ابزاری مفید و کاربردی برای <span class="fw-bold">املاکی های</span> سراسر کشور
                        <p>  - با داشتن نرم افزار قدرتمند و همیشه همراه !</p>

                    </h2>
                    <div class="d-flex justify-content-center justify-content-lg-start">
                        <a href="{{route('2fa.enter_number')}}" class="btn-get-started scrollto">ثبت نام</a>
                        <a href="https://98diha.ir//wp-content/themes/ringtone/api/mengene.apk" target="_blank"
                           class="btn-watch-video m-2">
                            <i class="mdi mdi-android"></i>
                            <h5 class="m-1" >نرم افزار اندروید</h5></a>
{{--                                            glightbox--}}
                    </div>
                </div>
                <div
                    class="col-lg-6 order-1 order-lg-2 hero-img"
                    data-aos="zoom-in"
                    data-aos-delay="100"
                >
                    <img
                        src="{{asset('Home/assets/img/4310987.png')}}"
                        class="img-fluid animated"
                        alt=""
                    />
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero -->

    <main id="main">
        <!-- ======= Clients Section ======= -->
        <!-- <section id="clients" class="clients section-bg">
        <div class="container">

          <div class="row" data-aos="zoom-in">

            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
              <img src="assets/img/clients/client-1.png" class="img-fluid" alt="">
            </div>

            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
              <img src="assets/img/clients/client-2.png" class="img-fluid" alt="">
            </div>

            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
              <img src="assets/img/clients/client-3.png" class="img-fluid" alt="">
            </div>

            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
              <img src="assets/img/clients/client-4.png" class="img-fluid" alt="">
            </div>

            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
              <img src="assets/img/clients/client-5.png" class="img-fluid" alt="">
            </div>

            <div class="col-lg-2 col-md-4 col-6 d-flex align-items-center justify-content-center">
              <img src="assets/img/clients/client-6.png" class="img-fluid" alt="">
            </div>

          </div>

        </div>
      </section>End Cliens Section -->

        <!-- ======= About Us Section ======= -->
        {{--    <section id="about" class="about">--}}
        {{--    <div class="container" data-aos="fade-up">--}}

        {{--      <div class="section-title">--}}
        {{--        <h2>About Us</h2>--}}
        {{--      </div>--}}

        {{--      <div class="row content">--}}
        {{--        <div class="col-lg-6">--}}
        {{--          <p>--}}
        {{--            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore--}}
        {{--            magna aliqua.--}}
        {{--          </p>--}}
        {{--          <ul>--}}
        {{--            <li><i class="ri-check-double-line"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat</li>--}}
        {{--            <li><i class="ri-check-double-line"></i> Duis aute irure dolor in reprehenderit in voluptate velit</li>--}}
        {{--            <li><i class="ri-check-double-line"></i> Ullamco laboris nisi ut aliquip ex ea commodo consequat</li>--}}
        {{--          </ul>--}}
        {{--        </div>--}}
        {{--        <div class="col-lg-6 pt-4 pt-lg-0">--}}
        {{--          <p>--}}
        {{--            Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate--}}
        {{--            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in--}}
        {{--            culpa qui officia deserunt mollit anim id est laborum.--}}
        {{--          </p>--}}
        {{--          <a href="#" class="btn-learn-more">Learn More</a>--}}
        {{--        </div>--}}
        {{--      </div>--}}

        {{--    </div>--}}
        {{--  </section>--}}
        {{--    End About Us Section--}}

        <!-- ======= Why Us Section ======= -->
        <!-- <section id="why-us" class="why-us section-bg">
        <div class="container-fluid" data-aos="fade-up">

          <div class="row">

            <div class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch  order-2 order-lg-1">

              <div class="content">
                <h3>Eum ipsam laborum deleniti <strong>velit pariatur architecto aut nihil</strong></h3>
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Duis aute irure dolor in reprehenderit
                </p>
              </div>

              <div class="accordion-list">
                <ul>
                  <li>
                    <a data-bs-toggle="collapse" class="collapse" data-bs-target="#accordion-list-1"><span>01</span> Non consectetur a erat nam at lectus urna duis? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                    <div id="accordion-list-1" class="collapse show" data-bs-parent=".accordion-list">
                      <p>
                        Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
                      </p>
                    </div>
                  </li>

                  <li>
                    <a data-bs-toggle="collapse" data-bs-target="#accordion-list-2" class="collapsed"><span>02</span> Feugiat scelerisque varius morbi enim nunc? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                    <div id="accordion-list-2" class="collapse" data-bs-parent=".accordion-list">
                      <p>
                        Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id interdum velit laoreet id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec pretium. Est pellentesque elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa tincidunt dui.
                      </p>
                    </div>
                  </li>

                  <li>
                    <a data-bs-toggle="collapse" data-bs-target="#accordion-list-3" class="collapsed"><span>03</span> Dolor sit amet consectetur adipiscing elit? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                    <div id="accordion-list-3" class="collapse" data-bs-parent=".accordion-list">
                      <p>
                        Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci. Faucibus pulvinar elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit. Rutrum tellus pellentesque eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at elementum eu facilisis sed odio morbi quis
                      </p>
                    </div>
                  </li>

                </ul>
              </div>

            </div>

            <div class="col-lg-5 align-items-stretch order-1 order-lg-2 img" style='background-image: url("assets/img/why-us.png");' data-aos="zoom-in" data-aos-delay="150">&nbsp;</div>
          </div>

        </div>
      </section>End Why Us Section -->

        <!-- ======= Skills Section ======= -->
        <!-- <section id="skills" class="skills">
        <div class="container" data-aos="fade-up">

          <div class="row">
            <div class="col-lg-6 d-flex align-items-center" data-aos="fade-right" data-aos-delay="100">
              <img src="assets/img/skills.png" class="img-fluid" alt="">
            </div>
            <div class="col-lg-6 pt-4 pt-lg-0 content" data-aos="fade-left" data-aos-delay="100">
              <h3>Voluptatem dignissimos provident quasi corporis voluptates</h3>
              <p class="fst-italic">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
                magna aliqua.
              </p>

              <div class="skills-content">

                <div class="progress">
                  <span class="skill">HTML <i class="val">100%</i></span>
                  <div class="progress-bar-wrap">
                    <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>

                <div class="progress">
                  <span class="skill">CSS <i class="val">90%</i></span>
                  <div class="progress-bar-wrap">
                    <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>

                <div class="progress">
                  <span class="skill">JavaScript <i class="val">75%</i></span>
                  <div class="progress-bar-wrap">
                    <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>

                <div class="progress">
                  <span class="skill">Photoshop <i class="val">55%</i></span>
                  <div class="progress-bar-wrap">
                    <div class="progress-bar" role="progressbar" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>

              </div>

            </div>
          </div>

        </div>
      </section>End Skills Section -->

        <!-- ======= Services Section ======= -->
        <section id="services" class="services section-bg">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>سرویس ها</h2>
                    <p>
                        با مِنگِنه دیگر فرصت های پولسازی را از دست ندهید!
                    </p>
                </div>

                <div class="row">
                    <div
                        class="col-xl-3 col-md-6 d-flex align-items-stretch"
                        data-aos="zoom-in"
                        data-aos-delay="100"
                    >
                        <div class="icon-box w-100">
                            <div class="icon"><i class="mdi mdi-account-plus"></i></div>
                            <h4>ثبت اطلاعات متقاضی</h4>
                            <p>برای پیدا کردن خانه(رهن و خرید)</p>
                        </div>
                    </div>

                    <div
                        class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-md-0"
                        data-aos="zoom-in"
                        data-aos-delay="200"
                    >
                        <div class="icon-box w-100">
                            <div class="icon"><i class="mdi mdi-home"></i></div>
                            <h4>ثبت اطلاعات ملک</h4>
                            <p>داشتن بانک اطلاعاتی از املاک</p>
                        </div>
                    </div>

                    <div
                        class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0"
                        data-aos="zoom-in"
                        data-aos-delay="300"
                    >
                        <div class="icon-box w-100">
                            <div class="icon"><i class="mdi mdi-message"></i></div>
                            <h4>سامانه پیامکی</h4>
                            <p>با هر ثبت مشتری پیامکی برای تایید ارسال میشود</p>
                        </div>
                    </div>

                    <div
                        class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0"
                        data-aos="zoom-in"
                        data-aos-delay="400"
                    >
                        <div class="icon-box w-100">
                            <div class="icon"><i class="mdi mdi-account-multiple"></i></div>
                            <h4>مدیریت مشاورین</h4>
                            <p>مشاهده اطلاعات ثبتی از طرف مشاورین و ...</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Services Section -->

        <!-- ======= Cta Section ======= -->
        <section id="cta" class="cta">
            <div class="container" data-aos="zoom-in">
                <div class="row">
                    <div class="col-lg-9 text-center text-lg-start">
                        <!-- <h3> مِنگِنه</h3>
                      <p>کاوش کنید، ملک را پیدا کنید، خانه رویایی خود را بسازید</p> -->
                    </div>
                    <div class="col-lg-3 cta-btn-container text-center">
                        <!-- <a class="cta-btn align-middle" href="#">شروع کنید</a> -->
                    </div>
                </div>
            </div>
        </section>
        <!-- End Cta Section -->

        <!-- ======= Portfolio Section ======= -->
        <!-- <section id="portfolio" class="portfolio">
        <div class="container" data-aos="fade-up">

          <div class="section-title">
            <h2>Portfolio</h2>
            <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
          </div>

          <ul id="portfolio-flters" class="d-flex justify-content-center" data-aos="fade-up" data-aos-delay="100">
            <li data-filter="*" class="filter-active">All</li>
            <li data-filter=".filter-app">App</li>
            <li data-filter=".filter-card">Card</li>
            <li data-filter=".filter-web">Web</li>
          </ul>

          <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

            <div class="col-lg-4 col-md-6 portfolio-item filter-app">
              <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-1.jpg" class="img-fluid" alt=""></div>
              <div class="portfolio-info">
                <h4>App 1</h4>
                <p>App</p>
                <a href="assets/img/portfolio/portfolio-1.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 1"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item filter-web">
              <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-2.jpg" class="img-fluid" alt=""></div>
              <div class="portfolio-info">
                <h4>Web 3</h4>
                <p>Web</p>
                <a href="assets/img/portfolio/portfolio-2.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Web 3"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item filter-app">
              <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-3.jpg" class="img-fluid" alt=""></div>
              <div class="portfolio-info">
                <h4>App 2</h4>
                <p>App</p>
                <a href="assets/img/portfolio/portfolio-3.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 2"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item filter-card">
              <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-4.jpg" class="img-fluid" alt=""></div>
              <div class="portfolio-info">
                <h4>Card 2</h4>
                <p>Card</p>
                <a href="assets/img/portfolio/portfolio-4.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Card 2"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item filter-web">
              <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-5.jpg" class="img-fluid" alt=""></div>
              <div class="portfolio-info">
                <h4>Web 2</h4>
                <p>Web</p>
                <a href="assets/img/portfolio/portfolio-5.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Web 2"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item filter-app">
              <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-6.jpg" class="img-fluid" alt=""></div>
              <div class="portfolio-info">
                <h4>App 3</h4>
                <p>App</p>
                <a href="assets/img/portfolio/portfolio-6.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="App 3"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item filter-card">
              <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-7.jpg" class="img-fluid" alt=""></div>
              <div class="portfolio-info">
                <h4>Card 1</h4>
                <p>Card</p>
                <a href="assets/img/portfolio/portfolio-7.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Card 1"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item filter-card">
              <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-8.jpg" class="img-fluid" alt=""></div>
              <div class="portfolio-info">
                <h4>Card 3</h4>
                <p>Card</p>
                <a href="assets/img/portfolio/portfolio-8.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Card 3"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>

            <div class="col-lg-4 col-md-6 portfolio-item filter-web">
              <div class="portfolio-img"><img src="assets/img/portfolio/portfolio-9.jpg" class="img-fluid" alt=""></div>
              <div class="portfolio-info">
                <h4>Web 3</h4>
                <p>Web</p>
                <a href="assets/img/portfolio/portfolio-9.jpg" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="Web 3"><i class="bx bx-plus"></i></a>
                <a href="portfolio-details.html" class="details-link" title="More Details"><i class="bx bx-link"></i></a>
              </div>
            </div>

          </div>

        </div>
      </section>End Portfolio Section -->

        <!-- ======= Team Section ======= -->
        <!-- <section id="team" class="team section-bg">
        <div class="container" data-aos="fade-up">

          <div class="section-title">
            <h2>Team</h2>
            <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p>
          </div>

          <div class="row">

            <div class="col-lg-6" data-aos="zoom-in" data-aos-delay="100">
              <div class="member d-flex align-items-start">
                <div class="pic"><img src="assets/img/team/team-1.jpg" class="img-fluid" alt=""></div>
                <div class="member-info">
                  <h4>Walter White</h4>
                  <span>Chief Executive Officer</span>
                  <p>Explicabo voluptatem mollitia et repellat qui dolorum quasi</p>
                  <div class="social">
                    <a href=""><i class="ri-twitter-fill"></i></a>
                    <a href=""><i class="ri-facebook-fill"></i></a>
                    <a href=""><i class="ri-instagram-fill"></i></a>
                    <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6 mt-4 mt-lg-0" data-aos="zoom-in" data-aos-delay="200">
              <div class="member d-flex align-items-start">
                <div class="pic"><img src="assets/img/team/team-2.jpg" class="img-fluid" alt=""></div>
                <div class="member-info">
                  <h4>Sarah Jhonson</h4>
                  <span>Product Manager</span>
                  <p>Aut maiores voluptates amet et quis praesentium qui senda para</p>
                  <div class="social">
                    <a href=""><i class="ri-twitter-fill"></i></a>
                    <a href=""><i class="ri-facebook-fill"></i></a>
                    <a href=""><i class="ri-instagram-fill"></i></a>
                    <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6 mt-4" data-aos="zoom-in" data-aos-delay="300">
              <div class="member d-flex align-items-start">
                <div class="pic"><img src="assets/img/team/team-3.jpg" class="img-fluid" alt=""></div>
                <div class="member-info">
                  <h4>William Anderson</h4>
                  <span>CTO</span>
                  <p>Quisquam facilis cum velit laborum corrupti fuga rerum quia</p>
                  <div class="social">
                    <a href=""><i class="ri-twitter-fill"></i></a>
                    <a href=""><i class="ri-facebook-fill"></i></a>
                    <a href=""><i class="ri-instagram-fill"></i></a>
                    <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6 mt-4" data-aos="zoom-in" data-aos-delay="400">
              <div class="member d-flex align-items-start">
                <div class="pic"><img src="assets/img/team/team-4.jpg" class="img-fluid" alt=""></div>
                <div class="member-info">
                  <h4>Amanda Jepson</h4>
                  <span>Accountant</span>
                  <p>Dolorum tempora officiis odit laborum officiis et et accusamus</p>
                  <div class="social">
                    <a href=""><i class="ri-twitter-fill"></i></a>
                    <a href=""><i class="ri-facebook-fill"></i></a>
                    <a href=""><i class="ri-instagram-fill"></i></a>
                    <a href=""> <i class="ri-linkedin-box-fill"></i> </a>
                  </div>
                </div>
              </div>
            </div>

          </div>

        </div>
      </section>End Team Section -->

        <!-- ======= Pricing Section ======= -->
        <section id="pricing" class="pricing">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>تعرفه ها</h2>
                    <!-- <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p> -->
                </div>

                <div class="row">
                    <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="box">
                            <h3>رایگان</h3>
                            <!-- <h4><sup>$</sup>0<span>per month</span></h4> -->
                            <ul>
                                <li><i class="mdi mdi-check"></i> ثبت اطلاعات متقاضی</li>
                                <li><i class="mdi mdi-check"></i>ثبت اطلاعات ملک</li>
                                <li class="na">
                                    <i class="mdi mdi-check"></i> <span>سامانه پیامکی</span>
                                </li>
                                <li class="na">
                                    <i class="mdi mdi-check"></i> <span>مدیریت مشاورین</span>
                                </li>
                            </ul>
{{--                            <a href="{{route('2fa.enter_number')}}" class="buy-btn">پلن فعلی</a>--}}
                        </div>
                    </div>

                    <div
                        class="col-lg-4 mt-4 mt-lg-0"
                        data-aos="fade-up"
                        data-aos-delay="200"
                    >
                        <div class="box featured">
                            <h3>سالانه 899 تومان</h3>
                            <!-- <h4><sup>$</sup>29<span>per month</span></h4> -->
                            <ul>
                                <li><i class="mdi mdi-check"></i> ثبت اطلاعات متقاضی</li>
                                <li><i class="mdi mdi-check"></i> ثبت اطلاعات ملک</li>
                                <li><i class="mdi mdi-check"></i> سامانه پیامکی(نامحدود)</li>
                                <li><i class="mdi mdi-check"></i>مدیریت مشاورین(نامحدود)</li>
                            </ul>
{{--                            <a href="{{route('2fa.enter_number' , ['level' => 'vip'])}}" class="buy-btn">شروع کنید</a>--}}
                        </div>
                    </div>

                    <div
                        class="col-lg-4 mt-4 mt-lg-0"
                        data-aos="fade-up"
                        data-aos-delay="300"
                    >
                        <div class="box">
                            <h3>سه ماهه 299 تومان</h3>
                            <!-- <h4><sup>$</sup>49<span>per month</span></h4> -->
                            <ul>
                                <li><i class="mdi mdi-check"></i> ثبت اطلاعات متقاضی</li>
                                <li><i class="mdi mdi-check"></i> ثبت اطلاعات ملک</li>
                                <li>
                                    <i class="mdi mdi-check"></i> سامانه پیامکی(تا سقف ماهانه 1000
                                    sms)
                                </li>
                                <li>
                                    <i class="mdi mdi-check"></i>مدیریت مشاورین(تا 4 عدد مشاور)
                                </li>
                            </ul>
{{--                            <a href="{{route('2fa.enter_number' , ['level' => 'midLevel'])}}" class="buy-btn">شروع کنید</a>--}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Pricing Section -->

        <!-- ======= Frequently Asked Questions Section ======= -->
        <section id="faq" class="faq section-bg">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>سوالات پر تکرار</h2>
                    <!-- <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p> -->
                </div>

                <div class="faq-list">
                    <ul>
                        <!-- <li data-aos="fade-up" data-aos-delay="100">
                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse" data-bs-target="#faq-list-1">Non consectetur a erat nam at lectus urna duis? <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i></a>
                        <div id="faq-list-1" class="collapse show" data-bs-parent=".faq-list">
                          <p>
                            Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus laoreet non curabitur gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus non.
                          </p>
                        </div>
                      </li> -->

                        <li data-aos="fade-up" data-aos-delay="200">
                            <i class="mdi mdi-help-circle icon-help"></i>
                            <a
                                data-bs-toggle="collapse"
                                data-bs-target="#faq-list-2"
                                class="collapsed"
                            >برای استفاده از چه امکاناتی می توانم رایگان ثبت نام کنم؟
                                <i class="mdi mdi-chevron-down icon-show"></i
                                ><i class="mdi mdi-chevron-up icon-close"></i
                                ></a>
                            <div
                                id="faq-list-2"
                                class="collapse"
                                data-bs-parent=".faq-list"
                            >
                                <p>
                                    شما املاکی عزیز برای استفاده از امکانات ثبت اطلاعات مشتری خود چه متقاضی خونه چه صاحب خونه میتوانید به صورت رایگان ثبت نام کنید و این اطلاعات را با مشاورین خود به اشتراک لحظه ای بگذارید!
                                </p>
                            </div>
                        </li>

                        <li data-aos="fade-up" data-aos-delay="300">
                            <i class="mdi mdi-help-circle icon-help"></i>
                            <a
                                data-bs-toggle="collapse"
                                data-bs-target="#faq-list-3"
                                class="collapsed"
                            >
                                سرویس های پولی شما شامل چه خدماتی است؟
                                <i class="mdi mdi-chevron-down icon-show"></i
                                ><i class="mdi mdi-chevron-up icon-close"></i
                                ></a>
                            <div
                                id="faq-list-3"
                                class="collapse"
                                data-bs-parent=".faq-list"
                            >
                                <p>
                                    کلیه خدمات پیامکی و تعداد مشاورین بستگی به تعرفه سرویس شما است!
                                </p>
                            </div>
                        </li>

                        <li data-aos="fade-up" data-aos-delay="400">
                            <i class="mdi mdi-help-circle icon-help"></i>
                            <a
                                data-bs-toggle="collapse"
                                data-bs-target="#faq-list-4"
                                class="collapsed"
                            >
                                چگونه می‌توانم مشاورین خود را مدیریت کنم؟
                                <i class="mdi mdi-chevron-down icon-show"></i
                                ><i class="mdi mdi-chevron-up icon-close"></i
                                ></a>
                            <div
                                id="faq-list-4"
                                class="collapse"
                                data-bs-parent=".faq-list"
                            >
                                <p>
                                    زمانی که یک مشاور بخواهد به املاکی شما پیوندد باید اول درخواست بدهد و بعد از تایید شما میتواند فایل های شما را ببیند
                                </p>
                            </div>
                        </li>

                        <li data-aos="fade-up" data-aos-delay="500">
                            <i class="mdi mdi-help-circle icon-help"></i>
                            <a
                                data-bs-toggle="collapse"
                                data-bs-target="#faq-list-5"
                                class="collapsed"
                            >چگونه می‌توانم به املاکی خودم متصل شوم؟
                                <i class="mdi mdi-chevron-down icon-show"></i
                                ><i class="mdi mdi-chevron-up icon-close"></i
                                ></a>
                            <div
                                id="faq-list-5"
                                class="collapse"
                                data-bs-parent=".faq-list"
                            >
                                <p>
                                    اول از همه ثبت نام کنید و بعد از قسمت اتصال به املاک شماره مدیریت را وارد کنید و درخواست خود را بدهید و منتظر بمانید تا تایید شوید
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <!-- End Frequently Asked Questions Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container" data-aos="fade-up">
                <div class="section-title">
                    <h2>ارتباط با ما</h2>
                    <!-- <p>Magnam dolores commodi suscipit. Necessitatibus eius consequatur ex aliquid fuga eum quidem. Sit sint consectetur velit. Quisquam quos quisquam cupiditate. Et nemo qui impedit suscipit alias ea. Quia fugiat sit in iste officiis commodi quidem hic quas.</p> -->
                </div>

                <div class="row">
                    <div class="col-lg-5 d-flex align-items-stretch">
                        <div class="info">
                            <div class="address">
                                <i class="mdi mdi-home"></i>
                                <h4>آدرس:</h4>
                                <p>پیروزی 10 ،پلاک 167</p>
                            </div>

                            <div class="email">
                                <i class="mdi mdi-email"></i>
                                <h4>ایمیل:</h4>
                                <p>vearad.ir@gmail.com</p>
                            </div>

                            <div class="phone">
                                <i class="mdi mdi-cellphone-android"></i>
                                <h4>تلفن:</h4>
                                <p>09358668218</p>
                            </div>

                            <div style="width: 100%"><iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d413.77004546981306!2d59.53924177811008!3d36.28984181283104!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2s!4v1695759443759!5m2!1sen!2s" width="350" height="320" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>
                        </div>
                    </div>

                    <div class="col-lg-7 mt-5 mt-lg-0 d-flex align-items-stretch">
                        <form
                            action="forms/contact.php"
                            method="post"
                            role="form"
                            class="php-email-form"
                        >
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">اسم و فامیل</label>
                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        id="name"
                                        required
                                    />
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name">ایمیل</label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        name="email"
                                        id="email"
                                        required
                                    />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">موضوع</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="subject"
                                    id="subject"
                                    required
                                />
                            </div>
                            <div class="form-group">
                                <label for="name">مسیج</label>
                                <textarea
                                    class="form-control"
                                    name="message"
                                    rows="10"
                                    required
                                ></textarea>
                            </div>
                            <div class="my-3">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">
                                    Your message has been sent. Thank you!
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit">ارسال</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Contact Section -->
    </main>
    <!-- End #main -->

@endsection
