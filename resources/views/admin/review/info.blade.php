@extends('admin/layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
    @if($id*1 == 0) {{__('lang.업소후기등록')}} @else {{__('lang.업소후기수정')}}@endif
    @parent
@stop
@section('header_styles')
@stop
{{-- Page content --}}
@section('content')

    <section class="content-header">
        <h1>@if($id*1 == 0) {{__('lang.업소후기등록')}} @else {{__('lang.업소후기수정')}} @endif</h1>
    </section>
    <!--section ends-->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-primary" id="hidepanel1">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <i class="livicon" data-name="clock" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
                            {{__('lang.업소후기정보')}}
                        </h3>
                        <span class="pull-right">
                            <i class="glyphicon glyphicon-chevron-up clickable"></i>
                        </span>
                    </div>
                    <div class="panel-body">
                        <form  id = "infoForm" action = "{{url("admin/review/ajaxSaveInfo")}}" method = "post">
                            <input type = "hidden" name = "_token" value = "{{csrf_token()}}"/>
                            <input type = "hidden" name = "id" value = "{{$id}}"/>

                            <div class="form-group">
                                <label class="control-label">{{__('lang.업소종류')}}</label>
                                <select name = "shop_type" class = "form-control" @if($id*1 > 0) disabled @endif onchange="updateCategoryList()">
                                    @foreach($shop_type_list as $item)
                                        <option value = "{{$item['id']}}" @if(isset($info['shop_type']) && $item['id']*1 == $info['shop_type']*1) selected @endif>{{$item['title']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label">{{__('lang.게시판내 카테고리')}}</label>
                                <select name = "category_id" class = "form-control" @if($id*1 > 0) disabled @endif>
                                    <option value = "0">{{__('lang.미정')}}</option>
                                    @if(isset($category_list))
                                        @foreach($category_list as $item)
                                            <option value = "{{$item['id']}}" @if($info['category_id']*1 == $item['id']*1) selected @endif>{{$item['title']}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">{{__('lang.타이틀')}}</label>
                                <input id="name" name="title" type="text" placeholder="{{__('lang.이름을 입력해주세요')}}" class="form-control" value = "{{$info['title']}}">
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="description">{{__('lang.내용')}}</label>
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
@stop
@section('footer_scripts')
<script>
    $(function() {
        $("select[name='shop_id']").select2();
        $('textarea#description').ckeditor({
            height: '200px'
        });
        updateCategoryList();
        loading_stop();

        $("#infoForm").validate({
            rules: {
                shop_type: "required",
                category_id: "required",
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
                var category_id = $("select[name='category_id']").val();
                if(category_id == "0"){
                    errorMsg("게시판내 카테고리를 선택해주세요.");
                    return;
                }
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
                                   window.location.href = "{{url('admin/review')}}";
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

    function updateCategoryList(){
        var shop_type = $("select[name='shop_type']").val();
        var param = new Object();
        param._token = _token;
        param.shop_type = shop_type;
        param.id = 0;
        var url = "{{url('review/category/getCategoryList')}}";
        $.post(url, param, function(html){
            $("select[name='category_id']").html(html);
        })
    }

</script>
@stop
