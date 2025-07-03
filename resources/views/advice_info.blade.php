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
        <div class = "row">
            <div class ="col-md-9 col-xs-12 mt-10">
                <div class="row content">
                    <!-- Business Deal Section Start -->
                    <div class="col-sm-12 col-md-12">
                        <div class=" thumbnail featured-post-wide img">
                            <div class = "row">
                                <div class = "col-md-12 p-10">
                                    <h2 class="color-white marl12 font-20">{{$info['title']}}</h2>
                                </div>
                            </div>
                            <div class = "row detail-header">
                                <div class = "col-md-9 relative">
                                    <img onerror = "noExitImg(this)" style="width:20px !important;" src="{{url($info['level_icon'])}}" @if(isset($user['id']) && $info['user_id']*1 != $user['id']*1) onclick = "menuItemClick1(this)" @endif>
                                    <span class = "text-white-gray ml-5 cursor font-18" @if(isset($user['id']) && $info['user_id']*1 != $user['id']*1) onclick = "menuItemClick1(this)" @endif>
                                        {{isset($info['user']['nickname'])? $info['user']['nickname']: ""}}
                                    </span>
                                    <ul class = "td-click-menu hidden">
                                        <li><a href = "javascript:void(0);" onclick = "showSendNoteDlg(this)" data-user-id = "{{$info['user_id']}}"  >{{__('lang.쪽지보내기')}}</a></li>
                                        <li><a href = "javascript:void(0);" onclick = "showUserInfoDlg(this)" data-user-id = "{{$info['user_id']}}" >{{__('lang.회원정보')}}</a></li>
                                    </ul>
                                    <span class = " ml-5 mr-5 text-white-gray" >|</span>
                                    <i class="fa fa-eye text-white-gray ml-10"></i><span class = "text-white-gray ml-5 cursor">{{$info['view_count']}}</span>
                                    <i class="fa fa-comment text-white-gray ml-20"></i><span class = "text-white-gray ml-5 cursor">{{$info['reply_count']}}</span>
                                </div>
                                <div class = "col-md-3 text-right">
                                    <i class="fa fa-clock-o text-white-gray"></i><span class = "text-white-gray  cursor"> {{substr($info['created_at'],0,16)}} </span>
                                </div>
                            </div>
                            <div class="the-box no-border blog-detail-content">
                                <p class="text-justify font-18 color-white word-break">
                                    {!! $info['description'] !!}
                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            @if($info['user_id']*1 == $user['id']*1)
                                <a class = "color-white write-a1 btn-danger border-none"  href = "{{url('advice/write/'.$info['id'])}}" style = "color:white;">{{__('lang.수정')}}</a>
                                <a class = "color-white write-a1 btn-danger border-none"  href = "javascript:void(0)" onclick = "delItem(this)" data-id = "{{$info['id']}}" style = "color:white;">{{__('lang.삭제')}}</a>
                            @endif
                            <a class = "color-white write-a1 btn-danger border-none"  href = "javascript:void(0)" onclick="goBack()" style = "color:white; margin-right:10px;">{{__('lang.목록으로')}}</a>
                        </div>
                        <h3 class="comments">{{$info['reply_count']}} {{__('lang.개의 댓글목록')}}</h3><br />
                        <ul class="media-list">
                            @foreach($reply_list as $reply)
                                <li class="media">
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <i>
                                                <img onerror = "noExitImg(this)" style="width:20px !important;" src="{{url($reply['user']['user_level']['icon'])}}" @if(isset($user['id']) && $reply['user']['id']*1 != $user['id']*1) onclick = "menuItemClick1(this)" @endif>
                                                <span class = "cursor" @if(isset($user['id']) && $reply['user']['id']*1 != $user['id']*1) onclick = "menuItemClick1(this)" @endif>{{$reply['user']['nickname']}}</span>
                                                <ul class = "td-click-menu hidden">
                                                    <li><a href = "javascript:void(0);" onclick = "showSendNoteDlg(this)" data-user-id = "{{$reply['user']['id']}}"  >{{__('lang.쪽지보내기')}}</a></li>
                                                    <li><a href = "javascript:void(0);" onclick = "showUserInfoDlg(this)" data-user-id = "{{$reply['user']['id']}}" >{{__('lang.회원정보')}}</a></li>
                                                </ul>
                                            </i>
                                            <a href = "javascript:void(0)" class = "ml-10" style = "font-size:14px;" onclick = "showReplyReplyForm(this)" data-id = "0"> {{__('lang.답글작성')}}</a>
                                            @if($user['id']*1 == $reply['user_id']*1)
                                                <a href = "javascript:void(0)" class = "ml-10" style = "font-size:14px;" onclick = "showReplyForm(this)"> {{__('lang.댓글변경')}}</a>
                                                <a href = "javascript:void(0)" class = "ml-10" style = "font-size:14px;" onclick = "deleteReply(this)" data-id = "{{$reply['id']}}"> {{__('lang.댓글삭제')}}</a>
                                            @endif
                                        </h4>
                                        <form class = "reply_form hidden" method = "method" action="{{url("advice/ajaxSaveReply")}}" accept-charset="UTF-8" class="bf" enctype="multipart/form-data">
                                            <input type = "hidden" name = "id" value = "{{$reply['id']}}"/>
                                            <input type = "hidden" name ="_token" value = "{{csrf_token()}}"/>
                                            <div class="form-group">
                                                <textarea class="form-control input-lg no-resize" required="required" style="height: 200px" placeholder="{{__('lang.댓글내용을 입력해주세요.')}}" name="description" cols="50" rows="10">{{$reply['description'] }}</textarea>
                                            </div>
                                            <div class="form-group ">
                                                <button type="button" class="btn btn-danger border-none radius-0 btn-md" onclick = "submitReplyUpdateForm(this)">
                                                    <i class="livicon" data-name="comment" data-c="#FFFFFF" data-hc="#FFFFFF" data-size="18" data-loop="true"></i>
                                                    {{__('lang.변경')}}
                                                </button>
                                            </div>
                                        </form>
                                        <div>
                                            {!! $reply['description'] !!}
                                        </div>
                                        <p class="color-white">
                                            <small class = "mr-5"> {{$reply['created_at']}} </small>
                                            <i class = "fa fa-comment "></i><span class="ml-5">{{count($reply['reply'])}}</span>
                                        </p>
                                        @foreach($reply['reply'] as $reply_reply)
                                            <div class = "comment-rect">
                                                <h4 class="media-heading">
                                                    <i>{{__('lang.답글')}} :
                                                        <img onerror = "noExitImg(this)" style="width:20px !important;" src="{{url($reply_reply['user']['user_level']['icon'])}}" @if(isset($user['id']) && $reply_reply['user']['id']*1 != $user['id']*1) onclick = "menuItemClick1(this)" @endif>
                                                        <span class = "cursor" @if(isset($user['id']) && $reply_reply['user']['id']*1 != $user['id']*1) onclick = "menuItemClick1(this)" @endif>{{$reply_reply['user']['nickname']}}</span>
                                                        <ul class = "td-click-menu hidden">
                                                            <li><a href = "javascript:void(0);" onclick = "showSendNoteDlg(this)" data-user-id = "{{$reply_reply['user']['id']}}"  >{{__('lang.쪽지보내기')}}</a></li>
                                                            <li><a href = "javascript:void(0);" onclick = "showUserInfoDlg(this)" data-user-id = "{{$reply_reply['user']['id']}}" >{{__('lang.회원정보')}}</a></li>
                                                        </ul>
                                                    </i>
                                                    <small class = "ml-10 text-white"> {{substr($reply_reply['created_at'],0,10)}} </small>
                                                    @if($user['id']*1 == $reply_reply['user_id']*1)
                                                        <a href = "javascript:void(0)" class = "ml-10" style = "font-size:14px;" onclick = "showReplyReplyForm(this)" data-id = "{{$reply_reply['id']}}">{{__('lang.답글변경')}}</a>
                                                        <a href = "javascript:void(0)" class = "ml-10" style = "font-size:14px;" onclick = "deleteReply(this)" data-id = "{{$reply_reply['id']}}">{{__('lang.답글삭제')}}</a>
                                                    @endif
                                                </h4>
                                                <p>
                                                    {{$reply_reply['description']}}
                                                </p>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class = "reply_reply_form-rect hidden">
                                        <form class = "reply_reply_form" method = "post" action = "{{url('/advice/ajaxSaveReply')}}" accept-charset="UTF-8" class="bf" enctype="multipart/form-data">
                                            <input type = "hidden" name = "board_id" value = "{{$info['id']}}"/>
                                            <input type = "hidden" name = "parent_reply_id" value = "{{$reply['id']}}"/>
                                            <input type = "hidden" name = "id" value = "0"/>
                                            <input type = "hidden" name = "_token" value ="{{csrf_token()}}"/>
                                            <div class="form-group {{ $errors->has('description') ? 'has-error' : '' }}">
                                                <textarea class="form-control input-lg no-resize" required="required" style="height: 200px" placeholder="{{__('lang.답글내용을 입력해주세요.')}}" name="description" cols="50" rows="10"></textarea>
                                                <span class="help-block">{{ $errors->first('description', ':message') }}</span>
                                            </div>
                                            <div class="form-group ">
                                                <button type="button" class="btn btn-danger border-none radius-0 btn-md" onclick = "submitReplyForm(this)">
                                                    <i class="livicon" data-name="comment" data-c="#FFFFFF" data-hc="#FFFFFF" data-size="18" data-loop="true"></i>
                                                    {{__('lang.등록')}}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        @if(Sentinel::check())
                            <div class = "comment-write-rect">
                                <h3>{{__('lang.댓글작성')}}</h3>
                                <form method="POST" id = "replyForm"  action="{{url("/advice/ajaxSaveReply")}}" accept-charset="UTF-8" class="bf" enctype="multipart/form-data">
                                    <input type = "hidden" name ="_token" value = "{{csrf_token()}}"/>
                                    <input type = "hidden" name = "board_id" value = "{{$info['id']}}"/>
                                    <input type = "hidden" name = "parent_reply_id" value = "0"/>
                                    <div class="form-group {{ $errors->has('comment') ? 'has-error' : '' }}">
                                        <textarea class="form-control input-lg no-resize" required="required" style="height: 200px" placeholder="{{__('lang.댓글을 입력해주십시오.')}}" name="description" cols="50" rows="10"></textarea>
                                        <span class="help-block">{{ $errors->first('comment', ':message') }}</span>
                                    </div>
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-danger border-none radius-0 btn-md">
                                            <i class="livicon" data-name="comment" data-c="#FFFFFF" data-hc="#FFFFFF" data-size="18" data-loop="true"></i>
                                            {{__('lang.작성')}}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row mt-10">
                    <div class = "col-md-12">
                        <table class = "table table-striped ">
                            <thead>
                            <tr>
                                <th style = "width:3%">No</th>
                                <th style = "width:50%">{{__('lang.제목')}}</th>
                                <th style = "width:18%"><span class = "hidden-xs">{{__('lang.닉네임')}}</span></th>
                                <th class = "hidden-xs" style = "width:8%"><span class = "hidden-xs">{{__('lang.조회수')}}</span></th>
                                <th style = "width:10%" class = "hidden-xs"><span class = "hidden-xs">{{__('lang.날짜')}}</span></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $key => $item)
                                <tr class = "cursor">
                                    <td onclick = "detailView(this)" data-id ="{{$item['id']}}">{{$key+$pageParam['startNumber']+1}}</td>
                                    <td onclick = "detailView(this)" data-id ="{{$item['id']}}">{{utf8_strcut(strip_tags($item['title']),30)}}</td>
                                    <td data-id ="{{$item['id']}}" class = "relative">
                                        <img onerror = "noExitImg(this)" style="width:20px !important;" src="{{url($item['level_icon'])}}" @if(isset($user['id']) && $item['user']['id']*1 != $user['id']*1) onclick = "menuItemClick1(this)" @endif>
                                        <span class = "cursor" @if(isset($user['id']) && $item['user']['id']*1 != $user['id']*1) onclick = "menuItemClick1(this)" @endif>{{$item['user']['nickname']}}</span>
                                        <ul class = "td-click-menu hidden">
                                            <li><a href = "javascript:void(0);" onclick = "showSendNoteDlg(this)" data-user-id = "{{$item['user_id']}}"  >{{__('lang.쪽지보내기')}}</a></li>
                                            <li><a href = "javascript:void(0);" onclick = "showUserInfoDlg(this)" data-user-id = "{{$item['user']['id']}}" >{{__('lang.회원정보')}}</a></li>
                                        </ul>
                                    </td>
                                    <td class = "hidden-xs" onclick = "detailView(this)" data-id ="{{$item['id']}}">{{$item['view_count']}}</td>
                                    <td onclick = "detailView(this)" data-id ="{{$item['id']}}" class = "hidden-xs">{{substr($item['created_at'],5,5)}}</td>
                                </tr>
                            @endforeach
                            @if(count($list) == 0)
                                <tr>
                                    <td colspan = "5">{{__('lang.자료가 없습니다.')}} </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
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
    <script>

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

        $(function(){
           loading_stop();
        });
        function  detailView(obj){
            var id = $(obj).attr("data-id");
            window.location.href = "{{url("/advice_info")}}/"+id;
        }

        function deleteReply(obj){
            confirmMsg("{{__('lang.정말 삭제하겟습니까?')}}", function(){
                var id = $(obj).attr("data-id");
                var param = new Object();
                param._token = _token;
                param.id = id;
                var url = "{{url("/advice/deleteReply")}}";
                loading_start();
                $.post(url, param, function(data){
                    if(data.status == "1"){
                        successMsg("{{__('lang.수정이 성공하였습니다.')}}", function(){
                            window.location.reload();
                        });
                    }else{
                        loading_stop();
                        errorMsg(data.msg);
                    }
                }, "json");
            });
        }

        function submitReplyUpdateForm(obj){
            var description = $(obj).closest("form").find("textarea[name='description']").val();
            if(description == ""){
                errorMsg("{{__('lang.댓글을 입력해주십시오.')}}");
                return;
            }
            var url = $(obj).closest("form").attr("action");
            var fdata = new FormData($(obj).closest("form")[0]);
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
                    loading_stop();
                    errorMsg("{{__('lang.서버에서 오류가 발생하였습니다.')}}");
                }
            })
        }

        function showReplyForm(obj){
            $(".reply_form").addClass("hidden");
            $(obj).parent().parent().find("form").removeClass("hidden");
            $(obj).parent().parent().find("form").next().addClass("hidden");
        }
        function showReplyReplyForm(obj){
            var id = $(obj).attr("data-id");
            var parent = $(obj).parent().parent().parent();
            if(id != "0"){
                parent = $(obj).parent().parent().parent().parent();
            }
            $(".reply_reply_form-rect").addClass("hidden");
            parent.find(".reply_reply_form-rect").removeClass("hidden");
            parent.find(".reply_reply_form-rect form input[name='id']").val(id);
            if(id == "0"){
                parent.find(".reply_reply_form-rect form textarea[name='description']").val("");

            }else{
                var description = $(obj).parent().parent().find("p").html();
                parent.find(".reply_reply_form-rect form textarea[name='description']").val(description.trim());

            }

        }

        function submitReplyForm(obj){
            var description = $(obj).closest("form").find("textarea[name='description']").val();
            if(description == ""){
                errorMsg("{{__('lang.답글을 입력해주십시오.')}}");
                return;
            }
            var url = $(obj).closest("form").attr("action");
            var fdata = new FormData($(obj).closest("form")[0]);
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
                    loading_stop();
                    errorMsg("{{__('lang.서버에서 오류가 발생하였습니다.')}}");
                }
            })
        }

        $("#replyForm").validate({
            rules: {
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
                var fdata = new FormData($("#replyForm")[0]);
                fdata.append("description", $("#replyForm textarea[name='description']").val());
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
                        loading_stop();
                        errorMsg("{{__('lang.서버에서 오류가 발생하였습니다.')}}");
                    }
                })

            }

        });
    </script>
@stop
