<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
<?php echo e(__('lang.스케쥴상세')); ?>

##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
    <!--page level css starts-->
    <!--end of page level css-->
    <style>
        .schedule-detail{
            border-bottom:1px solid #b3b3b3;
        }
        .schedule-detail-left{
            padding-top:10px;
            padding-bottom:10px;
            color:black;
            text-align:center;
            background: #747474;
            min-height:60px;
        }
        .schedule-detail-left span{
            color:black;
        }

        .schedule-detail-right{
            padding-top:10px;
            padding-bottom:10px;
            background:black;
            text-align:left;
            color: #747474;
            overflow-x: auto;
            max-height: 42px;
            word-wrap: break-word;
            min-height:60px;
        }

        .badge-danger{
            padding:3px 5px;
            color:#855b55;
            background:#f56954;
            cursor:pointer;

        }
        .schedule-table thead th{
            background: #dff0d8;
            color:#7aaabe;
        }

        .html-left-wrapper{
            display: inline-block;
            height:200px;
        }
        .html-wrapper{
            margin-top:0px;height:200px;  padding:10px;
        }

        .html-wrapper div{
            background: black;margin:10px;overflow: auto;height:100px;color: #909090;
        }

        @media (max-width:480px) {
            .html-left-wrapper{
                display:none;
            }
            .html-wrapper{
                margin-top:0px;height:auto;  padding:10px;
            }
            .html-wrapper div{
                background: black;margin:10px;overflow: auto;height:auto;color: #909090;
            }

            .table-scrollable{
                padding-left:10px;
                padding-right:10px;
            }

        }
        #description img {
            width: 100% !important;
            height: auto !important;
        }

    </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="container ">
        <div class = "row">
            <div class = "col-md-9 col-xs-12 mt-10">
                <div class ="row hidden-sm hidden-md hidden-lg mt-10 mb-10">
                    <div class ="col-md-12">
                        <div class="media">
                            <div class="media-left media-middle">
                                <a href="#">
                                    <img class="media-object img-circle" src="<?php echo e(url($info['shop']['img'])); ?>" style ="width:40px;height:40px;" onerror="noExitImg(this)" alt="image">
                                </a>
                            </div>
                            <div class="media-body">
                                <p class="media-heading">
                                    <?php if($info['is_force_end'] == "0"): ?> <?php echo e($info['title']); ?> <?php else: ?> <?php echo e(__('lang.마감 하였습니다')); ?> <?php endif; ?>
                                </p>
                                <p class="">
                                    <span><?php echo e(substr($info['updated_at'],0,10)); ?></span>
                                    <i class="fa fa-eye text-white-gray ml-10"></i><span class = "text-white-gray ml-5 cursor"><?php echo e($info['view_count']); ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row content bg-black-grey relative pt-20 pb-10 hidden-xs">
                    <div style ="position:absolute; width:100%; top:10px; height:2px; left:0px; background: #565656;" ></div>
                    <div class = "col-md-10 col-xs-12 text-left ">
                        <span class = "font-16 color-white-gray"><?php if($info['is_force_end'] == "0"): ?> <?php echo e($info['title']); ?> <?php else: ?> <?php echo e(__('lang.마감 하였습니다')); ?> <?php endif; ?></span>
                    </div>
                    <div class = "col-md-2 col-xs-12 text-right">
                        <span class = "color-white-gray"><?php echo e(__('lang.조회수')); ?>: </span> <span class ="color-red ml-10"><?php echo e(number_format($info['view_count'])); ?></span> <span class = "color-white-gray"><?php echo e(__('lang.회')); ?></span>
                    </div>
                </div>
                <div class = "row">
                    <div class ="col-md-6">
                        <div class = "row">
                            <div class ="col-md-4 col-xs-4  schedule-detail-left schedule-detail">
                                <span><?php echo e(__('lang.업소이름')); ?></span>
                            </div>
                            <div class ="col-md-8  col-xs-8 schedule-detail-right schedule-detail">
                                <span><?php if(isset($info['shop'])): ?><?php echo e($info['shop']['title']); ?> <?php else: ?> <?php echo e(__('lang.미정')); ?> <?php endif; ?> </span>
                            </div>
                        </div>
                    </div>
                    <div class ="col-md-6">
                        <div class = "row">
                            <div class ="col-md-4 col-xs-4 schedule-detail-left schedule-detail">
                                <span><?php echo e(__('lang.업소종류')); ?></span>
                            </div>
                            <div class ="col-md-8 col-xs-8 schedule-detail-right schedule-detail">
                                <span><?php if(isset($info['shop'])): ?> <?php echo e($info['shop']['shop_type']['title']); ?> <?php else: ?> <?php echo e(__('lang.미정')); ?> <?php endif; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class ="col-md-6">
                        <div class = "row">
                            <div class ="col-md-4 col-xs-4 schedule-detail-left schedule-detail">
                                <span><?php echo e(__('lang.예약전화번호')); ?></span>
                            </div>
                            <div class ="col-md-8 col-xs-8 schedule-detail-right schedule-detail">
                                <span><?php echo e($info['shop_phone']); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class ="col-md-6">
                        <div class = "row">
                            <div class ="col-md-4 col-xs-4 schedule-detail-left schedule-detail">
                                <span><?php echo e(__('lang.영업시간')); ?></span>
                            </div>
                            <div class ="col-md-8 col-xs-8 schedule-detail-right schedule-detail">
                                <span><?php echo e($info['s_time']); ?> ~<?php echo e($info['e_time']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class ="col-md-6">
                        <div class = "row">
                            <div class ="col-md-4 col-xs-4  schedule-detail-left schedule-detail">
                                <span class ="text-ellipsis">SNS</span>
                            </div>
                            <div class ="col-md-8 col-xs-8 schedule-detail-right schedule-detail">
                                <span><?php echo e($info['sns_id']); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class ="col-md-6">
                        <div class = "row">
                            <div class ="col-md-4 col-xs-4 schedule-detail-left schedule-detail">
                                <span><?php echo e(__('lang.위치')); ?></span>
                            </div>
                            <div class ="col-md-8 col-xs-8 schedule-detail-right schedule-detail">
                                <span><?php echo e($info['location']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class ="col-md-12">
                        <div class = "row">
                            <div class ="col-md-2  html-left-wrapper schedule-detail-left schedule-detail">
                                <span><?php echo e(__('lang.서비스요금 및 코스안내')); ?></span>
                            </div>
                            <div class ="col-md-10 html-wrapper schedule-detail-right schedule-detail" style = "max-height:200px;">
                                <div style ="">
                                    <?php echo $info['description']; ?>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class = "row mt-10">
                    <div class ="col-md-12 pr-0 pl-0">
                        <div class ="table-scrollable">
                            <table class = "table table-striped schedule-table">
                            <thead>
                                <tr>
                                    <th><?php echo e(__('lang.이름')); ?></th>
                                    <th><?php echo e(__('lang.나이')); ?></th>
                                    <th><?php echo e(__('lang.사이즈')); ?></th>
                                    <th><?php echo e(__('lang.키')); ?></th>
                                    <th><?php echo e(__('lang.가슴')); ?></th>
                                    <th class = "hidden-xs"><?php echo e(__('lang.흡연여부')); ?></th>
                                    <th class = "hidden-xs"><?php echo e(__('lang.근무시간')); ?></th>
                                    <th class = "hidden-xs text-center"><?php echo e(__('lang.프로필')); ?></th>
                                    <th><?php echo e(__('lang.사진')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $info['detail_list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($item['manager']['nickname']); ?></td>
                                        <td><?php echo e($item['manager']['age']); ?></td>
                                        <td><?php echo e($item['manager']['body_size']); ?></td>
                                        <td><?php echo e($item['manager']['height']); ?></td>
                                        <td><?php echo e($item['manager']['cup_size']); ?></td>
                                        <td class = "hidden-xs"><?php echo e($item['manager']['is_smoking']); ?></td>
                                        <td class = "hidden-xs"><?php echo e($item['schedule_start_at']); ?> ~<?php echo e($item['schedule_end_at']); ?> </td>
                                        <td class = "hidden-xs" style = "width: 30%; word-break: break-all;">
                                            <?php echo strip_tags($item['manager']['description']); ?>

                                        </td>
                                        <td>
                                            <?php if($item['manager']['photo_url'] != ''): ?>
                                                <a  onclick = "viewImg(this)" class = "cursor" src = "<?php echo e(url($item['manager']['photo_url'])); ?>" href ="javascript:void(0)" ><?php echo e(__('lang.보기')); ?></a>
                                            <?php endif; ?>
                                        </td>

                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($info['detail_list']) == 0): ?>
                                    <tr>
                                        <td colspan ="9"><?php echo e(__('lang.자료가 없습니다.')); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class = "col-md-12" id = "description">
                        <?php echo $info['description2']; ?>

                    </div>
                </div>

            </div>
            <div class = "col-md-3 hidden-xs">
                <?php echo $__env->make('layouts/right-side', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    <!-- //Container End -->
    </div>
    <?php echo $__env->make('dlg/img_view_dlg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
    <script>
        function  detailView(obj){
            var id = $(obj).attr("data-id");
            window.location.href = "<?php echo e(url("/schedule_info")); ?>/"+id;
        }
        function viewImg(obj){
            $("#img-view-dialog #img").attr("src", $(obj).attr("src"));
            $("#img-view-dialog").modal("show");
        }
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>