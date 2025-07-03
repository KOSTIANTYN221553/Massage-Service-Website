<!DOCTYPE html>
<html>
{{getCurrentLang()}}
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <title>
    	@section('title')
        | {{__('lang.SITE_NAME')}}
        @show
    </title>
    <!--global css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/lib.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/simple-line-icons/css/simple-line-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendors/ionicons/css/ionicons.min.css') }}" />
    <link href="{{ asset('assets/css/pages/icon.css') }}" rel="stylesheet" type="text/css" />
    <!--end of global css-->
    <!--page level css-->
    @include("layouts/style")
    @yield('header_styles')
    <!--end of page level css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/base.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/common.css') }}">
    <input type = "file" id = "cropFileInput" class = "hidden" accept="image/*" />
    <input type = "file" id = "cropFileInputNocrop" class = "hidden" accept="image/*" />
    <script>
        var public_path = '{{url("/")}}';
        var _token = '{{csrf_token()}}';
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/lib.js') }}"></script>
    @include("admin/layouts/script")

    <style>
        .language-rect{
            position: absolute;
            top: 20px;
            right: 10px;
        }

        .language-rect .dropdown-menu {
            background: #222222;
            left: -34px;
            min-width: 135px;
            top: 15px;
        }

        .language-rect a{
            color:white;
        }

        .lang-item {
            margin-bottom: 3px;
            margin-left: 11px;
        }

        .lang-item.active a, .lang-item.active a:hover {
            background: transparent;
            color: red;
        }

        .lang-item span.fa.fa-check {
            position: absolute;
            left: 2px;
        }

    </style>
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

</head>

<body>
    <!-- Header Start -->
    <header>
        <!-- Icon Section Start -->
        <div class="icon-section">
            <div class="container">
                <ul class="list-inline" style = "position:relative;">
                    <li class = "" style = "width: 100%;text-align: center;position:relative;">
                        <img onerror = "noExitImg(this)"  class = "main-left hidden hidden-xs" src="{{ asset('assets/img/left.png') }}" alt="logo">
                        <a href = "{{url("/")}}">
                            <img onerror = "noExitImg(this)" src="{{ asset('assets/images/log/logo_main_2.png') }}"  style = "width:300px;" alt="logo">
                        </a>
                        <img onerror = "noExitImg(this)"  class = "main-right hidden hidden-xs" src="{{ asset('assets/img/right.png') }}" alt="logo">
                    </li>
                    <li class="pull-right">
                        <div class = "language-rect">
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
                        </div>

                        <ul class="list-inline icon-position">
                            <li>


                            </li>
                            <li class ="hidden">
                                <a href="mailto:"><i class="livicon" data-name="mail" data-size="18" data-loop="true" data-c="#fff" data-hc="#fff"></i></a>
                                <label class="hidden-xs"><a href="mailto:" class="text-white hidden">info@ddbam.com</a></label>
                            </li>
                            <li class ="hidden-sm hidden-md hidden-lg hidden">
                                <a href="{{url("login-user")}}"><i class="livicon" data-name="user" data-size="18" data-loop="true" data-c="#fff" data-hc="#fff"></i></a>
                            </li>
                            <li class = "hidden">
                                <a href="tel:"><i class="livicon" data-name="phone" data-size="18" data-loop="true" data-c="#fff" data-hc="#fff"></i></a>
                                <label class="hidden-xs"><a href="tel:" class="text-white">{{__('lang.전화번호')}} (703) 717-4200</a></label>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <!-- //Icon Section End -->
        <!-- Nav bar Start -->
        <nav class="navbar navbar-default container">
            <button type="button" class="navbar-toggle collapsed" onclick = "toggleMenuView(this)" data-target="#collapse">
                    <span><a href="#"><i class="livicon" data-name="responsive-menu" data-size="25" data-loop="true" data-c="#fff" data-hc="#fff"></i>
                    </a></span>
            </button>

            <div class="collapse navbar-collapse" id="collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li {!! (Request::is('/') ? 'class="active"' : '') !!}><a href="{{ route('home') }}">{{__('lang.메인')}}</a>
                    </li>
                    <li class="dropdown {!! (Request::is('schedule/*')  || Request::is('schedule_info/*') || Request::is('question') || Request::is('question/*')  ? 'active' : '') !!}"><a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('lang.업소스케쥴')}}</a>
                        <?php $menu_arr1 = getShopTypeList();?>
                        <ul class="dropdown-menu" role="menu">
                            @foreach($menu_arr1 as $menu)
                            <li>
                                <a href="{{ url('schedule/'.$menu['id']) }}">{{$menu['title']}}</a>
                            </li>
                            @endforeach
                            <li>
                                <a href="{{url("question")}}">{{__('lang.제휴문의')}}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown {!! (Request::is('review/*') || Request::is('review_info/*')  ? 'active' : '') !!}"><a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('lang.업소후기')}}</a>
                        <ul class="dropdown-menu" role="menu">
                            @foreach($menu_arr1 as $menu)
                                <li><a href="{{ url("review/".$menu['id']) }}">{{$menu['title']}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="dropdown {!! (Request::is('board/*') || Request::is('board_info/*') ? 'active' : '') !!}">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> {{__('lang.커뮤니티')}}</a>
                        <?php $menu_arr3 = getBoardTypeList();?>
                        <ul class="dropdown-menu" role="menu">
                            @foreach($menu_arr3 as $key=>$menu)
                            <li><a href="{{ url("board"."/".$key) }}">{{__('lang.'.$menu)}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="dropdown {!! (Request::is('ebza_board/*') || Request::is('ebza_board') || Request::is('user_board') ? 'active' : '') !!}">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">{{__('lang.갤러리')}}</a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="{{ URL::to('ebza_board') }}">{{__('lang.'.env('SITE_NAME'))}}{{__('lang.갤러리')}}</a>
                            </li>
                            <li><a href="{{ URL::to('user_board') }}">{{__('lang.유저갤러리')}}</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown {!! (Request::is('notice/*')  || Request::is('advice_info/*') || Request::is('advice') || Request::is('advice/*') || Request::is('guide')  ? 'active' : '') !!}">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{__('lang.회원센터')}}</a>
                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{url('notice')}}">{{__('lang.공지사항')}}</a>
                            </li>
                            <li>
                                <a href="{{url('advice')}}">{{__('lang.건의사항')}}</a>
                            </li>
                            <li>
                                <a href="{{url('guide')}}">{{__('lang.계급과 포인트 가이드')}}</a>
                            </li>
                        </ul>
                    </li>
                    @if(Sentinel::check())
                    <li {!! (Request::is('chatting') ? 'class="active"' : '') !!}><a href="{{ url('chatting') }}">{{__('lang.채팅방')}}</a>
                    @endif
                    <li class = "@if(Request::is('/login-user'))active @endif hidden-lg hidden-md hidden-sm"><a href="{{ url('login-user') }}">@if(!Sentinel::check()) {{__('lang.로그인')}} @else {{__('lang.회원정보')}} @endif</a>
                    <li class = "@if(Request::is('/user_register'))active @endif hidden-lg hidden-md hidden-sm"><a href="{{ url('user_register') }}">{{__('lang.회원가입')}}</a></li>
                    @if(Sentinel::check())
                        <li class = "hidden-lg hidden-md hidden-sm"><a href="{{ url('logout') }}">{{__('lang.로그아웃')}}</a></li>
                    @endif
                </ul>
            </div>
        </nav>
        <!-- Nav bar End -->
    </header>
    <!-- //Header End -->
    
    <!-- slider / breadcrumbs section -->
    @yield('top')

    <!-- Content -->
    @yield('content')
    @include('dlg/note_dlg')
    @include('dlg/note_send_dlg')
    @include('dlg/note_view_dlg')
    @include('dlg/user_info_dlg')
    @yield('footer_scripts')
    <div class="copyright footer mt-10">
        <div class="container">
        <p>Copyright &copy; ddbam, 2020</p>
        </div>
    </div>
    <a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top" data-toggle="tooltip" data-placement="left">
        <i class="livicon" data-name="arrow-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
    </a>
    <!--global js starts-->

    <!--global js end-->
    <!-- begin page level js -->

    <script>
        $(".dropdown-toggle").click(function(){
           if(!$(this).parent().hasClass("open")){
                $(".dropdown ").removeClass("open");
                $(this).parent().addClass("open")
           }else{
               $(this).parent().removeClass("open")
           }
        });
    </script>
    <!-- end page level js -->
    <script>
        function closeNoteDlg(){
            window.location.reload();
        }


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

        function delNote(obj){
            confirmMsg("{{__('lang.정말 삭제하겟습니까?')}}", function(){
               var id = $(obj).attr("data-id");
               var param = new Object();
               param.id = id;
               param._token = _token;
               var url = "{{url("dlg/note_del")}}";
               setTimeout(function(){
                   loading_start();
                   $.post(url, param, function(data){
                      if(data.status == "1"){
                          successMsg("{{__('lang.삭제가 성공하었습니다.')}}", function(){
                              $(obj).closest("tr").remove();
                          });
                      } else{
                          errorMsg(data.msg);
                      }
                   }, "json");
               },500);

            });
        }

        function note_view(obj){
            var id = $(obj).attr("data-id");
            var param = new Object();
            param.id = id;
            param._token = _token;
            var url = "{{url('/dlg/note_view')}}";
            loading_start();
            $.post(url, param, function(html){
                loading_stop();
               $("#note-view-dialog #dlg_content").html(html);
               $("#note-view-dialog").modal("show");
            });
        }
        function showNoteDlg(obj){
            var user_id = $(obj).attr("data-user-id");
            var param = new Object();
            param.user_id = user_id;
            param._token = _token;
            var url = "{{url('dlg/note_list')}}";
            loading_start();
            $.post(url, param, function(html){
                loading_stop();
                $("#note-dialog #content").html(html);
                $("#note-dialog input[name='user_id']").val(user_id);
                $("#note-dialog").modal("show");
            });
        }

        function refreshNoteList(){
            var user_id = $("#note-dialog input[name='user_id']").val();
            var param = new Object();
            param.user_id = user_id;
            param._token = _token;
            loading_start();
            var url = "{{url('dlg/note_list1')}}";
            $.post(url, param, function(html){
                loading_stop();
                $("#note-dialog #content").html(html);
            });
        }

        function showSendNoteDlg(obj){
            var user_id = $(obj).attr("data-user-id");
            var param = new Object();
            param._token = _token;
            param.user_id = user_id;
            var url = "{{url('dlg/note_send_dlg_content')}}";
            loading_start();
            $.post(url, param, function(html){
                loading_stop();
                $(obj).closest(".td-click-menu").addClass("hidden");
                $("#note-send-dialog #dlg_content").html(html);
                $("#note-send-dialog").modal("show");
            });

        }

        function saveNoteInfo(){
            //$("#note_send_form #note_send_form_btn").click();
            $("#note_send_form").submit();
        }

        function showUserInfoDlg(obj){
            var user_id = $(obj).attr("data-user-id");
            var param = new Object();
            param._token = _token;
            param.user_id = user_id;
            var url = "{{url('/dlg/getUserInfo')}}";
            loading_start();
            $.post(url, param, function(html){
                loading_stop();
                $(obj).closest(".td-click-menu").addClass("hidden");
                $("#user-info-dialog #content").html(html);
                $("#user-info-dialog").modal("show");
            });
        }

        function menuItemClick(obj){
            if($(obj).find(".td-click-menu").hasClass("hidden")){
                $(obj).find(".td-click-menu").removeClass("hidden");
            }else{
                $(obj).find(".td-click-menu").addClass("hidden");
            }
        }

        function menuItemClick1(obj){
            if($(obj).parent().find(".td-click-menu").hasClass("hidden")){
                $(obj).parent().find(".td-click-menu").removeClass("hidden");
            }else{
                $(obj).parent().find(".td-click-menu").addClass("hidden");
            }
        }

    </script>
</body>

</html>
