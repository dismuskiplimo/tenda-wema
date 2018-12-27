<div class="modal fade" id="dismiss-cancel-order-{{ $cancel_request->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.order-cancellation.dismiss', ['id' => $cancel_request->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Dismiss Order purchase cancellation from {{ $cancel_request->user->name }} ?</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              	<h3>Dismiss Order purchase cancellation from {{ $cancel_request->user->name }}</h3><br>

                <div class="form-group">
                  <label class="">Reason for dismissing</label>
                  <textarea name="reason" id="" rows="10" class="form-control" required=""></textarea>
                </div>
            </div>   
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Yes, Dismiss</button>
        </div>
      </form>
    </div>
  </div>
</div>