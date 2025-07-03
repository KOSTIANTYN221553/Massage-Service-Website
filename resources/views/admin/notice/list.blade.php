@extends('admin/layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
    {{__('lang.공지사항')}}
    @parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/pages/tables.css') }}" />

@stop

@section('content')
    <style>
        .form-group{
            margin-bottom: 0px;
        }
    </style>
    <section class="content-header">
        <!--section starts-->
        <h1>{{__('lang.공지사항')}}</h1>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary filterable">
                    <div class="panel-heading clearfix  ">
                        <div class="panel-title pull-left">
                            <div class="caption">
                                <i class="livicon" data-name="camera" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                {{__('lang.공지사항리스트')}}
                            </div>
                        </div>
                    </div>
                    <div class="panel-body ">
                        <form id = "searchFrm" action = "{{url("admin/notice")}}" method = "post">
                            <input type = "hidden" name = "page" value = "{{$pageParam['pageNo']}}"/>
                            <input type = "hidden" name = "_token" value = "{!! csrf_token() !!}"/>
                            <input type = "hidden" name ="order_key" value = "{{$order_key}}"/>
                            <input type = "hidden" name ="order_val" value = "{{$order_val}}"/>
                            <div class="page_section_1 page_section search_section" id="search_filter_layout">
                                <div class="col-md-6">
                                    <div class = "row">
                                        <div class = "col-md-2">
                                            <label>{{__('lang.검색어')}}</label>
                                        </div>
                                        <div class = "col-md-4">
                                            <select class="form-control" data-width="120px"  name = "search_key_type">
                                                <option value="title">{{__('lang.공지타이틀')}}</option>
                                            </select>
                                        </div>
                                        <div class = "col-md-6">
                                            <div class="form-group input-group">
                                                <input type="text" class="form-control" name = "search" value = "{{$search}}" minlength = "2" placeholder="{{__('lang.검색어를 입력해 주세요(2자 이상)')}}">
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="button">
                                                        <i class="fa fa-search"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class = "row">
                                        <div class = "col-md-12">
                                            <button type="button" class="btn btn-info " onclick = "searchCustom()">{{__('lang.검색')}}</button>
                                            <button type="button" class="btn btn-info" onclick = "initFilter()">{{__('lang.초기화')}}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class = "clearfix"></div>
                        <div class = "table-responsive">
                            <table class="table table-bordered table-striped  table-hover">
                                <thead>
                                    <tr>
                                        <th><input type = "checkbox" class = "custom-checkbox" id = "allCheck"/></th>
                                        <th class = "sorting" aria-name = "id">ID</th>
                                        <th class = "sorting" aria-name = "title">{{__('lang.공지타이틀')}}</th>
                                        <th class = "sorting" aria-name = "nickname">{{__('lang.노출')}}</th>
                                        <th class = "sorting" aria-name = "body_size">{{__('lang.노출기간')}}</th>
                                        <th class = "sorting" aria-name = "created_at">{{__('lang.등록일')}}</th>
                                        <th class = "sorting" aria-name = "updated_at">{{__('lang.수정일')}}</th>
                                        <th>{{__('lang.수정')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $key => $item)
                                    <tr>
                                        <td><input type = "checkbox" class = "custom-checkbox" value = "{{$item['id']}}"></td>
                                        <td class = "cursor" onclick = "noticeInfo('{{$item['id']}}')">{{$item['id']}}</td>
                                        <td class = "cursor" onclick = "noticeInfo('{{$item['id']}}')">{{$item['title']}}</td>
                                        <td>{{$item->getStatusStr()}}</td>
                                        <td>{{$item->getDisplayStr()}}</td>
                                        <td>{{substr($item['created_at'],0,10)}}</td>
                                        <td>{{substr($item['updated_at'],0,10)}}</td>
                                        <td>
                                            <a class = "btn btn-danger" href = "{{url("admin/notice/info/".$item['id'])}}">@if($user['type']*1 == 99){{__('lang.수정')}} @else {{__('lang.보기')}} @endif</a>

                                        </td>
                                    </tr>
                                @endforeach
                                @if(count($list) == 0)
                                    <tr>
                                        <td colspan = "8">{{__('lang.자료가 없습니다.')}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class = "table-responsive">
                            <div class = "col-md-12 text-right">
                                @include("admin.layouts.pagination")
                            </div>
                        </div>
                        <div class = "table-responsive">
                            <div class = "col-md-12 text-left">
                                @if($user['type']*1 == 99)
                                <button type = "button" class = "btn btn-primary" onclick = "selItemDisplay('0')">{{__('lang.선택비노출')}}</button>
                                <button type = "button" class = "btn btn-primary" onclick = "selItemDisplay('1')">{{__('lang.선택노출')}}</button>
                                <button type = "button" class = "btn btn-primary" onclick = "selItemDelete()">{{__('lang.선택삭제')}}</button>
                                <a type = "button" class = "btn btn-primary float-right" href = "{{url('admin/notice/info/0')}}"><i class = "fa fa-plus"></i>{{__('lang.공지등록')}}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin/notice_dlg')
    <!-- content -->
    @if(isset($notice_info))
        <input type = "hidden" name = "notice" value = "{!! strip_tags($notice_info['description']) !!}"/>
    @endif
@stop


{{-- page level scripts --}}
@section('footer_scripts')
    <script>
        $(function(){
            @if(isset($notice_info))
            noticeMsg($("input[name='notice']").val());
            @endif
        });

        function noticeInfo(id){
            window.location.href = "{{url('admin/notice/info')}}/"+id;
        }
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/pages/admin/notice.js') }}" ></script>

@stop