@extends('layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
   @lang('lang.메인')
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/tabbular.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/animate/animate.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/jquery.circliful.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/owl_carousel/css/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/owl_carousel/css/owl.theme.css') }}">
    <style>
        .recent-shop-ul li a {
            cursor: pointer;
            color:white;
        }

        .recent-shop-ul li:hover {
            /*background: #e84848;*/
            /*border-bottom: 3px solid #d7da1a;*/
        }

        .recent-shop-ul li{
            float: left;
            padding: 5px 10px;
            /*border:1px solid white;*/
        }
        .recent-shop-ul li.active{
            /*border:2px solid white;*/
            /*background: #e84848;*/
            border-bottom: 3px solid #D9534F;
        }
        .recent-shop-ul{
            overflow: auto;
            min-height: 40px;
            padding: 0px;
        }

        .top-img-rect{
            position: relative;
            padding-top: 150%;
            overflow: hidden;
            border: 1px solid #e2e2e2;
        }

        .schedule-img{
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            max-width: 100%;
            height: auto;
        }

        .top-content-rect {
            padding: 10px;
        }

        .horizontal-tab ul.tabs li {
            width: 100px;
            text-align: center;
            height: 120px;
            vertical-align: middle;
            word-break: break-all;
            position: relative;
        }

        .horizontal-tab ul.tabs li a {
            position: absolute;
            top: 50%;
            width: 100%;
            left: 0px;
            line-height:25px;
            text-align: center;
            margin-top: -10px;
        }



    </style>
    <!--end of page level css-->
@stop
{{-- slider --}}
{{-- content --}}
@section('content')
    <div class="container">
        <div class = "row">
            <div class = "col-md-9 col-xs-12">
                <div class = "border-box margin-box" id = "recent-shop-rect" style = "margin-top:10px; min-height:250px;">
                    <h3 class = "title" style = "text-align:center;"> <i class = "fa fa-fw fa-clock-o"></i>{{__('lang.최신 업소 스케줄')}}</h3>
                    <div class = "row ">
                        <div class = "col-md-12" style = "text-align:center;">
                            <ul class = "recent-shop-ul hidden-xs" style = "display: inline-block">
                                @foreach($shop_type_list as $key => $shop_type)
                                    <li class = "@if($schedule_type*1 == $shop_type['id']*1) active @endif">
                                        <a class = "schedule_recent_item" data-id = "{{$shop_type['id']}}" href = "javascript:void(0)" onclick1 = "refreshPage('{{$shop_type['id']}}')">
                                            {!!  shopTitleBreak($shop_type['title'])  !!}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                            <select class = "form-control hidden-sm hidden-md hidden-lg radius-0" name = "shop_type_select" onchange="refreshPageMobile()" style = "margin-bottom:10px;">
                                @foreach($shop_type_list as $key => $shop_type)
                                    <option value = "{{$shop_type['id']}}" @if($schedule_type*1 == $shop_type['id']*1) selected @endif >{{$shop_type['title']}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-6 col-xs-12 hidden">
                            <div class="media p-5">
                                <div class="media-left">
                                    <a href="{{url("/schedule_info/1")}}">
                                        <img onerror = "noExitImg(this)" class="media-object wh-60" src="{{correctImgPath('1.jpg')}}" alt="image">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <a href="{{url("/schedule_info/1")}}">
                                        <h5 class="media-heading text-primary" style = "color:#dfe0da;">{{utf8_strcut(strip_tags('12121212'), 50)}}</h5>
                                    </a>
                                    <span class="text-danger" style = "color:#8c8c8c;">2000-12-21</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @foreach($schedule_recent_list as $key1 => $schedule_item)
                        <div class = "schedule_content @if($key1 != 0) hidden @endif" id = "schedule_content_{{$key1}}" >
                        @foreach($schedule_item as $key => $item)
                            @if($key % 4 == 0)
                            <div class = "row">
                            @endif
                            <div class = "col-md-3 col-xs-12">
                                <div class = "top-img-rect">
                                    <a href="{{url("/schedule_info/".$item['id'])}}">
                                        <img onerror = "noExitImg(this)" class="schedule-img" src="{{correctImgPath($item['img'])}}" alt="image">
                                    </a>
                                </div>
                                <div class = "top-content-rect">
                                    <a href="{{url("/schedule_info/".$item['id'])}}">
                                        <h5 class="media-heading text-primary" style = "color:#dfe0da;word-break:break-all;">@if($item['is_force_end'] == "0"){{utf8_strcut(strip_tags($item['title']), 50)}} @else {{__('lang.마감 하였습니다')}} @endif </h5>
                                    </a>
                                    <span class="text-danger" style = "color:#8c8c8c;">{{substr($item['updated_at'],0,10)}}</span>
                                </div>
                            </div>
                            @if($key % 4 == 3 || $key == count($schedule_item)-1)
                            </div>
                            @endif
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <div class = "horizontal-tab  mt-10 margin-box hidden-xs">
                    <ul class = "tabs">
                        @foreach($shop_type_list as $key => $shop_type)
                            <li class = "@if($key*1 == 0) active @endif ">
                                <a class = "active" href ="#tab_default_{{$key}}" data-toggle = "tab">{{$shop_type['title']}}</a>
                            </li>
                        @endforeach
                    </ul>
                    <div class="tab-content">
                        @foreach($shop_type_list as $key => $shop_type)
                            <div class="tab-pane @if($key*1 == 0) active @endif" id="tab_default_{{$key}}">
                                <div class = "row">
                                    <div class = "col-md-6">
                                        <h3 class = "title-border">{{__('lang.최신 업소 후기')}}</h3>
                                        <ul class = "list-ul">
                                            @foreach($shop_type['recent_list'] as $board)
                                                <li class = "list-li">
                                                    <a href = "{{url("/review_info/".$board['id'])}}">
                                                        <div class = "ellipse left">{{utf8_strcut(strip_tags($board['title']), 50)}}</div>
                                                        <div class = "right"><i class = "fa fa-comment color-custom-red"></i><span class = "ml-5">{{$board['reply_count']}}</span></div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class = "col-md-6 pr-25">
                                        <h3 class = "title-border">{{__('lang.인기 업소 후기')}}</h3>
                                        <ul class = "list-ul">
                                            @foreach($shop_type['favorite_list'] as $board)
                                                <li class = "list-li">
                                                    <a href = "{{url("/review_info/".$board['id'])}}">
                                                        <div class = "ellipse left">{{utf8_strcut(strip_tags($board['title']), 50)}}</div>
                                                        <div class = "right"><i class = "fa fa-comment color-custom-red"></i><span class = "ml-5">{{$board['reply_count']}}</span></div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class = "row mt-10 border-box margin-box hidden">
                    @foreach($board_type_list as $board_type)
                        <div class = "col-md-6 col-xs-12 pl-0">
                            <h3 class = "title-border">{{$board_type['title']}}</h3>
                            <ul class = "list-ul">
                                @foreach($board_type['list'] as $board)
                                    <li class = "list-li">
                                        <a href = "{{url("/board_info/".$board['id'])}}">
                                            <div class = "ellipse left">{{utf8_strcut(strip_tags($board['title']), 50)}}</div>
                                            <div class = "right"><i class = "fa fa-comment"></i><span class = "ml-5">{{$board['reply_count']}}</span></div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class = "col-md-3 col-xs-12">
                @include('layouts/right-side')
            </div>
        </div>
    </div>
    <!-- //Container End -->
@stop
{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
    <script type="text/javascript" src="{{ asset('assets/js/frontend/jquery.circliful.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/wow/js/wow.min.js') }}" ></script>
    <script type="text/javascript" src="{{ asset('assets/vendors/owl_carousel/js/owl.carousel.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/carousel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/index.js') }}"></script>
    <script>
        $(function(){
            $(".schedule_recent_item").hover(function(){
                var schedule_id = $(this).attr("data-id");
                $(".schedule_recent_item").parent().removeClass("active");
                $(this).parent().addClass("active");
                $(".schedule_content").addClass("hidden");
                $("#schedule_content_"+schedule_id).removeClass("hidden");
            },
            function(){

            }
            );


            refreshPageMobile();
        });




        function refreshPage(id){
            window.location.href = "{{url('/')}}?schedule_type="+id;
        }

        function refreshPageMobile(){
            var id = $("select[name='shop_type_select']").val();
            //var schedule_id = $(this).attr("data-id");
            $(".schedule_recent_item").parent().removeClass("active");
            $(this).parent().addClass("active");
            $(".schedule_content").addClass("hidden");
            $("#schedule_content_"+id).removeClass("hidden");
            //window.location.href = "{{url('/')}}?schedule_type="+id;
        }
    </script>
    <!--page level js ends-->
@stop
