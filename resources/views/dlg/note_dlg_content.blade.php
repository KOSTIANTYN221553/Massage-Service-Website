{{getCurrentLang()}}
<ul class="nav nav-tabs" style="margin-bottom: 15px;">
    <li class="active">
        <a href="#home" data-toggle="tab" aria-expanded="false" class = "active">{{__('lang.받은 쪽지')}}</a>
    </li>
    <li class="">
        <a href="#profile" data-toggle="tab" aria-expanded="true">{{__('lang.보낸 쪽지')}}</a>
    </li>
</ul>
<div class="slimScrollDiv" style="position: relative; overflow: visible; width: auto; ">
    <div id="myTabContent" class="tab-content" style="overflow: visible; width: auto;">
        <div class="tab-pane fade active in" id="home">
            <div class="table-scrollable" style ="overflow: visible">
                <table class="table table-striped" id = "table1">
                    <thead>
                    <tr>
                        <th>{{__('lang.아이디')}}</th>
                        <th>{{__('lang.받은 날')}}</th>
                        <th>{{__('lang.읽은 날')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($to_list as $item)
                        <tr>
                            <td class = "cursor relative menu-click-wrapper" onclick = "menuItemClick(this)">
                                {{$item['send_nickname']}}
                                <ul class = "td-click-menu hidden">
                                    <li><a href = "javascript:void(0);" onclick = "showSendNoteDlg(this)"  data-user-id = "{{$item['send_user_id']}}">{{__('lang.쪽지보내기')}}</a></li>
                                    <li><a href = "javascript:void(0);" onclick = "showUserInfoDlg(this)" data-user-id = "{{$item['send_user_id']}}">{{__('lang.회원정보')}}</a></li>
                                </ul>
                            </td>
                            <td class = "cursor" onclick = "note_view(this)" data-id = "{{$item['id']}}">{{substr($item['send_date'],0,16)}}</td>
                            <td class = "cursor" onclick = "note_view(this)" data-id = "{{$item['id']}}">{{substr($item['read_date'],0,16)}}</td>
                            <td>
                                <a href = "javascript:void(0)" onclick = "delNote(this)" data-id = "{{$item['id']}}" >{{__('lang.삭제')}}</a>
                            </td>
                        </tr>
                    @endforeach
                    @if(count($to_list)==0)
                        <tr>
                            <td colspan ="4">
                                {{__('lang.자료가 없습니다.')}}
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <?php $searchFun ='searchData1'; ?>
                @include('layouts/pagination')
            </div>
        </div>
        <div class="tab-pane fade" id="profile">
            <div class="table-scrollable" style ="overflow: visible">
                <table class="table table-striped" id = "table2">
                    <thead>
                    <tr>
                        <th>{{__('lang.아이디')}}</th>
                        <th>{{__('lang.받은 날')}}</th>
                        <th>{{__('lang.읽은 날')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($from_list as $item)
                        <tr>
                            <td class ="cursor relative menu-click-wrapper" onclick = "menuItemClick(this)">
                                {{$item['to_nickname']}}
                                <ul class = "td-click-menu hidden">
                                    <li><a href = "javascript:void(0);" onclick = "showSendNoteDlg(this)" data-user-id = "{{$item['to_user_id']}}">{{__('lang.쪽지보내기')}}</a></li>
                                    <li><a href = "javascript:void(0);" onclick = "showUserInfoDlg(this)" data-user-id = "{{$item['to_user_id']}}">{{__('lang.회원정보')}}</a></li>
                                </ul>
                            </td>
                            <td class = "cursor" onclick = "note_view(this)" data-id = "{{$item['id']}}">{{substr($item['send_date'],0,16)}}</td>
                            <td class = "cursor" onclick = "note_view(this)" data-id = "{{$item['id']}}">{{substr($item['read_date'],0,16)}}</td>
                            <td >
                                <a href = "javascript:void(0)" onclick = "delNote(this)" data-id = "{{$item['id']}}" >{{__('lang.삭제')}}</a>
                            </td>
                        </tr>
                    @endforeach
                    @if(count($from_list)==0)
                        <tr>
                            <td colspan ="4">
                                {{__('lang.자료가 없습니다.')}}
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
                <?php $searchFun ='searchData2'; ?>
                @include('layouts/pagination')
            </div>
        </div>
    </div>
</div>

<script>

</script>