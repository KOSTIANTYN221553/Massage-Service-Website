<?php echo e(getCurrentLang()); ?>

<div id="note-view-dialog" class="modal fade "  tabindex="-1" role="dialog" aria-hidden="false" style = "z-index: 1060;">
    <div class="modal-dialog  front-dlg" style = "">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><?php echo e(__('lang.쪽지보기')); ?></h4>
            </div>
            <div class="modal-body" id = "dlg_content">

            </div>
            <div class="modal-footer">
                <button type="button"  class="btn btn-danger radius-0" id ="note_send_form_btn1" onclick = "closeNoteViewDlg()" ><?php echo e(__('lang.리스트로')); ?></button>
                <button type="button"  class="btn btn-primary radius-0" id ="note_send_form_btn1" onclick = "closeNoteViewDlg()" style = "background: black;border-color: white;"><?php echo e(__('lang.닫기')); ?></button>
            </div>

        </div>
    </div>
</div>

<script>
    function closeNoteViewDlg(){
        $("#note-view-dialog").modal("hide");
    }
</script>




