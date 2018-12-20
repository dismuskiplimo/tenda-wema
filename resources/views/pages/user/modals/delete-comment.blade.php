<div class="modal fade text-left" id="delete-comment-{{ $comment->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('comment.delete', ['slug' => $post->slug, 'id' => $comment->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Delete Comment ?</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              	Delete Comment ?
            </div>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete Comment</button>
        </div>
      </form>
    </div>
  </div>
</div>