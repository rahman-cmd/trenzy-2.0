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
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="checkout-phone">{{ __('Phone Number') }}</label>
                                        <input class="form-control" name="bill_phone" type="text" id="checkout-phone"
                                            required value="{{ isset($user) ? $user->phone : '' }}">
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

                <div class="card">
                    <div class="card-body">

                        <h6 class="pb-2 widget-title2">{{ __('Shipping Options') }} :</h6>
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
                        <h6 class="pb-2 widget-title2">{{ __('Select your payment method & Conform your order :') }} :</h6>
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="payment-methods">
                                    @php
                                        $gateways = DB::table('payment_settings')->whereStatus(1)->get();
                                    @endphp
                                    @foreach ($gateways as $gateway)
                                        @if (PriceHelper::CheckDigitalPaymentGateway())
                                            @if ($gateway->unique_keyword != 'cod')
                                                <div class="single-payment-method">
                                                    <a class="text-decoration-none " href="#" data-bs-toggle="modal"
                                                        data-bs-target="#{{ $gateway->unique_keyword }}"
                                                        data-payment-name="{{ $gateway->name }}">

                                                        <img class=""
                                                            src="{{ asset('assets/images/' . $gateway->photo) }}"
                                                            alt="{{ $gateway->name }}" title="{{ $gateway->name }}">
                                                        <p>{{ $gateway->name }}</p>
                                                    </a>
                                                </div>
                                            @endif
                                        @else
                                            <div class="single-payment-method">
                                                <a class="text-decoration-none" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#{{ $gateway->unique_keyword }}"
                                                    data-payment-name="{{ $gateway->name }}">

                                                    <img class=""
                                                        src="{{ asset('assets/images/' . $gateway->photo) }}"
                                                        alt="{{ $gateway->name }}" title="{{ $gateway->name }}">
                                                    <p>{{ $gateway->name }}</p>
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


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

                $.ajax({
                    url: "{{ route('front.checkout.store') }}",
                    method: "POST",
                    data: formData,
                    success: function(response) {

                        console.log(response);
                        if (response.success) {
                            console.log('Data saved successfully');

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

        $(document).ready(function() {
            // Handle payment method selection
            $('.single-payment-method a').on('click', function(e) {
                e.preventDefault(); // Prevent the default anchor behavior

                // Get the selected payment method
                var paymentName = $(this).data('payment-name');


                // Prepare the data to be sent to the server
                var data = {
                    payment_method: paymentName,
                    state_id: '{{ auth()->check() && auth()->user()->state_id ? auth()->user()->state_id : '' }}',
                    shipping_id: '' // You can pass the actual shipping ID if available
                };

                console.log('Data:', data);

                // Send the data to the server using AJAX
                // $.ajax({
                //     url: "{{ route('front.checkout.submit') }}",
                //     method: 'POST',
                //     data: data,
                //     success: function(response) {
                //         if (response.success) {
                //             console.log('Payment method selected:', paymentName);

                //             // Redirect to the payment gateway
                //             window.location.href = response.redirect;
                //         } else {
                //             alert('Error: ' + response.message);
                //         }
                //     },
                //     error: function(xhr, status, error) {
                //         alert('An error occurred while processing the payment.');
                //         console.log('AJAX Error: ' + error);
                //     }
                // });
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
