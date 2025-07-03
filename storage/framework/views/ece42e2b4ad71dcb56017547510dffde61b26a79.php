<!DOCTYPE html>
<?php echo e(getCurrentLang()); ?>

<html>

<head>
    <title><?php echo e(__('lang.관리자페이지')); ?> | <?php echo e(__('lang.로그인')); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- global level css -->
    <link href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>" rel="stylesheet" />
    <!-- end of global level css -->
    <!-- page level css -->
    <link href="<?php echo e(asset('assets/css/pages/login2.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('assets/vendors/iCheck/css/minimal/blue.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('assets/vendors/bootstrapvalidator/css/bootstrapValidator.min.css')); ?>" rel="stylesheet"/>
    <link href="<?php echo e(asset('assets/vendors/sweetalert/css/sweetalert.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- styles of the page ends-->
</head>

<body>
<div class="container">
    <div class="row vertical-offset-100">
        <div class=" col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3  col-md-5 col-md-offset-4 col-lg-4 col-lg-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading hidden">
                    <h3 class="panel-title text-center"><?php echo e(__('lang.관리자페이지')); ?></h3>
                </div>
                <div class="panel-body">
                    <form action="<?php echo e(route('signin')); ?>" id="authentication" autocomplete="on" method="post" role="form">
                        <!-- CSRF Token -->
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />

                        <div class="form-group pt-20 <?php echo e($errors->first('email', 'has-error')); ?>">
                            <input class="form-control" placeholder="ID" name="email" type="text"
                                   value="<?php echo old('email'); ?>"/>
                            <div class="help-block">
                                <?php echo $errors->first('email', '<span class="help-block">:message</span>'); ?>

                            </div>
                        </div>
                        <div class="form-group  <?php echo e($errors->first('password', 'has-error')); ?>">
                            <input class="form-control" placeholder="Password" name="password" type="password"/>
                            <div class="help-block">
                                <?php echo $errors->first('password', '<span class="help-block">:message</span>'); ?>

                            </div>
                        </div>
                        <div class="form-group pb-20 border-bottom-line">
                            <label>
                                <input name="remember-me" type="checkbox" value="Remember Me" class="minimal-blue"/>
                                Remember Me
                            </label>
                        </div>

                        <input type="submit" value="로그인" class="btn btn-info btn-block btn-lg mt-20 mb-20" />
                    </form>
                </div>
            </div>
            <div class = "copyright">
                2019 © Admin Page.
            </div>
        </div>
    </div>
</div>
<script src="<?php echo e(url('assets/mobiscroll/js/mobiscroll/jquery-1.11.1.min.js')); ?>" type="text/javascript"></script>
<!-- global js -->
<script src="<?php echo e(asset('assets/js/app.js')); ?>" type="text/javascript"></script>
<!-- end of global js -->
<!-- begining of page level js-->
<script src="<?php echo e(asset('assets/js/TweenLite.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/vendors/iCheck/js/icheck.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/vendors/bootstrapvalidator/js/bootstrapValidator.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/js/pages/login2.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/vendors/sweetalert/js/sweetalert.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/vendors/sweetalert/js/sweetalert-dev.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(url('assets/js/pages/admin/common.js')); ?>"></script>
<!-- end of page level js-->
<script>
    $(function(){
        var msg = "<?php echo $errors->first('email', ':message'); ?>";
        if(msg != ""){
            errorMsg(msg);
        }
    });
</script>
</body>
</html>