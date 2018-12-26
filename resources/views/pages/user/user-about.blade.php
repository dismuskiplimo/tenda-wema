@extends('layouts.user')

@section('content')
	<section id="page-title">

		<div class="container clearfix">
			<h1>{{ $user->name }}</h1>
			<ol class="breadcrumb">
				<li><a href="{{ route('homepage') }}">Home</a></li>
				<li><a href="{{ route('registered-members') }}">Registered Members</a></li>
				<li class="active">{{ $user->name }}</li>
			</ol>
		</div>

	</section>

	<div class="container">
		<div class="row my-50">
			<div class="col-sm-3">
				@include('includes.user.profile-sidebar')
			</div>

			<div class="col-sm-9">
				<h4>ABOUT {{ strtoupper($user->fname) }}</h4>

				<h5>
					About:

					@if($me)
						<a href="" data-toggle="modal" data-target="#about-me" class="btn btn-xs btn-info pull-right">Edit</a>
					@endif
				</h5>
                <hr class = "mtn-5">
                {!! clean(nl2br($user->about_me ? : 'No Details')) !!}

                <br>

                <h5>
                    My Hobbies:
                    @if($me)
                        <a href="" data-toggle="modal" data-target="#add-hobby" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus"></i> Add Hobby</a>
                    @endif
                </h5>
                <hr class = "mtn-5">

                @if(count($user->hobbies))                        
                    <ul class="ml-20">
                        @foreach($user->hobbies as $hobby)
                            <li>
                                {{ $hobby->name }}

                                @if($me)
                                    <span class="pull-right">
                                        <button class="btn btn-warning btn-xs" type="button"  data-toggle="modal" data-target="#edit-hobby-{{ $hobby->id }}"  title="edit {{ $hobby->name }}">
                                            <i class="fa fa-edit"></i>
                                        </button> 

                                        <button class="btn btn-danger btn-xs" type="button" data-toggle="modal" data-target="#delete-hobby-{{ $hobby->id }}" title="delete {{ $hobby->name }}">
                                            <i class="fa fa-trash"></i>
                                        </button> 
                                    </span>

                                    @include('pages.user.modals.edit-hobby')
                                    @include('pages.user.modals.delete-hobby')
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="ml-20">No Hobbies Stated</p>
                @endif
                    
                
                <br>
                	<h5>
                		Memberships:
						@if($me)
							<a href="" data-toggle="modal" data-target="#add-membership" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus"></i> Add Membership</a>
						@endif
                	</h5>
                <hr class = "mtn-5">
                
                @if(count($user->memberships))
                    
                    <ul class="ml-20">
                        @foreach($user->memberships as $membership)
                            <li>
                            	{{ $membership->name }}
								@if($me)
									<span class="pull-right">
										<button class="btn btn-warning btn-xs" type="button"  data-toggle="modal" data-target="#edit-membership-{{ $membership->id }}"  title="edit {{ $membership->name }}">
											<i class="fa fa-edit"></i>
										</button> 

										<button class="btn btn-danger btn-xs" type="button" data-toggle="modal" data-target="#delete-membership-{{ $membership->id }}" title="delete {{ $membership->name }}">
											<i class="fa fa-trash"></i>
										</button> 
									</span>

                                    @include('pages.user.modals.edit-membership')
                                    @include('pages.user.modals.delete-membership')
								@endif
                            </li>
                        @endforeach
                    </ul>

                @else
                    <p class="ml-20">No Memberships Stated</p>
                @endif

                <h5>
                	Education:
					@if($me)
						<a href="" data-toggle="modal" data-target="#add-education" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus"></i> Add Education</a>
					@endif
                </h5>
                <hr class = "mtn-5">
                <div>
                    @if(count($user->education))
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>School</th>
                                    <th>Level</th>
                                    <th>Field of Study</th>
                                    <th>Grade</th>

                                    @if($me)
                                        <th></th>
                                    @endif
                                </tr>
                                
                                
                                
                            </thead>

                            <tbody>
                                @foreach($user->education as $education)
                                    <tr>
                                        <td>{{ $education->start_year }}</td>
                                        <td>{{ $education->end_year }}</td>
                                        <td>{{ $education->school }}</td>
                                        <td>{{ $education->level }}</td>
                                        <td>{{ $education->field_of_study }}</td>
                                        <td>{{ $education->grade }}</td>
                                        
                                        @if($me)
											<td>
                                                @include('pages.user.modals.edit-education')
                                                @include('pages.user.modals.delete-education')
                                            </td>

                                            <td class="text-right">
												<button class="btn btn-warning btn-xs" type="button"  data-toggle="modal" data-target="#edit-education-{{ $education->id }}"  title="edit {{ $education->school }}">
													<i class="fa fa-edit"></i>
												</button> 

												<button class="btn btn-danger btn-xs" type="button" data-toggle="modal" data-target="#delete-education-{{ $education->id }}" title="delete {{ $education->school }}">
													<i class="fa fa-trash"></i>
												</button> 	

                                                
											</td>

											
										@endif
                                        
                                    </tr>
                                    
                                @endforeach
                            </tbody>
                            
                        </table>
                    @else
                        <p class="ml-20">No Education Info</p>
                    @endif
                </div>

                <h5>
                	Work Experience:
					@if($me)
						<a href="" data-toggle="modal" data-target="#add-work-experience" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus"></i> Add Work Experience</a>
					@endif
                </h5>
                
                <hr class = "mtn-5">
                <div>
                    @if(count($user->work_experience))
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>Company</th>
                                    <th>Position</th>

                                    @if($me)
                                        <th></th>
                                    @endif
                                </tr>
                                
                                
                                
                                
                            </thead>

                            <tbody>
                                @foreach($user->work_experience as $work_experience)
                                    <tr>
                                        <td>{{ $work_experience->from_date }}</td>
                                        <td>{{ $work_experience->to_date }}</td>
                                        <td>{{ $work_experience->company }}</td>
                                        <td>{{ $work_experience->position }}</td>
                                        
                                        @if($me)
											<td>
                                                @include('pages.user.modals.edit-work-experience')
                                                @include('pages.user.modals.delete-work-experience')
                                            </td>

                                            <td class="text-right">
												<button class="btn btn-warning btn-xs" type="button"  data-toggle="modal" data-target="#edit-work-experience-{{ $work_experience->id }}"  title="edit {{ $work_experience->company }}">
													<i class="fa fa-edit"></i>
												</button> 

												<button class="btn btn-danger btn-xs" type="button" data-toggle="modal" data-target="#delete-work-experience-{{ $work_experience->id }}" title="delete {{ $work_experience->company }}">
													<i class="fa fa-trash"></i>
												</button> 

											</td>


                                        @endif
                                    </tr>
                                    
                                @endforeach
                            </tbody>
                            
                        </table>
                    @else
                        <p class="ml-20">No Work Expereince Stated</p>
                    @endif
                </div>
                
                <br>

                <h5>
                	Skills:
					@if($me)
						<a href="" data-toggle="modal" data-target="#add-skill" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus"></i> Add Skill</a>
					@endif
                </h5>
                <hr class = "mtn-5">
                
                @if(count($user->skills))
                    <ul class="ml-20">
                        @foreach($user->skills as $skill)
                            <li>
                            	{{ $skill->skill }}
								
								@if($me)
									<span class="pull-right">
										<button class="btn btn-warning btn-xs" type="button"  data-toggle="modal" data-target="#edit-skill-{{ $skill->id }}"  title="edit {{ $skill->skill }}">
											<i class="fa fa-edit"></i>
										</button> 

										<button class="btn btn-danger btn-xs" type="button" data-toggle="modal" data-target="#delete-skill-{{ $skill->id }}" title="delete {{ $skill->skill }}">
											<i class="fa fa-trash"></i>
										</button> 
									</span>

                                    @include('pages.user.modals.edit-skill')
                                    @include('pages.user.modals.delete-skill')
								@endif

                            </li>
                        @endforeach
                    </ul>
                    

                @else
                    <p class="ml-20">No Skills Stated</p>
                @endif
                
                <br>

                <h5>
					Awards:
					@if($me)
						<a href="" data-toggle="modal" data-target="#add-award" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus"></i> Add Award</a>
					@endif
				</h5>
                <hr class = "mtn-5">
                
                @if(count($user->awards))
                    <ul class="ml-20">
                        @foreach($user->awards as $award)
                            <li>
                            	{{ $award->name }}, {{ $award->year }} 
								
								@if($me)
									<span class="pull-right">
										<button class="btn btn-warning btn-xs" type="button"  data-toggle="modal" data-target="#edit-award-{{ $award->id }}"  title="edit {{ $award->name }}">
											<i class="fa fa-edit"></i>
										</button> 

										<button class="btn btn-danger btn-xs" type="button" data-toggle="modal" data-target="#delete-award-{{ $award->id }}" title="delete {{ $award->name }}">
											<i class="fa fa-trash"></i>
										</button> 
									</span>

                                    @include('pages.user.modals.edit-award')
                                    @include('pages.user.modals.delete-award')
								@endif
                            </li>
                        @endforeach
                    </ul>
                    

                @else
                    <p class="ml-20">No Awards Stated</p>
                @endif                

                <br>
                <h5>
                	Achievements:
					@if($me)
						<a href="" data-toggle="modal" data-target="#add-achievement" class="btn btn-xs btn-info pull-right"><i class="fa fa-plus"></i> Add Achievements</a>
					@endif
                </h5>
                <hr class = "mtn-5">

                @if(count($user->achievements))
                    
                    <ul class="ml-20">
                        @foreach($user->achievements as $achievement)
                            <li>
                            	{{ $achievement->name }}

                            	@if($me)
									<span class="pull-right">
										<button class="btn btn-warning btn-xs" type="button"  data-toggle="modal" data-target="#edit-achievment-{{ $achievement->id }}"  title="edit {{ $achievement->name }}">
											<i class="fa fa-edit"></i>
										</button> 

										<button class="btn btn-danger btn-xs" type="button" data-toggle="modal" data-target="#delete-achievement-{{ $achievement->id }}" title="delete {{ $achievement->name }}">
											<i class="fa fa-trash"></i>
										</button>
									</span>

                                    @include('pages.user.modals.edit-achievement')
                                    @include('pages.user.modals.delete-achievement')
								@endif
                            </li>
                        @endforeach
                    </ul>
                    
                @else
                    <p class="ml-20">No Achievements Stated</p>
                @endif
			</div>
		</div>
	</div>
		

@if($me)
	@include('pages.user.modals.about-me')
	@include('pages.user.modals.add-membership')
    @include('pages.user.modals.add-award')
    @include('pages.user.modals.add-hobby')
    @include('pages.user.modals.add-achievement')
    @include('pages.user.modals.add-education')
    @include('pages.user.modals.add-work-experience')
    @include('pages.user.modals.add-skill')
   
@endif
		

@endsection