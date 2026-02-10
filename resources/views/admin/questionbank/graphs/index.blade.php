@extends('admin.layouts.app')
@section('title', 'Luciderp | Graphs')
@push('styles')
    <style>
        .nav-tabs li {
            font-size: 15px;
            padding: 0 10px;
        }

        input#tutorSwitch {
            width: 3rem;
        }

        input#timedSwitch {
            width: 3rem;
        }

        .btn-group-toggle .btn {
            border-radius: 20px;
            padding: 8px 20px;
            font-size: 16px;
            transition: 0.3s;
        }

        .btn-check:checked+.btn {
            background-color: #fff;
            border-color: #ddd;
            color: black;
            font-weight: bold;
        }

        .btn-group {
            background-color: #e9ecef;
            border-radius: 25px;
            padding: 3px;
        }

        /* Custom Checkbox Styling */
        .form-check-input {
            width: 1.2rem;
            height: 1.2rem;
        }

        /* Blue Badge Styling */
        .badge-info {
            background-color: #e8f0ff;
            color: #1a73e8;
            font-weight: 600;
        }

        /* Disabled Input */
        .disabled-input {
            background: #f8f9fa;
            border: 1px solid #ddd;
            text-align: center;
            width: 50px;
        }

        .icon-size {
            font-size: 15px;
        }

        .stat-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .badge {
            background: #e9ecef;
            color: #6c757d;
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 50%;
            font-weight: 600;
        }

        .circle-chart {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            border: 8px solid #444;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 22px;
            font-weight: bold;
            color: #444;
        }

        .print-icon {
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
        }

        .print-icon img {
            width: 16px;
            margin-right: 4px;
        }

        .date-picker-container {
            display: flex;
            justify-content: flex-end;
            position: relative;
            margin-bottom: 20px;
        }

        .date-display {
            cursor: pointer;
            padding: 10px 15px;
            background: #fff;
            border-radius: 4px;
            font-size: 14px;
            border: 1px solid #ccc;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }

        .date-picker-dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            width: 400px;
        }

        .date-picker-dropdown .row {
            display: flex;
            justify-content: space-between;
        }

        .date-picker-dropdown .col-sm-2 {
            flex: 1;
            padding: 10px;
        }

        .date-picker-dropdown label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            color: #333;
        }

        .date-picker-dropdown input {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .date-picker-dropdown button {
            width: 100%;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 14px;
            margin-top: 10px;
        }

        .quick-range p {
            margin: 5px 0;
            cursor: pointer;
            color: #007bff;
            font-size: 14px;
        }

        .quick-range p:hover {
            text-decoration: underline;
        }
        #chartWrapper {
            scrollbar-width: thin;
            scrollbar-color: #007bff #f1f1f1; 
        }
        
        /* Chrome, Edge, Safari */
        #chartWrapper::-webkit-scrollbar {
            height: 10px;
        }
        
        #chartWrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        #chartWrapper::-webkit-scrollbar-thumb {
            background-color: #007bff;
            border-radius: 10px;
            border: 2px solid #f1f1f1;
        }
        
        #chartWrapper::-webkit-scrollbar-thumb:hover {
            background-color: #0056b3;
        }

    </style>
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Graphs</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            @if($testCount >= 2)
                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#home1"> Performance by
                                            Date</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#profile1"> Performance by Test</a>
                                    </li>

                                </ul>
                                <div class="tab-content mt-2">
                                   
                                    <div class="tab-pane fade show active" id="home1" role="tabpanel">
                                        <canvas id="testChart"></canvas>
                                        <div style="text-align: center; margin-top: 10px;">
                                            <button class="btn btn-primary" id="prevTest">Previous</button>
                                            <button class="btn btn-primary" id="nextTest">Next</button>
                                        </div>
                                    </div>
                                  <div class="tab-pane fade" id="profile1">
                                        <div id="chartWrapper" style="width: 100%; overflow-x: auto;">
                                            <canvas id="dateChart" height="400"></canvas>
                                        </div>
                                    </div>



                                </div>
                            </div>
                            @else
                            <h3 class="mt-3">Please complete at least 2 tests to view the performance graphs.</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $("#start-date, #end-date").datepicker({
                dateFormat: "M d, yy",
                changeMonth: true,
                changeYear: true
            });

            $("#toggle-date-picker").click(function() {
                $(".date-picker-dropdown").toggle();
            });

            $("#search-button").click(function() {
                $(".date-picker-dropdown").hide();
            });
        });


        document.addEventListener("DOMContentLoaded", function() {
            let currentIndex = 0;
            const testDates = @json($dateLabels); 
            const yourScores = @json($dateScores); 

            const ctx = document.getElementById('testChart').getContext('2d');
            let chartInstance = null; // Store chart instance

            function createChart() {
                if (chartInstance) {
                    chartInstance.destroy(); // Destroy previous chart
                }

                chartInstance = new Chart(ctx, {
                    type: 'scatter',
                    data: {
                        datasets: [{
                            label: "Your Score",
                            data: [{
                                x: 1,
                                y: yourScores[currentIndex]
                            }],
                            backgroundColor: 'green',
                            borderColor: 'green',
                            pointStyle: 'circle',
                            pointRadius: 6,
                            pointHoverRadius: 8
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        let score = context.raw.y; // Get the score value
                                        let date = testDates[currentIndex]; // Get the date
                                        return `${date}: ${score}%`; // Tooltip text
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                type: 'linear',
                                min: 0,
                                max: 2,
                                ticks: {
                                    callback: function(value) {
                                        return value === 1 ? testDates[currentIndex] : '';
                                    },
                                    font: {
                                        size: 14
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            },
                            y: {
                                title: {
                                    display: true,
                                    text: 'Score'
                                },
                                min: 0,
                                max: 100,
                                ticks: {
                                    stepSize: 20
                                }
                            }
                        }
                    }
                });
            }


            createChart(); // Initialize first chart

            document.getElementById('prevTest').addEventListener('click', function() {
                if (currentIndex > 0) {
                    currentIndex--;
                    createChart(); // Update chart with new data
                }
            });

            document.getElementById('nextTest').addEventListener('click', function() {
                if (currentIndex < testDates.length - 1) {
                    currentIndex++;
                    createChart(); // Update chart with new data
                }
            });

        });


   const chartCanvas = document.getElementById('dateChart');
    const labels = @json($labels);
    const testDates = @json($testDates);
    const yourScores = @json($yourScores);

    // 👇 Set canvas width dynamically (e.g., 80px per data point)
    chartCanvas.width = labels.length * 80;

    const ctx2 = chartCanvas.getContext('2d');

    const data2 = {
        labels: labels,
        datasets: [{
            label: "Your Score (%)",
            data: yourScores.map((percentage, index) => ({
                x: labels[index],
                y: percentage,
                testDate: testDates[index]
            })),
            backgroundColor: 'green',
            pointStyle: 'circle',
            pointRadius: 5,
            pointHoverRadius: 7,
        }]
    };

    new Chart(ctx2, {
        type: 'scatter',
        data: data2,
        options: {
            responsive: false,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return `Score: ${context.raw.y}%, Date: ${context.raw.testDate}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    type: 'category',
                    title: {
                        display: true,
                        text: 'Test IDs'
                    },
                    ticks: {
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 45,
                        font: {
                            size: 12
                        }
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Percentage (%)'
                    },
                    min: 0,
                    max: 100,
                    ticks: {
                        stepSize: 10
                    }
                }
            }
        }
    
  
        });
    </script>
@endpush
