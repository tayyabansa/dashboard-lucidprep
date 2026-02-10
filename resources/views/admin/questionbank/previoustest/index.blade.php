@extends('admin.layouts.app')
@section('title', 'Luciderp | Previous Test')                                 
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
    </style>
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Previous Tests</h4>
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
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#all">All</a>
                                    </li>
                                    @foreach ($subjectTabs as $tab)
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab"
                                                href="#{{ strtolower($tab['title']) }}">
                                                {{ $tab['title'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                                 <div class="tab-content">

                                    {{-- ALL TAB --}}
                                    <div class="tab-pane fade show active" id="all">
                                        <div class="container mt-4">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>SCORE</th>
                                                            <th>NAME</th>
                                                            <th>DATE</th>
                                                            <th>MODE</th>
                                                            <th>Q.POOL</th>
                                                            <th>SECTION</th>
                                                            <th>SUBJECTS</th>
                                                            <th># QS</th>
                                                            <th>ACTIONS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($incompleteTests as $test)
                                                            @php
                                                                $subjects = is_string($test->selected_subjects)
                                                                    ? json_decode($test->selected_subjects, true)
                                                                    : $test->selected_subjects;
                                                                $subjects = is_array($subjects) ? $subjects : [];
                                                                $displaySubjects = array_slice($subjects, 0, 3);
                                                                $remainingCount = count($subjects) - 3;
                                                                $questionTypes = is_string($test->question_type)
                                                                    ? json_decode($test->question_type, true)
                                                                    : [];
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $test->score_percentage }}%</td>
                                                                <td>{{ \App\Models\WpUser::find($test->user_id)->user_login ?? 'Unknown' }}
                                                                </td>
                                                                <td>{{ $test->created_at->format('d-m-y') }}</td>
                                                                <td>{{ ucfirst($test->test_mode) }}</td>
                                                                <td>{{ $test->question_mode }}</td>
                                                                <td>{{ implode(', ', $questionTypes ?: []) ?: 'N/A' }}</td>
                                                                <td>
                                                                    <span class="short-subjects"
                                                                        data-id="{{ $test->question_id }}">
                                                                        {{ implode(', ', $displaySubjects) }}
                                                                        @if ($remainingCount > 0)
                                                                            <a href="javascript:void(0);"
                                                                                class="text-primary toggle-subjects"
                                                                                data-id="{{ $test->question_id }}">
                                                                                ... ({{ $remainingCount }} more)
                                                                            </a>
                                                                        @endif
                                                                    </span>
                                                                    <span class="full-subjects d-none"
                                                                        data-id="{{ $test->question_id }}">
                                                                        {{ implode(', ', $subjects) }}
                                                                        <a href="javascript:void(0);"
                                                                            class="text-danger toggle-subjects"
                                                                            data-id="{{ $test->question_id }}">
                                                                            Show Less
                                                                        </a>
                                                                    </span>
                                                                </td>
                                                                <td>{{ $test->total_questions }}</td>
                                                                <td>
                                                                    <a href="{{ route('test.launched', ['user_id' => Auth::id(), 'test_id' => $test->id]) }}"
                                                                        class="btn btn-primary">View</a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- DYNAMIC SUBJECT TABS --}}
                                   @foreach ($subjectTabs as $tab)
    <div class="tab-pane fade" id="{{ strtolower($tab['title']) }}">
        <div class="container mt-4">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>SCORE</th>
                            <th>NAME</th>
                            <th>DATE</th>
                            <th>MODE</th>
                            <th>Q.POOL</th>
                            <th>SECTION</th>
                            <th>SUBJECTS</th>
                            <th># QS</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $tests = $subjectTests[$tab['title']] ?? [];
                            $bestTest = collect($tests)->sortByDesc('score_percentage')->first();
                        @endphp

                        @forelse ($tests as $test)
                            @php
                                $subjects = is_string($test->selected_subjects) ? json_decode($test->selected_subjects, true) : $test->selected_subjects;
                                $subjects = is_array($subjects) ? $subjects : [];
                                $displaySubjects = array_slice($subjects, 0, 3);
                                $remainingCount = count($subjects) - 3;
                                $questionTypes = is_string($test->question_type) ? json_decode($test->question_type, true) : [];
                            @endphp
                            <tr>
                                <td>{{ $test->score_percentage }}%</td>
                                <td>{{ \App\Models\WpUser::find($test->user_id)->user_login ?? 'Unknown' }}</td>
                                <td>{{ $test->created_at->format('d-m-y') }}</td>
                                <td>{{ ucfirst($test->test_mode) }}</td>
                                <td>{{ $test->question_mode }}</td>
                                <td>{{ implode(', ', $questionTypes ?: []) ?: 'N/A' }}</td>
                                <td>
                                    <span class="short-subjects" data-id="{{ $test->question_id }}">
                                        {{ implode(', ', $displaySubjects) }}
                                        @if ($remainingCount > 0)
                                            <a href="javascript:void(0);" class="text-primary toggle-subjects" data-id="{{ $test->question_id }}">
                                                ... ({{ $remainingCount }} more)
                                            </a>
                                        @endif
                                    </span>
                                    <span class="full-subjects d-none" data-id="{{ $test->question_id }}">
                                        {{ implode(', ', $subjects) }}
                                        <a href="javascript:void(0);" class="text-danger toggle-subjects" data-id="{{ $test->question_id }}">
                                            Show Less
                                        </a>
                                    </span>
                                </td>
                                <td>{{ $test->total_questions }}</td>
                                <td>
                                    <a href="{{ route('test.launched', ['user_id' => Auth::id(), 'test_id' => $test->id]) }}" class="btn btn-primary">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No Data Available</td>
                            </tr>
                        @endforelse

                       @if ($bestTest)
    <tr class="table-success">
        <td colspan="9" class="text-center fw-bold">
            Your best score is {{ $bestTest->score_percentage }}% on {{ $bestTest->created_at->format('d-m-y') }} for {{ $tab['title'] }}
        </td>
    </tr>
@endif


                    </tbody>
                </table>
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
@endpush
