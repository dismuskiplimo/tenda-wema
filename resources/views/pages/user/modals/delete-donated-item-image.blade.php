<div class="modal fade" id="delete-donated-item-image">
  <div class="modal-dialog">
    <div class="modal-content">
      
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Delete Images</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            
          	@if(count($item->images))

              @php
                $count = 0;
              @endphp

              @foreach($item->images()->orderBy('created_at', 'DESC')->get() as $image)
                @php
                  $count++;
                @endphp

                <div class="col-sm-4">
                  <form action="{{ route('user.donated-item.image.delete', ['slug' => $item->slug, 'id' =>$image->id ]) }}" method="POST" class="confirm">
                      <a data-fancybox="gallery" href="{{ $image->image() }}">
                        <img src="{{ $image->slide() }}" alt="" class="img-responsive img-rounded">
                      </a>
                      

                      <span class="delete-user-photo" title="Delete Photo">
                        <button type="submit" class="btn btn-xs btn-danger" title="Delete Image"><i class="fa fa-trash"></i></button>
                      </span>
                    @csrf
                  </form>
                </div>

                @if($count % 3 == 0)
                  </div>
                  <div class="row mb-20">
                @endif

              @endforeach
            @endif
                         
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        </div>
      
    </div>
  </div>
</div>