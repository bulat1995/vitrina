@extends('layouts.app')

@section('content')

    <div class="form-body">
      <form method="POST" action="{{ route('register') }}" novalidate class="col-form">
          @csrf
      <div class="col-logo"><a href="{{ route('shop') }}"><img alt="" src="/images/logo.png" style="margin-right:10px;"><img alt="" src="/images/logo-text.png"></a></div>
        <header>{{ __('Register') }}</header>
        <fieldset>

            <section>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <div class="alert alert-danger">{{ $message }}</div>
                    </span>
                @enderror
              <div class="form-group has-feedback">
                    <label class="control-label">{{ __('Name') }}</label>
                    <input class="form-control @error('name') is-invalid @enderror" placeholder="Name" type="name" name="name" value="{{ old('name') }}" required  autofocus>
                    <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
                </div>
            </section>

            <section>
                @error('firstName')
                    <span class="invalid-feedback" role="alert">
                        <div class="alert alert-danger">{{ $message }}</div>
                    </span>
                @enderror
              <div class="form-group has-feedback">
                    <label class="control-label">{{ __('firstName') }}</label>
                    <input class="form-control @error('firstName') is-invalid @enderror" placeholder="Name" type="text" name="firstName" value="{{ old('firstName') }}" required >
                    <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
                </div>
            </section>



            <section>
                @error('secondName')
                    <span class="invalid-feedback" role="alert">
                        <div class="alert alert-danger">{{ $message }}</div>
                    </span>
                @enderror
              <div class="form-group has-feedback">
                    <label class="control-label">{{ __('secondName') }}</label>
                    <input class="form-control @error('secondName') is-invalid @enderror" placeholder="Name" type="text" name="secondName" value="{{ old('secondName') }}" required >
                    <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
                </div>
            </section>

            <section>
                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <div class="alert alert-danger">{{ $message }}</div>
                    </span>
                @enderror
              <div class="form-group has-feedback">
                    <label class="control-label">{{ __('address') }}</label>
                    <input class="form-control @error('address') is-invalid @enderror" placeholder="Name" type="text" name="address" value="{{ old('address') }}" required >
                    <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
                </div>
            </section>

            <section>
                @error('birthday')
                    <span class="invalid-feedback" role="alert">
                        <div class="alert alert-danger">{{ $message }}</div>
                    </span>
                @enderror
              <div class="form-group has-feedback">
                    <label class="control-label">{{ __('birthday') }}</label>
                    <input class="form-control @error('birthday') is-invalid @enderror" placeholder="Name" type="date" name="birthday" value="{{ old('birthday') }}" required >
                    <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
                </div>
            </section>


            <section>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <div class="alert alert-danger">{{ $message }}</div>
                    </span>
                @enderror
              <div class="form-group has-feedback">
                <label class="control-label">{{ __('E-Mail Address') }}</label>
                <input class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" type="email" name="email" value="{{ old('email') }}" required autocomplete="email">
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
                <span class="fa fa-lock form-control-feedback" aria-hidden="true"></span>
            </div>
            <div class="form-group has-feedback">
                <label for="password-confirm" class="control-label">{{ __('Confirm Password') }}</label>
                <input id="password-confirm" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required placeholder="Confirm" autocomplete="new-password">
            </div>
            </section>
        </fieldset>
        <footer class="text-right">
            <button type="submit" class="btn btn-info pull-right">
                {{ __('Register') }}
            </button>
        </footer>
    </form>
    </div>

@endsection
