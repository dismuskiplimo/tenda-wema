<div class="modal fade" id="confirm-item-received-{{ $item->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.donated-item.confirm-delivery', ['slug' => $item->slug]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Confirm that you have received item</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <h3 class="nobottommargin">Confirm that you have received {{ $item->name }}?</h3>
              <p></p>
            </div>   
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Confirm</button>
        </div>
      </form>
    </div>
  </div>
</div>