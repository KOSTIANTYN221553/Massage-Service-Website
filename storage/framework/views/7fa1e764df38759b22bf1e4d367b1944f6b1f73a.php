<?php echo e(getCurrentLang()); ?>

<div id="notice-dialog" class="modal fade "  tabindex="-1" role="dialog" aria-hidden="false" style = "z-index: 1060;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?php echo e(__('lang.공지사항')); ?></h4>
            </div>

            <div class="modal-body" >
                <div class = "row">
                    <div class = "col-md-12" >
                        <p id = "content">

                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class ="row">
                    <div class = "col-md-8 text-left">
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="remember-me" id="remember-me" value="remember-me"
                                       class="square-blue"/>
                                <?php echo e(__('lang.24시간 보지 않기')); ?>

                            </label>
                        </div>
                    </div>
                    <div class = "col-md-4 text-right">
                        <button type="button"  class="btn btn-primary" onclick = "closeNoticeModal()"><?php echo e(__('lang.닫기')); ?></button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>