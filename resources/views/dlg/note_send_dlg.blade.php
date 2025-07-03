{{getCurrentLang()}}
<div id="note-send-dialog" class="modal fade "  tabindex="-1" role="dialog" aria-hidden="false" style = "z-index: 1060;">
    <div class="modal-dialog modal-lg front-dlg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">{{__('lang.쪽지보내기')}}</h4>
            </div>

            <div class="modal-body" id = "dlg_content">

            </div>
            <div class="modal-footer">
                <button type="button"  class="btn btn-danger radius-0" id ="note_send_form_btn1" onclick = "saveNoteInfo()" >{{__('lang.확인')}}</button>
            </div>

        </div>
    </div>
</div>




