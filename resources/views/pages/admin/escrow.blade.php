@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title">{{ $title }}  ({{ number_format($escrow->total()) }})</h3>

	            @if(count($escrow))
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Date</th>
								<th>Amount (Simba Coins)</th>
								<th>Settled</th>
								<th>User</th>
								<th>Donated Item</th>
								
								
								
							</tr>
						</thead>

						<tbody>
							@foreach($escrow as $r)
								<tr>
									<td>{{ $r->created_at }}</td>
									<td>{{ number_format($r->amount) }}</td>
									<td>{{ $r->released ? 'YES' : 'NO' }}</td>
									<td><a href="{{ route('admin.user', ['id' => $r->user->id]) }}">{{ $r->user->name }}</a></td>
									<td><a href="{{ route('admin.donated-item', ['id' => $r->donated_item->id]) }}"> {{ $r->donated_item->name }}</a></td>
																	
									
									
								</tr>
							@endforeach
						</tbody>
					</table>

					{{ $escrow->links() }}
	            @else
					No {{ $title }}
	            @endif
	            
	        </div> 
	        
	    </div>

	    
	</div>


	

	
@endsection