@extends('layout.master')
@section('content')
<section id="form"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Login to your account</h2>
						<form action="{{ route('postLogin') }}" method="POST">
							@csrf()
							<input required name="email" type="email" placeholder="Email Address" />
							<input required name="password" type="password" placeholder="Password" />
							@if(session('Error'))
							<p class="error">
								{{ session('Error') }}
							</p>
							@endif
							<span>
								<input name="remember" type="checkbox" class="checkbox"> 
								Keep me signed in
							</span>
							<button type="submit" class="btn btn-default">Login</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>New User Signup!</h2>
						<form action="{{ route('register') }}" method="POST">
							@csrf()
							<input value="{{ old('name') ? old('name') : '' }}" required name="name" type="text" placeholder="Name"/>
							@if($errors->has('name'))
							<p class="error">
								{{ $errors->first('name') }}
							</p>
							@endif
							<input value="{{ old('email') ? old('email') : '' }}" required name="email" type="email" placeholder="Email Address"/>
							@if($errors->has('email'))
							<p class="error">
								{{ $errors->first('email') }}
							</p>
							@endif
							<input required name="password" type="password" placeholder="Password"/>
							@if($errors->has('password'))
							<p class="error">
								{{ $errors->first('password') }}
							</p>
							@endif
							<button type="submit" class="btn btn-default">Signup</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
    </section><!--/form-->
@stop
