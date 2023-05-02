@include("layouts.auth-header")
<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a href="index.html"><img src="{{ asset('assets/images/logo/logo-full.png') }}" alt=""></a>
									</div>
                                    <h4 class="text-center mb-4">Sign up your account</h4>
										<form method="POST" action="{{ route('register') }}">
            								@csrf
            								@error('name')
                                                <div class="col-12 alert alert-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                            @error('email')
                                                <div class="col-12 alert alert-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                            @error('password')
                                                <div class="col-12 alert alert-danger" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </div>
                                            @enderror
                                            <div class="mb-3">
                                                <label class="mb-1"><strong>Name</strong></label>
                                                <input type="text" class="form-control" placeholder="Full Name" name="name" id="name" value="{{ old('name') }}" autofocus autocomplete="email" required>
                                            </div>
	                                        <div class="mb-3">
	                                            <label class="mb-1"><strong>Email</strong></label>
	                                            <input type="email" name="email" id="email" class="form-control" placeholder="hello@example.com" class="form-control form-control-user @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" >
	                                        </div>
	                                        <div class="mb-3">
	                                            <label class="mb-1"><strong>Password</strong></label>
	                                            <input type="password" name="password" class="form-control form-control-user  @error('password') is-invalid @enderror" id="password" placeholder="**********" required>
	                                        </div>
                                            <div class="mb-3">
                                                <label class="mb-1"><strong>Confirm Password</strong></label>
                                                <input type="password" name="password_confirmation" class="form-control form-control-user  @error('password') is-invalid @enderror" id="password_confirmation" placeholder="**********" required>
                                            </div>
	                                        <div class="text-center mt-4">
	                                            <button type="submit" class="btn btn-primary btn-block">Sign me up</button>
	                                        </div>
                                    </form>
                                    <div class="cnew-account col-12 mt-3">
                                    <div class="row">
									<div class=" col-6">	</div>
                                    <div class="col-6" style="text-align: right;">
                                        <p>Already have an account? <a class="text-primary" href="{{ route('login') }}">Sign in</a></p>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
@include("layouts.auth-footer")