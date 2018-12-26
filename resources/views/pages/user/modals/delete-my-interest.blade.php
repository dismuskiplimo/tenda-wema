<div class="modal fade" id="delete-my-interests-{{ $my_interest->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.my-interests.delete', ['id' => $my_interest->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Delete My Interests ?</h4>
        </div>
        
        <div class="modal-body">
          <h3>Are you sure you want to delete My Interests? </h3>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Yes, Delete Interests</button>
        </div>
      </form>
    </div>
  </div>
</div>