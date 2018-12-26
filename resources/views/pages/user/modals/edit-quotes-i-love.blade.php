<div class="modal fade" id="edit-quotes-i-love-{{ $quotes_i_love->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.quotes-i-love.update', ['id' => $quotes_i_love->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit 5 Quotes I Love</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="">5 Quotes I Love</label>
                <textarea name="content" id="" required="" class="form-control" rows="8" />{{ $quotes_i_love->content }}</textarea>
              </div>
            </div>   
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Quotes</button>
        </div>
      </form>
    </div>
  </div>
</div>