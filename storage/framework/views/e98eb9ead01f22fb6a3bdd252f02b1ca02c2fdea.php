<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
    <?php if($id*1 == 0): ?> <?php echo e(__('lang.매니저생성')); ?> <?php else: ?> <?php echo e(__('lang.매니저수정')); ?> <?php endif; ?>
    ##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_styles'); ?>
    <link href="<?php echo e(asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css')); ?>"  rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .logImg{
            width:100px;
            height:100px;
        }
    </style>
    <section class="content-header">
        <h1><?php if($id*1 == 0): ?> <?php echo e(__('lang.매니저생성')); ?> <?php else: ?> <?php echo e(__('lang.매니저수정')); ?> <?php endif; ?></h1>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            <?php echo e(__('lang.매니저정보')); ?>

                        </h3>
                        <span class="pull-right">
                            <i class="glyphicon glyphicon-chevron-up clickable"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <form  id = "infoForm" action = "<?php echo e(url("admin/manager/ajaxSaveInfo")); ?>" method = "post">
                            <input type = "hidden" name = "_token" value = "<?php echo e(csrf_token()); ?>"/>
                            <input type = "hidden" name = "id" value = "<?php echo e($id); ?>"/>
                            <div class="form-group">
                                <label class="control-label"><?php echo e(__('lang.업소')); ?></label>
                                <select class = "form-control" name = "shop_id">
                                    <?php $__currentLoopData = $shop_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value = "<?php echo e($shop['id']); ?>" <?php if($shop['id']*1 == $info['shop_id']*1): ?> selected <?php endif; ?>><?php echo e($shop['title']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo e(__('lang.예명')); ?></label>
                                <input  name="nickname" type="text" placeholder="<?php echo e(__('lang.예명을 입력해주세요')); ?>" class="form-control" value = "<?php echo e($info['nickname']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo e(__('lang.나이')); ?></label>
                                <input id="age" name="age" type="text" placeholder="<?php echo e(__('lang.나이를 입력해주세요')); ?>" class="form-control" value = "<?php echo e($info['age']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo e(__('lang.키')); ?></label>
                                <input id="height" name="height" type="text" placeholder="<?php echo e(__('lang.키를 입력해주세요')); ?>" class="form-control" value = "<?php echo e($info['height']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo e(__('lang.사이즈')); ?></label>
                                <input id="body_size" name="body_size" type="text" placeholder="<?php echo e(__('lang.바디 사이즈를 입력해주세요')); ?>" class="form-control" value = "<?php echo e($info['body_size']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo e(__('lang.가슴 사이즈')); ?></label>
                                <input id="name" name="cup_size" type="text" placeholder="<?php echo e(__('lang.가슴 사이즈를 입력해주세요')); ?>" class="form-control" value = "<?php echo e($info['cup_size']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo e(__('lang.흡연여부')); ?></label>
                                <input id="is_smoking" name="is_smoking" type="text" placeholder="<?php echo e(__('lang.흡연 여부를 입력해주세요')); ?>" class="form-control" value = "<?php echo e($info['is_smoking']); ?>">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="description"><?php echo e(__('lang.간단메모')); ?></label>
                                <textarea class="form-control resize_vertical" id="description" name="description" placeholder="" rows="5" style = "resize:none;"><?php echo $info['description']; ?></textarea>
                            </div>
                            <div class = "form-group">
                                <label class="" ><?php echo e(__('lang.사진')); ?></label>
                                <span class = "cursor <?php if($info['photo_url'] == ''): ?> hidden <?php endif; ?>" onclick = "delImage(this)">
                                    <i class = "fa fa-close cursor" ></i>
                                </span>
                                <div class = "row">
                                    <div class = "col-md-9" style = "padding-left:0px;">
                                        <img onerror = "noExitImg(this)" id = "photo_url_img" class = "logImg"  ratio = "1" onclick = "onClickFilgDlgNocrop('#photo_url');"  <?php if($info['photo_url'] != ''): ?> src = "<?php echo e(correctImgPath1($info['photo_url'])); ?>" <?php endif; ?>/>
                                        <input type = "hidden" id = "photo_url_val"  name = "photo_url_val" value = ""/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-position">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-responsive btn-success btn-sm" onclick = "goBack()"><?php echo e(__('lang.리스트로 이동')); ?></button>
                                    <button type="submit" class="btn btn-responsive btn-primary btn-sm"><?php echo e(__('lang.등록')); ?></button>
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
        $("select[name='shop_id']").select2();
        $('textarea#description').ckeditor({
            height: '200px'
        });

        $("#infoForm").validate({
            rules: {
                nickname: "required",
                age: "required",
                body_size: "required",
                height: "required",
                cup_size: "required",
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
                        if (data.status == '1') {
                            successMsg("<?php echo e(__('lang.수정이 성공하였습니다.')); ?>", function(){
                               var id = $("input[name='id']").val();
                               if(id ==0){
                                   window.location.href = "<?php echo e(url("admin/manager")); ?>";
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