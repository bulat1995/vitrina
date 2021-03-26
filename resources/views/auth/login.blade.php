@extends('layouts.app')

@section('content')

    <div class="form-body">
                    
      <form method="POST" action="{{ route('login') }}" novalidate class="col-form">
          @csrf
      <div class="col-logo"><a href="{{ route('shop') }}"><img alt="" src="/images/logo.png" style="margin-right:10px;"><img alt="" src="/images/logo-text.png"></a></div>
        <header>{{ __('Login') }}</header>
        <fieldset>

            <section>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <div class="alert alert-danger">{{ $message }}</div>
                    </span>
                @enderror
              <div class="form-group has-feedback">
                <label class="control-label">{{ __('E-Mail Address') }}</label>
                <input class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
            </div>
            </section>

            <section>
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <div class="alert alert-danger">{{ $message }}</div>
                    </span>
                @enderror
              <div class="form-group has-feedback">
                <label class="control-label">{{ __('Password') }}</label>
                <input class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password" type="password">
                <span class="fa fa-lock form-control-feedback" aria-hidden="true"></span> </div>
            </section>

            <section>
                <div class="row">
                  <div class="col-md-6 checkbox">
                      @if (Route::has('password.request'))
                          <a class="modal-opener" href="{{ route('password.request') }}">
                              {{ __('Forgot Your Password?') }}
                          </a>
                      @endif
                   </div>
                  <div class="col-md-6 text-right">
                    <label class="checkbox">
                      <input name="remember" checked="" type="checkbox">
                      <i></i>{{ __('Remember Me') }}</label>
                  </div>
                </div>
              </section>
        </fieldset>
        <footer class="text-right">
            <button type="submit" class="btn btn-info pull-right">
                {{ __('Enter') }}
            </button>
            <a href="{{ route('register') }}" class="button button-secondary">{{ __('Register') }}</a>
        </footer>
    </form>
    </div>
@endsection
