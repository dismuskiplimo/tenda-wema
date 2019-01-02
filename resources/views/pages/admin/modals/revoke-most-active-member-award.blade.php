<div class="modal fade text-left" id="revoke-most-active-member-award-{{ $last_most_active_member_award->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.user.award-most-active-member.revoke', ['id' => $last_most_active_member_award->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Revoke Most Active Member Award?</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              	Revoke <strong>Most Active Member Award {{ $last_most_active_member_award->award_year }}</strong> ? <br> <br>

                <div class="form-group">
                  <label for="Reason">Reason</label>
                  <textarea name="reason" id="" rows="5" class="form-control" required=""></textarea>
                </div>


            </div>   
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Revoke</button>
        </div>
      </form>
    </div>
  </div>
</div>