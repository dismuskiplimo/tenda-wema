<div class="modal fade" id="edit-education-{{ $education->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.education.update', ['id' => $education->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Education</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="school">School*</label>
                <input type = "text" name="school" id="school" value="{{ $education->school }}" required="" class="form-control" />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="level">Level*</label>
                <input type = "text" name="level" id="level" value="{{ $education->level }}"  required=""  class="form-control" />
              </div> 
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="field_of_study">Field of Study*</label>
                <input type = "text" name="field_of_study" id="field_of_study" value="{{ $education->field_of_study }}"  required=""  class="form-control" />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="grade">Grade</label>
                <input type = "text" name="grade" value="{{ $education->grade }}"  id="grade"  class="form-control" />
              </div> 
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="start_year">Start Year*</label>
                <input  type = "number" name="start_year" id="start_year" value="{{ $education->start_year }}"  required="" min="1900" max="{{ date('Y') }}"  class="form-control" />
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label for="end_year">End Year*</label>
                <input type = "number" name="end_year" id="end_year" value="{{ $education->end_year }}"  required="" min="1900" max="{{ date('Y') }}"  class="form-control" />
              </div> 
            </div>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>