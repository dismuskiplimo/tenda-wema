<div class="modal fade" id="purchase-approve-{{ $donated_item->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.donated-item.approve', ['id' => $donated_item->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Approve Donated Item?</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              	Approve <strong>{{ $donated_item->name }} </strong> to the Community Shop ? <br> <br>

                <div class="form-group">
                  <label for="">Approximate Value in Simba Coins</label>
                  <input type="number" class="form-control" value="{{ $donated_item->price }}" required="" name="price" placeholder="value in simba coins">
                </div>
            </div>   
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Approve</button>
        </div>
      </form>
    </div>
  </div>
</div>