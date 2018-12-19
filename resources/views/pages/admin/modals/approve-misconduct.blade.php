<div class="modal fade" id="approve-misconduct-{{ $report->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('admin.users.reported.approve', ['id' => $report->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Confirm Misconduct?</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
              	<h3>Confirm Misconduct by {{ $report->user->name }}?</h3>
                <p>{{ $report->description }}</p>
            </div>   
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Confirm Misconduct</button>
        </div>
      </form>
    </div>
  </div>
</div>