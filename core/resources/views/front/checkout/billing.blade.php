@extends('master.front')

@section('title')
    {{ __('Billing') }}
@endsection

@section('content')
    <!-- Page Title-->
    <div class="page-title">
        <div class="container">
            <div class="column">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('front.index') }}">{{ __('Home') }}</a> </li>
                    <li class="separator"></li>
                    <li>{{ __('Billing Address & Shipping Address') }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Page Content-->
    <div class="container padding-bottom-3x mb-1 checkut-page">

        <div class="row">
            <!-- Billing Adress-->

            <div class="col-xl-9 col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h6>{{ __('Billing Address & Shipping Address') }}</h6>

                        <form id="checkoutBilling" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="checkout-fn">{{ __('Name') }}</label>
                                        <input class="form-control" name="bill_first_name" type="text" required
                                            id="checkout-fn" value="{{ isset($user) ? $user->first_name : '' }}">
                                        <div class="text-danger" id="name-error"></div>
                                        @error('bill_first_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="checkout-phone">{{ __('Phone Number') }}</label>
                                        <input class="form-control" name="bill_phone" type="text" id="checkout-phone"
                                            required value="{{ isset($user) ? $user->phone : '' }}">
                                        <div class="text-danger" id="phone-error"></div>
                                        @error('bill_phone')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror

                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="checkout_email_billing">{{ __('E-mail Address (Optional)') }}</label>
                                        <input class="form-control" name="bill_email" type="email"
                                            id="checkout_email_billing" value="{{ isset($user) ? $user->email : '' }}">
                                    </div>
                                </div>
                                @if (PriceHelper::CheckDigital())
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="checkout-address1">{{ __('Address') }}</label>
                                            <input class="form-control" name="bill_address1" required type="text"
                                                id="checkout-address1"
                                                value="{{ isset($user) ? $user->bill_address1 : '' }}">
                                            <div class="text-danger" id="address-error"></div>
                                            @error('bill_address1')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror

                                        </div>
                                    </div>
                                @endif

                            </div>


                            <div class="form-group d-none">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" id="same_address"
                                        name="same_ship_address" checked>
                                    <label class="custom-control-label" for="same_address">
                                        {{ __('Same as billing address') }}
                                    </label>
                                </div>
                            </div>



                        </form>
                    </div>
                </div>

                <!-- Payment section -->

                <form action="{{ route('front.checkout.submit') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-body">

                            <h6 class="pb-2 widget-title2">{{ __('Shipping') }} :</h6>
                            <div class="row">
                                <div class="col-sm-6  mb-4">
                                    @if (PriceHelper::CheckDigital() == true)
                                        @php
                                            $free_shipping = DB::table('shipping_services')
                                                ->whereStatus(1)
                                                ->whereIsCondition(1)
                                                ->first();
                                        @endphp

                                        <select name="shipping_id" class="form-control" id="shipping_id_select" required>
                                            <option value="" selected disabled>
                                                {{ __('Select Shipping Method') }}
                                            </option>
                                            @foreach (DB::table('shipping_services')->whereStatus(1)->get() as $shipping)
                                                @if ($shipping->id == 1 && isset($free_shipping) && $free_shipping->minimum_price <= $cart_total)
                                                    <option value="{{ $shipping->id }}"
                                                        data-href="{{ route('front.shipping.setup') }}">
                                                        {{ $shipping->title }}
                                                    </option>
                                                @else
                                                    @if ($shipping->id != 1)
                                                        <option value="{{ $shipping->id }}"
                                                            data-href="{{ route('front.shipping.setup') }}">
                                                            {{ $shipping->title }}
                                                            ({{ PriceHelper::setCurrencyPrice($shipping->price) }})
                                                        </option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>

                                        {{-- shipping radio button --}}


                                        <small
                                            class="text-primary shipping_message">{{ __('Please select shipping method') }}</small>
                                        @error('shipping_id')
                                            <p class="text-danger shipping_message">{{ $message }}</p>
                                        @enderror
                                    @endif
                                </div>


                                <div class="col-sm-6  mb-4">
                                    @if (PriceHelper::CheckDigital() == true)


                                        @if (DB::table('states')->whereStatus(1)->count() > 0)
                                            <select name="state_id" class="form-control" id="state_id_select" required>
                                                <option value="" selected disabled>
                                                    {{ __('Select Shipping State') }}
                                                </option>
                                                @foreach (DB::table('states')->whereStatus(1)->get() as $state)
                                                    <option value="{{ $state->id }}"
                                                        data-href="{{ route('front.state.setup') }}"
                                                        {{ Auth::check() && Auth::user()->state_id == $state->id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                        @if ($state->type == 'fixed')
                                                            ({{ PriceHelper::setCurrencyPrice($state->price) }})
                                                        @else
                                                            ({{ $state->price }}%)
                                                        @endif

                                                    </option>
                                                @endforeach
                                            </select>
                                            <small
                                                class="text-primary state_message">{{ __('Please select shipping state') }}</small>
                                            @error('state_id')
                                                <p class="text-danger state_message">{{ $message }}</p>
                                            @enderror
                                        @endif
                                    @endif
                                </div>
                            </div>


                            <!-- Payment Methods -->
                            <h6 class="pb-2 widget-title2">{{ __('Select Payment Method & Confirm Order') }}:</h6>
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="payment-methods row g-3">
                                        @php $gateways = DB::table('payment_settings')->whereStatus(1)->get(); @endphp
                                        @foreach ($gateways as $gateway)
                                            @if (!PriceHelper::CheckDigitalPaymentGateway() || $gateway->unique_keyword != 'cod')
                                                <div class="col-lg-3 col-md-4 col-6 mb-3">
                                                    <div class="payment-card border rounded p-2 text-center">
                                                        <div class="form-check ">
                                                            <!-- Generate unique ID for each radio button -->
                                                            @php $radioId = 'payment_' . $gateway->unique_keyword; @endphp

                                                            <input class="form-check-input" type="radio"
                                                                name="payment_method"
                                                                value="{{ $gateway->unique_keyword }}"
                                                                id="{{ $radioId }}" required
                                                                @checked(old('payment_method') == $gateway->unique_keyword)>

                                                            <label class="form-check-label d-block cursor-pointer m-0"
                                                                for="{{ $radioId }}">
                                                                {{ $gateway->name }}
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>



                                                <input type="hidden" name="payment_method" value="Cash On Delivery">
                                                <input type="hidden" name="shipping_id" value=""
                                                    class="shipping_id_setup">
                                                <input type="hidden" name="state_id"
                                                    value="{{ auth()->check() && auth()->user()->state_id ? auth()->user()->state_id : '' }}"
                                                    class="state_id_setup">
                                            @endif
                                        @endforeach
                                    </div>
                                    @error('payment_method')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>



                            {{-- terms and conditions --}}
                            @if ($setting->is_privacy_trams == 1)
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input class="custom-control-input" type="checkbox" id="trams__condition">
                                        <label class="custom-control-label" for="trams__condition">This is <a
                                                href="{{ $setting->policy_link }}" target="_blank">Privacy Policy</a> and
                                            <a href="{{ $setting->terms_link }}" target="_blank">Terms of Service</a>
                                            apply.</label>
                                    </div>
                                </div>
                            @endif



                            @if ($setting->is_privacy_trams == 1)
                                <button disabled id="continue__button" class="btn btn-primary  btn-block"
                                    type="submit"><span class="hidden-xs-down">{{ __('Order Now') }}</span><i
                                        class="icon-arrow-right"></i></button>
                            @else
                                <button class="btn btn-primary btn-block" type="submit"><span
                                        class="hidden-xs-down">{{ __('Order Now') }}</span><i
                                        class="icon-arrow-right"></i></button>
                            @endif



                        </div>
                    </div>

                </form>

            </div>




            @include('includes.checkout_sitebar', $cart)


        </div>

        @include('includes.checkout_modal')




    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#checkoutBilling input, #checkoutBilling select').on('input change', function() {
                var formData = $('#checkoutBilling').serialize();
                // Send the form data to the server using AJAX
                $.ajax({
                    url: "{{ route('front.checkout.store') }}",
                    method: "POST",
                    data: formData,
                    success: function(response) {


                        if (response.success) {
                            console.log('Data saved:', response.data);


                            if (response.redirect) {
                                window.location.href = response.redirect;
                            }
                        } else {
                            console.log('Error:', response.message);

                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', error);

                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethods = document.querySelectorAll('.single-payment-method a');

            paymentMethods.forEach(function(method) {
                method.addEventListener('click', function() {
                    // Remove active class from all payment methods
                    paymentMethods.forEach(function(item) {
                        item.classList.remove('border', 'border-primary', 'active');
                    });

                    // Add active class to the selected payment method
                    this.classList.add('border', 'border-primary', 'active');
                });
            });
        });
    </script>
@endsection
