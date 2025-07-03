@extends('layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
    {{env('SITE_NAME')}}{{__('lang.갤러리')}}
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

    <!--end of page level css-->
@stop
{{-- slider --}}
{{-- content --}}
@section('content')
    <?php $user = Sentinel::getuser(); ?>
    <div class="container ">
        @if(isset($page_title))
        <div class = "row">
            <div class = "col-md-12 col-xs-12 page-title-wrapper">
                <span class = ""> {{$page_title}}</span>
            </div>
        </div>
        @endif
        @if(isset($notice_list))
        @foreach($notice_list as $item)
            <a href = "{{url('/ebza_board/info/'.$item['id'])}}">
            <div class = "row page-title-wrapper">
                <div class = "col-md-10 margin-box border-right">
                    <span class ="badge-warning">{{__('lang.공지')}}</span>
                    <span>{{utf8_strcut(strip_tags($item['title']),150)}}</span>
                </div>
                <div class = "col-md-2 hidden-xs text-right"><span class = "pr-10 border-right">{{$item['user']['nickname']}}</span> <span class = "pl-10">{{getMsgTimeStr($item['created_at'])}}</span></div>
            </div>
            </a>
        @endforeach
        @endif
        <?php $user_info = getLoginUserInfo();?>

        <div class = "row ">
            <div class = "col-md-9 col-xs-12 mt-10">
                <div class="row text-center">
                    @foreach($list as $item)
                    <div class="col-md-3 col-sm-5 profile " >
                        <div class="thumbnail bg-white relative">
                            @if(Sentinel::check() && ($user_info['type']*1 == 99 || $user_info['id']*1 == $item['user']['id']*1) )
                            <a class = "board-trash hidden" href = "javascript:void(0)" onclick = "delItem(this)" data-id = "{{$item['id']}}" ><i class = "fa fa-trash"></i></a>
                            <a class = "board-write hidden" href = "{{url('ebza_board/write/'.$item['id'])}}" ><i class = "fa fa-pencil"></i></a>
                            @endif
                            <a href = "{{url('/ebza_board/info/'.$item['id'])}}">
                                <img class = "same-img" src="{{ correctImgPath($item['img']) }}" alt="team-image" class="img-responsive" onerror="noExitImg(this)">
                            </a>
                            <div class="caption color-white">
                                <b class = "color-white">
                                    <img onerror = "noExitImg(this)" style="width:20px !important;" src="{{url($item['level_icon'])}}" @if(isset($user['id']) && $item['user']['id']*1 != $user['id']*1) onclick = "menuItemClick1(this)" @endif>
                                    <span class = "cursor" @if(isset($user['id']) && $item['user']['id']*1 != $user['id']*1) onclick = "menuItemClick1(this)" @else  onclick = "userOnlyWrite(this)" @endif data-user-id ="{{$item['user_id']}}">{{utf8_strcut(strip_tags($item['user']['nickname']), 30)}}</span>
                                    <ul class = "td-click-menu hidden">
                                        <li><a href = "javascript:void(0);" onclick = "showSendNoteDlg(this)" data-user-id = "{{$item['user_id']}}"  >{{__('lang.쪽지보내기')}}</a></li>
                                        <li><a href = "javascript:void(0);" onclick = "showUserInfoDlg(this)" data-user-id = "{{$item['user_id']}}" >{{__('lang.회원정보')}}</a></li>
                                        <li><a href = "javascript:void(0);" onclick = "userOnlyWrite(this)" data-user-id ="{{$item['user_id']}}">{{__('lang.작성게시글 보기')}}</a></li>
                                    </ul>
                                </b>
                                <p class="content color-white"> {{utf8_strcut(strip_tags($item['title']), 30)}}</p>
                                <div class="divide">
                                    <div class = "row mt-10">
                                        <div class = "col-md-6 col-xs-6">
                                            <a href="{{url('/ebza_board/info/'.$item['id'])}}" class="divider">
                                                <i class="fa fa-eye"></i><span class = "ml-5">{{$item['view_count']}}</span>
                                            </a>
                                        </div>
                                        <div class = "col-md-6 col-xs-6">
                                            <a href="{{url('/ebza_board/info/'.$item['id'])}}" class="divider">
                                                <i class="fa fa-comment"></i><span class = "ml-5">{{$item['reply_count']}}</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class = "row">
                    <div class = "col-md-8 text-left col-xs-12">
                        <form id = "searchForm" action = "{{url('ebza_board')}}" method = "post">
                            <input type = "hidden" name ="_token" value ="{{csrf_token()}}"/>
                            <input type = "hidden" name = "page" value = "{{$pageParam['pageNo']}}"/>
                            <input type = "hidden" name = "user_id" value = "{{$user_id}}"/>
                            <div class = "row">
                                <div class = "col-md-6 mt-10 mb-10" style = "margin-top:8px;">
                                    <select class = "form-control search-select radius-0" name = "search_type" style ="height:38px;">
                                        <option value ="getUserNickname(user_id)" @if($search_type == 'getUserNickname(user_id)') selected @endif>{{__('lang.닉네임')}}</option>
                                        <option value ="title" @if($search_type == 'title') selected @endif>{{__('lang.제목')}}</option>
                                        <option value ="title&content" @if($search_type == 'title&content') selected @endif>{{__('lang.제목')}}&{{__('lang.내용')}}</option>
                                        <option value ="reply" @if($search_type == 'reply') selected @endif>{{__('lang.댓글')}}</option>
                                    </select>
                                </div>
                                <div class = "col-md-6 mt-10 mb-10" style = "display:table;margin-top:8px;">
                                    <input type = "text" class = "form-control search-input radius-0"  style ="height:38px;" name = "search_title" value ="{{$search_title}}" placeholder ="{{__('lang.검색어를 입력해주세요')}}">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default radius-0" type="button" onclick = "searchData(0)" style = "background: black;color: white; height:38px;">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class = "col-md-4 text-right mt-10 col-xs-12" style = "margin-top:17px;">
                        @if(Sentinel::check())
                            <a class = "color-white write-a btn-danger border-none"  href = "{{url("ebza_board/write/0")}}" style = "color:white;">{{__('lang.글쓰기')}}</a>
                        @endif
                    </div>
                </div>
                <div class = "text-center " style = "margin-top:10px;">
                    @include("layouts/pagination")
                </div>
            </div>

            <div class = "col-md-3 hidden-xs">
                @include('layouts/right-side')
            </div>
        </div>
    </div>
    <!-- //Container End -->
@stop
{{-- footer scripts --}}
@section('footer_scripts')
    <!-- page level js starts-->
    <!--page level js ends-->
    <script>
        function userOnlyWrite(obj){
            var user_id = $(obj).attr("data-user-id");
            $("#searchForm input[name='page']").val("0");
            $("#searchForm input[name='user_id']").val(user_id);
            $("#searchForm").submit();
        }

        $(function(){
           $(".thumbnail").hover(function(){
                $(this).find(".board-trash").removeClass("hidden");
                $(this).find(".board-write").removeClass("hidden");
           }, function(){
               $(this).find(".board-trash").addClass("hidden");
               $(this).find(".board-write").addClass("hidden");
           });

        });

        function  delItem(obj){
            var id = $(obj).attr("data-id");
            confirmMsg("{{__('lang.정말 삭제하겟습니까?')}}", function(){
                setTimeout(function(){
                    var param = new Object();
                    param._token = _token;
                    param.id = id;
                    var url = "{{url("/ebza_board/deleteInfo")}}";
                    loading_start();
                    $.post(url, param, function(data){
                        if(data.status == "1"){
                            successMsg("{{__('lang.삭제가 성공하었습니다.')}}", function(){
                                window.location.reload();
                            });
                        }else{
                            loading_stop();
                            errorMsg(data.msg);
                        }
                    }, "json");
                }, 500);
            });
        }

        function searchData(page) {
            $("#searchForm input[name='page']").val(page);
            $("#searchForm").submit();
        }

        $(function(){
            var url = $("#searchForm").attr("action")+"?"+$("#searchFrm").serialize();
            setPageUrl(url);
        });

        $(function(){

               $(".same-img").each(function(){
                   $(this).css("height", $(this).width()+"px");
               });

               loading_stop();


        });
    </script>

@stop
