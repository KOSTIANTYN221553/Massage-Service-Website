<style>
    .sorting_desc:before, .sorting_asc:before, .sorting:before {
        right: 1em;
        content: "";
    }
</style>
{{getCurrentLang()}}
<div id="set-user-point-dialog" class="modal fade "  tabindex="-1" role="dialog" aria-hidden="false" style = "z-index: 1060;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">{{__('lang.보유포인트수정')}}</h4>
            </div>

            <div class="modal-body" >
                <div class="form-group">
                    <label class="control-label">{{__('lang.보유포인트')}}</label>
                    <input  name="user_point" type="number" placeholder="{{__('lang.보유포인트를 입력해주세요')}}" class="form-control" value = "">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button"  class="btn btn-primary" onclick = "setUserPoint()" >{{__('lang.확인')}}</button>
            </div>

        </div>
    </div>
</div>
