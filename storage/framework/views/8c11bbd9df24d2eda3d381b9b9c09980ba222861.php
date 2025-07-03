<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
    <?php echo e(__('lang.업소후기')); ?>

    ##parent-placeholder-3c6de1b7dd91465d437ef415f94f36afc1fbc8a8##
<?php $__env->stopSection(); ?>


<?php $__env->startSection('header_styles'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/pages/tables.css')); ?>" />

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .form-group{
            margin-bottom: 0px;
        }
    </style>
    <section class="content-header">
        <!--section starts-->
        <h1><?php echo e(__('lang.업소후기')); ?></h1>
    </section>
    <!--section ends-->
    <?php $user = Sentinel::getuser(); ?>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary filterable">
                    <div class="panel-heading clearfix  ">
                        <div class="panel-title pull-left">
                            <div class="caption">
                                <i class="livicon" data-name="camera" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                <?php echo e(__('lang.업소후기')); ?>

                            </div>
                        </div>
                    </div>
                    <div class="panel-body ">
                        <form id = "searchFrm" action = "<?php echo e(url("admin/review")); ?>" method = "post">
                            <input type = "hidden" name = "page" value = "<?php echo e($pageParam['pageNo']); ?>"/>
                            <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>"/>
                            <input type = "hidden" name ="order_key" value = "<?php echo e($order_key); ?>"/>
                            <input type = "hidden" name ="order_val" value = "<?php echo e($order_val); ?>"/>
                            <input type = "hidden" id = "category_id1" value = "<?php echo e($category_id); ?>"/>
                            <div class="page_section_1 page_section search_section" id="search_filter_layout">
                                <div class="col-md-6">
                                    <div class = "row">
                                        <div class = "col-md-2">
                                            <label><?php echo e(__('lang.검색어')); ?></label>
                                        </div>
                                        <div class = "col-md-4">
                                            <select class="form-control" data-width="120px"  name = "search_key_type">
                                                <option value="review_board.title" <?php if($search_key_type =='review_board.title'): ?> selected <?php endif; ?>><?php echo e(__('lang.타이틀')); ?></option>
                                            </select>
                                        </div>
                                        <div class = "col-md-6">
                                            <div class="form-group input-group">
                                                <input type="text" class="form-control" name = "search" value = "<?php echo e($search); ?>" minlength = "2" placeholder=" <?php echo e(__('lang.검색어를 입력해 주세요(2자 이상)')); ?>">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class = "row">
                                        <div class = "col-md-2">
                                            <select class="form-control" data-width="120px"  name = "board_type" onchange="getCategoryList()">
                                                <option value="0"><?php echo e(__('lang.전체')); ?></option>
                                                <?php $__currentLoopData = $shop_type_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value = "<?php echo e($type['id']); ?>" <?php if($board_type*1 == $type['id']*1): ?> selected <?php endif; ?>><?php echo e($type['title']); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class = "col-md-3">
                                            <select class="form-control" data-width="120px"  name = "category_id">
                                                <option value="0"><?php echo e(__('lang.전체')); ?></option>
                                            </select>
                                        </div>
                                        <div class = "col-md-4">
                                            <button type="button" class="btn btn-info " onclick = "searchCustom()"><?php echo e(__('lang.검색')); ?></button>
                                            <button type="button" class="btn btn-info" onclick = "initFilter()"><?php echo e(__('lang.초기화')); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class = "clearfix"></div>
                        <div class = "table-responsive">
                            <table class="table table-bordered table-striped  table-hover">
                                <thead>
                                    <tr>
                                        <th style = "width:3%"><input type = "checkbox" class = "custom-checkbox" id = "allCheck"/></th>
                                        <th style = "width:8%" class = "sorting" aria-name = "shop_type.id"><?php echo e(__('lang.업소타입')); ?></th>
                                        <th style = "width:10%" class = "sorting" aria-name = "shop.title"><?php echo e(__('lang.업소이름')); ?></th>
                                        <th style = "width:20%" class = "sorting" aria-name = "review_board.title"><?php echo e(__('lang.제목')); ?></th>
                                        <th style = "width:35%" class = "sorting" aria-name = "review_board.description"><?php echo e(__('lang.내용')); ?></th>
                                        <th style = "width:7%" class = "sorting" aria-name = "user.nickname"><?php echo e(__('lang.작성자')); ?></th>
                                        <th style = "width:7%" class = "sorting" aria-name = "review_board.created_at"><?php echo e(__('lang.날짜')); ?></th>
                                        <th  style = "width:5%"  ><?php echo e(__('lang.보기')); ?></th>
                                        <?php if($user['type']*1 == 99): ?>
                                        <th><?php echo e(__('lang.수정')); ?></th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><input type = "checkbox" class = "custom-checkbox" value = "<?php echo e($item['id']); ?>"></td>
                                        <td  class  ="cursor" onclick = "viewDetail(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e($item['shop_type_title']); ?></td>
                                        <td  class  ="cursor" onclick = "viewDetail(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e($item['shop_title']); ?></td>
                                        <td  class  ="cursor" onclick = "viewDetail(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e($item['title']); ?></td>
                                        <td  class  ="cursor" onclick = "viewDetail(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e(utf8_strcut(strip_tags($item['description']), 30)); ?></td>
                                        <td  class  ="cursor" onclick = "viewDetail(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e($item['user_nickname']); ?></td>
                                        <td  class  ="cursor" onclick = "viewDetail(this)" data-id = "<?php echo e($item['id']); ?>"><?php echo e($item['created_at']); ?></td>
                                        <td  class  ="cursor" onclick = "viewDetail(this)" data-id = "<?php echo e($item['id']); ?>">
                                            <span class = "float-left">
                                                <i class = "fa fa-eye"></i><span class = "ml-5"><?php echo e($item['view_count']); ?></span>
                                            </span>
                                                        <span class = "float-right">
                                                <i class = "fa fa-comment"></i><span class = "ml-5"><?php echo e($item['reply_count']); ?></span>
                                            </span>
                                        </td>
                                        <?php if($user['type']*1 == 99): ?>
                                        <td>
                                            <a class = "btn btn-danger" href = "<?php echo e(url("admin/review/info/".$item['id'])); ?>"><?php echo e(__('lang.수정')); ?></a>
                                        </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($list) == 0): ?>
                                    <tr>
                                        <td colspan = "9"><?php echo e(__('lang.자료가 없습니다.')); ?></td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class = "table-responsive">
                            <div class = "col-md-12 text-right">
                                <?php echo $__env->make("admin.layouts.pagination", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </div>
                        </div>
                        <div class = "table-responsive">
                            <div class = "col-md-12 text-left">
                                <?php if($user['type']*1 == 99): ?>
                                <button type = "button" class = "btn btn-primary" onclick = "selItemDelete()"><?php echo e(__('lang.선택삭제')); ?></button>
                                <a type = "button" class = "btn btn-primary float-right" href = "<?php echo e(url('admin/review/info/0')); ?>"><i class = "fa fa-plus"></i><?php echo e(__('lang.글쓰기')); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- content -->

<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer_scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/pages/admin/review.js')); ?>" ></script>
    <script>
        $(function(){
            getCategoryList();
        });

        function viewDetail(obj){
            var id = $(obj).attr("data-id");
            var url = "<?php echo e(url('admin/review/view')); ?>/"+id;
            loading_start();
            window.location.href = url;
        }

        function  getCategoryList(){
            var shop_type = $("select[name='board_type']").val();
            if(shop_type == "0"){
                $("select[name='category_id']").html("<option value = '0'><?php echo e(__('lang.전체')); ?></option>")
            }
            var param = new Object();
            param.shop_type = shop_type;
            param._token = _token;
            var url = "<?php echo e(url('admin/review/getCategoryList')); ?>";
            $.post(url, param, function(html){
                $("select[name='category_id']").html(html);
                var category_id1 = $("#category_id1").val();
                $("select[name='category_id']").val(category_id1);
            });

        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>