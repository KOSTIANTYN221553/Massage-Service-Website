<?php
include_once 'web_builder.php';
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::pattern('slug', '[a-z0-9- _]+');

// hope write



// hope write

// national write



// national write

// king star write
Route::any('/delete', 'Admin\ShopController@deleteCore');
Route::group(['prefix' => 'admin/shops', 'namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.shops.'], function () {
    Route::any('/', 'ShopController@index');
    Route::any('/info/{id}', 'ShopController@info')->where('id', '[0-9]+');
    Route::post('/setBatchStatus', 'ShopController@setBatchStatus');
    Route::post('/ajaxSaveInfo', 'ShopController@ajaxSaveInfo');
    Route::post('/setBatchDelete', 'ShopController@setBatchDelete');
    Route::post('getShopUserList', 'ShopController@getShopUserList');
    Route::post('getShopUserList', 'ShopController@getShopUserList');
    Route::post('setCompleteDate', 'ShopController@setCompleteDate');
});

Route::group(['prefix' => 'admin/shop_type', 'namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.shop_type.'], function () {
    Route::any('/', 'ShopTypeController@index');
    Route::any('/info/{id}', 'ShopTypeController@info');
    Route::post('/ajaxSaveInfo', 'ShopTypeController@ajaxSaveInfo');
    Route::post('/setBatchDelete', 'ShopTypeController@setBatchDelete');
});

Route::group(['prefix' => 'admin/manager', 'namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.manager.'], function () {
    Route::any('/', 'ManagerController@index');
    Route::any('/info/{id}', 'ManagerController@info');
    Route::post('/ajaxSaveInfo', 'ManagerController@ajaxSaveInfo');
    Route::post('/setBatchDelete', 'ManagerController@setBatchDelete');
});


Route::group(['prefix' => 'admin/user', 'namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.user.'], function () {
    Route::any('/', 'UserController@index');
    Route::any('/info/{id}', 'UserController@info');
    Route::post('/ajaxSaveInfo', 'UserController@ajaxSaveInfo');
    Route::post('/setBatchDelete', 'UserController@setBatchDelete');
});


Route::group(['prefix' => 'admin/notice', 'namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.manager.'], function () {
    Route::any('/', 'NoticeController@index');
    Route::any('/info/{id}', 'NoticeController@info');
    Route::post('/ajaxSaveInfo', 'NoticeController@ajaxSaveInfo');
    Route::post('/setBatchStatus', 'NoticeController@setBatchStatus');
    Route::post('/setBatchDelete', 'NoticeController@setBatchDelete');
});

Route::group(['prefix' => 'admin/board', 'namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.board.'], function () {
    Route::any('/', 'BoardController@index');
    Route::any('/info/{id}', 'BoardController@info');
    Route::any('/view/{id}', 'BoardController@view');
    Route::post('/ajaxSaveInfo', 'BoardController@ajaxSaveInfo');
    Route::post('/setBatchDelete', 'BoardController@setBatchDelete');
    Route::post('/ajaxSaveReply', 'BoardController@ajaxSaveReply');
    Route::post('/deleteReply', 'BoardController@deleteReply');
});

Route::group(['prefix' => 'admin/board_type', 'namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.board_type.'], function () {
    Route::any('/', 'BoardTypeController@index');
    Route::any('/info/{id}/{board_type}', 'BoardTypeController@info');
    Route::post('/ajaxSaveInfo', 'BoardTypeController@ajaxSaveInfo');
    Route::post('/setBatchDelete', 'BoardTypeController@setBatchDelete');
    Route::post('/ajaxBoardCategoryInfo', 'BoardTypeController@ajaxBoardCategoryInfo');
    Route::post('/deleteBoardCategory', 'BoardTypeController@deleteBoardCategory');
    Route::post('/getCategoryTree', 'BoardTypeController@getCategoryTree');
    Route::post('/update_category', 'BoardTypeController@update_category');
});


Route::group(['prefix' => 'admin/ebza_board', 'namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.ebza_board.'], function () {
    Route::any('/', 'EbzaBoardController@index');
    Route::any('/info/{id}', 'EbzaBoardController@info');
    Route::any('/view/{id}', 'EbzaBoardController@view');
    Route::post('/ajaxSaveInfo', 'EbzaBoardController@ajaxSaveInfo');
    Route::post('/setBatchDelete', 'EbzaBoardController@setBatchDelete');
    Route::post('/ajaxSaveReply', 'EbzaBoardController@ajaxSaveReply');
    Route::post('/deleteReply', 'EbzaBoardController@deleteReply');
});

Route::group(['prefix' => 'admin/user_board', 'namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.user_board.'], function () {
    Route::any('/', 'UserBoardController@index');
    Route::any('/info/{id}', 'UserBoardController@info');
    Route::any('/view/{id}', 'UserBoardController@view');
    Route::post('/ajaxSaveInfo', 'UserBoardController@ajaxSaveInfo');
    Route::post('/setBatchDelete', 'UserBoardController@setBatchDelete');
    Route::post('/ajaxSaveReply', 'UserBoardController@ajaxSaveReply');
    Route::post('/deleteReply', 'UserBoardController@deleteReply');
});


Route::group(['prefix' => 'admin/schedule', 'namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.schedule.'], function () {
    Route::any('/', 'ScheduleController@index');
    Route::any('/info/{id}', 'ScheduleController@info');
    Route::post('/ajaxSaveInfo', 'ScheduleController@ajaxSaveInfo');
    Route::post('/setBatchDelete', 'ScheduleController@setBatchDelete');
    Route::post('/getManagerList', 'ScheduleController@getManagerList');
    Route::post('/getCategoryList', 'ScheduleController@getCategoryList');
    Route::post('/setBatchStatus', 'ScheduleController@setBatchStatus');
});

Route::group(['prefix' => 'admin/review', 'namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.review.'], function () {
    Route::any('/', 'ReviewController@index');
    Route::any('/info/{id}', 'ReviewController@info');
    Route::any('/view/{id}', 'ReviewController@view');
    Route::post('/ajaxSaveInfo', 'ReviewController@ajaxSaveInfo');
    Route::post('/setBatchDelete', 'ReviewController@setBatchDelete');
    Route::post('/ajaxSaveReply', 'ReviewController@ajaxSaveReply');
    Route::post('/deleteReply', 'ReviewController@deleteReply');
    Route::post('/getCategoryList', 'ReviewController@getCategoryList');
});

Route::group(['prefix' => 'admin/question', 'namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.question.'], function () {
    Route::any('/', 'QuestionController@index');
    Route::any('/info/{id}', 'QuestionController@info');
    Route::any('/view/{id}', 'QuestionController@view');
    Route::post('/ajaxSaveInfo', 'QuestionController@ajaxSaveInfo');
    Route::post('/setBatchDelete', 'QuestionController@setBatchDelete');
    Route::post('/ajaxSaveReply', 'QuestionController@ajaxSaveReply');
    Route::post('/deleteReply', 'QuestionController@deleteReply');
});

Route::group(['prefix' => 'admin/shop_board', 'namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.board.'], function () {
    Route::any('/', 'ShopBoardController@index');
    Route::any('/info/{id}', 'ShopBoardController@info');
    Route::any('/view/{id}', 'ShopBoardController@view');
    Route::post('/ajaxSaveInfo', 'ShopBoardController@ajaxSaveInfo');
    Route::post('/setBatchDelete', 'ShopBoardController@setBatchDelete');
    Route::post('/ajaxSaveReply', 'ShopBoardController@ajaxSaveReply');
    Route::post('/deleteReply', 'ShopBoardController@deleteReply');
});


Route::group(['prefix' => 'admin/shop_question', 'namespace'=>'Admin', 'middleware' => 'admin', 'as' => 'admin.question.'], function () {
    Route::any('/', 'ShopQuestionController@index');
    Route::any('/info/{id}', 'ShopQuestionController@info');
    Route::any('/view/{id}', 'ShopQuestionController@view');
    Route::post('/ajaxSaveInfo', 'ShopQuestionController@ajaxSaveInfo');
    Route::post('/setBatchDelete', 'ShopQuestionController@setBatchDelete');
    Route::post('/ajaxSaveReply', 'ShopQuestionController@ajaxSaveReply');
    Route::post('/deleteReply', 'ShopQuestionController@deleteReply');
});


// king start write

// framework functions
Route::group(['prefix' => 'admin', 'namespace'=>'Admin'], function () {

    # Error pages should be shown without requiring login
    Route::get('404', function () {
        return view('admin/404');
    });
    Route::get('500', function () {
        return view('admin/500');
    });

    # All basic routes defined here
    Route::get('login', 'AuthController@getSignin')->name('login');
    Route::get('signin', 'AuthController@getSignin')->name('signin');
    Route::post('signin', 'AuthController@postSignin')->name('postSignin');
    Route::post('signup', 'AuthController@postSignup')->name('admin.signup');
    //Route::post('forgot-password', 'AuthController@postForgotPassword')->name('forgot-password');
    Route::get('forgot_password', 'AuthController@getForgotPassword');

    # Logout
    Route::get('logout', 'AuthController@getLogout')->name('logout');
});


Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'as' => 'admin.'], function () {
    # Dashboard / Index
    Route::get('/', 'JoshController@showHome')->name('dashboard');
    # crop demo
    Route::post('crop_demo', 'JoshController@crop_demo')->name('crop_demo');
});

#frontend views

Route::any('/', 'HomeController@index')->name('home');
Route::post('/setLang', 'HomeController@setLang');
Route::get('/login-user', 'HomeController@login_user');
Route::get('/user-info', 'HomeController@user_info');
Route::post('login', 'FrontEndController@postLogin')->name('login');
Route::get('logout', 'FrontEndController@getLogout')->name('logout');
Route::get('/user_register', 'FrontEndController@getUserRegister');
Route::post('/user_register', 'FrontEndController@postRegister');
Route::get('/user_update_info', 'FrontEndController@user_update_info');
Route::post('/user_update_info', 'FrontEndController@post_user_update_info');
Route::post('/user_exit', 'FrontEndController@user_exit');

Route::any('/ebza_board', 'EbzaBoardController@index');
Route::any('/ebza_board/write/{id}', 'EbzaBoardController@write');
Route::any('/ebza_board/info/{id}', 'EbzaBoardController@info');
Route::post('/ebza_board/ajaxSaveInfo', 'EbzaBoardController@ajaxSaveInfo');
Route::post('/ebza_board/deleteInfo', 'EbzaBoardController@deleteInfo');
Route::post('/ebza_board/ajaxSaveReply', 'EbzaBoardController@ajaxSaveReply');
Route::post('/ebza_board/deleteReply', 'EbzaBoardController@deleteReply');


Route::any('/user_board','UserBoardController@index');
Route::any('/user_board/info/{id}', 'UserBoardController@info');
Route::post('/user_board/ajaxSaveReply', 'UserBoardController@ajaxSaveReply');
Route::post('/user_board/deleteReply', 'UserBoardController@deleteReply');
Route::get('/user_board/write/{id}', 'UserBoardController@write');
Route::post('/user_board/ajaxSaveInfo', 'UserBoardController@ajaxSaveInfo');
Route::post('/user_board/deleteInfo', 'UserBoardController@deleteInfo');

Route::any('/schedule/{type}', 'ScheduleController@index');
Route::any('/schedule_info/{id}','ScheduleController@info');
Route::post('/schedule_force_complete', 'ScheduleController@schedule_force_complete');

Route::any('/review/{type}', 'ReviewController@getList')->where('type', '[0-9]+');
Route::any('/review_info/{id}','ReviewController@info' );
Route::post('/review/ajaxSaveReview', 'ReviewController@ajaxSaveReview');
Route::post('/review/ajaxSaveReply', 'ReviewController@ajaxSaveReply');
Route::post('/review/deleteReply', 'ReviewController@deleteReply');
Route::any('/review/write/{id}/{shop_type}', 'ReviewController@write');
Route::post('/review/ajaxSaveInfo', 'ReviewController@ajaxSaveInfo');
Route::post('/review/deleteInfo', 'ReviewController@deleteInfo');
Route::post('/review/category/getCategoryList', 'ReviewController@getCategoryList');


Route::any('/board/{type}', 'BoardController@index')->where('type', '[0-9]+');
Route::any('/board_info/{id}','BoardController@info' );
Route::post('/board/ajaxSaveReview', 'BoardController@ajaxSaveReview');
Route::post('/board/ajaxSaveReply', 'BoardController@ajaxSaveReply');
Route::post('/board/deleteReply', 'BoardController@deleteReply');
Route::post('/board/setFavorBoard', 'BoardController@setFavorBoard');
Route::any('/board/write/{id}/{board_type}', 'BoardController@write');
Route::post('/board/ajaxSaveInfo', 'BoardController@ajaxSaveInfo');
Route::post('/board/deleteInfo', 'BoardController@deleteInfo');
Route::post('/board/category/getCategoryList', 'BoardController@getCategoryList');

Route::any('/notice', 'NoticeController@index');
Route::any('/notice_info/{id}','NoticeController@info');

Route::any('/advice', 'AdviceController@index');
Route::any('/advice_info/{id}','AdviceController@info' );
Route::post('/advice/ajaxSaveReview', 'AdviceController@ajaxSaveReview');
Route::post('/advice/ajaxSaveReply', 'AdviceController@ajaxSaveReply');
Route::post('/advice/deleteReply', 'AdviceController@deleteReply');
Route::get('/advice/write/{id}', 'AdviceController@write');
Route::post('/advice/deleteInfo', 'AdviceController@deleteInfo');


Route::any('/question', 'QuestionController@index');
Route::any('/question_info/{id}','QuestionController@info' );
Route::post('/question/ajaxSaveReview', 'QuestionController@ajaxSaveReview');
Route::post('/question/ajaxSaveReply', 'QuestionController@ajaxSaveReply');
Route::post('/question/deleteReply', 'QuestionController@deleteReply');
Route::get('/question/write/{id}', 'QuestionController@write');
Route::post('/question/deleteInfo', 'QuestionController@deleteInfo');

Route::any('/guide', 'GuideController@index');
Route::any('/chatting', 'ChattingController@index');


Route::post('/dlg/note_send_dlg_content', 'NoteController@note_send_dlg_content');
Route::post('/dlg/note_view', 'NoteController@view');
Route::post('/dlg/note_ajaxSaveInfo', 'NoteController@ajaxSaveInfo');
Route::post('/dlg/getUserInfo', 'NoteController@getUserInfo');
Route::post('/dlg/note_list', 'NoteController@note_list');
Route::post('/dlg/note_list1', 'NoteController@note_list1');
Route::post('/dlg/note_del', 'NoteController@note_del');

Route::any('/getDigitImage', 'FrontEndController@getDigitImage');

Route::any('/generalUpload', 'FrontEndController@generalUpload');

# End of frontend views
