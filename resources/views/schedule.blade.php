@extends('layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
{{__('lang.업소소개')}}
@parent
@stop

{{-- page level styles --}}
@section('header_styles')


@stop
{{-- slider --}}
{{-- content --}}
@section('content')
    <?php
        $user_info = getLoginUserInfo();
        $user_id = $user_info['id'];
    ?>
    <div class="container mt-10">
        @if(isset($page_title))
            <div class = "row">
                <div class = "col-md-12 col-xs-12 page-title-wrapper">
                    <span class = ""> {{$page_title}}</span>
                </div>
            </div>
        @endif
        <div class = "row">
            <div class = "col-md-9 col-xs-12">
                <form id = "searchForm" action = "{{url("schedule/".$shop_type)}}"  method = "get">
                    <input type = "hidden" name = "_token" value = "{{csrf_token()}}"/>
                    <input type = "hidden" name = "category_id" value = "{{$category_id}}"/>
                </form>
                @if(isset($category_list))
                <div class="row">
                    <div class = "col-md-12 col-xs-12 margin-box">
                        <ul class = "category_list">
                            @foreach($category_list as $item)
                                <li class = "cursor @if($item['id']*1 == $category_id*1) active @endif" onclick = "changeCategoryItem(this)" data-id = "{{$item['id']}}"> {{$item['title']}}({{$item['cnt']}})</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                @endif
                <div class="row">
                    <div class = "col-md-12 col-xs-12 margin-box">
                        <div class = "table-scrollable ">
                            <table class = "table table-striped">
                                <thead>
                                    <tr>
                                        <th class = "text-center hidden" style = "width:3%;">No</th>
                                        <th class = "text-center" style = "width:10%;">{{__('lang.분류')}}</th>
                                        <th class = "text-center" style = "width:13%;">{{__('lang.업소명')}}</th>
                                        <th class = "text-center" style = "width:32%;">{{__('lang.제목')}}</th>
                                        <th class = "text-center  hidden-xs" style = "width:15%;">{{__('lang.수정날짜')}}</th>
                                        <th class = "text-center hidden-xs" style = "width:8%;">{{__('lang.조회수')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $self = 0; ?>
                                @foreach($list as $key => $item)
                                    <?php if($item['user_id'] == $user_id) $self = 1;?>
                                    <tr class = "cursor">
                                        <td style = "width:3%;" class = "text-center hidden" onclick = "detailView(this)" data-id = "{{$item['id']}}">{{$key+1}}</td>
                                        <td style = "width:10%;" class = "text-center" onclick = "detailView(this)" data-id = "{{$item['id']}}">{{$item['categoryName']}}</td>
                                        <td style = "width:13%;" class = "text-center" onclick = "detailView(this)" data-id = "{{$item['id']}}">
                                           {{$item['shop_title']}}
                                        </td>
                                        <td class = "text-left" style = "width:32%;"  onclick = "detailView(this)" data-id = "{{$item['id']}}">
                                            @if($item['is_force_end'] == "0") {{utf8_strcut($item['title'], 40)}} @else {{__('lang.마감 하였습니다')}} @endif
                                        </td>
                                        <td style = "width:15%;" class = "text-center hidden-xs" onclick = "detailView(this)" data-id = "{{$item['id']}}">{{substr($item['updated_at'],0,10)}}</td>
                                        <td style = "width:8%;" class = "text-center hidden-xs" onclick = "detailView(this)" data-id = "{{$item['id']}}">{{$item['view_count']}}</td>
                                    </tr>
                                @endforeach
                                @if(count($list) == 0)
                                    <tr>
                                        <td colspan ="8">{{__('lang.자료가 없습니다.')}}</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class = "row">
                            <div class = "col-md-8 text-left col-xs-12">
                            </div>
                            <div class = "col-md-4 text-right mt-10 col-xs-12" style = "margin-top:17px;">
                                @if(Sentinel::check())
                                    <?php $user = Sentinel::getuser(); $complete_info = $user->shop_complete_info();?>

                                    @if($complete_info['diff']*1 != -1)
                                    @if($self == 1)
                                        <a class = "btn-danger write-a"  href = "javascript:void(0);" style = "color:white; border:none;" onclick = "forceCompleteSchedule()">{{__('lang.마감하기')}}</a>
                                    @endif
                                    <a class = "btn-danger write-a"  href = "{{url("admin/schedule")}}" style = "color:white; border:none;">[ {{__('lang.스케줄생성')}} ]</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class = "text-center" style = "margin-top:10px;">

                        </div>
                </div>
            </div>
            </div>
            <div class = "col-md-3 hidden-xs">
                @include('layouts/right-side')
            </div>
        </div>
    <!-- //Container End -->
    </div>
@stop
{{-- footer scripts --}}
@section('footer_scripts')
    <script>
        $(function(){
           loading_stop();
        });

        function forceCompleteSchedule(){

            var shop_type = "{{$shop_type}}";
            var category_id = "{{$category_id}}";
            var param = new Object();
            param._token = _token;
            param.shop_type = shop_type;
            param.category_id = category_id;
            var url = "{{url('/schedule_force_complete')}}";
            $.post(url,param, function(data){
                if(data.status == "1"){
                    successMsg("{{__('lang.성공하였습니다')}}");
                    setTimeout(function(){
                        window.location.reload();
                    },2000);
                }else{
                    errorMsg(data.msg);
                }
            },"json");
        }

        function changeCategoryItem(obj){
            var category_id = $(obj).attr("data-id");
            loading_start();
            $("#searchForm input[name='category_id']").val(category_id);
            $("#searchForm input[name='page']").val("0");
            $("#searchForm").submit();

        }


        function  detailView(obj){
            var id = $(obj).attr("data-id");
            window.location.href = "{{url("/schedule_info")}}/"+id;
        }
        function searchData(page) {
            $("#searchForm input[name='page']").val(page);
            $("#searchForm").submit();
        }


    </script>

@stop
