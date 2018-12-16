<div class="modal fade" id="edit-skill-{{ $skill->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.skill.update', ['id' => $skill->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Skill</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                  <label for="skill-1">Skill</label>
                  <input type = "text" name="skill" id="skill-1" required="" value="{{ $skill->skill }}" class="form-control" />
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