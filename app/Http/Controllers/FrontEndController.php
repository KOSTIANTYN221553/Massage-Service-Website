<?php

namespace App\Http\Controllers;

use Activation;
use App\Http\Requests;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\FrontendRequest;
use App\User;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use File;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Mail;
use Redirect;
use Reminder;

use Symfony\Component\HttpFoundation\Session\Session;
use Validator;
use Sentinel;
use URL;
use View;
use stdClass;
use App\Mail\Contact;
use App\Mail\ForgotPassword ;
use KCAPTCHA;



class FrontEndController extends JoshController
{

    /*
     * $user_activation set to false makes the user activation via user registered email
     * and set to true makes user activated while creation
     */
    private $user_activation = true;

    public function __construct()
    {
        parent::__construct();
    }

    public function generalUpload(){
        $path = "uploads/";
        if (!file_exists($path))
            mkdir($path, 0777);
        $path = "uploads/ckeditor";
        if (!file_exists($path))
            mkdir($path, 0777);

        $path .= "/".date('Ymd');
        if (!file_exists($path))
            mkdir($path, 0777);

        $rules = [
            'upload'      => 'required|mimes:png,jpe,jpeg,jpg,gif,bmp,ico,tiff,tif,svg,svgz',
        ];

        $validator = Validator::make(Input::all(), $rules);

        if($validator->fails()){
            return json_encode(array('uploaded'=>'0', "msg"=>__("lang.허용되지 않은 파일입니다.")));
        }

        //$uploadfullPath = "e:/Project/Web/MybizCoupon/_MybizCoupon/uploads/images/";

        // 이미지가 웹에서 보여질때 사용되어질 기본 URL입니다.
        // 웹루트 부터의 절대 URL을 입력합니다.
        //$imageBaseUrl = "/uploads/images/";

        // 업로드후 이미지를보여줄 이미지 url
        $url = '' ;

        // 에러가 발생하면 메세지를 보여줍니다.
        $message = '';
        if (isset($_FILES['upload'])) {

            $name = time().'_'.$_FILES['upload']['name'];

            // 파일 이름 중복 체크는 없습니다.(실제 구현에는 직접 작성해야 할 것입니다.)
            move_uploaded_file($_FILES["upload"]["tmp_name"], public_path($path) . '/'.$name);

            // 업로드후 이미지를 보여줄 URL 을 만듭니다.
            $url = url($path . '/'.$name) ;

        } else {
            $message = '업로드된 파일이 없습니다.';
        }
        return json_encode(array('uploaded'=>'1', "fileName"=>$name, 'url'=>$url));
        //return $url;
    }

    public function getDigitImage(Request $request){
        //require_once ('..\..\Utils\kcaptcha.lib.php');
        $captcha = new KCAPTCHA();
        $code = rand_str(4,'1234567890');
        $session = new Session();


        /*if(isset($value)){
            $code =$value;
        }*/
        $session->set("code", $code);

        $captcha->setKeyString($code);
        $captcha->getKeyString();
        $captcha->image();
    }

    public function user_update_info(){
        $user = Sentinel::getuser();
        view()->share("user", $user);
        return view('user_update_info');
    }

    public function post_user_update_info(Request $request){
        $user = Sentinel::getuser();
        $description = $request->input("description", "");
        $password = $request->input("password", "");
        if($password != ''){
            $password = Hash::make($password);
            $user['password'] = $password;
        }
        $user['description'] =$description;
        $user->save();
        return json_encode(array("status"=>1));
    }

    public function getUserRegister(){
        return view('register');
    }

    public function postRegister(UserRequest $request)
    {
        $activate = $this->user_activation; //make it false if you don't want to activate user automatically it is declared above as global variable
        $code = $request->input("code", "");
        $session = new Session();
        $value = $session->get('code');
        if($code != $value){
            $this->messageBag->add('code', "인증코드를 정확히 입력해주십시오.");
            return Redirect::back()->withInput()->withErrors($this->messageBag);
        }
        try {

            // Register the user
            $user = Sentinel::register($request->only(['nickname', 'user_email',  'email', 'password', 'gender']), $activate);
            $description = $request->input("description","");
            $user['description'] = $description;
            $user['user_point'] =100;
            $user['visit_cnt'] =1;
            $user['level_id'] =1;
            $user->save();
            // login user automatically
            Sentinel::login($user, false);
            return redirect("/");

        } catch (UserExistsException $e) {
            $this->messageBag->add('email', trans('auth/message.account_already_exists'));
        }

        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors($this->messageBag);
    }

    /**
     * Account sign in.
     *
     * @return View
     */
    public function getLogin()
    {
        // Is the user logged in?
        if (Sentinel::check()) {
            return Redirect::route('my-account');
        }
        // Show the login page
        return view('login');
    }

    /**
     * Account sign in form processing.
     *
     * @return Redirect
     */
    public function postLogin(Request $request)
    {
        getCurrentLang();
        try {
            // Try to log the user in
            if ($user=  Sentinel::authenticate($request->only('email', 'password'), $request->get('remember-me', 0))) {
                if($user['status']*1 == 91){
                    Sentinel::logout();
                    $this->messageBag->add('email', __('lang.account_not_found'));
                    return Redirect::back()->withInput()->withErrors($this->messageBag);
                }
                $user['visit_cnt'] = $user['visit_cnt']+1;
                $user->save();
                return redirect("/");
            } else {
                $this->messageBag->add('email', __('lang.account_not_found'));
                return Redirect::back()->withInput()->withErrors($this->messageBag);
            }
        } catch (UserNotFoundException $e) {
            $this->messageBag->add('email', __('lang.account_not_found'));
        } catch (NotActivatedException $e) {
            $this->messageBag->add('email', __('lang.account_not_activated'));
        } catch (UserSuspendedException $e) {
            $this->messageBag->add('email', __('lang.account_suspended'));
        } catch (UserBannedException $e) {
            $this->messageBag->add('email', __('lang.account_banned'));
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            $this->messageBag->add('email', __('lang.account_suspended', compact('delay')));
        }

        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors($this->messageBag);
    }

    /**
     * get user details and display
     */
    public function myAccount(User $user)
    {
        $user = Sentinel::getUser();
        $countries = $this->countries;
        return view('user_account', compact('user', 'countries'));
    }

    /**
     * update user details and display
     * @param Request $request
     * @param User $user
     * @return Return Redirect
     */
    public function update(User $user, FrontendRequest $request)
    {
        $user = Sentinel::getUser();
        //update values
        $user->update($request->except('password','pic','password_confirm'));

        if ($password = $request->get('password')) {
            $user->password = Hash::make($password);
        }
        // is new image uploaded?
        if ($file = $request->file('pic')) {
            $extension = $file->extension()?: 'png';
            $folderName = '/uploads/users/';
            $destinationPath = public_path() . $folderName;
            $safeName = str_random(10) . '.' . $extension;
            $file->move($destinationPath, $safeName);

            //delete old pic if exists
            if (File::exists(public_path() . $folderName . $user->pic)) {
                File::delete(public_path() . $folderName . $user->pic);
            }
            //save new file path into db
            $user->pic = $safeName;

        }

        // Was the user updated?
        if ($user->save()) {
            // Prepare the success message
            $success = trans('users/message.success.update');
            //Activity log for update account
            activity($user->full_name)
                ->performedOn($user)
                ->causedBy($user)
                ->log('User Updated successfully');
            // Redirect to the user page
            return Redirect::route('my-account')->with('success', $success);
        }

        // Prepare the error message
        $error = trans('users/message.error.update');


        // Redirect to the user page
        return Redirect::route('my-account')->withInput()->with('error', $error);


    }

    /**
     * Account Register.
     *
     * @return View
     */
    public function getRegister()
    {
        // Show the page
        return view('register');
    }

    /**
     * Account sign up form processing.
     *
     * @return Redirect
     */
    public function postRegister_old(UserRequest $request)
    {
        $data = new stdClass();
        $activate = $this->user_activation; //make it false if you don't want to activate user automatically it is declared above as global variable
        try {
            // Register the user
            $user = Sentinel::register($request->only(['first_name', 'last_name', 'email', 'password', 'gender']), $activate);

            //add user to 'User' group
            $role = Sentinel::findRoleByName('User');
            $role->users()->attach($user);

            //if you set $activate=false above then user will receive an activation mail
            if (!$activate) {
                // Data to be used on the email view
                $data->user_name =$user->first_name .' '. $user->last_name;
                $data->activationUrl = URL::route('activate', [$user->id, Activation::exists($user)->code]);
                // Send the activation code through email
                Mail::to($user->email)
                    ->send(new Restore($data));
                //Redirect to login page
                return redirect('login')->with('success', trans('auth/message.signup.success'));
            }
            // login user automatically
            Sentinel::login($user, false);
            //Activity log for new account
            activity($user->full_name)
                ->performedOn($user)
                ->causedBy($user)
                ->log('New Account created');
            // Redirect to the home page with success menu
            return Redirect::route("my-account")->with('success', trans('auth/message.signup.success'));

        } catch (UserExistsException $e) {
            $this->messageBag->add('email', trans('auth/message.account_already_exists'));
        }

        // Ooops.. something went wrong
        return Redirect::back()->withInput()->withErrors($this->messageBag);
    }

    /**
     * User account activation page.
     *
     * @param number $userId
     * @param string $activationCode
     *
     */
    public function getActivate($userId, $activationCode)
    {
        // Is the user logged in?
        if (Sentinel::check()) {
            return Redirect::route('my-account');
        }

        $user = Sentinel::findById($userId);

        if (Activation::complete($user, $activationCode)) {
            // Activation was successfull
            return Redirect::route('login')->with('success', trans('auth/message.activate.success'));
        } else {
            // Activation not found or not completed.
            $error = trans('auth/message.activate.error');
            return Redirect::route('login')->with('error', $error);
        }
    }

    /**
     * Forgot password page.
     *
     * @return View
     */
    public function getForgotPassword()
    {
        // Show the page
        return view('forgotpwd');

    }

    /**
     * Forgot password form processing page.
     * @param Request $request
     * @return Redirect
     */
    public function postForgotPassword(Request $request)
    {
        $data = new stdClass();
        try {
            // Get the user password recovery code
            $user = Sentinel::findByCredentials(['email' => $request->email]);
            if (!$user) {
                return Redirect::route('forgot-password')->with('error', trans('auth/message.account_email_not_found'));
            }

            $activation = Activation::completed($user);
            if (!$activation) {
                return Redirect::route('forgot-password')->with('error', trans('auth/message.account_not_activated'));
            }

            $reminder = Reminder::exists($user) ?: Reminder::create($user);
            // Data to be used on the email view

            $data->user_name =$user->first_name .' '. $user->last_name;
            $data->forgotPasswordUrl = URL::route('forgot-password-confirm', [$user->id, $reminder->code]);
            // Send the activation code through email
            Mail::to($user->email)
                ->send(new ForgotPassword($data));

        } catch (UserNotFoundException $e) {
            // Even though the email was not found, we will pretend
            // we have sent the password reset code through email,
            // this is a security measure against hackers.
        }

        //  Redirect to the forgot password
        return back()->with('success', trans('auth/message.forgot-password.success'));
    }

    /**
     * Forgot Password Confirmation page.
     *
     * @param  string $passwordResetCode
     * @return View
     */
    public function getForgotPasswordConfirm(Request $request, $userId, $passwordResetCode = null)
    {
        if (!$user = Sentinel::findById($userId)) {
            // Redirect to the forgot password page
            return Redirect::route('forgot-password')->with('error', trans('auth/message.account_not_found'));
        }

        if($reminder = Reminder::exists($user))
        {
            if($passwordResetCode == $reminder->code)
            {
                return view('forgotpwd-confirm', compact(['userId', 'passwordResetCode']));
            }
            else{
                return 'code does not match';
            }
        }
        else
        {
            return 'does not exists';
        }

    }

    /**
     * Forgot Password Confirmation form processing page.
     *
     * @param  string $passwordResetCode
     * @return Redirect
     */
    public function postForgotPasswordConfirm(PasswordResetRequest $request, $userId, $passwordResetCode = null)
    {

        $user = Sentinel::findById($userId);
        if (!$reminder = Reminder::complete($user, $passwordResetCode, $request->get('password'))) {
            // Ooops.. something went wrong
            return Redirect::route('login')->with('error', trans('auth/message.forgot-password-confirm.error'));
        }

        // Password successfully reseted
        return Redirect::route('login')->with('success', trans('auth/message.forgot-password-confirm.success'));
    }

    /**
     * Contact form processing.
     * @param Request $request
     * @return Redirect
     */
    public function postContact(Request $request)
    {
        $data = new stdClass();

        // Data to be used on the email view
        $data->contact_name = $request->get('contact-name');
        $data->contact_email = $request->get('contact-email');
        $data->contact_msg = $request->get('contact-msg');

        // Send the activation code through email
        Mail::to('email@domain.com')
            ->send(new Contact($data));

        //Redirect to contact page
        return redirect('contact')->with('success', trans('auth/message.contact.success'));
    }

    public function showFrontEndView($name=null)
    {
        if(View::exists($name))
        {
            return view($name);
        }
        else
        {
            abort('404');
        }
    }


    /**
     * Logout page.
     *
     * @return Redirect
     */
    public function getLogout()
    {
        if (Sentinel::check()) {
            //Activity log
            Sentinel::logout();
        }
        // Redirect to the users page
        return redirect('/');
    }

    public function user_exit(Request $request){
        $user = Sentinel::getuser();
        $password = $request->input("password_dlg");
        $user = User::find($user['id']);
        if(!isset($user['id'])){
            return json_encode(array("status"=>"0","msg"=>__("lang.정보가 정확하지 않습니다.")));
        }
        if(!password_verify($password, $user['password'])){
            return json_encode(array("status"=>"0","msg"=>"암호가 정확하지 않습니다."));
        }

        $user['status'] = '91';
        $user->save();
        Sentinel::logout();
        return json_encode(array("status"=>"1","msg"=>"성공하였습니다."));
    }


}
