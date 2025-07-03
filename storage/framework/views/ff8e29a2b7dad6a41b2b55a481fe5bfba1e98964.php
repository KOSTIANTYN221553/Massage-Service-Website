<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
<?php echo e(__('lang.메인')); ?>

##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/frontend/tabbular.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/animate/animate.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/frontend/jquery.circliful.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/owl_carousel/css/owl.carousel.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/owl_carousel/css/owl.theme.css')); ?>">
    <style>
        .form-group{
            text-align:center;
        }
        .radius-0{
            border-radius: 0px !important;
        }
    </style>
    <!--end of page level css-->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class = "row">
            <div class = "col-xs-12">
                <?php if(!Sentinel::check()): ?>
                    <div class = "border-box margin-box" id = "login-rect" style = "margin-top:10px;">
                        <div class = "row">
                            <div class = "col-md-12">
                                <h3 class = "title text-center"> <i class = "fa fa-fw  fa-laptop"></i> <?php echo e(__('lang.로그인')); ?></h3>
                                <form class="form-horizontal" method = "post" action = "<?php echo e(url("login")); ?>">
                                    <input type = "hidden" name = "_token" value = "<?php echo e(csrf_token()); ?>"/>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo e(__('lang.계정')); ?></label>
                                        <div class="col-md-9">
                                            <input name="email" required="" type="text" placeholder="" class="form-control radius-0">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo e(__('lang.암호')); ?></label>
                                        <div class="col-md-9">
                                            <input name="password" type="password" class="form-control radius-0" maxlength="40" required="">
                                        </div>
                                    </div>
                                    <div class = "form-group mt-30">
                                        <div class="col-md-9 col-md-offset-3">
                                            <button  class="btn btn-responsive button-alignment btn-danger form-control radius-0" style="margin-bottom:7px;"><?php echo e(__('lang.로그인')); ?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <?php $user = Sentinel::getuser();?>
                    <div class = "border-box margin-box " id = "login-rect" style = "margin-top:10px;">
                        <div class = "row">
                            <div class = "col-md-12">
                                <h3 class = "title text-center"> <i class = "fa fa-fw  fa-laptop"></i> <?php echo e(__('lang.회원정보')); ?></h3>
                                <form class="" method = "post" action = "<?php echo e(url("logout")); ?>">
                                    <input type = "hidden" name = "_token" value = "<?php echo e(csrf_token()); ?>"/>
                                    <div class="form-group " style = "margin-bottom:0px;text-align:center;">
                                        <label class="col-md-5 p-0 control-label" style = "padding-top:0px !important;"><?php echo e(__('lang.가입일')); ?></label>
                                        <label class = "col-md-5 p-0 pl-10"><?php echo e(substr($user['created_at'],0,10)); ?></label>
                                    </div>

                                    <div class="form-group" style = "margin-bottom:0px;">
                                        <label class="col-md-3 control-label p-0" style = "padding-top:0px !important;"><?php echo e(__('lang.계정')); ?></label>
                                        <label class="col-md-4 p-0 pl-5"><?php echo e($user['email']); ?></label>
                                        <label class="col-md-5 p-0">
                                            <?php if(isset($user['user_level']['id'])): ?>
                                                <img onerror = "noExitImg(this)" style="width:20px !important;" src="<?php echo e(url($user['user_level']['icon'])); ?>"> <?php echo e($user['user_level']['title']); ?>

                                            <?php else: ?>
                                                <?php echo e(__('lang.미정')); ?>

                                            <?php endif; ?>
                                            <i class = "fa fa-gear cursor" onclick = "goUpdateUserInfo()"></i>
                                        </label>
                                    </div>
                                    <div class="form-group" style = "margin-bottom:0px;">
                                        <label class="col-md-3 control-label p-0" style = "padding-top:0px !important;"><?php echo e(__('lang.닉네임')); ?></label>
                                        <label class="col-md-3 p-0 pl-5"><?php echo e($user['nickname']); ?></label>
                                        <label class="col-md-3 control-label p-0" style = "padding-top:0px !important;"><?php echo e(__('lang.포인트')); ?></label>
                                        <label class="col-md-3 p-0 pl-5"><?php echo e(number_format($user['user_point'])); ?></label>
                                    </div>
                                    <?php if($user['type']*1 == 70): ?>
                                        <?php $complete_info = $user->shop_complete_info(); ?>
                                        <div class="form-group " style = "margin-bottom:0px;">
                                            <label class="col-md-5 p-0 control-label" style = "padding-top:0px !important;"><?php echo e(__('lang.만료일')); ?></label>
                                            <label class = "col-md-5 p-0 pl-10">
                                                <?php if($complete_info['diff']*1 == -1): ?>
                                                    <?php echo e(__('lang.없음')); ?>

                                                <?php else: ?>
                                                    <span id = "diff_time" data-diff = "<?php echo e($complete_info['diff']); ?>"></span>
                                                <?php endif; ?>
                                            </label>
                                        </div>
                                    <?php endif; ?>


                                    <?php if($user['type']*1 == 1): ?>
                                        <div class="form-group hidden" style = "margin-bottom:0px;">
                                            <label class="col-md-5 ">[↑<?php echo e(__('lang.일반회원')); ?>]</label>
                                        </div>
                                        <div class="form-group hidden" style = "margin-bottom:0px;">
                                            <label class="col-md-4  control-label"><?php echo e(__('lang.방문수')); ?></label>
                                            <div class="col-md-8">
                                                <label><?php echo e(number_format($user['visit_cnt'])); ?></label>
                                            </div>
                                        </div>
                                    <?php elseif($user['type']*1 == 70): ?>
                                        <div class="form-group hidden" style = "margin-bottom:0px;">
                                            <label class="col-md-4  control-label"><?php echo e(__('lang.방문수')); ?></label>
                                            <div class="col-md-8">
                                                <label><?php echo e(number_format($user['visit_cnt'])); ?></label>
                                            </div>
                                        </div>
                                        <?php $complete_info = $user->shop_complete_info(); ?>
                                        <div class="form-group hidden" style = "margin-bottom:0px;">
                                            <label class="col-md-4 control-label"><?php echo e(__('lang.업소명')); ?></label>
                                            <div class="col-md-8">
                                                <?php if($complete_info['diff']*1 == -1): ?>
                                                    <label><?php echo e(__('lang.없음')); ?></label>
                                                <?php else: ?>
                                                    <label><?php echo e($complete_info['title']); ?></label>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="form-group hidden" style = "margin-bottom:0px;">
                                            <label class="col-md-4 pl-0  control-label"><?php echo e(__('lang.만료일')); ?></label>
                                            <div class="col-md-8">
                                                <?php if($complete_info['diff']*1 == -1): ?>
                                                    <label><?php echo e(__('lang.없음')); ?></label>
                                                <?php else: ?>
                                                    <label id = "diff_time" data-diff = "<?php echo e($complete_info['diff']); ?>"></label>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class = "form-group mt-30">
                                        <div class="col-xs-6 ">
                                            <a href ="javascript:void(0)" onclick = "showNoteDlg(this)" data-user-id = "<?php echo e($user['id']); ?>"  class="btn btn-responsive button-alignment btn-danger form-control radius-0" style="margin-bottom:7px; color:white;"><?php echo e(__('lang.쪽지함')); ?></a>
                                        </div>
                                        <div class="col-xs-6 ">
                                            <a href ="<?php echo e(url('/logout')); ?>" class="btn btn-responsive button-alignment btn-danger form-control radius-0" style="margin-bottom:7px; color:white;"><?php echo e(__('lang.로그아웃')); ?></a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- //Container End -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
    <!-- page level js starts-->
    <script type="text/javascript" src="<?php echo e(asset('assets/js/frontend/jquery.circliful.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/vendors/wow/js/wow.min.js')); ?>" ></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/vendors/owl_carousel/js/owl.carousel.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/frontend/carousel.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/frontend/index.js')); ?>"></script>
    <!--page level js ends-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>