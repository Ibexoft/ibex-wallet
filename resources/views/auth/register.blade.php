@extends('layouts.app')
@section('content')
    <section>
        <div class="page-header min-vh-100">
            <div class="container">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                        <div class="card card-plain">
                            <div class="ps-4 pb-0 text-left">
                                <h4 class="font-weight-bolder">Register</h4>
                                <p class="mb-0">Enter your details to register</p>
                            </div>
                            <div class="card-body">
                                <form role="form">
                                    <div class="mb-3">
                                        <input type="text" class="form-control form-control-lg" placeholder="Name" name="name"
                                            aria-label="Name" aria-describedby="name-addon">
                                    </div>
                                    <div class="mb-3">
                                        <input type="email" class="form-control form-control-lg" placeholder="Email" name="email"
                                            aria-label="Email" aria-describedby="email-addon">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control form-control-lg" placeholder="Password" name="password"
                                            aria-label="Password" aria-describedby="password-addon">
                                    </div>
                                    <div class="mb-3">
                                        <input type="password" class="form-control form-control-lg" placeholder="Confirm Password" name="password_confirmation"
                                            aria-label="Confirm  Password" aria-describedby="confirm-password-addon">
                                    </div>
                                    <div class="text-center">
                                        <button type="submit"
                                            class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Register</button>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                <p class="mb-4 text-sm mx-auto">
                                    Already have an account?
                                    <a href="{{route('login')}}"
                                     class="text-primary text-gradient font-weight-bold">Sign in</a>
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
