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
          <table class="table table-hover datatable">
            <thead>
              <tr>
                <th width="30%">Manufacturer Number</th>
                <th>ECU</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($boschRecords as $bosch)
                  <tr class="">
                    <td>
                      <strong>{{$bosch->manufacturer_number}}</strong>
                    </td>
                    <td>{{$bosch->ecu}}</td>
                  </tr>
              @endforeach
            </tbody>
          </table>
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