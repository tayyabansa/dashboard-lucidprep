@extends('admin.layouts.app')
@section('title', 'Luciderp | Reports')
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

        .progress-container {
            display: flex;
            width: 100%;
            height: 6px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            border-radius: 0px !important;
        }

        .correct {
            background-color: green;
        }

        .incorrect {
            background-color: red;
        }

        .omitted {
            background-color: rgb(52, 52, 199);
        }
    </style>
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Reports</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">


                            <div class="custom-tab-1">
    <ul class="nav nav-tabs">
        @foreach ($groupedResults as $subject => $data)
            <li class="nav-item">
                <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab"
                   href="#{{ strtolower(str_replace(' ', '-', $subject)) }}">{{ $subject }}</a>
            </li>
        @endforeach
    </ul>

    <div class="tab-content mt-2">
        @foreach ($groupedResults as $subject => $data)
            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                 id="{{ strtolower(str_replace(' ', '-', $subject)) }}" role="tabpanel">
                @if ($data->isEmpty())
                    <h3 class="mt-3">Please complete at least 1 test to view the performance report.</h3>
                @else
                    <div class="custom-tab-1">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="subjects" role="tabpanel">
                                <div class="container mt-4">
                                    <div class="accordion accordion-primary mt-3" id="accordion-one">
                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Total Questions</th>
                                                    <th>Correct Q</th>
                                                    <th>Incorrect Q</th>
                                                    <th>Omitted Q</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $item)
                                                    <tr>
                                                        <td>
                                                            @php
                                                                $subject = \App\Models\Test::find($item->test_id);
                                                                $selectedSubjects = json_decode($subject->selected_subjects, true) ?? [];
                                                                $maxVisible = 2;
                                                                $displaySubjects = array_slice($selectedSubjects, 0, $maxVisible);
                                                                $remainingSubjects = array_slice($selectedSubjects, $maxVisible);
                                                                $remainingCount = count($remainingSubjects);

                                                                $totalQuestions = $item->total_questions;
                                                                $correctQuestions = $item->correct_questions;
                                                                $incorrectQuestions = $item->incorrect_questions;
                                                                $omittedQuestions = $item->omitted_questions;

                                                                $correctPercentage = $item->correct_percentage ?? 0;
                                                                $incorrectPercentage = $item->incorrect_percentage ?? 0;
                                                                $omittedPercentage = $item->omitted_percentage ?? 0;
                                                            @endphp

                                                            <span class="short-subjects" data-id="{{ $item->test_id }}">
                                                                {{ implode(', ', $displaySubjects) }}
                                                                @if ($remainingCount > 0)
                                                                    <a href="javascript:void(0);" class="text-primary toggle-subjects" data-id="{{ $item->test_id }}">
                                                                        ... ({{ $remainingCount }} more)
                                                                    </a>
                                                                @endif
                                                            </span>

                                                            <span class="full-subjects d-none" data-id="{{ $item->test_id }}">
                                                                {{ implode(', ', $selectedSubjects) }}
                                                                <a href="javascript:void(0);" class="text-danger toggle-subjects" data-id="{{ $item->test_id }}">
                                                                    Show Less
                                                                </a>
                                                            </span>

                                                            <div class="progress-container mt-2" style="height: 10px; display: flex; border-radius: 5px; overflow: hidden;">
                                                                <div class="progress-bar correct"
                                                                     style="background-color: green; flex: {{ $correctPercentage }}%;">
                                                                </div>
                                                                <div class="progress-bar incorrect"
                                                                     style="background-color: red; flex: {{ $incorrectPercentage }}%;">
                                                                </div>
                                                                <div class="progress-bar omitted"
                                                                     style="background-color: blue; flex: {{ $omittedPercentage }}%;">
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td>{{ $totalQuestions }}</td>
                                                        <td>{{ $correctQuestions }} ({{ $correctPercentage }}%)</td>
                                                        <td>{{ $incorrectQuestions }} ({{ $incorrectPercentage }}%)</td>
                                                        <td>{{ $omittedQuestions }} ({{ $omittedPercentage }}%)</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
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
    </script>

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll(".filter-checkbox");
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", function() {
                    let status = this.value;
                    let progressBars = document.querySelectorAll(
                        `.progress-bar[data-status="${status}"]`);
                    progressBars.forEach(bar => {
                        if (this.checked) {
                            bar.style.display = "block";
                        } else {
                            bar.style.display = "none";
                        }
                    });
                });
            });
        });
    </script> --}}

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkboxes = document.querySelectorAll(".filter-checkbox");
    
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", function() {
                    let progressContainers = document.querySelectorAll(".progress-container");
    
                    progressContainers.forEach(container => {
                        let correctBar = container.querySelector('.progress-bar.correct');
                        let incorrectBar = container.querySelector('.progress-bar.incorrect');
                        let omittedBar = container.querySelector('.progress-bar.omitted');
    
                        // Get original percentages (stored in data attributes)
                        let originalCorrect = parseFloat(correctBar.getAttribute("data-percentage"));
                        let originalIncorrect = parseFloat(incorrectBar.getAttribute("data-percentage"));
                        let originalOmitted = parseFloat(omittedBar.getAttribute("data-percentage"));
    
                        // Check which checkboxes are checked
                        let showCorrect = document.querySelector('input[value="Correct"]').checked;
                        let showIncorrect = document.querySelector('input[value="Incorrect"]').checked;
                        let showOmitted = document.querySelector('input[value="Omitted"]').checked;
    
                        // Apply the original widths, but hide bars when unchecked
                        correctBar.style.flex = `${originalCorrect}%`;
                        incorrectBar.style.flex = `${originalIncorrect}%`;
                        omittedBar.style.flex = `${originalOmitted}%`;
    
                        correctBar.style.visibility = showCorrect ? "visible" : "hidden";
                        incorrectBar.style.visibility = showIncorrect ? "visible" : "hidden";
                        omittedBar.style.visibility = showOmitted ? "visible" : "hidden";
                    });
                });
            });
    
            // Store original percentages as data attributes when the page loads
            document.querySelectorAll(".progress-bar").forEach(bar => {
                bar.setAttribute("data-percentage", parseFloat(bar.style.flex) || 0);
            });
        });
    </script> --}}

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const checkboxes = document.querySelectorAll(".filter-checkbox");
    
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("change", function () {
                    document.querySelectorAll(".progress-container").forEach(container => {
                        
                        let correctBar = container.querySelector('.progress-bar.correct');
                        let incorrectBar = container.querySelector('.progress-bar.incorrect');
                        let omittedBar = container.querySelector('.progress-bar.omitted');
    
                        let originalCorrect = parseFloat(correctBar.getAttribute("data-percentage")) || 0;
                        let originalIncorrect = parseFloat(incorrectBar.getAttribute("data-percentage")) || 0;
                        let originalOmitted = parseFloat(omittedBar.getAttribute("data-percentage")) || 0;
    
                        let showCorrect = document.querySelector('input[value="Correct"]').checked;
                        let showIncorrect = document.querySelector('input[value="Incorrect"]').checked;
                        let showOmitted = document.querySelector('input[value="Omitted"]').checked;
    
                        let totalVisible = 0;
                        if (showCorrect) totalVisible += originalCorrect;
                        if (showIncorrect) totalVisible += originalIncorrect;
                        if (showOmitted) totalVisible += originalOmitted;
    
                        if (totalVisible > 0) {
                            if (showCorrect) correctBar.style.flex = `${(originalCorrect / totalVisible) * 100}%`;
                            else correctBar.style.flex = "0%";
    
                            if (showIncorrect) incorrectBar.style.flex = `${(originalIncorrect / totalVisible) * 100}%`;
                            else incorrectBar.style.flex = "0%";
    
                            if (showOmitted) omittedBar.style.flex = `${(originalOmitted / totalVisible) * 100}%`;
                            else omittedBar.style.flex = "0%";
                        } else {
                            correctBar.style.flex = "0%";
                            incorrectBar.style.flex = "0%";
                            omittedBar.style.flex = "0%";
                        }
    
                        correctBar.style.visibility = showCorrect ? "visible" : "hidden";
                        incorrectBar.style.visibility = showIncorrect ? "visible" : "hidden";
                        omittedBar.style.visibility = showOmitted ? "visible" : "hidden";
                    });
                });
            });
    
            document.querySelectorAll(".progress-bar").forEach(bar => {
                bar.setAttribute("data-percentage", parseFloat(bar.style.flex) || 0);
            });
        });
    </script>
    
    
    
@endpush
