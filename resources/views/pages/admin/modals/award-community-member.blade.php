<div class="modal fade" id="award-community-member-{{ $user->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.user.award-community-member', ['id' => $user->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Award Community Member</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              	Give {{ $user->name }} Community Member Award? <br> <br>

                <div class="form-group">
                  <label for="">Year</label>
                  <select name="year" id="" class="form-control" required="">

                    @php

                      $community_member_awards = \App\CommunityMemberAward::where('revoked', 0)->get();

                      $taken_years = [];

                      foreach ($community_member_awards as $community_member_award) {
                        $taken_years[] = $community_member_award->award_year;
                      }

                    @endphp

                    @if($first_user)
                      @for($i = $start_year; $i <= $end_year ; $i++ )
                        
                  
                          @if(!in_array($i, $taken_years))
                            <option value="{{ $i }}">{{ $i }}</option>
                          @endif

                        
                      @endfor
                    @endif

                  </select>
                </div>
            </div>   
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Award Community Member Award</button>
        </div>
      </form>
    </div>
  </div>
</div>