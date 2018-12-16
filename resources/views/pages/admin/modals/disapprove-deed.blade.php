<div class="modal fade" id="deed-disapprove-{{ $deed->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.deed.disapprove', ['id' => $deed->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Disapprove Deed?</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              	Disapprove <strong>{{ $deed->name }}</strong> ? <br> <br>

                <div class="form-group">
                  <label for="Reason">Reason</label>
                  <textarea name="reason" id="" rows="5" class="form-control" required=""></textarea>
                </div>


            </div>   
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Disapprove</button>
        </div>
      </form>
    </div>
  </div>
</div>