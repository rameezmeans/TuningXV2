@extends('layouts.app')

@section('pagespecificstyles')

<style>

.card-header {
  background: #1E293B;
  color: white;
}

.card {
  padding: 0px !important;
}

.card-header {
  padding: 20px;
  border-top-left-radius: 10px;
  border-top-right-radius: 10px;
}

.card-content {
  padding: 20px;
}

.btn-cart {
  width: 100%;
  background: transparent;
  border: 1px #ddd solid;
}

.btn-cart:hover {
  background: #B01321;
  color: white;
}

.swal-footer {
  text-align: center !important;
}   

.swal2-html-container {
  text-align: center !important;
  align-content: center !important;
}

.swal2-confirm {
  
  background-color: #dc3741 !important;
  
}

.swal2-deny {
  
  background-color: grey !important;
  
}

.swal2-html-container {
  text-align: left;
}

.swal-button--catch{
  display: inline-block;
  background-color: rgb(240, 36, 41) !important;
}

.row-form {
  display: flex !important;
}

.swal2-input {
  margin-left: 15px !important;
  margin-right: 15px !important;
  width: 92% !important;
}

.swal2-html-container {
  overflow: inherit !important;
}

</style>

@endsection

@section('content')
<div id="viewport">
    @include('layouts.sidebar')
    <!-- Content -->
    <div id="content">
      @include('layouts.header')
      <div class="container-fluid">
        <div class="bb-light fix-header">
                <div class="header-block header-block-w-p">
                    <h1>Credits Shop</h1>
                    <p>Shop credits and packages.</p>
                </div>
        </div>

       <div class="i-content-block price-level  shop-cards">
        <div class="row post-row">
          <div class="col-xl-3 col-lg-3 col-md-3 heading-column">
              <div class="heading-column-box">
                <h3>Single Credit</h3>
                <p>Buy and single credit.</p>
            </div>
          </div>

          <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="row">

              <div class="col-xl-6 col-lg-6 col-md-6">
              
                <div class="card" >
                <div class="card-header">
                  <strong>Single Credit</strong>
                </div>
                <div class="card-content">
  
                  <h3>1 Credit</h3>
                  <strong>{{$price}}Є</strong>
                
                  <p class="m-t-20">Using this service only once.</p>
                  <button class="btn btn-cart" id="addToCart"><i class="fa fa-shopping-cart"></i> Add To Cart</button>
  
  
                </div>

              </div>

              </div>

            </div>
          </div>
        </div>

        <div class="row post-row">
          <div class="col-xl-3 col-lg-3 col-md-3 heading-column">
              <div class="heading-column-box">
              <h3>Packages</h3>
              <p>Buy package of credits.</p>
          </div>
          </div>

          <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="row">
              @foreach($packages as $package)
                <div class="col-xl-6 col-lg-6 col-md-6">
                  <div class="card" >
                    <div class="card-header">
                      <strong>{{$package->name}}</strong>
                    </div>
                    <div class="card-content">
                      <h3>{{$package->credits}} Credits</h3>
                      <span style="text-decoration: line-through;">{{$package->actual_price}}</span> <strong class="text-red">{{$package->discounted_price}}Є</strong>
                      <p class="m-t-20">{{$package->desc}}</p>
                      <form method="POST" action="{{route('buy.package')}}">
                        @csrf
                        <input type="hidden" name="package" value="{{$package->id}}">
                        <input type="hidden" name="price" value="{{$package->discounted_price}}">
                        <input type="hidden" name="credits" value="{{$package->credits}}">
                        <button type="submit" class="btn btn-cart"><i class="fa fa-shopping-cart"></i> Buy</button>
                      </form>
                    </div>
                  </div>
                </div>
              @endforeach

            </div>
          </div>
        </div>
        </div>
       
      </div>
    </div>
  </div>
@endsection

@section('pagespecificscripts')

<script type="text/javascript">

    $( document ).ready(function(event) {

      $(document).on('click','#addToCart', function(e){
        
        $.ajax({
             url: "/add_to_cart",
             type: "POST",
             headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
             data: {
                 cart: 1
             },
             success: function(response) {
                 console.log(response);
                 Swal.fire({
                 icon: 'success',
                 title: '1 Tuning credit (reseller)',
                 text: '{{__('Successfully added to Cart')}}',
                 showDenyButton: true,
                 denyButtonText: '{{__('Continue Shopping')}}',
                 confirmButtonText: '{{__('Go to Cart')}}',
                 }).then((result) => {
                 /* Read more about isConfirmed, isDenied below */
                 if (result.isConfirmed) {
                     get_update_show_cart();
                 } else if (result.isDenied) {
                     location.reload();
                 }
             });
             }
         }); 
     });

     function get_update_show_cart(){

$.ajax({
    url: "/cart_quantity",
    type: "POST",
    headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
    data: {},
    success: function(qty) {

      document.location = '/cart';

    //     $('#qty-input').val(qty);
    //     let price = $('#price_per_unit').val();
    //     let factor = $('#factor').val();
    //     let tax = $('#tax').val();
    
    // $('#subTotal').text(roundToTwo(qty*price));
    // $('#vatSubTotal').text(roundToTwo(qty*factor));

    // let adjustedPrice = (qty*price) + (qty*factor);
    // let taxAmount = ( tax * adjustedPrice ) / 100;

    // let adjusted_unit_price = roundToTwo(price) + roundToTwo(factor);
    // let unit_price_tax = ( roundToTwo(tax) * roundToTwo(adjusted_unit_price) ) / 100;

    // let final_unit_price = roundToTwo(adjusted_unit_price + unit_price_tax);

    // console.log(adjustedPrice);

    // console.log(adjusted_unit_price);

    // $('#taxValue').text(roundToTwo(taxAmount));
    // $('#total').text(roundToTwo(adjustedPrice + taxAmount));

    // $('.total_for_checkout').val(roundToTwo(adjustedPrice + taxAmount));
    // $('.credits_for_checkout').val(qty);
    // $('.unit_price_for_checkout').val(final_unit_price);

    // $('#modalcheckout').css("display", "block");

    }
});
}

    });

</script>

@endsection