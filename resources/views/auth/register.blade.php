@extends('layouts.guest')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xxl-8 col-lg-6">
        <div class="card pt-4 pb-4 ">
          <!-- Logo -->
          <div class="card-body p-4">
            <div class="text-center w-75 m-auto">
              <h4 class="text-dark-50 text-center mt-0 fw-bold">Inscription gratuit</h4>
              <p class="text-muted mb-4">Vous n'avez pas de compte ? <br>Créez votre compte, cela prend moins d'une minute</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
              @csrf

              <div class="row">
                <div class="col-md-6 col-sm-12 mb-3">
                  <label for="firstname" class="form-label">{{ __('Votre nom') }} <span class="text-danger">*</span></label>
                  <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror"
                         name="firstname" value="{{ old('firstname') }}" required autofocus>
                  @error('firstname')
                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                  @enderror
                </div>

                <div class="col-md-6 col-sm-12 mb-3">
                  <label for="lastname" class="form-label">{{ __('Prénom') }} <span class="text-danger">*</span></label>
                  <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror"
                         name="lastname" value="{{ old('lastname') }}" required>
                  @error('lastname')
                  <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                  @enderror
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 col-sm-12 mb-3">
                  <label for="phone" class="form-label">{{ __('Numéro de téléphone') }} <span class="text-danger">*</span></label>
                  <div class="input-group flex-nowrap">
                    <span class="input-group-text" id="basic-addon1">+261</span>
                    <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone"
                           value="{{ old('phone') }}" required>
                  </div>
                  <span class="help-block"><small>Ce numéro de telephone sera nécessaire pour se connecter et effectuer une commande</small></span>
                  @error('phone')
                  <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>


              <div class="mb-3">
                <label for="email" class="form-label">{{ __('Votre adresse email') }}</label>
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                         value="{{ old('email') }}" autocomplete="email">
                <span class="help-block"><small>L'adresse email ou électronique est facultative</small></span>
                  @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
              </div>


              <div class="row">
                <div class="col-md-6 col-sm-12 mb-3">
                  <label for="password" class="form-label">{{ __('Mot de passe') }} <span class="text-danger">*</span></label>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                         name="password" required autocomplete="new-password">

                  @error('password')
                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                  @enderror
                </div>
                <div class="col-md-6 col-sm-12 mb-3">
                  <label for="password-confirm"
                         class="form-label">{{ __('Confirm Password') }} <span class="text-danger">*</span></label>
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation"
                         required autocomplete="new-password">
                </div>
              </div>

              <div class="mb-3">
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="checkbox-signup" required>
                  <label class="form-check-label" for="checkbox-signup">J'accept les <a href="javascript: void(0);" class="text-muted">Terms and Conditions</a></label>
                </div>
              </div>

              <div class="row mb-0">
                <div class="col-md-6 ">
                  <button type="submit" class="btn btn-primary text-white">
                    {{ __('S\'enregistrer') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
