@extends('admin.layouts.app')
@section('title', 'Luciderp | Performance')
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
    </style>
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Overall Performance</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">

                        <div class="card-body">
                            <!-- Nav tabs -->
                             <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    @foreach ($groupedResults as $subject => $results)
                                        <li class="nav-item">
                                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab"
                                                href="#{{ Str::slug($subject) }}">{{ $subject }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content">
                                    @foreach ($groupedResults as $subject => $results)
                                        @php
                                            $total_questions = $results->count();

                                            $correct_answers = $results
                                                ->filter(function ($item) {
                                                    return $item->is_correct === 1;
                                                })
                                                ->count();

                                            $incorrect_answers = $results
                                                ->filter(function ($item) {
                                                    return $item->is_correct === 0;
                                                })
                                                ->count();

                                            $omitted_answers = $results
                                                ->filter(function ($item) {
                                                    return $item->is_correct !== 1 && $item->is_correct !== 0;
                                                })
                                                ->count();

                                            $omitted_percentage =
                                                $total_questions > 0
                                                    ? round(($omitted_answers / $total_questions) * 100, 2)
                                                    : 0;

                                            $used_questions = $correct_answers + $incorrect_answers;
                                            $unused_questions = $total_questions - $used_questions;

                                            $unused_percentage =
                                                $total_questions > 0
                                                    ? round(($unused_questions / $total_questions) * 100, 2)
                                                    : 0;

                                            $test_count = $results->unique('test_id')->count();
                                        @endphp


                                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                            id="{{ Str::slug($subject) }}">
                                            <div class="container mt-4">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="mb-0">{{ $subject }} Statistics</h5>
                                                    <a href="#" class="print-icon" id="printButton">
                                                        <i class="fa-solid fa-print"></i> Print
                                                    </a>
                                                </div>

                                                <div class="row mt-4">
                                                    <div class="col-md-3 text-center">
                                                        <p class="display-6 mb-0">{{ $omitted_percentage }}%</p>
                                                        <p class="text-muted">Omitted</p>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6>Your Score</h6>
                                                        <div class="stat-row">Total Correct <span
                                                                class="badge ">{{ $correct_answers }}</span></div>
                                                        <div class="stat-row">Total Incorrect <span
                                                                class="badge ">{{ $incorrect_answers }}</span>
                                                        </div>
                                                        <div class="stat-row">Total Omitted <span
                                                                class="badge ">{{ $omitted_answers }}</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <div class="row mt-4">
                                                    <div class="col-md-3 text-center">
                                                        <div class="circle-chart">
                                                            {{ $unused_percentage }}%<br>Unused
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6>Question Bank Usage</h6>
                                                        <div class="stat-row">Used Questions <span
                                                                class="badge">{{ $used_questions }}</span></div>
                                                        <div class="stat-row">Unused Questions <span
                                                                class="badge">{{ $unused_questions }}</span></div>
                                                        <div class="stat-row">Total Questions <span
                                                                class="badge">{{ $total_questions }}</span></div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <h6>Test Count</h6>
                                                        <div class="stat-row">Tests Created <span
                                                                class="badge">{{ $test_count }}</span></div>
                                                        <div class="stat-row">Tests Completed <span
                                                                class="badge">{{ $total_questions }}</span></div>
                                                        <div class="stat-row">Suspended Tests <span class="badge">0</span>
                                                        </div>
                                                    </div>
                                                </div>
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
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('printButton').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default link behavior
            window.print(); // Open the browser print dialog
        });
    </script>
@endpush
