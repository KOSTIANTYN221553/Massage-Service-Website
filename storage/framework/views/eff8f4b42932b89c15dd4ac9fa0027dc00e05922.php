<style>

</style>
<?php echo e(getCurrentLang()); ?>

<div id="shop-complete-setting-dialog" class="modal fade"  role="dialog" style = "z-index: 1060;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?php echo e(__('lang.월정액추가')); ?></h4>
            </div>
            <form class="form-horizontal" id = "completeSettingForm" method = "post" action="javascript:void(0)">
                <input type = "hidden" name ="id" />
                <div class="modal-body" >
                    <div class="panel-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" class="custom-radio" name = "radio" value="1" checked>&nbsp;<?php echo e(__('lang.1개월추가')); ?></label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" class="custom-radio" name = "radio" value="3">&nbsp;<?php echo e(__('lang.3개월추가')); ?></label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" class="custom-radio" name = "radio" value="6">&nbsp; <?php echo e(__('lang.6개월추가')); ?></label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" class="custom-radio" name = "radio" value="12">&nbsp; <?php echo e(__('lang.1년추가')); ?></label>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="checkbox">
                                    <label>
                                        <input type="radio" class="custom-radio" name = "radio" value="-1">&nbsp; <?php echo e(__('lang.기간삭제')); ?></label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-primary" onclick = "onSetCompleteDate()" ><?php echo e(__('lang.확인')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
