@extends('layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
{{__('lang.제휴문의')}}
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
        <div class = "row">
            <div class = "col-md-8 cols-xs-12">
                <div class="row">
                    <div class = "col-md-12">
                        <div class = "table-scrollable">
                            <table class = "table table-striped table-board">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>{{__('lang.제목')}}</th>
                                        <th>{{__('lang.날짜')}}</th>
                                        <th>{{__('lang.상태')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $key => $item)
                                    <tr>
                                        <td onclick = "detailView(this)" data-id ="{{$item['id']}}">{{$key+$pageParam['startNumber']+1}}</td>
                                        <td onclick = "detailView(this)" data-id ="{{$item['id']}}">{{utf8_strcut(strip_tags($item['title']),30)}}</td>
                                        <td onclick = "detailView(this)" data-id ="{{$item['id']}}">{{substr($item['created_at'],11,5)}}</td>
                                        <td onclick = "detailView(this)" data-id ="{{$item['id']}}">{{getQuestionStatusStr($item['status'])}}</td>
                                    </tr>
                                @endforeach
                                @if(count($list) == 0)
                                    <tr>
                                        <td colspan = "5">{{__('lang.자료가 없습니다.')}} </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <div class = "row">
                            <div class = "col-md-8 text-left col-xs-12">
                                <form id = "searchForm" action = "{{url('question')}}" method = "post">
                                    <input type = "hidden" name ="_token" value ="{{csrf_token()}}"/>
                                    <input type = "hidden" name = "page" value = "{{$pageParam['pageNo']}}"/>
                                    <div class = "row">
                                        <div class = "col-md-6 mt-10 mb-10" style = "margin-top:8px;">
                                            <select class = "form-control search-select radius-0" name = "search_type" style ="height:38px;">
                                                <option value ="title" @if($search_type == 'title') selected @endif>{{__('lang.제목')}}</option>
                                                <option value ="title&content" @if($search_type == 'title&content') selected @endif>{{__('lang.제목')}}&{{__('lang.내용')}}</option>
                                                <option value ="reply" @if($search_type == 'reply') selected @endif>{{__('lang.댓글')}}</option>
                                            </select>
                                        </div>
                                        <div class = "col-md-6 mt-10 mb-10" style = "display:table;margin-top:8px;">
                                            <input type = "text" class = "form-control search-input radius-0"  style ="height:38px;" name = "search_title" value ="{{$search_title}}" placeholder ="{{__('lang.검색어를 입력해주세요')}}">
                                            <span class="input-group-btn">
                                        <button class="btn btn-default radius-0" type="button" onclick = "searchData(0)" style = "background: black;color: white; height:38px;">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class = "col-md-4 text-right mt-10 col-xs-12" style = "margin-top:17px;">
                                @if(Sentinel::check())
                                    <a class = "color-white write-a btn-danger border-none"  href = "{{url("question/write/0")}}" style = "color:white;">{{__('lang.글쓰기')}}</a>
                                @endif
                            </div>
                        </div>
                        <div class = "text-center relative" style = "margin-top:10px;">
                            @include("layouts/pagination")
                        </div>

                </div>
            </div>
            </div>
            <div class = "col-md-4 hidden-xs">
                @include('layouts/right-side')
            </div>
        </div>
@stop
{{-- footer scripts --}}
@section('footer_scripts')
    <script>
        $(function(){
            var url = $("#searchForm").attr("action")+"?"+$("#searchFrm").serialize();
            setPageUrl(url);
        });
        function searchData(page) {
            $("#searchForm input[name='page']").val(page);
            $("#searchForm").submit();
        }
        function  detailView(obj){
            var id = $(obj).attr("data-id");
            window.location.href = "{{url("/question_info")}}/"+id;
        }
        $(function(){

        });

        $("#reviewForm textarea[name='description']").ckeditor({
            height: '200px'
        });

        $("#reviewForm").validate({
            rules: {
                shop_id: "required",
                title: "required",
                description: "required",
            },

            messages: {

            },
            errorPlacement: function (error, element) {
                if($(element).closest('div').children().filter("div.error-div").length < 1)
                    $(element).closest('div').append("<div class='error-div'></div>");
                $(element).closest('div').children().filter("div.error-div").append(error);
            },
            submitHandler: function(form){
                var url = $(form).attr("action");
                var fdata = new FormData($("#reviewForm")[0]);
                fdata.append("description", $("#reviewForm textarea[name='description']").val());
                loading_start();
                $.ajax({
                    url: url,
                    type: 'post',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: fdata,
                    dataType:"json",
                    success: function (data) {
                        loading_stop();
                        if (data.status == '1') {
                            successMsg("{{__('lang.수정이 성공하였습니다.')}}", function(){
                                window.location.reload();
                            });
                        } else {
                            errorMsg(data.msg);
                        }
                    },
                    error: function() {
                        errorMsg("{{__('lang.서버에서 오류가 발생하였습니다.')}}");
                    }
                })

            }

        });

    </script>
@stop
