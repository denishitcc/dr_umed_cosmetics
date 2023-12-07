<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <!-- <link rel="icon" type="image/x-icon" href="assets/favicon.ico" /> -->
        <link rel="icon" href="https://www.drumedcosmetics.com.au/wp-content/uploads/2023/08/favicon.jpg" sizes="32x32" />
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/custom.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="auth-outr">
            <div class="w-40 auth-1">
                <div class="w-lg-500px p-10">
                    <form action="{{ route('login.post') }}" method="POST">
                          @csrf
                        <div class="auth-logo text-center"><a href="{{URL::to('/')}}"><img alt="Logo" src="img/logo.svg"> </a></div>
                        <h3 class="text-center">Sign In</h3>
                        <div class="form-group">
                            <label for="InputEmail1">Enter Email Address</label>
                            <input type="text" id="email_address" class="form-control" name="email"  autofocus>
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            
                          </div>
                          <div class="form-group">
                            <label for="InputPassword1">Enter Password</label>
                            <input type="password" id="password" class="form-control" name="password">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            <a href="{{URL::to('forgot-password')}}" class="forgot-link"> Forgot Password? </a>
                          </div>
                          
                         <div class="text-center mt-30">
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Sign In</span>
                                <span class="indicator-progress d-none"> Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span> </span>
                            </button>
                        </div> 

                        @if(session()->has('message'))
                            <div class="alert alert-danger">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                    </form>

                    <div class="separator separator-content">
                        <span>Or</span>
                    </div>
                    <div class="q-log">
                        <a href="{{ url('authorized/google') }}" class="btn">
                            <img alt="" src="img/google-icon.svg" class="h-15px">   
                            Sign in with Google
                        </a>

                        <a href="{{ url('auth/facebook') }}" class="btn">
                            <img alt="" src="img/facebook.svg" class="h-15px">   
                            Sign in with Facebook
                        </a>
                    </div>
                </div>
            </div>
            <div class="w-60 auth-bg1 bg1 auth-info">
                <div class="w-lg-750px p-10">
                    <h2>EXPERIENCE EXCELLENCE AT DR. UMED COSMETICS</h2>
                    <p>Dr. Umed Cosmetics is a home to an exceptional team of talented cosmetic doctors, cosmetic injectors and skin specialists. Specializing in non-invasive cosmetic treatments like antiwrinkle treatments, dermal fillers, skin and anti-ageing, with a strong emphasis on skin rejuvenation with the latest superior quality products and technology. </p>
                </div>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>