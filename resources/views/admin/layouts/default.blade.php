<!DOCTYPE html>
<html>
{{getCurrentLang()}}
<head>
    <meta charset="UTF-8">
    <title>
        @section('title')
            | {{__('lang.관리자페이지')}}
        @show
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- global css -->
    @include("admin/layouts/style")
    @yield('header_styles')
    <!--end of page level css-->

<body class="skin-josh">
<input type = "file" id = "cropFileInput" class = "hidden" accept="image/*" />
<input type = "file" id = "cropFileInputNocrop" class = "hidden" accept="image/*" />
<script>
    var public_path = '{{url("/")}}';
    var _token = '{{csrf_token()}}';
</script>

<script>
    var lang_msg =  new Object();
    lang_msg['항목을 선택해주십시오'] = "{{__('lang.항목을 선택해주십시오')}}";
    lang_msg['정말 삭제하겟습니까?']="{{__('lang.정말 삭제하겟습니까?')}}";
    lang_msg['수정이 성공하었습니다.']="{{__('lang.수정이 성공하었습니다.')}}";
    lang_msg['검색어를 입력해 주세요(2자 이상)']="{{__('검색어를 입력해 주세요(2자 이상)')}}";
    lang_msg['일']="{{__('lang.일')}}";
    lang_msg['분']="{{__('lang.분')}}";
    lang_msg['초']="{{__('lang.초')}}";
    lang_msg['시간']="{{__('lang.시간')}}";
</script>
<style>

    /*.language-rect{
        position: absolute;
        top: 20px;
        right: 10px;
    }*/

    /*.language-rect .dropdown-menu {
        background: #222222;
        left: -34px;
        min-width: 135px;
        top: 15px;
    }*/

    /*.language-rect a{*/
        /*color:white;*/
    /*}*/

    /*.lang-item {*/
        /*margin-bottom: 3px;*/
        /*margin-left: 11px;*/
    /*}*/

    /*.lang-item.active a, .lang-item.active a:hover {*/
        /*background: transparent;*/
        /*color: red;*/
    /*}*/

    /*.lang-item span.fa.fa-check {*/
        /*position: absolute;*/
        /*left: 2px;*/
    /*}*/

</style>

<header class="header">
    <a href="{{ route('admin.dashboard') }}" class="logo">
        <?php $user = Sentinel::getuser();?>
        @if($user['type']*1 == 99)
            <img src="{{ asset('assets/images/log/logo_admin.png') }}" alt="logo">
        @else
                <img src="{{ asset('assets/images/log/logo_shop.png') }}" alt="logo">
        @endif
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <div class="responsive_nav"></div>
            </a>
        </div>
        <label class = "top-counter" id = "diff_time1">

        </label>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li class = "language-rect">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="riot">
                            <div>
                                <i class = "fa fa-globe" style = "margin-right:10px;"> </i>Language
                                <span>
                                    <i class="caret"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <li class = "lang-item @if(App::isLocale("vn")) active @endif">
                            <a href="javascript:void(0);" onclick = "setMyLang('vn')">
                                @if(App::isLocale("vn")) <span class = "fa fa-check" > </span> @endif Tiếng Việt
                            </a>
                        </li>
                        <li class = "lang-item @if(App::isLocale("kr")) active @endif">
                            <a href="javascript:void(0);" onclick = "setMyLang('kr')">
                                @if(App::isLocale("kr")) <span class = "fa fa-check" > </span> @endif 한국어
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="messages-menu">
                    <a href="{{ URL::to('admin/logout') }}" style = " color:white;">
                        <i class="livicon" data-name="sign-out" data-s="28" data-c="#6CC66C" data-hc="#6CC66C"></i>
                         {{__('lang.로그아웃')}}
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="wrapper ">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side ">
        <section class="sidebar ">
            <div class="page-sidebar  sidebar-nav">
                <div class="clearfix"></div>
                <!-- BEGIN SIDEBAR MENU -->
                @include('admin.layouts._left_menu')
                <!-- END SIDEBAR MENU -->
            </div>
        </section>
    </aside>
    <aside class="right-side">

        <!-- Notifications -->
        <div id="notific">
        @include('notifications')
        </div>

                <!-- Content -->
        @yield('content')

    </aside>
    <!-- right-side -->
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top"
   data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="arrow-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
<!-- global js -->
@include("admin/layouts/script")
<!-- end of global js -->
<!-- begin page level js -->
@yield('footer_scripts')
        <!-- end page level js -->
<script>
    function setMyLang(lang){
        var param = new Object();
        param._token = _token;
        param.lang = lang;
        $.post(public_path+"/setLang", param, function(data){
        if(data.status == "1"){
        window.location.reload();
        } else{
        errorMsg(data.msg);
        }
        },"json");
    }
</script>
</body>
</html>
