<?php echo e(getCurrentLang()); ?>

<option value = "0"><?php echo e(__('lang.미정')); ?></option>
<?php $__currentLoopData = $categoryList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <option value = "<?php echo e($item['id']); ?>"  <?php if($category_id*1 == $item['id']*1): ?> selected <?php endif; ?>><?php echo e($item['title']); ?></option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>