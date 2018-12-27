<div class="modal fade" id="approve-cancel-order-{{ $cancel_request->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.order-cancellation.approve', ['id' => $cancel_request->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Cancel Item Purchase by {{ $cancel_request->user->name }} ?</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              	<h3>Cancel Item Purchase by {{ $cancel_request->user->name }}</h3><br>

                
            </div>   
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Yes, Cancel purchase</button>
        </div>
      </form>
    </div>
  </div>
</div>