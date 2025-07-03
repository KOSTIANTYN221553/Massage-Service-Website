<?php echo e(getCurrentLang()); ?>

<ul id="menu" class="page-sidebar-menu">
    
    <li <?php echo (Request::is('admin/shops') || Request::is('admin/shops/info/*') || Request::is('admin/shop_type') || Request::is('admin/shop_type/info/*') ? 'class="active"' : ''); ?>>
        <a href="#">
            <i class="livicon" data-name="medal" data-size="18" data-c="#6CC66C" data-hc="#6CC66C"
               data-loop="true"></i>
            <span class="title"><?php echo e(__('lang.업소관리')); ?></span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li <?php echo (Request::is('admin/shops') || Request::is('admin/shops/info/*')   ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/shops')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.업소목록')); ?>

                </a>
            </li>
        </ul>
    </li>
    <li <?php echo ( Request::is('admin/manager') || Request::is('admin/manager/info/*') ? 'class="active"' : ''); ?>>
        <a href="#">
            <i class="livicon" data-name="barchart" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title"><?php echo e(__('lang.매니저관리')); ?></span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li <?php echo (Request::is('admin/manager') ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/manager')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.매니저목록')); ?>

                </a>
            </li>
            <li <?php echo (Request::is('admin/manager/info/0') ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/manager/info/0')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.매니저추가')); ?>

                </a>
            </li>

        </ul>
    </li>
    <li <?php echo (Request::is('admin/notice') || Request::is('admin/notice/info/*') ? 'class="active"' : ''); ?>>
        <a href="#">
            <i class="livicon" data-name="wrench" data-size="18" data-c="#6CC66C" data-hc="#6CC66C"
               data-loop="true"></i>
            <span class="title"><?php echo e(__('lang.공지사항')); ?></span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li <?php echo (Request::is('admin/notice') ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/notice')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.공지사항')); ?>

                </a>
            </li>
        </ul>
    </li>
    <li class ="hidden" <?php echo (Request::is('admin/board') || Request::is('admin/board/info/*') ? 'class="active"' : ''); ?>>
        <a href="#">
            <i class="livicon" data-name="doc-portrait" data-c="#67C5DF" data-hc="#67C5DF"
               data-size="18" data-loop="true"></i>
            <span class="title"><?php echo e(__('lang.게시판관리')); ?></span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li <?php echo (Request::is('admin/board') ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/board')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.게시판관리')); ?>

                </a>
            </li>
            <li <?php echo (Request::is('admin/board/info/0') ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/board/info/0')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.글쓰기')); ?>

                </a>
            </li>
        </ul>
    </li>
    <li <?php echo (Request::is('admin/review') || Request::is('admin/review/view/*')  || Request::is('admin/review/info/*') ? 'class="active"' : ''); ?>>
        <a href="#">
            <i class="livicon" data-name="cellphone" data-c="#67C5DF" data-hc="#67C5DF"
               data-size="18" data-loop="true"></i>
            <span class="title"><?php echo e(__('lang.업소후기')); ?></span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li <?php echo (Request::is('admin/review')  || Request::is('admin/review/view/*') ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/review')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.업소후기')); ?>

                </a>
            </li>
            <li  class = "hidden"  <?php echo (Request::is('admin/review/info/0') ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/review/info/0')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.글쓰기')); ?>

                </a>
            </li>
        </ul>
    </li>
    <li <?php echo (Request::is('admin/schedule') || Request::is('admin/schedule/info/*') ? 'class="active"' : ''); ?>>
        <a href="<?php echo e(URL::to('admin/schedule')); ?>">
            <i class="livicon" data-name="calendar" data-s="18" data-c="#1DA1F2" data-hc="#1DA1F2" data-loop="true"></i>
            <?php echo e(__('lang.스케쥴관리')); ?>

        </a>
    </li>
    <li <?php echo (Request::is('admin/shop_board') || Request::is('admin/shop_board/info/*') || Request::is('admin/shop_board/view/*') ? 'class="active"' : ''); ?>>
        <a href="<?php echo e(URL::to('admin/shop_board')); ?>">
            <i class="livicon" data-name="brush" data-s="18" data-c="#1DA1F2" data-hc="#1DA1F2" data-loop="true"></i>
            <?php echo e(__('lang.블랙리스트 게시판')); ?>

        </a>
    </li>

    <li <?php echo (Request::is('admin/shop_question') || Request::is('admin/shop_question/info/*') || Request::is('admin/shop_question/view/*') ? 'class="active"' : ''); ?>>
        <a href="<?php echo e(URL::to('admin/shop_question')); ?>">
            <i class="livicon" data-name="cloud-up" data-s="18" data-c="#6CC66C" data-hc="#6CC66C" data-loop="true"></i>
            <?php echo e(__('lang.관리자 문의 게시판')); ?>

        </a>
    </li>
    <li>
        <a href="<?php echo e(URL::to('admin/logout')); ?>">
            <i class="livicon" data-name="sign-out" data-s="18" data-c="#F89A14" data-hc="#F89A14" data-loop="true"></i>
            <?php echo e(__('lang.로그아웃')); ?>

        </a>
    </li>
    <?php
        $user = getLoginUserInfo();
        $complete_info = $user->shop_complete_info();
    ?>

    <li>
        <a href="javascript:void(0)">
            <?php if($complete_info['diff']*1 == -1): ?>
                <label><?php echo e(__('lang.없음')); ?></label>
            <?php else: ?>
                <label id = "diff_time_admin" data-diff = "<?php echo e($complete_info['diff']); ?>"></label>
            <?php endif; ?>
        </a>
    </li>

    <!-- Menus generated by CRUD generator -->
    <?php $__env->startSection('footer_scripts'); ?>
        <script>

        </script>
    <?php $__env->stopSection(); ?>
    <?php echo $__env->make('admin/layouts/menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</ul>


