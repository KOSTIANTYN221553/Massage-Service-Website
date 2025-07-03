{{getCurrentLang()}}
<div id="user-exit-password-confirm-dialog" class="modal fade"  role="dialog" style = "z-index: 1060;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">{{__('lang.암호확인')}}</h4>
            </div>
            <form class="form-horizontal" id = "userExitPasswordConfirmForm" method = "post" action="{{url("/user_exit")}}">
                <div class="modal-body" >
                    <div class="panel-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <div class = "form-group">
                            <label>
                                {{__('lang.회원탈퇴를 하시려면 비밀번호인증을 진행하셔야 합니다')}}
                            </label>
                        </div>
                        <div class="form-group {{ $errors->first('password', 'has-error') }}">
                            <label class="sr-only">{{__('lang.비밀번호')}}</label>
                            <input type="password" class="form-control" name="password_dlg"
                                   placeholder="{{__('lang.비밀번호를 입력해주세요')}}">
                            {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                        </div>
                        <div class="form-group {{ $errors->first('password_confirm', 'has-error') }}">
                            <label class="sr-only">{{__('lang.비밀번호확인')}}</label>
                            <input type="password" class="form-control" name="password_dlg_confirm"
                                   placeholder="{{__('lang.비밀번호확인을 입력해주세요')}}">
                            {!! $errors->first('password_confirm', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"  class="btn btn-danger" >{{__('lang.확인')}}</button>
                    <button type="button"  class="btn btn-danger" onclick = "hiddenConfirmDlg()" >{{__('lang.취소')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>
