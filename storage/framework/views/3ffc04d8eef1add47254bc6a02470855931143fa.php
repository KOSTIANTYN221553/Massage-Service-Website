<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
    <?php if($id*1 == 0): ?> <?php echo e(__('lang.고객추가')); ?> <?php else: ?> <?php echo e(__('lang.고객수정')); ?> <?php endif; ?>
    ##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_styles'); ?>
    <link href="<?php echo e(asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css')); ?>"  rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1><?php if($id*1 == 0): ?> <?php echo e(__('lang.고객추가')); ?> <?php else: ?> <?php echo e(__('lang.고객수정')); ?> <?php endif; ?></h1>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            <?php echo e(__('lang.고객정보')); ?>

                        </h3>
                        <span class="pull-right">
                            <i class="glyphicon glyphicon-chevron-up clickable"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <form  id = "infoForm" action = "<?php echo e(url("admin/user/ajaxSaveInfo")); ?>" method = "post">
                            <input type = "hidden" name = "_token" value = "<?php echo e(csrf_token()); ?>"/>
                            <input type = "hidden" name = "id" value = "<?php echo e($id); ?>"/>
                            <input type = "hidden" name = "user_point" value = "<?php echo e($info['user_point']); ?>"/>
                            <div class="form-group">
                                <label class="control-label"><?php echo e(__('lang.아이디')); ?></label>
                                <input  name="email" type="text" placeholder="<?php echo e(__('lang.아이디를 입력해주세요')); ?>" class="form-control" value = "<?php echo e($info['email']); ?>">
                            </div>
                            <div class = "form-group">
                                <label class="" ><?php echo e(__('lang.사진')); ?></label>
                                <span class = "cursor <?php if($info['photo_url'] == ''): ?> hidden <?php endif; ?>" onclick = "delImage(this)">
                                    <i class = "fa fa-close cursor" ></i>
                                </span>
                                <div class = "row">
                                    <div class = "col-md-9" style = "padding-left:0px;">
                                        <img onerror = "noExitImg(this)" id = "photo_url_img" class = "logImg"  ratio = "1" onclick = "onClickFilgDlgNocrop('#photo_url');" style = "width:100px; height:100px;" <?php if($info['photo_url'] != ''): ?> src = "<?php echo e(correctImgPath1($info['photo_url'])); ?>" <?php endif; ?>/>
                                        <input type = "hidden" id = "photo_url_val"  name = "photo_url_val" value = ""/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo e(__('lang.닉네임')); ?></label>
                                <input  name="nickname" type="text" placeholder="<?php echo e(__('lang.닉네임을 입력해주세요')); ?>." class="form-control" value = "<?php echo e($info['nickname']); ?>">
                            </div>
                            <div class="form-group">
                                <label class="control-label"><?php echo e(__('lang.전화번호')); ?></label>
                                <input  name="phone" type="text" placeholder="<?php echo e(__('lang.전화번호를 입력해주세요')); ?>" class="form-control" value = "<?php echo e($info['phone']); ?>">
                            </div>
                            <div class="form-group">
                                <label class = "control-label"><?php echo e(__('lang.성별')); ?></label><br>
                                <label>
                                    <input type="radio" name="gender" class="minimal-blue" value = "1" <?php if($id == 0 || $info['gender']*1 == 1): ?> checked <?php endif; ?>/>
                                    <?php echo e(__('lang.남성')); ?>

                                </label>
                                <label style = "margin-left:20px;">
                                    <input type="radio" name="gender" class="minimal-blue" value =  "2" <?php if($info['gender']*1 == 2): ?> checked <?php endif; ?>/>
                                    <?php echo e(__('lang.여성')); ?>

                                </label>
                            </div>
                            <div class="form-group">
                                <label for="select23" class="control-label">
                                    <?php echo e(__('lang.레벨')); ?>

                                </label>
                                <select id="user_level" name = "level_id" class="form-control select2" >
                                    <option value="0" data-icon = "assets/images/default_no_image.jpg"><?php echo e(__('lang.레벨을 선택하세요')); ?></option>
                                    <?php $__currentLoopData = $user_level_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($level['id']); ?>" data-icon = "<?php echo e($level['icon']); ?>" <?php if($info['level_id']*1 == $level['id']*1): ?> selected <?php endif; ?>><?php echo e($level['title']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class = "control-label"><?php echo e(__('lang.타입')); ?></label><br>
                                <label>
                                    <input type="radio" name="type" class="minimal-blue" value = "1" <?php if($id == 0 || $info['type']*1 == 1): ?> checked <?php endif; ?>/>
                                    <?php echo e(__('lang.일반고객')); ?>

                                </label>
                                <label style = "margin-left:20px;">
                                    <input type="radio" name="type" class="minimal-blue" value =  "70" <?php if($info['type']*1 == 70): ?> checked <?php endif; ?>/>
                                    <?php echo e(__('lang.업주')); ?>

                                </label>
                                <label style = "margin-left:20px;">
                                    <input type="radio" name="type" class="minimal-blue" value =  "99" <?php if($info['type']*1 == 99): ?> checked <?php endif; ?>/>
                                    <?php echo e(__('lang.관리자')); ?>

                                </label>
                            </div>
                            <div class="form-group">
                                <label class = "control-label"><?php echo e(__('lang.보유포인트')); ?> :</label>
                                <label class = "control-label" id = "user_point_str"><?php echo e($info['user_point']); ?></label>
                                <button type = "button" class = "btn btn-sm btn-success ml-20" onclick = "showSetUserPointDlg()"><?php echo e(__('lang.수정')); ?></button>
                            </div>
                            <div class="form-group">
                                <label class = "control-label"><?php echo e(__('lang.상태')); ?></label><br>
                                <label>
                                    <input type="radio" name="status" class="minimal-blue" value = "1" <?php if($id == 0 || $info['status']*1 == 1): ?> checked <?php endif; ?>/>
                                    <?php echo e(__('lang.활성')); ?>

                                </label>
                                <label style = "margin-left:20px;">
                                    <input type="radio" name="status" class="minimal-blue" value =  "91" <?php if($info['status']*1 == 91): ?> checked <?php endif; ?>/>
                                    <?php echo e(__('lang.탈퇴')); ?>

                                </label>
                                <label style = "margin-left:20px;">
                                    <input type="radio" name="status" class="minimal-blue" value =  "99" <?php if($info['status']*1 == 99): ?> checked <?php endif; ?>/>
                                    <?php echo e(__('lang.강퇴')); ?>

                                </label>
                            </div>
                            <div class = "form-group">
                                <label>
                                    <input type="checkbox" id="password_update" class="minimal-blue" value = "1" <?php if($id == 0): ?> checked <?php endif; ?>/>
                                    <?php echo e(__('lang.암호변경')); ?>

                                </label>
                            </div>
                            <div class = "form-group password-rect">
                                <label class="control-label"><?php echo e(__('lang.암호')); ?></label>
                                <input  name="password" type="password" placeholder="<?php echo e(__('lang.비밀번호를 입력해주세요')); ?>" class="form-control" value = "">
                            </div>
                            <div class = "form-group password-rect">
                                <label class="control-label"><?php echo e(__('lang.암호확인')); ?></label>
                                <input  name="re_password" type="password" placeholder="<?php echo e(__('lang.비밀번호확인을 입력해주세요')); ?>" class="form-control" value = "">
                            </div>
                            <?php if($id*1  > 0): ?>
                            <div class="form-group">
                                <label class = "control-label"><?php echo e(__('lang.가입일')); ?> :</label>
                                <label class = "control-label"><?php echo e(substr($info['created_at'],0,16)); ?></label>
                            </div>
                            <div class="form-group">
                                <label class = "control-label"><?php echo e(__('lang.글 쓴 횟수')); ?> :</label>
                                <label class = "control-label"><?php echo e($info['board_cnt']); ?></label>
                            </div>
                            <div class="form-group">
                                <label class = "control-label"><?php echo e(__('lang.댓글 쓴 횟수')); ?> :</label>
                                <label class = "control-label"><?php echo e($info['reply_cnt']); ?></label>
                            </div>
                            <?php endif; ?>
                            <div class="form-position">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-responsive btn-success btn-sm" onclick = "goBack()"><?php echo e(__('lang.리스트로 이동')); ?></button>
                                    <button type="submit" class="btn btn-responsive btn-primary btn-sm"><?php echo e(__('lang.확인')); ?></button>
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
    <?php echo $__env->make("admin/user/set_user_point_dlg", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
    <script src="<?php echo e(asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js')); ?>" ></script>
<script>
    function showSetUserPointDlg(){
        var user_point = $("input[name='user_point']").val();
        $("#set-user-point-dialog input[name ='user_point']").val(user_point);
        $("#set-user-point-dialog").modal("show");
    }

    function setUserPoint(){
        var user_point  = $("#set-user-point-dialog input[name ='user_point']").val();
        $("input[name='user_point']").val(user_point);
        $("#set-user-point-dialog").modal("hide");
        $("#user_point_str").text(user_point);
    }

    function delImage(obj){
        $("#photo_url_img").attr("src", "");
        $("#photo_url_val").val("");
        $(obj).addClass("hidden");
    }

    function changePassword(){
        var checked = $("#password_update").prop("checked");
        if(checked){
            $(".password-rect").removeClass("hidden");
            $("input[name='password']").val("");
            $("input[name='re_password']").val("");
        }else{
            $(".password-rect").addClass("hidden");
        }
    }

    $(function() {
        changePassword();
        $('input[type="checkbox"].minimal-blue, input[type="radio"].minimal-blue').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue',
            increaseArea: '20%'
        });

        function formatState (state) {
            if (!state.id) { return state.text; }

            var $state = $(
                '<span><img src="'+public_path +'/'+ $(state.element).attr("data-icon")+'" class="img-flag" width="20px" height="20px" onerror="noExitImg(this)" /> ' + state.text + '</span>'
            );
            return $state;


        }
        $("#user_level").select2({
            templateResult: formatState,
            templateSelection: formatState,
            placeholder: "select",
            theme:"bootstrap"
        });

        $("#password_update").on("ifChanged", changePassword);

        $('textarea#description').ckeditor({
            height: '200px'
        });
        loading_stop();
        $("#infoForm").validate({
            rules: {
                email: "required",
                nickname: "required",
                nickname: "required",
                phone: "required",
                re_password:{minlength:3, equalTo:"input[name='password']"}
            },
            messages: {

            },
            errorPlacement: function (error, element) {
                if($(element).closest('div').children().filter("div.error-div").length < 1)
                    $(element).closest('div').append("<div class='error-div'></div>");
                $(element).closest('div').children().filter("div.error-div").append(error);
            },
            submitHandler: function(form){
                var checked = $("#password_update").prop("checked");
                if(checked){
                    var password = $("input[name='password']").val();
                    if(password == ""){
                        errorMsg("암호를 입력해주십시오.");
                        return;
                    }
                }
                var url = $(form).attr("action");
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
                               var id = $("input[name='id']").val();
                               if(id ==0){
                                   window.location.href = "<?php echo e(url("admin/user")); ?>";
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