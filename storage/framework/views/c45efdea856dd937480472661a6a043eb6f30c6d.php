<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
    <?php if($id*1 == 0): ?> <?php echo e(__('lang.공지등록')); ?> <?php else: ?> <?php echo e(__('lang.공지수정')); ?> <?php endif; ?>
    ##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_styles'); ?>
    <link href="<?php echo e(asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css')); ?>"  rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1><?php if($id*1 == 0): ?><?php echo e(__('lang.공지등록')); ?> <?php else: ?> <?php echo e(__('lang.공지수정')); ?> <?php endif; ?></h1>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            <?php echo e(__('lang.공지정보')); ?>

                        </h3>
                        <span class="pull-right">
                            <i class="glyphicon glyphicon-chevron-up clickable"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <form  id = "infoForm" action = "<?php echo e(url("admin/notice/ajaxSaveInfo")); ?>" method = "post">
                            <input type = "hidden" name = "_token" value = "<?php echo e(csrf_token()); ?>"/>
                            <input type = "hidden" name = "id" value = "<?php echo e($id); ?>"/>
                            <input type = "hidden" name = "is_always_display" value = "0"/>
                            <div class="form-group">
                                <label class="control-label"><?php echo e(__('lang.공지타이틀')); ?></label>
                                <input  name="title" type="text" placeholder="<?php echo e(__('lang.예명을 입력해주세요')); ?>" <?php if($user['type']*1 == 70): ?> readonly <?php endif; ?> class="form-control" value = "<?php echo e($info['title']); ?>">
                            </div>
                            <div class = "form-group <?php if($user['type']*1 == 70): ?> hidden <?php endif; ?>">
                                <label><?php echo e(__('lang.공지타입')); ?></label>
                                <select class = "form-control" name = "type">
                                    <option value="1"  ><?php echo e(__('lang.이용안내')); ?></option>
                                    <option value="2" <?php if($info['type']*1 == 2): ?> selected <?php endif; ?>><?php echo e(__('lang.제휴')); ?></option>
                                    <option value="3" <?php if($info['type']*1 == 3): ?> selected <?php endif; ?>><?php echo e(__('lang.결제')); ?></option>
                                    <option value="4" <?php if($info['type']*1 == 4): ?> selected <?php endif; ?>><?php echo e(__('lang.이벤트')); ?></option>
                                    <option value="5" <?php if($info['type']*1 == 5): ?> selected <?php endif; ?>><?php echo e(__('lang.기타')); ?></option>
                                    <option value="6" <?php if($info['type']*1 == 6): ?> selected <?php endif; ?>><?php echo e(__('lang.관리자공지')); ?></option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="description"><?php echo e(__('lang.공지내용')); ?></label>
                                <textarea class="form-control resize_vertical" id="description" <?php if($user['type']*1 == 70): ?> readonly <?php endif; ?> name="description" placeholder="" rows="5" style = "resize:none;"><?php echo $info['description']; ?></textarea>
                            </div>

                            <div class = "form-group <?php if($user['type']*1 == 70): ?> hidden <?php endif; ?> ">
                                <label><?php echo e(__('lang.상시노출')); ?></label>
                                <input type = "checkbox" class = "custom-checkbox" id  = "is_always_display" <?php if($info['is_always_display']*1 == 1): ?> checked <?php endif; ?> >
                            </div>
                            <div class="form-group <?php if($user['type']*1 == 70): ?> hidden <?php endif; ?>">
                                <label class="control-label"><?php echo e(__('lang.노출기간')); ?></label>
                            </div>
                            <div class="form-group input-group <?php if($user['type']*1 == 70): ?> hidden <?php endif; ?>">
                                <input type="text" class="form-control date-picker" name = "display_start_at" value = "<?php echo e($info['display_start_at']); ?>"  placeholder="YYYY-MM-DD">
                                <span class="input-group-btn">
                                    <button class="btn btn-default " type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                            <div class="form-group input-group <?php if($user['type']*1 == 70): ?> hidden <?php endif; ?>">
                                <input type="text" class="form-control date-picker" name = "display_end_at" value = "<?php echo e($info['display_end_at']); ?>"  placeholder="YYYY-MM-DD">
                                <span class="input-group-btn">
                                    <button class="btn btn-default " type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>


                            <div class="form-position">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-responsive btn-success btn-sm" onclick = "goBack()"><?php echo e(__('lang.리스트로 이동')); ?></button>
                                    <?php if($user['type']*1 == 99): ?>
                                    <button type="submit" class="btn btn-responsive btn-primary btn-sm"><?php echo e(__('lang.등록')); ?></button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- content -->
    <?php echo $__env->make("dlg/crop_dlg", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
    <script src="<?php echo e(asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js')); ?>" ></script>
<script>
    $(function(){
       loading_stop();
    });
    function delImage(obj){
        $("#photo_url_img").attr("src", "");
        $("#photo_url_val").val("");
        $(obj).addClass("hidden");

    }

    $(function() {

        $(".date-picker").datepicker({
            format: "yyyy-mm-dd",
        });
        $('input[type="checkbox"].custom-checkbox, input[type="radio"].custom-radio').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue',
            increaseArea: '20%'
        });

        $('textarea#description').ckeditor({
            height: '400px'
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
                var fdata = new FormData($("#infoForm")[0]);
                fdata.append("description", $("textarea[name='description']").val());
                fdata.append("is_always_display", is_always_display);
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
                               if(id ==0){
                                   window.location.href = "<?php echo e(url("admin/customer")); ?>";
                               }
                               goBack();
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
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>