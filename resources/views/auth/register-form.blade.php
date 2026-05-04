<form method="POST" action="{{ route('register') }}" id="register-form">
    @csrf

    @if(getSetting('social-login.facebook_client_id') || getSetting('social-login.twitter_client_id') || getSetting('social-login.google_client_id'))
        <div class="my-1">
            <p class="mb-0">
                {{__('Already got an account?')}}
                @if(isset($mode) && $mode == 'ajax')
                    <a href="javascript:void(0);" onclick="LoginModal.changeActiveTab('login')" class="text-primary text-gradient font-weight-bold">{{__('Sign in')}}</a>
                @else
                    <a href="{{route('login')}}" class="text-primary text-gradient font-weight-bold">{{__('Sign in')}}</a>
                @endif
            </p>
        </div>
    @endif

    <div class="form-group">
        <label for="name" class="col-form-label">{{ __('Name') }}</label>
        <div>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>
        <div>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
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
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" required name="password" autocomplete="new-password">
            <div class="input-group-append">
                <span class="input-group-text" onclick="togglePasswordVisibility('password');">
                    <i class="fas fa-eye-slash toggle-password" id="toggle_password"></i>
                </span>
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>
        <div class="input-group">
            <input id="password-confirm" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" required name="password_confirmation" autocomplete="new-password">
            <div class="input-group-append">
                <span class="input-group-text" onclick="togglePasswordVisibility('password-confirm');">
                    <i class="fas fa-eye-slash toggle-password" id="toggle_password_confirm"></i>
                </span>
            </div>
            @error('password_confirmation')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <div class="custom-control custom-checkbox">
            <div>
                <input class="custom-control-input @error('terms') is-invalid @enderror" id="tosAgree" type="checkbox" name="terms" value="1" placeholder="{{ __('Terms and Conditions') }}">
                <label class="custom-control-label" for="tosAgree">
                    <span>{{ __('I agree to the') }} <a href="{{route('pages.get',['slug'=>GenericHelper::getTOSPage()->slug])}}">{{ __('Terms of Use') }}</a> {{ __('and') }} <a href="{{route('pages.get',['slug'=>GenericHelper::getPrivacyPage()->slug])}}">{{ __('Privacy Policy') }}</a>.</span>
                </label>
            </div>
        </div>
    </div>

    @if(getSetting('security.recaptcha_enabled') && !Auth::check())
        <div class="form-group row d-flex justify-content-center captcha-field">
            {!! NoCaptcha::display(['data-theme' => (Cookie::get('app_theme') == null ? (getSetting('site.default_user_theme')) : Cookie::get('app_theme') )]) !!}
            @error('g-recaptcha-response')
            <span class="text-danger" role="alert">
                <strong>{{__("Please check the captcha field.")}}</strong>
            </span>
            @enderror
        </div>
    @endif

    <div class="form-group row mb-0">
        <div class="col">
            <button type="submit" class="btn btn-grow btn-lg btn-primary bg-gradient-primary btn-block">
                {{ __('Register') }}
            </button>
        </div>
    </div>
</form>

@if(!getSetting('social-login.facebook_client_id') && !getSetting('social-login.twitter_client_id') && !getSetting('social-login.google_client_id'))
    <hr>
    <div class="text-center">
        <p class="mb-4">
            {{__('Already got an account?')}}
            @if(isset($mode) && $mode == 'ajax')
                <a href="javascript:void(0);" onclick="LoginModal.changeActiveTab('login')" class="text-primary text-gradient font-weight-bold">{{__('Sign in')}}</a>
            @else
                <a href="{{route('login')}}" class="text-primary text-gradient font-weight-bold">{{__('Sign in')}}</a>
            @endif
        </p>
    </div>
@endif

<script>
    function togglePasswordVisibility(fieldId) {
        const field = document.getElementById(fieldId);
        const toggleIcon = field.nextElementSibling.querySelector('.toggle-password');
        if (field.type === "password") {
            field.type = "text";
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        } else {
            field.type = "password";
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
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
