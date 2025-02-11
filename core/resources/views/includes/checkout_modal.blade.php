     <!-- Modal Cash on Transfer-->
     <div class="modal fade" id="cod" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <h6 class="modal-title">{{ __('Transaction Cash On Delivery') }}</h6>
                     <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span
                             aria-hidden="true">&times;</span></button>
                 </div>
                 <form action="{{ route('front.checkout.submit') }}" method="POST">
                     @csrf
                     <input type="hidden" name="payment_method" value="Cash On Delivery" id="">
                     <input type="hidden" name="state_id"
                         value="{{ auth()->check() && auth()->user()->state_id ? auth()->user()->state_id : '' }}"
                         class="state_id_setup">
                     <input type="hidden" name="shipping_id" value="" class="shipping_id_setup">
                     <div class="card-body">
                         <p>{{ PriceHelper::GatewayText('cod') }}</p>
                     </div>
                     <div class="modal-footer">
                         <button class="btn btn-primary btn-sm" type="button"
                             data-bs-dismiss="modal"><span>{{ __('Cancel') }}</span></button>
                         <button class="btn btn-primary btn-sm"
                             type="submit"><span>{{ __('Cash On Delivery') }}</span></button>
                 </form>
             </div>
         </div>
     </div>
     </div>




     {{-- SSL COMMERZ --}}
     <div class="modal fade" id="sslcommerz" tabindex="-1" aria-hidden="true">
         <form class="interactive-credit-card row" action="{{ route('front.sslcommerz.submit') }}" method="POST">
             @csrf
             <div class="modal-dialog">
                 <div class="modal-content">
                     <div class="modal-header">
                         <h6 class="modal-title">{{ __('Transactions via SSLCommerz') }}</h6>
                         <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span
                                 aria-hidden="true">&times;</span></button>
                     </div>
                     <div class="modal-body">
                         <div class="card-body">
                             <p>{{ PriceHelper::GatewayText('sslcommerz') }}</p>
                         </div>
                     </div>
                     <input type="hidden" name="payment_method" value="SSLCommerz">
                     <input type="hidden" name="shipping_id" value="" class="shipping_id_setup">
                     <input type="hidden" name="state_id"
                         value="{{ auth()->check() && auth()->user()->state_id ? auth()->user()->state_id : '' }}"
                         class="state_id_setup">
                     <div class="modal-footer">
                         <button class="btn btn-primary btn-sm" type="button"
                             data-bs-dismiss="modal"><span>{{ __('Cancel') }}</span></button>
                         <button class="btn btn-primary btn-sm"
                             type="submit"><span>{{ __('Checkout With SSLCommerz') }}</span></button>
                     </div>
                 </div>

             </div>
         </form>
     </div>
     </div>




     <!-- Modal bank -->
     <div class="modal fade" id="bank" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <h6 class="modal-title">{{ __('Transactions via Bank Transfer') }}</h6>
                     <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close"><span
                             aria-hidden="true">&times;</span></button>
                 </div>
                 <form action="{{ route('front.checkout.submit') }}" method="POST">
                     <div class="modal-body">
                         <div class="col-lg-12 form-group">
                             <label for="transaction">{{ __('Transaction Number') }}</label>
                             <input class="form-control" name="txn_id" id="transaction"
                                 placeholder="{{ __('Enter Your Transaction Number') }}" required />
                         </div>
                         <p>{!! PriceHelper::GatewayText('bank') !!}</p>
                     </div>
                     <div class="modal-footer">

                         @csrf
                         <input type="hidden" name="payment_method" value="Bank">
                         <input type="hidden" name="shipping_id" value="" class="shipping_id_setup">
                         <input type="hidden" name="state_id"
                             value="{{ auth()->check() && auth()->user()->state_id ? auth()->user()->state_id : '' }}"
                             class="state_id_setup">
                         <button class="btn btn-primary btn-sm" type="button"
                             data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                         <button class="btn btn-primary btn-sm"
                             type="submit"><span>{{ __('Checkout With Bank Transfer') }}</span></button>
                 </form>
             </div>
         </div>
     </div>
     </div>
