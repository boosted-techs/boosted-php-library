<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Boosteds - Home</title>
    <meta name="theme-color" content="#009c51"/>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="icon" href="/assets/image/favicon.png" type="image/png">

    <link rel="stylesheet" href="/assets/p/vendor/select2/css/select2.min.css">
    <link rel="stylesheet" href="/assets/p/vendor/toastr/css/toastr.min.css">
    <link href="/assets/p/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
    <link href="/assets/p/vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/p/vendor/chartist/css/chartist.min.css">
    <link href="/assets/p/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="/assets/p/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="/assets/p/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="/assets/p/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- vue axios -->
    <script src="/assets/axios/axios.js"></script>
</head>
<body class="h-auto">
<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>
<div id="main-wrapper">
    <!--**********************************
    Main wrapper start
    ***********************************-->
    <!--**********************************
        Nav header start
    ***********************************-->
    <div class="nav-header">
        <a href="/admin/" class="brand-logo">
            <img class="logo-abbr" src="/assets/image/favicon.png" alt="Boosted Logo">
            <img class="logo-compact" src="/assets/image/favicon.png" alt="Boosted Logo">
            <img class="brand-title" src="/assets/image/favicon.png" alt="Boosted Logo">
        </a>

        <div class="nav-control">
            <div class="hamburger">
                <span class="line"></span><span class="line"></span><span class="line"></span>
            </div>
        </div>
    </div>
    <!--**********************************
    Nav header end
    ***********************************-->


    <!--**********************************
        Header start
    ***********************************-->
    <div class="header">
        <div class="header-content">
            <nav class="navbar navbar-expand">
                <div class="collapse navbar-collapse justify-content-between">
                    <div class="header-left">
                        <div class="dashboard_bar">
                            <div class="input-group search-area d-lg-inline-flex d-none">
                                <input type="text" class="form-control" placeholder="{{$user.names}}">
                                <div class="input-group-append">
                                    <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <ul class="navbar-nav header-right">

                        <li class="nav-item dropdown notification_dropdown">
                            <a class="nav-link" href="javascript:void(0)" role="button" data-toggle="dropdown">
                                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M23.625 6.12506H22.75V2.62506C22.75 2.47268 22.7102 2.32295 22.6345 2.19068C22.5589 2.05841 22.45 1.94819 22.3186 1.87093C22.1873 1.79367 22.0381 1.75205 21.8857 1.75019C21.7333 1.74832 21.5831 1.78629 21.4499 1.86031L14 5.99915L6.55007 1.86031C6.41688 1.78629 6.26667 1.74832 6.11431 1.75019C5.96194 1.75205 5.8127 1.79367 5.68136 1.87093C5.55002 1.94819 5.44113 2.05841 5.36547 2.19068C5.28981 2.32295 5.25001 2.47268 5.25 2.62506V6.12506H4.375C3.67904 6.12582 3.01181 6.40263 2.51969 6.89475C2.02757 7.38687 1.75076 8.0541 1.75 8.75006V11.3751C1.75076 12.071 2.02757 12.7383 2.51969 13.2304C3.01181 13.7225 3.67904 13.9993 4.375 14.0001H5.25V23.6251C5.25076 24.321 5.52757 24.9882 6.01969 25.4804C6.51181 25.9725 7.17904 26.2493 7.875 26.2501H20.125C20.821 26.2493 21.4882 25.9725 21.9803 25.4804C22.4724 24.9882 22.7492 24.321 22.75 23.6251V14.0001H23.625C24.321 13.9993 24.9882 13.7225 25.4803 13.2304C25.9724 12.7383 26.2492 12.071 26.25 11.3751V8.75006C26.2492 8.0541 25.9724 7.38687 25.4803 6.89475C24.9882 6.40263 24.321 6.12582 23.625 6.12506ZM21 6.12506H17.3769L21 4.11256V6.12506ZM7 4.11256L10.6231 6.12506H7V4.11256ZM7 23.6251V14.0001H13.125V24.5001H7.875C7.64303 24.4998 7.42064 24.4075 7.25661 24.2434C7.09258 24.0794 7.0003 23.857 7 23.6251ZM21 23.6251C20.9997 23.857 20.9074 24.0794 20.7434 24.2434C20.5794 24.4075 20.357 24.4998 20.125 24.5001H14.875V14.0001H21V23.6251ZM24.5 11.3751C24.4997 11.607 24.4074 11.8294 24.2434 11.9934C24.0794 12.1575 23.857 12.2498 23.625 12.2501H4.375C4.14303 12.2498 3.92064 12.1575 3.75661 11.9934C3.59258 11.8294 3.5003 11.607 3.5 11.3751V8.75006C3.5003 8.51809 3.59258 8.2957 3.75661 8.13167C3.92064 7.96764 4.14303 7.87536 4.375 7.87506H23.625C23.857 7.87536 24.0794 7.96764 24.2434 8.13167C24.4074 8.2957 24.4997 8.51809 24.5 8.75006V11.3751Z" fill="#007A64"/>
                                </svg>
                                <span class="badge light text-white bg-primary">0</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right p-3">
                                <div id="DZ_W_TimeLine1" class="widget-timeline dz-scroll style-1 height370">
                                    <ul class="timeline">
                                        <li>
                                            <div class="timeline-badge primary"></div>
                                            <a class="timeline-panel text-muted" href="#">
                                                <span>Notification</span>
                                                <h6 class="mb-0">Nothing to show</h6>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown header-profile">
                            <a class="nav-link" href="javascript:void(0)" role="button" data-toggle="dropdown">
                                <!-- <div class="header-info">
                                    <span class="text-black">Hello,<strong>Franklin</strong></span>
                                    <p class="fs-12 mb-0">Super Admin</p>
                                </div> -->
                                <img src="{{$user.image}}" width="20" alt=""/>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="/p/profile.boosted" class="dropdown-item ai-icon">
                                    <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                    <span class="ml-2">Profile ({{$user.username}})</span>
                                </a>
                                <a href="/p/messages.boosted" class="dropdown-item ai-icon">
                                    <svg id="icon-inbox" xmlns="http://www.w3.org/2000/svg" class="text-success" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                                    <span class="ml-2">Inbox </span>
                                </a>
                                <a class="dropdown-item ai-icon" href="/"><i class="las la-globe text-primary"></i><span class="ml-2">Website</span></a>
                                <a href="/p/logout.boosted" class="dropdown-item ai-icon">

                                    <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                    <span class="ml-2">Logout </span>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <!--**********************************
        Header end ti-comment-alt
    ***********************************-->
    <!--**********************************
            Sidebar start
        ***********************************-->
    <div class="deznav">
        <div class="deznav-scroll">
            <ul class="metismenu" id="menu">
                <li data-toggle="tooltip" title="Dashboard"><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-networking"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="/admin/">Home</a></li>
                        <li><a href="/">Website</a></li>
                        <li><a href="/p">APP</a></li>
                    </ul>
                </li>
                <li data-toggle="tooltip" title="SMS"><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="las la-paper-plane"></i>
                        <span class="nav-text">SMS</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="/admin/sms/sent.boosted">Sent</a></li>
                        <li><a href="/admin/sms/pending.boosted">Pending</a></li>
                    </ul>
                </li>
                <li data-toggle="tooltip" title="Payment Transactions"><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-television"></i>
                        <span class="nav-text">Transactions</span>
                    </a>
                    <ul aria-expanded="false">

                        <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Transactions</a>
                            <ul aria-expanded="false">
                                <li><a href="/admin/transactions/collections.boosted">Collections</a></li>
                                <li><a href="/admin/transactions/payments.boosted">Payments</a></li>
                            </ul>
                        </li>
                        <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Utilities</a>
                            <ul aria-expanded="false">
                                <li><a href="/admin/transactions/utilities/tv.boosted">TV</a></li>
                                <li><a href="/admin/transactions/utilities/ura.boosted">URA</a></li>
                                <li><a href="/admin/transactions/utilities/nwsc.boosted">NWSC</a></li>
                                <li><a href="/admin/transactions/utilities/yaka.boosted">YAKA</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li data-toggle="tooltip" title="Organizations and Projects"><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                        <i class="flaticon-381-controls-3"></i>
                        <span class="nav-text">Namespaces</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="/admin/namespace/organizations.boosted">Organizations</a></li>
                        <li><a href="/admin/namespace/projects.boosted">Projects</a></li>
                        <li><a href="/admin/namespace/collaborations.boosted">Collaborations</a></li>
                    </ul>
                </li>
                <li data-toggle="tooltip" title="Settings and personalization"><a href="#" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-381-settings-2"></i>
                        <span class="nav-text">Settings</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="/p/security.boosted">Security</a></li>
                    </ul>
                </li>
                <li><a href="#">
                        <i class="flaticon-381-bookmark-1" data-toggle="tooltip" title="Documentation"></i>
                        <span class="nav-text">DOCS</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!--**********************************
        Sidebar end
    ***********************************-->
    <div class="content-body">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Admin</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{$page}}</a></li>
                </ol>
            </div>
            {{block name="body"}}{{/block}}
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">Modal body text goes here.</div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/assets/p/vendor/global/global.min.js"></script>
<script src="/assets/p/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="/assets/p/vendor/chart.js/Chart.bundle.min.js"></script>

<script src="/assets/p/js/custom.min.js"></script>
<script src="/assets/p/js/deznav-init.js"></script>
<!--<script src="../assets/p/vendor/bootstrap-datetimepicker/js/moment.js"></script>-->
<!--<script src="../assets/p/vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>-->
<script src="/assets/p/vendor/sweetalert2/dist/sweetalert2.min.js"></script>
<!--<script src="../assets/p/js/plugins-init/sweetalert.init.js"></script>-->

<!-- Toastr -->
<script src="/assets/p/vendor/toastr/js/toastr.min.js"></script>

<!-- All init script -->
<script src="/assets/p/js/plugins-init/toastr-init.js"></script>
<!-- Datatable -->
<!-- Select -->

<link href="/assets/p/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
<script src="/assets/p/vendor/datatables/js/jquery.dataTables.min.js"></script>
<!--<script src="/assets/p/vendor/datatables/js/buttons.min.js"></script>-->
<!--<script src="/assets/p/vendor/datatables/js/jszip.min.js"></script>-->
<!--<script src="/assets/p/vendor/datatables/js/pdfmake.js"></script>-->
<!--<script src="/assets/p/vendor/datatables/js/pdfmake.min.js"></script>-->
<!--<script src="/assets/p/vendor/datatables/js/vsf_fonts.mini.js"></script>-->
<!--<script src="/assets/p/vendor/datatables/js/buttons_.html5.min.js"></script>-->

<!--<script src="../assets/p/js/plugins-init/datatables.init.js"></script>-->
<script src="/assets/p/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="/assets/p/vendor/select2/js/select2.full.min.js"></script>
<!--<script src="/assets/p/js/plugins-init/select2-init.js"></script>-->
<Script src="/assets/admin/js/js.js" ></Script>
<!-- For loading helper scripts for Vue components -->


<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip()
        //$('.multi-select').select2()
        $(".table").dataTable()
    })

    jQuery(document).ready(function() {
        'use strict';
        Welly.init();

    });
    /* Document.ready END */

    /* Window Load START */
    jQuery(window).on('load',function () {
        'use strict';
        Welly.load();

    });
    /*  Window Load END */
    /* Window Resize START */
    jQuery(window).on('resize',function () {
        'use strict';
        Welly.resize();
    });
    /*  Window Resize END */

</script>
</body>
</html>