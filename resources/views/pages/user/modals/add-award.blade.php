<div class="modal fade" id="add-award">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.award.add') }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add Award</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="award-1">Award</label>
                <input type = "text" name="name" id="award-1" required="" class="form-control" />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="year-1">Year</label>
                <input type = "number" name="year" id="year-1" required="" min="1900" max="{{ date('Y') }}" class="form-control" />
              </div> 
            </div>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Award</button>
        </div>
      </form>
    </div>
  </div>
</div>