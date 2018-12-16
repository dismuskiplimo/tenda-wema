@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title">{{ $title }}({{ number_format($deeds->total()) }})</h3>

	            @if(count($deeds))
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Deed</th>
								<th>Location</th>
								<th>Date</th>
								<th>User</th>
								<th>Approved</th>
								<th></th>
								<th></th>
								
							</tr>
						</thead>

						<tbody>
							@foreach($deeds as $deed)
								<tr>
									<td>{{ $deed->name }}</td>
									<td>{{ $deed->location }}</td>
									<td>{{ $deed->performed_at }}</td>
									<td>{{ $deed->user->name }}</td>
									<td>{{ $deed->approved ? 'YES' : 'NO' }}</td>
									<td><a href="{{ route('admin.deed', ['id' => $deed->id]) }}" class=""><i class="fa fa-eye"></i></a></td>
									<td class="">
										@if($deed->approved)
											<a href=""  data-toggle = "modal" data-target = "#deed-disapprove-{{ $deed->id }}" class="btn btn-xs btn-danger"><i class="fa fa-times" title="Disapprove Deed"></i></a>

											@include('pages.admin.modals.disapprove-deed')
										@else
											@if($deed->disapproved)
												<a href="" data-toggle = "modal" data-target = "#deed-approve-{{ $deed->id }}"  class="btn btn-xs btn-success"><i class="fa fa-check" title="Approve Deed"></i></a>
											@else
												<a href="" data-toggle = "modal" data-target = "#deed-approve-{{ $deed->id }}"  class="btn btn-xs btn-success"><i class="fa fa-check" title="Approve Deed"></i></a>

												<a href="" data-toggle = "modal" data-target = "#deed-disapprove-{{ $deed->id }}" class="btn btn-xs btn-danger"><i class="fa fa-times" title="Disapprove Deed"></i></a>

												@include('pages.admin.modals.disapprove-deed')
											@endif

											@include('pages.admin.modals.approve-deed')
											

										@endif

									</td>
									
									
								</tr>
							@endforeach
						</tbody>
					</table>

					{{ $deeds->links() }}
	            @else
					No {{ $title }}
	            @endif
	            
	        </div> 
	        
	    </div>

	    
	</div>


	

	
@endsection