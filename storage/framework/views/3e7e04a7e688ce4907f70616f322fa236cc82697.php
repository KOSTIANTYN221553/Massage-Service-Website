<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
    <?php echo e(__('lang.게시판내 카테고리')); ?>

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
        <h1><?php echo e(__('lang.게시판내 카테고리')); ?></h1>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary filterable">
                    <div class="panel-heading clearfix  ">
                        <div class="panel-title pull-left">
                            <div class="caption">
                                <i class="livicon" data-name="camera" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                <?php echo e(__('lang.게시판종류리스트')); ?>

                            </div>
                        </div>
                    </div>
                    <div class="panel-body ">
                        <form id = "searchFrm" action = "<?php echo e(url("admin/board_type")); ?>" method = "post">
                            <input type = "hidden" name = "page" value = "<?php echo e($pageParam['pageNo']); ?>"/>
                            <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>"/>
                            <input type = "hidden" name ="order_key" value = "<?php echo e($order_key); ?>"/>
                            <input type = "hidden" name ="order_val" value = "<?php echo e($order_val); ?>"/>
                            <div class="page_section_1 page_section search_section" id="search_filter_layout">
                                <div class="col-md-6">
                                    <div class = "row">
                                        <div class = "col-md-2">
                                            <label><?php echo e(__('lang.검색어')); ?></label>
                                        </div>
                                        <div class = "col-md-4">
                                            <select class="form-control" data-width="120px"  name = "search_key_type">
                                                <option value="shop.title"><?php echo e(__('lang.타이틀')); ?></option>
                                            </select>
                                        </div>
                                        <div class = "col-md-6">
                                            <div class="form-group input-group">
                                                <input type="text" class="form-control" name = "search" value = "<?php echo e($search); ?>" minlength = "2" placeholder="<?php echo e(__('lang.검색어를 입력해 주세요(2자 이상)')); ?>">
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
                                        <div class = "col-md-12">
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
                                        <th class = "sorting" aria-name = "board_type"><?php echo e(__('lang.분류')); ?></th>
                                        <th class = "sorting" aria-name = "title"><?php echo e(__('lang.이름')); ?></th>
                                        <th><?php echo e(__('lang.수정')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(getBoardCategoryTypeName($item['board_type'])); ?></td>
                                        <td><?php if($item['board_type']*1 ==0): ?> <?php echo e(__("lang.".$item['title'])); ?> <?php else: ?> <?php echo e($item['title']); ?> <?php endif; ?></td>
                                        <td>
                                            <a class = "btn btn-danger" href = "<?php echo e(url("admin/board_type/info/".$item['id']."/".$item['board_type'])); ?>"><?php echo e(__('lang.카테고리추가')); ?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($list) == 0): ?>
                                    <tr>
                                        <td colspan = "4"><?php echo e(__('lang.자료가 없습니다.')); ?></td>
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
                        <div class = "table-responsive hidden">
                            <div class = "col-md-12 text-left">
                                <button type = "button" class = "btn btn-primary" onclick = "selItemDelete()"><?php echo e(__('lang.선택삭제')); ?></button>
                                <a type = "button" class = "btn btn-primary float-right" href = "<?php echo e(url('admin/board_type/info/0')); ?>"><i class = "fa fa-plus"></i><?php echo e(__('lang.종류생성')); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer_scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/pages/admin/board_type.js')); ?>" ></script>
    <script>
        $(function(){
            loading_stop();
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>