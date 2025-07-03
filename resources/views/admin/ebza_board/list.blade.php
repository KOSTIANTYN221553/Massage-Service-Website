@extends('admin/layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
    {{__('lang.익명게시판')}}
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
        <h1>{{__('lang.익명게시판')}}</h1>
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
                                {{__('lang.익명게시판')}}
                            </div>
                        </div>
                    </div>
                    <div class="panel-body ">
                        <form id = "searchFrm" action = "{{url("admin/ebza_board")}}" method = "post">
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
                                                <option value="title">{{__('lang.게시판타이틀')}}</option>
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
                                        <th class = "sorting" aria-name = "id">{{__('lang.이미지')}}</th>
                                        <th class = "sorting" aria-name = "title">{{__('lang.제목')}}</th>
                                        <th  >{{__('내용')}}</th>
                                        <th >{{__('lang.보기')}}</th>
                                        <th>{{__('lang.수정')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $key => $item)
                                    <tr>
                                        <td><input type = "checkbox" class = "custom-checkbox" value = "{{$item['id']}}"></td>
                                        <td class  ="cursor" onclick = "viewDetail(this)" data-id = "{{$item['id']}}">
                                            <img onerror = "noExitImg(this)" src ="{{correctImgPath($item['user']['photo_url'])}}" class = "wh-80"/>
                                        </td>
                                        <td class  ="cursor" onclick = "viewDetail(this)" data-id = "{{$item['id']}}">{{$item['title']}}</td>
                                        <td class  ="cursor" onclick = "viewDetail(this)" data-id = "{{$item['id']}}">{{utf8_strcut(strip_tags($item['description']), 30)}}</td>
                                        <td class  ="cursor" onclick = "viewDetail(this)" data-id = "{{$item['id']}}">
                                            <span class = "float-left">
                                                <i class = "fa fa-eye"></i><span class = "ml-5">{{$item['view_count']}}</span>
                                            </span>
                                            <span class = "float-right">
                                                <i class = "fa fa-comment"></i><span class = "ml-5">{{$item['reply_count']}}</span>
                                            </span>
                                        </td>
                                        <td>
                                            <a class = "btn btn-danger" href = "{{url("admin/ebza_board/info/".$item['id'])}}">{{__('lang.수정')}}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if(count($list) == 0)
                                    <tr>
                                        <td colspan = "6">{{__('lang.자료가 없습니다.')}}</td>
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
                                <button type = "button" class = "btn btn-primary" onclick = "selItemDelete()">{{__('lang.선택삭제')}}</button>
                                <a type = "button" class = "btn btn-primary float-right" href = "{{url('admin/ebza_board/info/0')}}"><i class = "fa fa-plus"></i>{{__('lang.글쓰기')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- content -->

@stop


{{-- page level scripts --}}
@section('footer_scripts')
    <script type="text/javascript" src="{{ asset('assets/js/pages/admin/ebza_board.js') }}" ></script>
    <script>
        function viewDetail(obj){
            var id = $(obj).attr("data-id");
            var url = "{{url('admin/ebza_board/view')}}/"+id;
            window.location.href = url;
        }
        $(function(){
            loading_stop();
        });
    </script>
@stop