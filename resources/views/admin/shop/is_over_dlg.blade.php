<style>
    .sorting_desc:before, .sorting_asc:before, .sorting:before {
        right: 1em;
        content: "";
    }
</style>
{{getCurrentLang()}}
<div id="is_over_dlg" class="modal fade "  tabindex="-1" role="dialog" aria-hidden="false" style = "z-index: 1060;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-danger">{{__('lang.알림')}}</h4>
            </div>
            <form class="form-horizontal" id = "" method = "post" action="javascript:void(0)">
                <div class="modal-body" >
                    <p class = "text-danger">{{__('lang.업소 갱신 1주일 남았습니다')}}</p>
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-primary" onclick = "closeIsOverDlg()" >{{__('lang.확인')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
