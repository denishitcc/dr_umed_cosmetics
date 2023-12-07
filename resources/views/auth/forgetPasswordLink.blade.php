<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Reset Password</title>
        <!-- <link rel="icon" type="image/x-icon" href="assets/favicon.ico" /> -->
        <link rel="icon" href="https://www.drumedcosmetics.com.au/wp-content/uploads/2023/08/favicon.jpg" sizes="32x32" />
        <link href="../css/styles.css" rel="stylesheet" />
        <link href="../css/custom.css" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="auth-outr">
            <div class="w-40 auth-1">
                <div class="w-lg-500px p-10">
                    <form action="{{ route('reset.password.post') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="auth-logo text-center"><a href="{{URL::to('/')}}"><img alt="Logo" src="../img/logo.svg"> </a></div>
                        <h3 class="text-center">Reset Password?</h3>
                        <div class="form-group">
                            <label for="InputEmail1">Enter Email Address</label>
                            <input type="text" id="email_address" class="form-control" name="email" autofocus>
                                  @if ($errors->has('email'))
                                      <span class="text-danger">{{ $errors->first('email') }}</span>
                                  @endif
                          </div>
                          <div class="form-group">
                            <label for="InputPassword1">Enter New Password</label>
                            <input type="password" id="password" class="form-control" name="password" autofocus>
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                          </div>

                          <div class="form-group">
                            <label for="InputEmail1">Enter Confirm Password</label>
                            <input type="password" id="password-confirm" class="form-control" name="password_confirmation"  autofocus>
                                  @if ($errors->has('password_confirmation'))
                                      <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                  @endif
                          </div>
                          
                         <div class="text-center mt-30">
                            <button type="submit" class="btn btn-primary">
                                <span class="indicator-label">Create Password</span>
                                <span class="indicator-progress d-none"> Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span> </span>
                            </button>
                        </div> 
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                    </form>

                    
                  
                </div>
            </div>
            <div class="w-60 auth-bg1 bg2 auth-info">
                <div class="w-lg-750px p-10">
                    <h2>EXPERIENCE EXCELLENCE AT DR. UMED COSMETICS</h2>
                    <p>Dr. Umed Cosmetics is a home to an exceptional team of talented cosmetic doctors, cosmetic injectors and skin specialists. Specializing in non-invasive cosmetic treatments like antiwrinkle treatments, dermal fillers, skin and anti-ageing, with a strong emphasis on skin rejuvenation with the latest superior quality products and technology.</p>
                </div>
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../js/scripts.js"></script>
    </body>
</html>
