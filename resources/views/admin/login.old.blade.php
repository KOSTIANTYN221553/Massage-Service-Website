<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="ko">
{{getCurrentLang()}}
<!--<![endif]-->

<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>{{__('lang.관리자페이지')}} | {{__('lang.로그인')}}</title>
    <meta content="{{__('lang.관리자페이지')}} | {{__('lang.로그인')}}" name="description"/>
    @include('admin/common/common_meta')

    <link href="{{asset('assets/theme/metronic/assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/theme/metronic/assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/theme/metronic/assets/pages/css/login.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .login .content .forget-password {
            margin-top: 0;
            margin-right: 8px;
        }
    </style>

    <script>

    </script>


</head>
<!-- END HEAD -->

<body class="page-footer-fixed login">
<div class="page-wrapper">
    <!-- BEGIN LOGO -->
    <div class="logo">
        <img src="{{ url('images/logo_header.png') }}" alt="" style="margin-top: -100px; margin-bottom: -110px; width: 330px;"/>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN LOGIN -->
    <div class="content" style="margin-top: 30px; padding-top: 30px">
        <!-- BEGIN LOGIN FORM -->
        <form class="login-form" action="{{ route('signin') }}" id="authentication" autocomplete="on" method="post" role="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <h3 class="form-title font-green"></h3>
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span> {{__('lang.아이디와 비밀번호를 입력해주세요')}} </span>
            </div>
            <div class="form-group {{ $errors->first('email', 'has-error') }}">
                <label class="control-label visible-ie8 visible-ie9">ID</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="{{__('lang.아이디')}}" name="email" />
                <div class="help-block">
                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->first('password', 'has-error') }}">
                <label class="control-label visible-ie8 visible-ie9">Password</label>
                <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="{{__('lang.비밀번호')}}" name="password" />
                <div class="help-block">
                    {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                </div>
            </div>
            <div class="form-actions text-center">
                <label class="rememberme check mt-checkbox mt-checkbox-outline">
                    <input type="checkbox" name="remember-me"  value="Remember Me"  id="remember"/>Remember
                    <span></span>
                </label>
            </div>
            <div class="form-group" style="margin-top:20px;">
                <button type="submit"  class="btn green uppercase" style="width: 100%; height: 50px;">{{__('lang.로그인')}}</button>
            </div>
            <div class="form-group hidden" style="margin-top:20px;">
                <button type="button" class="btn default uppercase" style="width: 100%; height: 50px;" onclick="window.location = '{{ url('ilabsmul/admin_join') }}'">Admin {{__('lang.가입')}}</button>
            </div>
            <div class="form-group hidden" style="margin-top:20px;">
                <button type="button" class="btn default uppercase" style="width: 100%; height: 50px;" onclick="window.location = '{{ url('admin/forgot_password') }}'">{{__('lang.비밀번호 찾기')}}</button>
            </div>

        </form>
        <!-- END LOGIN FORM -->
    </div>
    <!-- END LOGIN -->
    <div class="copyright"> 2019 © Admin Page. </div>

    <!-- BEGIN FOOTER -->
    @include ('admin/common/common_footer')
    <!-- END FOOTER -->
</div>

<!-- BEGIN PAGE LEVEL PLUGINS -->

</body>

</html>