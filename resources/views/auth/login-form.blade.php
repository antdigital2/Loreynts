<form method="POST" action="{{ route('login') }}">
    @csrf
    @if(getSetting('social-login.facebook_client_id') || getSetting('social-login.twitter_client_id') || getSetting('social-login.google_client_id'))
        <div class="my-1">
            <p class="mb-0">
                {{__("Don't have an account?")}}
                @if(isset($mode) && $mode == 'ajax')
                    <a href="javascript:void(0);" onclick="LoginModal.changeActiveTab('register')" class="text-primary text-gradient font-weight-bold">{{__('Sign up')}}</a>
                @else
                    <a href="{{route('register')}}" class="text-primary text-gradient font-weight-bold">{{__('Sign up')}}</a>
                @endif
            </p>
        </div>
    @endif
    <div class="form-group ">
        <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>
        <div class="">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"  name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="password" class="col-form-label">{{ __('Password') }}</label>
        <div class="input-group">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">
            <div class="input-group-append">
                <span class="input-group-text" onclick="password_show_hide();">
                    <i class="fas fa-eye-slash" id="show_eye"></i>
                    <i class="fas fa-eye d-none" id="hide_eye"></i>
                </span>
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="loginHelpers form-group d-flex flex-row-reverse">
        @if (Route::has('password.request'))
            <div class="pull-right">
                @if(isset($mode) && $mode == 'ajax')
                    <a href="javascript:void(0);" onclick="LoginModal.changeActiveTab('forgot')" class="" id="forgotPass-label">{{ __('Forgot Your Password?') }}</a>
                @else
                    <a href="{{ route('password.request') }}" class="" id="forgotPass-label">{{ __('Forgot Your Password?') }}</a>
                @endif
            </div>
        @endif
    </div>

    <div class="clearfix"></div>
    <div class="form-group row mb-0 mt-4">
        <div class="col">
            <button type="submit" class="btn btn-grow btn-lg btn-primary bg-gradient-primary btn-block">
                {{__('Login')}}
            </button>
        </div>
    </div>
</form>

@if(!getSetting('social-login.facebook_client_id') && !getSetting('social-login.twitter_client_id') && !getSetting('social-login.google_client_id'))
    <hr>
    <div class=" text-center py-2">
        <p class="">
            {{__("Don't have an account?")}}
            @if(isset($mode) && $mode == 'ajax')
                <a href="javascript:void(0);" onclick="LoginModal.changeActiveTab('register')" class="text-primary text-gradient font-weight-bold">{{__('Sign up')}}</a>
            @else
                <a href="{{route('register')}}" class="text-primary text-gradient font-weight-bold">{{__('Sign up')}}</a>
            @endif
        </p>
    </div>
@endif

<script>
    function password_show_hide() {
        const password = document.getElementById("password");
        const show_eye = document.getElementById("show_eye");
        const hide_eye = document.getElementById("hide_eye");
        hide_eye.classList.remove("d-none");
        if (password.type === "password") {
            password.type = "text";
            show_eye.classList.add("d-none");
            hide_eye.classList.remove("d-none");
        } else {
            password.type = "password";
            show_eye.classList.remove("d-none");
            hide_eye.classList.add("d-none");
        }
    }
</script>

<style>
    .input-group-text {
        cursor: pointer;
        background-color: #f8f9fa!important;
        border: 1px solid #ced4da;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
