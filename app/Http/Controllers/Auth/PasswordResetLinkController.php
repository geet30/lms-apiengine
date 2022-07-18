<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Repositories\SparkPost\SparkPost;
use App\Http\Requests\User\ForgotPassword;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Passwords\PasswordBroker;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(ForgotPassword $request,PasswordBroker $broker)
    { 
        $email = EmailTemplate::whereId(3)->select("subject", "description")->first();
        $find = ['@Name@', '@Phone@', '@Link@', '@Email@'];
        $user = User::where('email',$request->email)->first();
        $time=time()+strtotime('2 day', 0);
        $token = $broker->createToken($user);
        $url = encryptGdprData($time.'+'.$token);
        $link = url("affiliates/generate-password/".$url);
        $values = [ucfirst(decryptGdprData($user->first_name)) . ' ' . ucfirst(decryptGdprData($user->last_name)), decryptGdprData($user->phone), $link, decryptGdprData($user->email)];
        $html = str_replace($find, $values, $email->description);
        User::where('email', $user->email)->update(['token' => $token]);
        $sendData = [
            'from_email' => config('env.FROM_EMAIL'),
            'service_id' => 3,
            'user_email' => decryptGdprData($request->email),
            'subject'    => $email->subject,
            'cc_mail'    => [],
            'bcc_mail'   => [],
            'attachments' => [],
            'text'        => '',
            'html'        => $html
        ];

        $sparkpost = new SparkPost();
        $data = $sparkpost->sendEmail($sendData);
        return $data;
       
    }

    public function getForgotPassword($token = null){
        $user =  DB::table('users')->where('token', '=', $token)->first();
        return view('pages.affiliates.create_update.generate_password')->with('user', $user);
    }

   

    /**
     * Handle an incoming api password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function apiStore(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user){
            throw ValidationException::withMessages([
                'email' => ['User with such email doesn\'t exist']
            ]);
        }

        return response('Password reset email successfully sent.');
    }
}
