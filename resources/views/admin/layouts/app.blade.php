<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title> @yield('title', 'Luciderp Chart')</title>

    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <!-- STYLESHEETS -->
    <link rel="stylesheet" href="{{ asset('vendor/jqvmap/css/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/chartist/css/chartist.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <link  rel="stylesheet" href="{{ asset('css/style.css') }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.2.1/js/dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.min.css">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    tinymce.init({
    selector: ".tinymce-editor", // Apply to all elements with this class
    height: 300,
    menubar: false,
    plugins: "advlist autolink lists link charmap preview anchor",
    toolbar: "bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent",
});

</script>

    <script>
        $(document).ready(function() {
            let table = new DataTable('#myTable', {
                "order": [
                    [2, "desc"]
                ] 
            });
        });
    </script>

    <style>
        .nav-text {
            font-size: 14px;
        }
        .highlighted {
            background-color: #c9e3ba;
            color: black;
            font-weight: bold;
        }
    </style>
    @stack('styles')

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header"
            style="display: flex; justify-content: space-between; align-items: center; padding: 10px; background: #fff;">
            <a href="{{ url('/') }}" class="brand-logo">
                <img src="/images/footer-logo-img.png" alt="logo" style="max-width: 100%; height: 40px;">
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
            Chat box start
        ***********************************-->
        <div class="chatbox">
            <div class="chatbox-close"></div>
            <div class="custom-tab-1">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#notes">Notes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#alerts">Alerts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#chat">Chat</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="chat" role="tabpanel">
                        <div class="card mb-sm-3 mb-md-0 contacts_card dlab-chat-user-box">
                            <div class="card-header chat-list-header text-center">
                                <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect fill="#000000" x="4" y="11" width="16" height="2"
                                                rx="1" />
                                            <rect fill="#000000" opacity="0.3"
                                                transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) "
                                                x="4" y="11" width="16" height="2" rx="1" />
                                        </g>
                                    </svg></a>
                                <div>
                                    <h6 class="mb-1">Chat List</h6>
                                    <p class="mb-0">Show All</p>
                                </div>
                                <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <circle fill="#000000" cx="5" cy="12" r="2" />
                                            <circle fill="#000000" cx="12" cy="12" r="2" />
                                            <circle fill="#000000" cx="19" cy="12" r="2" />
                                        </g>
                                    </svg></a>
                            </div>
                            <div class="card-body contacts_body p-0 dlab-scroll  " id="DLAB_W_Contacts_Body">
                                <ul class="contacts">
                                    <li class="name-first-letter">A</li>
                                    <li class="active dlab-chat-user">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="/images/avatar/1.jpg" class="rounded-circle user_img"
                                                    alt="">
                                                <span class="online_icon"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>Archie Parker</span>
                                                <p>Kalid is online</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dlab-chat-user">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="/images/avatar/2.jpg" class="rounded-circle user_img"
                                                    alt="">
                                                <span class="online_icon offline"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>Alfie Mason</span>
                                                <p>Taherah left 7 mins ago</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dlab-chat-user">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="/images/avatar/3.jpg" class="rounded-circle user_img"
                                                    alt="">
                                                <span class="online_icon"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>AharlieKane</span>
                                                <p>Sami is online</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dlab-chat-user">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="/images/avatar/4.jpg" class="rounded-circle user_img"
                                                    alt="">
                                                <span class="online_icon offline"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>Athan Jacoby</span>
                                                <p>Nargis left 30 mins ago</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="name-first-letter">B</li>
                                    <li class="dlab-chat-user">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="/images/avatar/5.jpg" class="rounded-circle user_img"
                                                    alt="">
                                                <span class="online_icon offline"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>Bashid Samim</span>
                                                <p>Rashid left 50 mins ago</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dlab-chat-user">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="/images/avatar/1.jpg" class="rounded-circle user_img"
                                                    alt="">
                                                <span class="online_icon"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>Breddie Ronan</span>
                                                <p>Kalid is online</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dlab-chat-user">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="/images/avatar/2.jpg" class="rounded-circle user_img"
                                                    alt="">
                                                <span class="online_icon offline"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>Ceorge Carson</span>
                                                <p>Taherah left 7 mins ago</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="name-first-letter">D</li>
                                    <li class="dlab-chat-user">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="/images/avatar/3.jpg" class="rounded-circle user_img"
                                                    alt="">
                                                <span class="online_icon"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>Darry Parker</span>
                                                <p>Sami is online</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dlab-chat-user">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="/images/avatar/4.jpg" class="rounded-circle user_img"
                                                    alt="">
                                                <span class="online_icon offline"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>Denry Hunter</span>
                                                <p>Nargis left 30 mins ago</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="name-first-letter">J</li>
                                    <li class="dlab-chat-user">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="/images/avatar/5.jpg" class="rounded-circle user_img"
                                                    alt="">
                                                <span class="online_icon offline"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>Jack Ronan</span>
                                                <p>Rashid left 50 mins ago</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dlab-chat-user">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="/images/avatar/1.jpg" class="rounded-circle user_img"
                                                    alt="">
                                                <span class="online_icon"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>Jacob Tucker</span>
                                                <p>Kalid is online</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dlab-chat-user">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="/images/avatar/2.jpg" class="rounded-circle user_img"
                                                    alt="">
                                                <span class="online_icon offline"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>James Logan</span>
                                                <p>Taherah left 7 mins ago</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dlab-chat-user">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="/images/avatar/3.jpg" class="rounded-circle user_img"
                                                    alt="">
                                                <span class="online_icon"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>Joshua Weston</span>
                                                <p>Sami is online</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="name-first-letter">O</li>
                                    <li class="dlab-chat-user">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="/images/avatar/4.jpg" class="rounded-circle user_img"
                                                    alt="">
                                                <span class="online_icon offline"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>Oliver Acker</span>
                                                <p>Nargis left 30 mins ago</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="dlab-chat-user">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont">
                                                <img src="/images/avatar/5.jpg" class="rounded-circle user_img"
                                                    alt="">
                                                <span class="online_icon offline"></span>
                                            </div>
                                            <div class="user_info">
                                                <span>Oscar Weston</span>
                                                <p>Rashid left 50 mins ago</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card chat dlab-chat-history-box d-none">
                            <div class="card-header chat-list-header text-center">
                                <a href="javascript:void(0);" class="dlab-chat-history-back">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3"
                                                transform="translate(15.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-15.000000, -12.000000) "
                                                x="14" y="7" width="2" height="10" rx="1" />
                                            <path
                                                d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z"
                                                fill="#000000" fill-rule="nonzero"
                                                transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997) " />
                                        </g>
                                    </svg>
                                </a>
                                <div>
                                    <h6 class="mb-1">Chat with Khelesh</h6>
                                    <p class="mb-0 text-success">Online</p>
                                </div>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown"
                                        aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                            viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24" />
                                                <circle fill="#000000" cx="5" cy="12" r="2" />
                                                <circle fill="#000000" cx="12" cy="12" r="2" />
                                                <circle fill="#000000" cx="19" cy="12" r="2" />
                                            </g>
                                        </svg></a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li class="dropdown-item"><i class="fa fa-user-circle text-primary me-2"></i>
                                            View profile</li>
                                        <li class="dropdown-item"><i class="fa fa-users text-primary me-2"></i> Add to
                                            btn-close friends</li>
                                        <li class="dropdown-item"><i class="fa fa-plus text-primary me-2"></i> Add to
                                            group</li>
                                        <li class="dropdown-item"><i class="fa fa-ban text-primary me-2"></i> Block
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body msg_card_body dlab-scroll" id="DLAB_W_Contacts_Body3">
                                <div class="d-flex justify-content-start mb-4">
                                    <div class="img_cont_msg">
                                        <img src="/images/avatar/1.jpg" class="rounded-circle user_img_msg"
                                            alt="">
                                    </div>
                                    <div class="msg_cotainer">
                                        Hi, how are you samim?
                                        <span class="msg_time">8:40 AM, Today</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mb-4">
                                    <div class="msg_cotainer_send">
                                        Hi Khalid i am good tnx how about you?
                                        <span class="msg_time_send">8:55 AM, Today</span>
                                    </div>
                                    <div class="img_cont_msg">
                                        <img src="/images/avatar/2.jpg" class="rounded-circle user_img_msg"
                                            alt="">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-4">
                                    <div class="img_cont_msg">
                                        <img src="/images/avatar/1.jpg" class="rounded-circle user_img_msg"
                                            alt="">
                                    </div>
                                    <div class="msg_cotainer">
                                        I am good too, thank you for your chat template
                                        <span class="msg_time">9:00 AM, Today</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mb-4">
                                    <div class="msg_cotainer_send">
                                        You are welcome
                                        <span class="msg_time_send">9:05 AM, Today</span>
                                    </div>
                                    <div class="img_cont_msg">
                                        <img src="/images/avatar/2.jpg" class="rounded-circle user_img_msg"
                                            alt="">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-4">
                                    <div class="img_cont_msg">
                                        <img src="/images/avatar/1.jpg" class="rounded-circle user_img_msg"
                                            alt="">
                                    </div>
                                    <div class="msg_cotainer">
                                        I am looking for your next templates
                                        <span class="msg_time">9:07 AM, Today</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mb-4">
                                    <div class="msg_cotainer_send">
                                        Ok, thank you have a good day
                                        <span class="msg_time_send">9:10 AM, Today</span>
                                    </div>
                                    <div class="img_cont_msg">
                                        <img src="/images/avatar/2.jpg" class="rounded-circle user_img_msg"
                                            alt="">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-4">
                                    <div class="img_cont_msg">
                                        <img src="/images/avatar/1.jpg" class="rounded-circle user_img_msg"
                                            alt="">
                                    </div>
                                    <div class="msg_cotainer">
                                        Bye, see you
                                        <span class="msg_time">9:12 AM, Today</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-4">
                                    <div class="img_cont_msg">
                                        <img src="/images/avatar/1.jpg" class="rounded-circle user_img_msg"
                                            alt="">
                                    </div>
                                    <div class="msg_cotainer">
                                        Hi, how are you samim?
                                        <span class="msg_time">8:40 AM, Today</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mb-4">
                                    <div class="msg_cotainer_send">
                                        Hi Khalid i am good tnx how about you?
                                        <span class="msg_time_send">8:55 AM, Today</span>
                                    </div>
                                    <div class="img_cont_msg">
                                        <img src="/images/avatar/2.jpg" class="rounded-circle user_img_msg"
                                            alt="">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-4">
                                    <div class="img_cont_msg">
                                        <img src="/images/avatar/1.jpg" class="rounded-circle user_img_msg"
                                            alt="">
                                    </div>
                                    <div class="msg_cotainer">
                                        I am good too, thank you for your chat template
                                        <span class="msg_time">9:00 AM, Today</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mb-4">
                                    <div class="msg_cotainer_send">
                                        You are welcome
                                        <span class="msg_time_send">9:05 AM, Today</span>
                                    </div>
                                    <div class="img_cont_msg">
                                        <img src="/images/avatar/2.jpg" class="rounded-circle user_img_msg"
                                            alt="">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-4">
                                    <div class="img_cont_msg">
                                        <img src="/images/avatar/1.jpg" class="rounded-circle user_img_msg"
                                            alt="">
                                    </div>
                                    <div class="msg_cotainer">
                                        I am looking for your next templates
                                        <span class="msg_time">9:07 AM, Today</span>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mb-4">
                                    <div class="msg_cotainer_send">
                                        Ok, thank you have a good day
                                        <span class="msg_time_send">9:10 AM, Today</span>
                                    </div>
                                    <div class="img_cont_msg">
                                        <img src="/images/avatar/2.jpg" class="rounded-circle user_img_msg"
                                            alt="">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-start mb-4">
                                    <div class="img_cont_msg">
                                        <img src="/images/avatar/1.jpg" class="rounded-circle user_img_msg"
                                            alt="">
                                    </div>
                                    <div class="msg_cotainer">
                                        Bye, see you
                                        <span class="msg_time">9:12 AM, Today</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer type_msg">
                                <div class="input-group">
                                    <textarea class="form-control" placeholder="Type your message..."></textarea>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-primary"><i
                                                class="fa fa-location-arrow"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="alerts" role="tabpanel">
                        <div class="card mb-sm-3 mb-md-0 contacts_card">
                            <div class="card-header chat-list-header text-center">
                                <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <circle fill="#000000" cx="5" cy="12" r="2" />
                                            <circle fill="#000000" cx="12" cy="12" r="2" />
                                            <circle fill="#000000" cx="19" cy="12" r="2" />
                                        </g>
                                    </svg></a>
                                <div>
                                    <h6 class="mb-1">Notications</h6>
                                    <p class="mb-0">Show All</p>
                                </div>
                                <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                                fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                            <path
                                                d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                                fill="#000000" fill-rule="nonzero" />
                                        </g>
                                    </svg></a>
                            </div>
                            <div class="card-body contacts_body p-0 dlab-scroll" id="DLAB_W_Contacts_Body1">
                                <ul class="contacts">
                                    <li class="name-first-letter">SEVER STATUS</li>
                                    <li class="active">
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont primary">KK</div>
                                            <div class="user_info">
                                                <span>David Nester Birthday</span>
                                                <p class="text-primary">Today</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="name-first-letter">SOCIAL</li>
                                    <li>
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont success">RU</div>
                                            <div class="user_info">
                                                <span>Perfection Simplified</span>
                                                <p>Jame Smith commented on your status</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="name-first-letter">SEVER STATUS</li>
                                    <li>
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont primary">AU</div>
                                            <div class="user_info">
                                                <span>AharlieKane</span>
                                                <p>Sami is online</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex bd-highlight">
                                            <div class="img_cont info">MO</div>
                                            <div class="user_info">
                                                <span>Athan Jacoby</span>
                                                <p>Nargis left 30 mins ago</p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="notes">
                        <div class="card mb-sm-3 mb-md-0 note_card">
                            <div class="card-header chat-list-header text-center">
                                <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect fill="#000000" x="4" y="11" width="16" height="2"
                                                rx="1" />
                                            <rect fill="#000000" opacity="0.3"
                                                transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) "
                                                x="4" y="11" width="16" height="2" rx="1" />
                                        </g>
                                    </svg></a>
                                <div>
                                    <h6 class="mb-1">Notes</h6>
                                    <p class="mb-0">Add New Nots</p>
                                </div>
                                <a href="javascript:void(0);"><svg xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px"
                                        viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24" />
                                            <path
                                                d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                                fill="#000000" fill-rule="nonzero" opacity="0.3" />
                                            <path
                                                d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                                fill="#000000" fill-rule="nonzero" />
                                        </g>
                                    </svg></a>
                            </div>
                            <div class="card-body contacts_body p-0 dlab-scroll" id="DLAB_W_Contacts_Body2">
                                <ul class="contacts">
                                    <li class="active">
                                        <div class="d-flex bd-highlight">
                                            <div class="user_info">
                                                <span>New order placed..</span>
                                                <p>10 Aug 2020</p>
                                            </div>
                                            <div class="ms-auto">
                                                <a href="javascript:void(0);"
                                                    class="btn btn-primary btn-xs sharp me-1"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                                <a href="javascript:void(0);" class="btn btn-danger btn-xs sharp"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex bd-highlight">
                                            <div class="user_info">
                                                <span>Youtube, a video-sharing website..</span>
                                                <p>10 Aug 2020</p>
                                            </div>
                                            <div class="ms-auto">
                                                <a href="javascript:void(0);"
                                                    class="btn btn-primary btn-xs sharp me-1"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                                <a href="javascript:void(0);" class="btn btn-danger btn-xs sharp"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex bd-highlight">
                                            <div class="user_info">
                                                <span>john just buy your product..</span>
                                                <p>10 Aug 2020</p>
                                            </div>
                                            <div class="ms-auto">
                                                <a href="javascript:void(0);"
                                                    class="btn btn-primary btn-xs sharp me-1"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                                <a href="javascript:void(0);" class="btn btn-danger btn-xs sharp"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex bd-highlight">
                                            <div class="user_info">
                                                <span>Athan Jacoby</span>
                                                <p>10 Aug 2020</p>
                                            </div>
                                            <div class="ms-auto">
                                                <a href="javascript:void(0);"
                                                    class="btn btn-primary btn-xs sharp me-1"><i
                                                        class="fas fa-pencil-alt"></i></a>
                                                <a href="javascript:void(0);" class="btn btn-danger btn-xs sharp"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Chat box End
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="search_bar dropdown">
                                <span class="search_icon p-3 c-pointer" data-bs-toggle="dropdown">
                                    <i class="mdi mdi-magnify"></i>
                                </span>
                                <div class="dropdown-menu p-0 m-0">
                                    <form>
                                        <input class="form-control"  id="page-search" type="search" placeholder="Search"
                                            aria-label="Search">
                                    </form>
                                </div>
                            </div>
                        </div>

                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell " id="fullscreenBtn" href="javascript:void(0);">
                                    <i class="fas fa-expand"></i>
                                </a>
                            </li>
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell dlab-theme-mode p-0" href="javascript:void(0);">
                                    <i id="icon-light" class="fas fa-sun"></i>
                                    <i id="icon-dark" class="fas fa-moon"></i>
                                </a>
                            </li>
                        
                          
                
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button"
                                    data-bs-toggle="dropdown">
                                    <img src="{{ asset('images/profile/education/user.jpg') }}" width="20"
                                        alt="" />
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" class="dropdown-item ai-icon no-pointer" >
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" width="18"
                                            height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-user">
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="12" cy="7" r="4"></circle>
                                        </svg>
                                        <span class="ms-2 ">{{ Auth::user()->user_nicename  }}  </span>
                                    </a>
                                    <hr>
                                                                      <a href="{{ route('wordpress.redirect') }}" class="dropdown-item ai-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <line x1="2" y1="12" x2="22" y2="12"></line>
                                            <line x1="12" y1="2" x2="12" y2="22"></line>
                                        </svg>
                                        <span class="ms-2">Login to Website</span>
                                    </a>

                                  
                                    <a href="{{ route('logout') }}" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" width="18"
                                            height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-log-out">
                                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                            <polyline points="16 17 21 12 16 7"></polyline>
                                            <line x1="21" y1="12" x2="9" y2="12">
                                            </line>
                                        </svg>
                                        <span class="ms-2">Logout </span>
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
        <div class="dlabnav">
            <div class="dlabnav-scroll">
                <ul class="metismenu" id="menu">

                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i _ngcontent-ucy-c89="" class="fas fa-file-alt"></i>
                            <span class="nav-text">Question Bank </span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('test') }}" style="font-size:14px;"><i
                                        class="la la-edit"></i>Create Test</a></li>
                            <li><a href="{{ route('previoustests') }}" style="font-size:14px;"><i
                                        class="la la-list-alt"></i>Previous Tests</a></li>
                            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"
                                    style="font-size:14px;"><i class="la la-chart-bar"></i>
                                    Performance</a>
                                <ul aria-expanded="false">
                                    <li><a href="{{ route('performance.overall') }}" style="font-size:14px;"><i
                                                class="la la-clipboard-check"></i>Overall</a></li>
                                    <li><a href="{{ route('report.index') }}" style="font-size:14px;"><i
                                                class="la la-chart-pie"></i>Reports</a></li>
                                    <li><a href="{{ route('performance.graph') }}" style="font-size:14px;"><i
                                                class="la la-chart-line"></i>Graphs</a></li>
                                </ul>
                            </li>
                        </ul>

                    </li>


                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fa-solid fa-map-signs"></i>
                            <span class="nav-text">Resources</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('study.plan') }}" style="font-size:14px;"><i class="la la-book"></i>Study
                                    Plan</a></li>
                            <li><a href="{{ route('act.book') }}" style="font-size:14px;"><i
                                        class="la la-comments"></i>ACT book</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="fas fa-tools"></i>
                            <span class="nav-text">Tools</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="{{ route('search') }}" style="font-size:14px;"><i
                                        class="la la-search"></i>Search</a></li>
                            <li><a href="{{ route('flashcards') }}" style="font-size:14px;"><i
                                        class="la la-bolt"></i>Flashcards</a></li>
                            <li><a href="{{ route('notebook') }}" style="font-size:14px;"><i class="la la-book"></i>My
                                    Notebook</a></li>
                        </ul>
                    </li>
                    <li><a class="has-arrow" href="{{ route('help') }}">
                        <i class="fas fa-question-circle"></i>
                        <span class="nav-text">Help</span>
                    </a>
                    </li>

                </ul>



            </div>
        </div>

        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        @yield('content')
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
    <!--<button id="readBtn2" onclick="toggleGlobalRead(getPageText(), 'readBtn2')" class="btn btn-primary btn-sm">-->
    <!--    ▶️ Read This-->
    <!--</button>-->
</div>

        </div>
        <!--**********************************
            Footer end
        ***********************************-->

    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('vendor/global/global.min.js') }}"></script>
    <!--<script src="{{ asset('public/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>-->
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>

    <!-- Chart sparkline plugin files -->
    <script src="{{ asset('vendor/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('js/plugins-init/sparkline-init.js') }}"></script>

    <!-- Chart Morris plugin files -->
    <script src="{{ asset('vendor/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('vendor/morris/morris.min.js') }}"></script>

    <!-- Init file -->
    <script src="{{ asset('js/plugins-init/widgets-script-init.js') }}"></script>

    <!-- Svganimation scripts -->
    <script src="{{ asset('vendor/svganimation/vivus.min.js') }}"></script>
    <script src="{{ asset('vendor/svganimation/svg.animation.js') }}"></script>

    <!-- Demo scripts -->
    <script src="{{ asset('js/dashboard/dashboard.js') }}"></script>

    <script src="{{ asset('js/custom.min.js') }}"></script>
    <script src="{{ asset('js/dlabnav-init.js') }}"></script>

    <script>
        document.getElementById('fullscreenBtn').addEventListener('click', function() {
            let elem = document.documentElement;
            let icon = this.querySelector('i');

            if (!document.fullscreenElement) {
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.mozRequestFullScreen) {
                    elem.mozRequestFullScreen();
                } else if (elem.webkitRequestFullscreen) {
                    elem.webkitRequestFullscreen();
                } else if (elem.msRequestFullscreen) {
                    elem.msRequestFullscreen();
                }
                icon.classList.remove('fa-expand');
                icon.classList.add('fa-compress');
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
                icon.classList.remove('fa-compress');
                icon.classList.add('fa-expand');
            }
        });
        
        
    </script>
<!-- Global Read Aloud Script -->
<script>
    let currentUtterance = null;
    let isReading = false;
    let isPaused = false;

    function getPageText() {
        const contentBody = document.querySelector('.content-body');
        return contentBody ? contentBody.innerText : "No readable content found.";
    }

    function toggleFloatingRead() {
        const button = document.getElementById('floatingReadButton');

        // Resume if paused
        if (isPaused) {
            window.speechSynthesis.resume();
            isPaused = false;
            button.innerText = "⏹️";
            return;
        }

        // Pause if already speaking
        if (isReading && !isPaused) {
            window.speechSynthesis.pause();
            isPaused = true;
            button.innerText = "▶️";
            return;
        }

        // Start new speech
        const textContent = getPageText();

        if (window.speechSynthesis.speaking) {
            window.speechSynthesis.cancel(); // cancel previous completely
        }

        currentUtterance = new SpeechSynthesisUtterance(textContent);
        currentUtterance.lang = 'en-US';
        currentUtterance.rate = 1;

        currentUtterance.onend = function () {
            button.innerText = "🔊";
            isReading = false;
            isPaused = false;
        };

        window.speechSynthesis.speak(currentUtterance);
        button.innerText = "⏹️";
        isReading = true;
        isPaused = false;
    }

    window.addEventListener('beforeunload', function () {
        window.speechSynthesis.cancel();
    });
    
$(document).ready(function () {
    function escapeRegExp(string) {
        return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    }

    function removeHighlights(context) {
        context.find("span.highlighted").each(function () {
            const text = $(this).text();
            $(this).replaceWith(text); // convert to plain text
        });
    }

    function highlightText(context, searchText) {
        const regex = new RegExp(escapeRegExp(searchText), "gi");

        context.contents().each(function () {
            if (this.nodeType === 3) {
                const text = this.nodeValue;
                if (regex.test(text)) {
                    const newHTML = text.replace(regex, match => `<span class="highlighted">${match}</span>`);
                    $(this).replaceWith(newHTML);
                }
            } else if (
                this.nodeType === 1 &&
                !["SCRIPT", "STYLE", "NOSCRIPT", "IFRAME", "TEXTAREA", "INPUT"].includes(this.tagName)
            ) {
                highlightText($(this), searchText);
            }
        });
    }

    $("#page-search").on("input", function () {
        const searchText = $(this).val();

        const context = $("body").not("script, style"); // avoid unwanted tags

        removeHighlights(context);

        if (searchText.length > 0) {
            highlightText(context, searchText);
        }
    });
});




</script>






@stack('scripts')
<!-- Floating Read Aloud Button -->
<button id="floatingReadButton" onclick="toggleFloatingRead()" style="
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 9999;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    font-size: 24px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    cursor: pointer;
">
    🔊
</button>

</body>

</html>
