<?php echo e(getCurrentLang()); ?>

<div id="user-info-dialog" class="modal fade "  tabindex="-1" role="dialog" aria-hidden="false" style = "z-index: 1060;">
    <div class="modal-dialog modal-lg front-dlg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?php echo e(__('lang.회원정보')); ?></h4>
            </div>

            <div class="modal-body" id="content">
            </div>
            <div class="modal-footer hidden">
                <button type="button"  class="btn btn-primary close"  data-dismiss="modal"  ><?php echo e(__('lang.확인')); ?></button>
            </div>

        </div>
    </div>
</div>


