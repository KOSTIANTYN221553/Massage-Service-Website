@extends('layouts/default')

{{-- Page title --}}
@section('title')
{{__('lang.스케쥴상세')}}
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
    <div class="container ">
        <div class = "row">
            <div class = "col-md-8 col-xs-12 mt-10">
                <div class="row content">
                    <!-- Business Deal Section Start -->
                    <div class="col-sm-12 col-md-12">
                        <div class=" thumbnail featured-post-wide img">
                            <img src="{{url($info['shop']['img'])}}" class="img-responsive w-100" alt="Image">
                            <!-- /.blog-detail-image -->
                            <h2 class="color-white marl12">{{$info['shop']['title']}}</h2>
                            <div class="the-box no-border blog-detail-content">
                                <p class="text-justify font-18 color-white word-break">
                                    {!! $info['description'] !!}
                                </p>
                                <p class="text-justify font-18 color-white word-break">
                                    {!! $info['description2'] !!}
                                </p>
                                <p class="additional-post-wrap">
                                    <span class="additional-post">
                                            <i class="livicon" data-name="user" data-size="13" data-loop="true" data-c="#fff" data-hc="#ddd"></i> {{__('lang.개업날짜:')}} &nbsp;<a href="#">{{substr($info['date'],0,10)}}</a>
                                        </span>
                                    <span class="additional-post" style = "margin-left:10px;">
                                        <i class="livicon" data-name="clock" data-size="13" data-loop="true" data-c="#fff" data-hc="#ddd"></i>봉사시간 <a href="#"> {{$info['s_time']}} - {{$info['e_time']}} </a>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-10">
                <div class = "col-md-12">
                    <div class = "table-scrollable">
                        <table class = "table table-striped table-hover">
                            <thead>
                            <tr>
                                <th class = "text-center">No</th>
                                <th class = "text-center">{{__('lang.이미지')}}</th>
                                <th class = "text-center">{{__('lang.제목')}}</th>
                                <th class = "text-center">{{__('lang.개업날짜')}}</th>
                                <th class = "text-center">{{__('lang.봉사시간')}}</th>
                                <th class = "text-center">{{__('lang.조회수')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($list as $key => $item)
                                <tr>
                                    <td class = "text-center" onclick = "detailView(this)" data-id = "{{$item['id']}}">{{$key+$pageParam['startNumber']+1}}</td>
                                    <td class = "text-center" onclick = "detailView(this)" data-id = "{{$item['id']}}"><img src="{{correctImgPath($item['shop_img'])}}" alt="team-image" class="wh-60"></td>
                                    <td class = "text-center" onclick = "detailView(this)" data-id = "{{$item['id']}}">{{utf8_strcut(strip_tags($item['title']), 30)}}</td>
                                    <td class = "text-center" onclick = "detailView(this)" data-id = "{{$item['id']}}">{{substr($item['date'],0,10)}}</td>
                                    <td class = "text-center" onclick = "detailView(this)" data-id = "{{$item['id']}}">{{$item['s_time']}}-{{$item['e_time']}}</td>
                                    <td class = "text-center" onclick = "detailView(this)" data-id = "{{$item['id']}}">{{$item['view_count']}}</td>
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
                </div>
            </div>
            </div>
            <div class = "col-md-4 hidden-xs">
                @include('layouts/right-side')
            </div>
        </div>
    <!-- //Container End -->
    </div>
@stop
{{-- footer scripts --}}
@section('footer_scripts')
    <script>
        function  detailView(obj){
            var id = $(obj).attr("data-id");
            window.location.href = "{{url("/schedule_info")}}/"+id;
        }
    </script>

@stop
