@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title"> {{ $title }} ({{ number_format($conversations->total()) }})</h3>
	            
	            @if($conversations->total())
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Recepient</th>
								<th>Message</th>
								<th></th>
							</tr>
						</thead>

						<tbody>
							@foreach($conversations as $conversation)
								@php
									if($conversation->from_admin)
										$recepient = $conversation->to;
									else{
										$recepient = $conversation->from;
									}

									$class = '';

									if($conversation->last_message){
										if($conversation->last_message->support && !$conversation->last_message->from_admin && !$conversation->last_message->read){
											$class = ' class="bg-light"';
										}

									}
								@endphp

								<tr{!! $class !!}>
									<td>{{ $recepient->name }}</td>
									
									<td>
										{{ $conversation->last_message ? characters($conversation->last_message->message, 50) : 'No messages' }}
									</td>
									
									<td class="text-right"><a {!! $class !!} href="{{ route('admin.message.view', ['id' => $conversation->id]) }}"><i class="fa fa-eye"></i> View</a></td>
								</tr>
							@endforeach
						</tbody>
					</table>

					{{ $conversations->links() }}
	            @else
					<p class="text-muted">No Conversations</p>
	            @endif
	        </div> 
	        
	    </div>

	    
	</div>


	

	
@endsection