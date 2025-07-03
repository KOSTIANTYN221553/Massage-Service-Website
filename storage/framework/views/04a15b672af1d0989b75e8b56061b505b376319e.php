<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
    <?php echo e(env('SITE_NAME')); ?><?php echo e(__('lang.갤러리')); ?>

##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
    <!--page level css starts-->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/frontend/tabbular.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/animate/animate.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/frontend/jquery.circliful.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/owl_carousel/css/owl.carousel.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/vendors/owl_carousel/css/owl.theme.css')); ?>">

    <!--end of page level css-->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <?php $user = Sentinel::getuser(); ?>
    <div class="container ">
        <?php if(isset($page_title)): ?>
        <div class = "row">
            <div class = "col-md-12 col-xs-12 page-title-wrapper">
                <span class = ""> <?php echo e($page_title); ?></span>
            </div>
        </div>
        <?php endif; ?>
        <?php if(isset($notice_list)): ?>
        <?php $__currentLoopData = $notice_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href = "<?php echo e(url('/ebza_board/info/'.$item['id'])); ?>">
            <div class = "row page-title-wrapper">
                <div class = "col-md-10 margin-box border-right">
                    <span class ="badge-warning"><?php echo e(__('lang.공지')); ?></span>
                    <span><?php echo e(utf8_strcut(strip_tags($item['title']),150)); ?></span>
                </div>
                <div class = "col-md-2 hidden-xs text-right"><span class = "pr-10 border-right"><?php echo e($item['user']['nickname']); ?></span> <span class = "pl-10"><?php echo e(getMsgTimeStr($item['created_at'])); ?></span></div>
            </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <?php $user_info = getLoginUserInfo();?>

        <div class = "row ">
            <div class = "col-md-9 col-xs-12 mt-10">
                <div class="row text-center">
                    <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-md-3 col-sm-5 profile " >
                        <div class="thumbnail bg-white relative">
                            <?php if(Sentinel::check() && ($user_info['type']*1 == 99 || $user_info['id']*1 == $item['user']['id']*1) ): ?>
                            <a class = "board-trash hidden" href = "javascript:void(0)" onclick = "delItem(this)" data-id = "<?php echo e($item['id']); ?>" ><i class = "fa fa-trash"></i></a>
                            <a class = "board-write hidden" href = "<?php echo e(url('ebza_board/write/'.$item['id'])); ?>" ><i class = "fa fa-pencil"></i></a>
                            <?php endif; ?>
                            <a href = "<?php echo e(url('/ebza_board/info/'.$item['id'])); ?>">
                                <img class = "same-img" src="<?php echo e(correctImgPath($item['img'])); ?>" alt="team-image" class="img-responsive" onerror="noExitImg(this)">
                            </a>
                            <div class="caption color-white">
                                <b class = "color-white">
                                    <img onerror = "noExitImg(this)" style="width:20px !important;" src="<?php echo e(url($item['level_icon'])); ?>" <?php if(isset($user['id']) && $item['user']['id']*1 != $user['id']*1): ?> onclick = "menuItemClick1(this)" <?php endif; ?>>
                                    <span class = "cursor" <?php if(isset($user['id']) && $item['user']['id']*1 != $user['id']*1): ?> onclick = "menuItemClick1(this)" <?php else: ?>  onclick = "userOnlyWrite(this)" <?php endif; ?> data-user-id ="<?php echo e($item['user_id']); ?>"><?php echo e(utf8_strcut(strip_tags($item['user']['nickname']), 30)); ?></span>
                                    <ul class = "td-click-menu hidden">
                                        <li><a href = "javascript:void(0);" onclick = "showSendNoteDlg(this)" data-user-id = "<?php echo e($item['user_id']); ?>"  ><?php echo e(__('lang.쪽지보내기')); ?></a></li>
                                        <li><a href = "javascript:void(0);" onclick = "showUserInfoDlg(this)" data-user-id = "<?php echo e($item['user_id']); ?>" ><?php echo e(__('lang.회원정보')); ?></a></li>
                                        <li><a href = "javascript:void(0);" onclick = "userOnlyWrite(this)" data-user-id ="<?php echo e($item['user_id']); ?>"><?php echo e(__('lang.작성게시글 보기')); ?></a></li>
                                    </ul>
                                </b>
                                <p class="content color-white"> <?php echo e(utf8_strcut(strip_tags($item['title']), 30)); ?></p>
                                <div class="divide">
                                    <div class = "row mt-10">
                                        <div class = "col-md-6 col-xs-6">
                                            <a href="<?php echo e(url('/ebza_board/info/'.$item['id'])); ?>" class="divider">
                                                <i class="fa fa-eye"></i><span class = "ml-5"><?php echo e($item['view_count']); ?></span>
                                            </a>
                                        </div>
                                        <div class = "col-md-6 col-xs-6">
                                            <a href="<?php echo e(url('/ebza_board/info/'.$item['id'])); ?>" class="divider">
                                                <i class="fa fa-comment"></i><span class = "ml-5"><?php echo e($item['reply_count']); ?></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class = "row">
                    <div class = "col-md-8 text-left col-xs-12">
                        <form id = "searchForm" action = "<?php echo e(url('ebza_board')); ?>" method = "post">
                            <input type = "hidden" name ="_token" value ="<?php echo e(csrf_token()); ?>"/>
                            <input type = "hidden" name = "page" value = "<?php echo e($pageParam['pageNo']); ?>"/>
                            <input type = "hidden" name = "user_id" value = "<?php echo e($user_id); ?>"/>
                            <div class = "row">
                                <div class = "col-md-6 mt-10 mb-10" style = "margin-top:8px;">
                                    <select class = "form-control search-select radius-0" name = "search_type" style ="height:38px;">
                                        <option value ="getUserNickname(user_id)" <?php if($search_type == 'getUserNickname(user_id)'): ?> selected <?php endif; ?>><?php echo e(__('lang.닉네임')); ?></option>
                                        <option value ="title" <?php if($search_type == 'title'): ?> selected <?php endif; ?>><?php echo e(__('lang.제목')); ?></option>
                                        <option value ="title&content" <?php if($search_type == 'title&content'): ?> selected <?php endif; ?>><?php echo e(__('lang.제목')); ?>&<?php echo e(__('lang.내용')); ?></option>
                                        <option value ="reply" <?php if($search_type == 'reply'): ?> selected <?php endif; ?>><?php echo e(__('lang.댓글')); ?></option>
                                    </select>
                                </div>
                                <div class = "col-md-6 mt-10 mb-10" style = "display:table;margin-top:8px;">
                                    <input type = "text" class = "form-control search-input radius-0"  style ="height:38px;" name = "search_title" value ="<?php echo e($search_title); ?>" placeholder ="<?php echo e(__('lang.검색어를 입력해주세요')); ?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default radius-0" type="button" onclick = "searchData(0)" style = "background: black;color: white; height:38px;">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class = "col-md-4 text-right mt-10 col-xs-12" style = "margin-top:17px;">
                        <?php if(Sentinel::check()): ?>
                            <a class = "color-white write-a btn-danger border-none"  href = "<?php echo e(url("ebza_board/write/0")); ?>" style = "color:white;"><?php echo e(__('lang.글쓰기')); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
                <div class = "text-center " style = "margin-top:10px;">
                    <?php echo $__env->make("layouts/pagination", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>

            <div class = "col-md-3 hidden-xs">
                <?php echo $__env->make('layouts/right-side', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    </div>
    <!-- //Container End -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
    <!-- page level js starts-->
    <!--page level js ends-->
    <script>
        function userOnlyWrite(obj){
            var user_id = $(obj).attr("data-user-id");
            $("#searchForm input[name='page']").val("0");
            $("#searchForm input[name='user_id']").val(user_id);
            $("#searchForm").submit();
        }

        $(function(){
           $(".thumbnail").hover(function(){
                $(this).find(".board-trash").removeClass("hidden");
                $(this).find(".board-write").removeClass("hidden");
           }, function(){
               $(this).find(".board-trash").addClass("hidden");
               $(this).find(".board-write").addClass("hidden");
           });

        });

        function  delItem(obj){
            var id = $(obj).attr("data-id");
            confirmMsg("<?php echo e(__('lang.정말 삭제하겟습니까?')); ?>", function(){
                setTimeout(function(){
                    var param = new Object();
                    param._token = _token;
                    param.id = id;
                    var url = "<?php echo e(url("/ebza_board/deleteInfo")); ?>";
                    loading_start();
                    $.post(url, param, function(data){
                        if(data.status == "1"){
                            successMsg("<?php echo e(__('lang.삭제가 성공하었습니다.')); ?>", function(){
                                window.location.reload();
                            });
                        }else{
                            loading_stop();
                            errorMsg(data.msg);
                        }
                    }, "json");
                }, 500);
            });
        }

        function searchData(page) {
            $("#searchForm input[name='page']").val(page);
            $("#searchForm").submit();
        }

        $(function(){
            var url = $("#searchForm").attr("action")+"?"+$("#searchFrm").serialize();
            setPageUrl(url);
        });

        $(function(){

               $(".same-img").each(function(){
                   $(this).css("height", $(this).width()+"px");
               });

               loading_stop();


        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>