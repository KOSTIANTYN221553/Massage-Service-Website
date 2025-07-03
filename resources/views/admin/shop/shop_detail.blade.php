@extends('admin/layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
    @if($id*1 == 0) {{__('lang.업소생성')}} @else {{__('lang.업소수정')}} @endif
    @parent
@stop
@section('header_styles')
@stop
{{-- Page content --}}
@section('content')

    <section class="content-header">
        <h1>@if($id*1 == 0) {{__('lang.업소생성')}} @else {{__('lang.업소수정')}} @endif</h1>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            {{__('lang.업소정보')}}
                        </h3>
                        <span class="pull-right">
                            <i class="glyphicon glyphicon-chevron-up clickable"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <form  id = "infoForm" action = "{{url("admin/shops/ajaxSaveInfo")}}" method = "post">
                            <input type = "hidden" name = "_token" value = "{{csrf_token()}}"/>
                            <input type = "hidden" name = "id" value = "{{$id}}"/>
                            <div class = "form-group">
                                <label class="" >{{__('lang.이미지')}}</label>
                                <span class = "cursor @if($info['img'] == '') hidden @endif" onclick = "delImage(this)">
                                    <i class = "fa fa-close cursor" ></i>
                                </span>
                                <div class = "row">
                                    <div class = "col-md-9" style = "padding-left:0px;">
                                        <img onerror = "noExitImg(this)" id = "img_img" class = "logImg"  ratio = "0.67" onclick = "onClickFilgDlgNocrop('#img');" style = "width:100px; height:100px;" @if($info['img'] != '') src = "{{correctImgPath1($info['img'])}}" @endif/>
                                        <input type = "hidden" id = "img_val"  name = "img_val" value = ""/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">{{__('lang.이름')}}</label>
                                <input id="name" name="title" type="text" placeholder="{{__('lang.이름을 입력해주세요')}}" class="form-control" value = "{{$info['title']}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">{{__('lang.소유유저')}}</label>
                                <button type = "button"  class = "btn btn-primary btn-sm" onclick = "detail_dlg()">{{__('lang.검색')}}</button>
                            </div>
                            <div class="form-group">
                                <input type = "hidden" name = "user_id" value = "{{$info['user_id']}}"/>
                                <input type = "text" id = "user_name" readonly name = "user_name" value = "{{isset($info['user']['nickname']) ? $info['user']['nickname'] :""}}" class ="form-control"/>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="type">{{__('lang.업소종류')}}</label>
                                <select name = "type" id = "type" class = "form-control">
                                    <option value = ""></option>
                                    @foreach($shop_type_list as $type_item)
                                        <option value = "{{$type_item['id']}}" @if($info['type']*1 == $type_item['id']*1) selected @endif>{{$type_item['title']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="location">{{__('lang.위치')}}</label>
                                <input id="location" name="location" type="text" placeholder="{{__('lang.위치를 입력해주세요')}}" class="form-control" value = "{{$info['location']}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="phone">{{__('lang.전화번호')}}</label>
                                <input id="phone" name="phone" type="text" placeholder="{{__('lang.전화번호를 입력해주세요')}}" class="form-control" value = "{{$info['phone']}}">
                            </div>
                            <div class="form-group hidden">
                                <label class="control-label" for="time">{{__('lang.영업시간')}}</label>
                                <input id="time" name="time" type="text"   placeholder="{{__('lang.영업시간을 입력해주세요')}}" class="form-control" value = "{{$info['time']}}">
                            </div>

                            <div class="form-group hidden">
                                <label class="control-label" for="price">{{__('lang.요금정보')}}</label>
                                <textarea class="form-control resize_vertical" id="price" name="price" placeholder="" rows="5" style = "resize:none;">{!! $info['price'] !!}</textarea>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="description">{{__('lang.설명')}}</label>
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
        @include('admin/shop/shop_user_dlg')
    </section>
    <!-- content -->
    @include("dlg/crop_dlg")
@stop
@section('footer_scripts')


<script>
    function setShopUser(){
        var user_id = $("#shop-users-dialog input[name='check_shop_user']:checked").val();
        var user_name = $("#shop-users-dialog input[name='check_shop_user']:checked").attr("data-name");
        $("#infoForm input[name='user_id']").val(user_id);
        $("#infoForm #user_name").val(user_name);
        $("#shop-users-dialog").modal("hide");
    }
    function detail_dlg(){

        $("#shop-users-dialog").modal("show");


    }

    function delImage(obj){
        $("#img").attr("src", "");
        $("#img_val").val("");
        $(obj).addClass("hidden");
    }

    jQuery(document).ready(
        function(){
            // calendar
            $("#time").mobiscroll().time({
                timeFormat:"HH:ii",
                lang: 'ko',
            });

        }
    )

    $(function() {
        $('#price').ckeditor({
            height: '200px'
        });
        $('#description').ckeditor({
            height: '200px'
        });
        $("select[name='user_id']").select2();

        loading_stop();
        $("#infoForm").validate({
            rules: {
                title: "required",
                type: "required",
                phone: "required",
                user_name: "required",
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
                $("textarea[name='price']").val(CKEDITOR.instances.price.getData());
                $("textarea[name='description']").val(CKEDITOR.instances.description.getData());
                var fdata = new FormData($("#infoForm")[0]);
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
                               goBack();
                            });
                        } else {
                            loading_stop();
                            errorMsg(data.msg);
                        }
                    },
                    error: function() {
                        errorMsg("{{__('lang.서버에서 오류가 발생하였습니다.')}}");
                    }
                })

            }
        });
    });


    $(function(){
        $('#shop-users-dialog #table1').DataTable();
    });

</script>
@stop
