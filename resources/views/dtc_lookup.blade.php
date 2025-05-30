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
                    <h1>DTC Lookup Records</h1>
                    <p>Search DTC Lookup records by Code</p>
                </div>
            </div>
        
        <div class="i-content-block price-level">
          <form action="{{route('get-dtc-desc')}}" method="POST" class="text-center">
            @csrf
            <input type="text" name="dtc_lookup_code" value="" class="form-control text-center" placeholder="Enter DTC Code">
            <div>
              <button class="btn btn-red btn-red-full text-center m-t-10" type="submit">GET DESCRIPTION</button>
            </div>
          </form>

        @if(isset($record))

          <div class="row m-t-20">
            <div class="col-md-12 text-center">

              <div class="card">

                @if(is_object($record))

                  <div class="card-header">
                    <div style="display: inline-flex;">
                      <h4>{{$record->desc}}</h4>
                    </div>
                  </div>
                  <div class="card-content">
                    Code: {{$record->code}}
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
@endsection

@section('pagespecificscripts')

<script type="text/javascript">

    $( document ).ready(function(event) {

    });

</script>

@endsection