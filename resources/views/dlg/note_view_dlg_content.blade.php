{{getCurrentLang()}}
<style>
    .wrapper-1{
        position:relative;
    }
    .wrapper1-input{
        border: 0px;color: white;background-color: #0C0A0A !important; margin-top: 2px;box-shadow: none;
        /*position: absolute;left: -60px;width: calc(100% + 60px);*/
    }
    @media(max-width:480px){
        .wrapper1-input{
            background-color: #0C0A0A !important;
            position: relative;left: 0px;width: 100%;
        }

    }
</style>
<form class = "form-horizontal panel-body" id = "note_send_form"  role="form" action = "{{url('/dlg/note_ajaxSaveInfo')}}">
    <div class="row">
        <label class="col-md-12 control-label text-left color-white" for="name">{{__('lang.보낸 사람')}}</label>
        <div class="col-md-12 wrapper-1" style = "">
            <input readonly type="text"   style = "" class="form-control radius-0 wrapper1-input" value = "{{$info['send_nickname']}}"/>
        </div>
    </div>
    <div style = "width: 100%;height: 1px; background: white; margin-top: 10px;margin-bottom: 10px;"></div>
    <div class="row">
        <label class = "color-white">{{__('lang.내용')}}</label>
        <textarea class="form-control resize_vertical radius-0" rows="3" name ="content" readonly style = "border: 0px;color: white;background-color: #0C0A0A;    box-shadow: none; margin-top: 2px;">{{$info['content']}}</textarea>
    </div>
    <button type="submit"  class="hidden" id = "note_send_form_btn" >{{__('lang.확인')}}</button>
</form>

<script>

</script>
