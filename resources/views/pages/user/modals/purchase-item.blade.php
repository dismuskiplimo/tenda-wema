<div class="modal fade" id="purchase-item-{{ $item->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.donated-item.purchase', ['slug' => $item->slug]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Purchase Donated Item?</h4>
        </div>
        
        <div class="modal-body">
          <h3 class="nobottommargin text-center">Purchase {{ $item->name }} for {{ $item->price }} Simba Coins?</h3>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Purchase</button>
        </div>
      </form>
    </div>
  </div>
</div>