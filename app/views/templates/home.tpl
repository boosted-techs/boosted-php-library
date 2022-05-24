{extends file="index.tpl"}
{block name="style"}{/block}
{block name="body"}
    <!-- Banner/Slider -->
    <div id="slider" class="banner banner-slider slider-large carousel slide carousel-fade">
        <!-- Wrapper for Slides -->
        <div class="carousel-inner">
            <div class="item active">
                <!-- Set the first background image using inline CSS below. -->
                <div class="fill" style="background-image:url('//{$smarty.server.SERVER_NAME}/assets/image/slider/fintech.jpg');">
                    <div class="banner-content">
                        <div class="container">
                            <div class="row">
                                <div class="banner-text al-left pos-left light">
                                    <h2>COLLECT ON MONEY.<strong>.</strong></h2>
                                    <p>Collect money from any device.</p>
{*                                    <a href="#" class="btn">Learn more</a>*}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="item">
                <!-- Set the second background image using inline CSS below. -->
                <div class="fill" style="background-image:url('//{$smarty.server.SERVER_NAME}/assets/image/slider/sms.jpg');">
                    <div class="banner-content">
                        <div class="container">
                            <div class="row">
                                <div class="banner-text al-left pos-left light">
                                    <h2>SMS LIKE A PRO<strong>.</strong></h2>
                                    <p>Power your website to send SMSs.</p>
{*                                    <a href="#" class="btn">Learn more</a>*}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Left and right controls -->
        <a class="left carousel-control" href="#slider" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#slider" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <!-- #end Banner/Slider -->
    </header>
    <!-- Service Section -->
    <div class="section section-services">
        <div class="container">
            <div class="content row">
                <!-- Feature Row  -->
                <div class="feature-row feature-service-row row feature-s4 off-text boxed-filled boxed-w">
                    <div class="heading-box clearfix">
                        <div class="col-sm-3">
                            <h2 class="heading-section">GENERATIONAL FINTECH SOLUTIONS.</h2>
                        </div>
                        <div class="col-sm-8 col-sm-offset-1">
                            <span>Boosteds the Boosted Payments & SMS gateway is a generation Fintech boosted approach giving power to developers to collect and send money from over 10 key mobile money service providers in Africa.</span>
                            <span class="text-primary font-weight-bolder">DEVELOPED FOR DEVELOPERS</span>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6 even">
                        <!-- Feature box -->
                        <div class="feature">
                            <a href="#">
                                <div class="fbox-photo">
                                    <img src="//{$smarty.server.SERVER_NAME}/assets/image/mobile-money.jpg" alt="Boosteds Mobile money collections API">
                                </div>
                                <div class="fbox-over">
                                    <h3 class="title">MOBILE MONEY COLLECTIONS API</h3>
                                    <div class="fbox-content">
                                        <p>Send and receive mobile money from your clients on your application with our Mobile Money Collections API</p>
{*                                        <span class="btn">Learn More</span>*}
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- End Feature box -->
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6 odd">
                        <!-- Feature box -->
                        <div class="feature">
                            <a href="#">
                                <div class="fbox-photo">
                                    <img src="//{$smarty.server.SERVER_NAME}/assets/image/utilites.jpg" alt="Boosted Utility Bills payment API">
                                </div>
                                <div class="fbox-over">
                                    <h3 class="title">UTILITY PAYMENTS API</h3>
                                    <div class="fbox-content">
                                        <p>Power your APPLICATION to pay UMEME YAKA,NAtional Waters BILLS, Uganda Revenue Authority and Popular TV subscriptions.</p>
{*                                        <span class="btn">Learn More</span>*}
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- End Feature box -->
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-6 even">
                        <!-- Feature box -->
                        <div class="feature">
                            <a href="#">
                                <div class="fbox-photo">
                                    <img src="//{$smarty.server.SERVER_NAME}/assets/image/send_money.jpg" alt="Boosted Money transfer API">
                                </div>
                                <div class="fbox-over">
                                    <h3 class="title">WALLET TRANSFER API</h3>
                                    <div class="fbox-content">
                                        <p>With our Wallet transfer API, you sre able to pay out or transfer money to your mobile or bank wallet at the GO.</p>
{*                                        <span class="btn">Learn More</span>*}
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- End Feature box -->
                    </div>

                    <div class="col-md-3 col-sm-6 col-xs-6 odd">
                        <!-- Feature box -->
                        <div class="feature">
                            <a href="#">
                                <div class="fbox-photo">
                                    <img src="//{$smarty.server.SERVER_NAME}/assets/image/sms.jpg" alt="Boosted SMS gateway API">
                                </div>
                                <div class="fbox-over">
                                    <h3 class="title">SMS API</h3>
                                    <div class="fbox-content">
                                        <p>Power your Application to send SMS through our SMS Gateway API.</p>
{*                                        <span class="btn">Learn More</span>*}
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- End Feature box -->
                    </div>
                </div>
                <!-- Feture Row  #end -->

            </div>
        </div>
    </div>
    <!-- End Section -->
    <!-- Content -->
    <div class="section section-content section-pad">
        <div class="container">
            <div class="content row">

                <div class="row row-vm">
                    <div class="col-md-6 res-m-bttm">
                        <h5 class="heading-sm-lead">About us</h5>
                        <h2 class="heading-section">Who we are</h2>
                        <blockquote>Commitment unlocks doors of imaginations, allows vision and gives us the right energy to turn our dreams to reality</blockquote>
                        <p>Boosted Payments and SMS (Boosteds PS) gateway solutions is a digital platform that offers payment gateway solutions to developers of websites, web applications and any other form of software that accepts payments.</p>
                        <p>BPSs accepts Mobile Money collections In the following Currencies. UGX (Ugandan Shilling), KES (Kenyan Shilling), TZS (Tanzanian Shilling) , ZMW (Zimbabwean Dollar), RWF (Rwandan Franc), XOF (West African CFA franc), NGN (Nigerian Naira), XAF (Central African CFA franc)</p>
                        <p>You can do any FinTech product with our Fast, secure and reliable technology. Our APIs are designed to perform as fast as you wish your product to respond to your customers queries.
                        </p>
                        <p>Boosted SMS solutions is a gateway that receives SMS requests and dispatches them off to the intended receipts.
                            With the need to stay above competition, we bring our SMS gateway to web developers to power their sites with SMS at amazing rates.</p>
                        <p>UTILITY Payments in Uganda is as well possible with our Boosted Payment solutions. Power your Application to collect YAKA, NWSC, URA with just an API call.</p>
                    </div>
                    <div class="col-md-5 col-md-offset-1">
                        <img class="no-round" src="//{$smarty.server.SERVER_NAME}/assets/image/about-us-pic.jpg" alt="">
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Content -->
    <!-- Content -->
    <div class="section section-contents section-pad image-on-right bg-light">
        <div class="container">
            <div class="row">

                <h5 class="heading-sm-lead">Our Services</h5>
                <h2 class="heading-section">What we do</h2>
                <div class="feature-intro">
                    <div class="row">
                        <div class="col-sm-7 col-md-6">
                            <div class="row">
                                <div class="col-sm-6 res-s-bttm">
                                    <div class="icon-box style-s1 photo-plx-full">
                                        <em class="fa fa-mobile-phone" aria-hidden="true"></em>
                                    </div>
                                    <h4>Mobile Money Collections API development</h4>
                                    <p>We delight in being among the best Mobile money collections and Transfer APIs developers in Africa that power a vast number of service providers</p>
                                </div>
                                <div class="col-sm-6">
                                    <div class="icon-box style-s1">
                                        <em class="fa fa-envelope" aria-hidden="true"></em>
                                    </div>
                                    <h4>SMS Gateway API development</h4>
                                    <p>We develop SMS gateway solutions for developers to fully rely on. Send Bulky SMSs, SMS Notifications among others.</p>
                                </div>
                                <div class="gaps size-lg"></div>
                                <div class="col-sm-6 res-s-bttm">
                                    <div class="icon-box style-s1">
                                        <em class="fa fa-tv" aria-hidden="true"></em>
                                    </div>
                                    <h4>UTILITY PAYMENTS API DEVELOPMENT</h4>
                                    <p>We power other developers into the Utility payments business. Paying for TV subscriptions, YAKA, URA is now made possible for everyone. </p>
                                </div>
                                <div class="col-sm-6">
                                    <div class="icon-box style-s1">
                                        <em class="fa fa-credit-card" aria-hidden="true"></em>
                                    </div>
                                    <h4>CREDIT & DEBIT CARD COLLECTIONS</h4>
                                    <p>Our API powers websites to accept and receive debit & Credit card collections at the Go. It is secure and reliable.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
        <div class="section-bg imagebg"><img src="//{$smarty.server.SERVER_NAME}/assets/image/our-services.jpg" alt="Boosted services"></div>
    </div>
    <!-- End Content -->
    <!-- Testimonials -->
    <div class="section section-quotes section-pad">
        <div class="container">
            <div class="content row">

                <div class="col-md-offset-2 col-md-8 center">
                    <h5 class="heading-sm-lead">The People Say</h5>
                    <h2 class="heading-section">Testimonials</h2>
                </div>
                <div class="gaps"></div>
                <div class="testimonials">
                    <div id="testimonial" class="quotes-slider col-md-8 col-md-offset-2">
                        <div class="owl-carousel loop has-carousel" data-items="1" data-loop="true" data-dots="true" data-auto="true">
                            <div class="item">
                                <!-- Each Quotes -->
                                <div class="quotes">
                                    <div class="quotes-text center">
                                        <p>Boosted Payments and SMS gateway is built with our developers needs in mind. Security, Reliability, Efficiency and 99.9% UPTIME </p>
                                    </div>
                                    <div class="profile">
                                        <img src="https://tumusiime.boostedtechs.com/assets/images/tumusiime.JPG" alt="Tumusiime Ashiraff">
                                        <h5>Mr. Tumusiime Ashiraff</h5>
                                        <h6>BOOSTED TECHNOLOGIES LTD</h6>
                                    </div>
                                </div>
                                <!-- End Quotes -->
                            </div>
                            <!-- End Slide -->
                            <!-- Each Slide -->
                            <div class="item">
                                <!-- Each Quotes -->
                                <div class="quotes">
                                    <div class="quotes-text center">
                                        <p>Reliable and has cheap rates.</p>
                                    </div>
                                    <div class="profile">
{*                                        <img src="//{$smarty.server.SERVER_NAME}/assets/image/profile-img.jpg" alt="">*}
                                        <h5>Anonymous</h5>
                                        <h6>Satisfied Developer</h6>
                                    </div>
                                </div>
                                <!-- End Quotes -->
                            </div>
                        </div>
                        <!-- End Slide -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- End Section -->
    <!-- Content -->
    <div class="section section-contents section-pad has-bg fixed-bg light bg-alternet">
        <div class="container">
            <div class="row">

                <div class="row">
                    <div class="col-md-4 pad-r res-m-bttm">
                        <h2 class="heading-lead">Modern FinTech solutions for Modern Challenges</h2>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-sm-6 res-s-bttm">
                                <div class="icon-box style-s4 photo-plx-full">
                                    <em class="fa fa-check" aria-hidden="true"></em>
                                </div>
                                <h4>Experienced</h4>
                                <p>We develop with our developers on market in mind.</p>
                            </div>
                            <div class="col-sm-6">
                                <div class="icon-box style-s4">
                                    <em class="fa fa-cogs" aria-hidden="true"></em>
                                </div>
                                <h4>Vibrant</h4>
                                <p>Vibrant solutions that work. </p>
                            </div>
                            <div class="gaps size-lg"></div>
{*                            <div class="col-sm-6 res-s-bttm">*}
{*                                <div class="icon-box style-s4">*}
{*                                    <em class="fa fa-credit-card" aria-hidden="true"></em>*}
{*                                </div>*}
{*                                <h4>Professional</h4>*}
{*                                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusan.</p>*}
{*                            </div>*}
{*                            <div class="col-sm-6">*}
{*                                <div class="icon-box style-s4">*}
{*                                    <em class="fa fa-trademark" aria-hidden="true"></em>*}
{*                                </div>*}
{*                                <h4>Trademarks</h4>*}
{*                                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusan.</p>*}
{*                            </div>*}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section-bg imagebg"><img src="//{$smarty.server.SERVER_NAME}/assets/image/core-bg.jpg" alt=""></div>
    </div>
    <!-- End Content -->
    <!-- Teams -->
{*    <div class="section section-teams section-pad bdr-bottom">*}
{*        <div class="container">*}
{*            <div class="content row">*}

{*                <div class="col-md-offset-2 col-md-8 center">*}
{*                    <h5 class="heading-sm-lead">The Team</h5>*}
{*                    <h2 class="heading-section">Our Advisors</h2>*}
{*                </div>*}
{*                <div class="gaps"></div>*}
{*                <div class="team-member-row row">*}
{*                    <div class="col-md-3 col-sm-6 col-xs-6 even">*}
{*                        <!-- Team Profile -->*}
{*                        <div class="team-member">*}
{*                            <div class="team-photo">*}
{*                                <img alt="" src="//{$smarty.server.SERVER_NAME}/assets/image/team-a.jpg">*}
{*                            </div>*}
{*                            <div class="team-info center">*}
{*                                <h4 class="name">Robert Miller</h4>*}
{*                                <p class="sub-title">Managing Director &amp; CEO</p>*}
{*                            </div>*}
{*                        </div>*}
{*                        <!-- Team #end -->*}
{*                    </div>*}
{*                    <div class="col-md-3 col-sm-6 col-xs-6 odd">*}
{*                        <!-- Team Profile -->*}
{*                        <div class="team-member">*}
{*                            <div class="team-photo">*}
{*                                <img alt="" src="//{$smarty.server.SERVER_NAME}/assets/image/team-b.jpg">*}
{*                            </div>*}
{*                            <div class="team-info center">*}
{*                                <h4 class="name">Stephen Everett</h4>*}
{*                                <p class="sub-title">Chief Financial Officer</p>*}
{*                            </div>*}
{*                        </div>*}
{*                        <!-- Team #end -->*}
{*                    </div>*}
{*                    <div class="col-md-3 col-sm-6 col-xs-6 even">*}
{*                        <!-- Team Profile -->*}
{*                        <div class="team-member">*}
{*                            <div class="team-photo">*}
{*                                <img alt="" src="//{$smarty.server.SERVER_NAME}/assets/image/team-c.jpg">*}
{*                            </div>*}
{*                            <div class="team-info center">*}
{*                                <h4 class="name">Philip Hennessy</h4>*}
{*                                <p class="sub-title">Senior Tax Specialist</p>*}
{*                            </div>*}
{*                        </div>*}
{*                        <!-- Team #end -->*}
{*                    </div>*}
{*                    <div class="col-md-3 col-sm-6 col-xs-6 odd">*}
{*                        <!-- Team Profile -->*}
{*                        <div class="team-member">*}
{*                            <div class="team-photo">*}
{*                                <img alt="" src="//{$smarty.server.SERVER_NAME}/assets/image/team-d.jpg">*}
{*                            </div>*}
{*                            <div class="team-info center">*}
{*                                <h4 class="name">Robert Miller</h4>*}
{*                                <p class="sub-title">Chief Financial Advisor</p>*}
{*                            </div>*}
{*                        </div>*}
{*                        <!-- Team #end -->*}
{*                    </div>*}
{*                </div><!-- TeamRow #end -->*}
{*            </div>*}
{*        </div>*}
{*    </div>*}
    <!-- End Section -->
    <!-- Latest News -->
{*    <div class="section section-news section-pad">*}
{*        <div class="container">*}
{*            <div class="content row">*}

{*                <h5 class="heading-sm-lead center">Latest News</h5>*}
{*                <h2 class="heading-section center">Our Financial Updates</h2>*}

{*                <div class="row">*}
{*                    <!-- Blog Post Loop -->*}
{*                    <div class="blog-posts">*}
{*                        <div class="post post-loop  col-md-4">*}
{*                            <div class="post-thumbs">*}
{*                                <a href="news-details.html"><img alt="" src="//{$smarty.server.SERVER_NAME}/assets/image/post-thumb-a.jpg"></a>*}
{*                            </div>*}
{*                            <div class="post-entry">*}
{*                                <div class="post-meta"><span class="pub-date">15, Aug 2017</span></div>*}
{*                                <h2><a href="news-details.html">Income Increase Shows the Recovery Is Very Much Real</a></h2>*}
{*                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt laboris nisi ut aliquip ex ea commodo consequat...</p>*}
{*                                <a class="btn btn-alt" href="#">Read More</a>*}
{*                            </div>*}
{*                        </div>*}
{*                        <div class="post post-loop col-md-4">*}
{*                            <div class="post-thumbs">*}
{*                                <a href="news-details.html"><img alt="" src="//{$smarty.server.SERVER_NAME}/assets/image/post-thumb-b.jpg"></a>*}
{*                            </div>*}
{*                            <div class="post-entry">*}
{*                                <div class="post-meta"><span class="pub-date">04, Jul 2017</span></div>*}
{*                                <h2><a href="news-details.html">An Economics Nobel awarded for Examining Reality</a></h2>*}
{*                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt laboris nisi ut aliquip ex ea commodo consequat...</p>*}
{*                                <a class="btn btn-alt" href="#">Read More</a>*}
{*                            </div>*}
{*                        </div>*}
{*                        <div class="post post-loop col-md-4">*}
{*                            <div class="post-thumbs">*}
{*                                <a href="news-details.html"><img alt="" src="//{$smarty.server.SERVER_NAME}/assets/image/post-thumb-c.jpg"></a>*}
{*                            </div>*}
{*                            <div class="post-entry">*}
{*                                <div class="post-meta"><span class="pub-date">26, Dec 2016</span></div>*}
{*                                <h2><a href="news-details.html">Maybe Supply-Side Economics Deserves a Second Look</a></h2>*}
{*                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit sed do eiusmod tempor incididunt laboris nisi ut aliquip ex ea commodo consequat...</p>*}
{*                                <a class="btn btn-alt" href="#">Read More</a>*}
{*                            </div>*}
{*                        </div>*}
{*                    </div>*}
{*                </div>*}

{*            </div>*}
{*        </div>*}
{*    </div>*}
    <!-- End Section -->
{/block}