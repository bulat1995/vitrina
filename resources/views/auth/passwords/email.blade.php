@extends('layouts.app')

@section('content')

    <div class="form-body">
      <form method="POST" action="{{ route('password.email') }}" novalidate class="col-form">
          @csrf
      <div class="col-logo"><a href="{{ route('shop') }}"><img alt="" src="/images/logo.png" style="margin-right:10px;"><img alt="" src="/images/logo-text.png"></a></div>
        <header>{{ __('Reset Password') }}</header>
        <fieldset>
            <section>
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
              <div class="form-group has-feedback">
                <label class="control-label">{{ __('E-Mail Address') }}</label>
                <input class="form-control @error('email') is-invalid @enderror" placeholder="E-mail" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                <span class="fa fa-envelope form-control-feedback" aria-hidden="true"></span>
            </div>
            </section>


        </fieldset>
        <footer class="text-right">
            <button type="submit" class="btn btn-info pull-right">
                {{ __('Send Password Reset Link') }}
            </button>
        </footer>
    </form>
    </div>


@endsection
