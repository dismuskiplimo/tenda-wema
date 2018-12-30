<div class="modal fade" id="about-me">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.about-me.update') }}" method="POST" id = "about-me-form">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">About Me</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            
            <div class="col-sm-12">
              <div class="form-group">
                <label for="about-me-control">About Me (Must be at least 200 words long)</label>
                <textarea name="about_me" id="about-me-control" required=""  class="form-control" placeholder="about me" rows="8">{{ old('about_me') ? : $user->about_me }}</textarea>

                <p class="nobottomborder">Word Count (<span id="word-count"></span> Words)</p>
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