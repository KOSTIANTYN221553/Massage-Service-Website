@if(!Sentinel::check())
    <div class = "border-box margin-box hidden-xs" id = "login-rect" style = "margin-top:10px;">
        <div class = "row">
            <div class = "col-md-12">
                <div class = "row  ">
                    <div class = "col-md-10 col-md-offset-2 pl-0">
                        <h3 class = "title"> <i class = "fa fa-fw  fa-laptop"></i> {{__('lang.로그인')}}</h3>
                    </div>
                </div>

                <form class="form-horizontal" method = "post" action = "{{url("login")}}">
                    <input type = "hidden" name = "_token" value = "{{csrf_token()}}"/>
                    <div class="form-group">
                        <label class="col-md-2 control-label text-left pr-0">{{__('lang.계정')}}</label>
                        <div class="col-md-9 pl-0">
                            <input name="email" required="" type="text" placeholder="" class="form-control">
                            <div class="help-block">
                                {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label text-left pr-0">암호</label>
                        <div class="col-md-9 pl-0">
                            <input name="password" type="password" class="form-control" maxlength="40" required="">
                            <div class="help-block">
                                {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-md-2 pr-0 control-label" style ="padding-top:0px;padding-bottom:0px;">&nbsp;</label>
                        <label class="col-md-9 pl-0" style ="padding-top:0px;padding-bottom:0px;">
                            <input name="remember-me" type="checkbox" value="Remember Me" class="minimal-blue"/>
                            {{__('lang.로그인유지')}}
                        </label>
                    </div>
                    <div class = "form-group " style = "margin-top:9px;">
                        <div class="col-md-4 col-md-offset-2 pl-0">
                            <button  class="btn btn-responsive button-alignment btn-danger form-control radius-0" style="margin-bottom:7px;">{{__('lang.로그인')}}</button>
                        </div>
                        <div class="col-md-4 text-right">
                            <button type ="button" onclick = "goRegister()" class="btn btn-responsive button-alignment btn-danger form-control radius-0" style="margin-bottom:7px;width:88px;">{{__('lang.회원가입')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@else
    <?php $user = Sentinel::getuser();?>
    <style>
        .control-label {
            padding-top:10px !important;
        }
    </style>
    <div class = "border-box margin-box hidden-xs" id = "login-rect" style = "margin-top:10px;">
        <div class = "row">
            <div class = "col-md-12">
                <h3 class = "title text-center"><a href = "javascript:void(0);" onclick = "goUpdateUserInfo()"> <i class = "fa fa-fw  fa-laptop"></i> {{__('lang.회원정보')}}</a></h3>
                <form class="form-horizontal" method = "post" action = "{{url("logout")}}">
                    <input type = "hidden" name = "_token" value = "{{csrf_token()}}"/>
                    <div class="form-group " style = "margin-bottom:0px;">
                        <label class="col-md-5 p-0 control-label" style = "padding-top:0px !important;">{{__('lang.가입일')}}</label>
                        <label class = "col-md-5 p-0 pl-10">{{substr($user['created_at'],0,10)}}</label>
                    </div>

                    <div class="form-group" style = "margin-bottom:0px;">
                        <label class="col-md-3 control-label p-0" style = "padding-top:0px !important;">{{__('lang.계정')}}</label>
                        <label class="col-md-4 p-0 pl-5">{{$user['email']}}</label>
                        <label class="col-md-5 p-0">
                            @if(isset($user['user_level']['id']))
                                <img onerror = "noExitImg(this)" style="width:20px !important;" src="{{url($user['user_level']['icon'])}}"> {{$user['user_level']['title']}}
                            @else
                                {{__('lang.미정')}}
                            @endif
                            <i class = "fa fa-gear cursor" onclick = "goUpdateUserInfo()"></i>
                        </label>
                    </div>
                    <div class="form-group" style = "margin-bottom:0px;">
                        <label class="col-md-3 control-label p-0" style = "padding-top:0px !important;">{{__('lang.닉네임')}}</label>
                        <label class="col-md-3 p-0 pl-5">{{$user['nickname']}}</label>
                        <label class="col-md-3 control-label p-0" style = "padding-top:0px !important;">{{__('lang.포인트')}}</label>
                        <label class="col-md-3 p-0 pl-5">{{number_format($user['user_point'])}}</label>
                    </div>
                    @if($user['type']*1 == 70)
                        <?php $complete_info = $user->shop_complete_info(); ?>
                        <div class="form-group " style = "margin-bottom:0px;">
                            <label class="col-md-5 p-0 control-label" style = "padding-top:0px !important;">{{__('lang.만료일')}}</label>
                            <label class = "col-md-5 p-0 pl-10">
                                @if($complete_info['diff']*1 == -1)
                                    {{__('lang.없음')}}
                                @else
                                    <span id = "diff_time" data-diff = "{{$complete_info['diff']}}"></span>
                                @endif
                            </label>
                        </div>
                    @endif


                    @if($user['type']*1 == 1)
                    <div class="form-group hidden" style = "margin-bottom:0px;">
                        <label class="col-md-5 ">[↑{{__('lang.일반회원')}}]</label>
                    </div>
                    <div class="form-group hidden" style = "margin-bottom:0px;">
                        <label class="col-md-4  control-label">{{__('lang.방문수')}}</label>
                        <div class="col-md-8">
                            <label>{{number_format($user['visit_cnt'])}}</label>
                        </div>
                    </div>
                    @elseif($user['type']*1 == 70)
                        <div class="form-group hidden" style = "margin-bottom:0px;">
                            <label class="col-md-4  control-label">{{__('lang.방문수')}}</label>
                            <div class="col-md-8">
                                <label>{{number_format($user['visit_cnt'])}}</label>
                            </div>
                        </div>
                        <?php $complete_info = $user->shop_complete_info(); ?>
                        <div class="form-group hidden" style = "margin-bottom:0px;">
                            <label class="col-md-4 control-label">{{__('lang.업소명')}}</label>
                            <div class="col-md-8">
                                @if($complete_info['diff']*1 == -1)
                                    <label>{{__('lang.없음')}}</label>
                                @else
                                    <label>{{$complete_info['title']}}</label>
                                @endif
                            </div>
                        </div>
                        <div class="form-group hidden" style = "margin-bottom:0px;">
                            <label class="col-md-4 pl-0  control-label">{{__('lang.만료일')}}</label>
                            <div class="col-md-8">
                                @if($complete_info['diff']*1 == -1)
                                    <label>{{__('lang.없음')}}</label>
                                @else
                                    <label id = "diff_time" data-diff = "{{$complete_info['diff']}}"></label>
                                @endif
                            </div>
                        </div>
                    @endif

                    <div class="form-group hidden" style = "margin-bottom:0px;">
                        <label class="col-md-3 control-label">{{__('lang.이메일')}}</label>
                        <div class="col-md-3" style = "margin-top:5px;">
                            <lable>{{$user['user_email']}}</lable>
                        </div>
                        <label class="col-md-3 control-label">{{__('lang.성별')}}</label>
                        <div class="col-md-3">
                            <label>{{$user['nickname']}}</label>
                        </div>
                    </div>
                    <div class="form-group hidden">
                        <label class="col-md-3 control-label">{{__('lang.자기소개')}}</label>
                        <div class="col-md-9" style = "margin-top:5px;">
                            <lable>{!! $user['description']  !!}</lable>
                        </div>
                    </div>
                    <div class = "form-group mt-10">
                        <div class="col-md-12 text-left" style ="margin-left:10px;">
                            <button type ="button" onclick = "showNoteDlg(this)" data-user-id = "{{$user['id']}}" class="btn btn-responsive button-alignment btn-danger form-control radius-0" style="margin-left:10px;margin-bottom:7px;width:100px;">
                                {{__('lang.쪽지함')}}
                                @if($user->note_count() > 0)
                                <small class = "badge badge-danger event_count ml-5">{{$user->note_count()}}</small>
                                @endif
                            </button>
                            <a href ="{{url('/logout')}}"  class="btn btn-responsive button-alignment btn-danger form-control color-white radius-0" style="color:white;margin-bottom:7px;width:100px;display: inline-block;margin-left:10px;">{{__('lang.로그아웃')}}</a>
                            <button type ="button" onclick = "goUpdateUserInfo()" class="btn btn-responsive button-alignment btn-danger form-control hidden" style="margin-left:10px;margin-bottom:7px;width:100px;">{{__('lang.정보수정')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif
<div class = "row  border-box margin-box mt-10 ">
    <h3 class = "title-border">{{__('lang.주간 베스트')}}</h3>
    <ul class = "list-ul right-recent-best">
        @foreach($recent_board_list as $key => $board)
            <li class = "list-li ">
                <a href = "{{url("/board_info/".$board['id'])}}">
                    <div class = "ellipse left"><span class = "mr-10 best-numbering">{{$key+1}}</span>{{utf8_strcut(strip_tags($board['title']), 50)}}</div>
                    <div class = "right"><i class = "fa fa-comment color-custom-red"></i><span class = "ml-5">{{$board['reply_count']}}</span></div>
                </a>
            </li>
        @endforeach
    </ul>
</div>
@foreach($board_type_list as $board_type)
<div class = "row  border-box margin-box mt-10">
    <h3 class = "title-border">{{$board_type['title']}}</h3>
    <ul class = "list-ul right-recent-best">
        @foreach($board_type['list'] as $key=>$board)
            <li class = "list-li ">
                <a href = "{{url("/board_info/".$board['id'])}}">
                    <div class = "ellipse left"><span class = "mr-10 best-numbering">{{$key+1}}</span>{{utf8_strcut(strip_tags($board['title']), 50)}}</div>
                    <div class = "right"><i class = "fa fa-comment color-custom-red"></i><span class = "ml-5">{{$board['reply_count']}}</span></div>
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endforeach



<script>




    /*$(".menu-click-wrapper").hover(
        function(){
            $(this).find(".td-click-menu").removeClass("hidden");
        },
        function(){
            $(this).find(".td-click-menu").addClass("hidden");
        }
    );*/



    function goRegister(){
        window.location.href = "{{url('/user_register')}}";
    }

    function goUpdateUserInfo(){
        window.location.href = "{{url('/user_update_info')}}";
    }

    $(function(){
       var msg = "{!! $errors->first('email', ':message') !!}";
       if(msg != ""){
           errorMsg(msg, function(){
               var width = $(window).width();
               if(width <= 480){
                   window.location.href = "{{url('login-user')}}";
               }
           });
       }
    });

</script>
