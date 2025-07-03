<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
<?php echo e(__('lang.제휴문의')); ?>

##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
    <!--page level css starts-->
    <!--end of page level css-->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <div class="container mt-10">
        <div class = "row">
            <div class = "col-md-8 cols-xs-12">
                <div class="row">
                    <div class = "col-md-12">
                        <div class = "table-scrollable">
                            <table class = "table table-striped table-board">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th><?php echo e(__('lang.제목')); ?></th>
                                        <th><?php echo e(__('lang.날짜')); ?></th>
                                        <th><?php echo e(__('lang.상태')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td onclick = "detailView(this)" data-id ="<?php echo e($item['id']); ?>"><?php echo e($key+$pageParam['startNumber']+1); ?></td>
                                        <td onclick = "detailView(this)" data-id ="<?php echo e($item['id']); ?>"><?php echo e(utf8_strcut(strip_tags($item['title']),30)); ?></td>
                                        <td onclick = "detailView(this)" data-id ="<?php echo e($item['id']); ?>"><?php echo e(substr($item['created_at'],11,5)); ?></td>
                                        <td onclick = "detailView(this)" data-id ="<?php echo e($item['id']); ?>"><?php echo e(getQuestionStatusStr($item['status'])); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($list) == 0): ?>
                                    <tr>
                                        <td colspan = "5"><?php echo e(__('lang.자료가 없습니다.')); ?> </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class = "row">
                            <div class = "col-md-8 text-left col-xs-12">
                                <form id = "searchForm" action = "<?php echo e(url('question')); ?>" method = "post">
                                    <input type = "hidden" name ="_token" value ="<?php echo e(csrf_token()); ?>"/>
                                    <input type = "hidden" name = "page" value = "<?php echo e($pageParam['pageNo']); ?>"/>
                                    <div class = "row">
                                        <div class = "col-md-6 mt-10 mb-10" style = "margin-top:8px;">
                                            <select class = "form-control search-select radius-0" name = "search_type" style ="height:38px;">
                                                <option value ="title" <?php if($search_type == 'title'): ?> selected <?php endif; ?>><?php echo e(__('lang.제목')); ?></option>
                                                <option value ="title&content" <?php if($search_type == 'title&content'): ?> selected <?php endif; ?>><?php echo e(__('lang.제목')); ?>&<?php echo e(__('lang.내용')); ?></option>
                                                <option value ="reply" <?php if($search_type == 'reply'): ?> selected <?php endif; ?>><?php echo e(__('lang.댓글')); ?></option>
                                            </select>
                                        </div>
                                        <div class = "col-md-6 mt-10 mb-10" style = "display:table;margin-top:8px;">
                                            <input type = "text" class = "form-control search-input radius-0"  style ="height:38px;" name = "search_title" value ="<?php echo e($search_title); ?>" placeholder ="<?php echo e(__('lang.검색어를 입력해주세요')); ?>">
                                            <span class="input-group-btn">
                                        <button class="btn btn-default radius-0" type="button" onclick = "searchData(0)" style = "background: black;color: white; height:38px;">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class = "col-md-4 text-right mt-10 col-xs-12" style = "margin-top:17px;">
                                <?php if(Sentinel::check()): ?>
                                    <a class = "color-white write-a btn-danger border-none"  href = "<?php echo e(url("question/write/0")); ?>" style = "color:white;"><?php echo e(__('lang.글쓰기')); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class = "text-center relative" style = "margin-top:10px;">
                            <?php echo $__env->make("layouts/pagination", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>

                </div>
            </div>
            </div>
            <div class = "col-md-4 hidden-xs">
                <?php echo $__env->make('layouts/right-side', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
    <script>
        $(function(){
            var url = $("#searchForm").attr("action")+"?"+$("#searchFrm").serialize();
            setPageUrl(url);
        });
        function searchData(page) {
            $("#searchForm input[name='page']").val(page);
            $("#searchForm").submit();
        }
        function  detailView(obj){
            var id = $(obj).attr("data-id");
            window.location.href = "<?php echo e(url("/question_info")); ?>/"+id;
        }
        $(function(){

        });

        $("#reviewForm textarea[name='description']").ckeditor({
            height: '200px'
        });

        $("#reviewForm").validate({
            rules: {
                shop_id: "required",
                title: "required",
                description: "required",
            },

            messages: {

            },
            errorPlacement: function (error, element) {
                if($(element).closest('div').children().filter("div.error-div").length < 1)
                    $(element).closest('div').append("<div class='error-div'></div>");
                $(element).closest('div').children().filter("div.error-div").append(error);
            },
            submitHandler: function(form){
                var url = $(form).attr("action");
                var fdata = new FormData($("#reviewForm")[0]);
                fdata.append("description", $("#reviewForm textarea[name='description']").val());
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
                                window.location.reload();
                            });
                        } else {
                            errorMsg(data.msg);
                        }
                    },
                    error: function() {
                        errorMsg("<?php echo e(__('lang.서버에서 오류가 발생하였습니다.')); ?>");
                    }
                })

            }

        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>