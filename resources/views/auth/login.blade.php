@extends('layouts.guest')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xxl-4 col-lg-5">
        <div class="card  border-secondary border">
          <!-- Logo -->
          <h4 class="card-title pt-4 text-center">
            Se connecter
          </h4>
          <div class="card-body p-4">
            <form method="POST" action="{{ route('login') }}">
              @csrf

              <div class="mb-3">
                <label for="phone" class="form-label">{{ __('Numéro de téléphone') }}</label>

                <input id="phone" type="text"
                       class="form-control @error('phone') is-invalid @enderror" name="phone"
                       value="{{ old('phone') }}" required autofocus>

                @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>

              <div class=" mb-3">
                <!-- <a href="{{ route('password.request') }}" class="text-muted float-end">
                  <small>Mot de passe oublier ?</small></a> -->
                <label for="password" class="form-label">{{ __('Mot de passe') }}</label>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror" name="password" required
                       autocomplete="current-password">

                @error('password')
                <span class="invalid-feedback " role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>

              <div class="row mb-0">
                <div class="col-md-12 text-center">
                  <button type="submit" class="btn btn-primary text-white">
                    {{ __('Se connecter') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-12 text-center">
            <p class="text-muted">Vous n'avez pas de compte ? <a href="{{route('register')}}"
                                                                 class="text-muted ms-1"><b>S'inscrire</b></a></p>
          </div> <!-- end col -->
        </div>
        <!-- end row -->
      </div>
    </div>
  </div>
@endsection
