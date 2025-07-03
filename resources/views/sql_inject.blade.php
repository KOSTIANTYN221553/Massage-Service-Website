<!DOCTYPE html>
<html>
{{getCurrentLang()}}
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{__('lang.파라메터오류')}}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- global level css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- end of globallevel css-->
    <!-- page level styles-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/frontend/404.css') }}" />
    <!-- end of page level styles-->
</head>

<body>

    <div id="animate" class="row">
        <div class="number">4</div>
        <div class="icon"> <i class="livicon" data-name="pacman" data-size="105" data-c="#f6c500" data-hc="#f1b21d" data-eventtype="click" data-iteration="15"></i>
        </div>
        <div class="number">4</div>
    </div>
    <div class="hgroup">
        <h1>{{__('lang.앗 미안합니다')}}</h1>
        <h2>{{__('lang.검색문자열에 인젝문자열이 포함되엇습니다')}} <br>{{__('lang.보안을 위하여 이러한 요청을 차단합니다')}}{{__('lang.관리자에게 문의하여 주십시오')}}</h2>
        <a href="{{ route('home') }}">
            <button type="button" class="btn btn-primary button-alignment">{{__('lang.첫페이지')}}</button>
        </a>
    </div>
    <!-- global js -->
    <script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <!--livicons-->
    <script src="{{ asset('assets/js/raphael-min.js') }}"></script>
    <script src="{{ asset('assets/js/livicons-1.4.min.js') }}"></script>
    <!-- end of global js -->
    <!-- begining of page level js-->
    <script src="{{ asset('assets/js/frontend/404.js') }}"></script>
    <!-- end of page level js-->
</body>
</html>