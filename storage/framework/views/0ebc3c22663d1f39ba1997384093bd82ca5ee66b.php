<?php echo e(getCurrentLang()); ?>

<div id="user-exit-password-confirm-dialog" class="modal fade"  role="dialog" style = "z-index: 1060;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?php echo e(__('lang.암호확인')); ?></h4>
            </div>
            <form class="form-horizontal" id = "userExitPasswordConfirmForm" method = "post" action="<?php echo e(url("/user_exit")); ?>">
                <div class="modal-body" >
                    <div class="panel-body">
                        <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
                        <div class = "form-group">
                            <label>
                                <?php echo e(__('lang.회원탈퇴를 하시려면 비밀번호인증을 진행하셔야 합니다')); ?>

                            </label>
                        </div>
                        <div class="form-group <?php echo e($errors->first('password', 'has-error')); ?>">
                            <label class="sr-only"><?php echo e(__('lang.비밀번호')); ?></label>
                            <input type="password" class="form-control" name="password_dlg"
                                   placeholder="<?php echo e(__('lang.비밀번호를 입력해주세요')); ?>">
                            <?php echo $errors->first('password', '<span class="help-block">:message</span>'); ?>

                        </div>
                        <div class="form-group <?php echo e($errors->first('password_confirm', 'has-error')); ?>">
                            <label class="sr-only"><?php echo e(__('lang.비밀번호확인')); ?></label>
                            <input type="password" class="form-control" name="password_dlg_confirm"
                                   placeholder="<?php echo e(__('lang.비밀번호확인을 입력해주세요')); ?>">
                            <?php echo $errors->first('password_confirm', '<span class="help-block">:message</span>'); ?>

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"  class="btn btn-danger" ><?php echo e(__('lang.확인')); ?></button>
                    <button type="button"  class="btn btn-danger" onclick = "hiddenConfirmDlg()" ><?php echo e(__('lang.취소')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
