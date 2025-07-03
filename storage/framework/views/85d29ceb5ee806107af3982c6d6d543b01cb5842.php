<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
<?php echo e($board_type_str); ?>

##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
    <!--page level css starts-->
    <!--end of page level css-->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <div class="container mt-10">
        <?php if(isset($page_title)): ?>
            <div class = "row">
                <div class = "col-md-12 col-xs-12 page-title-wrapper">
                    <span class = ""> <?php echo e($page_title); ?></span>
                </div>
            </div>
        <?php endif; ?>
        <?php if(isset($notice_list)): ?>
            <?php $__currentLoopData = $notice_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href = "<?php echo e(url('/board_info/'.$item['id'])); ?>">
                    <div class = "row page-title-wrapper">
                        <div class = "col-md-10 margin-box border-right">
                            <span class ="badge-warning"><?php echo e(__('lang.공지')); ?></span>
                            <span><?php echo e(utf8_strcut(strip_tags($item['title']),150)); ?></span>
                        </div>
                        <div class = "col-md-2 text-right hidden-xs"><span class = "pr-10 border-right"><?php echo e($item['user']['nickname']); ?></span> <span class = "pl-10"><?php echo e(getMsgTimeStr($item['created_at'])); ?></span></div>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <?php $user_info = getLoginUserInfo();?>
        <div class ="row">
            <div class = "col-md-9 col-xs-12">
                <?php if(isset($category_list)): ?>
                    <div class="row">
                        <div class = "col-md-12 col-xs-12 margin-box">
                            <ul class = "category_list">
                                <?php $__currentLoopData = $category_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class = "cursor <?php if($item['id']*1 == $category_id*1): ?> active <?php endif; ?>" onclick = "changeCategoryItem(this)" data-id = "<?php echo e($item['id']); ?>"> <?php echo e($item['title']); ?>(<?php echo e($item['cnt']); ?>)</li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="row">
                    <div class = "col-md-12">
                        <div class = "table-scrollable"  style = "overflow: visible;">
                            <table class = "table  table-striped  table-board">
                                <thead>
                                    <tr>
                                        <th class = "text-center" style = "width:3%">No</th>
                                        <th class = "text-center" style = "width:35%;"><?php echo e(__('lang.제목')); ?></th>
                                        <th class = "text-center" style = "width:15%;"><?php echo e(__('lang.닉네임')); ?></th>
                                        <th class = "text-center hidden-xs" style = "width:10%;"><span class ="hidden-xs"><?php echo e(__('lang.조회수')); ?></span></th>
                                        <th class = "text-center hidden-xs" style = "width:12%;"><?php echo e(__('lang.날짜')); ?></th>
                                        <th class ="hidden-xs" style = "width:10%;"><span class ="hidden-xs"><?php echo e(__('lang.관리')); ?></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class = "cursor">
                                        <td class = "text-center" onclick = "detailView(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e($key+$pageParam['startNumber']+1); ?></td>
                                        <td class = "text-left" onclick = "detailView(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e(utf8_strcut(strip_tags($item['title']),30)); ?>

                                            <img src="<?php echo e(correctImgPath($item['img'])); ?>" alt="team-image" style = "width:10px; height:10px;margin-bottom: 10px;margin-left: 10px;" onerror="noExitImgHidden(this)"></td>
                                        <td class = "text-center cursor relative menu-click-wrapper" data-id = "<?php echo e($item['id']); ?>">
                                            <a href = "javascript:void(0)" <?php if(isset($user_info['id']) && $item['user_id']*1 != $user_info['id']): ?> onclick = "menuItemClick1(this)" <?php else: ?> onclick = "userOnlyWrite(this)" <?php endif; ?> data-user-id ="<?php echo e($item['user_id']); ?>" >
                                                <img onerror = "noExitImg(this)" style="width:20px !important;" src="<?php echo e(url($item['level_icon'])); ?>">
                                                <?php echo e($item['user']['nickname']); ?>

                                            </a>
                                            <ul class = "td-click-menu hidden">
                                                <li><a href = "javascript:void(0);" onclick = "showSendNoteDlg(this)" data-user-id = "<?php echo e($item['user_id']); ?>"  ><?php echo e(__('lang.쪽지보내기')); ?></a></li>
                                                <li><a href = "javascript:void(0);" onclick = "showUserInfoDlg(this)" data-user-id = "<?php echo e($item['user_id']); ?>" ><?php echo e(__('lang.회원정보')); ?></a></li>
                                                <li><a href = "javascript:void(0);" onclick = "userOnlyWrite(this)" data-user-id ="<?php echo e($item['user_id']); ?>"><?php echo e(__('lang.작성게시글 보기')); ?></a></li>
                                            </ul>
                                        </td>
                                        <td class = "text-center hidden-xs" onclick = "detailView(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e($item['view_count']); ?></td>
                                        <td class = "text-center hidden-xs" onclick = "detailView(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e(getMsgTimeStr($item['created_at'])); ?></td>
                                        <td class ="hidden-xs" >
                                            <?php if(Sentinel::check() && ($user_info['type']*1 == 99 || $user_info['id']*1 == $item['user']['id']*1) ): ?>
                                                <a class = " " href = "javascript:void(0)" onclick = "delItem(this)" data-id = "<?php echo e($item['id']); ?>" ><i class = "fa fa-trash"></i></a>
                                                <a class = "" href = "<?php echo e(url("board/write/".$item['id']."/".$board_type)); ?>" ><i class = "fa fa-pencil"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($list) == 0): ?>
                                    <tr>
                                        <td colspan = "7"><?php echo e(__('lang.자료가 없습니다.')); ?></td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class = "row">
                            <div class = "col-md-8 text-left col-xs-12">
                                <form id = "searchForm" action = "<?php echo e(url("board/".$board_type)); ?>"  method = "post">
                                    <input type = "hidden" name ="_token" value ="<?php echo e(csrf_token()); ?>"/>
                                    <input type = "hidden" name = "page" value = "<?php echo e($pageParam['pageNo']); ?>"/>
                                    <input type = "hidden" name = "user_id" value = "<?php echo e($user_id); ?>"/>
                                    <input type = "hidden" name = "category_id" value = "<?php echo e($category_id); ?>"/>
                                    <div class = "row">
                                        <div class = "col-md-6 mt-10 mb-10" style = "margin-top:8px;">
                                            <select class = "form-control search-select radius-0" name = "search_type" style = "height:38px;">
                                                <option value ="getUserNickname(user_id)" <?php if($search_type == 'getUserNickname(user_id)'): ?> selected <?php endif; ?>><?php echo e(__('lang.닉네임')); ?></option>
                                                <option value ="title" <?php if($search_type == 'title'): ?> selected <?php endif; ?>><?php echo e(__('lang.제목')); ?></option>
                                                <option value ="title&content" <?php if($search_type == 'title&content'): ?> selected <?php endif; ?>><?php echo e(__('lang.제목')); ?>&<?php echo e(__('lang.내용')); ?></option>
                                                <option value ="reply" <?php if($search_type == 'reply'): ?> selected <?php endif; ?>><?php echo e(__('lang.댓글')); ?></option>
                                            </select>
                                        </div>
                                        <div class = "col-md-6 mt-10 -mb-10" style = "display:table; margin-top:8px;">
                                            <input type = "text" class = "form-control search-input radius-0" style ="height:38px;" name = "search_title" value ="<?php echo e($search_title); ?>" placeholder ="<?php echo e(__('lang.검색어를 입력해주세요')); ?>">
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
                                    <a class = "color-white write-a btn-danger border-none"  href = "<?php echo e(url("board/write/0/".$board_type)); ?>" style = "color:white;"><?php echo e(__('lang.글쓰기')); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class = "text-center relative" style = "margin-top:10px;">
                            <?php echo $__env->make("layouts/pagination", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "col-md-3 hidden-xs">
                <?php echo $__env->make('layouts/right-side', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    </div>
    <?php echo $__env->make("dlg/crop_dlg", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- //Container End -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('footer_scripts'); ?>
    <script>
        function userOnlyWrite(obj){
            var user_id = $(obj).attr("data-user-id");
            $("#searchForm input[name='page']").val("0");
            $("#searchForm input[name='user_id']").val(user_id);
            $("#searchForm").submit();
        }

        function  delItem(obj){
            var id = $(obj).attr("data-id");
            confirmMsg("<?php echo e(__('lang.정말 삭제하겟습니까?')); ?>", function(){
                setTimeout(function(){
                    var param = new Object();
                    param._token = _token;
                    param.id = id;
                    var url = "<?php echo e(url('/board/deleteInfo')); ?>";
                    loading_start();
                    $.post(url, param,function(data){
                        if(data.status=="1"){
                            successMsg("<?php echo e(__('lang.삭제가 성공하었습니다.')); ?>", function(){
                                window.location.reload();
                            });
                        }
                    }, "json");
                }, 500);
            })
        }

        function changeCategoryItem(obj){
            loading_start();
            var category_id = $(obj).attr("data-id");
            $("#searchForm input[name='page']").val("0");
            $("#searchForm input[name='category_id']").val(category_id);
            $("#searchForm").submit();
        }

        $(function(){
            var url = $("#searchForm").attr("action")+"?"+$("#searchFrm").serialize();
            setPageUrl(url);
            loading_stop();
        });
        function searchData(page) {
            $("#searchForm input[name='page']").val(page);
            $("#searchForm").submit();
        }

        function  detailView(obj){
            var id = $(obj).attr("data-id");
            window.location.href = "<?php echo e(url("/board_info")); ?>/"+id;
        }

        $("#reviewForm textarea[name='description']").ckeditor({
            height: '200px'
        });

        $("#reviewForm").validate({
            rules: {
                shop_id: "required",
                title: "required",
                description: "required",
            },

            messages: {

            },
            errorPlacement: function (error, element) {
                if($(element).closest('div').children().filter("div.error-div").length < 1)
                    $(element).closest('div').append("<div class='error-div'></div>");
                $(element).closest('div').children().filter("div.error-div").append(error);
            },
            submitHandler: function(form){
                var url = $(form).attr("action");
                var fdata = new FormData($("#reviewForm")[0]);
                fdata.append("description", $("#reviewForm textarea[name='description']").val());
                loading_start();
                $.ajax({
                    url: url,
                    type: 'post',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: fdata,
                    dataType:"json",
                    success: function (data) {

                        if (data.status == '1') {
                            successMsg("<?php echo e(__('lang.수정이 성공하였습니다.')); ?>", function(){
                                window.location.reload();
                            });
                        } else {
                            loading_stop();
                            errorMsg(data.msg);
                        }
                    },
                    error: function() {
                        errorMsg("<?php echo e(__('lang.서버에서 오류가 발생하였습니다.')); ?>");
                    }
                })

            }

        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>