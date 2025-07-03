@extends('layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
{{__('lang.건의사항')}}
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
    <?php $user = Sentinel::getuser(); ?>
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
                <a href = "{{url('/advice_info/'.$item['id'])}}">
                    <div class = "row page-title-wrapper">
                        <div class = "col-md-10  margin-box border-right">
                            <span class ="badge-warning">{{__('lang.공지')}}</span>
                            <span>{{utf8_strcut(strip_tags($item['title']),150)}}</span>
                        </div>
                        <div class = "col-md-2 hidden-xs text-right">
                            <span class = "pr-10 border-right">{{$item['user']['nickname']}}</span>
                            <span class = "pl-10">{{getMsgTimeStr($item['created_at'])}}</span>
                        </div>
                    </div>
                </a>
            @endforeach
        @endif
        <?php $user_info = getLoginUserInfo();?>
        <div class = "row">
            <div class = "col-md-9 cols-xs-12">
                <form id = "searchForm" action = "{{url("advice")}}"  method = "get">
                    <input type = "hidden" name = "_token" value = "{{csrf_token()}}"/>
                    <input type = "hidden" name = "page" value = "{{$pageParam['pageNo']}}"/>
                </form>
                <div class="row">
                    <div class = "col-md-12">
                        <div class = "table-scrollable" style = "overflow: visible;">
                            <table class = "table table-striped">
                                <thead>
                                    <tr>
                                        <th style = "width:3%">No</th>
                                        <th class = "text-center" style = "width:50%">{{__('lang.제목')}}</th>
                                        <th style = "width:20%"><span class = "hidden-xs">{{__('lang.닉네임')}}</span></th>
                                        <th style = "width:8%" class = "hidden-xs"><span class = "hidden-xs">{{__('lang.조회수')}}</span></th>
                                        <th style = "width:12%" class = "hidden-xs"><span class = "hidden-xs">{{__('lang.날짜')}}</span></th>
                                        <th style ="width:8%" class = "hidden-xs">{{__('lang.관리')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $key => $item)
                                    <tr class ="cursor">
                                        <td onclick = "detailView(this)" data-id ="{{$item['id']}}">{{$key+$pageParam['startNumber']+1}}</td>
                                        <td onclick = "detailView(this)" data-id ="{{$item['id']}}">{{utf8_strcut(strip_tags($item['title']),30)}}</td>
                                        <td data-id ="{{$item['id']}}" class = "relative">
                                            <img onerror = "noExitImg(this)" class = "cursor" style="width:20px !important;" src="{{url($item['level_icon'])}}" @if(isset($user['id']) && $item['user']['id']*1 != $user['id']*1) onclick = "menuItemClick1(this)" @endif>
                                            <span class = "cursor" @if(isset($user['id']) && $item['user']['id']*1 != $user['id']*1) onclick = "menuItemClick1(this)" @endif>{{$item['user']['nickname']}}</span>
                                            <ul class = "td-click-menu hidden">
                                                <li><a href = "javascript:void(0);" onclick = "showSendNoteDlg(this)" data-user-id = "{{$item['user']['id']}}" >{{__('lang.쪽지보내기')}}</a></li>
                                                <li><a href = "javascript:void(0);" onclick = "showUserInfoDlg(this)" data-user-id = "{{$item['user']['id']}}" >{{__('lang.회원정보')}}</a></li>
                                            </ul>
                                        </td>
                                        <td onclick = "detailView(this)" data-id ="{{$item['id']}}" class = "hidden-xs">{{$item['view_count']}}</td>
                                        <td onclick = "detailView(this)" data-id ="{{$item['id']}}" class = "hidden-xs">{{getMsgTimeStr($item['created_at'])}}</td>
                                        <td class = "hidden-xs">
                                            @if(Sentinel::check() && ($user_info['type']*1 == 99 || $user_info['id']*1 == $item['user']['id']*1) )
                                            <a class = " " href = "javascript:void(0)" onclick = "delItem(this)" data-id = "{{$item['id']}}" ><i class = "fa fa-trash"></i></a>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                                @if(count($list) == 0)
                                    <tr>
                                        <td colspan = "6">{{__('lang.자료가 없습니다.')}} </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class = "row">
                            <div class = "col-md-12 text-right">
                                @if(Sentinel::check())
                                    <a class = "color-white write-a hidden-xs btn-danger border-none"  href = "{{url("advice/write/0")}}">{{__('lang.글쓰기')}}</a>
                                @endif
                            </div>
                        </div>
                        <div class = "text-center " style = "margin-top:15px;">
                            @include("layouts/pagination")
                        </div>
                        @if(Sentinel::check())
                        <div class = "comment-write-rect hidden">
                            <h3>{{__('lang.글쓰기')}}</h3>
                            <form method="POST" id = "reviewForm"  action="{{url("/advice/ajaxSaveReview")}}" accept-charset="UTF-8" class="bf" enctype="multipart/form-data">
                                <input type = "hidden" name ="_token" value = "{{csrf_token()}}"/>
                                <div class="form-group">
                                    <input type = "text" class = "form-control" name = "title" placeholder="{{__('lang.제목을 입력해주세요.')}}" required="required"/>
                                </div>
                                <div class="form-group {{ $errors->has('comment') ? 'has-error' : '' }}">
                                    <textarea class="form-control input-lg no-resize" required="required" style="height: 200px" placeholder="{{__('lang.댓글을 입력해주십시오.')}}" name="description" cols="50" rows="10"></textarea>
                                    <span class="help-block">{{ $errors->first('comment', ':message') }}</span>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger border-none radius-0 btn-md">
                                        <i class="livicon" data-name="comment" data-c="#FFFFFF" data-hc="#FFFFFF" data-size="18" data-loop="true"></i>
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                        @endif
                </div>
            </div>
            </div>
            <div class = "col-md-3 hidden-xs">
                @include('layouts/right-side')
            </div>
        </div>
    </div>
@stop
{{-- footer scripts --}}
@section('footer_scripts')
    <script>
        $(function(){
            var url = $("#searchForm").attr("action")+"?"+$("#searchFrm").serialize();
            setPageUrl(url);
            loading_stop();
        });

        function  delItem(obj){
            var id = $(obj).attr("data-id");
            confirmMsg("{{__('lang.정말 삭제하겟습니까?')}}", function(){
                setTimeout(function(){
                    var param = new Object();
                    param._token = _token;
                    param.id = id;
                    var url = "{{url('/advice/deleteInfo')}}";
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
        function searchData(page) {
            $("#searchForm input[name='page']").val(page);
            $("#searchForm").submit();
        }
        function  detailView(obj){
            var id = $(obj).attr("data-id");
            window.location.href = "{{url("/advice_info")}}/"+id;
        }
        $(function(){

        });

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
                        loading_stop();
                        if (data.status == '1') {
                            successMsg("{{__('lang.수정이 성공하였습니다.')}}", function(){
                                window.location.reload();
                            });
                        } else {
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
