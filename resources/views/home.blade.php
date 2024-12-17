@extends('layouts.app')
@section('pagespecificstyles')

  <style>

  .alert {
    padding: 20px;
    background-color: #f44336;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
  }

  .alert.success {background-color: #04AA6D;}
  .alert.info {background-color: transparent;}
  .alert.warning {background-color: #ff9800;}

  .closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
  }

  .closebtn:hover {
    color: black;
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

        @php
        $frontend = \ECUApp\SharedCode\Models\FrontEnd::findOrFail(2);
        @endphp

        @if($frontend->resellers_text != NULL)
          <div class="alert @if($frontend->type == 'info') info @elseif($frontend->type == 'success') success @else danger @endif">
              <p>{!!$frontend->resellers_text!!}</p>
          </div>
        @endif

          {{-- @php 
            $feed = Illuminate\Support\Facades\Session::get('feed');       
          @endphp
        @if($feed)
        <div class="alert @if($feed->type == 'warning') info @elseif($feed->type == 'good_news') success @else danger @endif">
          
          @if(isset($feed))
            <p>{{$feed->feed}}</p>

          @endif
        </div>
        @endif --}}

        <div class="dashboard-header-block fix-header">
            <h1>Welcome, {{$user->name}}</h1>
        </div>  
        @if(!$user->is_admin())
        <div class="dashboard-content-box">
         
            <div class="row">
              <div class="col-md-6">
    
                <div class="card">
                  <div class="card-header">
                    <div style="display: inline-flex;"><h4>Files Completed</h4><span class="m-l-10">Last 24 hours</span></div>
                  </div>
                  <div class="card-content">
                    <div class="boxes">
                    <div class="small-box small-box-grey">
                      <span>This Week</span>
                      <h3>{{$thisWeeksFilesCount}}</h3>
                    </div>
                    <div class="small-box small-box-pale">
                      <span>This Month</span>
                      <h3>{{$thisMonthsFilesCount}}</h3>
                    </div>
                    <div class="small-box small-box-green">
                      <span>This Year</span>
                      <h3>{{$thisYearsFilesCount}}</h3>
                    </div>
                  </div>
                  </div>
                  <hr>
                  <div class="card-footer">
                    <a href="{{route('history')}}"><i class="fa-solid fa-arrow-up-right-from-square"></i> View File History</a>
                  </div>
                </div>
    
                <div class="card">
                  <div class="card-header">
                    <div style="display: inline-flex;"><h4>Recent Credits Transactions</h4></div>
                  </div>
                  <div class="card-content" style="height: 300px; overflow-x: scroll;">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>DATE</th>
                          <th>CREDITS</th>
                          <th>NOTES</th>
                          <th>AMOUNT</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($invoices as $invoice)
                            <tr>
                              <td>{{date('Y - m - d', strtotime( $invoice->created_at))}}</td>
                              <td>@if($invoice->credits > 0 ) <label class="label label-success"> {{$invoice->credits}} Credits </label> @else <label class="label label-danger"> {{-1*$invoice->credits}} Credits </label> @endif</td>
                              <td>{{$invoice->message_to_credit}}</td>
                              <td>${{$invoice->price_payed}}</td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                  <hr>
                  <div class="card-footer">
                    <a href="{{route('invoices')}}"><i class="fa-solid fa-arrow-up-right-from-square"></i> View Invoices</a>
                  </div>
                </div>
                
              </div>
              <div class="col-md-6">
    
                <div class="card" >
                  <div class="card-header">
                    <div style="display: inline-flex;"><h4>Recent Files</h4></div>
                  </div>
                  <div class="card-content">
    
                    <ul class="nav nav-tabs">
                      <li class="active"><a data-toggle="tab" href="#home">This Week</a></li>
                      <li><a data-toggle="tab" href="#menu1">This Month</a></li>
                      <li><a data-toggle="tab" href="#menu2">This Year</a></li>
                    </ul>
                  
                    <div class="tab-content">
                      <div id="home" class="tab-pane fade in active">
                        
                        <div class="week-chart chart-wrapper">
                          <canvas id="week-charts" height="696" width="1902" class="chartjs-render-monitor" style="display: block; height: 0px; width: 0px;"></canvas>
                        </div>
                      </div>
                      <div id="menu1" class="tab-pane fade">
                        <div class="month-chart chart-wrapper">
                          <canvas id="month-charts" height="696" width="1902" class="chartjs-render-monitor" style="display: block; height: 0px; width: 0px;"></canvas>
                      </div>
                      </div>
                      <div id="menu2" class="tab-pane fade">
                        <div class="year-chart chart-wrapper"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                            <canvas id="year-charts" height="696" width="1902" style="" class="chartjs-render-monitor"></canvas>
                        </div>
                      </div>
                      
                    </div>
    
    
                  </div>
                  <hr>
                  <div class="card-footer">
                    <a href="{{route('history')}}"><i class="fa-solid fa-arrow-up-right-from-square"></i> View File History</a>
                  </div>
    
                </div>
    
              </div>
            </div>
        </div>  
        @else
        
        <div class="i-content-block price-level">
          <table class="table table-hover datatable">
            <thead>
              <tr>
                
                <th width="30%">Name</th>
                <th>Email</th>
                
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
                  <tr class="">
                    <td>
                      <strong>{{$user->name}}</strong>
                    </td>

                    <td>
                      <p>{{$user->email}}</p>
                    </td>

                    <td>
                      <a class="btn btn-success" href="{{route('loginAs', $user->id)}}">Login as This User</a>
                    </td>
                    

                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        
        @endif

       
        
      </div>
    </div>
  </div>
@endsection

@section('pagespecificscripts')

<script type="text/javascript">

    $( document ).ready(function(event) {

        $(document).on('click', '.close-feed', function(e){

            $(this).parent().parent().hide();

            $.ajax({
                url: "/clear_feed",
                type: "POST",
                headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    
                }
            }); 

        });

        // $(document).on('change', '.graph-select', function(e){
        //     let value = $(this).val();

        //     if(value == 'month'){
        //         $('.year-chart').addClass('hide');
        //         $('.month-chart').removeClass('hide');
        //         $('.week-chart').addClass('hide');
        //     }
        //     else if(value == 'week'){
        //         $('.year-chart').addClass('hide');
        //         $('.month-chart').addClass('hide');
        //         $('.week-chart').removeClass('hide');
        //     }
        //     else if(value == 'year'){   
        //         $('.year-chart').removeClass('hide');
        //         $('.month-chart').addClass('hide');
        //         $('.week-chart').addClass('hide');
        //     }

        // });

        var xValuesYears = ['January','Fabrury','March','April','May',
        'June','July','August','September','October', 'November', 'December'];

        let yearObj = @php echo $countYear @endphp;
        let dataYear = Object.values(yearObj);

        new Chart("year-charts", {
        type: "line",
        data: {
                labels: xValuesYears,
                datasets: [{
                label: 'Uploaded Files',
                data: dataYear,
                borderColor: "#F9D3D6",
                fill: true
                },
            ]
        },
        options: {
            legend: {display: true}
        }
        });

        let objMonths= @php echo $datesMonth @endphp;
        let xValuesMonths = Object.values(objMonths);

        let objMonthsCount = @php echo $datesMonthCount @endphp;
        let yMonthsCount = Object.values(objMonthsCount);

        console.log(yMonthsCount);

        new Chart("month-charts", {
        type: "line",
        data: {  
                labels: xValuesMonths,
                datasets: [{
                label: 'Uploaded Files',
                data: yMonthsCount,
                borderColor: "#F9D3D6",
                fill: true
                },
            ]
        },
        options: {
            legend: {display: true}
        }
        });

        let weekRangeObj = @php echo $weekRange @endphp;
        let xValuesWeek = Object.values(weekRangeObj);

        let objWeekCount = @php echo $weekCount @endphp;
        let yWeeksCount = Object.values(objWeekCount);

        // console.log(yMonthsCount);

        var chartEl = new Chart("week-charts", {
        type: "line",
        data: {
                labels: xValuesWeek,
                datasets: [{
                label: 'Uploaded Files',
                data: yWeeksCount,
                borderColor: "#F9D3D6",
                fill: true
                },
            ]
        },
        options: {
            legend: {display: true}
        }
        });

        chartEl.height = 500;
    });

</script>



@endsection