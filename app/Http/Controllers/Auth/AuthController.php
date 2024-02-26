<?php
  
namespace App\Http\Controllers\Auth;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon; 
use Mail; 
use Illuminate\Support\Str;
use DB; 
use Laravel\Socialite\Facades\Socialite;
use DateTime;
use App\Models\EmailTemplates;
use URL;

class AuthController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(): View
    {
        return view('auth.login');
    }  
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    // public function registration(): View
    // {
    //     return view('auth.registration');
    // }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required',//'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        // if (Auth::attempt($credentials)) {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'status' => 'active'])) {
            $newUser = User::where('email',$request->email)->update(['last_login'=>new DateTime]);
            return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully loggedin');
        }
        return redirect()->back()->with('message', 'Opps! You have entered invalid credentials');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    // public function postRegistration(Request $request): RedirectResponse
    // {  
    //     $request->validate([
    //         'first_name' => 'required',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|min:6',
    //     ]);
           
    //     $data = $request->all();
    //     $check = $this->create($data);
         
    //     return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    // }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if (Auth::check()) {
            // User is authenticated, redirect to the dashboard
            return view('dashboard');
        } else {
            // User is not authenticated, handle accordingly (e.g., redirect to login)
            return redirect()->route('login');
        }
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    // public function create(array $data)
    // {
    //   return User::create([
    //     'first_name' => $data['first_name'],
    //     'email' => $data['email'],
    //     'password' => Hash::make($data['password'])
    //   ]);
    // }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout(): RedirectResponse
    {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }

    public function forgotpassword()
    {
        return view('auth/forgot-password');
    }

    public function submitForgetPasswordForm(Request $request): RedirectResponse
      {
          $request->validate([
              'email' => 'required|email|exists:users',
          ]);
  
          $token = Str::random(64);
  
          DB::table('password_resets')->insert([
              'email' => $request->email, 
              'token' => $token, 
              'created_at' => Carbon::now()
            ]);
            $url = URL::to("/");
            $users=User::where('email',$request->email)->first();
            $emailtemplate = EmailTemplates::where('email_template_type', 'Forgot Password')->first();
            $_data = [
                'first_name' => $users->first_name,
                'last_name' =>$users->last_name,
                'url' => "<a class='abtn' href=".$url."/reset-password/".($token).">Reset</a>&nbsp;&nbsp;&nbsp;",
                'subject' => $emailtemplate->subject,
            ];
            
            // Check if the template is found
            if ($emailtemplate) {
                $templateContent = $emailtemplate->email_template_description;
                // Replace placeholders in the template with actual values
                $parsedContent = str_replace(
                    ['{{first_name}}', '{{last_name}}', '{{url}}', '{{subject}}'],
                    [$_data['first_name'], $_data['last_name'] ?? '', $_data['url'] ?? '', $_data['subject'] ?? ''],
                    $templateContent
                );

                $data = ([
                    'from_email'=>'support@itcc.net.au',
                    'emailbody' => $parsedContent,
                    'subject'=>$_data['subject']
                ]);
                $sub = $data['subject'];
                $to_email = $request->email;
                Mail::send('email.forgetPassword', $data, function($message) use ($to_email,$sub) {
                    $message->to($to_email)
                    ->subject($sub);
                    $message->from('support@itcc.net.au',$sub);
                });
            }
            
  
          return back()->with('message', 'We have e-mailed your password reset link!');
      }
      public function showResetPasswordForm($token): View
      { 
         return view('auth.forgetPasswordLink', ['token' => $token]);
      }
      public function submitResetPasswordForm(Request $request): RedirectResponse
      {
          $request->validate([
            //   'email' => 'required|email|exists:users',
              'password' => 'required|string|min:6|confirmed',
              'password_confirmation' => 'required'
          ]);
  
          $updatePassword = DB::table('password_resets')
                              ->where([
                                // 'email' => $request->email, 
                                'token' => $request->token
                              ])
                              ->first();
  
          if(!$updatePassword){
              return back()->withInput()->with('error', 'Invalid token!');
          }
          $user = User::where('email', $updatePassword->email)
                      ->update(['password' => Hash::make($request->password)]);
 
          DB::table('password_resets')->where(['email'=> $updatePassword->email])->delete();
  
          return redirect('/login')->with('message', 'Your password has been changed!');
      }
      public function redirectToGoogle()
        {
            return Socialite::driver('google')->redirect();
        }

        public function handleGoogleCallback()
        {
            try {
        
                $user = Socialite::driver('google')->user();
                
                $finduser = User::where('email', $user->getEmail())->first();
                // $finduser = User::where('google_id', $user->id)->first();
                if($finduser){
        
                    Auth::login($finduser);
        
                    return redirect()->intended('dashboard');
        
                }else{
                    $newUser = User::create([
                        'first_name' => $user->name,
                        'email' => $user->email,
                        'google_id'=> $user->id,
                        'password' => encrypt('123456'),
                        'type'=>'admin'
                    ]);
        
                    Auth::login($newUser);
        
                    return redirect()->intended('dashboard');
                }
        
            } catch (Exception $e) {
                dd($e->getMessage());
            }
        }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
           
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function handleFacebookCallback()
    {
        try {
        
            $user = Socialite::driver('facebook')->user();
         
            $finduser = User::where('email', $user->getEmail())->first();
            // $finduser = User::where('facebook_id', $user->id)->first();
         
            if($finduser){
         
                Auth::login($finduser);
       
                return redirect()->intended('dashboard');
         
            }else{
                $newUser = User::updateOrCreate(['email' => $user->email],[
                        'first_name' => $user->name,
                        'email' => $user->email,
                        'facebook_id'=> $user->id,
                        'password' => encrypt('123456'),
                        'type'=>'admin'
                    ]);
        
                Auth::login($newUser);
        
                return redirect()->intended('dashboard');
            }
       
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}