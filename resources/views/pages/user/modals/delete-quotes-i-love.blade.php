<div class="modal fade" id="delete-quotes-i-love-{{ $quotes_i_love->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.quotes-i-love.delete', ['id' => $quotes_i_love->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Delete 5 Quotes I Love?</h4>
        </div>
        
        <div class="modal-body">
          <h3>Delete 5 Quotes I Love?</h3>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Yes, Delete Quotes</button>
        </div>
      </form>
    </div>
  </div>
</div>