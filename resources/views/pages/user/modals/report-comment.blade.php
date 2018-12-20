<div class="modal fade text-left" id="report-comment-{{ $comment->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.report') }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Report Comment</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              
              <div class="form-group">
                <label for="hobby-1">Reason</label>
                <select name="report_type" id="" class="form-control" required="">
                  <option value="language.inappropriate">Inappropriate Language used</option>
                  <option value="community.disrupt">Disrupts the community</option>
                  <option value="rules.non-adhere">Non Adherence to {{ config('app.name') }} Community Policies</option>
                </select>

                <input type="hidden" name="model_id" value="{{ $comment->id }}" />
                <input type="hidden" name="user_id" value="{{ $comment->user->id }}" />
                <input type="hidden" name="section" value="comment" />
              </div>
              
              <div class="form-group">
                <label for="">Please Explain in detail</label>

                <textarea name="description" id="" rows="10" class="form-control" required=""></textarea>
              </div>

            </div>


            
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Report Comment</button>
        </div>
      </form>
    </div>
  </div>
</div>