<div class="modal fade" id="receive-donation-request-{{ $donation->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.support-cause.confirm', ['id' => $donation->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Received Donation from {{ $donation->fname . ' ' . $donation->lname }} ?</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              	<h3>Received Donation from {{ $donation->fname . ' ' . $donation->lname }} ?</h3>
            </div>   
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Yes, Donation received</button>
        </div>
      </form>
    </div>
  </div>
</div>