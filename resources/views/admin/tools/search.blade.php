@extends('admin.layouts.app')
@section('title', 'Luciderp | Search')
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

        .disabled-input {
            background: #f8f9fa;
            border: 1px solid #ddd;
            text-align: center;
            width: 50px;
        }

        .search-container {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-container input[type="text"] {
            padding: 10px;
            padding-left: 15px;
            border: 2px solid #c0c0c0;
            border-radius: 5px;
            outline: none;
            font-weight: 500;
            width: 300px;
            box-sizing: border-box;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: #fff;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .search-container input[type="text"]:focus {
            border-color: #007bff;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1), 0 0 3px rgba(0, 123, 255, 0.2);
        }

        .search-icon,
        .info-icon {
            background: none;
            border: none;
            cursor: pointer;
            padding: 5px;
            font-size: 18px;
        }
    </style>
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Search Questions</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="search-container">
                                <input type="text" id="searchQuery"
                                    placeholder="Enter ID, Subject, Question Type, or Content">
                                {{-- <button class="search-icon">
                                    <i class="fas fa-search mx-1"></i>
                                </button> --}}
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <div class="row">
                <div class="card">
                    <div class="container mt-2">
                        <h5 class="my-3">Total Results: <span id="resultCount">0</span></h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Subject</th>
                                        <th>System</th>
                                        <th>Topic</th>
                                        <th>Correct</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="tableBody">
                                    <tr id="initialMessage">
                                        <td colspan="6" class="text-center">No results found.</td>
                                    </tr>
                                </tbody>
                            </table>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
                 $(document).ready(function() {
                $("#searchQuery").on("keyup", function() {
                    let query = $(this).val();

                    if (query.length > 0) {
                        $.ajax({
                            url: "{{ route('search') }}",
                            type: "GET",
                            data: {
                                query: query
                            },
                            success: function(response) {
                                    let tableRows = "";
                                
                                    if (response.total > 0) {
                                        response.questions.forEach(function(question) {
                                            let subjects = JSON.parse(question.test?.selected_subjects || "[]");
                                            let topics = JSON.parse(question.test?.selected_topics || "[]");
                                
                                            // Ensure topics is an array; if empty, set default to ['N/A']
                                            topics = Array.isArray(topics) && topics.length > 0 ? topics : ["N/A"];
                                            subjects = Array.isArray(subjects) && subjects.length > 0 ? subjects : ["N/A"];
                                
                                            let displaySubjects = subjects.slice(0, 3).join(", ");
                                            let remainingSubjects = subjects.length - 3;
                                            let displayTopics = topics.slice(0, 3).join(", ");
                                            let remainingTopics = topics.length - 3;
                                
                                            tableRows += `
                                                <tr>
                                                    <td>${question.id}</td>
                                
                                                    <td>
                                                        <span class="short-subjects" data-id="${question.id}">
                                                            ${displaySubjects}
                                                            ${remainingSubjects > 0 ? `<a href="javascript:void(0);" class="text-primary toggle-subjects" data-id="${question.id}">... (${remainingSubjects} more)</a>` : ''}
                                                        </span>
                                                        <span class="full-subjects d-none" data-id="${question.id}">
                                                            ${subjects.join(", ")}
                                                            <a href="javascript:void(0);" class="text-danger toggle-subjects" data-id="${question.id}">Show Less</a>
                                                        </span>
                                                    </td>
                                
                                                    <td>${question.question_type || 'N/A'}</td>
                                
                                                    <td>
                                                        <span class="short-topics" data-id="${question.id}">
                                                            ${displayTopics}
                                                            ${remainingTopics > 0 ? `<a href="javascript:void(0);" class="text-primary toggle-topics" data-id="${question.id}">... (${remainingTopics} more)</a>` : ''}
                                                        </span>
                                                        <span class="full-topics d-none" data-id="${question.id}">
                                                            ${topics.join(", ")}
                                                            <a href="javascript:void(0);" class="text-danger toggle-topics" data-id="${question.id}">Show Less</a>
                                                        </span>
                                                    </td>
                                
                                                    <td>${question.content || 'N/A'}</td>
                                                    <td>${question.correct_answer || 'N/A'}</td>
                                                    <td>
                                                        <a href="" class="btn btn-sm btn-primary">View</a>
                                                    </td>
                                                </tr>`;
                                        });
                                    } else {
                                        tableRows = `<tr><td colspan="7" class="text-center">No results found.</td></tr>`;
                                    }
                                
                                    $("#tableBody").html(tableRows);
                                    $("#resultCount").text(response.total);
                                    $("#initialMessage").remove();
                                }

                        });
                    } else {
                        $("#tableBody").html(
                            `<tr id="initialMessage"><td colspan="7" class="text-center">No results found.</td></tr>`
                        );
                        $("#resultCount").text("0");
                    }
                });

                // Show More/Less functionality for subjects and topics
                $(document).on("click", ".toggle-subjects", function() {
                    let id = $(this).data("id");
                    $(`.short-subjects[data-id="${id}"]`).toggleClass("d-none");
                    $(`.full-subjects[data-id="${id}"]`).toggleClass("d-none");
                });

                $(document).on("click", ".toggle-topics", function() {
                    let id = $(this).data("id");
                    $(`.short-topics[data-id="${id}"]`).toggleClass("d-none");
                    $(`.full-topics[data-id="${id}"]`).toggleClass("d-none");
                });
            });
        </script>
    @endpush
