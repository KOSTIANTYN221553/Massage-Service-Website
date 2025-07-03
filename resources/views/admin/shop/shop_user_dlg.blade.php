<style>
    .sorting_desc:before, .sorting_asc:before, .sorting:before {
        right: 1em;
        content: "";
    }
</style>
{{getCurrentLang()}}
<div id="shop-users-dialog" class="modal fade "  tabindex="-1" role="dialog" aria-hidden="false" style = "z-index: 1060;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">{{__('lang.소유자목록')}}</h4>
            </div>
            <form class="form-horizontal" id = "" method = "post" action="javascript:void(0)">
                <div class="modal-body" >
                    <table class="table table-hover table-striped table-bordered" id = "table1" style = "margin-top:10px;">
                        <thead>
                        <tr>
                            <th style = "width:10%">No</th>
                            <th style = "width:90%">{{__('lang.이름')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($shop_account_list))
                        @foreach($shop_account_list as $key => $item)
                            <tr data-id = "{{$item['id']}}">
                                <td><input type = "radio"  name = "check_shop_user" data-name = "{{$item['nickname']}}" @if($item['id']*1 ==$info['user_id']*1 ) checked @endif value = "{{$item['id']}}"/></td>
                                <td data-id = "{{$item['id']}}">{{$item['nickname']}}</td>
                            </tr>

                        @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button"  class="btn btn-primary" onclick = "setShopUser()" >{{__('lang.확인')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
