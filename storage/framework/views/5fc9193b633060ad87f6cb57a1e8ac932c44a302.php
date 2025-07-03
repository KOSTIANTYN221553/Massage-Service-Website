<?php echo e(getCurrentLang()); ?>

<ul class="nav nav-tabs" style="margin-bottom: 15px;">
    <li class="active">
        <a href="#home" data-toggle="tab" aria-expanded="false" class = "active"><?php echo e(__('lang.받은 쪽지')); ?></a>
    </li>
    <li class="">
        <a href="#profile" data-toggle="tab" aria-expanded="true"><?php echo e(__('lang.보낸 쪽지')); ?></a>
    </li>
</ul>
<div class="slimScrollDiv" style="position: relative; overflow: visible; width: auto; ">
    <div id="myTabContent" class="tab-content" style="overflow: visible; width: auto;">
        <div class="tab-pane fade active in" id="home">
            <div class="table-scrollable" style ="overflow: visible">
                <table class="table table-striped" id = "table1">
                    <thead>
                    <tr>
                        <th><?php echo e(__('lang.아이디')); ?></th>
                        <th><?php echo e(__('lang.받은 날')); ?></th>
                        <th><?php echo e(__('lang.읽은 날')); ?></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $to_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class = "cursor relative menu-click-wrapper" onclick = "menuItemClick(this)">
                                <?php echo e($item['send_nickname']); ?>

                                <ul class = "td-click-menu hidden">
                                    <li><a href = "javascript:void(0);" onclick = "showSendNoteDlg(this)"  data-user-id = "<?php echo e($item['send_user_id']); ?>"><?php echo e(__('lang.쪽지보내기')); ?></a></li>
                                    <li><a href = "javascript:void(0);" onclick = "showUserInfoDlg(this)" data-user-id = "<?php echo e($item['send_user_id']); ?>"><?php echo e(__('lang.회원정보')); ?></a></li>
                                </ul>
                            </td>
                            <td class = "cursor" onclick = "note_view(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e(substr($item['send_date'],0,16)); ?></td>
                            <td class = "cursor" onclick = "note_view(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e(substr($item['read_date'],0,16)); ?></td>
                            <td>
                                <a href = "javascript:void(0)" onclick = "delNote(this)" data-id = "<?php echo e($item['id']); ?>" ><?php echo e(__('lang.삭제')); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if(count($to_list)==0): ?>
                        <tr>
                            <td colspan ="4">
                                <?php echo e(__('lang.자료가 없습니다.')); ?>

                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
                <?php $searchFun ='searchData1'; ?>
                <?php echo $__env->make('layouts/pagination', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
        <div class="tab-pane fade" id="profile">
            <div class="table-scrollable" style ="overflow: visible">
                <table class="table table-striped" id = "table2">
                    <thead>
                    <tr>
                        <th><?php echo e(__('lang.아이디')); ?></th>
                        <th><?php echo e(__('lang.받은 날')); ?></th>
                        <th><?php echo e(__('lang.읽은 날')); ?></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $from_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class ="cursor relative menu-click-wrapper" onclick = "menuItemClick(this)">
                                <?php echo e($item['to_nickname']); ?>

                                <ul class = "td-click-menu hidden">
                                    <li><a href = "javascript:void(0);" onclick = "showSendNoteDlg(this)" data-user-id = "<?php echo e($item['to_user_id']); ?>"><?php echo e(__('lang.쪽지보내기')); ?></a></li>
                                    <li><a href = "javascript:void(0);" onclick = "showUserInfoDlg(this)" data-user-id = "<?php echo e($item['to_user_id']); ?>"><?php echo e(__('lang.회원정보')); ?></a></li>
                                </ul>
                            </td>
                            <td class = "cursor" onclick = "note_view(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e(substr($item['send_date'],0,16)); ?></td>
                            <td class = "cursor" onclick = "note_view(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e(substr($item['read_date'],0,16)); ?></td>
                            <td >
                                <a href = "javascript:void(0)" onclick = "delNote(this)" data-id = "<?php echo e($item['id']); ?>" ><?php echo e(__('lang.삭제')); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if(count($from_list)==0): ?>
                        <tr>
                            <td colspan ="4">
                                <?php echo e(__('lang.자료가 없습니다.')); ?>

                            </td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
                <?php $searchFun ='searchData2'; ?>
                <?php echo $__env->make('layouts/pagination', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    </div>
</div>

<script>

</script>