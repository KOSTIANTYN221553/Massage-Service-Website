<!DOCTYPE html>
<html>
{{getCurrentLang()}}
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>503 Internal Error | Welcome to Josh Frontend</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- global level js -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- end of global js-->
    <!-- page level styles-->
    <link href="{{ asset('assets/css/frontend/500.css') }}" rel="stylesheet" type="text/css" />
    <!-- end of page level styles-->
</head>
<body>
<div class="container-fluid">
    <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-offset-1 col-xs-10 middle">
        <div class="error-container">
            <div class="error-main">
                <h1> <i class="livicon" data-name="recycled" data-s="100" data-c="#ffbc60" data-hc="#ffbc60" data-eventtype="click" data-iteration="15" data-duration="2000"></i>
                    503
                </h1>
                <h3>
                    Be Right Back
                </h3>
            </div>
        </div>
    </div>
</div>
<!-- global js -->
<script src="{{ asset('assets/js/jquery-1.11.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!--livicons-->
<script src="{{ asset('assets/vendors/livicons/minified/raphael-min.js') }}"></script>
<script src="{{ asset('assets/vendors/livicons/minified/livicons-1.4.min.js') }}"></script>
<!-- end of global js -->
<!-- begining of page level js-->
<script>
    $("document").ready(function() {
        setTimeout(function() {
            $(".livicon").trigger('click');
        }, 10);
    });
    // code for aligning center
    $(document).ready(function() {
        var x = $(window).height();
        var y = $(".middle").height();
        //alert(x);
        x = x - y;
        x = x / 2;
        $(".middle").css("padding-top", x);
    });
</script>
<!-- end of page level js-->
</body>
</html>