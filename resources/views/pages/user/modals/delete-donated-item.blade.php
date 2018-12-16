<div class="modal fade" id="delete-donated-item-{{ $item->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.donated-item.delete', ['slug' => $item->slug]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Delete {{ $item->name }} ?</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              	Remove <strong>{{ $item->name }}</strong> from Community Shop? <br> <br>  N/B You won't have access to it anymore. <br><br>

                <div class="form-group">
                  <label for="">Reason</label>
                  <textarea name="reason" id="" rows="5" class="form-control"></textarea>
                </div>
            </div>
            
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>