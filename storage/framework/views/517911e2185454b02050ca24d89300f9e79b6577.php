<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
    <?php echo e(__('lang.관리자 문의 게시판')); ?>

    ##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1><?php echo e(__('lang.관리자 문의 게시판')); ?></h1>
    </section>
    <!--section ends-->
    <?php $user = Sentinel::getuser();?>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            <?php echo e(__('lang.게시판정보')); ?>

                        </h3>
                        <span class="pull-right">
                            <i class="glyphicon glyphicon-chevron-up clickable"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <form  id = "infoForm" action = "<?php echo e(url("admin/shop_question/ajaxSaveInfo")); ?>" method = "post">
                            <input type = "hidden" name = "_token" value = "<?php echo e(csrf_token()); ?>"/>
                            <input type = "hidden" name = "id" value = "<?php echo e($id); ?>"/>
                            <div class="form-group">
                                <label class="control-label" for="name"><?php echo e(__('lang.타이틀')); ?></label>
                                <?php if($user['type']*1 == 99): ?>
                                <label ><?php echo e($info['title']); ?></label>
                                <?php else: ?>
                                <input type = "text" class = "form-control" name = "title" value = "<?php echo e($info['title']); ?>"/>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="description"><?php echo e(__('lang.게시판 내용')); ?></label>
                                <textarea class="form-control resize_vertical" <?php if($user['type']*1 == 99): ?> readonly <?php endif; ?>  id="content" name="content" placeholder="" rows="5" style = "resize:none;"><?php echo strip_tags($info['content']); ?></textarea>
                            </div>

                            <div class="form-group <?php if($info['answer'] == '' && $user['type']*1 == 70): ?> hidden <?php endif; ?>">
                                <label class="control-label"><?php echo e(__('lang.답변')); ?></label>
                                <textarea class="form-control resize_vertical" <?php if($user['type']*1 == 70): ?> readonly <?php endif; ?>   id="answer" name="answer" placeholder="" rows="5" style = "resize:none;"><?php echo $info['answer']; ?></textarea>
                            </div>
                            <!-- Form actions -->
                            <div class="form-position">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-responsive btn-success btn-sm" onclick = "goBack()"><?php echo e(__('lang.리스트로 이동')); ?></button>
                                    <button type="submit" class="btn btn-responsive btn-primary btn-sm"><?php echo e(__('lang.등록')); ?></button>
                                </div>
                            </div>
                        </form>
                        <div class = "form-group" style = "padding-top:30px;">
                            <h3 class="comments"><?php echo e($info['reply_count']); ?> <?php echo e(__('lang.댓글보기')); ?></h3><br />
                            <ul class="media-list">
                                <?php $__currentLoopData = $reply_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="media">
                                        <div class="media-body">
                                            <p><?php echo $reply['description']; ?></p>
                                            <p class="">
                                                <small class = "mr-5"> <?php echo e(substr($reply['created_at'],0,10)); ?> </small>
                                            </p>
                                            <?php $__currentLoopData = $reply['reply']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply_reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class = "comment-rect">
                                                    <h4 class="media-heading">
                                                        <i><?php echo e(__('lang.답글')); ?> : <?php echo e($reply_reply['user']['nickname']); ?></i> <small class = "ml-10 text-white"> <?php echo e(substr($reply_reply['created_at'],0,10)); ?> </small>
                                                    </h4>
                                                    <p>
                                                        <?php echo $reply_reply['description']; ?>

                                                    </p>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <div class = "reply_reply_form-rect hidden">
                                            <form class = "reply_reply_form" method = "post" action = "<?php echo e(url('admin/shop_question/ajaxSaveReply')); ?>" accept-charset="UTF-8" class="bf" enctype="multipart/form-data">
                                                <input type = "hidden" name = "board_id" value = "<?php echo e($info['id']); ?>"/>
                                                <input type = "hidden" name = "parent_reply_id" value = "<?php echo e($reply['id']); ?>"/>
                                                <input type = "hidden" name = "id" value = "0"/>
                                                <div class="form-group <?php echo e($errors->has('description') ? 'has-error' : ''); ?>">
                                                    <textarea class="form-control input-lg no-resize" required="required" style="height: 200px" placeholder="<?php echo e(__('lang.답글내용을 입력해주세요.')); ?>" name="description" cols="50" rows="10"></textarea>
                                                    <span class="help-block"><?php echo e($errors->first('description', ':message')); ?></span>
                                                </div>
                                                <div class="form-group ">
                                                    <button type="button" class="btn btn-success btn-md" onclick = "submitReplyForm(this)">
                                                        <i class="livicon" data-name="comment" data-c="#FFFFFF" data-hc="#FFFFFF" data-size="18" data-loop="true"></i>
                                                        <?php echo e(__('lang.등록')); ?>

                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <div class = "comment-write-rect">
                            <h3><?php echo e(__('lang.댓글쓰기')); ?></h3>
                            <form method="POST" id = "replyForm" action="<?php echo e(url("admin/shop_question/ajaxSaveReply")); ?>" accept-charset="UTF-8" class="bf" enctype="multipart/form-data">
                                <input type = "hidden" name = "board_id" value = "<?php echo e($info['id']); ?>"/>
                                <input type = "hidden" name = "parent_reply_id" value = "0"/>
                                <input type = "hidden" name = "_token" value = "<?php echo e(csrf_token()); ?>"/>
                                <div class="form-group <?php echo e($errors->has('description') ? 'has-error' : ''); ?>">
                                    <textarea class="form-control input-lg no-resize" required="required" style="height: 200px" placeholder="<?php echo e(__('lang.댓글내용을 입력해주세요.')); ?>" name="description" cols="50" rows="10"></textarea>
                                    <span class="help-block"><?php echo e($errors->first('description', ':message')); ?></span>
                                </div>
                                <div class="form-group ">
                                    <button type="submit" class="btn btn-success btn-md">
                                        <i class="livicon" data-name="comment" data-c="#FFFFFF" data-hc="#FFFFFF" data-size="18" data-loop="true"></i>
                                        <?php echo e(__('lang.등록')); ?>

                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer_scripts'); ?>
<script>
    $(function() {
        $('textarea#answer').ckeditor({
            height: '200px'
        });
        loading_stop();

        $("#replyForm").validate({
            rules: {
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
                var fdata = new FormData($("#replyForm")[0]);
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
                        if (data.status == '1') {
                            successMsg("<?php echo e(__('lang.수정이 성공하였습니다.')); ?>", function(){
                                window.location.reload();
                            });
                        } else {
                            loading_stop();
                            errorMsg(data.msg);
                        }
                    },
                    error: function() {
                        loading_stop();
                        errorMsg("<?php echo e(__('lang.서버에서 오류가 발생하였습니다.')); ?>");
                    }
                })

            }
        });


        $("#infoForm").validate({
            rules: {
                answer: "required",
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
                $("textarea[name='answer']").val(CKEDITOR.instances.answer.getData());
                var fdata = new FormData($("#infoForm")[0]);
                fdata.append("answer", $("textarea[name='answer']").val());
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
                        if (data.status == '1') {
                            successMsg("<?php echo e(__('lang.수정이 성공하였습니다.')); ?>", function(){
                               var id = $("input[name='id']").val();
                               if(id == "0"){
                                   goBack();
                               }else{
                                   goBack();
                               }

                            });
                        } else {
                            loading_start();
                            errorMsg(data.msg);
                        }
                    },
                    error: function() {
                        loading_start();
                        errorMsg("<?php echo e(__('lang.서버에서 오류가 발생하였습니다.')); ?>");
                    }
                })

            }
        });
    });


</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>