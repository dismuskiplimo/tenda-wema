<div class="modal fade" id="purchase-disapprove-{{ $donated_item->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.donated-item.disapprove', ['id' => $donated_item->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Reject Donated Item?</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              	Reject Donated Item <strong>{{ $donated_item->name }} </strong> ? <br><br>

                <div class="form-group">
                  <label for="">Reason</label>
                  <textarea name="reason" id="" rows="5" required="" class="form-control"></textarea>
                </div>
            </div>   
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Reject</button>
        </div>
      </form>
    </div>
  </div>
</div>