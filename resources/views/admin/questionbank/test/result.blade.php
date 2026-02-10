@extends('admin.layouts.app')
@section('title', 'Luciderp | Result Test')
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

        .form-check-input {
            width: 1.2rem;
            height: 1.2rem;
        }

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

        #myTable th,
        #myTable td {
            text-align: center;
            vertical-align: middle;
        }
        .score-box {
            text-align: center;
        }
        /* .score-details {
            display: flex;
            justify-content: space-between;
        } */
        .score-item {
            display: flex;
            justify-content: space-between;
            width: 100%;
            border-bottom: 1px solid #ddd;
            padding: 5px 0;
        }
        .score-item span {
            background: #eee;
            border-radius: 12px;
            padding: 2px 8px;
        }

        .chart-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: auto;
        }
        .search_bar .dropdown-menu form {
            margin-bottom: 0;
        }
        .card {
        	height: auto;
        }
    </style>
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Test Name</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="custom-tab-1">

                             <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <ul class="nav nav-tabs mb-2">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#test-results">Test Results</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#test-analysis">Test Analysis</a>
                                    </li>
                                </ul>
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#questionsModal">Questions List</button>
                            </div>


                                <div class="tab-content mt-3">
                                    <!-- Test Results Tab -->
                                    <div class="tab-pane fade show active" id="test-results" role="tabpanel">
                                        <div class="row mb-3">
                                            <div class="col-lg-4">
                                                <h5>Your Score</h5>
                                                <div class="progress" style="height: 16px;">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: {{ $your_score }}%;"
                                                        aria-valuenow="{{ $your_score }}" aria-valuemin="0"
                                                        aria-valuemax="100">
                                                        {{ $your_score }}%
                                                    </div>
                                                </div>
                                                <small class="text-muted">Avg: {{ $your_score }}%</small>
                                            </div>

                                            <div class="col-lg-4">
                                                <h5>Average Time Per Question</h5>
                                                <p><strong>Yours:</strong> {{ gmdate('H:i:s', $your_time) }} </p>
                                                <p><strong>Others:</strong> {{ round($others_time, 2) }} sec</p>
                                            </div>

                                            <div class="col-lg-4">
                                                <h5>Test Settings</h5>
                                                <p><strong>Mode:</strong> Tutored</p>
                                                <p><strong>Question Pool:</strong> Unused</p>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table class="table table-bordered text-center" id="myTable">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>ID</th>
                                                        <th>Subjects</th>
                                                        <th>Topics</th>
                                                        <th>% Correct Others</th>
                                                        <th>Your Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    
                                                    @foreach ($results as $result)
                                                        @php
                                                            // Decode subjects and topics safely
                                                            $subjects = json_decode($result->selected_subjects, true) ?? [];
                                                            $topics = json_decode($result->selected_topics, true) ?? [];
                                                
                                                            if (is_string($subjects)) {
                                                                $subjects = json_decode($subjects, true) ?? [];
                                                            }
                                                
                                                            if (is_string($topics)) {
                                                                $topics = json_decode($topics, true) ?? [];
                                                            }
                                                
                                                            // Get up to 3 subjects/topics for preview
                                                            $displaySubjects = array_slice($subjects, 0, 3); 
                                                            $remainingSubjects = count($subjects) - 3;
                                                
                                                            $displayTopics = array_slice($topics, 0, 3); 
                                                            $remainingTopics = count($topics) - 3;
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                @if ($result->is_correct === 1)
                                                                    <span class="text-success">✔</span>
                                                                @elseif ($result->is_correct === 0)
                                                                    <span class="text-danger">✖</span>
                                                                @elseif (is_null($result->is_correct))
                                                                    <span class="text-warning">--</span> 
                                                                @endif
                                                            </td>
                                                            
                                                            <td>{{ $result->question_id }}</td>
                                                
                                                            <!-- Subjects -->
                                                            <td>
                                                                <span class="short-subjects" data-id="{{ $result->question_id }}">
                                                                    {{ implode(', ', $displaySubjects) }}
                                                                    @if ($remainingSubjects > 0)
                                                                        <a href="javascript:void(0);" class="text-primary toggle-subjects" data-id="{{ $result->question_id }}">
                                                                            ... ({{ $remainingSubjects }} more)
                                                                        </a>
                                                                    @endif
                                                                </span>
                                                
                                                                <span class="full-subjects d-none" data-id="{{ $result->question_id }}">
                                                                    {{ implode(', ', $subjects) }}
                                                                    <a href="javascript:void(0);" class="text-danger toggle-subjects" data-id="{{ $result->question_id }}">
                                                                        Show Less
                                                                    </a>
                                                                </span>
                                                            </td>
                                                
                                                            <td>
                                                                <span class="short-topics" data-id="{{ $result->question_id }}">
                                                                   
                                                                  @if (!empty($displayTopics))
                                                                        {{ implode(', ', $displayTopics) }}
                                                                        @if ($remainingTopics > 0)
                                                                            <a href="javascript:void(0);" class="text-primary toggle-topics" data-id="{{ $result->question_id }}">
                                                                                ... ({{ $remainingTopics }} more)
                                                                            </a>
                                                                        @endif
                                                                    @else
                                                                        N/A
                                                                    @endif
                                                                </span>
                                                
                                                                <span class="full-topics d-none" data-id="{{ $result->question_id }}">
                                                                    {{ implode(', ', $topics) }}
                                                                    <a href="javascript:void(0);" class="text-danger toggle-topics" data-id="{{ $result->question_id }}">
                                                                        Show Less
                                                                    </a>
                                                                </span>
                                                            </td>
                                                
                                                            <td>{{ $result->accuracy }}</td>
                                                
                                                            <td>
                                                                @if (!is_null($result->time_spent))
                                                                    {{ gmdate('H:i:s', $result->time_spent) }}
                                                                @else
                                                                    --
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                        
                                    </div>

                                    <!-- Test Analysis Tab -->
                                    <div class="tab-pane fade" id="test-analysis" role="tabpanel">
                                        <h5>Test Analysis</h5>
                                        <div class="row align-items-center">
                                            <!-- Score Chart -->
                                            <div class="col-lg-4 text-center">
                                                <div class="chart-container">
                                                    <canvas id="scoreChart"></canvas>
                                                </div>
                                                <h6 class="mt-2">{{ $your_score }}% Correct</h6>
                                            </div>

                                            <!-- Your Score Section -->
                                            <div class="col-lg-4">
                                                <h6>Your Score</h6>
                                                <div class="score-details">
                                                    <div class="score-item">
                                                        <span>Total Correct</span> <span
                                                            class="badge bg-light">{{ $correct_answers }}</span>
                                                    </div>
                                                    <div class="score-item">
                                                        <span>Total Incorrect</span> <span
                                                            class="badge bg-light">{{ $incorrect_answers }}</span>
                                                    </div>
                                                    <div class="score-item">
                                                        <span>Total Omitted</span> <span
                                                            class="badge bg-light">{{ $omitted_answers }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Answer Changes Section -->
                                            <!--<div class="col-lg-4">-->
                                            <!--    <h6>Answer Changes</h6>-->
                                            <!--    <div class="score-details">-->
                                            <!--        <div class="score-item">-->
                                            <!--            <span>Correct to Incorrect</span> <span-->
                                            <!--                class="badge bg-light">0</span>-->
                                            <!--        </div>-->
                                            <!--        <div class="score-item">-->
                                            <!--            <span>Incorrect to Correct</span> <span-->
                                            <!--                class="badge bg-light">0</span>-->
                                            <!--        </div>-->
                                            <!--        <div class="score-item">-->
                                            <!--            <span>Incorrect to Incorrect</span> <span-->
                                            <!--                class="badge bg-light">0</span>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="modal fade" id="questionsModal" tabindex="-1" aria-labelledby="questionsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Question IDs</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @php
    $questionIds = $results->sortBy('question_id')->pluck('question_id')->join(', ');
                @endphp
                <textarea id="questionList" class="form-control" rows="5" readonly>{{ $questionIds }}</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="copyQuestionIds()">Copy</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
    function copyQuestionIds() {
        const textarea = document.getElementById('questionList');
        textarea.select();
        textarea.setSelectionRange(0, 99999); // for mobile
        document.execCommand('copy');
    }
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".toggle-subjects").forEach(function(element) {
                element.addEventListener("click", function() {
                    let id = this.getAttribute("data-id");

                    let row = this.closest("td");
                    let shortSubjects = row.querySelector(".short-subjects");
                    let fullSubjects = row.querySelector(".full-subjects");

                    shortSubjects.classList.toggle("d-none");
                    fullSubjects.classList.toggle("d-none");
                });
            });
        });
        const centerTextPlugin = {
          id: 'centerText',
          afterDraw(chart) {
            const {ctx, chartArea: {width, height}} = chart;
            ctx.save();
        
            const centerX = width / 2;
            const centerY = height / 2;
            
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.font = 'bold 24px Arial';
            ctx.fillStyle = '#000';
        
            // Draw the center text stored in chart.config.options.plugins.centerText.text
            const text = chart.config.options.plugins.centerText.text || '';
            ctx.fillText(text, centerX, centerY);
        
            ctx.restore();
          }
        };

      var ctx = document.getElementById('scoreChart').getContext('2d');

        var scoreChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Correct', 'Incorrect', 'Omitted'],
                datasets: [{
                    data: [{{ $correct_answers }}, {{ $incorrect_answers }}, {{ $omitted_answers }}],
                    backgroundColor: ['#28a745', '#dc3545', '#6c757d'],
                    borderWidth: 1
                }]
            },
            options: {
                cutout: '70%',
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    centerText: {
                        text: "{{ $your_score }}%"  // Initial center text
                    }
                },
                onClick: (evt, elements) => {
                    if (elements.length > 0) {
                        const index = elements[0].index;  // segment clicked index
                        const dataValue = scoreChart.data.datasets[0].data[index];
                        const total = scoreChart.data.datasets[0].data.reduce((a,b) => a+b, 0);
                        const percentage = ((dataValue / total) * 100).toFixed(1) + '%';
        
                        // Update center text and redraw chart
                        scoreChart.options.plugins.centerText.text = percentage;
                        scoreChart.update();
                    }
                }
            },
            plugins: [centerTextPlugin]
        });

    </script>
@endpush
