<div class="modal fade" id="delete-books-you-should-read-{{ $books_you_should_read->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.books-you-should-read.delete', ['id' => $books_you_should_read->id]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Delete 3 Books You Should Read?</h4>
        </div>
        
        <div class="modal-body">
          <h4>Delete 3 Books You Should Read?</h4>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Yes, Delete Books</button>
        </div>
      </form>
    </div>
  </div>
</div>