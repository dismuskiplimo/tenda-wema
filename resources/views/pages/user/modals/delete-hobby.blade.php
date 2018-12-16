<div class="modal fade" id="delete-hobby-{{ $hobby->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.hobby.delete', ['id' => $hobby->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Delete {{ $hobby->name }} ? </h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              	Delete {{ $hobby->name }} ? 
            </div>
           
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>