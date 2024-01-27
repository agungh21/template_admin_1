@extends('layouts.layout_login')

@section('content')
    <div>
        <div class="wave"></div>
        <div class="wave"></div>
        <div class="wave"></div>
    </div>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
            <div class="">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="text-center mb-3">
                        <i class="fa-solid fa-circle-user fs-1 mb-3 text-white"></i>
                        <h2 class="fw-bold text-white" style="z-index: 9999;">LOGIN</h2>
                    </div>
                    <div class="position-relative mt-3 form-input">
                        <div class="input-group mb-3">
                            <span class="input-group-text text-primary" id="basic-addon1"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="Masukkan Email" aria-label="Email" aria-describedby="basic-addon1" value="{{ old('email') }}" required>
                          </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text text-primary" id="basic-addon1"><i class="fa-solid fa-key"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan Password" aria-label="Password" aria-describedby="basic-addon1" required>
                          </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-outline-light button fw-bold mt-3">Masuk <i class="fa-solid fa-arrow-right"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
@endsection
@section('scripts')
@if(session()->has('error'))
    <script>
         $(document).ready(function() {
            let message = `{!! \Session::get('error') !!}`;
            warningNotificationSnack(message);
        })
    </script>
@endif
@endsection
