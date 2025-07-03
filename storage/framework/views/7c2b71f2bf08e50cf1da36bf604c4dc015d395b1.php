<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
<?php echo e(__('lang.계급과 포인트 가이드')); ?>

##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
    <!--page level css starts-->
    <!--end of page level css-->
    <style>
        .text-vcenter{
            vertical-align: middle !important;
        }
    </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <div class="container mt-10">
            <div class = "row">
                <div class = "col-md-12 col-xs-12 page-title-wrapper">
                    <span class = ""><?php echo e(__('lang.계급과 포인트 가이드')); ?></span>
                </div>
            </div>

            <?php $user_info = getLoginUserInfo();?>
        <div class = "row">
            <div class = "col-md-9 cols-xs-12">
                <div class="row">
                    <div class = "col-md-12">
                        <div class = "table-scrollable">
                            <div class="page-wrap hidden-xs">
                                <style>
                                    .page-content { line-height:22px; word-break: keep-all; word-wrap: break-word; }
                                    .page-content .article-title { color:#0083B9; font-weight:bold; padding-top:30px; padding-bottom:10px; }
                                    .page-content ul { list-style:none; padding:0px; margin:0px; font-weight:normal; }
                                    .page-content ol { margin-top:0px; margin-bottom:15px; }
                                    .page-content p { margin:0 0 15px; padding:0; }
                                    .page-content table { border-top:2px solid #999; border-bottom:1px solid #ddd; }
                                    .page-content th,
                                    .page-content td { line-height:1.6 !important; }
                                    .page-content table.tbl-center th,
                                    .page-content table.tbl-center td,
                                    .page-content th.text-center,
                                    .page-content td.text-center { text-align:center !important; }
                                </style>
                                <div class="page-content">
                                    <div class="article-title" style="padding-top: 0px;">
                                        <h3 style="font-weight:bold;">
                                            <span class="glyphicon glyphicon-flag"></span><?php echo e(env('SITE_NAME')); ?> <?php echo e(__('lang.등업 안내')); ?>

                                        </h3>
                                    </div>
                                    <p style="padding-left:20px;"><?php echo e(env('SITE_NAME')); ?><?php echo e(__('lang.레벨별 경험치 및 등업 기준 안내입니다')); ?></p>
                                    <div class="table-responsive">
                                        <style>
                                            table > tbody tr > th {
                                                text-align:center !important;
                                            }
                                            table > tbody> tr > td {
                                                text-align:center !important;
                                            }
                                            table > tbody> tr > td {
                                                text-align:center !important;
                                            }
                                            .nextlevel > td {
                                                vertical-align:middle !important;
                                            }
                                            .nextlevel > th {
                                                vertical-align:middle !important;
                                            }
                                            @-webkit-keyframes invalid2 {
                                                from { background-color: #3cbf62; }
                                                to { background-color: #579a6a; }
                                            }
                                            @-moz-keyframes invalid2 {
                                                from { background-color: #3cbf62; }
                                                to { background-color: #579a6a; }
                                            }
                                            @-o-keyframes invalid2 {
                                                from { background-color: #3cbf62; }
                                                to { background-color: #579a6a; }
                                            }
                                            @keyframes  invalid2 {
                                                from { background-color: #3cbf62; }
                                                to { background-color: #579a6a; }
                                            }
                                            .invalid2 {
                                                -webkit-animation: invalid2 1s infinite; /* Safari 4+ */
                                                -moz-animation:    invalid2 1s infinite; /* Fx 5+ */
                                                -o-animation:      invalid2 1s infinite; /* Opera 12+ */
                                                animation:         invalid2 1s infinite; /* IE 10+ */
                                            }

                                            @-webkit-keyframes invalid3 {
                                                from { background-color: #9a5757; }
                                                to { background-color: #af1717; }
                                            }
                                            @-moz-keyframes invalid3 {
                                                from { background-color: #9a5757; }
                                                to { background-color: #af1717; }
                                            }
                                            @-o-keyframes invalid3 {
                                                from { background-color: #9a5757; }
                                                to { background-color: #af1717; }
                                            }
                                            @keyframes  invalid3 {
                                                from { background-color: #9a5757; }
                                                to { background-color: #af1717; }
                                            }
                                            .invalid3 {
                                                -webkit-animation: invalid3 1s infinite; /* Safari 4+ */
                                                -moz-animation:    invalid3 1s infinite; /* Fx 5+ */
                                                -o-animation:      invalid3 1s infinite; /* Opera 12+ */
                                                animation:         invalid3 1s infinite; /* IE 10+ */
                                            }

                                        </style>
                                        <?php if(isset($user_info['id'])): ?>
                                            <table class="table">
                                                <tbody>
                                                <tr class="active">
                                                    <th><?php echo e(__('lang.현재레벨')); ?></th>
                                                    <th><?php echo e(__('lang.가입일')); ?></th>
                                                    <th><?php echo e(__('lang.보유 포인트')); ?></th>
                                                    <th><?php echo e(__('lang.후기 작성개수')); ?></th>
                                                    <th><?php echo e(__('lang.게시글 작성개수')); ?></th>
                                                    <th><?php echo e(__('lang.댓글 작성개수')); ?></th>
                                                </tr>

                                                <tr>
                                                    <th><img style="width:20px !important;" src="<?php echo e(url($user_info['user_level']['icon'])); ?>"> <?php echo e($user_info['user_level']['title']); ?></th>
                                                    <td> <?php echo e(getDayDiff('', $user_info['created_at'])); ?> <?php echo e(__('lang.일')); ?></td>
                                                    <td> <?php echo e(number_format($user_info['user_point'])); ?>P</td>
                                                    <?php $write_cnt_info = $user_info->get_user_write_count_info();?>
                                                    <td> <?php echo e($write_cnt_info['review_cnt']); ?><?php echo e(__('lang.개')); ?></td>
                                                    <td> <?php echo e($write_cnt_info['board_cnt']); ?><?php echo e(__('lang.개')); ?></td>
                                                    <td> <?php echo e($write_cnt_info['reply_cnt']); ?><?php echo e(__('lang.개')); ?></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        <?php endif; ?>
                                        <table class="table">
                                            <tbody>
                                            <tr class="active">
                                                <th><?php echo e(__('lang.아이콘')); ?></th>
                                                <th><?php echo e(__('lang.레벨')); ?></th>
                                                <th><?php echo e(__('lang.권한')); ?></th>
                                                <th><?php echo e(__('lang.가입일')); ?></th>
                                                <th><?php echo e(__('lang.포인트')); ?></th>
                                                <th><?php echo e(__('lang.후기')); ?></th>
                                                <th><?php echo e(__('lang.게시글')); ?></th>
                                                <th><?php echo e(__('lang.댓글')); ?></th>
                                                <th ><?php echo e(_('lang.레벨업')); ?></th>
                                            </tr>
                                            <?php $__currentLoopData = $level_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr <?php if( isset($user_info['level_id']) && ($item['id']*1 == $user_info['level_id']+1)): ?>class="nextlevel" style="background-color:antiquewhite;" <?php endif; ?>>
                                                    <th><img style="width:20px !important;" src="<?php echo e(url($item['icon'])); ?>"><?php echo e($item['icon_level']); ?></th>
                                                    <td style="font-weight:bold;"><?php echo e($item['title']); ?></td>
                                                    <td style="padding-left:40px;text-align:left !important;"><?php echo e($item['description']); ?></td>
                                                    <td>
                                                        <?php echo e($item['period']); ?><?php echo e(__('lang.일')); ?></td>
                                                    <td <?php if( isset($user_info['level_id']) && ($item['id']*1 == $user_info['level_id']+1)): ?> style = "color:red;" <?php endif; ?>>
                                                        <?php echo e($item['need_point']); ?>P</td>
                                                    <td>
                                                        <?php echo e($item['review_cnt']); ?><?php echo e(__('lang.개')); ?></td>
                                                    <td>
                                                        <?php echo e($item['board_cnt']); ?><?php echo e(__('lang.개')); ?></td>
                                                    <td>
                                                        <?php echo e($item['reply_cnt']); ?><?php echo e(__('lang.개')); ?></td>
                                                    <td>
                                                        <?php if( isset($user_info['level_id']) && ($item['id']*1 == $user_info['level_id']+1)): ?>
                                                            <button id="btn_upgrade" style="height:35px;color:white;background-color:#af1717; border-radius:5px;width:100px;"><?php echo e(__('lang.등업조건미달')); ?></button>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>



                                    <div class="article-title"><h3 style="font-weight:bold;"><span class="glyphicon glyphicon-flag"></span>  <?php echo e(__('lang.포인트 제도 안내')); ?></h3></div>

                                    <p style="padding-left:20px;"><?php echo e(__('lang.본 사이트는 활성화와 다양한 혜택을 서비스하기 위해 포인트 제도를 운영하고 있습니다')); ?></p>

                                    <ol>
                                        <li> <?php echo e(__('lang.포인트 정책은 수시로 변경될 수 있으며,이를 별도로 통보하지 않습니다')); ?>

                                        </li><li> <?php echo e(__('lang.포인트 획득을 위한 도배 및 어뷰징 등의 행위자는 통보없이 “포인트 몰수” 또는 “회원정지” 또는 “사이트 접근차단” 등의 조치를 받을 수 있습니다')); ?>

                                        </li><li> <?php echo e(__('lang.적립된 포인트는 사이트내 서비스를 이용하는 목적 이외의 어떠한 효력도 갖고 있지 않습니다')); ?>

                                        </li><li> <?php echo e(__('lang.회원가입시')); ?> <b>100</b> <?php echo e(__('lang.포인트 적립(1회), 로그인시')); ?>  <b>0</b> <?php echo e(__('lang.포인트 적립(매일), 쪽지발송시')); ?> <b>50</b> <?php echo e(__('lang.포인트 차감(매회)')); ?>

                                        </li></ol>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody><tr class="active">
                                                <th class="text-center text-vcenter"><?php echo e(__('lang.그룹명')); ?></th>
                                                <th class="text-center"><?php echo e(__('lang.보드명')); ?></th>
                                                <th class="text-center"><?php echo e(__('lang.읽기')); ?></th>
                                                <th class="text-center"><?php echo e(__('lang.쓰기')); ?></th>
                                                <th class="text-center"><?php echo e(__('lang.댓글')); ?></th>
                                            </tr>
                                            <tr>

                                                <th rowspan="2" class="text-center text-vcenter"><?php echo e(__('lang.공지사항')); ?></th>
                                                <td><a href="#"><?php echo e(__('lang.공지사항')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">1</td>
                                            </tr>
                                            <tr>
                                                <td><a href="#"></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                            </tr>
                                            <tr>
                                                <th rowspan="1" class="text-center text-vcenter"><?php echo e(__('lang.업소정보')); ?></th>
                                                <td><a href="#"><?php echo e(__('lang.업소정보')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">1</td>
                                            </tr>
                                            <tr>
                                                <th rowspan="1" class="text-center text-vcenter"><?php echo e(__('lang.업소후기')); ?></th>
                                                <td><a href="#"><?php echo e(__('lang.업소후기')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">20</td>
                                                <td class="text-center">5</td>
                                            </tr>
                                            <tr>
                                                <th rowspan="8" class="text-center text-vcenter"><?php echo e(__('lang.커뮤니티')); ?></th>
                                                <td><a href="#"><?php echo e(__('lang.가입인사(장터게시판을 변경)')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">400</td>
                                                <td class="text-center">10</td>
                                            </tr>
                                            <tr>
                                                <td><a href="#"><?php echo e(__('lang.자유게시판')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">10</td>
                                                <td class="text-center">2</td>
                                            </tr>
                                            <tr>
                                                <td><a href="#"><?php echo e(__('lang.질문게시판')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-10</td>
                                                <td class="text-center">2</td>
                                            </tr>
                                            <tr>
                                                <td><a href="#"><?php echo e(__('lang.언니들의 놀이터')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">10</td>
                                                <td class="text-center">5</td>
                                            </tr>
                                            <tr>
                                                <td><a href="#"><?php echo e(__('lang.벼룩시장/구인구직')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">5</td>
                                                <td class="text-center">5</td>
                                            </tr>
                                            <tr>
                                                <td><a href="#"><?php echo e(__('lang.실장놀이터')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">10</td>
                                                <td class="text-center">2</td>
                                            </tr>
                                            <tr>
                                                <td><a href="#"><?php echo e(__('lang.번개게시판')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">10</td>
                                                <td class="text-center">2</td>
                                            </tr>
                                            <tr>
                                                <td><a href="#"><?php echo e(__('lang.정보공유')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">20</td>
                                                <td class="text-center">5</td>
                                            </tr>
                                            <tr>
                                                <th rowspan="1" class="text-center text-vcenter"><?php echo e(__('lang.이벤트')); ?></th>
                                                <td><a href="#"><?php echo e(env('SITE_NAME')); ?> <?php echo e(__('lang.이벤트')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">1</td>
                                            </tr>
                                            <tr>

                                                <th rowspan="1" class="text-center text-vcenter"><?php echo e(__('lang.제휴문의')); ?></th>
                                                <td><a href="#"><?php echo e(__('lang.메모관리')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="h30"></div>
                            </div>
                            <div class = "hidden-sm hidden-lg hidden-md page-wrap font-14">
                                <style>
                                    .page-content { line-height:22px; word-break: keep-all; word-wrap: break-word; }
                                    .page-content .article-title { color:#0083B9; font-weight:bold; padding-top:30px; padding-bottom:10px; }
                                    .page-content ul { list-style:none; padding:0px; margin:0px; font-weight:normal; }
                                    .page-content ol { margin-top:0px; margin-bottom:15px; }
                                    .page-content p { margin:0 0 15px; padding:0; }
                                    .page-content table { border-top:2px solid #999; border-bottom:1px solid #ddd; }
                                    .page-content th,
                                    .page-content td { line-height:1.6 !important; }
                                    .page-content table.tbl-center th,
                                    .page-content table.tbl-center td,
                                    .page-content th.text-center,
                                    .page-content td.text-center { text-align:center !important; }
                                </style>
                                <div class="page-content">
                                    <div class="article-title" style="padding-top: 0px;">
                                        <h3 style="font-weight:bold;">
                                            <span class="glyphicon glyphicon-flag"></span><?php echo e(env('SITE_NAME')); ?> <?php echo e(__('lang.등업 안내')); ?>

                                        </h3>
                                    </div>
                                    <p style="padding-left:20px;"><?php echo e(env('SITE_NAME')); ?> <?php echo e(__('lang.레벨별 경험치 및 등업 기준 안내입니다')); ?></p>
                                    <div class="table-responsive">
                                        <style>
                                            table > tbody tr > th {
                                                text-align:center !important;
                                            }
                                            table > tbody> tr > td {
                                                text-align:center !important;
                                            }
                                            table > tbody> tr > td {
                                                text-align:center !important;
                                            }
                                            .nextlevel > td {
                                                vertical-align:middle !important;
                                            }
                                            .nextlevel > th {
                                                vertical-align:middle !important;
                                            }
                                            @-webkit-keyframes invalid2 {
                                                from { background-color: #3cbf62; }
                                                to { background-color: #579a6a; }
                                            }
                                            @-moz-keyframes invalid2 {
                                                from { background-color: #3cbf62; }
                                                to { background-color: #579a6a; }
                                            }
                                            @-o-keyframes invalid2 {
                                                from { background-color: #3cbf62; }
                                                to { background-color: #579a6a; }
                                            }
                                            @keyframes  invalid2 {
                                                from { background-color: #3cbf62; }
                                                to { background-color: #579a6a; }
                                            }
                                            .invalid2 {
                                                -webkit-animation: invalid2 1s infinite; /* Safari 4+ */
                                                -moz-animation:    invalid2 1s infinite; /* Fx 5+ */
                                                -o-animation:      invalid2 1s infinite; /* Opera 12+ */
                                                animation:         invalid2 1s infinite; /* IE 10+ */
                                            }

                                            @-webkit-keyframes invalid3 {
                                                from { background-color: #9a5757; }
                                                to { background-color: #af1717; }
                                            }
                                            @-moz-keyframes invalid3 {
                                                from { background-color: #9a5757; }
                                                to { background-color: #af1717; }
                                            }
                                            @-o-keyframes invalid3 {
                                                from { background-color: #9a5757; }
                                                to { background-color: #af1717; }
                                            }
                                            @keyframes  invalid3 {
                                                from { background-color: #9a5757; }
                                                to { background-color: #af1717; }
                                            }
                                            .invalid3 {
                                                -webkit-animation: invalid3 1s infinite; /* Safari 4+ */
                                                -moz-animation:    invalid3 1s infinite; /* Fx 5+ */
                                                -o-animation:      invalid3 1s infinite; /* Opera 12+ */
                                                animation:         invalid3 1s infinite; /* IE 10+ */
                                            }
                                            .guide_status>.my_status {
                                                display: inline-block;
                                                padding: .2em .6em .3em;
                                                font-size: 75%;
                                                font-weight: 700;
                                                /* line-height: 1; */
                                                color: #fff;
                                                text-align: center;
                                                white-space: nowrap;
                                                vertical-align: baseline;
                                                border-radius: .25em;
                                                background-color: #777;
                                                height: 25px;
                                                margin: 3px;
                                            }
                                            .guide_levels .level_line {
                                                padding: 10px;
                                                background-color: #f2f7c5;
                                                margin-top: 10px;
                                            }

                                            .guide_levels .level_line:first-child{
                                                margin-top: 0px;
                                            }

                                            .guide_levels .level_line div:first-child {
                                                background-color: #cbd290;
                                                margin: 2px;
                                                border-radius: 2px;

                                            }
                                            .guide_levels  .level_line .level_line_item{
                                                display: inline-block;
                                                background: white;
                                                border-radius: 2px;
                                                padding: 3px;
                                                margin: 2px;
                                            }
                                            .guide_levels .level_line .item_note {
                                                border-radius: 0px;
                                                font-size: smaller;
                                                display: block;
                                                background-color:lightgray;
                                            }

                                        </style>
                                        <?php if(isset($user_info['id'])): ?>
                                        <div class ="">
                                            <div class="guide_status">
                                                <span class="my_status"><img style="width:17px !important;" src="<?php echo e(url($user_info['user_level']['icon'])); ?>">  <?php echo e($user_info['user_level']['title']); ?></span>
                                                <span class="my_status"> <?php echo e(__('lang.가입일')); ?>:<?php echo e(getDayDiff('', $user_info['created_at'])); ?> <?php echo e(__('lang.일')); ?> </span>
                                                <span class="my_status"> <?php echo e(__('lang.보유포인트')); ?>: <?php echo e(number_format($user_info['user_point'])); ?>P</span>
                                                <span class="my_status"> <?php echo e(__('lang.후기 작성갯수')); ?>:<?php echo e($write_cnt_info['review_cnt']); ?><?php echo e(__('lang.개')); ?></span>
                                                <span class="my_status"> <?php echo e(__('lang.게시글 작성갯수')); ?>:<?php echo e($write_cnt_info['board_cnt']); ?><?php echo e(__('lang.개')); ?></span>
                                                <span class="my_status"> <?php echo e(__('lang.댓글 작성갯수')); ?>:<?php echo e($write_cnt_info['reply_cnt']); ?><?php echo e(__('lang.개')); ?></span>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                        <div class="guide_levels">
                                            <?php $__currentLoopData = $level_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div  class="level_line" <?php if( isset($user_info['level_id']) && ($item['id']*1 == $user_info['level_id']+1)): ?> style="background-color:antiquewhite;" <?php endif; ?>>
                                                    <div>
                                                        <span>
                                                            <img style="width:17px !important;" src="<?php echo e(url($item['icon'])); ?>"> <?php echo e($item['icon_level']); ?>

                                                        </span>
                                                        <span style="font-weight:bold;"><?php echo e($item['title']); ?></span>
                                                        <?php if( isset($user_info['level_id']) && ($item['id']*1 == $user_info['level_id']+1)): ?>
                                                        <span style="background-color: green; color: white;" class="level_line_item "><?php echo e(__('lang.다음레벨')); ?></span>
                                                        <button class="" style="height:35px;color:white;background-color:#af1717; border-radius:5px;width:100px;"><?php echo e(__('lang.등업조건미달')); ?></button>
                                                        <?php endif; ?>
                                                    </div>
                                                    <span class="level_line_item"><?php echo e(__('lang.가입일')); ?>:<?php echo e($item['period']); ?><?php echo e(__('lang.일')); ?></span>
                                                    <span class="level_line_item" <?php if( isset($user_info['level_id']) && ($item['id']*1 == $user_info['level_id']+1)): ?> style="color:red" <?php endif; ?>><?php echo e(__('lang.포인트')); ?>:<?php echo e($item['need_point']); ?>P</span>
                                                    <span class="level_line_item"><?php echo e(__('lang.후기')); ?>: <?php echo e($item['review_cnt']); ?><?php echo e(__('lang.개')); ?></span>
                                                    <span class="level_line_item"><?php echo e(__('lang.게시글')); ?>:<?php echo e($item['board_cnt']); ?><?php echo e(__('lang.개')); ?></span>
                                                    <span class="level_line_item"><?php echo e(__('lang.댓글')); ?>:<?php echo e($item['reply_cnt']); ?><?php echo e(__('lang.개')); ?></span>
                                                    <div>
                                                        <span class="level_line_item item_note"><?php echo e($item['description']); ?></span>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>



                                    <div class="article-title"><h3 style="font-weight:bold;"><span class="glyphicon glyphicon-flag"></span>  <?php echo e(__('lang.포인트 제도 안내')); ?></h3></div>

                                    <p style="padding-left:20px;"><?php echo e(__('lang.본 사이트는 활성화와 다양한 혜택을 서비스하기 위해 포인트 제도를 운영하고 있습니다')); ?></p>

                                    <ol>
                                        <li> <?php echo e(__('lang.포인트 정책은 수시로 변경될 수 있으며,이를 별도로 통보하지 않습니다')); ?>

                                        </li><li> <?php echo e(__('lang.포인트 획득을 위한 도배 및 어뷰징 등의 행위자는 통보없이 “포인트 몰수” 또는 “회원정지” 또는 “사이트 접근차단” 등의 조치를 받을 수 있습니다')); ?>

                                        </li><li> <?php echo e(__('lang.적립된 포인트는 사이트내 서비스를 이용하는 목적 이외의 어떠한 효력도 갖고 있지 않습니다')); ?>

                                        </li><li> <?php echo e(__('lang.회원가입시')); ?> <b>100</b> <?php echo e(__('lang.포인트 적립(1회), 로그인시')); ?>  <b>0</b> <?php echo e(__('lang.포인트 적립(매일), 쪽지발송시')); ?> <b>50</b> <?php echo e(__('lang.포인트 차감(매회)')); ?>

                                        </li></ol>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody><tr class="active">
                                                <th class="text-center text-vcenter"><?php echo e(__('lang.그룹명')); ?></th>
                                                <th class="text-center"><?php echo e(__('lang.보드명')); ?></th>
                                                <th class="text-center"><?php echo e(__('lang.읽기')); ?></th>
                                                <th class="text-center"><?php echo e(__('lang.쓰기')); ?></th>
                                                <th class="text-center"><?php echo e(__('lang.댓글')); ?></th>
                                            </tr>
                                            <tr>

                                                <th rowspan="2" class="text-center text-vcenter"><?php echo e(__('lang.공지사항')); ?></th>
                                                <td><a href="#"><?php echo e(__('lang.공지사항')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">1</td>
                                            </tr>
                                            <tr>
                                                <td><a href="#"></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                            </tr>
                                            <tr>

                                                <th rowspan="1" class="text-center text-vcenter"><?php echo e(__('lang.업소정보')); ?></th>
                                                <td><a href="#"><?php echo e(__('lang.업소정보')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">1</td>
                                            </tr>
                                            <tr>

                                                <th rowspan="1" class="text-center text-vcenter"><?php echo e(__('lang.업소후기')); ?></th>
                                                <td><a href="#"><?php echo e(__('lang.업체후기')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">20</td>
                                                <td class="text-center">5</td>
                                            </tr>
                                            <tr>

                                                <th rowspan="8" class="text-center text-vcenter"><?php echo e(__('lang.커뮤니티')); ?></th>
                                                <td><a href="#"><?php echo e(__('lang.가입인사(장터게시판을 변경)')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">400</td>
                                                <td class="text-center">10</td>
                                            </tr>
                                            <tr>
                                                <td><a href="#"><?php echo e(__('lang.자유게시판')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">10</td>
                                                <td class="text-center">2</td>
                                            </tr>
                                            <tr>
                                                <td><a href="#"><?php echo e(__('lang.질문게시판')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-10</td>
                                                <td class="text-center">2</td>
                                            </tr>
                                            <tr>
                                                <td><a href="#"><?php echo e(__('lang.언니들의 놀이터')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">10</td>
                                                <td class="text-center">5</td>
                                            </tr>
                                            <tr>
                                                <td><a href="#"><?php echo e(__('lang.벼룩시장/구인구직')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">5</td>
                                                <td class="text-center">5</td>
                                            </tr>
                                            <tr>
                                                <td><a href="#"><?php echo e(__('lang.실장놀이터')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">10</td>
                                                <td class="text-center">2</td>
                                            </tr>
                                            <tr>
                                                <td><a href="#"><?php echo e(__('lang.번개게시판')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">10</td>
                                                <td class="text-center">2</td>
                                            </tr>
                                            <tr>
                                                <td><a href="#"><?php echo e(__('lang.정보공유')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">20</td>
                                                <td class="text-center">5</td>
                                            </tr>
                                            <tr>

                                                <th rowspan="1" class="text-center text-vcenter"><?php echo e(__('lang.이벤트')); ?></th>
                                                <td><a href="#"><?php echo e(env('SITE_NAME')); ?> <?php echo e(__('lang.이벤트')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">1</td>
                                            </tr>
                                            <tr>

                                                <th rowspan="1" class="text-center text-vcenter"><?php echo e(__('lang.제휴문의')); ?></th>
                                                <td><a href="#"><?php echo e(__('lang.메모관리')); ?></a></td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                                <td class="text-center">-</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="h30"></div>
                            </div>
                        </div>
                </div>
            </div>
            </div>
            <div class = "col-md-3 hidden-xs">
                <?php echo $__env->make('layouts/right-side', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
    <script>
        $(function(){
            loading_stop();
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>