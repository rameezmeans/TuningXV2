@extends('layouts.app')
@section('pagespecificstyles')

<style>

        /* 
  You want a simple and fancy tooltip?
  Just copy all [data-tooltip] blocks:
*/
[data-tooltip] {
  --arrow-size: 5px;
  position: relative;
  z-index: 10;
}

.i-content-block{
  padding-top: 150px !important; 
}

/* Positioning and visibility settings of the tooltip */
[data-tooltip]:before,
[data-tooltip]:after {
  position: absolute;
  visibility: hidden;
  opacity: 0;
  left: 50%;
  bottom: calc(100% + var(--arrow-size));
  pointer-events: none;
  transition: 0.2s;
  will-change: transform;
}

/* The actual tooltip with a dynamic width */
[data-tooltip]:before {
  content: attr(data-tooltip);
  padding: 10px 18px;
  min-width: 50px;
  max-width: 300px;
  width: max-content;
  width: -moz-max-content;
  border-radius: 6px;
  font-size: 14px;
  background-color: black;
  background-image: linear-gradient(30deg,
    rgba(59, 72, 80, 0.44),
    rgba(59, 68, 75, 0.44),
    rgba(60, 82, 88, 0.44));
  box-shadow: 0px 0px 24px rgba(0, 0, 0, 0.2);
  color: #fff;
  text-align: center;
  white-space: pre-wrap;
  transform: translate(-50%,  calc(0px - var(--arrow-size))) scale(0.5);
}

/* Tooltip arrow */
[data-tooltip]:after {
  content: '';
  border-style: solid;
  border-width: var(--arrow-size) var(--arrow-size) 0px var(--arrow-size); /* CSS triangle */
  border-color: rgba(55, 64, 70, 0.9) transparent transparent transparent;
  transition-duration: 0s; /* If the mouse leaves the element, 
                              the transition effects for the 
                              tooltip arrow are "turned off" */
  transform-origin: top;   /* Orientation setting for the
                              slide-down effect */
  transform: translateX(-50%) scaleY(0);
}

/* Tooltip becomes visible at hover */
[data-tooltip]:hover:before,
[data-tooltip]:hover:after {
  visibility: visible;
  opacity: 1;
}
/* Scales from 0.5 to 1 -> grow effect */
[data-tooltip]:hover:before {
  transition-delay: 0.3s;
  transform: translate(-50%, calc(0px - var(--arrow-size))) scale(1);
}
/* 
  Arrow slide down effect only on mouseenter (NOT on mouseleave)
*/
[data-tooltip]:hover:after {
  transition-delay: 0.5s; /* Starting after the grow effect */
  transition-duration: 0.2s;
  transform: translateX(-50%) scaleY(1);
}
/*
  That's it for the basic tooltip.

  If you want some adjustability
  here are some orientation settings you can use:
*/

/* LEFT */
/* Tooltip + arrow */
[data-tooltip-location="left"]:before,
[data-tooltip-location="left"]:after {
  left: auto;
  right: calc(100% + var(--arrow-size));
  bottom: 50%;
}

/* Tooltip */
[data-tooltip-location="left"]:before {
  transform: translate(calc(0px - var(--arrow-size)), 50%) scale(0.5);
}
[data-tooltip-location="left"]:hover:before {
  transform: translate(calc(0px - var(--arrow-size)), 50%) scale(1);
}

/* Arrow */
[data-tooltip-location="left"]:after {
  border-width: var(--arrow-size) 0px var(--arrow-size) var(--arrow-size);
  border-color: transparent transparent transparent rgba(55, 64, 70, 0.9);
  transform-origin: left;
  transform: translateY(50%) scaleX(0);
}
[data-tooltip-location="left"]:hover:after {
  transform: translateY(50%) scaleX(1);
}



/* RIGHT */
[data-tooltip-location="right"]:before,
[data-tooltip-location="right"]:after {
  left: calc(100% + var(--arrow-size));
  bottom: 50%;
}

[data-tooltip-location="right"]:before {
  transform: translate(var(--arrow-size), 50%) scale(0.5);
}
[data-tooltip-location="right"]:hover:before {
  transform: translate(var(--arrow-size), 50%) scale(1);
}

[data-tooltip-location="right"]:after {
  border-width: var(--arrow-size) var(--arrow-size) var(--arrow-size) 0px;
  border-color: transparent rgba(55, 64, 70, 0.9) transparent transparent;
  transform-origin: right;
  transform: translateY(50%) scaleX(0);
}
[data-tooltip-location="right"]:hover:after {
  transform: translateY(50%) scaleX(1);
}



/* BOTTOM */
[data-tooltip-location="bottom"]:before,
[data-tooltip-location="bottom"]:after {
  top: calc(100% + var(--arrow-size));
  bottom: auto;
}

[data-tooltip-location="bottom"]:before {
  transform: translate(-50%, var(--arrow-size)) scale(0.5);
}
[data-tooltip-location="bottom"]:hover:before {
  transform: translate(-50%, var(--arrow-size)) scale(1);
}

[data-tooltip-location="bottom"]:after {
  border-width: 0px var(--arrow-size) var(--arrow-size) var(--arrow-size);
  border-color: transparent transparent rgba(55, 64, 70, 0.9) transparent;
  transform-origin: bottom;
}

strong {
  display: inline-block;
    width: 200px;
    white-space: nowrap;
    overflow: hidden !important;
    text-overflow: ellipsis;
}

.stage-option-container .text-stage{
    position: relative;
}

.stage-option-container .text-stage button{
    position: absolute;
    right: 5px;
    top: 15px;
}

@media only screen and (max-width: 1439px) {
    strong {
     font-size:14px;
    }
    .text-stage button i{
        font-size: 15px !important;
    }
    .text-stage button{
        font-size: 13px !important;
        top: 32px !important;
        right: 0 !important;
    }
}

.with-gap {
  margin-right: 5px !important;
}

.loader {
  border: 16px solid transparent; /* Light grey */
  border-top: 16px solid #b01321; /* Blue */
  border-radius: 50%;
  width: 60px;
  height: 60px;
  margin-bottom: 20px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
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
          <div class="bb-light fix-header" style="height: 250px !important;">
            <div class="header-block header-block-w-p">
              <input type="hidden" id="type" value="@if($type == 'slave'){{'slave'}}@else{{'master'}}@endif">
              <div>
              <h1>Price List</h1>
              <p>All the details of Stages and Options are here. </p>
              </div>
              <div class="text-center">
                <a href="?type=master" class="btn @if($type == 'master' || $type == null) btn-info @else btn-white @endif">Master</a>
                <a href="?type=slave" class="btn @if($type == 'slave') btn-info @else btn-white @endif">Slave</a>
              </div>
              <div class="text-center form-group" style="margin-top: 20px;">
               <label>Vehicle type</label>
               <select id="vehicle_type" class="select-dropdown form-control" style="width: 20%; display: inline;">
                 <option value="car" @if($vehicleType == 'car') selected @endif>Car</option>
                 <option value="truck" @if($vehicleType == 'truck') selected @endif>Truck</option>
                 <option value="machine" @if($vehicleType == 'machine') selected @endif>Machine</option>
                 <option value="agri" @if($vehicleType == 'agri') selected @endif>Agriculture</option>
               </select>
              </div>
            </div>
          </div>
        
        <div class="i-content-block price-level">
            <div class="row post-row">
              <div class="col-xl-3 col-lg-3 col-md-3 heading-column">
                <div class="heading-column-box">  
                  <h3>Tuning</h3>
                  <p>These are tuning stages.</p>
                </div>
              </div>


              <div class="col-xl-8 col-lg-8 col-md-8">
                <div class="row">
                  @foreach ($stages as $stage)
                    <div class="col-xl-6 col-lg-6 col-md-6">
                      <div class="stage-option-container">
                        <span class="bl stage-img-box">
                          <input name="stage" class="with-gap" type="radio" id="tuning-{{$stage['id']}}" value="{{$stage['id']}}">
                          <img width="50%" src="{{'https://backend.ecutech.gr/icons/'.$stage['icon']}}" alt="{{$stage['name']}}">
                        </span>
                        <span class="text-stage">

                          <span style="display: inline-grid;">
                            <strong>{{$stage['name']}} @if(isset($vehicleType)){{' ('.ucfirst($vehicleType).')'}}@endif </strong>
                            <span class="text-danger"> @if($type == 'slave') {{$stage['tuningx_slave_credits']}} @else {{$stage['tuningx_credits']}} @endif Credits </span>
                          </span>

                          <button type="button" data-tooltip-location="left" data-tooltip="{{__(trim($stage['description']))}}"  class="btn btn-transparent" style="font-size: 16px; float: right;"><i style="font-size: 18px;" class="fa fa-info-circle"></i> Info</button>
                          
                        </span>
                      </div>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>

            <div class="row post-row">
              <div class="loader hide"></div>
              <div class="col-xl-3 col-lg-3 col-md-3 heading-column">
                <div class="heading-column-box">
                    <h3>Options</h3>
                    <p>These are tuning options.</p>
                </div>
              </div>

              <div class="col-xl-8 col-lg-8 col-md-8">
                <label class="account-label">Options</label>
                <div class="row">
                  @foreach ($options as $option)
                    <div class="col-xl-6 col-lg-6 col-md-6">
                      <div class="stage-option-container">
                        <span class="bl stage-img-box">
                          <img width="50%" src="{{'https://backend.ecutech.gr/icons/'.$option['icon']}}" alt="{{$option['name']}}">
                        </span>
                        <span class="text-stage">

                          <span style="display: inline-grid;">
                            <strong>{{$option['name']}} @if(isset($vehicleType)){{' ('.ucfirst($vehicleType).')'}}@endif</strong>
                            <span class="text-danger"> <span id="option-credits-{{$option['id']}}"> @if($type == 'slave') {{$option['tuningx_slave_credits']}} @else {{$option['tuningx_credits']}} @endif </span> Credits </span>
                          </span>

                          <button type="button" data-tooltip-location="left" data-tooltip="{{__(trim($option['description']))}}"  class="btn btn-transparent" style="font-size: 16px; float: right;"><i style="font-size: 18px;" class="fa fa-info-circle"></i> Info</button>
                          
                        </span>
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

      function removeParam(parameter)
      {
        var url=document.location.href;
        var urlparts= url.split('?');

      if (urlparts.length>=2)
      {
        var urlBase=urlparts.shift(); 
        var queryString=urlparts.join("?"); 

        var prefix = encodeURIComponent(parameter)+'=';
        var pars = queryString.split(/[&;]/g);
        for (var i= pars.length; i-->0;)               
            if (pars[i].lastIndexOf(prefix, 0)!==-1)   
                pars.splice(i, 1);
        url = urlBase+'?'+pars.join('&');
        window.history.pushState('',document.title,url); // added this line to push the new url directly to url bar .

      }
      return url;
      }

      $(document).on('change', '#vehicle_type', function(){

        console.log($(this).val());

        

        if(window.location.href.indexOf("?") > -1) {
            var url = removeParam('vehicle_type');
            url = document.location.href+"&vehicle_type="+$(this).val();
        }else{
            var url = removeParam('vehicle_type');
            var url = document.location.href+"?vehicle_type="+$(this).val();
        }
          document.location = url;
      });

      $(document).on('change', '.with-gap', function(){

        $('.loader').removeClass('hide');

        let stage_id = $(this).val();
        let file_type = $('#type').val();

        console.log(file_type);

        $.ajax({
                  url: 'get_options_for_stage',
                  data: {
                      stage_id: stage_id,
                  },
                  async: false,
                  type: "POST",
                  headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                  success: function(options) {

                        $('.loader').addClass('hide');
                        

                        valuesArray = jQuery.parseJSON(options);

                        console.log(valuesArray);

                        jQuery.each( valuesArray , function(i,v){

                        if(file_type == 'slave'){
                          
                          jQuery('#option-credits-'+v.option_id).html(v.slave_credits);
                          
                        }
                        else if(file_type == 'master'){
                          console.log('#option-credits-'+v.option_id);
                          console.log(v.master_credits);

                          jQuery('#option-credits-'+v.option_id).html(v.master_credits);
                          
                        }

                        });

                  },
                  error: function(XMLHttpRequest, textStatus, errorThrown) { 

                  } 
              });

      });

    });

</script>

@endsection