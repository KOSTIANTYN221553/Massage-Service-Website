<option value = "0">{{__('lang.전체')}}</option>
@foreach($categoryList as $item)
    <option value = "{{$item['id']}}"  @if($category_id*1 == $item['id']*1) selected @endif>{{$item['title']}}</option>
@endforeach