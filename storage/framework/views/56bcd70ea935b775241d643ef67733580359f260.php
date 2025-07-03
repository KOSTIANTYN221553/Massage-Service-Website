<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
<?php echo e(utf8_strcut($info['title'],10)); ?>

##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
    <!--page level css starts-->
    <!--end of page level css-->
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <?php $user = Sentinel::getuser(); ?>
    <div class="container mt-10">
        <div class = "row">
            <div class = "col-md-9 col-xs-12 mt-10">
                <div class="row content">
                    <!-- Business Deal Section Start -->
                    <div class="col-sm-12 col-md-12">
                        <div class=" thumbnail featured-post-wide img">
                            <div class = "row">
                                <div class = "col-md-12 p-10">
                                    <h2 class="color-white marl12 font-20"><?php echo e($info['title']); ?></h2>
                                </div>
                            </div>
                            <div class = "row detail-header">
                                <div class = "col-md-9 relative">
                                    <img onerror = "noExitImg(this)" style="width:20px !important;" src="<?php echo e(url($info['level_icon'])); ?>" <?php if(isset($user['id']) && $info['user']['id']*1 != $user['id']*1): ?> onclick = "menuItemClick1(this)" <?php endif; ?>>
                                    <span class = "text-white-gray ml-5 cursor font-18" <?php if(isset($user['id']) && $info['user']['id']*1 != $user['id']*1): ?> onclick = "menuItemClick1(this)" <?php endif; ?>><?php echo e(isset( $info['user']['nickname']) ? $info['user']['nickname'] :""); ?></span>
                                    <ul class = "td-click-menu hidden">
                                        <li><a href = "javascript:void(0);" onclick = "showSendNoteDlg(this)" data-user-id = "<?php echo e($info['user']['id']); ?>"  ><?php echo e(__('lang.쪽지보내기')); ?></a></li>
                                        <li><a href = "javascript:void(0);" onclick = "showUserInfoDlg(this)" data-user-id = "<?php echo e($info['user']['id']); ?>" ><?php echo e(__('lang.회원정보')); ?></a></li>
                                    </ul>
                                    <span class = " ml-5 mr-5 text-white-gray" >|</span>
                                    <i class="fa fa-eye text-white-gray ml-10"></i><span class = "text-white-gray ml-5 cursor"><?php echo e($info['view_count']); ?></span>
                                    <i class="fa fa-comment text-white-gray ml-20"></i><span class = "text-white-gray ml-5 cursor"><?php echo e($info['reply_count']); ?></span>
                                    <a class = "ml-20" href = "javascript:void(0)" data-id = "<?php echo e($info['id']); ?>" <?php if(Sentinel::check()): ?> data-user-id = "1" <?php else: ?> data-user-id = "0"<?php endif; ?> onclick = "setFavorBoard(this)">
                                        <i class = "fa <?php if($is_favor*1 ==0): ?> fa-thumbs-o-up <?php else: ?> fa-thumbs-up <?php endif; ?>"></i> <span><?php echo e($info['favor_count']); ?></span>
                                    </a>
                                </div>
                                <div class = "col-md-3 text-right">
                                    <i class="fa fa-clock-o text-white-gray"></i><span class = "text-white-gray cursor"> <?php echo e(substr($info['created_at'],0,16)); ?> </span>
                                </div>
                            </div>
                            <?php if($info['img'] != ''): ?>
                            <div class = "row mt-10 mb-10">
                                <div class = "col-md-12 text-center">
                                     <img onerror = "noExitImg(this)" src="<?php echo e(correctImgPath($info['img'])); ?>" class="img-responsive  head-img" style = "display:inline-block;" alt="Image">
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="the-box no-border blog-detail-content">
                                <p class="text-justify font-18 color-white word-break">
                                    <?php echo $info['description']; ?>

                                </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <?php if($info['user_id']*1 == $user['id']*1): ?>
                                <a class = "color-white write-a1 btn-danger border-none"  href = "<?php echo e(url('board/write/'.$info['id'].'/'.$info['board_type'])); ?>" style = "color:white;"><?php echo e(__('lang.수정')); ?></a>
                                <a class = "color-white write-a1 btn-danger border-none"  href = "javascript:void(0)" onclick = "delItem(this)" data-id = "<?php echo e($info['id']); ?>" style = "color:white;"><?php echo e(__('lang.삭제')); ?></a>
                            <?php endif; ?>
                            <a class = "color-white write-a1 btn-danger border-none"  href = "javascript:void(0)" onclick="goBack()" style = "color:white; margin-right:10px;"><?php echo e(__('lang.목록으로')); ?></a>
                        </div>
                        <h3 class="comments"><?php echo e($info['reply_count']); ?>  <?php echo e(__('lang.댓글목록')); ?></h3><br />
                        <ul class="media-list">
                            <?php $__currentLoopData = $reply_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="media">
                                    <div class="media-body">
                                        <h4 class="media-heading">
                                            <i>
                                                <img onerror = "noExitImg(this)" style="width:20px !important;" src="<?php echo e(url($reply['user']['user_level']['icon'])); ?>" <?php if(isset($user['id']) && $reply['user']['id']*1 != $user['id']*1): ?> onclick = "menuItemClick1(this)" <?php endif; ?>>
                                                <span class = "cursor" <?php if(isset($user['id']) && $reply['user']['id']*1 != $user['id']*1): ?> onclick = "menuItemClick1(this)" <?php endif; ?>><?php echo e($reply['user']['nickname']); ?></span>
                                                <ul class = "td-click-menu hidden">
                                                    <li><a href = "javascript:void(0);" onclick = "showSendNoteDlg(this)" data-user-id = "<?php echo e($reply['user']['id']); ?>"  ><?php echo e(__('lang.쪽지보내기')); ?></a></li>
                                                    <li><a href = "javascript:void(0);" onclick = "showUserInfoDlg(this)" data-user-id = "<?php echo e($reply['user']['id']); ?>" ><?php echo e(__('lang.회원정보')); ?></a></li>
                                                </ul>
                                            </i>
                                            <a href = "javascript:void(0)" class = "ml-10" style = "font-size:14px;" onclick = "showReplyReplyForm(this)" data-id = "0"> <?php echo e(__('lang.답글작성')); ?></a>
                                            <?php if($user['id']*1 == $reply['user_id']*1): ?>
                                                <a href = "javascript:void(0)" class = "ml-10" style = "font-size:14px;" onclick = "showReplyForm(this)"> <?php echo e(__('lang.댓글변경')); ?></a>
                                                <a href = "javascript:void(0)" class = "ml-10" style = "font-size:14px;" onclick = "deleteReply(this)" data-id = "<?php echo e($reply['id']); ?>"> <?php echo e(__('lang.댓글삭제')); ?></a>
                                            <?php endif; ?>
                                        </h4>
                                        <form class = "reply_form hidden" method = "method" action="<?php echo e(url("board/ajaxSaveReply")); ?>" accept-charset="UTF-8" class="bf" enctype="multipart/form-data">
                                            <input type = "hidden" name = "id" value = "<?php echo e($reply['id']); ?>"/>
                                            <input type = "hidden" name ="_token" value = "<?php echo e(csrf_token()); ?>"/>
                                            <div class="form-group">
                                                <textarea class="form-control input-lg no-resize" required="required" style="height: 200px" placeholder="<?php echo e(__('lang.댓글내용을 입력해주세요.')); ?>" name="description" cols="50" rows="10"><?php echo e($reply['description']); ?></textarea>
                                            </div>
                                            <div class="form-group ">
                                                <button type="button" class="btn btn-md btn-danger border-none radius-0" onclick = "submitReplyUpdateForm(this)">
                                                    <i class="livicon" data-name="comment" data-c="#FFFFFF" data-hc="#FFFFFF" data-size="18" data-loop="true"></i>
                                                    <?php echo e(__('lang.변경')); ?>

                                                </button>
                                            </div>
                                        </form>
                                        <div>
                                            <?php echo $reply['description']; ?>

                                        </div>
                                        <p class="color-white">
                                            <small class = "mr-5"> <?php echo e($reply['created_at']); ?> </small>
                                            <i class = "fa fa-comment "></i><span class="ml-5"><?php echo e(count($reply['reply'])); ?></span>
                                        </p>
                                        <?php $__currentLoopData = $reply['reply']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply_reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class = "comment-rect">
                                                <h4 class="media-heading">
                                                    <i><?php echo e(__('lang.답글')); ?> :
                                                        <img onerror = "noExitImg(this)" style="width:20px !important;" src="<?php echo e(url($reply_reply['user']['user_level']['icon'])); ?>" <?php if(isset($user['id']) && $reply_reply['user']['id']*1 != $user['id']*1): ?> onclick = "menuItemClick1(this)" <?php endif; ?>>
                                                        <span class = "cursor" <?php if(isset($user['id']) && $reply_reply['user']['id']*1 != $user['id']*1): ?> onclick = "menuItemClick1(this)" <?php endif; ?>><?php echo e($reply_reply['user']['nickname']); ?></span>
                                                        <ul class = "td-click-menu hidden">
                                                            <li><a href = "javascript:void(0);" onclick = "showSendNoteDlg(this)" data-user-id = "<?php echo e($reply_reply['user']['id']); ?>"  ><?php echo e(__('lang.쪽지보내기')); ?></a></li>
                                                            <li><a href = "javascript:void(0);" onclick = "showUserInfoDlg(this)" data-user-id = "<?php echo e($reply_reply['user']['id']); ?>" ><?php echo e(__('lang.회원정보')); ?></a></li>
                                                        </ul>
                                                    </i>
                                                    <small class = "ml-10 text-white"> <?php echo e(substr($reply_reply['created_at'],0,10)); ?> </small>
                                                    <?php if($user['id']*1 == $reply_reply['user_id']*1): ?>
                                                        <a href = "javascript:void(0)" class = "ml-10" style = "font-size:14px;" onclick = "showReplyReplyForm(this)" data-id = "<?php echo e($reply_reply['id']); ?>"><?php echo e(__('lang.답글변경')); ?></a>
                                                        <a href = "javascript:void(0)" class = "ml-10" style = "font-size:14px;" onclick = "deleteReply(this)" data-id = "<?php echo e($reply_reply['id']); ?>"><?php echo e(__('lang.답글삭제')); ?></a>
                                                    <?php endif; ?>
                                                </h4>
                                                <p>
                                                    <?php echo e($reply_reply['description']); ?>

                                                </p>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <div class = "reply_reply_form-rect hidden">
                                        <form class = "reply_reply_form" method = "post" action = "<?php echo e(url('/board/ajaxSaveReply')); ?>" accept-charset="UTF-8" class="bf" enctype="multipart/form-data">
                                            <input type = "hidden" name = "board_id" value = "<?php echo e($info['id']); ?>"/>
                                            <input type = "hidden" name = "parent_reply_id" value = "<?php echo e($reply['id']); ?>"/>
                                            <input type = "hidden" name = "id" value = "0"/>
                                            <input type = "hidden" name = "_token" value ="<?php echo e(csrf_token()); ?>"/>
                                            <div class="form-group <?php echo e($errors->has('description') ? 'has-error' : ''); ?>">
                                                <textarea class="form-control input-lg no-resize" required="required" style="height: 200px" placeholder="<?php echo e(__('lang.답글내용을 입력해주세요.')); ?>" name="description" cols="50" rows="10"></textarea>
                                                <span class="help-block"><?php echo e($errors->first('description', ':message')); ?></span>
                                            </div>
                                            <div class="form-group ">
                                                <button type="button" class="btn btn-danger border-none radius-0 btn-md" onclick = "submitReplyForm(this)">
                                                    <i class="livicon" data-name="comment" data-c="#FFFFFF" data-hc="#FFFFFF" data-size="18" data-loop="true"></i>
                                                    <?php echo e(__('lang.등록')); ?>

                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        <?php if(Sentinel::check()): ?>
                            <div class = "comment-write-rect">
                                <h3><?php echo e(__('lang.댓글작성')); ?></h3>
                                <form method="POST" id = "replyForm"  action="<?php echo e(url("/board/ajaxSaveReply")); ?>" accept-charset="UTF-8" class="bf" enctype="multipart/form-data">
                                    <input type = "hidden" name ="_token" value = "<?php echo e(csrf_token()); ?>"/>
                                    <input type = "hidden" name = "board_id" value = "<?php echo e($info['id']); ?>"/>
                                    <input type = "hidden" name = "parent_reply_id" value = "0"/>
                                    <div class="form-group <?php echo e($errors->has('comment') ? 'has-error' : ''); ?>">
                                        <textarea class="form-control input-lg no-resize" required="required" style="height: 200px" placeholder="<?php echo e(__('lang.댓글을 입력해주십시오.')); ?>" name="description" cols="50" rows="10"></textarea>
                                        <span class="help-block"><?php echo e($errors->first('comment', ':message')); ?></span>
                                    </div>
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-danger border-none radius-0 btn-md">
                                            <i class="livicon" data-name="comment" data-c="#FFFFFF" data-hc="#FFFFFF" data-size="18" data-loop="true"></i>
                                            <?php echo e(__('lang.작성')); ?>

                                        </button>
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="row mt-10">
                    <div class = "col-md-12">
                        <div class = "table-scrollable">
                            <table class = "table  table-striped table-board">
                                <thead>
                                <tr>
                                    <th class = "text-center">No</th>
                                    <th class = "text-left"><?php echo e(__('lang.제목')); ?></th>
                                    <th class = "text-center"><?php echo e(__('lang.닉네임')); ?></th>
                                    <th class = "text-center hidden-xs"><?php echo e(__('lang.조회수')); ?></th>
                                    <th class = "text-center hidden"><?php echo e(__('lang.날짜')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class = "cursor">
                                        <td class = "text-center" onclick = "detailView(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e($key+$pageParam['startNumber']+1); ?></td>
                                        <td class = "text-left" onclick = "detailView(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e(utf8_strcut(strip_tags($item['title']),30)); ?><img onerror = "noExitImg(this)" src="<?php echo e(correctImgPath($item['img'])); ?>" alt="team-image" style = "width:10px; height:10px;margin-bottom: 10px;margin-left: 10px;"></td>
                                        <td class = "text-center relative"  data-id = "<?php echo e($item['id']); ?>">
                                            <img onerror = "noExitImg(this)" style="width:20px !important;" src="<?php echo e(url($item['level_icon'])); ?>" <?php if(isset($user['id']) && $item['user']['id']*1 != $user['id']*1): ?> onclick = "menuItemClick1(this)" <?php endif; ?>>
                                            <span class = "cursor" <?php if(isset($user['id']) && $item['user']['id']*1 != $user['id']*1): ?> onclick = "menuItemClick1(this)" <?php endif; ?>><?php echo e($item['user']['nickname']); ?></span>
                                            <ul class = "td-click-menu hidden">
                                                <li><a href = "javascript:void(0);" onclick = "showSendNoteDlg(this)" data-user-id = "<?php echo e($item['user']['id']); ?>"  ><?php echo e(__('lang.쪽지보내기')); ?></a></li>
                                                <li><a href = "javascript:void(0);" onclick = "showUserInfoDlg(this)" data-user-id = "<?php echo e($item['user']['id']); ?>" ><?php echo e(__('lang.회원정보')); ?></a></li>
                                            </ul>
                                        </td>
                                        <td class = "text-center hidden-xs" onclick = "detailView(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e($item['view_count']); ?></td>
                                        <td class = "text-center hidden" onclick = "detailView(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e(substr($item['created_at'], 11,5)); ?></td>
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
                    </div>
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
    <script>
        $(function(){
           loading_stop();
        });

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

        function setFavorBoard(obj){
            var user_id = $(obj).attr("data-user-id");
            if(user_id == "0"){
                errorMsg("<?php echo e(__('lang.먼저 로그인하십시오.')); ?>");
                return;
            }
            var url = "<?php echo e(url('board/setFavorBoard')); ?>";
            var param = new Object();
            param._token = _token;
            param.board_id = $(obj).attr("data-id");
            $.post(url, param, function(data){
                if(data.status =="1"){
                    if($(obj).find("i").hasClass("fa-thumbs-o-up")){
                        $(obj).find("i").removeClass("fa-thumbs-o-up");
                        $(obj).find("i").addClass("fa-thumbs-up");
                        var count_str = $(obj).find("span").text();
                        count_str = count_str.trim();
                        count_str = parseInt(count_str);
                        count_str++;
                        $(obj).find("span").text(count_str)
                    }else{
                        $(obj).find("i").addClass("fa-thumbs-o-up");
                        $(obj).find("i").removeClass("fa-thumbs-up");
                        var count_str = $(obj).find("span").text();
                        count_str = count_str.trim();
                        count_str = parseInt(count_str);
                        count_str--;
                        if(count_str <0){
                            count_str =0;
                        }
                        $(obj).find("span").text(count_str)
                    }
                }else{
                    errorMsg(data.msg);
                }
            }, "json");
        }

        function deleteReply(obj){
            confirmMsg("<?php echo e(__('lang.정말 삭제하겟습니까?')); ?>", function(){
                var id = $(obj).attr("data-id");
                var param = new Object();
                param._token = _token;
                param.id = id;
                var url = "<?php echo e(url("/board/deleteReply")); ?>";
                loading_start();
                $.post(url, param, function(data){
                    if(data.status == "1"){
                        successMsg("<?php echo e(__('lang.수정이 성공하였습니다.')); ?>", function(){
                            window.location.reload();
                        });
                    }else{
                        loading_stop();
                        errorMsg(data.msg);
                    }
                }, "json");
            });
        }

        function submitReplyUpdateForm(obj){
            var description = $(obj).closest("form").find("textarea[name='description']").val();
            if(description == ""){
                errorMsg("<?php echo e(__('lang.댓글을 입력해주십시오.')); ?>");
                return;
            }
            var url = $(obj).closest("form").attr("action");
            var fdata = new FormData($(obj).closest("form")[0]);
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
                    loading_stop();
                    errorMsg("<?php echo e(__('lang.서버에서 오류가 발생하였습니다.')); ?>");
                }
            })
        }

        function showReplyForm(obj){
            $(".reply_form").addClass("hidden");
            $(obj).parent().parent().find("form").removeClass("hidden");
            $(obj).parent().parent().find("form").next().addClass("hidden");
        }
        function showReplyReplyForm(obj){
            var id = $(obj).attr("data-id");
            var parent = $(obj).parent().parent().parent();
            if(id != "0"){
                parent = $(obj).parent().parent().parent().parent();
            }
            $(".reply_reply_form-rect").addClass("hidden");
            parent.find(".reply_reply_form-rect").removeClass("hidden");
            parent.find(".reply_reply_form-rect form input[name='id']").val(id);
            if(id == "0"){
                parent.find(".reply_reply_form-rect form textarea[name='description']").val("");

            }else{
                var description = $(obj).parent().parent().find("p").html();
                parent.find(".reply_reply_form-rect form textarea[name='description']").val(description.trim());

            }

        }

        function submitReplyForm(obj){
            var description = $(obj).closest("form").find("textarea[name='description']").val();
            if(description == ""){
                errorMsg("<?php echo e(__('lang.답글을 입력해주십시오.')); ?>");
                return;
            }
            var url = $(obj).closest("form").attr("action");
            var fdata = new FormData($(obj).closest("form")[0]);
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
                    loading_stop();
                    errorMsg("<?php echo e(__('lang.서버에서 오류가 발생하였습니다.')); ?>");
                }
            })
        }

        $("#replyForm").validate({
            rules: {
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
                var fdata = new FormData($("#replyForm")[0]);
                fdata.append("description", $("#replyForm textarea[name='description']").val());
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
                        loading_stop();
                        errorMsg("<?php echo e(__('lang.서버에서 오류가 발생하였습니다.')); ?>");
                    }
                })

            }

        });
        function  detailView(obj){
            var id = $(obj).attr("data-id");
            loading_start();
            window.location.href = "<?php echo e(url("/board_info")); ?>/"+id;
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>