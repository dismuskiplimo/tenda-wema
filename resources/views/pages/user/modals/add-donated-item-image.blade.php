<div class="modal fade" id="add-donated-item-image">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.donated-item.image.add', ['slug' => $item->slug]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Add Images</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12 buttons">
              <label for="">Image (Only images accepted | maximum size allowed per image : 4MB)</label>           
              
              <div class="button-wrapper file-button"></div>

              <button class="btn add-file-button btn-sm btn-success" type="button">
                <i class="fa fa-plus"></i> Add Image
              </button>

            </div>  
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>