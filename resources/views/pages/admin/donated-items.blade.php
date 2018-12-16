@extends('layouts.admin')

@section('title', $title)

@section('content')
	<div class="row">
	    <div class="col-md-12">
	        <div class="white-box">
	            <h3 class="box-title">{{ $title }}  ({{ number_format($donated_items->total()) }})</h3>

	            @if(count($donated_items))
					<table class="table table-striped">
						<thead>
							<tr>
								<th>Name</th>
								<th>Type</th>
								<th>Condition</th>
								<th>Category</th>
								<th>Donor</th>
								<th>Purchased</th>
								<th>Approved</th>
								<th>Delivered</th>
								<th></th>
								<th></th>
								
							</tr>
						</thead>

						<tbody>
							@foreach($donated_items as $donated_item)
								<tr>
									<td>{{ $donated_item->name }}</td>
									<td>{{ $donated_item->type }}</td>
									<td>{{ $donated_item->condition }}</td>
									<td>{{ $donated_item->category ? $donated_item->category->name : 'N/A' }}</td>
									<td>{{ $donated_item->donor ? $donated_item->donor->name : 'N/A' }}</td>
									<td>{{ $donated_item->bought ? 'YES' : 'NO' }}</td>
									<td>{{ $donated_item->approved ? 'YES' : 'NO' }}</td>
									<td>{{ $donated_item->received ? 'YES' : 'NO' }}</td>
									
									<td><a href="{{ route('admin.donated-item', ['id' => $donated_item->id]) }}" class=""><i class="fa fa-eye"></i></a></td>
									<td class="">
										@if($donated_item->bought)
											@if(!$donated_item->approved && !$donated_item->disapproved)
												<a href=""  data-toggle = "modal" data-target = "#purchase-approve-{{ $donated_item->id }}" class="btn btn-xs btn-success"><i class="fa fa-check" title="Approve Purchase"></i></a>

												<a href=""  data-toggle = "modal" data-target = "#purchase-disapprove-{{ $donated_item->id }}" class="btn btn-xs btn-danger"><i class="fa fa-times" title="Disapprove Purchase"></i></a>

												@include('pages.admin.modals.approve-purchase')
												@include('pages.admin.modals.disapprove-purchase')
											@endif
										@endif

									</td>
									
									
								</tr>
							@endforeach
						</tbody>
					</table>

					{{ $donated_items->links() }}
	            @else
					No {{ $title }}
	            @endif
	            
	        </div> 
	        
	    </div>

	    
	</div>


	

	
@endsection