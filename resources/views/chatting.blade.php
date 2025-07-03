@extends('layouts/default')
{{getCurrentLang()}}
{{-- Page title --}}
@section('title')
{{__('lang.채팅방')}}
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
    @if(Sentinel::check())
    <?php
        $user_info = getLoginUserInfo();
        $joinData = array();

        $joinData['room'] = 'ddbam_chat';
        $joinData['token'] = 'f144591243b5ca1f92e655d7c5622730';
        $joinData['nick'] = $user_info['nickname'];
        $joinData['id'] = $user_info['email'];
        $joinData['level'] = '레벨';
        if($user_info['type']*1 == 99){
            $joinData['auth'] = 'admin'; // (admin, subadmin, member, guest)중 하나선택, 미선택시 자동(권장)
        }else{
            $joinData['auth'] = 'guest'; // (admin, subadmin, member, guest)중 하나선택, 미선택시 자동(권장)
        }
        $joinData['icons'] = '아이콘주소';
        $joinData['nickcon'] = '닉콘주소';
        $joinData['other'] = '';
    ?>

    <div class="container mt-10">
            <div class = "row">
                <div class = "col-md-12 col-xs-12 page-title-wrapper">
                    <span class = "">{{__('lang.채팅방')}}</span>
                </div>
            </div>


        <div class = "row">
            <div class = "col-md-9 cols-xs-12">
                <div class="row">
                    <div class = "col-md-12">
                        <div class="border-box margin-box" style="margin-top:10px;">
                            <u-chat room='<?php echo $joinData["room"];?>' user_data='<?php echo uchat_array2data($joinData); ?>' style="display:inline-block; width:100%; height:863px;"></u-chat>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "col-md-3 hidden-xs">
                @include('layouts/right-side')
            </div>
        </div>
    </div>
    @endif
@stop
{{-- footer scripts --}}
@section('footer_scripts')
    <script>
        $(function(){
            loading_stop();
        });
    </script>
    <script async src="//client.uchat.io/uchat.js"></script>
@stop
