@extends('layouts.user')

@section('content')
	<section id="page-title">

		<div class="container clearfix">
			<h1>{{ $title }}</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li>Account</li>
				<li class="active">{{ $title }}</li>
			</ol>
		</div>

	</section>

	<div class="container">
		<div class="row my-50">
			<div class="col-sm-3 text-center">
				<div class="card">
					<div class="card-body">
						<h4>AVALIABLE BALANCE</h4>
						<h2>
							<img src="{{ simba_coin() }}" alt="Simba Coin" class="size-30">
							{{ number_format($user->coins) }}
							<small>Simba Coins</small>
						</h2>

						<hr>

						<p>
							<strong>
								{{ number_format($user->accumulated_coins) }}
							</strong>

							 accumulated Simba Coins since joining {{ config('app.name') }}

						</p>
					</div>
				</div>

				
			</div>

			<div class="col-sm-9">
				<h4>HISTORY 
					<span class="pull-right">
						@if($coin_request)
							<a href="#" class="btn btn-primary btn-block btn-xs">
								COIN PURCHASE REQUESTED, PLEASE WAIT FOR FEEDBACK FROM ADMIN
							</a>
						@else
							<a href="{{ route('user.purchase-coins') }}" class="btn btn-primary btn-block btn-lg" data-toggle="modal" data-target="#purchase-coins">
								<img src="{{ simba_coin() }}" alt="" class="size-20 mr-5"> 
								PURCHASE EXTRA COINS
							</a>
						@endif

					</span>
				</h4>

				@if($user->simba_coin_logs()->count())
					<table class="table table-hover">
						<thead>
							<tr>
								<th class="">DATE</th>
								<th class="text-right">AMOUNT</th>
								
								<th class="">DESCRIPTION</th>
								<th class="text-right">BALANCE</th>
							</tr>
						</thead>

						<tbody>
							@foreach($user->simba_coin_logs()->orderBy('created_at', 'DESC')->paginate(50) as $log)
								<tr class="{{ $log->type == 'credit' ? 'text-success' : 'text-danger' }}">
									<td>
										<small>{{ simple_datetime($log->created_at) }}</small>	
									</td>

									<td class="text-right">
										{{ $log->type == 'debit' ? '- ' : '+ ' }} {{ number_format($log->coins) }} 
										<img src="{{ simba_coin() }}" alt="Simba Coin" class="size-20 mtn-4">
									</td>
									
									<td>{{ $log->message }}</td>
									<td class="text-right">
										{{ number_format($log->current_balance) }} 
										<img src="{{ simba_coin() }}" alt="Simba Coin" class="size-20 mtn-4">
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					{{ $user->simba_coin_logs()->orderBy('created_at', 'DESC')->paginate(50)->links() }}
					
				@else
					No Transaction History
				@endif
			</div>
		</div>
	</div>
	
	@include('pages.user.modals.buy-coins')

@endsection