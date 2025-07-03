@extends('layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
    {{__('lang.업소후기')}}
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
    <?php $user_info = getLoginUserInfo();?>
    <div class="container mt-10">
        <div class = "row">
            <div class = "col-md-9 col-xs-12 mt-10">
                <div class="row content">
                    <!-- Business Deal Section Start -->
                    <div class="col-sm-12 col-md-12 margin-box">
                        @if(Sentinel::check())
                            <div class = "comment-write-rect">
                                <form method="POST" id = "saveForm"  action="{{url("/review/ajaxSaveReview")}}" accept-charset="UTF-8" class="bf" enctype="multipart/form-data">
                                    <input type = "hidden" name ="_token" value = "{{csrf_token()}}"/>
                                    <input type = "hidden" name = "id" value = "{{$id}}"/>
                                    <input type = "hidden" name = "shop_type" value = "{{$shop_type}}"/>
                                    <div class="form-group">
                                        <label class="" >{{__('lang.분류')}}</label>
                                        <select class = "form-control" name = "category_id">
                                            <option value ="">{{__('lang.게시판내 카테고리')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type = "text" class = "form-control" name = "title" placeholder="{{__('lang.제목을 입력해주세요.')}}" value = "{{$info['title']}}" required="required"/>
                                    </div>
                                    <div class="form-group {{ $errors->has('comment') ? 'has-error' : '' }}">
                                        <textarea class="form-control input-lg no-resize" required="required" style="height: 200px" placeholder="{{__('lang.글을 입력해주십시오.')}}"  name="description" cols="50" rows="10">{!! $info['description'] !!}</textarea>
                                        <span class="help-block">{{ $errors->first('comment', ':message') }}</span>
                                    </div>
                                    @if($user_info['type']*1 == 99)
                                    <div class = "form-group">
                                        <label>
                                            <input type="checkbox" id="is_notice" class="minimal-blue" value = "1" @if($info['is_notice']*1 == 1) checked @endif/>
                                            {{__('lang.공지')}}
                                        </label>
                                    </div>
                                    @endif
                                    <div class="form-group text-right">
                                        <button type="submit" class="btn btn-danger border-none radius-0 btn-md">
                                            <i class="livicon" data-name="comment" data-c="#FFFFFF" data-hc="#FFFFFF" data-size="18" data-loop="true"></i>
                                            {{__('lang.작성')}}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class = "col-md-3 hidden-xs">
                @include('layouts/right-side')
            </div>
        </div>
    </div>
    @include("dlg/crop_dlg")
    <!-- //Container End -->
@stop
{{-- footer scripts --}}
@section('footer_scripts')
    <script>
        function updateCategoryList(){
            var id = $("input[name ='id']").val();
            var shop_type = $("input[name='shop_type']").val();
            var param = new Object();
            param._token = _token;
            param.shop_type = shop_type;
            param.id = id;
            var url = "{{url('review/category/getCategoryList')}}";
            $.post(url, param, function(html){
                $("select[name='category_id']").html(html);
            })
        }
        $(function(){
            $('input[type="checkbox"].minimal-blue, input[type="radio"].minimal-blue').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue',
                increaseArea: '20%'
            });
            updateCategoryList();
            loading_stop();
        });

        $("#saveForm textarea[name='description']").ckeditor({
            height: '200px'
        });

        $("#saveForm").validate({
            rules: {
                title: "required",
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
                    errorMsg("{{__('lang.게시판내 카테고리를 선택해주세요!')}}");
                    return;
                }
                var url = $(form).attr("action");
                var fdata = new FormData($("#saveForm")[0]);
                $("#saveForm textarea[name='description']").val(CKEDITOR.instances.description.getData());
                fdata.append("description", $("#saveForm textarea[name='description']").val());

                var is_notice = 0;
                if($("#saveForm #is_notice").prop("checked")){
                    is_notice = 1;
                }
                fdata.append("is_notice", is_notice);

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
                        loading_stop();
                        errorMsg("{{__('lang.서버에서 오류가 발생하였습니다.')}}");
                    }
                })

            }

        });

        function  detailView(){
            window.location.href = "{{url("/board_info")}}";
        }
    </script>
@stop
