@extends('layouts.app')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

@section('content')
    <div class="page-content-wrapper ">
        @if (session('msg'))
            <div class="alert alert-success" role="alert">
                {{ session('msg') }}
            </div>
        @endif
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-lg-4 col-xl-4">
                    <a href="">
                        <div class="mini-stat clearfix bg-primary">
                            <span class="mini-stat-icon"><i class="mdi mdi-account"></i></span>
                            <div class="mini-stat-info text-right text-white">
                                <span class="counter">{{ $totalCustomers }}</span>
                                {{ __('Total User') }}
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 col-lg-4 col-xl-4">
                    <a href="">
                        <div class="mini-stat clearfix bg-primary">
                            <span class="mini-stat-icon"><i class="mdi mdi-account"></i></span>
                            <div class="mini-stat-info text-right text-white">
                                <span class="counter">{{ $totalSubscriptions }}</span>
                                {{ __('Active Subscriptions') }}
                            </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-4 col-lg-4 col-xl-4">
                    <a href="">
                        <div class="mini-stat clearfix bg-primary">
                            <span class="mini-stat-icon"><i class="mdi mdi-currency-eur"></i></span>
                            <div class="mini-stat-info text-right text-white">
                                <span class="counter">{{ $subscriptionsRevenue }}</span>
                                {{ __('Total Revenue Subscription') }}
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-6 ">
                    <div class="card m-b-20">
                        <div class="card-body">
                            <div style="margin: auto;">
                                <canvas id="barChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-5 mb-4">
                    <div class="card-body pb-0">
                        <canvas id="myPieChart" width="400" height="400"></canvas>
                    </div>
                </div>


            </div>
        </div><!-- container-fluid -->
    </div>
@endsection
@section('pageSpecificJs')
    <script>
        const totalReportsLabel = 'Total Users'
        var ctx = document.getElementById('barChart').getContext('2d');
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: @json($data['labels']),
                datasets: [{
                    label: totalReportsLabel,
                    data: @json($data['data']),
                    backgroundColor: 'rgba(114, 228, 30, 1)',
                    borderColor: 'rgba(114, 228, 30, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <script>
        var ctx = document.getElementById('myPieChart').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @json($labels),
                datasets: [{
                    data: @json($values),
                    backgroundColor: [
                        'rgba(114, 228, 30, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
                // onClick: function(event, elements) {
                //     if (elements.length > 0) {
                //         var label = myPieChart.data.labels[elements[0].index];
                //         // Perform action based on clicked label
                //         console.log('Clicked label:', label);
                //         window.location.href = `/lead?leadType=${label}`;
                //         // // Example: Redirect to a URL based on the clicked label
                //         // if (label === 'Label1') {
                //         //     window.location.href = 'https://example.com';
                //         // } else if (label === 'Label2') {
                //         //     window.location.href = 'https://anotherexample.com';
                //         // }
                //     }
                // }
            },
        });
    </script>
@endsection
