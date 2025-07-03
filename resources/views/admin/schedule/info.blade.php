@extends('admin/layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
    @if($id*1 == 0) {{__('lang.스케줄등록')}} @else {{__('lang.스케줄수정')}} @endif
    @parent
@stop
@section('header_styles')
    <style>
        .cke_dialog_ui_input_file {
            width: 100%;
            height: auto !important;
            overflow-x:hidden;
        }
    </style>
@stop
{{-- Page content --}}
@section('content')

    <section class="content-header">
        <h1>@if($id*1 == 0) {{__('lang.스케줄등록')}} @else {{__('lang.스케줄수정')}} @endif</h1>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            {{__('lang.스케줄정보')}}
                        </h3>
                        <span class="pull-right">
                            <i class="glyphicon glyphicon-chevron-up clickable"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <form  id = "infoForm" action = "{{url("admin/schedule/ajaxSaveInfo")}}" method = "post">
                            <input type = "hidden" name = "_token" value = "{{csrf_token()}}"/>
                            <input type = "hidden" name = "id" value = "{{$id}}"/>
                            <div class="form-group">
                                <label class="control-label" for="name">{{__('lang.제목')}}</label>
                                <input id="name" name="title" type="text" placeholder="{{__('lang.제목을 입력해주세요.')}}" class="form-control" value = "{{$info['title']}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="type">{{__('lang.업소')}}</label>
                                <select name = "shop_id" id = "shop_id" class = "form-control"  onchange ="updateCategoryList()" @if(isset($info['shop_id'])) disabled @endif>
                                    <option value = ""></option>
                                    @foreach($shop_list as $item)
                                        @if($info['shop_id']*1 == $item['id']*1 || $item['schedule_cnt']*1 == 0)
                                        <option value = "{{$item['id']}}" data-phone = "{{$item['phone']}}" @if($info['shop_id']*1 == $item['id']*1) selected @endif>{{$item['title']}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="type">{{__('lang.게시판내 카테고리')}}</label>
                                <select name = "category_id" class = "form-control">

                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="time">{{__('lang.영업시작시간')}}</label>
                                <input id="s_time" name="s_time" type="text"  placeholder="{{__('lang.영업시작시간을 입력해주세요')}}" class="form-control" value = "{{$info['s_time']}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="time">{{__('lang.영업마감시간')}}</label>
                                <input id="e_time" name="e_time" type="text"  placeholder="{{__('lang.영업마감시간을 입력해주세요')}}" class="form-control" value = "{{$info['e_time']}}">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="sns_id">{{__('lang.메신저 아이디')}}</label>
                                <input id="sns_id" name="sns_id" type="text" placeholder="{{__('lang.메신저 아이디를 입력해주세요')}}" class="form-control" value = "{{$info['sns_id']}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="location">{{__('lang.위치')}}</label>
                                <input id="location" name="location" type="text" placeholder="{{__('lang.위치를 입력해주세요')}}" class="form-control" value = "{{$info['location']}}">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="shop_phone">{{__('lang.전화번호')}}</label>
                                <input id="shop_phone" name = "shop_phone"  type="text" placeholder="{{__('lang.전화번호를 입력해주세요')}}" class="form-control" value = "{{$info['shop_phone']}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="shop_phone">{{__('lang.매니저목록')}}</label>
                                <button type = "button"  class = "btn btn-primary" onclick = "detail_dlg()">{{__('lang.상세')}}</button>
                            </div>
                            <div class = "form-group">
                                <table class="table table-hover table-striped table-bordered" id = "manager_tabl" style = "margin-top:10px;">
                                    <thead>
                                    <tr>
                                        <td>No</td>
                                        <td>{{__('lang.매니저이름')}}</td>
                                        <td>{{__('lang.시작시간')}}</td>
                                        <td>{{__('lang.마감시간')}}</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($info['detail_list']))
                                        @foreach($info['detail_list'] as $key => $item)
                                            <tr data-id = "{{$item['id']}}">
                                                <td>{{$key+1}}</td>
                                                <td data-id = "{{$item['manager']['id']}}">{{$item['manager']['nickname']}}</td>
                                                <td>{{$item['schedule_start_at']}}</td>
                                                <td>{{$item['schedule_end_at']}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    </tbody>
                                </table>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="price">{{__('lang.서비스요금&코스안내')}}<b>({{__('lang.여기는 이미지 업로드가 안됩니다')}} {{__('lang.요금 정보만 쓰시면 됩니다')}})</b></label>
                                <textarea class="form-control resize_vertical" id="description" name="description" placeholder="{{__('lang.테스트만 입력해주세요')}}{{__('lang.텍스트만 입력 가능합니다')}}" rows="5" style = "resize:none;">{!! $info['description'] !!}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="description">{{__('lang.HTML작성부분')}}<b>({{__('lang.업소 프로필 내용을 업로드 해주세요')}})</b></label>
                                <textarea class="form-control resize_vertical" id="description2" name="description2" placeholder="{{__('lang.업소 프로필을 업로드 하는 구간입니다')}}{{__('lang.이미지를 업로드하고 폰트를 꾸며주세요')}}" rows="5" style = "resize:none;">{!! $info['description2'] !!}</textarea>
                            </div>
                            <input type = "hidden" name = "detail_list" value = ""/>
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
    @include('admin/schedule/detail_dlg')
@stop
@section('footer_scripts')
    <script src="{{ asset('assets/vendors/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script>
    function detail_dlg(){
        var shop_id = $("select[name='shop_id']").val();
        if(shop_id == ""){
            errorMsg("업소를 선택하여주십시오.");
            return;
        }
        var url = "{{url('admin/schedule/getManagerList')}}";
        var param = new Object();
        param._token = _token;
        param.shop_id = shop_id;
        $.post(url, param, function(html){
            $("#schedule-detail-dialog select[name='manager_id']").html(html);
            $("#schedule-detail-dialog input[name='detail_id']").val("0");
            $("#schedule-detail-dialog").modal("show");
        });

    }

    function updateCategoryList(){
        var id = $("input[name ='id']").val();
        var shop_id = $("select[name='shop_id']").val();
        var param = new Object();
        param._token = _token;
        param.shop_id = shop_id;
        param.id = id;
        if(shop_id  == "") return;
        var url = "{{url('admin/schedule/getCategoryList')}}";
        $.post(url, param, function(html){
            loading_stop();
            $("select[name='category_id']").html(html);
        })
    }
    jQuery(document).ready(
        function(){

            $("input[name='s_time1']").mobiscroll().time({
                timeFormat:"HH:ii",
                lang: 'ko',
            });
            $("input[name='e_time1']").mobiscroll().time({
                timeFormat:"HH:ii",
                lang: 'ko',
            });
            $("input[name='s_time']").datetimepicker({
                format: 'LT'
            }).parent().css("position :relative");

            $("input[name='e_time']").datetimepicker({
                format: 'LT'
            }).parent().css("position :relative");

            $("input[name='schedule_start_at']").datetimepicker({
                format: 'LT'
            }).parent().css("position :relative");
            $("input[name='schedule_end_at']").datetimepicker({
                format: 'LT'
            }).parent().css("position :relative");

        }
    )

    $(function() {
        updateCategoryList();

        $('textarea#description2').ckeditor({
            height: '400px',
            extraPlugins : 'uploadimage,confighelper,justify,colorbutton,font',
            filebrowserUploadUrl: '{{url("/generalUpload?_token=".csrf_token())}}',
            removeButtons:'Source',
        });

        $('textarea#description').ckeditor({
            height: '400px',
            removeButtons:'Source',
            extraPlugins : 'confighelper,justify,colorbutton,font',
        });



        $("#infoForm").validate({
            rules: {
                title: "required",
                shop_id: "required",
                sns_id: "required",
                location: "required",
                shop_phone: "required",
                s_time: "required",
                e_time: "required",
                category_id: "required",
            },
            messages: {

            },
            errorPlacement: function (error, element) {
                if($(element).closest('div').children().filter("div.error-div").length < 1)
                    $(element).closest('div').append("<div class='error-div'></div>");
                $(element).closest('div').children().filter("div.error-div").append(error);
            },
            submitHandler: function(form){
                var category_id = $("select[name='category_id']").val();
                if(category_id == "0"){
                    errorMsg("게시판내 카테고리을 선택해주세요!");
                    return;
                }
                var url = $(form).attr("action");
                $("textarea[name='description2']").val(CKEDITOR.instances.description2.getData());
                $("textarea[name='description']").val(CKEDITOR.instances.description.getData());
                var fdata = new FormData($("#infoForm")[0]);
                var detail_list = $("input[name='detail_list']").val();
                fdata.append("detail_list", detail_list);
                fdata.append("description",$("textarea[name='description']").val());
                fdata.append("description2",$("textarea[name='description2']").val());
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
                                   window.location.href = "{{url('admin/schedule')}}";
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
