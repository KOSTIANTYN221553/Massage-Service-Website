<style>
    .sorting_desc:before, .sorting_asc:before, .sorting:before {
        right: 1em;
        content: "";
    }
</style>
<?php echo e(getCurrentLang()); ?>

<div id="shop-users-dialog" class="modal fade "  tabindex="-1" role="dialog" aria-hidden="false" style = "z-index: 1060;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?php echo e(__('lang.소유자목록')); ?></h4>
            </div>
            <form class="form-horizontal" id = "" method = "post" action="javascript:void(0)">
                <div class="modal-body" >
                    <table class="table table-hover table-striped table-bordered" id = "table1" style = "margin-top:10px;">
                        <thead>
                        <tr>
                            <th style = "width:10%">No</th>
                            <th style = "width:90%"><?php echo e(__('lang.이름')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($shop_account_list)): ?>
                        <?php $__currentLoopData = $shop_account_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr data-id = "<?php echo e($item['id']); ?>">
                                <td><input type = "radio"  name = "check_shop_user" data-name = "<?php echo e($item['nickname']); ?>" <?php if($item['id']*1 ==$info['user_id']*1 ): ?> checked <?php endif; ?> value = "<?php echo e($item['id']); ?>"/></td>
                                <td data-id = "<?php echo e($item['id']); ?>"><?php echo e($item['nickname']); ?></td>
                            </tr>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-primary" onclick = "setShopUser()" ><?php echo e(__('lang.확인')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
