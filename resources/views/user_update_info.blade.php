{{getCurrentLang()}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{__('회원정보')}} | {{env('SITE_NAME')}}</title>
    <!--global css starts-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">
    <!--end of global css-->
    <!--page level css starts-->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/vendors/iCheck/css/all.css')}}" />
    <link href="{{ asset('assets/vendors/bootstrapvalidator/css/bootstrapValidator.min.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/register.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/loading/loading.css')}}">
    <link href="{{ asset('assets/vendors/sweetalert/css/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/pages/toastr.css') }}" rel="stylesheet" />
    <!--end of page level css-->
    <style>
        div.error-div{
            text-align: left;
            color: #900d0d;
        }

        .radius-0{
            border-radius:0px;
        }
    </style>
</head>
<script>
    var public_path = '{{url("/")}}';
    var _token = '{{csrf_token()}}';
</script>
<body>
<div class="container">
    <!--Content Section Start -->
    <div class="row">
        <div class="box">
            <h3 class="text-danger">{{__('lang.회원정보')}}</h3>
            <!-- Notifications -->
            <div id="notific">
            @include('notifications')
            </div>
            <form id = "regForm" action="{{url('user_update_info')}}" method="POST" >
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="form-group {{ $errors->first('email', 'has-error') }}">
                    <label style = "float:left; margin-left:0px;"> {{__('lang.아이디')}}</label>
                    <input type="text" class="form-control"  readonly value ="{{$user['email']}}">
                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->first('password', 'has-error') }}">
                    <label style = "float:left; margin-left:0px;"> {{__('lang.비밀번호')}}</label>
                    <input type="password" class="form-control" id="Password1" name="password" placeholder="{{__('lang.비밀번호를 입력해주세요')}}">
                    {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group {{ $errors->first('password_confirm', 'has-error') }}">
                    <label class="sr-only"> {{__('lang.비밀번호확인')}}</label>
                    <input type="password" class="form-control" id="Password2" name="password_confirm"
                           placeholder="{{__('lang.비밀번호확인을 입력해주세요')}}">
                    {!! $errors->first('password_confirm', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="clearfix"></div>
                <div class="form-group {{ $errors->first('nickname', 'has-error') }}">
                    <label style = "float:left; margin-left:0px;"> {{__('lang.별명')}}</label>
                    <input type="text" readonly class="form-control" value="{!! $user['nickname'] !!}" />
                </div>
                <div class="clearfix"></div>
                <div class="form-group {{ $errors->first('gender', 'has-error') }}">
                    <label style = "float:left; margin-left:0px;">{{__('lang.성별')}}</label>
                    <label class="radio-inline disabled" style = "float:left;">
                        <input type="radio" name="gender" id="inlineRadio1" disabled value="1" @if($user['gender']*1 == 1) checked @endif> {{__('lang.남성')}}
                    </label>
                    <label class="radio-inline disabled" style = "float:left;">
                        <input type="radio" name="gender" id="inlineRadio2" disabled value="2" @if($user['gender']*1 == 2) checked @endif> {{__('lang.여성')}}
                    </label>
                </div>
                <div class="clearfix"></div>
                <div class="form-group {{ $errors->first('user_email', 'has-error') }}" style = "margin-top:10px;">
                    <label style = "float:left; margin-left:0px;" > E-mail</label>
                    <input type="email" class="form-control" readonly value="{{$user['user_email'] }}" >
                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                </div>
                <div class="form-group " style = "margin-top:10px;">
                    <label style = "float:left; margin-left:0px;" > {{__('lang.자기소개')}}</label>
                    <textarea class = "form-control" name = "description"  rows = "2" style ="resize:none;">{!! $user['description'] !!}</textarea>

                </div>
                <div class = "row" style = "margin-top:40px;">
                    <div class = "col-md-4">
                        <button type="button" class="btn btn-block btn-danger radius-0" onclick = "showExitUserConfirmDlg()">{{__('lang.회원탈퇴')}}</button>
                    </div>
                    <div class = "col-md-4">
                        <button type="submit" class="btn btn-block btn-danger radius-0">{{__('lang.변경')}}</button>
                    </div>
                    <div class = "col-md-4">
                        <button type="button" onclick ="goHomepage()" class="btn  btn-block btn-danger radius-0 ">{{__('lang.취소')}}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- //Content Section End -->
</div>
@include('user_exit_password_confirm_dlg')
<!--global js starts-->
<script type="text/javascript" src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendors/iCheck/js/icheck.js') }}"></script>
<script  src="{{ asset('assets/js/jquery.validate.js') }}"  type="text/javascript"></script>
<script src="{{ asset('assets/vendors/noty/js/jquery.noty.packaged.min.js') }}" ></script>
<script type="text/javascript" src="{{asset("assets/loading/loading.js")}}"></script>
<script src="{{ asset('assets/vendors/sweetalert/js/sweetalert.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/vendors/sweetalert/js/sweetalert-dev.js') }}" type="text/javascript"></script>
<script  src="{{ asset('assets/js/pages/admin/common.js') }}"  type="text/javascript"></script>
<script>
    function goHomepage(){
        window.location.href = "{{url('/')}}";
    }

    function showExitUserConfirmDlg(){
        $("#user-exit-password-confirm-dialog").modal("show");
    }

    function hiddenConfirmDlg(){
        $("#user-exit-password-confirm-dialog").modal("hide");
    }

    $(document).ready(function() {
        $("input[type='checkbox'],input[type='radio']").iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    });

    $("#userExitPasswordConfirmForm").validate({
        rules: {
            password_dlg: { required:true, minlength:3, },
            password_dlg_confirm: {required:true,minlength:3, equalTo:"input[name='password_dlg']"},
        },
        messages: {
            password_dlg: { required: "{{__('lang.비밀번호를 입력해주세요')}}",minlength:"{{__('lang.최소 3자이상 입력해주십시오')}}"},
            password_dlg_confirm: {required: "{{__('lang.비밀번호를 입력해주세요')}}",minlength:"{{__('lang.최소 3자이상 입력해주십시오')}}", equalTo:"{{__('lang.암호와 일치하여야 합니다')}}"},
        },
        errorPlacement: function (error, element) {
            if($(element).closest('div').children().filter("div.error-div").length < 1)
                $(element).closest('div').append("<div class='error-div'></div>");
            $(element).closest('div').children().filter("div.error-div").append(error);
        },
        submitHandler: function(form){
            var url = $(form).attr("action");
            var fdata = new FormData(form);

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
                        successMsg("{{__('lang.성공하였습니다')}}", function(){
                            window.location.href = "{{url('/')}}"
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

    $("#regForm").validate({
        rules: {
            password: { minlength:3, },
            password_confirm: {minlength:3, equalTo:"input[name='password']"},
        },
        messages: {
            password: { minlength:"{{__('lang.최소 3자이상 입력해주십시오')}}"},
            password_confirm: {minlength:"{{__('lang.최소 3자이상 입력해주십시오')}}", equalTo:"{{__('lang.암호와 일치하여야 합니다')}}"},
        },
        errorPlacement: function (error, element) {
            if($(element).closest('div').children().filter("div.error-div").length < 1)
                $(element).closest('div').append("<div class='error-div'></div>");
            $(element).closest('div').children().filter("div.error-div").append(error);
        },
        submitHandler: function(form){
            var url = $(form).attr("action");
            var fdata = new FormData($("#regForm")[0]);

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
                            window.location.href = "{{url('/')}}"
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
<!--global js end-->
</body>
</html>
