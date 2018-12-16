<div class="modal fade" id="edit-donated-item-{{ $item->id }}">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('user.donated-item.update', ['slug' => $item->slug]) }}" method="POST">
        @csrf
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Edit Domated Item</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="item-name">Item Name</label>
                <input type="text" id="item-name" name="name" required="" class="form-control required" placeholder="item name" value="{{ $item->name }}" />
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="type">Type</label>
                <select name="type" id="type" class="form-control required" required="">
                  <option value="">--Select Item Type --</option>
                  <option value="PRODUCT"{{ $item->type == 'PRODUCT' ? ' selected' : '' }}>Product</option>
                  <option value="SERVICE"{{ $item->type == 'SERVICE' ? ' selected' : '' }}>Service</option>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-6">
              <div class="form-group">
                <label for="condition">Condition</label>
                <select name="condition" id="condition" class="form-control required" required="">
                  <option value="">--Select Item Condition --</option>
                  <option value="NEW"{{ $item->condition == 'NEW' ? ' selected' : '' }}>New</option>
                  <option value="USED"{{ $item->condition == 'USED' ? ' selected' : '' }}>Used</option>
                </select>
              </div>
            </div>

            <div class="col-sm-6">
              <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" id="category_id" class="form-control required" required="">
                  <option value=""> -- Select Item Category --</option>
                  @if(count($categories))
                    @foreach($categories as $category)
                      <option value="{{ $category->id }}"{{ $item->category_id == $category->id ? ' selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                  @endif
                                    
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-12">
              <div class="form-group">
                <label for="item-description">Description</label>
                <textarea id="item-description" name="description" required="" class="form-control required" placeholder="item description" rows="6">{{ $item->description }}</textarea>
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