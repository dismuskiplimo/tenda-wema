<div class="modal fade" id="add-world-i-desire">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.world-i-desire.add') }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">The World I Desire to See</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="">The World I Desire to See'</label>
                <textarea name="content" id="" required="" class="form-control" rows="8" /></textarea>
              </div>
            </div>   
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Add Message</button>
        </div>
      </form>
    </div>
  </div>
</div>