@extends('layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
{{__('lang.스케쥴상세')}}
@parent
@stop

{{-- page level styles --}}
@section('header_styles')
    <!--page level css starts-->
    <!--end of page level css-->
    <style>
        .schedule-detail{
            border-bottom:1px solid #b3b3b3;
        }
        .schedule-detail-left{
            padding-top:10px;
            padding-bottom:10px;
            color:black;
            text-align:center;
            background: #747474;
            min-height:60px;
        }
        .schedule-detail-left span{
            color:black;
        }

        .schedule-detail-right{
            padding-top:10px;
            padding-bottom:10px;
            background:black;
            text-align:left;
            color: #747474;
            overflow-x: auto;
            max-height: 42px;
            word-wrap: break-word;
            min-height:60px;
        }

        .badge-danger{
            padding:3px 5px;
            color:#855b55;
            background:#f56954;
            cursor:pointer;

        }
        .schedule-table thead th{
            background: #dff0d8;
            color:#7aaabe;
        }

        .html-left-wrapper{
            display: inline-block;
            height:200px;
        }
        .html-wrapper{
            margin-top:0px;height:200px;  padding:10px;
        }

        .html-wrapper div{
            background: black;margin:10px;overflow: auto;height:100px;color: #909090;
        }

        @media (max-width:480px) {
            .html-left-wrapper{
                display:none;
            }
            .html-wrapper{
                margin-top:0px;height:auto;  padding:10px;
            }
            .html-wrapper div{
                background: black;margin:10px;overflow: auto;height:auto;color: #909090;
            }

            .table-scrollable{
                padding-left:10px;
                padding-right:10px;
            }

        }
        #description img {
            width: 100% !important;
            height: auto !important;
        }

    </style>
@stop
{{-- slider --}}
{{-- content --}}
@section('content')
    <div class="container ">
        <div class = "row">
            <div class = "col-md-9 col-xs-12 mt-10">
                <div class ="row hidden-sm hidden-md hidden-lg mt-10 mb-10">
                    <div class ="col-md-12">
                        <div class="media">
                            <div class="media-left media-middle">
                                <a href="#">
                                    <img class="media-object img-circle" src="{{url($info['shop']['img'])}}" style ="width:40px;height:40px;" onerror="noExitImg(this)" alt="image">
                                </a>
                            </div>
                            <div class="media-body">
                                <p class="media-heading">
                                    @if($info['is_force_end'] == "0") {{$info['title']}} @else {{__('lang.마감 하였습니다')}} @endif
                                </p>
                                <p class="">
                                    <span>{{substr($info['updated_at'],0,10)}}</span>
                                    <i class="fa fa-eye text-white-gray ml-10"></i><span class = "text-white-gray ml-5 cursor">{{$info['view_count']}}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row content bg-black-grey relative pt-20 pb-10 hidden-xs">
                    <div style ="position:absolute; width:100%; top:10px; height:2px; left:0px; background: #565656;" ></div>
                    <div class = "col-md-10 col-xs-12 text-left ">
                        <span class = "font-16 color-white-gray">@if($info['is_force_end'] == "0") {{$info['title']}} @else {{__('lang.마감 하였습니다')}} @endif</span>
                    </div>
                    <div class = "col-md-2 col-xs-12 text-right">
                        <span class = "color-white-gray">{{__('lang.조회수')}}: </span> <span class ="color-red ml-10">{{number_format($info['view_count'])}}</span> <span class = "color-white-gray">{{__('lang.회')}}</span>
                    </div>
                </div>
                <div class = "row">
                    <div class ="col-md-6">
                        <div class = "row">
                            <div class ="col-md-4 col-xs-4  schedule-detail-left schedule-detail">
                                <span>{{__('lang.업소이름')}}</span>
                            </div>
                            <div class ="col-md-8  col-xs-8 schedule-detail-right schedule-detail">
                                <span>@if(isset($info['shop'])){{$info['shop']['title']}} @else {{__('lang.미정')}} @endif </span>
                            </div>
                        </div>
                    </div>
                    <div class ="col-md-6">
                        <div class = "row">
                            <div class ="col-md-4 col-xs-4 schedule-detail-left schedule-detail">
                                <span>{{__('lang.업소종류')}}</span>
                            </div>
                            <div class ="col-md-8 col-xs-8 schedule-detail-right schedule-detail">
                                <span>@if(isset($info['shop'])) {{$info['shop']['shop_type']['title']}} @else {{__('lang.미정')}} @endif</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class ="col-md-6">
                        <div class = "row">
                            <div class ="col-md-4 col-xs-4 schedule-detail-left schedule-detail">
                                <span>{{__('lang.예약전화번호')}}</span>
                            </div>
                            <div class ="col-md-8 col-xs-8 schedule-detail-right schedule-detail">
                                <span>{{$info['shop_phone']}}</span>
                            </div>
                        </div>
                    </div>
                    <div class ="col-md-6">
                        <div class = "row">
                            <div class ="col-md-4 col-xs-4 schedule-detail-left schedule-detail">
                                <span>{{__('lang.영업시간')}}</span>
                            </div>
                            <div class ="col-md-8 col-xs-8 schedule-detail-right schedule-detail">
                                <span>{{$info['s_time']}} ~{{$info['e_time']}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class ="col-md-6">
                        <div class = "row">
                            <div class ="col-md-4 col-xs-4  schedule-detail-left schedule-detail">
                                <span class ="text-ellipsis">SNS</span>
                            </div>
                            <div class ="col-md-8 col-xs-8 schedule-detail-right schedule-detail">
                                <span>{{$info['sns_id']}}</span>
                            </div>
                        </div>
                    </div>
                    <div class ="col-md-6">
                        <div class = "row">
                            <div class ="col-md-4 col-xs-4 schedule-detail-left schedule-detail">
                                <span>{{__('lang.위치')}}</span>
                            </div>
                            <div class ="col-md-8 col-xs-8 schedule-detail-right schedule-detail">
                                <span>{{$info['location']}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class ="col-md-12">
                        <div class = "row">
                            <div class ="col-md-2  html-left-wrapper schedule-detail-left schedule-detail">
                                <span>{{__('lang.서비스요금 및 코스안내')}}</span>
                            </div>
                            <div class ="col-md-10 html-wrapper schedule-detail-right schedule-detail" style = "max-height:200px;">
                                <div style ="">
                                    {!! $info['description'] !!}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class = "row mt-10">
                    <div class ="col-md-12 pr-0 pl-0">
                        <div class ="table-scrollable">
                            <table class = "table table-striped schedule-table">
                            <thead>
                                <tr>
                                    <th>{{__('lang.이름')}}</th>
                                    <th>{{__('lang.나이')}}</th>
                                    <th>{{__('lang.사이즈')}}</th>
                                    <th>{{__('lang.키')}}</th>
                                    <th>{{__('lang.가슴')}}</th>
                                    <th class = "hidden-xs">{{__('lang.흡연여부')}}</th>
                                    <th class = "hidden-xs">{{__('lang.근무시간')}}</th>
                                    <th class = "hidden-xs text-center">{{__('lang.프로필')}}</th>
                                    <th>{{__('lang.사진')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($info['detail_list'] as $item)
                                    <tr>
                                        <td>{{$item['manager']['nickname']}}</td>
                                        <td>{{$item['manager']['age']}}</td>
                                        <td>{{$item['manager']['body_size']}}</td>
                                        <td>{{$item['manager']['height']}}</td>
                                        <td>{{$item['manager']['cup_size']}}</td>
                                        <td class = "hidden-xs">{{$item['manager']['is_smoking']}}</td>
                                        <td class = "hidden-xs">{{$item['schedule_start_at']}} ~{{$item['schedule_end_at']}} </td>
                                        <td class = "hidden-xs" style = "width: 30%; word-break: break-all;">
                                            {!! strip_tags($item['manager']['description']) !!}
                                        </td>
                                        <td>
                                            @if($item['manager']['photo_url'] != '')
                                                <a  onclick = "viewImg(this)" class = "cursor" src = "{{url($item['manager']['photo_url'])}}" href ="javascript:void(0)" >{{__('lang.보기')}}</a>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                                @if(count($info['detail_list']) == 0)
                                    <tr>
                                        <td colspan ="9">{{__('lang.자료가 없습니다.')}}</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <div class = "row">
                    <div class = "col-md-12" id = "description">
                        {!! $info['description2'] !!}
                    </div>
                </div>

            </div>
            <div class = "col-md-3 hidden-xs">
                @include('layouts/right-side')
            </div>
        </div>
    <!-- //Container End -->
    </div>
    @include('dlg/img_view_dlg')
@stop
{{-- footer scripts --}}
@section('footer_scripts')
    <script>
        function  detailView(obj){
            var id = $(obj).attr("data-id");
            window.location.href = "{{url("/schedule_info")}}/"+id;
        }
        function viewImg(obj){
            $("#img-view-dialog #img").attr("src", $(obj).attr("src"));
            $("#img-view-dialog").modal("show");
        }
    </script>

@stop
