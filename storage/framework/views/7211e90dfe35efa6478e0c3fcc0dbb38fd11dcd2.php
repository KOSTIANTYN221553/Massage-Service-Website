<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
    <?php echo e(__('lang.게시판내 카테고리')); ?>

    ##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header_styles'); ?>
    <link href="<?php echo e(asset('assets/css/pages/sortable.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="content-header">
        <h1><?php echo e(__('lang.카테고리추가')); ?></h1>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                           <?php echo e(__('lang.카테고리정보')); ?>

                        </h3>
                        <span class="pull-right">
                            <i class="glyphicon glyphicon-chevron-up clickable"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="control-label" for="name"><?php echo e(__('lang.분류명')); ?> :  <?php echo e($info['title']); ?></label>

                        </div>
                        <form  id = "categoryForm" action = "<?php echo e(url('/admin/board_type/ajaxBoardCategoryInfo')); ?>" method = "post">
                            <input type = "hidden" name = "_token" value = "<?php echo e(csrf_token()); ?>"/>
                            <input type = "hidden" name = "type_id" value = "<?php echo e($type_id); ?>"/>
                            <input type = "hidden" name = "board_type" value = "<?php echo e($board_type); ?>"/>
                            <input type = "hidden" name = "id" value = "0"/>
                            <div class="form-group">
                                <label class="control-label" for="name"><?php echo e(__('lang.카테고리이름')); ?> <button class = "btn btn-primary ml-10 btn-sm "  id = "btn" ><?php echo e(__('lang.추가')); ?></button> <button type = "button" onclick ="initCategoryForm()"  class = "btn btn-primary ml-10 btn-sm "   ><?php echo e(__('lang.취소')); ?></button></label>
                                <input id="name" name="title" type="text" placeholder="<?php echo e(__('lang.이름을 입력해주세요')); ?>" class="form-control" value = "">
                            </div>
                        </form>
                        <form  id = "infoForm1" action = "" method = "post">
                            <div class="form-group">
                                <label class="control-label" for="name"><?php echo e(__('lang.카테고리')); ?></label>
                            </div>
                            <div class="form-group">
                                <div class="dd" id="nestable_list_2">

                                </div>
                            </div>
                            <!-- Form actions -->
                            <div class="form-position">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-responsive btn-success btn-sm" onclick = "goBack()"><?php echo e(__('lang.리스트로 이동')); ?></button>
                                    <button type="button" class="btn btn-responsive btn-primary btn-sm" onclick = "updateCategory()"><?php echo e(__('lang.카테고리변경')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('footer_scripts'); ?>
    <script src="<?php echo e(asset('assets/vendors/nestable-list/jquery.nestable.js')); ?>" ></script>
    <script src="<?php echo e(asset('assets/vendors/html5sortable/html.sortable.js')); ?>" ></script>
<script>
    var update_category = 0;
    var tree_list ;

    function editCategory(obj){
        var id = $(obj).attr("data-id");
        var title = $(obj).attr("data-title");
        $("#categoryForm input[name='id']").val(id);
        $("#categoryForm input[name='title']").val(title);
        $("#categoryForm #btn").html("편집");

    }

    function initCategoryForm(){
        $("#categoryForm input[name='id']").val("");
        $("#categoryForm input[name='title']").val("");
        $("#categoryForm #btn").html("<?php echo e(__('lang.추가')); ?>");
    }

    function deleteCategory(obj){
        var id = $(obj).attr("data-id");
        confirmMsg("<?php echo e(__('lang.정말 삭제하겟습니까?')); ?>", function(){
            setTimeout(function(){
                var url = "<?php echo e(url('admin/board_type/deleteBoardCategory')); ?>";
                var param = new Object();
                param._token = _token;
                param.id = id;
                loading_start();
                $.post(url, param,function(data){
                    if(data.status == "1"){
                        refreshCategory();
                    }else{
                        loading_stop();
                        errorMsg(data.msg);
                    }
                }, "json");
            }, 500);
        });
    }
    function updateCategory(){
        var ret = checkCategory();
        if(ret.status == "0"){
            errorMsg(ret.msg);
            return;
        }
        var url = "<?php echo e(url('admin/board_type/update_category')); ?>";
        var param = new Object();
        param._token = _token;
        param.tree_list = JSON.stringify(tree_list);
        $.post(url, param, function(data){
            if(data.status == "1"){
                successMsg("<?php echo e(__('lang.수정이 성공하였습니다.')); ?>", function(){
                   refreshCategory();
                });
            }else{
                errorMsg(data.msg);
            }
        }, "json");

    }



    function checkCategory(){
        var ret = new Object();
        ret.status = "1";
        for(var i =0 ; i< tree_list.length ; i++){
            if(tree_list[i].children!=undefined){
                for(var j = 0; j < tree_list[i].children.length; j++) {
                    var obj = tree_list[i].children[j];
                    if (obj.children != undefined) {
                        ret.status = "0";
                        ret.msg = "최대로 하위분류는 2계단까지입니다.";
                    }
                }
            }
        }
        return ret;
    }
    var updateOutput = function (e) {
        var list = e.length ? e : $(e.target),
            output = list.data('output');
        if (window.JSON) {
            output.val(window.JSON.stringify(list.nestable('serialize'))); //, null, 2));
        } else {
            output.val('JSON browser support required for this demo.');
        }
        console.log(list.nestable('serialize'));
        tree_list = list.nestable('serialize');
        update_category = 1;
    };

    function refreshCategory(){
        var type_id = "<?php echo e($type_id); ?>";
        var board_type = "<?php echo e($board_type); ?>";
        initCategoryForm();
        var url = "<?php echo e(url('admin/board_type/getCategoryTree')); ?>";
        var param = new Object();
        param._token = _token;
        param.type_id = type_id;
        param.board_type = board_type;
        $.post(url, param, function(html){
           $("#nestable_list_2").html(html);
            $('#nestable_list_2').nestable({
                group: 1
            }).on('change', updateOutput);
            updateOutput($('#nestable_list_2').data('output', $('#nestable_list_2_output')));
            loading_stop();
        });
    }

    $(function() {
        refreshCategory();
        $("#categoryForm").validate({
            rules: {
                title: "required",
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
                var fdata = new FormData($("#categoryForm")[0]);
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
                               refreshCategory();
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
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>