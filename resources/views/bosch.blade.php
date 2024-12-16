@extends('layouts.app')
@section('content')
<div id="viewport">
    @include('layouts.sidebar')
    <!-- Content -->
    <div id="content">
      @include('layouts.header')
      <div class="container-fluid">
        <div class="bb-light fix-header">
            <div class="header-block header-block-w-p">
                <h1>Bosch ECU Number</h1>
                <p>Please search Bosch numbers for ECUs.</p>
            </div>
        </div>

          <div class="i-content-block price-level">
            
            <form action="{{route('get-bosch-ecu')}}" method="POST" class="text-center">
              @csrf
              <input type="text" name="manufacturer_number" value="" class="form-control text-center" placeholder="Enter Bosch manufacturer number">
              <div>
                <button class="btn btn-red btn-red-full text-center m-t-10" type="submit">GET ECU</button>
              </div>
            </form>
  
          @if(isset($record))
  
            <div class="row m-t-20">
              <div class="col-md-12 text-center">
  
                <div class="card">
  
                  @if(is_object($record))
  
                  <div class="card-header">
                    <div style="display: inline-flex;">
                      <h4>
                        ECU: {{$record->ecu}}
                      </h4>
                    </div>
                  </div>
                  <div class="card-content">
                    Manufacturer Number: {{$record->manufacturer_number}}
                  </div>
  
                  @elseif(is_string($record))
  
                    <div class="card-header">
                      <div style="display: inline-flex;">
                        <h4>No Record Found!</h4>
                      </div>
                    </div>
  
                  @endif
  
                </div>
  
              </div>
            </div>
  
          @endif

          </div>

          </div>
      </div>

    </div>
  </div>
@endsection

@section('pagespecificscripts')

<script type="text/javascript">

    $( document ).ready(function(event) {

    });

</script>

@endsection