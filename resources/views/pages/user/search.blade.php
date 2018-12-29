@extends('layouts.user')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-sm-10 col-sm-offset-1 my-50">
				<h3 class="text-center">
					@if($empty)
						Search for members or donated items
					@else
						Search results for <strong style="text-decoration: underline;">{{ $request->q }}</strong> ({{ number_format($total) }})
					@endif
				</h3>
			</div>
		</div>
	</div>
		

		

@endsection