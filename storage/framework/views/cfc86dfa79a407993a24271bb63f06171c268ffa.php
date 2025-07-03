<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
<?php echo e(__('lang.공지사항')); ?>

##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>

<?php $__env->startSection('header_styles'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

    <div class="container mt-10">
        <?php if(isset($page_title)): ?>
            <div class = "row">
                <div class = "col-md-12 col-xs-12 page-title-wrapper">
                    <span class = ""> <?php echo e($page_title); ?></span>
                </div>
            </div>
        <?php endif; ?>
        <?php if(isset($notice_list)): ?>
            <?php $__currentLoopData = $notice_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href = "javascript:void(0)" data-id = "<?php echo e($item['id']); ?>" onclick = "detailView1(this)">
                    <div class = "row page-title-wrapper">
                        <div class = "col-md-10 margin-box border-right">
                            <span class ="badge-warning"><?php echo e(__('lang.공지')); ?></span>
                            <span><?php echo e(utf8_strcut(strip_tags($item['title']),150)); ?></span>
                        </div>
                        <div class = "col-md-2 text-right"><span class = "pr-10 border-right"><?php echo e($item['user']['nickname']); ?></span> <span class = "pl-10"><?php echo e(getMsgTimeStr($item['created_at'])); ?></span></div>
                    </div>
                    <div class = "row page-title-wrapper content-wrapper hidden">
                        <?php echo $item['description']; ?>

                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <div class = "row">
            <div class = "col-md-9 cols-xs-12">
                <form id = "searchForm" action = "<?php echo e(url("notice")); ?>"  method = "get">
                    <input type = "hidden" name = "_token" value = "<?php echo e(csrf_token()); ?>"/>
                    <input type = "hidden" name = "page" value = "<?php echo e($pageParam['pageNo']); ?>"/>
                </form>
                <div class="row">
                    <div class = "col-md-12">
                        <div class = "table-scrollable">
                            <table class = "table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th><?php echo e(__('lang.분류')); ?></th>
                                        <th><?php echo e(__('lang.제목')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr >
                                        <td class = "cursor" onclick = "detailView(this)" data-id ="<?php echo e($item['id']); ?>"><?php echo e($key+$pageParam['startNumber']+1); ?></td>
                                        <td class = "cursor" onclick = "detailView(this)" data-id ="<?php echo e($item['id']); ?>"><?php echo e(getNoticeTypeStr($item['type'])); ?></td>
                                        <td class = "cursor" onclick = "detailView(this)" data-id ="<?php echo e($item['id']); ?>"><?php echo e(utf8_strcut(strip_tags($item['title']),30)); ?></td>
                                    </tr>
                                    <tr class = "content-tr hidden">
                                        <td colspan = "3">
                                            <?php echo $item['description']; ?>

                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($list) == 0): ?>
                                    <tr>
                                        <td colspan = "3"><?php echo e(__('lang.검색결과가 없습니다')); ?></td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class = "text-center" style = "margin-top:10px;">
                            <?php echo $__env->make("layouts/pagination", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "col-md-3 hidden-xs">
                <?php echo $__env->make('layouts/right-side', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
    <script>
        function searchData(page) {
            $("#searchForm input[name='page']").val(page);
            $("#searchForm").submit();
        }
        function  detailView(obj){

            //$(".content-tr").addClass("hidden");
            var tr = $(obj).parent().next();
            if(tr.hasClass("hidden")){
                tr.removeClass("hidden");
            }else{
                tr.addClass("hidden");
            }
        }

        function detailView1(obj){
           var id = $(obj).attr("data-id");
           var url = "<?php echo e(url('/notice_info/')); ?>/"+id;
           window.location.href = url;
        }

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>