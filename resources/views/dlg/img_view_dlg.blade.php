{{getCurrentLang()}}
<div id="img-view-dialog" class="modal fade "  tabindex="-1" role="dialog" aria-hidden="false" style = "z-index: 1060;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">{{__('lang.이미지보기')}}</h4>
            </div>

            <div class="modal-body" >
                <div class = "row">
                    <div class = "col-md-12">
                        <img src = "" id = "img" style = "width:100%"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer hidden">
                <button type="button"  class="btn btn-primary close"  data-dismiss="modal"  >{{__('lang.확인')}}</button>
            </div>

        </div>
    </div>
</div>
