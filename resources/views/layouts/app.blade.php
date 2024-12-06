<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url" content="{{env('APP_URL')}}" data-user="{{Auth::user()->id}}">
    <meta name="id" content="{{env('LIVE_CHAT_ID')}}">
    <meta name="type" content="user">

    <title>{{ config('app.name', 'DEV | Tuning-X | Performance Excellence') }}</title>

    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> --}}
    <link href="{{ url('vendor/ecutech-code/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css">

    <link href="{{ url('vendor/ecutech-code/css/newappv1.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
    {{-- <link href="{{url('/css/all.min.css')}}" rel="stylesheet"> --}}

    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> --}}
    <script src="{{url('vendor/ecutech-code/js/jquery.min.js')}}"></script>

    {{-- <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script> --}}
    <script src="{{url('vendor/ecutech-code/js/dropzone.min.js')}}"></script>

    {{-- <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" /> --}}
    <link rel="stylesheet" href="{{url('vendor/ecutech-code/css/dropzone.min.css')}}" type="text/css" />
    
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" type="text/css" /> --}}
    <link rel="stylesheet" href="{{ url('vendor/ecutech-code/css/datatables.css') }}" type="text/css" />

    {{-- <script src="https://phpcoder.tech/multiselect/js/jquery.multiselect.js"></script> --}}
    {{-- <link rel="stylesheet" href="https://phpcoder.tech/multiselect/css/jquery.multiselect.css"> --}}
    
    {{-- <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> --}}
    <script src="{{url('vendor/ecutech-code/js/jquery.dataTables.min.js')}}"></script>
    
    <style type="text/css">.tk-proxima-nova{font-family:"proxima-nova",sans-serif;}</style>
    {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script src="{{url('vendor/ecutech-code/js/sweetalert2.js')}}"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script> --}}
    <script src="{{url('vendor/ecutech-code/js/Chart.js')}}"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
    

    @yield('pagespecificstyles')    
</head>
<body>

    @yield('content')
   

</body>
<!-- jQuery library -->
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script> --}}

<!-- Latest compiled JavaScript -->
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}

<script type="text/javascript">

    function showTime(){
            var date = new Date(new Date().toLocaleString('en', {timeZone: 'Europe/Athens'}));
            // var date = new Date();
            var h = date.getHours(); // 0 - 23
            var m = date.getMinutes(); // 0 - 59
            var s = date.getSeconds(); // 0 - 59
            var session = "AM";
            
            if(h == 0){
                h = 12;
            }
            
            if(h > 12){
                h = h - 12;
                session = "PM";
            }
            
            h = (h < 10) ? "0" + h : h;
            m = (m < 10) ? "0" + m : m;
            s = (s < 10) ? "0" + s : s;
            
            var time = h + ":" + m + ":" + s + " " + session;
            document.getElementById("MyClockDisplay").innerText = time;
            document.getElementById("MyClockDisplay").textContent = time;
            
            setTimeout(showTime, 1000);
            
        }

    showTime();

    $(document).on('click','.redirect-click',function(e) {
            if(!$(e.target).hasClass('switchery')){
                
                if( e.target.nodeName !== 'SMALL' && e.target.nodeName !== 'LABEL') {
                  window.location.href = $(this).data('redirect');
                }

                if(e.target.nodeName == 'LABEL'){
                  console.log( $(e.target).prev().is(":checked"));
                  if($(e.target).prev().is(":checked")){
                    $(e.target).prev().attr('checked', false);
                  }
                  else{
                    $(e.target).prev().attr('checked', true);
                  }
                }
            }
            return false;
        });

</script>

<script type="text/javascript">

    var icons;
    $( document ).ready(function(event) {

        // console.log(channel);

        $('.datatable').DataTable({
            "ordering": false,
        });

        $.ajax({
            url: "/get_tool_icons",
            type: "POST",
            async: false,
            data: {
            
            },
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            success: (response) => {
                icons = response;
            }
        });

    });

    function setUnseen(){
        $.ajax({
            url: "/get_unseen",
            type: "POST",
            // async: false,
            data: {
            
            },
            headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
            success: (response) => {
                $('#unseen').html(response);
            }
        });
    }

    $(document).ready(function(e){  

        $(document).on("click", ".close", function() {
            $(this).parent().hide();
        });

        // setUnseen();
        
         // message form on submit.
        $("#message-form").on("submit", (e) => {
            console.log(e);
            e.preventDefault();
            sendMessage();
            allMessages();
        });

        $(document).on('click','.button-collapse', function(ev){
            if($(this).data('activates') == 'slide-menu'){
                $('#slide-menu').css('transform','translateX(0%)');
                $(this).data('activates', 'show');
            }
            else if($(this).data('activates') == 'show'){
                $('#slide-menu').css('transform','translateX(-100%)');
                $(this).data('activates', 'slide-menu');
            }
        });

        $(document).on('click','.close-message', function(ev){
            $(this).parent().parent().hide();
        });

        $(document).on('click','#language-btn', function(ev){
            $('#switch-language').toggleClass('hide');
        });
    });

    function openForm() {
        let id = "{{ Auth::user()->id }}";
        document.getElementById("myForm").style.display = "block";
            $('#sendBtn').prop('autofocus');
            $("#div1").animate({ scrollTop: 100000}, 1000);

            allMessages();
            makeSeen(true);
            setUnseen();
        }

        function allMessages(){
            $.ajax({
                url: "fetchMessages",
                method: "POST",
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    id: 5,
                    type: 'group',
                    page: 1,
                },
                dataType: "JSON",
                success: (data) => {
                    // console.log(data.messages);
                    $("#div1").html("");
                    $("#div1").html(data.messages);
                    $("#div1").animate({ scrollTop: 100000}, 1000);
                },
                error: (error) => {
                    
                }
            });
        }

    function closeForm() {
        document.getElementById("myForm").style.display = "none";
        setUnseen();
    }
</script>
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}
<script src="{{url('vendor/ecutech-code/js/bootstrap.min.js')}}"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> --}}

{{-- <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
  <script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('a3a059d4aeb714a56210', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      alert(JSON.stringify(data));
    });
  </script> --}}

  <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

<script >
// Enable pusher logging - don't include this in production
Pusher.logToConsole = true;

var pusher = new Pusher("{{ config('chatify.pusher.key') }}", {
encrypted: true,
cluster: "ap2",
authEndpoint: '{{route("pusher.auth")}}',
auth: {
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}
});

console.log(pusher);


</script>

{{-- <div id="switch-language" class="modal bottom-sheet no-print hide" style="z-index: 1005; opacity: 1; display: block; bottom: 0px;">
    <div class="modal-content center no-print">
        <h2>Select your language</h2>
        <a href="/language/en" class="chip">
            <img src="https://resellers.ecutech.tech/assets/img/flags/gb.svg" alt="England flag">
            English
        </a>
        <a href="/language/gr" class="chip">
            <img src="https://resellers.ecutech.tech/assets/img/flags/gr.svg" alt="Greece flag">
            Ελληνικά
        </a>
    </div>
</div> --}}
@yield('pagespecificscripts')
{{-- <script src="{{ asset('vendor/ecutech-codejs/chatify/code.js') }}"></script>  --}}
</body>

</html>