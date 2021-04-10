@extends('layouts.theme')

@section('content')
    <section id="hero" class="d-flex align-items-center justify-content-center">

        <div class="herocontainer">

            <video autoplay muted loop id="herovideo">
                <source src="assets/img/hero.mp4" type="video/mp4">
            </video>

            <div class="herocontent">

                <a href="{{ route('login') }}" class="herobtn"> Members Area </a> <br/>
                <a href="#" class="herobtn"> Join The Movement</a>

            </div>

        </div>

    </section>


    <main id="main">

        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container" data-aos="fade-up">

                <div class="row">
                    <div class="col-lg-6 order-1 order-lg-2 image" data-aos="fade-left" data-aos-delay="100">
                        <!-- <img src="assets/img/about.jpg" class="img-fluid" alt=""> -->
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0 order-2 order-lg-1 content" data-aos="fade-right" data-aos-delay="100">
                        <h3>Black Wall Street Reclaimed</h3>
                        <p>
                            One hundred years ago, a thriving community of Black business owners, entrepreneurs, and community members was physically destroyed by a violent White mob. While that mob took lives, they could not take a legacy.
                        </p>
                        <p>
                            Today, we reclaim Black Wall Street as a group of investors focused on generational wealth. Join us as we rebuild on an international scale.
                        </p>

                    </div>
                </div>

            </div>
        </section><!-- End About Section -->


        <!-- ======= Cities Section ======= -->
        <section id="cities" class="features">
            <div class="container-fluid w20" data-aos="fade-up">

                <div class="row">

                    <div class="col-lg-6 content-pad" data-aos="fade-up" data-aos-delay="100">
                        <div class="section-title">
                            <h2></h2>
                            <p>Invest in Black Cities</p>
                        </div>

                        <p>One of Tulsa’s Black Wall Street’s greatest features was its community. Our investment group is in the bidding process to purchase the first of several New Era cities.</p>

                        <p> Each city will be designed to elevate Black generational wealth. </p>

                        <a href="#" class="lmbtn"> learn more </a>
                    </div>
                    <div class="image col-lg-6" style='background-image: url("assets/img/cities.png");' data-aos="fade-left"></div>

                </div>

            </div>
        </section><!-- End Cities Section -->

        <!-- ======= Schools Section ======= -->
        <section id="schools" class="features">
            <div class="container-fluid w20" data-aos="fade-up">

                <div class="row">

                    <div class="image col-lg-6" style='background-image: url("assets/img/schools.png");' data-aos="fade-right"></div>

                    <div class="col-lg-6 content-pad" data-aos="fade-up" data-aos-delay="100">
                        <div class="section-title">
                            <h2></h2>
                            <p>Invest in Black Education</p>
                        </div>

                        <p>Tulsa’s Black Wall Street placed high value on education. As traditional American schools leave out key parts of Black History, our New Era schools will prioritize education that teaches our history, our societal contributions and our future.</p>
                        <p>Our education will include courses on college and career readiness, financial literacy and entrepreneurial resources.</p>
                        <p>We will also promote and celebrate opportunities within HBCU communities, and more.</p>

                        <a href="#" class="lmbtn"> learn more </a>
                    </div>

                </div>

            </div>
        </section><!-- End Schools Section -->


        <!-- ======= luxury Section ======= -->
        <section id="luxury" class="features">
            <div class="container-fluid w20" data-aos="fade-up">

                <div class="row">

                    <div class="col-lg-6 content-pad" data-aos="fade-up" data-aos-delay="100">
                        <div class="section-title">
                            <h2></h2>
                            <p>Invest in Black Luxury</p>
                        </div>

                        <p>Luxury experiences are often some of the most gatekept opportunities. New Era Black Wall Street is purchasing Yachts to provide luxury experiences that elevate the Black community.</p>
                        <p>Whether you need a yacht to throw a party or to embark upon a new sailing adventure, now is the time to invest in Black luxury experiences.</p>

                        <a href="#" class="lmbtn"> learn more </a>
                    </div>

                    <div class="image col-lg-6" style='background-image: url("assets/img/yachts.png");' data-aos="fade-right"></div>

                </div>

            </div>
        </section><!-- End luxury Section -->


        <!-- ======= Travel Section ======= -->
        <section id="travel" class="features">
            <div class="container-fluid w20" data-aos="fade-up">

                <div class="row">

                    <div class="image col-lg-6" style='background-image: url("assets/img/Jets.png");' data-aos="fade-right"></div>

                    <div class="col-lg-6 content-pad" data-aos="fade-up" data-aos-delay="100">
                        <div class="section-title">
                            <h2></h2>
                            <p>Invest in Black Travel</p>
                        </div>

                        <p>Access to travel means greater access to the world. Invest with us as we purchase a fleet of private jets to elevate the Black travel experience and expand luxury travel to our community.</p>
                        <p>We’re working to alleviate the challenges brought on by blackout dates, arbitrary membership requirements and more. </p>
                        <p>Join us as we upgrade the Black Travel experience with our own resources.</p>

                        <a href="#" class="lmbtn"> learn more </a>
                    </div>

                </div>

            </div>
        </section><!-- End Travel Section -->




        <!-- ======= Team Section ======= -->
        <section id="team" class="team">
            <div class="container" data-aos="fade-up">

                <div class="teamtitle">
                    <h2>Our Team</h2>
                    <p>Our team is comprised of a curated group of Black experts across the industries we intend to pursue. Each member brings a powerful combination of perspective, experience and vision to New Era Black Wall Street.</p>
                </div>
                <div class="row">

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                        <div class="member" data-aos="fade-up" data-aos-delay="100">
                            <div class="member-img">
                                <img src="assets/img/team/team-1.jpg" class="img-fluid" alt="">
                                <div class="social">
                                    <a href=""><i class="icofont-twitter"></i></a>
                                    <a href=""><i class="icofont-facebook"></i></a>
                                    <a href=""><i class="icofont-instagram"></i></a>
                                    <a href=""><i class="icofont-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Curtis</h4>
                                <span>IT Management</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                        <div class="member" data-aos="fade-up" data-aos-delay="200">
                            <div class="member-img">
                                <img src="assets/img/team/team-2.jpg" class="img-fluid" alt="">
                                <div class="social">
                                    <a href=""><i class="icofont-twitter"></i></a>
                                    <a href=""><i class="icofont-facebook"></i></a>
                                    <a href=""><i class="icofont-instagram"></i></a>
                                    <a href=""><i class="icofont-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Andrea</h4>
                                <span>Customer Relations</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                        <div class="member" data-aos="fade-up" data-aos-delay="300">
                            <div class="member-img">
                                <img src="assets/img/team/team-3.jpg" class="img-fluid" alt="">
                                <div class="social">
                                    <a href=""><i class="icofont-twitter"></i></a>
                                    <a href=""><i class="icofont-facebook"></i></a>
                                    <a href=""><i class="icofont-instagram"></i></a>
                                    <a href=""><i class="icofont-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Reshonah</h4>
                                <span>Acquisitions</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch">
                        <div class="member" data-aos="fade-up" data-aos-delay="400">
                            <div class="member-img">
                                <img src="assets/img/team/team-4.jpg" class="img-fluid" alt="">
                                <div class="social">
                                    <a href=""><i class="icofont-twitter"></i></a>
                                    <a href=""><i class="icofont-facebook"></i></a>
                                    <a href=""><i class="icofont-instagram"></i></a>
                                    <a href=""><i class="icofont-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Marcus</h4>
                                <span>Investments</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- End Team Section -->

        <!-- ======= Movement Section ======= -->
        <section id="movement" class="cta">
            <div class="container" data-aos="zoom-in">

                <div class="text-center">
                    <h3>Ready to join the movement?</h3>
                    <a class="cta-btn" href="#">START INVESTING TODAY</a>
                </div>

            </div>
        </section><!-- End Movement Section -->

        <!-- ======= Contact Section ======= -->
        <section id="contact" class="contact">
            <div class="container contact-container" data-aos="fade-up">

                <div class="section-title">
                    <h2></h2>
                    <p>Contact Us</p>
                </div>

                <div class="row mt-5">

                    <div class="col-lg-4">
                        <div class="info">
                            <div class="address">
                                <i class="icofont-google-map"></i>
                                <h4>Location:</h4>
                                <p>A108 Adam Street, New York, NY 535022</p>
                            </div>

                            <div class="email">
                                <i class="icofont-envelope"></i>
                                <h4>Email:</h4>
                                <p>info@example.com</p>
                            </div>

                            <div class="phone">
                                <i class="icofont-phone"></i>
                                <h4>Call:</h4>
                                <p>+1 5589 55488 55s</p>
                            </div>

                        </div>

                    </div>

                    <div class="col-lg-8 mt-5 mt-lg-0">

                        <form action="forms/contact.php" method="post" role="form" class="php-email-form">
                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
                                    <div class="validate"></div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
                                    <div class="validate"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
                                <div class="validate"></div>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
                                <div class="validate"></div>
                            </div>
                            <div class="mb-3">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>
                            </div>
                            <div class="text-center"><button type="submit">Send Message</button></div>
                        </form>

                    </div>

                </div>

            </div>
        </section><!-- End Contact Section -->

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer">

        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Gp</span></strong>. All Rights Reserved
            </div>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/gp-free-multipurpose-html-bootstrap-template/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>
    <div id="preloader"></div>
@endsection
