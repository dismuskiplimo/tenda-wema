<div class="modal fade" id="purchase-coins-mpesa">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('mpesa.request', ['type' => 'purchase-coins']) }}" method="POST">
        @csrf
     
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Purchase Coins</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
            

              <p class="text-center">
                <img src="{{ custom_asset('images/payments/mpesa.png') }}" alt="" title="Paypal" class="h-75">  
              </p>
            
              <div class="form-group">
                <label for="">Phone Number (Starting with 254 e,g 254720XXXXXX)</label>
                <input type="number" min="10" value="" name="phone" placeholder="phone number starting with 254" class="form-control" required="">
              </div>

              <div class="form-group">
                <label for="">Simba Coins You Wish to Purchase</label>
                <input type="number" min="1" value="" name="amount" placeholder="simba coins you wish to purchase" class="form-control mpesa-input" required="">
              </div>

              <h5><b>N/B: {{ $settings->system_currency->value }} {{ $settings->coin_value->value }} = 1 Simba Coin</b></h5>

              <hr>

              <p class="nobottomborder"><strong> <span class="mpesa-coins">0</span> Simba Coins =  <span class="mpesa-amount">0</span> {{ $settings->system_currency->value }} </strong></p>
            </div>

          </div>
          
        
          
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Purchase Coins</button>
        </div>
      </form>
    </div>
  </div>
</div>