@extends('layouts.app')
@section('pagespecificstyles')

<style>
  .dataTables_wrapper .dataTables_length select {
    background: white;
}

.dataTables_wrapper .dataTables_filter input {
    background: white;
}

.checked {
    border: 2px solid #237E02 !important;
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
                <h1>File History</h1>
            </div>
        </div>
        <div class="i-content-block price-level">
        <table class="table table-hover datatable file-history-table">
          <thead>
            <tr>
              <th width="50%">Vehicle</th>
              <th>Status</th>
              <th>Created At</th>
              <th>Credits</th>
              <th>Vin</th>
              <th>Customer</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($files as $file)
                <tr class="redirect-click @if($file->checked_by == 'engineer') checked @endif" href="#" data-redirect="{{route('file', $file->id)}}">
                  <td>
                    <img alt="" class="img-circle-car-history" src="{{ get_image_from_brand($file->brand) }}">
                    {{$file->vehicle()->Name}} {{ $file->engine }} {{ $file->vehicle()->TORQUE_standard }}
                  </td>
                  <td>
                    <span class="label @if($file->status == 'rejected') label-danger @elseif($file->status == 'completed') label-success @elseif($file->status == 'submitted') label-grey @else label-orange @endif">@if($file->status == 'rejected') Canceled  @else {{ucfirst($file->status)}} @endif</span>
                  </td>
                  <td>{{$file->created_at->diffForHumans();}}</td>
                  <td>{{$file->credits}} Credits</td>
                  <td>@if($file->vin != ''){{$file->vin}} @else No Name @endif</td>
                  <td>@if($file->name != ''){{$file->name}} @else No Name @endif</td>
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