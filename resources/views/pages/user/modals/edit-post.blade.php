<div class="modal fade text-left" id="edit-post-{{ $post->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('post.update', ['slug' => $post->slug]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Post</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              
              <div class="form-group">
                <label for="">Post Title</label>  
                <input type="text" class="form-control" name="title" required="" value="{{ $post->title }}" placeholder="post title">
              </div>
              
              <div class="form-group">
                <label for="">Content</label>

                <textarea name="content" id="" rows="10" class="form-control" required="" placeholder="post content">{{ $post->content }}</textarea>
              </div>

            </div>


            
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update Post</button>
        </div>
      </form>
    </div>
  </div>
</div>