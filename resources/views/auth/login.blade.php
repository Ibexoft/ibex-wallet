@extends('layouts.app')
@section('content')
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain">
                                <div class="ps-4 pb-0 text-left">
                                    <h4 class="font-weight-bolder">Sign In</h4>
                                    <p class="mb-0">Enter your email and password to sign in</p>
                                </div>
                                <div class="card-body">
                                    @if ($errors->has('email') || $errors->has('password'))
                                        <div class="alert alert-danger text-xs text-white">
                                            Invalid credentials. Please try again.
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <input type="email" name="email" value="{{ old('email') }}"
                                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                                            placeholder="Email" aria-label="Email" aria-describedby="email-addon">
                                    </div>
                                    <div class="">
                                        <input type="password" name="password"
                                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                                            placeholder="Password" aria-label="Password" aria-describedby="password-addon">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit"
                                            class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
                                    </div>
                                </div>
                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm mx-auto">
                                        Don't have an account?
                                        <a href="{{ route('register') }}"
                                            class="text-primary text-gradient font-weight-bold">Register</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div
                                class="position-relative bg-gradient-primary h-100 m-3 px-5 border-radius-lg d-flex flex-column justify-content-center">
                                <img src="{{ asset('assets/img/shapes/pattern-lines.svg') }}" alt="pattern-lines"
                                    class="position-absolute opacity-4 start-0">
                                <div class="position-relative">
                                    <img class="max-width-500 w-70 position-relative z-index-2"
                                        src="{{ asset('assets/img/illustrations/chat.webp') }}">
                                </div>
                                <h4 class="mt-5 text-white font-weight-bolder">"Your Journey to Endless Financial Possibilities Begins Here!"</h4>
                                <p class="text-white">Stay organized, stay informed, and make decisions that empower you.</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
