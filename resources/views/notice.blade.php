@extends('layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
{{__('lang.공지사항')}}
@parent
@stop

@section('header_styles')
@stop
@section('content')

    <div class="container mt-10">
        @if(isset($page_title))
            <div class = "row">
                <div class = "col-md-12 col-xs-12 page-title-wrapper">
                    <span class = ""> {{$page_title}}</span>
                </div>
            </div>
        @endif
        @if(isset($notice_list))
            @foreach($notice_list as $item)
                <a href = "javascript:void(0)" data-id = "{{$item['id']}}" onclick = "detailView1(this)">
                    <div class = "row page-title-wrapper">
                        <div class = "col-md-10 margin-box border-right">
                            <span class ="badge-warning">{{__('lang.공지')}}</span>
                            <span>{{utf8_strcut(strip_tags($item['title']),150)}}</span>
                        </div>
                        <div class = "col-md-2 text-right"><span class = "pr-10 border-right">{{$item['user']['nickname']}}</span> <span class = "pl-10">{{getMsgTimeStr($item['created_at'])}}</span></div>
                    </div>
                    <div class = "row page-title-wrapper content-wrapper hidden">
                        {!! $item['description'] !!}
                    </div>
                </a>
            @endforeach
        @endif
        <div class = "row">
            <div class = "col-md-9 cols-xs-12">
                <form id = "searchForm" action = "{{url("notice")}}"  method = "get">
                    <input type = "hidden" name = "_token" value = "{{csrf_token()}}"/>
                    <input type = "hidden" name = "page" value = "{{$pageParam['pageNo']}}"/>
                </form>
                <div class="row">
                    <div class = "col-md-12">
                        <div class = "table-scrollable">
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
                                @if(count($list) == 0)
                                    <tr>
                                        <td colspan = "3">{{__('lang.검색결과가 없습니다')}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class = "text-center" style = "margin-top:10px;">
                            @include("layouts/pagination")
                        </div>
                    </div>
                </div>
            </div>
            <div class = "col-md-3 hidden-xs">
                @include('layouts/right-side')
            </div>
        </div>
@stop
{{-- footer scripts --}}
@section('footer_scripts')
    <script>
        function searchData(page) {
            $("#searchForm input[name='page']").val(page);
            $("#searchForm").submit();
        }
        function  detailView(obj){

            //$(".content-tr").addClass("hidden");
            var tr = $(obj).parent().next();
            if(tr.hasClass("hidden")){
                tr.removeClass("hidden");
            }else{
                tr.addClass("hidden");
            }
        }

        function detailView1(obj){
           var id = $(obj).attr("data-id");
           var url = "{{url('/notice_info/')}}/"+id;
           window.location.href = url;
        }

    </script>
@stop
