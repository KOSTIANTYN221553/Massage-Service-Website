@extends('layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
{{$board_type_str}}
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <!--end of page level css-->
@stop
{{-- slider --}}
{{-- content --}}
@section('content')
    <div class="container mt-10">
        @if(isset($page_title))
            <div class = "row">
                <div class = "col-md-12 col-xs-12 page-title-wrapper">
                    <span class = ""> {{$page_title}}</span>
                </div>
            </div>
        @endif
        @if(isset($notice_list))
            @foreach($notice_list as $item)
                <a href = "{{url('/board_info/'.$item['id'])}}">
                    <div class = "row page-title-wrapper">
                        <div class = "col-md-10 margin-box border-right">
                            <span class ="badge-warning">{{__('lang.공지')}}</span>
                            <span>{{utf8_strcut(strip_tags($item['title']),150)}}</span>
                        </div>
                        <div class = "col-md-2 text-right hidden-xs"><span class = "pr-10 border-right">{{$item['user']['nickname']}}</span> <span class = "pl-10">{{getMsgTimeStr($item['created_at'])}}</span></div>
                    </div>
                </a>
            @endforeach
        @endif
        <?php $user_info = getLoginUserInfo();?>
        <div class ="row">
            <div class = "col-md-9 col-xs-12">
                @if(isset($category_list))
                    <div class="row">
                        <div class = "col-md-12 col-xs-12 margin-box">
                            <ul class = "category_list">
                                @foreach($category_list as $item)
                                    <li class = "cursor @if($item['id']*1 == $category_id*1) active @endif" onclick = "changeCategoryItem(this)" data-id = "{{$item['id']}}"> {{$item['title']}}({{$item['cnt']}})</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class = "col-md-12">
                        <div class = "table-scrollable"  style = "overflow: visible;">
                            <table class = "table  table-striped  table-board">
                                <thead>
                                    <tr>
                                        <th class = "text-center" style = "width:3%">No</th>
                                        <th class = "text-center" style = "width:35%;">{{__('lang.제목')}}</th>
                                        <th class = "text-center" style = "width:15%;">{{__('lang.닉네임')}}</th>
                                        <th class = "text-center hidden-xs" style = "width:10%;"><span class ="hidden-xs">{{__('lang.조회수')}}</span></th>
                                        <th class = "text-center hidden-xs" style = "width:12%;">{{__('lang.날짜')}}</th>
                                        <th class ="hidden-xs" style = "width:10%;"><span class ="hidden-xs">{{__('lang.관리')}}</span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $key => $item)
                                    <tr class = "cursor">
                                        <td class = "text-center" onclick = "detailView(this)" data-id = "{{$item['id']}}">{{$key+$pageParam['startNumber']+1}}</td>
                                        <td class = "text-left" onclick = "detailView(this)" data-id = "{{$item['id']}}">{{utf8_strcut(strip_tags($item['title']),30)}}
                                            <img src="{{correctImgPath($item['img'])}}" alt="team-image" style = "width:10px; height:10px;margin-bottom: 10px;margin-left: 10px;" onerror="noExitImgHidden(this)"></td>
                                        <td class = "text-center cursor relative menu-click-wrapper" data-id = "{{$item['id']}}">
                                            <a href = "javascript:void(0)" @if(isset($user_info['id']) && $item['user_id']*1 != $user_info['id']) onclick = "menuItemClick1(this)" @else onclick = "userOnlyWrite(this)" @endif data-user-id ="{{$item['user_id']}}" >
                                                <img onerror = "noExitImg(this)" style="width:20px !important;" src="{{url($item['level_icon'])}}">
                                                {{$item['user']['nickname']}}
                                            </a>
                                            <ul class = "td-click-menu hidden">
                                                <li><a href = "javascript:void(0);" onclick = "showSendNoteDlg(this)" data-user-id = "{{$item['user_id']}}"  >{{__('lang.쪽지보내기')}}</a></li>
                                                <li><a href = "javascript:void(0);" onclick = "showUserInfoDlg(this)" data-user-id = "{{$item['user_id']}}" >{{__('lang.회원정보')}}</a></li>
                                                <li><a href = "javascript:void(0);" onclick = "userOnlyWrite(this)" data-user-id ="{{$item['user_id']}}">{{__('lang.작성게시글 보기')}}</a></li>
                                            </ul>
                                        </td>
                                        <td class = "text-center hidden-xs" onclick = "detailView(this)" data-id = "{{$item['id']}}">{{$item['view_count']}}</td>
                                        <td class = "text-center hidden-xs" onclick = "detailView(this)" data-id = "{{$item['id']}}">{{getMsgTimeStr($item['created_at'])}}</td>
                                        <td class ="hidden-xs" >
                                            @if(Sentinel::check() && ($user_info['type']*1 == 99 || $user_info['id']*1 == $item['user']['id']*1) )
                                                <a class = " " href = "javascript:void(0)" onclick = "delItem(this)" data-id = "{{$item['id']}}" ><i class = "fa fa-trash"></i></a>
                                                <a class = "" href = "{{url("board/write/".$item['id']."/".$board_type)}}" ><i class = "fa fa-pencil"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                @if(count($list) == 0)
                                    <tr>
                                        <td colspan = "7">{{__('lang.자료가 없습니다.')}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class = "row">
                            <div class = "col-md-8 text-left col-xs-12">
                                <form id = "searchForm" action = "{{url("board/".$board_type)}}"  method = "post">
                                    <input type = "hidden" name ="_token" value ="{{csrf_token()}}"/>
                                    <input type = "hidden" name = "page" value = "{{$pageParam['pageNo']}}"/>
                                    <input type = "hidden" name = "user_id" value = "{{$user_id}}"/>
                                    <input type = "hidden" name = "category_id" value = "{{$category_id}}"/>
                                    <div class = "row">
                                        <div class = "col-md-6 mt-10 mb-10" style = "margin-top:8px;">
                                            <select class = "form-control search-select radius-0" name = "search_type" style = "height:38px;">
                                                <option value ="getUserNickname(user_id)" @if($search_type == 'getUserNickname(user_id)') selected @endif>{{__('lang.닉네임')}}</option>
                                                <option value ="title" @if($search_type == 'title') selected @endif>{{__('lang.제목')}}</option>
                                                <option value ="title&content" @if($search_type == 'title&content') selected @endif>{{__('lang.제목')}}&{{__('lang.내용')}}</option>
                                                <option value ="reply" @if($search_type == 'reply') selected @endif>{{__('lang.댓글')}}</option>
                                            </select>
                                        </div>
                                        <div class = "col-md-6 mt-10 -mb-10" style = "display:table; margin-top:8px;">
                                            <input type = "text" class = "form-control search-input radius-0" style ="height:38px;" name = "search_title" value ="{{$search_title}}" placeholder ="{{__('lang.검색어를 입력해주세요')}}">
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
                                    <a class = "color-white write-a btn-danger border-none"  href = "{{url("board/write/0/".$board_type)}}" style = "color:white;">{{__('lang.글쓰기')}}</a>
                                @endif
                            </div>
                        </div>
                        <div class = "text-center relative" style = "margin-top:10px;">
                            @include("layouts/pagination")
                        </div>
                    </div>
                </div>
            </div>
            <div class = "col-md-3 hidden-xs">
                @include('layouts/right-side')
            </div>
        </div>
    </div>
    @include("dlg/crop_dlg")
    <!-- //Container End -->
@stop
{{-- footer scripts --}}
@section('footer_scripts')
    <script>
        function userOnlyWrite(obj){
            var user_id = $(obj).attr("data-user-id");
            $("#searchForm input[name='page']").val("0");
            $("#searchForm input[name='user_id']").val(user_id);
            $("#searchForm").submit();
        }

        function  delItem(obj){
            var id = $(obj).attr("data-id");
            confirmMsg("{{__('lang.정말 삭제하겟습니까?')}}", function(){
                setTimeout(function(){
                    var param = new Object();
                    param._token = _token;
                    param.id = id;
                    var url = "{{url('/board/deleteInfo')}}";
                    loading_start();
                    $.post(url, param,function(data){
                        if(data.status=="1"){
                            successMsg("{{__('lang.삭제가 성공하었습니다.')}}", function(){
                                window.location.reload();
                            });
                        }
                    }, "json");
                }, 500);
            })
        }

        function changeCategoryItem(obj){
            loading_start();
            var category_id = $(obj).attr("data-id");
            $("#searchForm input[name='page']").val("0");
            $("#searchForm input[name='category_id']").val(category_id);
            $("#searchForm").submit();
        }

        $(function(){
            var url = $("#searchForm").attr("action")+"?"+$("#searchFrm").serialize();
            setPageUrl(url);
            loading_stop();
        });
        function searchData(page) {
            $("#searchForm input[name='page']").val(page);
            $("#searchForm").submit();
        }

        function  detailView(obj){
            var id = $(obj).attr("data-id");
            window.location.href = "{{url("/board_info")}}/"+id;
        }

        $("#reviewForm textarea[name='description']").ckeditor({
            height: '200px'
        });

        $("#reviewForm").validate({
            rules: {
                shop_id: "required",
                title: "required",
                description: "required",
            },

            messages: {

            },
            errorPlacement: function (error, element) {
                if($(element).closest('div').children().filter("div.error-div").length < 1)
                    $(element).closest('div').append("<div class='error-div'></div>");
                $(element).closest('div').children().filter("div.error-div").append(error);
            },
            submitHandler: function(form){
                var url = $(form).attr("action");
                var fdata = new FormData($("#reviewForm")[0]);
                fdata.append("description", $("#reviewForm textarea[name='description']").val());
                loading_start();
                $.ajax({
                    url: url,
                    type: 'post',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: fdata,
                    dataType:"json",
                    success: function (data) {

                        if (data.status == '1') {
                            successMsg("{{__('lang.수정이 성공하였습니다.')}}", function(){
                                window.location.reload();
                            });
                        } else {
                            loading_stop();
                            errorMsg(data.msg);
                        }
                    },
                    error: function() {
                        errorMsg("{{__('lang.서버에서 오류가 발생하였습니다.')}}");
                    }
                })

            }

        });

    </script>
@stop
