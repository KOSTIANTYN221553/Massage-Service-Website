@extends('layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
{{__('lang.공지사항')}}
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <!--end of page level css-->
@stop
{{-- slider --}}
{{-- content --}}
@section('content')
    <div class="container mt-10">
        <div class="row content">
            <!-- Business Deal Section Start -->
            <div class="col-sm-12 col-md-12">
                <div class=" thumbnail featured-post-wide img">
                    <!-- /.blog-detail-image -->
                    <h2 class="color-white marl12">{{$info['title']}}(<span class = "font-14">{{getNoticeTypeStr($info['type'])}}</span>)</h2>
                    <div class="the-box no-border blog-detail-content">
                        <p class="text-justify font-18 color-white word-break">
                            {!! $info['description'] !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-10">
            <div class = "col-md-12">
                <table class = "table table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>{{__('lang.분류')}}</th>
                        <th>{{__('lang.제목')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($list as $key => $item)
                        <tr >
                            <td class = "cursor" onclick = "detailView(this)" data-id ="{{$item['id']}}">{{$key+$pageParam['startNumber']+1}}</td>
                            <td class = "cursor" onclick = "detailView(this)" data-id ="{{$item['id']}}">{{getNoticeTypeStr($item['type'])}}</td>
                            <td class = "cursor" onclick = "detailView(this)" data-id ="{{$item['id']}}">{{utf8_strcut(strip_tags($item['title']),30)}}</td>
                        </tr>
                        <tr class = "content-tr hidden">
                            <td colspan = "3">
                                {!! $item['description'] !!}
                            </td>
                        </tr>
                    @endforeach
                    @if(count($list)==0)
                        <tr>
                            <td colspan = "3">
                                {{__('lang.자료가 없습니다.')}}
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- //Container End -->
@stop
{{-- footer scripts --}}
@section('footer_scripts')
    <script>
        function  detailView(obj){
            var id = $(obj).attr("data-id");
            window.location.href = "{{url("/notice_info")}}/"+id;
        }
    </script>
@stop
