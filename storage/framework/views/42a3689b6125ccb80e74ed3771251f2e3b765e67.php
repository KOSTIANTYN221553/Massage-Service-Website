<?php echo e(getCurrentLang()); ?>

<ol class="dd-list">
    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <li class="dd-item dd3-item" data-id="<?php echo e($item['id']); ?>">
        <div class="dd-handle dd3-handle"></div>
        <div class="dd3-content">
            <?php echo e($item['title']); ?>

            <span style = "float:right; margin-left:10px;" class ="cursor" onclick ="deleteCategory(this)" data-id = "<?php echo e($item['id']); ?>"><i class ="fa fa-trash"></i></span>
            <span style = "float:right" onclick ="editCategory(this)" data-id = "<?php echo e($item['id']); ?>" data-title = "<?php echo e($item['title']); ?>" class ="cursor"><i class ="fa fa-pencil"></i></span>
        </div>
        <?php if(count($item['childList']) > 0): ?>
            <ol class="dd-list">
            <?php $__currentLoopData = $item['childList']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="dd-item dd3-item" data-id="<?php echo e($child['id']); ?>">
                        <div class="dd-handle dd3-handle"></div>
                        <div class="dd3-content">
                            <?php echo e($child['title']); ?>

                            <span style = "float:right; margin-left:10px;" class ="cursor" onclick ="deleteCategory(this)" data-id = "<?php echo e($child['id']); ?>"><i class ="fa fa-trash"></i></span>
                            <span style = "float:right" onclick ="editCategory(this)" data-id = "<?php echo e($child['id']); ?>" data-title = "<?php echo e($child['title']); ?>" class ="cursor"><i class ="fa fa-pencil"></i></span>
                        </div>
                    </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ol>
        <?php endif; ?>
    </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ol>

<script>

</script>