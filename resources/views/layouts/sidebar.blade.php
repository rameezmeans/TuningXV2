<!-- Sidebar -->
<div id="sidebar">
    <header class="bb">
      <a href="{{route('home')}}">
        <svg class="logo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="142" height="50" viewBox="0 0 142 50"><defs><clipPath id="a"><rect width="142" height="50" fill="none"/></clipPath></defs><path d="M2.888,218.286,0,222.08H5.957v10.834h4.493V222.08h4.332l2.908-3.794Z" transform="translate(0 -183.015)" fill="#fff"/><g clip-path="url(#a)"><path d="M136.013,226.259q0,6.654-9.025,6.655h-.943q-9.025,0-9.025-6.655v-7.973h4.473v7.973a2.413,2.413,0,0,0,1.725,2.556,13.816,13.816,0,0,0,3.771.324,7.7,7.7,0,0,0,3.229-.487,2.4,2.4,0,0,0,1.3-2.394v-7.973h4.493Z" transform="translate(-98.328 -183.015)" fill="#fff"/><path d="M266.171,231.028q0,1.989-1.785,1.988a3.763,3.763,0,0,1-2.447-.974l-8.464-7.162v8.034h-4.492v-12.74a1.846,1.846,0,0,1,.511-1.339,1.932,1.932,0,0,1,1.454-.528,3.464,3.464,0,0,1,2.266.873l8.464,7.162v-8.054h4.493Z" transform="translate(-209.212 -183.016)" fill="#fff"/><rect width="4.473" height="14.628" transform="translate(59.265 35.271)" fill="#fff"/><path d="M430.149,231.028q0,1.989-1.785,1.988a3.763,3.763,0,0,1-2.447-.974l-8.464-7.162v8.034h-4.492v-12.74a1.846,1.846,0,0,1,.511-1.339,1.932,1.932,0,0,1,1.454-.528,3.464,3.464,0,0,1,2.266.873l8.464,7.162v-8.054h4.492Z" transform="translate(-346.997 -183.016)" fill="#fff"/><path d="M548.1,218.287l-2.888,3.793h-7.261a4.636,4.636,0,0,0-3.058,1,3.183,3.183,0,0,0-1.214,2.566,3.08,3.08,0,0,0,1.2,2.526,4.754,4.754,0,0,0,3.068.964h5.215v-1.359H537.55L534.6,224.17h13.056v8.744h-9.707a9.267,9.267,0,0,1-6.247-2.12,6.716,6.716,0,0,1-2.477-5.326,6.373,6.373,0,0,1,2.447-5.194,9.636,9.636,0,0,1,6.277-1.988Z" transform="translate(-444.691 -183.016)" fill="#fff"/><path d="M664.033,255.228h-7.922l-2.707-3.794h7.922Z" transform="translate(-549.032 -210.807)" fill="#fff"/><path d="M623.116,49.9H602.9L587.52,28.087l-4.38,5.374H572.96l9.894-12.126-10.277-14.7,7.3-.062,7.768,8.269L599.56,0h14.493L594.3,20.788Z" transform="translate(-481.116 0.001)" fill="#b01321"/></g></svg>
      </a>
    </header>
	@if(!Auth::user()->is_admin())
    @php 
      $feeds = ECUApp\SharedCode\Models\NewsFeed::where('active', 1)
        ->whereNull('subdealer_group_id')
        ->where('front_end_id', 2)
        ->get();
		
		$feed = NULL;

        foreach($feeds as $live){
			$feed = $live;
        }

	  $OnlineStatus = ECUApp\SharedCode\Models\IntegerMeta::where('key', 'tuningx_online_status')->first()->value;
    @endphp
	@if($feed)
		<div class="box @if($feed->type == 'danger') box-danger @else box-success @endif" style="height: 130px !important;">
		<p style="font-size: 10px;">Mon-Fri: ({{ date('h:i A', strtotime($workHours[0]->start))}} - {{ date('h:i A', strtotime($workHours[0]->end)) }})</p>
		<p style="font-size: 10px;">Sat: ({{ date('h:i A', strtotime($workHours[1]->start))}} - {{ date('h:i A', strtotime($workHours[1]->end)) }}) Sunday: (Closed)</p>
		<span>{{__('File Service Status')}}:</span>
		<p style="margin-top: 5px;"><span class="dot @if($feed->type == 'danger') dot-danger @else dot-success @endif"></span> @if($feed->type == 'danger') Offline @else Online @endif - <span id="MyClockDisplay"></span><span style="font-size: 10px;"> (Local Time)</span></p>
		</div>
	@endif

	<div class="box @if($OnlineStatus == 0) box-danger @else box-success @endif" style="height: 100px !important;">
		<p style="font-size: 10px;">24h / 7d</p>
		
		<p>{{__('Automatic File Service Status')}}:</p>
		<span class="dot @if($OnlineStatus == 'danger') dot-danger @else dot-success @endif"></span><span>@if($OnlineStatus == 0) {{'Not Online'}} @else {{'Online'}} @endif</span>
		
	</div>
	
	<div class="sidebar-section">
		<ul class="nav sidebar">
		  <li class="dashboard-link">
			<a href="{{route('home')}}">
			  <i>
			  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                  <path id="Path_11" data-name="Path 11" d="M3,6A3,3,0,0,1,6,3H8.25a3,3,0,0,1,3,3V8.25a3,3,0,0,1-3,3H6a3,3,0,0,1-3-3Zm9.75,0a3,3,0,0,1,3-3H18a3,3,0,0,1,3,3V8.25a3,3,0,0,1-3,3H15.75a3,3,0,0,1-3-3ZM3,15.75a3,3,0,0,1,3-3H8.25a3,3,0,0,1,3,3V18a3,3,0,0,1-3,3H6a3,3,0,0,1-3-3Zm9.75,0a3,3,0,0,1,3-3H18a3,3,0,0,1,3,3V18a3,3,0,0,1-3,3H15.75a3,3,0,0,1-3-3Z" transform="translate(-3 -3)" fill="#fff" fill-rule="evenodd"/>
                </svg>
			  </i> {{__('Dashboard')}}
			</a>
		  </li>
		</ul>
		<h3 class="nav-heading">{{__('Account')}}</h3>
		<ul class="nav sidebar">
		  <li class="">
			<a href="{{route('account')}}">
			  <i>
			    <svg xmlns="http://www.w3.org/2000/svg" width="16.499" height="21" viewBox="0 0 16.499 21">
                  <path id="Path_2" data-name="Path 2" d="M7.5,6A4.5,4.5,0,1,1,12,10.5,4.5,4.5,0,0,1,7.5,6ZM3.751,20.1a8.25,8.25,0,1,1,16.5,0,.75.75,0,0,1-.438.7,18.8,18.8,0,0,1-15.624,0,.75.75,0,0,1-.437-.695Z" transform="translate(-3.751 -1.5)" fill="#94a3b8" fill-rule="evenodd"/>
                </svg>
			  </i> {{__('Account Settings')}}
			</a>
		  </li>
		</ul>
	</div>
	<div class="sidebar-section">
		<h3 class="nav-heading">{{__('File')}}</h3>
		<ul class="nav sidebar">

		{{-- <li class="">
			<a href="{{route('original-files')}}">
				<i><svg xmlns="http://www.w3.org/2000/svg" width="18" height="21" viewBox="0 0 18 21">
					<g id="Group_78" data-name="Group 78" transform="translate(-3 -1.5)">
					<path id="Path_4" data-name="Path 4" d="M7.5,6H14.63A3.375,3.375,0,0,1,18,9.375V18.75a3,3,0,0,0,3-3V6.108a2.929,2.929,0,0,0-2.664-2.94q-.336-.027-.673-.05A3,3,0,0,0,15,1.5H13.5a3,3,0,0,0-2.663,1.618c-.225.015-.45.032-.673.05A2.928,2.928,0,0,0,7.5,6Zm6-3A1.5,1.5,0,0,0,12,4.5h4.5A1.5,1.5,0,0,0,15,3Z" fill="#94a3b8" fill-rule="evenodd"/>
					<path id="Path_5" data-name="Path 5" d="M3,9.375A1.875,1.875,0,0,1,4.875,7.5h9.75A1.875,1.875,0,0,1,16.5,9.375v11.25A1.876,1.876,0,0,1,14.625,22.5H4.875A1.875,1.875,0,0,1,3,20.625ZM6,12a.75.75,0,0,1,.75-.75h.008a.75.75,0,0,1,.75.75v.008a.75.75,0,0,1-.75.75H6.75a.75.75,0,0,1-.75-.75Zm2.25,0A.75.75,0,0,1,9,11.25h3.75a.75.75,0,0,1,0,1.5H9A.75.75,0,0,1,8.25,12ZM6,15a.75.75,0,0,1,.75-.75h.008a.75.75,0,0,1,.75.75v.008a.75.75,0,0,1-.75.75H6.75a.75.75,0,0,1-.75-.75Zm2.25,0A.75.75,0,0,1,9,14.25h3.75a.75.75,0,0,1,0,1.5H9A.75.75,0,0,1,8.25,15ZM6,18a.75.75,0,0,1,.75-.75h.008a.75.75,0,0,1,.75.75v.008a.75.75,0,0,1-.75.75H6.75a.75.75,0,0,1-.75-.75Zm2.25,0A.75.75,0,0,1,9,17.25h3.75a.75.75,0,0,1,0,1.5H9A.75.75,0,0,1,8.25,18Z" fill="#94a3b8" fill-rule="evenodd"/>
					</g>
				</svg>
				</i> {{__('Original Files')}}
				<span style="border-radius: 4px; display: inline-block; border: 1px solid #b01321; margin-left: 3px; background:#b01321; padding: 0px 2px 0px 2px; font-size: 10px;">New</span>
			</a>
		</li> --}}
		  <li class="">
			<a href="{{route('upload')}}">
			  <i><svg xmlns="http://www.w3.org/2000/svg" width="19.5" height="19.499" viewBox="0 0 19.5 19.499">
                  <path id="Path_3" data-name="Path 3" d="M11.47,2.47a.75.75,0,0,1,1.06,0l4.5,4.5a.75.75,0,0,1-1.06,1.06L12.75,4.81V16.5a.75.75,0,1,1-1.5,0V4.81L8.03,8.03A.75.75,0,0,1,6.97,6.97l4.5-4.5ZM3,15.75a.75.75,0,0,1,.75.75v2.25a1.5,1.5,0,0,0,1.5,1.5h13.5a1.5,1.5,0,0,0,1.5-1.5V16.5a.75.75,0,0,1,1.5,0v2.25a3,3,0,0,1-3,3H5.25a3,3,0,0,1-3-3V16.5A.75.75,0,0,1,3,15.75Z" transform="translate(-2.25 -2.251)" fill="#94a3b8" fill-rule="evenodd"/>
                </svg>
                </i> 
                {{__('File Upload')}}
			</a>
		  </li>
		  <li class="">
			<a href="{{route('history')}}">
			  <i><svg xmlns="http://www.w3.org/2000/svg" width="18" height="21" viewBox="0 0 18 21">
                  <g id="Group_78" data-name="Group 78" transform="translate(-3 -1.5)">
                    <path id="Path_4" data-name="Path 4" d="M7.5,6H14.63A3.375,3.375,0,0,1,18,9.375V18.75a3,3,0,0,0,3-3V6.108a2.929,2.929,0,0,0-2.664-2.94q-.336-.027-.673-.05A3,3,0,0,0,15,1.5H13.5a3,3,0,0,0-2.663,1.618c-.225.015-.45.032-.673.05A2.928,2.928,0,0,0,7.5,6Zm6-3A1.5,1.5,0,0,0,12,4.5h4.5A1.5,1.5,0,0,0,15,3Z" fill="#94a3b8" fill-rule="evenodd"/>
                    <path id="Path_5" data-name="Path 5" d="M3,9.375A1.875,1.875,0,0,1,4.875,7.5h9.75A1.875,1.875,0,0,1,16.5,9.375v11.25A1.876,1.876,0,0,1,14.625,22.5H4.875A1.875,1.875,0,0,1,3,20.625ZM6,12a.75.75,0,0,1,.75-.75h.008a.75.75,0,0,1,.75.75v.008a.75.75,0,0,1-.75.75H6.75a.75.75,0,0,1-.75-.75Zm2.25,0A.75.75,0,0,1,9,11.25h3.75a.75.75,0,0,1,0,1.5H9A.75.75,0,0,1,8.25,12ZM6,15a.75.75,0,0,1,.75-.75h.008a.75.75,0,0,1,.75.75v.008a.75.75,0,0,1-.75.75H6.75a.75.75,0,0,1-.75-.75Zm2.25,0A.75.75,0,0,1,9,14.25h3.75a.75.75,0,0,1,0,1.5H9A.75.75,0,0,1,8.25,15ZM6,18a.75.75,0,0,1,.75-.75h.008a.75.75,0,0,1,.75.75v.008a.75.75,0,0,1-.75.75H6.75a.75.75,0,0,1-.75-.75Zm2.25,0A.75.75,0,0,1,9,17.25h3.75a.75.75,0,0,1,0,1.5H9A.75.75,0,0,1,8.25,18Z" fill="#94a3b8" fill-rule="evenodd"/>
                  </g>
                </svg>
                </i> {{__('File History')}}
			</a>
		  </li>
		  <li class="">
			<a href="{{route('bosch-ecu')}}">
			<i><svg xmlns="http://www.w3.org/2000/svg" width="19.515" height="19.499" viewBox="0 0 19.515 19.499">
              <g id="image_3_" data-name="image (3)" transform="translate(-28.886 -17.664)">
                <path id="Path_602" data-name="Path 602" d="M38.268,17.678A7.993,7.993,0,0,0,36.1,18a7.381,7.381,0,0,0-1.378.494,9.931,9.931,0,0,0-4.905,4.78,9.576,9.576,0,0,0-.251,7.687,10.038,10.038,0,0,0,2.238,3.372,9.465,9.465,0,0,0,2.907,1.981,9.181,9.181,0,0,0,3.949.844,9.717,9.717,0,0,0,2.723-.389,12.2,12.2,0,0,0,2.258-1.005,10.088,10.088,0,0,0,3.3-3.293,11.343,11.343,0,0,0,.837-1.678,10.054,10.054,0,0,0,.616-3.184,8.426,8.426,0,0,0-.125-1.747,12.013,12.013,0,0,0-.527-1.925,11.14,11.14,0,0,0-.827-1.661A10.586,10.586,0,0,0,44.4,19.564a9.749,9.749,0,0,0-4.862-1.856l-.577-.043C38.907,17.662,38.594,17.665,38.268,17.678Zm1.038,1.249a8.052,8.052,0,0,1,4.1,1.444,8.2,8.2,0,0,1,1.533,1.3,13.948,13.948,0,0,1,.864,1.134,9.072,9.072,0,0,1,1.282,3.5,8.283,8.283,0,0,1-.053,2.518,9.95,9.95,0,0,1-.613,2.04,8.42,8.42,0,0,1-5.057,4.625,13.612,13.612,0,0,1-1.6.382,11.171,11.171,0,0,1-1.846.04,9.462,9.462,0,0,1-1.8-.356A8.419,8.419,0,0,1,31.28,31.7a9.448,9.448,0,0,1-1.094-3.214,10.666,10.666,0,0,1,0-2.176,10.133,10.133,0,0,1,.488-1.935,9.188,9.188,0,0,1,1.968-3.036A12.02,12.02,0,0,1,34,20.269a8.662,8.662,0,0,1,3.59-1.305c.191-.02.392-.043.445-.049A10.4,10.4,0,0,1,39.306,18.928Z" fill="#94a3b8"/>
                <path id="Path_603" data-name="Path 603" d="M114.821,118.285v1.734H107.8v-3.362l-.488.369a7.6,7.6,0,0,0-1.694,1.681,9.819,9.819,0,0,0-.893,1.46,7.459,7.459,0,0,0-.57,2.555,7.143,7.143,0,0,0,.712,3.524,8.155,8.155,0,0,0,1.058,1.536,8.476,8.476,0,0,0,1.605,1.5l.27.2v-2.97h7.021v1.533c0,.844.013,1.533.026,1.533a.651.651,0,0,0,.158-.109c.069-.059.293-.224.491-.366a7.081,7.081,0,0,0,2.05-2.113,5.1,5.1,0,0,0,.62-1.2,7.206,7.206,0,0,0,.26-4.625,5.415,5.415,0,0,0-.488-1.335,7.066,7.066,0,0,0-2.06-2.515c-.287-.224-.877-.646-1.015-.735A8.988,8.988,0,0,0,114.821,118.285Zm1.625,1.48a4.6,4.6,0,0,1,.725,1.5,4.868,4.868,0,0,1,.264,1.806,5.748,5.748,0,0,1-.5,2.459,6.885,6.885,0,0,1-.775,1.263l-.119.158v-3.877c0-2.133.007-3.877.013-3.877S116.238,119.452,116.446,119.765Zm-9.866,3.31,0,3.586-.076-.092a8.136,8.136,0,0,1-.659-1.157,10.632,10.632,0,0,1-.369-1.338,6.121,6.121,0,0,1,.27-3.066,4.746,4.746,0,0,1,.26-.649,7.82,7.82,0,0,1,.56-.867C106.573,119.491,106.58,121.1,106.58,123.074Zm8.109.191v1.994H107.8v-3.989h6.889Z" transform="translate(-72.779 -95.652)" fill="#94a3b8"/>
              </g>
            </svg>
            </i> {{__('Bosch ECU Numbers')}}
			</a>
		  </li>
		  <li class="">
			<a href="{{route('dtc-lookup')}}">
			<i><svg xmlns="http://www.w3.org/2000/svg" width="19.515" height="19.499" viewBox="0 0 19.515 19.499">
              <g id="image_3_" data-name="image (3)" transform="translate(-28.886 -17.664)">
                <path id="Path_602" data-name="Path 602" d="M38.268,17.678A7.993,7.993,0,0,0,36.1,18a7.381,7.381,0,0,0-1.378.494,9.931,9.931,0,0,0-4.905,4.78,9.576,9.576,0,0,0-.251,7.687,10.038,10.038,0,0,0,2.238,3.372,9.465,9.465,0,0,0,2.907,1.981,9.181,9.181,0,0,0,3.949.844,9.717,9.717,0,0,0,2.723-.389,12.2,12.2,0,0,0,2.258-1.005,10.088,10.088,0,0,0,3.3-3.293,11.343,11.343,0,0,0,.837-1.678,10.054,10.054,0,0,0,.616-3.184,8.426,8.426,0,0,0-.125-1.747,12.013,12.013,0,0,0-.527-1.925,11.14,11.14,0,0,0-.827-1.661A10.586,10.586,0,0,0,44.4,19.564a9.749,9.749,0,0,0-4.862-1.856l-.577-.043C38.907,17.662,38.594,17.665,38.268,17.678Zm1.038,1.249a8.052,8.052,0,0,1,4.1,1.444,8.2,8.2,0,0,1,1.533,1.3,13.948,13.948,0,0,1,.864,1.134,9.072,9.072,0,0,1,1.282,3.5,8.283,8.283,0,0,1-.053,2.518,9.95,9.95,0,0,1-.613,2.04,8.42,8.42,0,0,1-5.057,4.625,13.612,13.612,0,0,1-1.6.382,11.171,11.171,0,0,1-1.846.04,9.462,9.462,0,0,1-1.8-.356A8.419,8.419,0,0,1,31.28,31.7a9.448,9.448,0,0,1-1.094-3.214,10.666,10.666,0,0,1,0-2.176,10.133,10.133,0,0,1,.488-1.935,9.188,9.188,0,0,1,1.968-3.036A12.02,12.02,0,0,1,34,20.269a8.662,8.662,0,0,1,3.59-1.305c.191-.02.392-.043.445-.049A10.4,10.4,0,0,1,39.306,18.928Z" fill="#94a3b8"/>
                <path id="Path_603" data-name="Path 603" d="M114.821,118.285v1.734H107.8v-3.362l-.488.369a7.6,7.6,0,0,0-1.694,1.681,9.819,9.819,0,0,0-.893,1.46,7.459,7.459,0,0,0-.57,2.555,7.143,7.143,0,0,0,.712,3.524,8.155,8.155,0,0,0,1.058,1.536,8.476,8.476,0,0,0,1.605,1.5l.27.2v-2.97h7.021v1.533c0,.844.013,1.533.026,1.533a.651.651,0,0,0,.158-.109c.069-.059.293-.224.491-.366a7.081,7.081,0,0,0,2.05-2.113,5.1,5.1,0,0,0,.62-1.2,7.206,7.206,0,0,0,.26-4.625,5.415,5.415,0,0,0-.488-1.335,7.066,7.066,0,0,0-2.06-2.515c-.287-.224-.877-.646-1.015-.735A8.988,8.988,0,0,0,114.821,118.285Zm1.625,1.48a4.6,4.6,0,0,1,.725,1.5,4.868,4.868,0,0,1,.264,1.806,5.748,5.748,0,0,1-.5,2.459,6.885,6.885,0,0,1-.775,1.263l-.119.158v-3.877c0-2.133.007-3.877.013-3.877S116.238,119.452,116.446,119.765Zm-9.866,3.31,0,3.586-.076-.092a8.136,8.136,0,0,1-.659-1.157,10.632,10.632,0,0,1-.369-1.338,6.121,6.121,0,0,1,.27-3.066,4.746,4.746,0,0,1,.26-.649,7.82,7.82,0,0,1,.56-.867C106.573,119.491,106.58,121.1,106.58,123.074Zm8.109.191v1.994H107.8v-3.989h6.889Z" transform="translate(-72.779 -95.652)" fill="#94a3b8"/>
              </g>
            </svg>
            </i> {{__('DTC Lookup')}}
			</a>
		  </li>
		</ul>
	</div>
	<div class="sidebar-section">
		<h3 class="nav-heading">{{__('Credits')}}</h3>
		<ul class="nav sidebar">
		  <li class="">
			<a href="{{route('evc-credits-shop')}}">
			  <i class="fa-solid fa-cart-plus"></i> {{__('EVC Credits Shop')}}
			  @if(!Auth::user()->is_evc_customer())
				<span style="border-radius: 4px; display: inline-block; border: 1px solid #b01321; margin-left: 3px; background:#b01321; padding: 0px 2px 0px 2px; font-size: 10px;">New</span>
			  @endif
			</a>
		   
		  </li>
		  <li class="">
			<a href="{{route('shop-product')}}">
			  <i>
			   <svg xmlns="http://www.w3.org/2000/svg" width="20.891" height="19.5" viewBox="0 0 20.891 19.5">
                  <path id="Path_12" data-name="Path 12" d="M2.25,2.25a.75.75,0,0,0,0,1.5H3.636A.375.375,0,0,1,4,4.028L6.556,13.62A3.752,3.752,0,0,0,3.75,17.25.75.75,0,0,0,4.5,18H20.25a.75.75,0,0,0,0-1.5H5.378A2.25,2.25,0,0,1,7.5,15H18.718a.75.75,0,0,0,.674-.421,60.356,60.356,0,0,0,2.96-7.228.75.75,0,0,0-.525-.965A60.864,60.864,0,0,0,5.68,4.509l-.232-.867A1.875,1.875,0,0,0,3.636,2.25Zm1.5,18a1.5,1.5,0,1,1,1.5,1.5A1.5,1.5,0,0,1,3.75,20.25Zm12.75,0a1.5,1.5,0,1,1,1.5,1.5A1.5,1.5,0,0,1,16.5,20.25Z" transform="translate(-1.5 -2.25)" fill="#94a3b8"/>
                </svg>
			  </i> {{__('Credits Shop')}}
			</a>
		  </li>
		  <li class="">
			<a href="{{route('price-list')}}">
			  <i>
			  <svg xmlns="http://www.w3.org/2000/svg" width="19.5" height="19.5" viewBox="0 0 19.5 19.5">
                  <g id="Group_79" data-name="Group 79" transform="translate(-2.25 -2.25)">
                    <path id="Path_7" data-name="Path 7" d="M10.464,8.746a2.272,2.272,0,0,1,.786-.394v2.8a2.252,2.252,0,0,1-.786-.393,1.291,1.291,0,0,1-.546-1,1.291,1.291,0,0,1,.546-1Zm2.286,6.916V12.838a2.544,2.544,0,0,1,.921.421,1.138,1.138,0,0,1,0,1.982,2.534,2.534,0,0,1-.921.42Z" fill="#cbd5e1"/>
                    <path id="Path_8" data-name="Path 8" d="M12,2.25A9.75,9.75,0,1,0,21.75,12,9.75,9.75,0,0,0,12,2.25ZM12.75,6a.75.75,0,0,0-1.5,0v.816a3.836,3.836,0,0,0-1.72.756,2.688,2.688,0,0,0,0,4.356,3.818,3.818,0,0,0,1.719.756v2.978a2.536,2.536,0,0,1-.921-.421l-.879-.66a.75.75,0,1,0-.9,1.2l.879.66a4.124,4.124,0,0,0,1.821.75V18a.75.75,0,0,0,1.5,0v-.81a4.124,4.124,0,0,0,1.821-.749,2.625,2.625,0,0,0,0-4.382,4.122,4.122,0,0,0-1.821-.75V8.354a2.244,2.244,0,0,1,.786.393l.415.33A.75.75,0,0,0,14.884,7.9l-.415-.33a3.836,3.836,0,0,0-1.719-.755V6Z" fill="#94a3b8" fill-rule="evenodd"/>
                  </g>
                </svg>
			  </i> {{__('Price List')}}
			</a>
		  </li>
		  <li class="">
			<a href="{{route('invoices')}}">
			<i><svg xmlns="http://www.w3.org/2000/svg" width="16.5" height="21" viewBox="0 0 16.5 21">
              <g id="Group_80" data-name="Group 80" transform="translate(-3.75 -1.5)">
                <path id="Path_9" data-name="Path 9" d="M5.625,1.5A1.875,1.875,0,0,0,3.75,3.375v17.25A1.876,1.876,0,0,0,5.625,22.5h12.75a1.876,1.876,0,0,0,1.875-1.875V12.75A3.75,3.75,0,0,0,16.5,9H14.625A1.875,1.875,0,0,1,12.75,7.125V5.25A3.75,3.75,0,0,0,9,1.5ZM7.5,15a.75.75,0,0,1,.75-.75h7.5a.75.75,0,0,1,0,1.5H8.25A.75.75,0,0,1,7.5,15Zm.75,2.25a.75.75,0,0,0,0,1.5H12a.75.75,0,0,0,0-1.5Z" fill="#94a3b8" fill-rule="evenodd"/>
                <path id="Path_10" data-name="Path 10" d="M12.971,1.816A5.23,5.23,0,0,1,14.25,5.25V7.125a.375.375,0,0,0,.375.375H16.5a5.23,5.23,0,0,1,3.434,1.279,9.768,9.768,0,0,0-6.963-6.963Z" fill="#94a3b8"/>
              </g>
            </svg>
            </i> {{__('Invoices')}}
			</a>
		  </li>
		</ul>
		<div class="time-box">
		  {{__('Working Hours')}}:
		  <p style="font-size: 12px; margin-top: 10px; margin-bottom:0px;">Monday to Friday</p>
		  <span style="font-size: 14px; margin-top:">{{ date('h:i A', strtotime($workHours[0]->start))}} - {{ date('h:i A', strtotime($workHours[0]->end))}}</span>
		  <p style="font-size: 12px; margin-top: 10px; 0px; margin-bottom:0px;">Saturday</p>
		  <span style="font-size: 14px; margin:0px; margin-top: 0px;">{{ date('h:i A', strtotime($workHours[1]->start))}} - {{ date('h:i A', strtotime($workHours[1]->end))}}</span>
		  <p style="font-size: 12px; margin-top: 10px; margin-bottom:0px; padding: 0px;">Sunday</p>
		  <span style="font-size: 14px; margin-top: 0px;">Closed</span>

		</div>
	</div>
	@endif
  </div>
  