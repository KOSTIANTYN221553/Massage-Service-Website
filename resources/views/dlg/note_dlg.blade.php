<style>
    .table.table-striped1 tbody tr:nth-child(odd) td, .table.table-striped1 tbody tr:nth-child(odd) th {
        background-color: #b1b1b1;
        color: white;
    }

    .table.table-striped1 >tbody>tr:hover>td {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .radius-0{
        border-radius: 0px !important;
    }


</style>
{{getCurrentLang()}}
<div id="note-dialog" class="modal fade "  tabindex="-1" role="dialog" aria-hidden="false" style = "z-index: 1060;">
    <input type = "hidden" name = "user_id" value = "0"/>
    <div class="modal-dialog modal-lg front-dlg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick = "closeNoteDlg()" aria-hidden="true">×</button>
                <h4 class="modal-title">{{__('lang.쪽지함')}}</h4>
            </div>

            <div class="modal-body" >
                <div class = "row">
                    <div class = "col-md-12">
                        <div class="bs-example" id = "content">

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <button type="button"  class="btn btn-danger radius-0"  data-dismiss="modal" style = "" onclick = "closeNoteDlg()"> {{__('lang.닫기')}} </button>
            </div>

        </div>
    </div>
</div>


