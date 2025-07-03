<!DOCTYPE html>
<html>
<?php echo e(getCurrentLang()); ?>

<head>
    <meta charset="UTF-8">
    <title>
        <?php $__env->startSection('title'); ?>
            | <?php echo e(__('lang.관리자페이지')); ?>

        <?php echo $__env->yieldSection(); ?>
    </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <!-- global css -->
    <?php echo $__env->make("admin/layouts/style", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->yieldContent('header_styles'); ?>
    <!--end of page level css-->

<body class="skin-josh">
<input type = "file" id = "cropFileInput" class = "hidden" accept="image/*" />
<input type = "file" id = "cropFileInputNocrop" class = "hidden" accept="image/*" />
<script>
    var public_path = '<?php echo e(url("/")); ?>';
    var _token = '<?php echo e(csrf_token()); ?>';
</script>

<script>
    var lang_msg =  new Object();
    lang_msg['항목을 선택해주십시오'] = "<?php echo e(__('lang.항목을 선택해주십시오')); ?>";
    lang_msg['정말 삭제하겟습니까?']="<?php echo e(__('lang.정말 삭제하겟습니까?')); ?>";
    lang_msg['수정이 성공하었습니다.']="<?php echo e(__('lang.수정이 성공하었습니다.')); ?>";
    lang_msg['검색어를 입력해 주세요(2자 이상)']="<?php echo e(__('검색어를 입력해 주세요(2자 이상)')); ?>";
    lang_msg['일']="<?php echo e(__('lang.일')); ?>";
    lang_msg['분']="<?php echo e(__('lang.분')); ?>";
    lang_msg['초']="<?php echo e(__('lang.초')); ?>";
    lang_msg['시간']="<?php echo e(__('lang.시간')); ?>";
</script>
<style>

    /*.language-rect{
        position: absolute;
        top: 20px;
        right: 10px;
    }*/

    /*.language-rect .dropdown-menu {
        background: #222222;
        left: -34px;
        min-width: 135px;
        top: 15px;
    }*/

    /*.language-rect a{*/
        /*color:white;*/
    /*}*/

    /*.lang-item {*/
        /*margin-bottom: 3px;*/
        /*margin-left: 11px;*/
    /*}*/

    /*.lang-item.active a, .lang-item.active a:hover {*/
        /*background: transparent;*/
        /*color: red;*/
    /*}*/

    /*.lang-item span.fa.fa-check {*/
        /*position: absolute;*/
        /*left: 2px;*/
    /*}*/

</style>

<header class="header">
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="logo">
        <?php $user = Sentinel::getuser();?>
        <?php if($user['type']*1 == 99): ?>
            <img src="<?php echo e(asset('assets/images/log/logo_admin.png')); ?>" alt="logo">
        <?php else: ?>
                <img src="<?php echo e(asset('assets/images/log/logo_shop.png')); ?>" alt="logo">
        <?php endif; ?>
    </a>
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <div>
            <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <div class="responsive_nav"></div>
            </a>
        </div>
        <label class = "top-counter" id = "diff_time1">

        </label>
        <div class="navbar-right">
            <ul class="nav navbar-nav">
                <li class = "language-rect">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <div class="riot">
                            <div>
                                <i class = "fa fa-globe" style = "margin-right:10px;"> </i>Language
                                <span>
                                    <i class="caret"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <li class = "lang-item <?php if(App::isLocale("vn")): ?> active <?php endif; ?>">
                            <a href="javascript:void(0);" onclick = "setMyLang('vn')">
                                <?php if(App::isLocale("vn")): ?> <span class = "fa fa-check" > </span> <?php endif; ?> Tiếng Việt
                            </a>
                        </li>
                        <li class = "lang-item <?php if(App::isLocale("kr")): ?> active <?php endif; ?>">
                            <a href="javascript:void(0);" onclick = "setMyLang('kr')">
                                <?php if(App::isLocale("kr")): ?> <span class = "fa fa-check" > </span> <?php endif; ?> 한국어
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="messages-menu">
                    <a href="<?php echo e(URL::to('admin/logout')); ?>" style = " color:white;">
                        <i class="livicon" data-name="sign-out" data-s="28" data-c="#6CC66C" data-hc="#6CC66C"></i>
                         <?php echo e(__('lang.로그아웃')); ?>

                    </a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="wrapper ">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side ">
        <section class="sidebar ">
            <div class="page-sidebar  sidebar-nav">
                <div class="clearfix"></div>
                <!-- BEGIN SIDEBAR MENU -->
                <?php echo $__env->make('admin.layouts._left_menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <!-- END SIDEBAR MENU -->
            </div>
        </section>
    </aside>
    <aside class="right-side">

        <!-- Notifications -->
        <div id="notific">
        <?php echo $__env->make('notifications', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>

                <!-- Content -->
        <?php echo $__env->yieldContent('content'); ?>

    </aside>
    <!-- right-side -->
</div>
<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Return to top"
   data-toggle="tooltip" data-placement="left">
    <i class="livicon" data-name="arrow-up" data-size="18" data-loop="true" data-c="#fff" data-hc="white"></i>
</a>
<!-- global js -->
<?php echo $__env->make("admin/layouts/script", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<!-- end of global js -->
<!-- begin page level js -->
<?php echo $__env->yieldContent('footer_scripts'); ?>
        <!-- end page level js -->
<script>
    function setMyLang(lang){
        var param = new Object();
        param._token = _token;
        param.lang = lang;
        $.post(public_path+"/setLang", param, function(data){
        if(data.status == "1"){
        window.location.reload();
        } else{
        errorMsg(data.msg);
        }
        },"json");
    }
</script>
</body>
</html>
