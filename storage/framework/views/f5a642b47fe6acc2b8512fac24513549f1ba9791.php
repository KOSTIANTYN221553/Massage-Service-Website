<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
    <?php if($id*1 == 0): ?> <?php echo e(__('lang.업소생성')); ?> <?php else: ?> <?php echo e(__('lang.업소수정')); ?> <?php endif; ?>
    ##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_styles'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1><?php if($id*1 == 0): ?> <?php echo e(__('lang.업소생성')); ?> <?php else: ?> <?php echo e(__('lang.업소수정')); ?> <?php endif; ?></h1>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            <?php echo e(__('lang.업소정보')); ?>

                        </h3>
                        <span class="pull-right">
                            <i class="glyphicon glyphicon-chevron-up clickable"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <form  id = "infoForm" action = "<?php echo e(url("admin/shops/ajaxSaveInfo")); ?>" method = "post">
                            <input type = "hidden" name = "_token" value = "<?php echo e(csrf_token()); ?>"/>
                            <input type = "hidden" name = "id" value = "<?php echo e($id); ?>"/>
                            <div class = "form-group">
                                <label class="" ><?php echo e(__('lang.이미지')); ?></label>
                                <span class = "cursor <?php if($info['img'] == ''): ?> hidden <?php endif; ?>" onclick = "delImage(this)">
                                    <i class = "fa fa-close cursor" ></i>
                                </span>
                                <div class = "row">
                                    <div class = "col-md-9" style = "padding-left:0px;">
                                        <img onerror = "noExitImg(this)" id = "img_img" class = "logImg"  ratio = "0.67" onclick = "onClickFilgDlgNocrop('#img');" style = "width:100px; height:100px;" <?php if($info['img'] != ''): ?> src = "<?php echo e(correctImgPath1($info['img'])); ?>" <?php endif; ?>/>
                                        <input type = "hidden" id = "img_val"  name = "img_val" value = ""/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name"><?php echo e(__('lang.이름')); ?></label>
                                <input id="name" name="title" type="text" placeholder="<?php echo e(__('lang.이름을 입력해주세요')); ?>" class="form-control" value = "<?php echo e($info['title']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name"><?php echo e(__('lang.소유유저')); ?></label>
                                <button type = "button"  class = "btn btn-primary btn-sm" onclick = "detail_dlg()"><?php echo e(__('lang.검색')); ?></button>
                            </div>
                            <div class="form-group">
                                <input type = "hidden" name = "user_id" value = "<?php echo e($info['user_id']); ?>"/>
                                <input type = "text" id = "user_name" readonly name = "user_name" value = "<?php echo e(isset($info['user']['nickname']) ? $info['user']['nickname'] :""); ?>" class ="form-control"/>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="type"><?php echo e(__('lang.업소종류')); ?></label>
                                <select name = "type" id = "type" class = "form-control">
                                    <option value = ""></option>
                                    <?php $__currentLoopData = $shop_type_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value = "<?php echo e($type_item['id']); ?>" <?php if($info['type']*1 == $type_item['id']*1): ?> selected <?php endif; ?>><?php echo e($type_item['title']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="location"><?php echo e(__('lang.위치')); ?></label>
                                <input id="location" name="location" type="text" placeholder="<?php echo e(__('lang.위치를 입력해주세요')); ?>" class="form-control" value = "<?php echo e($info['location']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="phone"><?php echo e(__('lang.전화번호')); ?></label>
                                <input id="phone" name="phone" type="text" placeholder="<?php echo e(__('lang.전화번호를 입력해주세요')); ?>" class="form-control" value = "<?php echo e($info['phone']); ?>">
                            </div>
                            <div class="form-group hidden">
                                <label class="control-label" for="time"><?php echo e(__('lang.영업시간')); ?></label>
                                <input id="time" name="time" type="text"   placeholder="<?php echo e(__('lang.영업시간을 입력해주세요')); ?>" class="form-control" value = "<?php echo e($info['time']); ?>">
                            </div>

                            <div class="form-group hidden">
                                <label class="control-label" for="price"><?php echo e(__('lang.요금정보')); ?></label>
                                <textarea class="form-control resize_vertical" id="price" name="price" placeholder="" rows="5" style = "resize:none;"><?php echo $info['price']; ?></textarea>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="description"><?php echo e(__('lang.설명')); ?></label>
                                <textarea class="form-control resize_vertical" id="description" name="description" placeholder="" rows="5" style = "resize:none;"><?php echo $info['description']; ?></textarea>
                            </div>
                            <!-- Form actions -->
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
        <?php echo $__env->make('admin/shop/shop_user_dlg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </section>
    <!-- content -->
    <?php echo $__env->make("dlg/crop_dlg", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer_scripts'); ?>


<script>
    function setShopUser(){
        var user_id = $("#shop-users-dialog input[name='check_shop_user']:checked").val();
        var user_name = $("#shop-users-dialog input[name='check_shop_user']:checked").attr("data-name");
        $("#infoForm input[name='user_id']").val(user_id);
        $("#infoForm #user_name").val(user_name);
        $("#shop-users-dialog").modal("hide");
    }
    function detail_dlg(){

        $("#shop-users-dialog").modal("show");


    }

    function delImage(obj){
        $("#img").attr("src", "");
        $("#img_val").val("");
        $(obj).addClass("hidden");
    }

    jQuery(document).ready(
        function(){
            // calendar
            $("#time").mobiscroll().time({
                timeFormat:"HH:ii",
                lang: 'ko',
            });

        }
    )

    $(function() {
        $('#price').ckeditor({
            height: '200px'
        });
        $('#description').ckeditor({
            height: '200px'
        });
        $("select[name='user_id']").select2();

        loading_stop();
        $("#infoForm").validate({
            rules: {
                title: "required",
                type: "required",
                phone: "required",
                user_name: "required",
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
                $("textarea[name='price']").val(CKEDITOR.instances.price.getData());
                $("textarea[name='description']").val(CKEDITOR.instances.description.getData());
                var fdata = new FormData($("#infoForm")[0]);
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
                               goBack();
                            });
                        } else {
                            loading_stop();
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


    $(function(){
        $('#shop-users-dialog #table1').DataTable();
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>