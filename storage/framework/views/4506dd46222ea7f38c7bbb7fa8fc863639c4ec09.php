<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
<?php echo e(__('lang.업소소개')); ?>

##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <?php
        $user_info = getLoginUserInfo();
        $user_id = $user_info['id'];
    ?>
    <div class="container mt-10">
        <?php if(isset($page_title)): ?>
            <div class = "row">
                <div class = "col-md-12 col-xs-12 page-title-wrapper">
                    <span class = ""> <?php echo e($page_title); ?></span>
                </div>
            </div>
        <?php endif; ?>
        <div class = "row">
            <div class = "col-md-9 col-xs-12">
                <form id = "searchForm" action = "<?php echo e(url("schedule/".$shop_type)); ?>"  method = "get">
                    <input type = "hidden" name = "_token" value = "<?php echo e(csrf_token()); ?>"/>
                    <input type = "hidden" name = "category_id" value = "<?php echo e($category_id); ?>"/>
                </form>
                <?php if(isset($category_list)): ?>
                <div class="row">
                    <div class = "col-md-12 col-xs-12 margin-box">
                        <ul class = "category_list">
                            <?php $__currentLoopData = $category_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class = "cursor <?php if($item['id']*1 == $category_id*1): ?> active <?php endif; ?>" onclick = "changeCategoryItem(this)" data-id = "<?php echo e($item['id']); ?>"> <?php echo e($item['title']); ?>(<?php echo e($item['cnt']); ?>)</li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>
                <div class="row">
                    <div class = "col-md-12 col-xs-12 margin-box">
                        <div class = "table-scrollable ">
                            <table class = "table table-striped">
                                <thead>
                                    <tr>
                                        <th class = "text-center hidden" style = "width:3%;">No</th>
                                        <th class = "text-center" style = "width:10%;"><?php echo e(__('lang.분류')); ?></th>
                                        <th class = "text-center" style = "width:13%;"><?php echo e(__('lang.업소명')); ?></th>
                                        <th class = "text-center" style = "width:32%;"><?php echo e(__('lang.제목')); ?></th>
                                        <th class = "text-center  hidden-xs" style = "width:15%;"><?php echo e(__('lang.수정날짜')); ?></th>
                                        <th class = "text-center hidden-xs" style = "width:8%;"><?php echo e(__('lang.조회수')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $self = 0; ?>
                                <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($item['user_id'] == $user_id) $self = 1;?>
                                    <tr class = "cursor">
                                        <td style = "width:3%;" class = "text-center hidden" onclick = "detailView(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e($key+1); ?></td>
                                        <td style = "width:10%;" class = "text-center" onclick = "detailView(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e($item['categoryName']); ?></td>
                                        <td style = "width:13%;" class = "text-center" onclick = "detailView(this)" data-id = "<?php echo e($item['id']); ?>">
                                           <?php echo e($item['shop_title']); ?>

                                        </td>
                                        <td class = "text-left" style = "width:32%;"  onclick = "detailView(this)" data-id = "<?php echo e($item['id']); ?>">
                                            <?php if($item['is_force_end'] == "0"): ?> <?php echo e(utf8_strcut($item['title'], 40)); ?> <?php else: ?> <?php echo e(__('lang.마감 하였습니다')); ?> <?php endif; ?>
                                        </td>
                                        <td style = "width:15%;" class = "text-center hidden-xs" onclick = "detailView(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e(substr($item['updated_at'],0,10)); ?></td>
                                        <td style = "width:8%;" class = "text-center hidden-xs" onclick = "detailView(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e($item['view_count']); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($list) == 0): ?>
                                    <tr>
                                        <td colspan ="8"><?php echo e(__('lang.자료가 없습니다.')); ?></td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class = "row">
                            <div class = "col-md-8 text-left col-xs-12">
                            </div>
                            <div class = "col-md-4 text-right mt-10 col-xs-12" style = "margin-top:17px;">
                                <?php if(Sentinel::check()): ?>
                                    <?php $user = Sentinel::getuser(); $complete_info = $user->shop_complete_info();?>

                                    <?php if($complete_info['diff']*1 != -1): ?>
                                    <?php if($self == 1): ?>
                                        <a class = "btn-danger write-a"  href = "javascript:void(0);" style = "color:white; border:none;" onclick = "forceCompleteSchedule()"><?php echo e(__('lang.마감하기')); ?></a>
                                    <?php endif; ?>
                                    <a class = "btn-danger write-a"  href = "<?php echo e(url("admin/schedule")); ?>" style = "color:white; border:none;">[ <?php echo e(__('lang.스케줄생성')); ?> ]</a>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class = "text-center" style = "margin-top:10px;">

                        </div>
                </div>
            </div>
            </div>
            <div class = "col-md-3 hidden-xs">
                <?php echo $__env->make('layouts/right-side', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    <!-- //Container End -->
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
    <script>
        $(function(){
           loading_stop();
        });

        function forceCompleteSchedule(){

            var shop_type = "<?php echo e($shop_type); ?>";
            var category_id = "<?php echo e($category_id); ?>";
            var param = new Object();
            param._token = _token;
            param.shop_type = shop_type;
            param.category_id = category_id;
            var url = "<?php echo e(url('/schedule_force_complete')); ?>";
            $.post(url,param, function(data){
                if(data.status == "1"){
                    successMsg("<?php echo e(__('lang.성공하였습니다')); ?>");
                    setTimeout(function(){
                        window.location.reload();
                    },2000);
                }else{
                    errorMsg(data.msg);
                }
            },"json");
        }

        function changeCategoryItem(obj){
            var category_id = $(obj).attr("data-id");
            loading_start();
            $("#searchForm input[name='category_id']").val(category_id);
            $("#searchForm input[name='page']").val("0");
            $("#searchForm").submit();

        }


        function  detailView(obj){
            var id = $(obj).attr("data-id");
            window.location.href = "<?php echo e(url("/schedule_info")); ?>/"+id;
        }
        function searchData(page) {
            $("#searchForm input[name='page']").val(page);
            $("#searchForm").submit();
        }


    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>