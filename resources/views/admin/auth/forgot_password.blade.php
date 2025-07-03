<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="ko">
<!--<![endif]-->
{{getCurrentLang()}}
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>Smul {{__('lang.관리자페이지')}} | {{__('lang.비밀번호 찾기')}}</title>
    <meta content="Smul {{__('lang.관리자페이지')}} | {{__('lang.비밀번호 찾기')}}" name="description"/>

    @include('admin/common/common_meta')

    <link href="{{ url('assets/theme/metronic/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/theme/metronic/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/theme/metronic/assets/pages/css/login.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .login .content #email-check-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: #ffffff;
        }
        .login .content #email-check-btn:active,
        .login .content #email-check-btn:hover,
        .login .content #email-check-btn:focus {
            border-color: #32c5d2;
            color: #FFF;
            background-color: #32c5d2;
        }
    </style>

    @include('admin/common/common_script')
</head>
<!-- END HEAD -->

<body class="page-footer-fixed login">
<div class="page-wrapper">
    <!-- BEGIN LOGO -->
    <div class="logo">
        <a href="{{ url('admin/login') }}">
            <img src="{{ url('images/logo_header.png') }}" alt="" style="margin-top: -100px; margin-bottom: -110px; width: 330px;"/>
        </a>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN LOGIN -->
    <div class="content" style="margin-top: 30px;">
        <!-- BEGIN LOGIN FORM -->
        <form class="register-form">
            <h3 class="font-green" style="margin-bottom: 30px;">SMUL Admin </h3>
            <div class="alert alert-danger display-hide">
                <button class="close" data-close="alert"></button>
                <span> {{__('lang.이메일 증복 확인을 해주세요')}} </span>
            </div>
            <div class="form-group">
                <label class="control-label visible-ie8 visible-ie9">{{__('lang.이름')}}</label>
                <input class="form-control placeholder-no-fix" type="text" placeholder="{{__('lang.이름을 입력해주세요')}}" name="name" id="name"/>
            </div>
            <div class="form-group" style="position: relative;">
                <label class="control-label visible-ie8 visible-ie9">{{__('lang.이메일 아이디')}}</label>
                <input class="form-control placeholder-no-fix" type="text" placeholder="{{__('lang.이메일 주소를 입력하세요')}}" name="email" id="email"/>
            </div>
            <div class="form-actions">
                <button type="button" id="register-back-btn" class="btn green btn-outline">{{__('lang.뒤로')}}</button>
                <button type="button" id="register-submit-btn" class="btn btn-success uppercase pull-right">{{__('lang.비밀번호 찾기')}}</button>
            </div>
        </form>
        <!-- END LOGIN FORM -->
    </div>
    <!-- END LOGIN -->
    <div class="copyright"> 2019 © Smul Admin Page. </div>

    <!-- BEGIN FOOTER -->
    @include('admin/common/common_footer')
    <!-- END FOOTER -->
</div>

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ url('assets/theme/metronic/assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/theme/metronic/assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ url('assets/theme/metronic/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ url('assets/js/admin/forgot_password.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
</body>

</html>