@include('includes.email.header')

	<div class="container">
		<p class="text-center"> <img src="{{ $message->embed(logo_absolute()) }}" alt="{{ config('app.name') }} Logo" style="max-width: 100%;height: auto"> </p> <br>
		
		<hr> <br>

		@yield('content')		
	</div>

@include('includes.email.footer')