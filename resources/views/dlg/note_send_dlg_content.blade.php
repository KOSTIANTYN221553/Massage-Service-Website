{{getCurrentLang()}}
<form class = "form-horizontal panel-body" id = "note_send_form"  role="form" action = "{{url('/dlg/note_ajaxSaveInfo')}}">
    <input type = "hidden" name = "to_user_id" value = "{{$user_id}}"/>
    <input type = "hidden" name = "_token" value = "{{csrf_token()}}"/>
    <input type = "hidden" name = "to_nickname" value = "{{$user_info['nickname']}}"/>
    <div class="form-group">
        <label class="col-md-2 control-label color-white" for="name">{{__('lang.받는 사람')}}</label>
        <div class="col-md-10">
            <input readonly type="text"  class="form-control radius-0" value = "{{$user_info['nickname']}}"/>
        </div>
    </div>
    <div class="form-group">
        <label class = "color-white">{{__('lang.내용')}}</label>
        <textarea class="form-control resize_vertical radius-0" rows="3" name ="content"></textarea>
    </div>
    <button type="submit"  class="hidden" id = "note_send_form_btn" >{{__('lang.확인')}}</button>
</form>

<script>
    $("#note_send_form").validate({
        rules: {
            content: "required",
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
            var fdata = new FormData($("#note_send_form")[0]);
            loading_start();
            $("#note-send-dialog #note_send_form_btn1").attr("disabled","");
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
                            $("#note-send-dialog #note_send_form_btn1").removeAttr("disabled");
                            loading_stop();
                            refreshNoteList();
                            $("#note-send-dialog").modal("hide");
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
</script>

