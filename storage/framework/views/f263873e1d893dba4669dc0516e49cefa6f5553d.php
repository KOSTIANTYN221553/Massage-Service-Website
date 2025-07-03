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
            <li <?php echo (Request::is('admin/shop_type') ||  Request::is('admin/shop_type/info/*') ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/shop_type')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.업소종류')); ?>

                </a>
            </li>
            <li <?php echo (Request::is('admin/shops') || Request::is('admin/shops/info/*')   ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/shops')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.업소목록')); ?>

                </a>
            </li>
        </ul>
    </li>
    <li <?php echo ( Request::is('admin/user') || Request::is('admin/user/info/*') ? 'class="active"' : ''); ?>>
        <a href="#">
            <i class="livicon" data-name="user" data-size="18" data-c="#418BCA" data-hc="#418BCA"
               data-loop="true"></i>
            <span class="title"><?php echo e(__('lang.고객관리')); ?></span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li <?php echo (Request::is('admin/user') ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/user')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.고객관리')); ?>

                </a>
            </li>
            <li <?php echo (Request::is('admin/user/info/0') ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/user/info/0')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.고객추가')); ?>

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
            <li <?php echo (Request::is('admin/notice/info/0') ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/notice/info/0')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.공지등록')); ?>

                </a>
            </li>
        </ul>
    </li>
    <li <?php echo (Request::is('admin/board') || Request::is('admin/board/info/*') || Request::is('admin/board_type') ||  Request::is('admin/board_type/info/*') ? 'class="active"' : ''); ?>>
        <a href="#">
            <i class="livicon" data-name="doc-portrait" data-c="#67C5DF" data-hc="#67C5DF"
               data-size="18" data-loop="true"></i>
            <span class="title"><?php echo e(__('lang.게시판관리')); ?></span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li <?php echo (Request::is('admin/board_type') ||  Request::is('admin/board_type/info/*') ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/board_type')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.게시판내 카테고리')); ?>

                </a>
            </li>
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
    <li <?php echo (Request::is('admin/question') || Request::is('admin/question/info/*') ? 'class="active"' : ''); ?>>
        <a href="#">
            <i class="livicon" data-name="mail" data-c="#3c8dbc" data-hc="#3c8dbc"
               data-size="18" data-loop="true"></i>
            <span class="title"><?php echo e(__('lang.제휴문의')); ?></span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li <?php echo (Request::is('admin/question/*') || Request::is('admin/question') ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/question')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.제휴문의')); ?>

                </a>
            </li>
        </ul>
    </li>
    <li <?php echo (Request::is('admin/ebza_board') || Request::is('admin/ebza_board/*') || Request::is('admin/user_board') || Request::is('admin/user_board/*') ? 'class="active"' : ''); ?>>
        <a href="#">
            <i class="livicon" data-name="help" data-c="#1DA1F2" data-hc="#1DA1F2"
               data-size="18" data-loop="true"></i>
            <span class="title"><?php echo e(__('lang.갤러리')); ?></span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li <?php echo (Request::is('admin/ebza_board') || Request::is('admin/ebza_board/*') ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/ebza_board')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__("lang.".env('SITE_NAME'))); ?><?php echo e(__('lang.갤러리')); ?>

                </a>
            </li>
            <li <?php echo (Request::is('admin/user_board') || Request::is('admin/user_board/*')  ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/user_board')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.유저갤러리')); ?>

                </a>
            </li>
        </ul>
    </li>
    <li <?php echo (Request::is('admin/review') || Request::is('admin/review/info/*') || Request::is('admin/review/view/*') ? 'class="active"' : ''); ?>>
        <a href="#">
            <i class="livicon" data-name="eye-open" data-c="#F89A14" data-hc="#F89A14"
               data-size="18" data-loop="true"></i>
            <span class="title"><?php echo e(__('lang.업소후기')); ?></span>
            <span class="fa arrow"></span>
        </a>
        <ul class="sub-menu">
            <li <?php echo (Request::is('admin/review') || Request::is('admin/review/view/*') ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/review')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.업소후기')); ?>

                </a>
            </li>
            <li <?php echo (Request::is('admin/review/info/0') ? 'class="active"' : ''); ?>>
                <a href="<?php echo e(URL::to('admin/review/info/0')); ?>">
                    <i class="fa fa-angle-double-right"></i>
                    <?php echo e(__('lang.글쓰기')); ?>

                </a>
            </li>
        </ul>
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
    <!-- Menus generated by CRUD generator -->
    <?php echo $__env->make('admin/layouts/menu', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</ul>
