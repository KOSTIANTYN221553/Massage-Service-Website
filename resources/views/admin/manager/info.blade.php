@extends('admin/layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
    @if($id*1 == 0) {{__('lang.매니저생성')}} @else {{__('lang.매니저수정')}} @endif
    @parent
@stop
@section('header_styles')
    <link href="{{ asset('assets/vendors/jasny-bootstrap/css/jasny-bootstrap.css') }}"  rel="stylesheet" type="text/css" />
@stop
{{-- Page content --}}
@section('content')
    <style>
        .logImg{
            width:100px;
            height:100px;
        }
    </style>
    <section class="content-header">
        <h1>@if($id*1 == 0) {{__('lang.매니저생성')}} @else {{__('lang.매니저수정')}} @endif</h1>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            {{__('lang.매니저정보')}}
                        </h3>
                        <span class="pull-right">
                            <i class="glyphicon glyphicon-chevron-up clickable"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <form  id = "infoForm" action = "{{url("admin/manager/ajaxSaveInfo")}}" method = "post">
                            <input type = "hidden" name = "_token" value = "{{csrf_token()}}"/>
                            <input type = "hidden" name = "id" value = "{{$id}}"/>
                            <div class="form-group">
                                <label class="control-label">{{__('lang.업소')}}</label>
                                <select class = "form-control" name = "shop_id">
                                    @foreach($shop_list as $shop)
                                        <option value = "{{$shop['id']}}" @if($shop['id']*1 == $info['shop_id']*1) selected @endif>{{$shop['title']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__('lang.예명')}}</label>
                                <input  name="nickname" type="text" placeholder="{{__('lang.예명을 입력해주세요')}}" class="form-control" value = "{{$info['nickname']}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__('lang.나이')}}</label>
                                <input id="age" name="age" type="text" placeholder="{{__('lang.나이를 입력해주세요')}}" class="form-control" value = "{{$info['age']}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__('lang.키')}}</label>
                                <input id="height" name="height" type="text" placeholder="{{__('lang.키를 입력해주세요')}}" class="form-control" value = "{{$info['height']}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__('lang.사이즈')}}</label>
                                <input id="body_size" name="body_size" type="text" placeholder="{{__('lang.바디 사이즈를 입력해주세요')}}" class="form-control" value = "{{$info['body_size']}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__('lang.가슴 사이즈')}}</label>
                                <input id="name" name="cup_size" type="text" placeholder="{{__('lang.가슴 사이즈를 입력해주세요')}}" class="form-control" value = "{{$info['cup_size']}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__('lang.흡연여부')}}</label>
                                <input id="is_smoking" name="is_smoking" type="text" placeholder="{{__('lang.흡연 여부를 입력해주세요')}}" class="form-control" value = "{{$info['is_smoking']}}">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="description">{{__('lang.간단메모')}}</label>
                                <textarea class="form-control resize_vertical" id="description" name="description" placeholder="" rows="5" style = "resize:none;">{!! $info['description'] !!}</textarea>
                            </div>
                            <div class = "form-group">
                                <label class="" >{{__('lang.사진')}}</label>
                                <span class = "cursor @if($info['photo_url'] == '') hidden @endif" onclick = "delImage(this)">
                                    <i class = "fa fa-close cursor" ></i>
                                </span>
                                <div class = "row">
                                    <div class = "col-md-9" style = "padding-left:0px;">
                                        <img onerror = "noExitImg(this)" id = "photo_url_img" class = "logImg"  ratio = "1" onclick = "onClickFilgDlgNocrop('#photo_url');"  @if($info['photo_url'] != '') src = "{{correctImgPath1($info['photo_url'])}}" @endif/>
                                        <input type = "hidden" id = "photo_url_val"  name = "photo_url_val" value = ""/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-position">
                                <div class="col-md-12 text-center">
                                    <button type="button" class="btn btn-responsive btn-success btn-sm" onclick = "goBack()">{{__('lang.리스트로 이동')}}</button>
                                    <button type="submit" class="btn btn-responsive btn-primary btn-sm">{{__('lang.등록')}}</button>
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
        $("select[name='shop_id']").select2();
        $('textarea#description').ckeditor({
            height: '200px'
        });

        $("#infoForm").validate({
            rules: {
                nickname: "required",
                age: "required",
                body_size: "required",
                height: "required",
                cup_size: "required",
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
                $("textarea[name='description']").val(CKEDITOR.instances.description.getData());
                var fdata = new FormData($("#infoForm")[0]);
                fdata.append("description", $("textarea[name='description']").val());
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
                                   window.location.href = "{{url("admin/manager")}}";
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
