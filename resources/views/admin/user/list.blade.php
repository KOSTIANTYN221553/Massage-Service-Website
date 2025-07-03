@extends('admin/layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
    {{__('lang.고객목록')}}
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
        <h1>{{__('lang.고객목록')}}</h1>
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
                                {{__("lang.고객리스트")}}
                            </div>
                        </div>
                    </div>
                    <div class="panel-body ">
                        <form id = "searchFrm" action = "{{url("admin/user")}}" method = "post">
                            <input type = "hidden" name = "page" value = "{{$pageParam['pageNo']}}"/>
                            <input type = "hidden" name = "_token" value = "{!! csrf_token() !!}"/>
                            <input type = "hidden" name ="order_key" value = "{{$order_key}}"/>
                            <input type = "hidden" name ="order_val" value = "{{$order_val}}"/>
                            <div class="page_section_1 page_section search_section" id="search_filter_layout">
                                <div class = "row">
                                    <div class = "col-md-2">
                                        <label>
                                            {{__('lang.전체회원')}}: &nbsp;&nbsp;{{$totalCount}} {{__("lang.명")}}
                                        </label>
                                    </div>
                                    <div class = "col-md-8">
                                        <div class="form-group">
                                            <label >

                                            </label>    &nbsp;

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class = "row">
                                        <div class = "col-md-2">
                                            <label>
                                                {{__('lang.상태')}}
                                            </label>
                                        </div>
                                        <div class = "col-md-8">
                                            <div class="form-group">
                                                <label class="checkbox-inline">
                                                    &nbsp;<input type="radio" class="custom-radio" @if($filter_status*1 == 0) checked @endif name="filter_status" value="0" >&nbsp;{{__('lang.전체')}}</label>
                                                <label class=" checkbox-inline">
                                                    <input type="radio" class="custom-radio"  name="filter_status" @if($filter_status*1 == 1) checked @endif value="1" > {{__('lang.활성')}}</label>
                                                <label class="checkbox-inline" >
                                                    <input type="radio"  class="custom-radio" name="filter_status" @if($filter_status*1 == 91) checked @endif value="91" >&nbsp;{{__('lang.탈퇴')}}</label>
                                                <label class="checkbox-inline" >
                                                    <input type="radio"  class="custom-radio" name="filter_status" @if($filter_status*1 == 99) checked @endif value="99" >&nbsp;{{__('lang.강퇴')}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class = "row">
                                        <div class = "col-md-2">
                                            <label>{{__('lang.검색어')}}</label>
                                        </div>
                                        <div class = "col-md-4">
                                            <select class="form-control" data-width="120px"  name = "search_key_type">
                                                <option value="email" @if($search_key_type == 'email') selected @endif>{{__('lang.아이디')}}</option>
                                                <option value="nickname" @if($search_key_type == 'nickname') selected @endif>{{__('lang.예명')}}</option>
                                                <option value="phone" @if($search_key_type == 'phone') selected @endif>{{__('lang.전화번호')}}</option>
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
                                            <label>
                                                {{__('lang.타입')}}
                                            </label>
                                        </div>
                                        <div class = "col-md-8">
                                            <div class="form-group">
                                                <label class="checkbox-inline">
                                                    &nbsp;<input type="radio" class="custom-radio" @if($filter_type*1 == 0) checked @endif name="filter_type" value="0" >&nbsp;{{__('lang.전체')}}</label>
                                                <label class=" checkbox-inline">
                                                    <input type="radio" class="custom-radio"  name="filter_type" @if($filter_type*1 == 99) checked @endif value="99" > {{__('lang.관리자')}}</label>
                                                <label class="checkbox-inline" >
                                                    <input type="radio"  class="custom-radio" name="filter_type" @if($filter_type*1 == 70) checked @endif value="70" >&nbsp;{{__('lang.업주')}}</label>
                                                <label class="checkbox-inline" >
                                                    <input type="radio"  class="custom-radio" name="filter_type" @if($filter_type*1 == 1) checked @endif value="1" >&nbsp;{{__('lang.일반고객')}}</label>
                                            </div>
                                        </div>
                                    </div>
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
                                        <th class = "sorting" >{{__('lang.타입')}}</th>
                                        <th class = "sorting"  aria-name = "level_id">{{__('lang.레벨')}}</th>
                                        <th class = "sorting" aria-name = "email">{{__('lang.아이디')}}</th>
                                        <th class = "sorting" >{{__('lang.프로필사진')}}</th>
                                        <th class = "sorting" aria-name = "nickname">{{__('lang.닉네임')}}</th>
                                        <th class = "sorting" aria-name = "gender">{{__('lang.성별')}}</th>
                                        <th class = "sorting" aria-name = "phone">{{__('lang.전화번호')}}</th>
                                        <th class = "sorting" aria-name = "user_point">{{__('lang.보유포인트')}}</th>
                                        <th class = "sorting" aria-name = "status">{{__('lang.상태')}}</th>
                                        <th class = "sorting" aria-name = "created_at">{{__('lang.가입일')}}</th>
                                        <th>{{__('lang.수정')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $key => $item)
                                    <tr>
                                        <td><input type = "checkbox" class = "custom-checkbox" value = "{{$item['id']}}"></td>
                                        <td>{{getUserTypeStr($item['type'])}}</td>
                                        <td>
                                            @if(isset($item['user_level']['id']))
                                                <img onerror = "noExitImg(this)" style="width:20px !important;" src="{{url($item['user_level']['icon'])}}">{{$item['user_level']['title']}}
                                            @endif
                                        </td>
                                        <td>{{$item['email']}}</td>
                                        <td><img onerror = "noExitImg(this)" src ="{{correctImgPath($item['photo_url'])}}" class = "wh-80"/></td>
                                        <td>{{$item['nickname']}}</td>
                                        <td>{{getUserGenderStr($item['gender'])}}</td>
                                        <td>{{$item['phone']}}</td>
                                        <td>{{$item['user_point']}}</td>
                                        <td>{{getUserStatusStr($item['status'])}}</td>
                                        <td>{{substr($item['created_at'],0,10)}}</td>
                                        <td>
                                            <a class = "btn btn-danger" href = "{{url("admin/user/info/".$item['id'])}}">{{__('lang.수정')}}</a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if(count($list) == 0)
                                    <tr>
                                        <td colspan = "12">{{__('lang.자료가 없습니다.')}}</td>
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
                                <a type = "button" class = "btn btn-primary float-right" href = "{{url('admin/user/info/0')}}"><i class = "fa fa-plus"></i>{{__('lang.고객추가')}}</a>
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
    <script type="text/javascript" src="{{ asset('assets/js/pages/admin/user.js') }}" ></script>
@stop