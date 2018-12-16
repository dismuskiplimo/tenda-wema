<div class="modal fade" id="purchase-coins">
  <div class="modal-dialog">
    <div class="modal-content">
      
        
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Purchase Coins</h4>
        </div>
        
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-12 text-center">
              <h4>Please Choose Your Preferred Payment Method</h4>
            </div>

            <div class="col-sm-6 text-center">
              
                <a href="" data-toggle="modal" data-target="#purchase-coins-mpesa" class="purchase-coins">
                  <img src="{{ custom_asset('images/payments/mpesa.png') }}" alt="" title="Mpesa" class="h-100">
                </a>  
              
            </div>

            <div class="col-sm-6  text-center">
              
                <a href="" data-toggle="modal" data-target="#purchase-coins-paypal" class="purchase-coins">
                  <img src="{{ custom_asset('images/payments/paypal.png') }}" alt="" title="Paypal" class="h-100">
                </a>  
              
            </div>

          </div>
          
        
          
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
        </div>
      
    </div>
  </div>
</div>

@include('pages.user.modals.buy-coins-mpesa')
@include('pages.user.modals.buy-coins-paypal')