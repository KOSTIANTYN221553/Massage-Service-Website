<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
   <?php echo app('translator')->getFromJson('lang.메인'); ?>
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
        .recent-shop-ul li a {
            cursor: pointer;
            color:white;
        }

        .recent-shop-ul li:hover {
            /*background: #e84848;*/
            /*border-bottom: 3px solid #d7da1a;*/
        }

        .recent-shop-ul li{
            float: left;
            padding: 5px 10px;
            /*border:1px solid white;*/
        }
        .recent-shop-ul li.active{
            /*border:2px solid white;*/
            /*background: #e84848;*/
            border-bottom: 3px solid #D9534F;
        }
        .recent-shop-ul{
            overflow: auto;
            min-height: 40px;
            padding: 0px;
        }

        .top-img-rect{
            position: relative;
            padding-top: 150%;
            overflow: hidden;
            border: 1px solid #e2e2e2;
        }

        .schedule-img{
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            max-width: 100%;
            height: auto;
        }

        .top-content-rect {
            padding: 10px;
        }

        .horizontal-tab ul.tabs li {
            width: 100px;
            text-align: center;
            height: 120px;
            vertical-align: middle;
            word-break: break-all;
            position: relative;
        }

        .horizontal-tab ul.tabs li a {
            position: absolute;
            top: 50%;
            width: 100%;
            left: 0px;
            line-height:25px;
            text-align: center;
            margin-top: -10px;
        }



    </style>
    <!--end of page level css-->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class = "row">
            <div class = "col-md-9 col-xs-12">
                <div class = "border-box margin-box" id = "recent-shop-rect" style = "margin-top:10px; min-height:250px;">
                    <h3 class = "title" style = "text-align:center;"> <i class = "fa fa-fw fa-clock-o"></i><?php echo e(__('lang.최신 업소 스케줄')); ?></h3>
                    <div class = "row ">
                        <div class = "col-md-12" style = "text-align:center;">
                            <ul class = "recent-shop-ul hidden-xs" style = "display: inline-block">
                                <?php $__currentLoopData = $shop_type_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $shop_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class = "<?php if($schedule_type*1 == $shop_type['id']*1): ?> active <?php endif; ?>">
                                        <a class = "schedule_recent_item" data-id = "<?php echo e($shop_type['id']); ?>" href = "javascript:void(0)" onclick1 = "refreshPage('<?php echo e($shop_type['id']); ?>')">
                                            <?php echo shopTitleBreak($shop_type['title']); ?>

                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <select class = "form-control hidden-sm hidden-md hidden-lg radius-0" name = "shop_type_select" onchange="refreshPageMobile()" style = "margin-bottom:10px;">
                                <?php $__currentLoopData = $shop_type_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $shop_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value = "<?php echo e($shop_type['id']); ?>" <?php if($schedule_type*1 == $shop_type['id']*1): ?> selected <?php endif; ?> ><?php echo e($shop_type['title']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-md-6 col-xs-12 hidden">
                            <div class="media p-5">
                                <div class="media-left">
                                    <a href="<?php echo e(url("/schedule_info/1")); ?>">
                                        <img onerror = "noExitImg(this)" class="media-object wh-60" src="<?php echo e(correctImgPath('1.jpg')); ?>" alt="image">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <a href="<?php echo e(url("/schedule_info/1")); ?>">
                                        <h5 class="media-heading text-primary" style = "color:#dfe0da;"><?php echo e(utf8_strcut(strip_tags('12121212'), 50)); ?></h5>
                                    </a>
                                    <span class="text-danger" style = "color:#8c8c8c;">2000-12-21</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $__currentLoopData = $schedule_recent_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key1 => $schedule_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class = "schedule_content <?php if($key1 != 0): ?> hidden <?php endif; ?>" id = "schedule_content_<?php echo e($key1); ?>" >
                        <?php $__currentLoopData = $schedule_item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($key % 4 == 0): ?>
                            <div class = "row">
                            <?php endif; ?>
                            <div class = "col-md-3 col-xs-12">
                                <div class = "top-img-rect">
                                    <a href="<?php echo e(url("/schedule_info/".$item['id'])); ?>">
                                        <img onerror = "noExitImg(this)" class="schedule-img" src="<?php echo e(correctImgPath($item['img'])); ?>" alt="image">
                                    </a>
                                </div>
                                <div class = "top-content-rect">
                                    <a href="<?php echo e(url("/schedule_info/".$item['id'])); ?>">
                                        <h5 class="media-heading text-primary" style = "color:#dfe0da;word-break:break-all;"><?php if($item['is_force_end'] == "0"): ?><?php echo e(utf8_strcut(strip_tags($item['title']), 50)); ?> <?php else: ?> <?php echo e(__('lang.마감 하였습니다')); ?> <?php endif; ?> </h5>
                                    </a>
                                    <span class="text-danger" style = "color:#8c8c8c;"><?php echo e(substr($item['updated_at'],0,10)); ?></span>
                                </div>
                            </div>
                            <?php if($key % 4 == 3 || $key == count($schedule_item)-1): ?>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class = "horizontal-tab  mt-10 margin-box hidden-xs">
                    <ul class = "tabs">
                        <?php $__currentLoopData = $shop_type_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $shop_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class = "<?php if($key*1 == 0): ?> active <?php endif; ?> ">
                                <a class = "active" href ="#tab_default_<?php echo e($key); ?>" data-toggle = "tab"><?php echo e($shop_type['title']); ?></a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <div class="tab-content">
                        <?php $__currentLoopData = $shop_type_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $shop_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="tab-pane <?php if($key*1 == 0): ?> active <?php endif; ?>" id="tab_default_<?php echo e($key); ?>">
                                <div class = "row">
                                    <div class = "col-md-6">
                                        <h3 class = "title-border"><?php echo e(__('lang.최신 업소 후기')); ?></h3>
                                        <ul class = "list-ul">
                                            <?php $__currentLoopData = $shop_type['recent_list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $board): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class = "list-li">
                                                    <a href = "<?php echo e(url("/review_info/".$board['id'])); ?>">
                                                        <div class = "ellipse left"><?php echo e(utf8_strcut(strip_tags($board['title']), 50)); ?></div>
                                                        <div class = "right"><i class = "fa fa-comment color-custom-red"></i><span class = "ml-5"><?php echo e($board['reply_count']); ?></span></div>
                                                    </a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                    <div class = "col-md-6 pr-25">
                                        <h3 class = "title-border"><?php echo e(__('lang.인기 업소 후기')); ?></h3>
                                        <ul class = "list-ul">
                                            <?php $__currentLoopData = $shop_type['favorite_list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $board): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li class = "list-li">
                                                    <a href = "<?php echo e(url("/review_info/".$board['id'])); ?>">
                                                        <div class = "ellipse left"><?php echo e(utf8_strcut(strip_tags($board['title']), 50)); ?></div>
                                                        <div class = "right"><i class = "fa fa-comment color-custom-red"></i><span class = "ml-5"><?php echo e($board['reply_count']); ?></span></div>
                                                    </a>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class = "row mt-10 border-box margin-box hidden">
                    <?php $__currentLoopData = $board_type_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $board_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class = "col-md-6 col-xs-12 pl-0">
                            <h3 class = "title-border"><?php echo e($board_type['title']); ?></h3>
                            <ul class = "list-ul">
                                <?php $__currentLoopData = $board_type['list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $board): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class = "list-li">
                                        <a href = "<?php echo e(url("/board_info/".$board['id'])); ?>">
                                            <div class = "ellipse left"><?php echo e(utf8_strcut(strip_tags($board['title']), 50)); ?></div>
                                            <div class = "right"><i class = "fa fa-comment"></i><span class = "ml-5"><?php echo e($board['reply_count']); ?></span></div>
                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class = "col-md-3 col-xs-12">
                <?php echo $__env->make('layouts/right-side', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
    <script>
        $(function(){
            $(".schedule_recent_item").hover(function(){
                var schedule_id = $(this).attr("data-id");
                $(".schedule_recent_item").parent().removeClass("active");
                $(this).parent().addClass("active");
                $(".schedule_content").addClass("hidden");
                $("#schedule_content_"+schedule_id).removeClass("hidden");
            },
            function(){

            }
            );


            refreshPageMobile();
        });




        function refreshPage(id){
            window.location.href = "<?php echo e(url('/')); ?>?schedule_type="+id;
        }

        function refreshPageMobile(){
            var id = $("select[name='shop_type_select']").val();
            //var schedule_id = $(this).attr("data-id");
            $(".schedule_recent_item").parent().removeClass("active");
            $(this).parent().addClass("active");
            $(".schedule_content").addClass("hidden");
            $("#schedule_content_"+id).removeClass("hidden");
            //window.location.href = "<?php echo e(url('/')); ?>?schedule_type="+id;
        }
    </script>
    <!--page level js ends-->
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>