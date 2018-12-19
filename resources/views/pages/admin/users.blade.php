@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title">{{ $title }} ({{ number_format($users->total()) }})</h3>

	            @if(count($users))
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Name</th>
								<th>Username</th>
								<th>Email</th>
								<th>Coins</th>
								<th>Email Confirmed</th>
								<th>Last Seen</th>
								<th></th>
								
								
							</tr>
						</thead>

						<tbody>
							@foreach($users as $user)
								<tr>
									<td>{{ $user->name }}</td>
									<td>{{ $user->username }}</td>
									<td>{{ $user->email }}</td>
									<td>{{ number_format($user->coins) }}</td>
									<td>{{ $user->email_confirmed ? 'YES' : 'NO' }}</td>
									<td>{{ simple_datetime($user->last_seen) }}</td>
									<td><a href="{{ route('admin.user', ['id' => $user->id]) }}" class=""><i class="fa fa-eye"></i></a></td>
									
									
									
								</tr>
							@endforeach
						</tbody>
					</table>

					{{ $users->links() }}
	            @else
					No {{ $title }}
	            @endif
	            
	        </div> 
	        
	    </div>

	    
	</div>

	
@endsection