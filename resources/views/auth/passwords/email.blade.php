@extends('layouts.front')

@section('pagespecificstyles')

  <style>
	  .note-danger {
		padding: 5px;
		background-color: #f44336;
		color: white;
		opacity: 1;
	  }
  </style>

@section('content')
    <div class="container login-home">
		<div class="grid-container">
            <div class="grid-item" style="position:relative">
			    <div class="signin-box">
					<div class="logo text-center">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="261" height="101" viewBox="0 0 261 101"><defs><clipPath id="a"><rect width="261" height="101" transform="translate(0 0.053)" fill="#fff" stroke="#707070" stroke-width="1"/></clipPath><pattern id="b" preserveAspectRatio="none" width="100%" height="100%" viewBox="0 0 1200 1200"><image width="1200" height="1200" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAABLAAAASwCAMAAADc/0P9AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAAlQTFRFsBMhAAAAAAAAUPktvQAAAAN0Uk5T//8A18oNQQAAFGhJREFUeNrs3VuW4ygURUFg/oPuCeTqsiwucEzEt0u+icQuv9LZBkCIZgkAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAAQLECwAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAAQLECwAwQIQLECwAAQLECwAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAAQLECwAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAAQLECwAwQIQLECwAAQLECwAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAAQLECwAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAAQLECwAwQIEyxIAggUgWIBgAQgWgGABggUgWACCBQgWgGABCBYgWACCBSBYgGABCBaAYAGCBSBYAIIFCBaAYAEIFiBYAIIFIFiAYAEIFiBYAIIFIFiAYAEIFoBgAYIFIFgAggUIFoBgAQgWIFgAggUgWIBgAQgWgGABggUgWACCBQgWgGAB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BSBYAIIFCBaAYAEIFiBYAIIFIFiAYAEIFoBgAYIFIFiAYAEIFoBgAYIFIFgAggUIFoBgAQgWIFgAggUgWIBgAQgWgGABggUgWACCBQgWgGABCBYgWACCBSBYgGABCBaAYAGCBSBYgGABCBaAYAGCBSBYAIIFCBaAYAEIFiBYAIIFIFiAYAEIFoBgAYIFIFgAggUIFoBgAQgWIFgAggUgWIBgAQgWgGABggUgWIBgAQgWgGABggUgWACCBQgWgGABCBYgWACCBSBYgGABCBaAYAGCBSBYAIIFCBaAYAEIFiBYAIIFIFiAYAEIFoBgAYIFIFiAYAEIFoBgAYIFIFgAggUIFoBgAQgWIFgAggUgWIBgAQgWgGABggUgWACCBQgWgGABCBYgWACCBSBYgGABCBaAYAGCBSBYgGABCBaAYAGCBSBYAIIFCBaAYAEIFiBYAIIFIFiAYAEIFoBgAYIFIFgAggUIFoBgAQgWIFgAggUgWIBgAQgWgGABggUgWIBgAQgWgGABggUgWACCBQgWgGABCBYgWACCBSBYgGABCBaAYAGCBSBYAIIFCBaAYAEIFiBYAIIFIFiAYAEIFiBYlgAQLADBAgQLQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAMECECwAwQIEC0CwAAQLECwAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAAQLECwAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAEC0CwAMECECwAwQIEC0CwAMECECwAwQIEC0CwAAQLECwAwQIQLECwAAQLQLAAwQIQLADBAgQLQLAABAsQLADBAhAsQLAABAtAsADBAhAsAMECBAtAsADBAhAsAMECBAtAsAAECxAsAMECECxAsAAEC0CwAMEC2Ow/AQYA7MtQs3XP5LAAAAAASUVORK5CYII="/></pattern></defs><g transform="translate(-160.484 -13.66)"><g transform="translate(160.484 13.607)" clip-path="url(#a)"><rect width="343" height="344" transform="translate(-41 -126.947)" fill="url(#b)"/></g></g></svg>
					</div>
					<div class="login-box">

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <a class="black" href="{{url('')}}"><p><i class="fa fa-angle-left p-r-5"></i>Back to Homepage</p></a>
						<h2>Reset Your Password</h2>
						<p>Please provde Email.</p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="grid-item" style="position: static; padding: 0px;">

            <div class="container-img" style="background-image:url('vendor/ecutech-code/images/login-hero-image.jpg')">
            </div>
        </div>
        <div class="cut"></div>
    </div>
</div>
@endsection
