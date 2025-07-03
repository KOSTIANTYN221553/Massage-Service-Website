{{getCurrentLang()}}
<form class = "form-horizontal panel-body" role="form">
        <div class="form-group">
            <label class="col-md-3 control-label color-white " for="name">{{__('lang.계정')}}:</label>
            <label class="col-md-3 control-label text-left color-white" for="name">{{$user_info['email']}}</label>
            <label class="col-md-3 control-label color-white" for="name">{{__('lang.닉네임')}}:</label>
            <label class="col-md-3 control-label text-left color-white" for="name">{{$user_info['nickname']}}</label>
        </div>
        <div class="form-group">
            <label class="col-md-3 control-label color-white" for="name">{{__('lang.레벨')}}:</label>
            <label class="col-md-9 control-label text-left" for="name"><img onerror = "noExitImg(this)" style="width:20px !important;" src="{{url($user_info['user_level']['icon'])}}"> {{$user_info['user_level']['title']}}</label>

        </div>
        <div class="form-group">
            <label class="col-md-3 control-label color-white" for="name">{{__('lang.가입일')}}:</label>
            <label class="col-md-3 control-label text-left color-white" for="name">{{substr($user_info['created_at'],0,10)}}</label>
            <label class="col-md-3 control-label color-white" for="name">{{__('lang.방문수')}}:</label>
            <label class="col-md-3 control-label text-left color-white" for="name">{{number_format($user_info['visit_cnt'])}}</label>
        </div>
</form>





