@extends('admin/layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
    {{__('lang.업소후기')}}
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
        <h1>{{__('lang.업소후기')}}</h1>
    </section>
    <!--section ends-->
    <?php $user = Sentinel::getuser(); ?>
    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary filterable">
                    <div class="panel-heading clearfix  ">
                        <div class="panel-title pull-left">
                            <div class="caption">
                                <i class="livicon" data-name="camera" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                                {{__('lang.업소후기')}}
                            </div>
                        </div>
                    </div>
                    <div class="panel-body ">
                        <form id = "searchFrm" action = "{{url("admin/review")}}" method = "post">
                            <input type = "hidden" name = "page" value = "{{$pageParam['pageNo']}}"/>
                            <input type = "hidden" name = "_token" value = "{!! csrf_token() !!}"/>
                            <input type = "hidden" name ="order_key" value = "{{$order_key}}"/>
                            <input type = "hidden" name ="order_val" value = "{{$order_val}}"/>
                            <input type = "hidden" id = "category_id1" value = "{{$category_id}}"/>
                            <div class="page_section_1 page_section search_section" id="search_filter_layout">
                                <div class="col-md-6">
                                    <div class = "row">
                                        <div class = "col-md-2">
                                            <label>{{__('lang.검색어')}}</label>
                                        </div>
                                        <div class = "col-md-4">
                                            <select class="form-control" data-width="120px"  name = "search_key_type">
                                                <option value="review_board.title" @if($search_key_type =='review_board.title') selected @endif>{{__('lang.타이틀')}}</option>
                                            </select>
                                        </div>
                                        <div class = "col-md-6">
                                            <div class="form-group input-group">
                                                <input type="text" class="form-control" name = "search" value = "{{$search}}" minlength = "2" placeholder=" {{__('lang.검색어를 입력해 주세요(2자 이상)')}}">
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
                                        <div class = "col-md-2">
                                            <select class="form-control" data-width="120px"  name = "board_type" onchange="getCategoryList()">
                                                <option value="0">{{__('lang.전체')}}</option>
                                                @foreach($shop_type_list as $key =>$type)
                                                    <option value = "{{$type['id']}}" @if($board_type*1 == $type['id']*1) selected @endif>{{$type['title']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class = "col-md-3">
                                            <select class="form-control" data-width="120px"  name = "category_id">
                                                <option value="0">{{__('lang.전체')}}</option>
                                            </select>
                                        </div>
                                        <div class = "col-md-4">
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
                                        <th style = "width:3%"><input type = "checkbox" class = "custom-checkbox" id = "allCheck"/></th>
                                        <th style = "width:8%" class = "sorting" aria-name = "shop_type.id">{{__('lang.업소타입')}}</th>
                                        <th style = "width:10%" class = "sorting" aria-name = "shop.title">{{__('lang.업소이름')}}</th>
                                        <th style = "width:20%" class = "sorting" aria-name = "review_board.title">{{__('lang.제목')}}</th>
                                        <th style = "width:35%" class = "sorting" aria-name = "review_board.description">{{__('lang.내용')}}</th>
                                        <th style = "width:7%" class = "sorting" aria-name = "user.nickname">{{__('lang.작성자')}}</th>
                                        <th style = "width:7%" class = "sorting" aria-name = "review_board.created_at">{{__('lang.날짜')}}</th>
                                        <th  style = "width:5%"  >{{__('lang.보기')}}</th>
                                        @if($user['type']*1 == 99)
                                        <th>{{__('lang.수정')}}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $key => $item)
                                    <tr>
                                        <td><input type = "checkbox" class = "custom-checkbox" value = "{{$item['id']}}"></td>
                                        <td  class  ="cursor" onclick = "viewDetail(this)" data-id = "{{$item['id']}}">{{$item['shop_type_title']}}</td>
                                        <td  class  ="cursor" onclick = "viewDetail(this)" data-id = "{{$item['id']}}">{{$item['shop_title']}}</td>
                                        <td  class  ="cursor" onclick = "viewDetail(this)" data-id = "{{$item['id']}}">{{$item['title']}}</td>
                                        <td  class  ="cursor" onclick = "viewDetail(this)" data-id = "{{$item['id']}}">{{utf8_strcut(strip_tags($item['description']), 30)}}</td>
                                        <td  class  ="cursor" onclick = "viewDetail(this)" data-id = "{{$item['id']}}">{{$item['user_nickname']}}</td>
                                        <td  class  ="cursor" onclick = "viewDetail(this)" data-id = "{{$item['id']}}">{{$item['created_at']}}</td>
                                        <td  class  ="cursor" onclick = "viewDetail(this)" data-id = "{{$item['id']}}">
                                            <span class = "float-left">
                                                <i class = "fa fa-eye"></i><span class = "ml-5">{{$item['view_count']}}</span>
                                            </span>
                                                        <span class = "float-right">
                                                <i class = "fa fa-comment"></i><span class = "ml-5">{{$item['reply_count']}}</span>
                                            </span>
                                        </td>
                                        @if($user['type']*1 == 99)
                                        <td>
                                            <a class = "btn btn-danger" href = "{{url("admin/review/info/".$item['id'])}}">{{__('lang.수정')}}</a>
                                        </td>
                                        @endif
                                    </tr>
                                @endforeach
                                @if(count($list) == 0)
                                    <tr>
                                        <td colspan = "9">{{__('lang.자료가 없습니다.')}}</td>
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
                                <button type = "button" class = "btn btn-primary" onclick = "selItemDelete()">{{__('lang.선택삭제')}}</button>
                                <a type = "button" class = "btn btn-primary float-right" href = "{{url('admin/review/info/0')}}"><i class = "fa fa-plus"></i>{{__('lang.글쓰기')}}</a>
                                @endif
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
    <script type="text/javascript" src="{{ asset('assets/js/pages/admin/review.js') }}" ></script>
    <script>
        $(function(){
            getCategoryList();
        });

        function viewDetail(obj){
            var id = $(obj).attr("data-id");
            var url = "{{url('admin/review/view')}}/"+id;
            loading_start();
            window.location.href = url;
        }

        function  getCategoryList(){
            var shop_type = $("select[name='board_type']").val();
            if(shop_type == "0"){
                $("select[name='category_id']").html("<option value = '0'>{{__('lang.전체')}}</option>")
            }
            var param = new Object();
            param.shop_type = shop_type;
            param._token = _token;
            var url = "{{url('admin/review/getCategoryList')}}";
            $.post(url, param, function(html){
                $("select[name='category_id']").html(html);
                var category_id1 = $("#category_id1").val();
                $("select[name='category_id']").val(category_id1);
            });

        }
    </script>
@stop