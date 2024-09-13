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
          <table class="table table-hover datatable">
            <thead>
              <tr>
                <th width="30%">Code</th>
                <th>Desc</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($dtcLookupRecords as $dtc)
                  <tr class="">
                    <td>
                      <strong>{{$dtc->code}}</strong>
                    </td>
                    <td>{{$dtc->desc}}</td>
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