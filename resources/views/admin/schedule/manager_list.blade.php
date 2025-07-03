{{getCurrentLang()}}
<option value = "">{{__('lang.매니저선택')}}</option>
@foreach($manager_list as $item)
    <option value = "{{$item['id']}}">{{$item['nickname']}}</option>
@endforeach