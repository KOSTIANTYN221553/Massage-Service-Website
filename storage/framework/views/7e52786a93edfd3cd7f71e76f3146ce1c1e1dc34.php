<?php echo e(getCurrentLang()); ?>


<?php $__env->startSection('title'); ?>
    <?php echo e(__('lang.업소목록')); ?>

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
        <h1><?php echo e(__('lang.업소목록')); ?></h1>
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
                                <?php echo e(__('lang.업소리스트')); ?>

                            </div>
                        </div>
                    </div>
                    <div class="panel-body ">
                        <form id = "searchFrm" action = "<?php echo e(url("admin/shops")); ?>" method = "post">
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
                                            <option value="shop.title"><?php echo e(__('lang.업소타이틀')); ?></option>
                                        </select>
                                    </div>
                                    <div class = "col-md-6">
                                        <div class="form-group input-group">
                                            <input type="text" class="form-control" name = "search" value = "<?php echo e($search); ?>" minlength = "2" placeholder=" <?php echo e(__('lang.검색어를 입력해 주세요(2자 이상)')); ?>">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button" onclick = "searchCustom()">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-2">
                                        <label>
                                            <?php echo e(__('lang.기간검색')); ?>

                                        </label>
                                    </div>
                                    <div class = "col-md-4">
                                        <select class="form-control" name = "filter_date">
                                            <option value="created" <?php if($filter_date == "created"): ?> selected <?php endif; ?>><?php echo e(__('lang.등록일')); ?></option>
                                            <option value="updated" <?php if($filter_date == "created"): ?> selected <?php endif; ?>><?php echo e(__('lang.수정일')); ?></option>
                                        </select>
                                    </div>
                                    <div class = "col-md-3">
                                        <div class="form-group input-group">
                                            <input type="text" class="form-control date-picker" name = "fromDate" value = "<?php echo e($fromDate); ?>"  placeholder="YYYY-MM-DD">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default " type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class = "col-md-3">
                                        <div class="form-group input-group">
                                            <input type="text" class="form-control date-picker" name = "toDate" value ="<?php echo e($toDate); ?>" placeholder="YYYY-MM-DD">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default" type="button">
                                                    <i class="fa fa-calendar"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class = "row" style = "margin-top:4px;">
                                    <div class = "col-md-2">
                                        <label class="checkbox-inline">
                                        <?php echo e(__('lang.노출')); ?>

                                        </label>
                                    </div>
                                    <div class = "col-md-6">
                                        <div class="form-group">
                                            <label class="checkbox-inline">
                                                &nbsp;<input type="radio" class="custom-radio" <?php if($filter_status*1 == -99): ?> checked <?php endif; ?> name="filter_status" value="-99" >&nbsp;<?php echo e(__('lang.전체')); ?></label>
                                            <label class=" checkbox-inline">
                                                <input type="radio" class="custom-radio"  name="filter_status" <?php if($filter_status*1 == 1): ?> checked <?php endif; ?> value="1" > <?php echo e(__('lang.노출')); ?></label>
                                            <label class="checkbox-inline" >
                                                <input type="radio"  class="custom-radio" name="filter_status" <?php if($filter_status*1 == 0): ?> checked <?php endif; ?> value="0" >&nbsp;<?php echo e(__('lang.비노출')); ?></label>
                                        </div>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class = "col-md-12" style = "padding-top:10px;">
                                        <button  type = "button" class="calendar_btn_1 calendar_btn btn_type_1 btn btn-success  mt-ladda-btn date_range_btn_today" onclick ="todayClick()"><?php echo e(__('lang.오늘')); ?></button>
                                        <button  type = "button" class="calendar_btn_2 calendar_btn btn_type_1 btn btn-success  mt-ladda-btn date_range_btn_week" onclick = "weekClick()"><?php echo e(__('lang.1주')); ?></button>
                                        <button  type = "button" class="calendar_btn_3 calendar_btn btn_type_1 btn btn-success  mt-ladda-btn date_range_btn_month" onclick = "monthClick()"><?php echo e(__('lang.1개월')); ?></button>
                                        <button type="button" class="btn btn-info " onclick = "searchCustom()"><?php echo e(__('lang.검색')); ?></button>
                                        <button type="button" class="btn btn-info" onclick = "initFilter()"><?php echo e(__('lang.초기화')); ?></button>
                                        <?php if($user['type']*1 != 70): ?>
                                           <span style = "float:right;"> <?php echo e(__('lang.전체')); ?>:  &nbsp;&nbsp; <?php echo e($totalCount); ?> <?php echo e(__('lang.개')); ?> </span>
                                        <?php endif; ?>
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
                                        <th class = "sorting" aria-name = "shop.id">ID</th>
                                        <th class = "sorting" aria-name = "shop.title"><?php echo e(__('lang.이름')); ?></th>
                                        <th class = "sorting" aria-name = "shop_type.title"><?php echo e(__('lang.종류')); ?></th>
                                        <th class = "sorting" aria-name = "user.nickname"><?php echo e(__('lang.업주')); ?></th>
                                        <th class = "sorting" aria-name = "shop.phone"><?php echo e(__('lang.전화번호')); ?></th>
                                        <th class = "sorting" aria-name = "shop.complete_date"><?php echo e(__('lang.만료일')); ?></th>
                                        <th><?php echo e(__('lang.수정')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><input type = "checkbox" class = "custom-checkbox" value = "<?php echo e($item['id']); ?>"></td>
                                        <td><?php echo e($item['id']); ?></td>
                                        <td><?php echo e($item['title']); ?></td>
                                        <td><?php echo e($item['shop_type_title']); ?></td>
                                        <td><?php echo e($item['nickname']); ?></td>
                                        <td><?php echo e($item['phone']); ?></td>
                                        <td><?php if($item['complete_date'] != '0000-00-00 00:00:00'): ?> <?php echo e(substr($item['complete_date'],0,16)); ?> <?php endif; ?></td>
                                        <td>
                                            <?php if($user['type']*1 == 99): ?>
                                            <a class = "btn btn-success" href = "javascript:void(0)" data-id = "<?php echo e($item['id']); ?>" onclick ="showCompleteDateDlg(this)" ><?php echo e(__('lang.정액추가')); ?></a>
                                            <?php endif; ?>
                                            <a class = "btn btn-danger" href = "<?php echo e(url("admin/shops/info/".$item['id'])); ?>"><?php echo e(__('lang.수정')); ?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if(count($list) == 0): ?>
                                    <tr>
                                        <td colspan = "8"><?php echo e(__('lang.자료가 없습니다.')); ?></td>
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
                                <button type = "button" class = "btn btn-primary" onclick = "selItemDisplay('0')"><?php echo e(__('lang.선택비노출')); ?></button>
                                <button type = "button" class = "btn btn-primary" onclick = "selItemDisplay('1')"><?php echo e(__('lang.선택노출')); ?></button>
                                <button type = "button" class = "btn btn-primary" onclick = "selItemDelete()"><?php echo e(__('lang.선택삭제')); ?></button>

                                <?php if($user['type']*1 == 99): ?>
                                    <a type = "button" class = "btn btn-primary float-right" href = "<?php echo e(url('admin/shops/info/0')); ?>"><i class = "fa fa-plus"></i><?php echo e(__('lang.업소생성')); ?></a>
                                    <a class = "btn btn-primary float-right" href = "javascript:void(0)" style = "margin-right:10px;" data-id = "check" onclick ="showCompleteDateDlg(this)" ><?php echo e(__('lang.정액추가')); ?></a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- content -->
    <?php echo $__env->make('admin/notice_dlg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('admin/shop/is_over_dlg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('admin.shop.shop_complete_setting_dlg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <!-- content -->
    <?php if(isset($notice_info)): ?>
        <input type = "hidden" name = "notice" value = "<?php echo strip_tags($notice_info['description']); ?>"/>
    <?php endif; ?>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('footer_scripts'); ?>
    <script type="text/javascript" src="<?php echo e(asset('assets/js/pages/admin/shop.js')); ?>" ></script>
    <script>
        function showCompleteDateDlg(obj){
            var id = $(obj).attr("data-id");
            if(id == "check"){
                var ids = "";
                $("tbody tr input[type='checkbox']").each(function(){
                    if($(this).attr("id") == "allCheck"){
                        return true;
                    }
                    if($(this).prop("checked")){
                        ids += (ids == ""? "":",")+$(this).val();
                    }
                });
                if(ids == ""){
                    errorMsg("<?php echo e(__('lang.항목을 선택해주십시오')); ?>.");
                    return;
                }
                id = ids;
            }
            $("#completeSettingForm input[name='id']").val(id);
            $("#shop-complete-setting-dialog").modal("show");
        }
        function onSetCompleteDate(){
            var param = new Object();
            param.id = $("#completeSettingForm input[name='id']").val();
            param.radio = $("#completeSettingForm input[name='radio']:checked").val();
            param._token ='<?php echo e(csrf_token()); ?>';
            loading_start();
            var url ="<?php echo e(url('admin/shops/setCompleteDate')); ?>";
            $.post(url, param, function(data){
                if(data.status == "1"){
                    successMsg("만료일이 변경되였습니다.", function(){
                        window.location.reload();
                    });
                }else{
                    errorMsg(data.msg);
                }
            },"json");
        }
        $(function(){
           loading_stop();
        });
        $(function(){
            <?php if(isset($notice_info)): ?>
            noticeMsg($("input[name='notice']").val());
                <?php if($user['type']*1 == 70): ?>
                    <?php $diff_info = $user->shop_complete_info(); ?>
                    <?php if($diff_info['diff']*1 > 0 && $diff_info['diff']*1 < 3600*24*7): ?>
                        $("#is_over_dlg").modal("show");
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        });
        $(function(){
            $('input[type="checkbox"].square-blue').iCheck({
                checkboxClass: 'icheckbox_square-blue'
            });
        });

        function closeIsOverDlg(){
            $("#is_over_dlg").modal("hide");
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin/layouts/default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>