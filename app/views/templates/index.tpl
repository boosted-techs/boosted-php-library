<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$page_title}}Boosted Payments & SMS</title>
    <meta name="keywords" content="Boosteds, Boosteds Payment gateway, Boosted Payments, Boosted Payment gateway, YAKA api, URA API, UMEME API, MOMO API, AIRTEL MONEY API, STAR TIMES SUBSCRIPTION API, GOTV SUBSCRIPTIONS API, DSTV SUBCRIPTION API, ZUKU Subscription, MPESA COLLECTION API, URA COLLECTION API, URA API, Airtel money payment gateway, Mobile Money payment gateway, Boosted Payment and SMS gateway, Payment gateway, Payment solutions, cheap payment gateway, SMS gateway, bulk sms gateway, Cheap payments in Uganda, SMS and Payment, Boosted technologies, Boosted Technologies LTD, PeraPay, Smart payment solutions"/>
    <meta name="description" content="{{$description}} Collect Payments from over 10 Major telecom in Africa, send to SMS to over 10 telecom companies in Africa from your website. Our Payments and SMS gateway is developed for web developers who need to accept payments, and send SMS notifications to their clients."/>
    <meta property="og:title" content="Boosteds Payment & SMS solutions">
    <meta property="og:site_name" content="Boosted Payment & SMS solutions">
    <meta property="og:description" content="Boosted PS solutions powers Websites and other platforms that collect money from Mobile Money, Electronic cards as well send SMS to their clients. Boosted PS is a product of Boosted Technololiges LTD">
    <meta property="og:image" content="https://{{$smarty.server.SERVER_NAME}}/assets/image/our-services.jpg">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="theme-color" content="#009c51"/>

    <meta name="author" content="Tumusiime ashiraff https://www.tumusiime.boostedtechs.com" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/assets/image/favicon.png" type="image/png">
    <link rel="stylesheet" type="text/css" href="/assets/css/vendor.bundle.css">
    <link id="style-css" rel="stylesheet" type="text/css" href="/assets/css/style.css">
    {block name="styles"}{/block}
</head>
<body class="site-body style-v1">
<!-- Header -->
    <header class="site-header header-s1 is-transparent is-sticky">
        <!-- Topbar -->
        <div class="topbar">
            <div class="container">
                <div class="row">
                    <div class="top-aside top-left">
                        <ul class="top-nav">
{*                            <li><a href="/onpress">On Press</a></li>*}
{*                            <li><a href="/career">Career</a></li>*}
{*                            <li><a href="/offices">Our Offices</a></li>   *}
                            <li><a href="/contact">Contact Us</a></li>        
                        </ul>
                    </div>
                    <div class="top-aside top-right clearfix">
                        <ul class="top-contact clearfix">
                            <li class="t-email t-email1">
                                <em class="fa fa-envelope-o" aria-hidden="true"></em>
                                <span><a href="#">support@boosteds.co</a></span>
                            </li>
                            <li class="t-phone t-phone1">
                                <em class="fa fa-phone" aria-hidden="true"></em>
                                <span>+256 759 800742</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- #end Topbar -->
        <!-- Navbar -->
        <div class="navbar navbar-primary">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand" href="./">
                    <img class="logo logo-dark" alt="" src="/assets/image/logo-2.png" srcset="/assets/image/logo2x-2.png 2x">
                    <img class="logo logo-light" alt="" src="/assets/image/logo-light-2.png" srcset="/assets/image/logo-light2x-2.png 2x">
                </a>
                <!-- #end Logo -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainnav" aria-expanded="false">
                        <span class="sr-only">Menu</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Q-Button for Mobile -->
                    <div class="quote-btn"><a class="btn" href="{{if isset($smarty.cookies.auth)}}/p/{{else}}{{$domain.auth}}/app/{{$key}}?i=6&redirect={{$domain.redirect}}{/if}">{{if isset($smarty.cookies.auth)}}DASHBOARD{{else}}LOGIN{/if}</a></div>
                </div>
                <!-- MainNav -->
                <nav class="navbar-collapse collapse" id="mainnav">
                    <ul class="nav navbar-nav">
                        <li><a href="./">Home</a></li>
                        <li><a href="/about">About Us</a></li>
                        <li><a href="/services">Services</a></li>
                        <li><a href="/testimonial">Testimonial</a></li>
                        <li><a href="/news">News</a></li>
                        <li><a href="/docs">DOCUMENTATION</a></li>
                        <li class="quote-btn"><a class="btn" href="{{if isset($smarty.cookies.auth)}}/p/{{else}}{{$domain.auth}}/app/{{$key}}?i=6&redirect={{$domain.redirect}}{/if}">{{if isset($smarty.cookies.auth)}}DASHBOARD{{else}}LOGIN{/if}</a></li>
                    </ul>
                </nav>
                <!-- #end MainNav -->
            </div>
        </div>
        <!-- #end Navbar -->

<!-- End Header -->
{block name="body"}{/block}

<!-- Client logo -->
<div class="section section-logos section-pad-sm bg-light bdr-top">
    <div class="container">
        <div class="content row">

            <div class="owl-carousel loop logo-carousel style-v2">
                <div class="logo-item"><img  alt="Boosted Technologies LTD" style="width:190px; height: 82px; object-fit: contain" src="https://www.boostedtechs.com/assets/images/logo.png"></div>
                <div class="logo-item"><img alt="" style="width:190px; height: 82px; object-fit: contain" src="https://store.boostedtechs.com/assets/images/logo/logo-white.png"></div>
                <div class="logo-item"><img alt="" style="width:190px; height: 82px; object-fit: contain" src="https://3dultimate256.com/assets/images/logo-white.png"></div>
                <div class="logo-item"><img alt="" style="width:190px; height: 82px; object-fit: contain"src="https://ariostoreug.com/wp-content/uploads/2021/10/logo-logo-copy2-copy3.png"></div>

            </div>

        </div>
    </div>
</div>
<!-- End Section -->

<!-- Call Action -->
<div class="call-action cta-small has-bg bg-primary" style="background-image: url('/assets/image/customer.jpg');">
    <div class="cta-block">
        <div class="container">
            <div class="content row">

                <div class="cta-sameline">
                    <h2>Have any Question?</h2>
                    <p>We're here to help. Send us an email or call us at +256 759800742. Please feel free to contact our expert.</p>
                    <a class="btn btn-alt" href="#">Contact Us</a>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- End Section -->

<!-- Footer Widget-->
<div class="footer-widget style-v2 section-pad-md">
    <div class="container">
        <div class="row">

            <div class="widget-row row">
                <div class="footer-col col-md-3 col-sm-6 res-m-bttm">
                    <!-- Each Widget -->
                    <div class="wgs wgs-footer wgs-text">
                        <div class="wgs-content">
                            <p><img src="/assets/image/logo-2.png" srcset="/assets/image/logo2x.png 2x" alt="Boosted Payments and Sms logo"></p>
                            <p>Boosted Payments and SMS solutions is a product of Boosted Technologies LTD</p>
                        </div>
                    </div>
                    <!-- End Widget -->
                </div>
                <div class="footer-col col-md-3 col-sm-6 col-md-offset-1 res-m-bttm">
                    <!-- Each Widget -->
                    <div class="wgs wgs-footer wgs-menu">
                        <h5 class="wgs-title">Pages</h5>
                        <div class="wgs-content">
                            <ul class="menu">
                               
                                <li><a href="/services">Services</a></li>
                                <li><a href="/contact">Contact Us</a></li>
                                <li><a href="/news">News</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Widget -->
                </div>
                <div class="footer-col col-md-2 col-sm-6 res-m-bttm">
                    <!-- Each Widget -->
                    <div class="wgs wgs-footer wgs-menu">
                        <h5 class="wgs-title">Quick Links</h5>
                        <div class="wgs-content">
                            <ul class="menu">
                                <li><a href="/about">About Us</a></li>
                                <li><a href="/testimonial">Testimonial</a></li>
                                
                            </ul>
                        </div>
                    </div>
                    <!-- End Widget -->
                </div>

                <div class="footer-col col-md-3 col-sm-6">
                    <!-- Each Widget -->
                    <div class="wgs wgs-footer">
                        <h5 class="wgs-title">Get In Touch</h5>
                        <div class="wgs-content">
                            <p>
                                S.A Fridaus - Bwaise -Kampala (U) <br>
                               P.O BOX 3904 Kampala.</p>
                            <p><span></span>Helpline: +256 759 800742<br>
                                <span>Phone</span>: +256 760 690359</p>
                            <ul class="social">
                                <li><a href="https://www.facebook.com/boostedtechnologies/"><em class="fa fa-facebook" aria-hidden="true"></em></a></li>
                                <li><a href="https://twitter.com/boosted_techs"><em class="fa fa-twitter" aria-hidden="true"></em></a></li>
                                <li><a href="https://www.linkedin.com/company/boosted-technologies-ug-ltd/"><em class="fa fa-linkedin" aria-hidden="true"></em></a></li>
                                <li><a href="https://www.instagram.com/boosted_technologies?r=nametag"><em class="fa fa-instagram" aria-hidden="true"></em></a></li>
                                <li><a href="https://www.youtube.com/channel/UCyKTHdnhDeLxwLzIvBm7n2A"><em class="fa fa-youtube" aria-hidden="true"></em></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- End Widget -->
                </div>

            </div><!-- Widget Row -->

        </div>
    </div>
</div>
<!-- End Footer Widget -->
<!-- Copyright -->
<div class="copyright style-v2">
    <div class="container">
        <div class="row">

            <div class="row">
                <div class="site-copy col-sm-7">
                    <p>&copy; {$smarty.now|date_format:"%Y"} Boosted PS. <a href="/privacy-policy">Policy</a> | <a href="/terms-and-conditions">Terms and Conditions</a></p>

                </div>
                <div class="site-by col-sm-5 al-right">
                    <p>Developed by <a href="https://www.boostedtechs.com" target="_blank">Boosted Technologies LTD.</a></p>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="/assets/js/jquery.bundle.js"></script>
<!-- Theme Script init() -->
<script src="/assets/js/script.js"></script>
{block name="scripts"}{/block}
        {literal}
            <!--Start of Tawk.to Script-->
            <script type="text/javascript">
                var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
                (function(){
                    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                    s1.async=true;
                    s1.src='https://embed.tawk.to/61f7fa079bd1f31184da360c/1fqoahc2i';
                    s1.charset='UTF-8';
                    s1.setAttribute('crossorigin','*');
                    s0.parentNode.insertBefore(s1,s0);
                })();
            </script>
            <!--End of Tawk.to Script-->
        {/literal}
</body>
</html>
