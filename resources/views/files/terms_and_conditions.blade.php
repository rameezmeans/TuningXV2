@extends('layouts.app')

@section('pagespecificstyles')

@endsection
@section('content')
<div id="viewport">
    @include('layouts.sidebar')
    <!-- Content -->
    <div id="content" style="padding-top: 100px !important; ">
      @include('layouts.header')
      <div class="container-fluid">
        <div class="file-title-block"> 
                <span style="display: inline-flex;" class="file-heading-area">
                  <div>
                    <h3 class="m-t-5">
                        Terms and Conditions
                    </h3>
                  </div>
                </span>
        </div>
        <div class="row bt">
          
          <div class="col-xl-12 col-lg-12 col-md-12 m-t-40" style="background: white;">
            {!!ECUApp\SharedCode\Models\Text::where('slug', 'terms-and-conditions')->where('front_end_id', 2)->first()->text!!}
          </div>
          
          
    </div>
  </div>
</div>

  
@endsection

@section('pagespecificscripts')

@endsection