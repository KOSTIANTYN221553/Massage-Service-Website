@extends('admin/layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
    @if($id*1 == 0) {{__('lang.게시판등록')}} @else {{__('lang.게시판수정')}} @endif
    @parent
@stop
@section('header_styles')
@stop
{{-- Page content --}}
@section('content')

    <section class="content-header">
        <h1>@if($id*1 == 0) {{__('lang.게시판등록')}} @else {{__('lang.게시판수정')}} @endif</h1>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            {{__('lang.게시판정보')}}
                        </h3>
                        <span class="pull-right">
                            <i class="glyphicon glyphicon-chevron-up clickable"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <form  id = "infoForm" action = "{{url("admin/shop_board/ajaxSaveInfo")}}" method = "post">
                            <input type = "hidden" name = "_token" value = "{{csrf_token()}}"/>
                            <input type = "hidden" name = "id" value = "{{$id}}"/>
                            <div class = "form-group">
                                <label class="" >{{__('lang.이미지')}}</label>
                                <span class = "cursor @if($info['img'] == '') hidden @endif" onclick = "delImage(this)">
                                    <i class = "fa fa-close cursor" ></i>
                                </span>
                                <div class = "row">
                                    <div class = "col-md-9" style = "padding-left:0px;">
                                        <img onerror = "noExitImg(this)" id = "img_img" class = "logImg"  ratio = "1" onclick = "onClickFilgDlgNocrop('#img');" style = "width:100px; height:100px;" @if($info['img'] != '') src = "{{correctImgPath1($info['img'])}}" @endif/>
                                        <input type = "hidden" id = "img_val"  name = "img_val" value = ""/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">{{__('lang.게시판 타이틀')}}</label>
                                <input id="name" name="title" type="text" placeholder="{{__('lang.이름을 입력해주세요')}}" class="form-control" value = "{{$info['title']}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="description">{{__('lang.게시판 내용')}}</label>
                                <textarea class="form-control resize_vertical" id="description" name="description" placeholder="" rows="5" style = "resize:none;">{!! $info['description'] !!}</textarea>
                            </div>
                            <!-- Form actions -->
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
<script>
    $(function() {
        $('textarea#description').ckeditor({
            height: '200px'
        });
        loading_stop();

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
                               if(id == "0"){
                                   goBack();
                               }else{
                                   goBack();
                               }

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
