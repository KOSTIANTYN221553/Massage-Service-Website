{{getCurrentLang()}}
<ol class="dd-list">
    @foreach($list as $item)
    <li class="dd-item dd3-item" data-id="{{$item['id']}}">
        <div class="dd-handle dd3-handle"></div>
        <div class="dd3-content">
            {{$item['title']}}
            <span style = "float:right; margin-left:10px;" class ="cursor" onclick ="deleteCategory(this)" data-id = "{{$item['id']}}"><i class ="fa fa-trash"></i></span>
            <span style = "float:right" onclick ="editCategory(this)" data-id = "{{$item['id']}}" data-title = "{{$item['title']}}" class ="cursor"><i class ="fa fa-pencil"></i></span>
        </div>
        @if(count($item['childList']) > 0)
            <ol class="dd-list">
            @foreach($item['childList'] as $child)
                    <li class="dd-item dd3-item" data-id="{{$child['id']}}">
                        <div class="dd-handle dd3-handle"></div>
                        <div class="dd3-content">
                            {{$child['title']}}
                            <span style = "float:right; margin-left:10px;" class ="cursor" onclick ="deleteCategory(this)" data-id = "{{$child['id']}}"><i class ="fa fa-trash"></i></span>
                            <span style = "float:right" onclick ="editCategory(this)" data-id = "{{$child['id']}}" data-title = "{{$child['title']}}" class ="cursor"><i class ="fa fa-pencil"></i></span>
                        </div>
                    </li>
            @endforeach
            </ol>
        @endif
    </li>
    @endforeach
</ol>

<script>

</script>