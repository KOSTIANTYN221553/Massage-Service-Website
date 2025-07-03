<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
    <?php echo e(__('lang.고객목록')); ?>

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
        <h1><?php echo e(__('lang.고객목록')); ?></h1>
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
                                <?php echo e(__("lang.고객리스트")); ?>

                            </div>
                        </div>
                    </div>
                    <div class="panel-body ">
                        <form id = "searchFrm" action = "<?php echo e(url("admin/user")); ?>" method = "post">
                            <input type = "hidden" name = "page" value = "<?php echo e($pageParam['pageNo']); ?>"/>
                            <input type = "hidden" name = "_token" value = "<?php echo csrf_token(); ?>"/>
                            <input type = "hidden" name ="order_key" value = "<?php echo e($order_key); ?>"/>
                            <input type = "hidden" name ="order_val" value = "<?php echo e($order_val); ?>"/>
                            <div class="page_section_1 page_section search_section" id="search_filter_layout">
                                <div class = "row">
                                    <div class = "col-md-2">
                                        <label>
                                            <?php echo e(__('lang.전체회원')); ?>: &nbsp;&nbsp;<?php echo e($totalCount); ?> <?php echo e(__("lang.명")); ?>

                                        </label>
                                    </div>
                                    <div class = "col-md-8">
                                        <div class="form-group">
                                            <label >

                                            </label>    &nbsp;

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class = "row">
                                        <div class = "col-md-2">
                                            <label>
                                                <?php echo e(__('lang.상태')); ?>

                                            </label>
                                        </div>
                                        <div class = "col-md-8">
                                            <div class="form-group">
                                                <label class="checkbox-inline">
                                                    &nbsp;<input type="radio" class="custom-radio" <?php if($filter_status*1 == 0): ?> checked <?php endif; ?> name="filter_status" value="0" >&nbsp;<?php echo e(__('lang.전체')); ?></label>
                                                <label class=" checkbox-inline">
                                                    <input type="radio" class="custom-radio"  name="filter_status" <?php if($filter_status*1 == 1): ?> checked <?php endif; ?> value="1" > <?php echo e(__('lang.활성')); ?></label>
                                                <label class="checkbox-inline" >
                                                    <input type="radio"  class="custom-radio" name="filter_status" <?php if($filter_status*1 == 91): ?> checked <?php endif; ?> value="91" >&nbsp;<?php echo e(__('lang.탈퇴')); ?></label>
                                                <label class="checkbox-inline" >
                                                    <input type="radio"  class="custom-radio" name="filter_status" <?php if($filter_status*1 == 99): ?> checked <?php endif; ?> value="99" >&nbsp;<?php echo e(__('lang.강퇴')); ?></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class = "row">
                                        <div class = "col-md-2">
                                            <label><?php echo e(__('lang.검색어')); ?></label>
                                        </div>
                                        <div class = "col-md-4">
                                            <select class="form-control" data-width="120px"  name = "search_key_type">
                                                <option value="email" <?php if($search_key_type == 'email'): ?> selected <?php endif; ?>><?php echo e(__('lang.아이디')); ?></option>
                                                <option value="nickname" <?php if($search_key_type == 'nickname'): ?> selected <?php endif; ?>><?php echo e(__('lang.예명')); ?></option>
                                                <option value="phone" <?php if($search_key_type == 'phone'): ?> selected <?php endif; ?>><?php echo e(__('lang.전화번호')); ?></option>
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
                                            <label>
                                                <?php echo e(__('lang.타입')); ?>

                                            </label>
                                        </div>
                                        <div class = "col-md-8">
                                            <div class="form-group">
                                                <label class="checkbox-inline">
                                                    &nbsp;<input type="radio" class="custom-radio" <?php if($filter_type*1 == 0): ?> checked <?php endif; ?> name="filter_type" value="0" >&nbsp;<?php echo e(__('lang.전체')); ?></label>
                                                <label class=" checkbox-inline">
                                                    <input type="radio" class="custom-radio"  name="filter_type" <?php if($filter_type*1 == 99): ?> checked <?php endif; ?> value="99" > <?php echo e(__('lang.관리자')); ?></label>
                                                <label class="checkbox-inline" >
                                                    <input type="radio"  class="custom-radio" name="filter_type" <?php if($filter_type*1 == 70): ?> checked <?php endif; ?> value="70" >&nbsp;<?php echo e(__('lang.업주')); ?></label>
                                                <label class="checkbox-inline" >
                                                    <input type="radio"  class="custom-radio" name="filter_type" <?php if($filter_type*1 == 1): ?> checked <?php endif; ?> value="1" >&nbsp;<?php echo e(__('lang.일반고객')); ?></label>
                                            </div>
                                        </div>
                                    </div>
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
                                        <th><input type = "checkbox" class = "custom-checkbox" id = "allCheck"/></th>
                                        <th class = "sorting" ><?php echo e(__('lang.타입')); ?></th>
                                        <th class = "sorting"  aria-name = "level_id"><?php echo e(__('lang.레벨')); ?></th>
                                        <th class = "sorting" aria-name = "email"><?php echo e(__('lang.아이디')); ?></th>
                                        <th class = "sorting" ><?php echo e(__('lang.프로필사진')); ?></th>
                                        <th class = "sorting" aria-name = "nickname"><?php echo e(__('lang.닉네임')); ?></th>
                                        <th class = "sorting" aria-name = "gender"><?php echo e(__('lang.성별')); ?></th>
                                        <th class = "sorting" aria-name = "phone"><?php echo e(__('lang.전화번호')); ?></th>
                                        <th class = "sorting" aria-name = "user_point"><?php echo e(__('lang.보유포인트')); ?></th>
                                        <th class = "sorting" aria-name = "status"><?php echo e(__('lang.상태')); ?></th>
                                        <th class = "sorting" aria-name = "created_at"><?php echo e(__('lang.가입일')); ?></th>
                                        <th><?php echo e(__('lang.수정')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><input type = "checkbox" class = "custom-checkbox" value = "<?php echo e($item['id']); ?>"></td>
                                        <td><?php echo e(getUserTypeStr($item['type'])); ?></td>
                                        <td>
                                            <?php if(isset($item['user_level']['id'])): ?>
                                                <img onerror = "noExitImg(this)" style="width:20px !important;" src="<?php echo e(url($item['user_level']['icon'])); ?>"><?php echo e($item['user_level']['title']); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($item['email']); ?></td>
                                        <td><img onerror = "noExitImg(this)" src ="<?php echo e(correctImgPath($item['photo_url'])); ?>" class = "wh-80"/></td>
                                        <td><?php echo e($item['nickname']); ?></td>
                                        <td><?php echo e(getUserGenderStr($item['gender'])); ?></td>
                                        <td><?php echo e($item['phone']); ?></td>
                                        <td><?php echo e($item['user_point']); ?></td>
                                        <td><?php echo e(getUserStatusStr($item['status'])); ?></td>
                                        <td><?php echo e(substr($item['created_at'],0,10)); ?></td>
                                        <td>
                                            <a class = "btn btn-danger" href = "<?php echo e(url("admin/user/info/".$item['id'])); ?>"><?php echo e(__('lang.수정')); ?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($list) == 0): ?>
                                    <tr>
                                        <td colspan = "12"><?php echo e(__('lang.자료가 없습니다.')); ?></td>
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
                                <button type = "button" class = "btn btn-primary" onclick = "selItemDelete()"><?php echo e(__('lang.선택삭제')); ?></button>
                                <a type = "button" class = "btn btn-primary float-right" href = "<?php echo e(url('admin/user/info/0')); ?>"><i class = "fa fa-plus"></i><?php echo e(__('lang.고객추가')); ?></a>
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
    <script type="text/javascript" src="<?php echo e(asset('assets/js/pages/admin/user.js')); ?>" ></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>