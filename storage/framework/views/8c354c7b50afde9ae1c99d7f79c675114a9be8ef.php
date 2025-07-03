<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
    <?php echo e(__('lang.관리자 문의 게시판보기')); ?>

    ##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1><?php echo e(__('lang.관리자 문의 게시판보기')); ?></h1>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            <?php echo e(__('lang.관리자 문의 게시판보기')); ?>

                        </h3>
                        <span class="pull-right">
                            <i class="glyphicon glyphicon-chevron-up clickable"></i>
                        </span>
                    </div>
                    <div class="panel-body">

                        <input type = "hidden" name = "_token" value = "<?php echo e(csrf_token()); ?>"/>
                        <input type = "hidden" name = "id" value = "<?php echo e($id); ?>"/>
                        <div class="form-group">
                            <label class="control-label" for="name"><?php echo e(__('lang.타이틀')); ?>:</label>
                            <label class="control-label"><?php echo e($info['title']); ?></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description"><?php echo e(__('lang.내용')); ?></label>
                            <textarea class="form-control resize_vertical" id="content" readonly name="content" placeholder="" rows="5" style = "resize:none;"><?php echo $info['content']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description"><?php echo e(__('lang.답변')); ?></label>
                            <textarea class="form-control resize_vertical" id="answer" readonly name="answer" placeholder="" rows="5" style = "resize:none;"><?php echo $info['answer']; ?></textarea>
                        </div>
                        <div class = "form-group">
                            <label class="control-label" for="name"><?php echo e(__('lang.작성날짜')); ?>:</label>
                            <label class="control-label"><?php echo e($info['created_at']); ?></label>
                        </div>
                        <div class = "form-group">
                            <h3 class="comments"><?php echo e($info['reply_count']); ?> <?php echo e(__('lang.댓글보기')); ?></h3><br />
                            <ul class="media-list">
                                <?php $__currentLoopData = $reply_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="media">
                                        <div class="media-body">
                                            <h4 class="media-heading"> <?php echo e(__('lang.댓글 작성자')); ?>: <i><?php echo e($reply['user']['nickname']); ?></i> <span class = "ml-5"><?php echo e(substr($reply['created_at'],0,10)); ?></span>
                                                <a href = "javascript:void(0)" class = "ml-10" style = "font-size:14px;" onclick = "showReplyReplyForm(this)" data-id = "0"> <?php echo e(__('lang.답글작성')); ?></a>
                                                <?php if($user['id']*1 == $reply['user_id']*1): ?>
                                                    <a href = "javascript:void(0)" class = "ml-10" style = "font-size:14px;" onclick = "showReplyForm(this)"> <?php echo e(__('lang.댓글변경')); ?></a>
                                                    <a href = "javascript:void(0)" class = "ml-10" style = "font-size:14px;" onclick = "deleteReply(this)" data-id = "<?php echo e($reply['id']); ?>"> <?php echo e(__('lang.댓글삭제')); ?></a>
                                                <?php endif; ?>
                                            </h4>
                                            <form class = "reply_form hidden" method = "method" action="<?php echo e(url("admin/shop_question/ajaxSaveReply")); ?>" accept-charset="UTF-8" class="bf" enctype="multipart/form-data">
                                                <input type = "hidden" name = "id" value = "<?php echo e($reply['id']); ?>"/>
                                                <div class="form-group">
                                                    <textarea class="form-control input-lg no-resize" required="required" style="height: 200px" placeholder="<?php echo e(__('lang.댓글내용을 입력해주세요.')); ?>" name="description" cols="50" rows="10"><?php echo e($reply['description']); ?></textarea>
                                                </div>
                                                <div class="form-group ">
                                                    <button type="button" class="btn btn-success btn-md" onclick = "submitReplyUpdateForm(this)">
                                                        <i class="livicon" data-name="comment" data-c="#FFFFFF" data-hc="#FFFFFF" data-size="18" data-loop="true"></i>
                                                        <?php echo e(__('lang.변경')); ?>

                                                    </button>
                                                </div>
                                            </form>
                                            <p><?php echo $reply['description']; ?></p>
                                            <p class="">
                                                <small class = "mr-5"> <?php echo e(substr($reply['created_at'],0,10)); ?> </small>
                                                <i class = "fa fa-comment "></i><span class="ml-5"><?php echo e(count($reply['reply'])); ?></span>
                                            </p>
                                            <?php $__currentLoopData = $reply['reply']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply_reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class = "comment-rect">
                                                    <h4 class="media-heading">
                                                        <i><?php echo e(__('lang.답글')); ?> : <?php echo e($reply_reply['user']['nickname']); ?></i> <small class = "ml-10 text-white"> <?php echo e(substr($reply_reply['created_at'],0,10)); ?> </small>
                                                        <?php if($user['id']*1 == $reply_reply['user_id']*1): ?>
                                                        <a href = "javascript:void(0)" class = "ml-10" style = "font-size:14px;" onclick = "showReplyReplyForm(this)" data-id = "<?php echo e($reply_reply['id']); ?>"><?php echo e(__('lang.답글변경')); ?></a>
                                                        <a href = "javascript:void(0)" class = "ml-10" style = "font-size:14px;" onclick = "deleteReply(this)" data-id = "<?php echo e($reply_reply['id']); ?>"><?php echo e(__('lang.답글삭제')); ?></a>
                                                        <?php endif; ?>
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
                        <!-- Form actions -->
                        <div class="form-position">
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-responsive btn-success btn-sm" onclick = "goBack()"><?php echo e(__('lang.리스트로 이동')); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer_scripts'); ?>
<script>
    function deleteReply(obj){
        confirmMsg("<?php echo e(__('lang.정말 삭제하겟습니까?')); ?>", function(){
           var id = $(obj).attr("data-id");
           var param = new Object();
           param._token = _token;
           param.id = id;
           var url = "<?php echo e(url("admin/shop_question/deleteReply")); ?>";
           loading_start();
           $.post(url, param, function(data){
               if(data.status == "1"){
                   successMsg("<?php echo e(__('lang.수정이 성공하였습니다.')); ?>", function(){
                       window.location.reload();
                   });
               }else{
                   loading_stop();
                   errorMsg(data.msg);
               }
           }, "json");
        });
    }

    function submitReplyUpdateForm(obj){
        var description = $(obj).closest("form").find("textarea[name='description']").val();
        if(description == ""){
            errorMsg("<?php echo e(__('lang.댓글을 입력해주십시오.')); ?>");
            return;
        }
        var url = $(obj).closest("form").attr("action");
        var fdata = new FormData($(obj).closest("form")[0]);
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
    function showReplyForm(obj){
        $(".reply_form").addClass("hidden");
        $(obj).parent().parent().find("form").removeClass("hidden");
        $(obj).parent().parent().find("form").next().addClass("hidden");
    }
    function showReplyReplyForm(obj){
        var id = $(obj).attr("data-id");
        var parent = $(obj).parent().parent().parent();
        if(id != "0"){
            parent = $(obj).parent().parent().parent().parent();
        }
        $(".reply_reply_form-rect").addClass("hidden");
        parent.find(".reply_reply_form-rect").removeClass("hidden");
        parent.find(".reply_reply_form-rect form input[name='id']").val(id);
        if(id == "0"){
            parent.find(".reply_reply_form-rect form textarea[name='description']").val("");

        }else{
            var description = $(obj).parent().parent().find("p").html();
            parent.find(".reply_reply_form-rect form textarea[name='description']").val(description.trim());

        }

    }

    function submitReplyForm(obj){
        var description = $(obj).closest("form").find("textarea[name='description']").val();
        if(description == ""){
            errorMsg("<?php echo e(__('lang.답글을 입력해주십시오.')); ?>");
            return;
        }
        var url = $(obj).closest("form").attr("action");
        var fdata = new FormData($(obj).closest("form")[0]);
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

    $(function() {
        $("select[name='shop_id']").select2();
        $('textarea#content').ckeditor({
            height: '200px'
        });
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
                fdata.append("description", $("#replyForm textarea[name='description']").val());
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
                title: "required",
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
                $("textarea[name='description']").val(CKEDITOR.instances.description.getData());
                var fdata = new FormData($("#infoForm")[0]);
                fdata.append("description", $("textarea[name='description']").val());
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
                               var id = $("input[name='id']").val();
                               if(id == "0"){
                                   window.location.href = "<?php echo e(url('admin/review')); ?>";
                               }else{
                                   goBack();
                               }

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
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>