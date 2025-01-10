<nav class="navbar navbar-default top-header">
  @if(!Auth::user()->is_admin())
  <div class="navbar-left mb-top-header">
    
    <div class="mb-header-ctrl desktop-hide">

      <div class="burger-menu">
        <a href="#" id="menu-opener">
          <svg class="opn" xmlns="http://www.w3.org/2000/svg" width="25.5" height="16.773" viewBox="0 0 25.5 16.773">
            <path id="icon-burger-menu" d="M3.75,6.75h24m-24,7.636h24m-24,7.636h12" transform="translate(-3 -6)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
          </svg>
          <svg class="cls" xmlns="http://www.w3.org/2000/svg" width="25.5" height="16.773" viewBox="0 0 26.121 26.121">
            <path id="icon-burger-menu-close" d="M6,30,30,6M6,6,30,30" transform="translate(-4.939 -4.939)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
          </svg>

        </a>
      </div>
      <div class="mb-logo">
        <a href="{{route('home')}}">
        <svg class="logo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="105" height="41" viewBox="0 0 142 50"><defs><clipPath id="a"><rect width="142" height="50" fill="none"/></clipPath></defs><path d="M2.888,218.286,0,222.08H5.957v10.834h4.493V222.08h4.332l2.908-3.794Z" transform="translate(0 -183.015)" fill="#fff"/><g clip-path="url(#a)"><path d="M136.013,226.259q0,6.654-9.025,6.655h-.943q-9.025,0-9.025-6.655v-7.973h4.473v7.973a2.413,2.413,0,0,0,1.725,2.556,13.816,13.816,0,0,0,3.771.324,7.7,7.7,0,0,0,3.229-.487,2.4,2.4,0,0,0,1.3-2.394v-7.973h4.493Z" transform="translate(-98.328 -183.015)" fill="#fff"/><path d="M266.171,231.028q0,1.989-1.785,1.988a3.763,3.763,0,0,1-2.447-.974l-8.464-7.162v8.034h-4.492v-12.74a1.846,1.846,0,0,1,.511-1.339,1.932,1.932,0,0,1,1.454-.528,3.464,3.464,0,0,1,2.266.873l8.464,7.162v-8.054h4.493Z" transform="translate(-209.212 -183.016)" fill="#fff"/><rect width="4.473" height="14.628" transform="translate(59.265 35.271)" fill="#fff"/><path d="M430.149,231.028q0,1.989-1.785,1.988a3.763,3.763,0,0,1-2.447-.974l-8.464-7.162v8.034h-4.492v-12.74a1.846,1.846,0,0,1,.511-1.339,1.932,1.932,0,0,1,1.454-.528,3.464,3.464,0,0,1,2.266.873l8.464,7.162v-8.054h4.492Z" transform="translate(-346.997 -183.016)" fill="#fff"/><path d="M548.1,218.287l-2.888,3.793h-7.261a4.636,4.636,0,0,0-3.058,1,3.183,3.183,0,0,0-1.214,2.566,3.08,3.08,0,0,0,1.2,2.526,4.754,4.754,0,0,0,3.068.964h5.215v-1.359H537.55L534.6,224.17h13.056v8.744h-9.707a9.267,9.267,0,0,1-6.247-2.12,6.716,6.716,0,0,1-2.477-5.326,6.373,6.373,0,0,1,2.447-5.194,9.636,9.636,0,0,1,6.277-1.988Z" transform="translate(-444.691 -183.016)" fill="#fff"/><path d="M664.033,255.228h-7.922l-2.707-3.794h7.922Z" transform="translate(-549.032 -210.807)" fill="#fff"/><path d="M623.116,49.9H602.9L587.52,28.087l-4.38,5.374H572.96l9.894-12.126-10.277-14.7,7.3-.062,7.768,8.269L599.56,0h14.493L594.3,20.788Z" transform="translate(-481.116 0.001)" fill="#b01321"/></g></svg>
      </a>

      </div>

    </div>
    <ul class="nav navbar-nav">
      <li class="m-r-8">
          <button data-redirect="{{route('upload')}}" class="btn btn-info redirect-click"><i class="fa fa-cloud-upload"></i> <span>File Uplaod</span></button>
      </li>
      <li class="m-r-8">
            <button data-redirect="{{route('shop-product')}}" class="btn btn-success redirect-click"><i class="fa fa-cart-shopping"></i> <span>Buy Credits</span></button>     
      </li>    
      <li class="mobile-hide">    
          <span style="display: inline-grid; position: absolute; width:200px;">
              <span class="m-l-26" style="">Credit Balance</span>
              <span class="m-l-26" ><b style="font-size:16px">{{Auth::user()->credits->sum('credits')}} Credits</b></span>
          </span>
          @if(Auth::user()->is_evc_customer())
            <div style="display: inline-grid; position: relative; width:220px; left: 110px;">
              <span class="m-l-26 text-red" style="">EVC Credit Balance</span>
              <span class="m-l-26 text-red" ><b>{{Auth::user()->evc_credits()}} Credits</b></span>
            </div>
          @endif
        
      </li>
    </ul>
  </div>
  @endif
  <div class="navbar-right mb-bottom-header">
    <div class="desktop-hide">    
        <span style="display: inline-grid; width:200px;">
            <span>Credit Balance</span>
            <span><b style="font-size:16px">{{Auth::user()->credits->sum('credits')}} Credits</b></span>
        </span>
        @if(Auth::user()->is_evc_customer())
          <div style="display: inline-grid; position: relative; width:220px; left: 110px;">
            <span class="m-l-26 text-red" style="">EVC Credit Balance</span>
            <span class="m-l-26 text-red" ><b>{{Auth::user()->evc_credits()}} Credits</b></span>
          </div>
        @endif
    </div>

    <ul class="nav navbar-nav">
      @if(!Auth::user()->is_admin())
        <li class="m-r-8">
            <button class="btn btn-warning redirect-click" data-redirect="{{route('cart')}}"> <span style="background: #4cae4c; color: white; padding: 2px 0px 2px 5px; border-radius: 5px; margin-right: 5px;"> {{\Cart::getTotalQuantity()}} </span> <i class="fa fa-cart-shopping"></i> Cart</button>
        </li>
        @endif
        <li>
            <form id="logout-form" action="{{ route('logout'); }}" method="POST" class="d-none">@csrf  <button class="btn btn-warning" type='submit'><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</button></form>
        </li>
    </ul>
  </div>
</nav>
{{-- @if(Session::has('success'))
  <p class="note-success">{{ Session::get('success') }} <button class="close">x</button></p>
@endif

@if(Session::has('danger'))
  <p class="note-danger">{{ Session::get('danger') }} <button class="close">x</button></p>
@endif --}}

<script type="text/javascript">
  document.addEventListener('DOMContentLoaded', function () {
    var menuOpener = document.getElementById('menu-opener');
    var sidebar = document.getElementById('sidebar');
    var body = document.body;

    menuOpener.addEventListener('click', function () {
      sidebar.classList.toggle('sidebar-active');
      body.classList.toggle('sidebar-open');
      menuOpener.classList.toggle('menu-open');
    });
  });
</script>