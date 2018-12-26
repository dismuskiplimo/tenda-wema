<div class="modal fade" id="edit-profile-pic">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('user.profile-picture.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Update Image</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              <div class="crop-it-container">
                  
                <div id="image-cropper">
                  
                  <div class="cropit-preview"></div>
                  
                  <div class="input-group">
                    <span class="input-group-addon" style="border: none;background-color: #fff"><i class="fa fa-file-image-o"></i></span>
                    <input type="range" class="cropit-image-zoom-input mt-10" />
                    <span class="input-group-addon" style="border: none;background-color: #fff"><i class="fa fa-file-image-o" style="font-size: 2em"></i></span>
                  </div>
                  
                  
                 
                  <input type="file" class="cropit-image-input hidden" name="image" accept="image/*" />

                  <button class="btn btn-info cropit-image-button" type="button"><i class="fa fa-file-image-o"></i> Select Image</button>
                  
                 
                </div>

              </div>
            </div>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>