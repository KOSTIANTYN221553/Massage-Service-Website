<?php echo e(getCurrentLang()); ?>

<div id="schedule-detail-dialog" class="modal fade "  tabindex="-1" role="dialog" aria-hidden="false" style = "z-index: 1060;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?php echo e(__('lang.매너저상세')); ?></h4>
            </div>
            <form class="form-horizontal" id = "" method = "post" action="javascript:void(0)">
                <div class="modal-body" >
                    <div class = "row">
                        <div class = "col-md-12" id = "detail_rect">
                            <input type = "hidden" name = "detail_id" value = "0" />
                            <select class = "form-control inline-block w-120" name = "manager_id">
                                <option value = ""><?php echo e(__('lang.매니저선택')); ?></option>
                            </select>
                            <input name = "schedule_start_at" class = "form-control inline-block w-120" placeholder="<?php echo e(__('lang.시작시간')); ?>">
                            <input name = "schedule_end_at" class = "form-control inline-block w-120" placeholder="<?php echo e(__('lang.마감시간')); ?>">
                            <button class = "btn btn-primary" type = "button" id = "btn_edit" onclick = "onAddScheduleDetail()"><?php echo e(__('lang.추가')); ?></button>
                        </div>
                    </div>
                    <table class="table table-hover table-striped table-bordered" style = "margin-top:10px;">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td><?php echo e(__('lang.매니저이름')); ?></td>
                                <td><?php echo e(__('lang.시작시간')); ?></td>
                                <td><?php echo e(__('lang.마감시간')); ?></td>
                                <td><?php echo e(__('lang.관리')); ?></td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($info['detail_list'])): ?>
                        <?php $__currentLoopData = $info['detail_list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr data-id = "<?php echo e($item['id']); ?>">
                            <td><?php echo e($key+1); ?></td>
                            <td data-id = "<?php echo e($item['manager']['id']); ?>"><?php echo e($item['manager']['nickname']); ?></td>
                            <td><?php echo e($item['schedule_start_at']); ?></td>
                            <td><?php echo e($item['schedule_end_at']); ?></td>
                            <td>
                                <a class="btn btn-raised btn-success btn-large" type = "button" onclick = "editTr(this)"><?php echo e(__('lang.편집')); ?></a>
                                <a class="btn btn-raised btn-danger btn-large" type = "button" onclick = "deleteTr(this)"><?php echo e(__('lang.삭제')); ?></a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                    <div class = "row">
                        <div class = "col-md-12">
                            <button class = "btn btn-primary" type = "button" id = "btn_edit" onclick = "onAllRemove()"><?php echo e(__('lang.전체삭제')); ?></button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-primary" onclick = "createDetail()" ><?php echo e(__('lang.확인')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function onAllRemove(){
        confirmMsg("정말 전체삭제하시겠습니까?", function(){
            $("#schedule-detail-dialog .table tbody tr").remove();
        });
    }

    function onAddScheduleDetail(){
        var detail_id = $("#detail_rect input[name='detail_id']").val();
        var manager_id = $("#detail_rect select[name='manager_id']").val();
        var manager_name = $("#detail_rect select[name='manager_id'] option:selected").text();
        manager_name = manager_name.trim();
        if(manager_id==""){
            errorMsg("매니저를 선택해주세요.");
            return;
        }
        var schedule_start_at = $("#detail_rect input[name='schedule_start_at']").val();
        if(schedule_start_at == ""){
            errorMsg("시작시간을 입력해주세요.");
            return;
        }
        var schedule_end_at = $("#detail_rect input[name='schedule_end_at']").val();
        if(schedule_end_at == ""){
            errorMsg("시작시간을 입력해주세요.");
            return;
        }


        if(detail_id == "0"){
            var retInfo  = getDetailId();
            detail_id = retInfo.data_id;
            var index = retInfo.index;
            var html = genTr(detail_id, manager_id,manager_name, schedule_start_at, schedule_end_at,index );
            $("#schedule-detail-dialog .table tbody").append(html);
        }else{
            var tr = $("#schedule-detail-dialog .table tbody tr[data-id = '"+detail_id+"']");
            tr.find("td").eq(1).attr("data-id", manager_id);
            tr.find("td").eq(1).text(manager_name);
            tr.find("td").eq(2).text(schedule_start_at);
            tr.find("td").eq(3).text(schedule_end_at);
        }
        initDetailRect();
    }

    function initDetailRect(){
        $("#detail_rect select[name='manager_id']").val("");
        $("#detail_rect input[name='schedule_start_at']").val("");
        $("#detail_rect input[name='schedule_end_at']").val("");
        $("#detail_rect input[name='detail_id']").val("0");
        $("#detail_rect #btn_edit").text("<?php echo e(__('lang.추가')); ?>");
    }

    function editTr(obj){
        var data_id = $(obj).parent().parent().attr("data-id");
        var tr = $("#schedule-detail-dialog .table tbody tr[data-id = '"+data_id+"']");
        var manager_id = tr.find("td").eq(1).attr("data-id");
        $("#detail_rect select[name='manager_id']").val(manager_id);
        var schedule_start_at = tr.find("td").eq(2).text();
        schedule_start_at = schedule_start_at.trim();
        var schedule_end_at = tr.find("td").eq(3).text();
        schedule_end_at = schedule_end_at.trim();
        $("#detail_rect input[name='schedule_start_at']").val(schedule_start_at);
        $("#detail_rect input[name='schedule_end_at']").val(schedule_end_at);
        $("#detail_rect input[name='detail_id']").val(data_id);
        $("#detail_rect #btn_edit").text("편집");
    }

    function deleteTr(obj){
        confirmMsg("<?php echo e(__('lang.정말 삭제하겟습니까?')); ?>", function(){
            $(obj).parent().parent().remove();
        });
    }

    function genTr(detail_id, manager_id, manager_name, start,end, index){
        var html = `<tr data-id = "${detail_id}">
        <td>${index}</td>
        <td data-id = "${manager_id}">${manager_name}</td>
        <td >${start}</td>
        <td >${end}</td>
        <td>
            <a class="btn btn-raised btn-success btn-large" type = "button" onclick = "editTr(this)">편집</a>
            <a class="btn btn-raised btn-danger btn-large" type = "button" onclick = "deleteTr(this)">삭제</a>
        </td>
        </tr>`;
        return html;
    }

    function getDetailId(){
        var  ret_data_id = 0;
        var ret_index = 0;
        $("#schedule-detail-dialog .table tbody tr").each(function(){
           var data_id = $(this).attr("data-id");
           data_id = parseInt(data_id);
           if(ret_data_id > data_id){
               ret_data_id = data_id;
           }
           var index = $(this).find("td").eq(0).text();
           index = index.trim();
           index = parseInt(index);
           if(ret_index < index){
               ret_index = index;
           }
        });
        ret_data_id--;
        ret_index++;
        var ret = new Object();
        ret.data_id = ret_data_id;
        ret.index = ret_index;
        return ret;
    }

    function createDetail(){
        var detail_list_str = "-1";
        var detail_list = new Array();
        $("#schedule-detail-dialog .table tbody tr").each(function(){
            var detail_ele = new Object();
            var id = $(this).attr("data-id");
            var manager_id = $(this).find("td").eq(1).attr("data-id");
            var schedule_start_at = $(this).find("td").eq(2).text();
            schedule_start_at = schedule_start_at.trim();
            var schedule_end_at = $(this).find("td").eq(3).text();
            schedule_end_at = schedule_end_at.trim();
            detail_ele.id = id;
            detail_ele.manager_id = manager_id;
            detail_ele.schedule_start_at = schedule_start_at;
            detail_ele.schedule_end_at = schedule_end_at;
            detail_list[detail_list.length] = detail_ele;
        });
        if(detail_list.length > 0){
            detail_list_str = JSON.stringify(detail_list);
        }
        $("input[name='detail_list']").val(detail_list_str);
        $("#schedule-detail-dialog").modal("hide");
        refreshManagerTable();
    }

    function refreshManagerTable(){
        var html = "";
        var i =0;
        $("#schedule-detail-dialog .table tbody tr").each(function(){
            var detail_ele = new Object();
            var id = $(this).attr("data-id");
            var manager_id = $(this).find("td").eq(1).attr("data-id");
            var manager_name = $(this).find("td").eq(1).html();
            manager_name = manager_name.trim();
            var schedule_start_at = $(this).find("td").eq(2).text();
            schedule_start_at = schedule_start_at.trim();
            var schedule_end_at = $(this).find("td").eq(3).text();
            schedule_end_at = schedule_end_at.trim();
            html +=`
                 <tr>
                    <td>${i+1}</td>
                    <td>${manager_name}</td>
                    <td>${schedule_start_at}</td>
                    <td>${schedule_end_at}</td>
                </tr>
            `;
            i++;
        });
        if(html == ""){
            html =`<tr><td colspan = "4">자료가 없습니다.</td></tr>`;
        }
        $("#manager_tabl tbody").html(html);
    }

</script>