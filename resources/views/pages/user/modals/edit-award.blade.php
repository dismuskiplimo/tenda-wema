<div class="modal fade" id="edit-award-{{ $award->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.award.update', ['id' => $award->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Award</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                  <label for="name-{{ $award->id }}">Award</label>
                  <input type="text" name="name" id="name-{{ $award->id }}" value="{{ $award->name }}" class="form-crontrol" />
                </div> 
            </div>

            <div class="col-sm-6">
                <div class="form-group">
                  <label for="year-{{ $award->id }}">Year</label>
                  <input type="number" name="year" id="year-{{ $award->id }}" value="{{ $award->year }}" min="1900" max="{{ date('Y') }}" class="form-control">
                </div>
            </div>

          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>