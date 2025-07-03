<!DOCTYPE html>
<?php echo e(getCurrentLang()); ?>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(__('lang.회원가입')); ?> | <?php echo e(env('SITE_NAME')); ?></title>
    <!--global css starts-->
    <link href="<?php echo e(asset('assets/css/app.css')); ?>" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('assets/images/favicon.png')); ?>" type="image/x-icon">
    <link rel="icon" href="<?php echo e(asset('assets/images/favicon.png')); ?>" type="image/x-icon">
    <!--end of global css-->
    <!--page level css starts-->
    <link type="text/css" rel="stylesheet" href="<?php echo e(asset('assets/vendors/iCheck/css/all.css')); ?>" />
    <link href="<?php echo e(asset('assets/vendors/bootstrapvalidator/css/bootstrapValidator.min.css')); ?>" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/frontend/register.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/loading/loading.css')); ?>">
    <link href="<?php echo e(asset('assets/vendors/sweetalert/css/sweetalert.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('assets/css/pages/toastr.css')); ?>" rel="stylesheet" />

    <!--end of page level css-->
    <style>
        div.error-div{
            text-align: left;
            color: #900d0d;
        }

        .radius-0{
            border-radius: 0px !important;
        }

    </style>
</head>
<body>
<div class="container">
    <!--Content Section Start -->
    <div class="row">
        <div class="box">
            <h3 class="text-danger"><?php echo e(__('lang.회원가입')); ?></h3>
            <!-- Notifications -->
            <div id="notific">
            <?php echo $__env->make('notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <form id = "regForm" action="<?php echo e(url('user_register')); ?>" method="POST" >
                <!-- CSRF Token -->
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
                <div class="form-group <?php echo e($errors->first('email', 'has-error')); ?>">
                    <label style = "float:left; margin-left:0px;"> <?php echo e(__('lang.아이디')); ?></label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="<?php echo e(__('lang.영문자,숫자,_만 입력가능. 최소 3자이상 입력해주세요')); ?>"
                           value="<?php echo old('email'); ?>" >
                    <?php echo $errors->first('email', '<div class="help-block">:message</div>'); ?>

                </div>
                <div class="form-group <?php echo e($errors->first('password', 'has-error')); ?>">
                    <label style = "float:left; margin-left:0px;"> <?php echo e(__('lang.비밀번호')); ?></label>
                    <input type="password" class="form-control" id="Password1" name="password" placeholder="<?php echo e(__('lang.비밀번호를 입력해주세요')); ?>">
                    <?php echo $errors->first('password', '<div class="help-block">:message</div>'); ?>

                </div>
                <div class="form-group <?php echo e($errors->first('password_confirm', 'has-error')); ?>">
                    <label class="sr-only"> <?php echo e(__('lang.비밀번호확인')); ?></label>
                    <input type="password" class="form-control" id="Password2" name="password_confirm"
                           placeholder="<?php echo e(__('lang.비밀번호확인을 입력해주세요')); ?>">
                    <?php echo $errors->first('password_confirm', '<div class="help-block">:message</div>'); ?>

                </div>
                <div class="clearfix"></div>
                <div class="form-group <?php echo e($errors->first('nickname', 'has-error')); ?>">
                    <label style = "float:left; margin-left:0px;"> <?php echo e(__('lang.별명')); ?></label>
                    <input type="text" class="form-control" id="nickname" name="nickname" placeholder="<?php echo e(__('lang.한글 2자 영문4자이상 입력해주세요')); ?>"
                           value="<?php echo old('nickname'); ?>" >
                    <?php echo $errors->first('nickname', '<div class="help-block">:message</div>'); ?>

                </div>
                <div class="clearfix"></div>
                <div class="form-group <?php echo e($errors->first('gender', 'has-error')); ?>">
                    <label style = "float:left; margin-left:0px;"><?php echo e(__('lang.성별')); ?></label>
                    <label class="radio-inline" style = "float:left;">
                        <input type="radio" name="gender" id="inlineRadio1" value="1" checked><?php echo e(__('lang.남성')); ?>

                    </label>
                    <label class="radio-inline" style = "float:left;">
                        <input type="radio" name="gender" id="inlineRadio2" value="2"> <?php echo e(__('lang.여성')); ?>

                    </label>
                    <?php echo $errors->first('gender', '<div class="help-block">:message</div>'); ?>

                </div>
                <div class="clearfix"></div>
                <div class="form-group <?php echo e($errors->first('user_email', 'has-error')); ?>" style = "margin-top:10px;">
                    <label style = "float:left; margin-left:0px;" > E-mail</label>
                    <input type="email" class="form-control" id="user_email" name="user_email" placeholder="<?php echo e(__('lang.이메일은 아이디 비밀번호찾기에 이용하니 정확히 기재해주시기 바랍니다')); ?>"
                           value="<?php echo old('user_email'); ?>" >
                    <?php echo $errors->first('email', '<div class="help-block">:message</div>'); ?>

                </div>
                <div class="form-group " style = "margin-top:10px;">
                    <label style = "float:left; margin-left:0px;" > <?php echo e(__('lang.자기소개')); ?></label>
                    <textarea class = "form-control radius-0" name ="description" rows = "2" style ="resize:none;"><?php echo old('description'); ?></textarea>
                </div>
                <div class = "row">
                    <div class = "col-md-4 col-lg-4">
                        <img id = "code" src = "<?php echo e(url('/getDigitImage')); ?>"/>
                    </div>
                    <div class = "col-md-5 col-lg-8">
                        <input type = "text" class ="form-control" name ="code" style = "display:inline-block; width:150px;"/>
                        <i class ="fa fa-fw fa-repeat " style = "font-size:20px; line-height:40px; cursor:pointer;" onclick = "refreshCode();" ></i>
                    </div>
                </div>
                <?php echo $errors->first('code', '<div class="help-block">:message</div>'); ?>

                <div class = "row" style = "margin-top:40px;">
                    <div class = "col-md-6">
                        <button type="submit" class="btn btn-responsive button-alignment btn-danger form-control radius-0"><?php echo e(__('lang.회원가입')); ?></button>
                    </div>
                    <div class = "col-md-6">
                        <button type="button" onclick ="goHomepage()" class="btn  btn-responsive button-alignment btn-danger form-control radius-0"><?php echo e(__('lang.취소')); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- //Content Section End -->
</div>
<!--global js starts-->
<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('assets/vendors/iCheck/js/icheck.js')); ?>"></script>
<script  src="<?php echo e(asset('assets/js/jquery.validate.js')); ?>"  type="text/javascript"></script>
<script src="<?php echo e(asset('assets/vendors/noty/js/jquery.noty.packaged.min.js')); ?>" ></script>
<script type="text/javascript" src="<?php echo e(asset("assets/loading/loading.js")); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/sweetalert/js/sweetalert.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/vendors/sweetalert/js/sweetalert-dev.js')); ?>" type="text/javascript"></script>
<script  src="<?php echo e(asset('assets/js/pages/admin/common.js')); ?>"  type="text/javascript"></script>
<script>
    function goHomepage(){
        window.location.href = "<?php echo e(url('/')); ?>";
    }

    function refreshCode(){
        $("#code").attr("src", "<?php echo e(url('/getDigitImage')); ?>");
    }


    $(document).ready(function() {
        $("input[type='checkbox'],input[type='radio']").iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
    });
    $("#regForm1").validate({
        rules: {
            email:{"required":true,"minlength":3} ,
            password_confirm: {required:true, minlength:8, equalTo:"input[name='password']"},
            password: {required:true, minlength:8, },
            nickname:{"required":true,"minlength":2} ,
            user_email:{"required":true} ,
        },
        messages: {
            email: {"required":"<?php echo e(__('lang.아이디를 입력해주세요')); ?>", minlength:"<?php echo e(__('lang.최소 8자이상 입력해주십시오')); ?>"},
            password: {required:"<?php echo e(__('lang.암호확인을 입력해주세요')); ?>", minlength:"<?php echo e(__('lang.최소 8자이상 입력해주십시오')); ?>"},
            password_confirm: {required:"<?php echo e(__('lang.암호확인을 입력해주세요')); ?>", minlength:"<?php echo e(__('lang.최소 3자이상 입력해주십시오')); ?>", equalTo:"<?php echo e(__('lang.암호와 일치하여야 합니다')); ?>"},
            nickname: {"required":"<?php echo e(__('lang.별명을 입력해주세요')); ?>", minlength:"<?php echo e(__('lang.최소 2자이상 입력해주십시오')); ?>"},
            user_email: {"required":"<?php echo e(__('lang.이메일을 입력해주세요')); ?>", },
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
                        successMsg("<?php echo e(__('lang.수정이 성공하였습니다.')); ?>", function(){
                            goBack();
                        });
                    } else {
                        errorMsg(data.msg);
                    }
                },
                error: function() {
                    errorMsg("<?php echo e(__('lang.서버에서 오류가 발생하였습니다.')); ?>");
                }
            });

        }

    });
</script>
<!--global js end-->
</body>
</html>
