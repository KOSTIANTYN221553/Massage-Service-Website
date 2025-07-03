@extends('admin/layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
    @if($id*1 == 0) {{__('lang.공지등록')}} @else {{__('lang.공지수정')}} @endif
    @parent
@stop
@section('header_styles')
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}"  rel="stylesheet" type="text/css" />
@stop
{{-- Page content --}}
@section('content')

    <section class="content-header">
        <h1>@if($id*1 == 0){{__('lang.공지등록')}} @else {{__('lang.공지수정')}} @endif</h1>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            {{__('lang.공지정보')}}
                        </h3>
                        <span class="pull-right">
                            <i class="glyphicon glyphicon-chevron-up clickable"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <form  id = "infoForm" action = "{{url("admin/notice/ajaxSaveInfo")}}" method = "post">
                            <input type = "hidden" name = "_token" value = "{{csrf_token()}}"/>
                            <input type = "hidden" name = "id" value = "{{$id}}"/>
                            <input type = "hidden" name = "is_always_display" value = "0"/>
                            <div class="form-group">
                                <label class="control-label">{{__('lang.공지타이틀')}}</label>
                                <input  name="title" type="text" placeholder="{{__('lang.예명을 입력해주세요')}}" @if($user['type']*1 == 70) readonly @endif class="form-control" value = "{{$info['title']}}">
                            </div>
                            <div class = "form-group @if($user['type']*1 == 70) hidden @endif">
                                <label>{{__('lang.공지타입')}}</label>
                                <select class = "form-control" name = "type">
                                    <option value="1"  >{{__('lang.이용안내')}}</option>
                                    <option value="2" @if($info['type']*1 == 2) selected @endif>{{__('lang.제휴')}}</option>
                                    <option value="3" @if($info['type']*1 == 3) selected @endif>{{__('lang.결제')}}</option>
                                    <option value="4" @if($info['type']*1 == 4) selected @endif>{{__('lang.이벤트')}}</option>
                                    <option value="5" @if($info['type']*1 == 5) selected @endif>{{__('lang.기타')}}</option>
                                    <option value="6" @if($info['type']*1 == 6) selected @endif>{{__('lang.관리자공지')}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="description">{{__('lang.공지내용')}}</label>
                                <textarea class="form-control resize_vertical" id="description" @if($user['type']*1 == 70) readonly @endif name="description" placeholder="" rows="5" style = "resize:none;">{!! $info['description'] !!}</textarea>
                            </div>

                            <div class = "form-group @if($user['type']*1 == 70) hidden @endif ">
                                <label>{{__('lang.상시노출')}}</label>
                                <input type = "checkbox" class = "custom-checkbox" id  = "is_always_display" @if($info['is_always_display']*1 == 1) checked @endif >
                            </div>
                            <div class="form-group @if($user['type']*1 == 70) hidden @endif">
                                <label class="control-label">{{__('lang.노출기간')}}</label>
                            </div>
                            <div class="form-group input-group @if($user['type']*1 == 70) hidden @endif">
                                <input type="text" class="form-control date-picker" name = "display_start_at" value = "{{$info['display_start_at']}}"  placeholder="YYYY-MM-DD">
                                <span class="input-group-btn">
                                    <button class="btn btn-default " type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                            <div class="form-group input-group @if($user['type']*1 == 70) hidden @endif">
                                <input type="text" class="form-control date-picker" name = "display_end_at" value = "{{$info['display_end_at']}}"  placeholder="YYYY-MM-DD">
                                <span class="input-group-btn">
                                    <button class="btn btn-default " type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>


                            <div class="form-position">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-responsive btn-success btn-sm" onclick = "goBack()">{{__('lang.리스트로 이동')}}</button>
                                    @if($user['type']*1 == 99)
                                    <button type="submit" class="btn btn-responsive btn-primary btn-sm">{{__('lang.등록')}}</button>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- content -->
    @include("dlg/crop_dlg")
@stop

@section('footer_scripts')
    <script src="{{ asset('assets/vendors/jasny-bootstrap/js/jasny-bootstrap.js') }}" ></script>
<script>
    $(function(){
       loading_stop();
    });
    function delImage(obj){
        $("#photo_url_img").attr("src", "");
        $("#photo_url_val").val("");
        $(obj).addClass("hidden");

    }

    $(function() {

        $(".date-picker").datepicker({
            format: "yyyy-mm-dd",
        });
        $('input[type="checkbox"].custom-checkbox, input[type="radio"].custom-radio').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue',
            increaseArea: '20%'
        });

        $('textarea#description').ckeditor({
            height: '400px'
        });

        $("#infoForm").validate({
            rules: {
                title: "required",
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
                var fdata = new FormData($("#infoForm")[0]);
                fdata.append("description", $("textarea[name='description']").val());
                fdata.append("is_always_display", is_always_display);
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
                        if (data.status == '1') {
                            successMsg("{{__('lang.수정이 성공하였습니다.')}}", function(){
                               var id = $("input[name='id']").val();
                               if(id ==0){
                                   window.location.href = "{{url("admin/customer")}}";
                               }
                               goBack();
                            });
                        } else {
                            loading_stop();
                            errorMsg(data.msg);
                        }
                    },
                    error: function() {
                        loading_stop();
                        errorMsg("{{__('lang.서버에서 오류가 발생하였습니다.')}}");
                    }
                })

            }
        });
    });
</script>
@stop
