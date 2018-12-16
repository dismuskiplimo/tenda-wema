<div class="modal fade" id="purchase-coins-paypal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="{{ route('paypal.request', ['type' => 'purchase-coins']) }}" method="POST">
        @csrf
     
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Purchase Coins</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12">
            

              <p class="text-center">
                <img src="{{ custom_asset('images/payments/paypal.png') }}" alt="" title="Paypal" class="h-75">  
              </p>
            
              <div class="form-group">
                <label for="">Amount You Wish To Deposit (USD)</label>
                <input type="number" min="1" value="" name="amount" placeholder="amount in USD" class="form-control" required="">
              </div>

              <h5><b>N/B: 1 {{ $settings->paypal_currency->value }} = {{ $settings->coin_value->value }} Simba Coins </b></h5>
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