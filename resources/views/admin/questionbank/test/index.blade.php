@extends('admin.layouts.app')
@section('title', 'Luciderp | Create Test')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/test-index.css') }}">
@endpush
@section('content')
    <div @class(['content-body'])>
        <div @class(['container-fluid'])>
            <div @class(['row', 'page-titles', 'mx-0'])>
                <div @class(['col-sm-6', 'p-md-0'])>
                    <div @class(['welcome-text'])>
                        <h4>Create Test tayyab</h4>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2 mb-3" id="examTabs">
                <a href="{{ route('test', ['exam_type' => 'act']) }}"
                    class="btn btn-outline-primary {{ $examType === 'ACT' ? 'active' : '' }}" data-exam="ACT">
                    ACT
                </a>

                <a href="{{ route('test', ['exam_type' => 'sat']) }}"
                    class="btn btn-outline-primary {{ $examType === 'SAT' ? 'active' : '' }}" data-exam="SAT">
                    SAT
                </a>
            </div>
            @if (session('error'))
                <div @class(['alert', 'alert-danger', 'alert-dismissible', 'fade', 'show']) role="alert">
                    {{ session('error') }}
                    <button type="button" @class(['btn-close']) data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div @class(['row'])>
                <div @class(['col-xl-12'])>
                    <div @class(['card'])>
                        <div @class(['card-body'])>
                            <!-- Nav tabs -->
                            <div @class(['custom-tab-1'])>
                                <ul @class(['nav', 'nav-tabs']) id="dynamicTabs">
                                    <!-- Tabs will be dynamically inserted here -->
                                    <input type="hidden" id="active_tab" name="type" value="">
                                    <input type="hidden" id="exam_type" value="{{ $examType }}">
                                </ul>
                                <div @class(['tab-content'])>
                                    <!-- Tab content will be dynamically inserted here -->
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Function to attach click handlers to tabs
            function attachTabClickHandlers() {
                $(".nav-tabs .nav-link").click(function() {
                    // Remove active class from all tabs
                    $(".nav-tabs .nav-link").removeClass('active');
                    // Add active class to clicked tab
                    $(this).addClass('active');

                    let activeType = $(this).attr("data-type");
                    $("#active_tab").val(activeType);

                    // Clear previous passage counts
                    $(".badge-circle.badge-outline-dark").text("0");

                    // Load new question counts for the selected tab
                    loadQuestionCounts(activeType);
                });
            }

            // Function to load tabs from API
            function loadTabs() {
                $.ajax({
                    url: "{{ route('fetch.tabs', ['subject' => 'all']) }}?exam_type={{ strtolower($examType) }}",
                    type: 'GET',
                    success: function(response) {
                        // console.log("API Response:", response);
                        const examType = $('#exam_type').val(); // ACT / SAT
                        const tabsContainer = $('#dynamicTabs');
                        const tabContentContainer = $('.tab-content');

                        // 🔥 HARD RESET
                        tabsContainer.empty();
                        tabContentContainer.empty();

                        // ✅ FILTER COURSES BASED ON EXAM TYPE
                        let filteredCourses = response.filter(course => {
                            return course.exam_type === examType;
                        });

                        // ✅ RENDER FILTERED COURSES
                        filteredCourses.forEach((course, index) => {
                            const tabId = `tab${index + 1}`;
                            const isActive = index === 0 ? 'active' : '';
                            const subjectType = course.title;

                            // console.log("Creating tab:", {
                            //     tabId,
                            //     isActive,
                            //     subjectType
                            // });

                            // Create tab item
                            const tabHtml = `
                            <li @class(['nav-item'])>
                                <a @class(['nav-link', '${isActive}']) data-bs-toggle="tab" href="#${tabId}" data-type="${subjectType}">
                                    ${subjectType}
                                </a>
                            </li>
                        `;
                            tabsContainer.append(tabHtml);

                            // Create corresponding tab content
                            const tabContentHtml = `
                            <div class="tab-pane fade ${isActive ? 'show active' : ''}" id="${tabId}" role="tabpanel" data-type="${subjectType}">
                                <div @class(['row', 'pt-4'])>
                                    <div @class(['col-xl-12', 'col-lg-12', 'col-md-12', 'col-sm-12'])>
                                        <div @class(['card'])>
                                            <div @class(['card-body'])>
                                                <div @class(['accordion', 'accordion-primary']) id="accordion-${tabId}">
                                                    <!-- Quick Section -->
                                                    <div @class(['accordion-item'])>
                                                        <h2 @class(['accordion-header'])>
                                                            <button @class(['accordion-button']) type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#default-collapseOne-${tabId}"
                                                                aria-expanded="true"
                                                                aria-controls="default-collapseOne-${tabId}">
                                                                Quick <i @class([
                                                                    'fa',
                                                                    'fa-info-circle',
                                                                    'ml-1',
                                                                    'info-icon',
                                                                    'cursor',
                                                                    'mx-2',
                                                                ])></i>
                                                            </button>
                                                        </h2>
                                                        <div id="default-collapseOne-${tabId}"
                                                            @class(['accordion-collapse', 'collapse', 'show'])
                                                            data-bs-parent="#accordion-${tabId}">
                                                            <div @class(['accordion-body'])>
                                                                <div @class(['row'])>
                                                                    <div @class(['col-md-2'])>
                                                                        <a href="" @class(['btn', 'btn-primary', 'btn-md', 'start-test-btn']) data-subject="${subjectType}">START TEST</a>
                                                                    </div>
                                                                    <div @class(['col-md-1'])>
                                                                        <div @class(['form-group'])>
                                                                            <input type="text" @class(['form-control', 'max_number']) id="num_of_passages_${subjectType.toLowerCase()}" value="">
                                                                        </div>
                                                                    </div>
                                                                    <div @class(['col-md-2'])>
                                                                        <div @class(['form-group', 'mt-2'])>
                                                                            <label for="max-passages">
                                                                                Max Passages
                                                                                <a href="javascript:void(0)" @class(['badge', 'badge-circle', 'badge-outline-dark']) id="max_passages_badge_${subjectType.toLowerCase()}">0</a>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Personalize Section -->
                                                    <div @class(['accordion-item'])>
                                                        <h2 @class(['accordion-header'])>
                                                            <button @class(['accordion-button']) type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#default-collapseTwo-${tabId}"
                                                                aria-expanded="true"
                                                                aria-controls="default-collapseTwo-${tabId}">
                                                                Personalize <i @class([
                                                                    'fa',
                                                                    'fa-info-circle',
                                                                    'ml-1',
                                                                    'info-icon',
                                                                    'cursor',
                                                                    'mx-2',
                                                                ])></i>
                                                            </button>
                                                        </h2>
                                                        <div id="default-collapseTwo-${tabId}"
                                                            @class(['accordion-collapse', 'collapse', 'show'])
                                                            data-bs-parent="#accordion-${tabId}">
                                                            <form @class(['createTestForm']) data-subject="${subjectType}">
                                                                <div @class(['accordion-body'])>
                                                                    <!-- Test Mode Section -->
                                                                    <div @class(['accordion-body'])>
                                                                        <h4>Test Mode <i @class([
                                                                            'fa',
                                                                            'fa-info-circle',
                                                                            'ml-1',
                                                                            'info-icon',
                                                                            'cursor',
                                                                            'mx-2',
                                                                        ])></i></h4>
                                                                        <div @class(['mode', 'd-flex', 'gap-4', 'align-items-center'])>
                                                                            <div @class(['form-check', 'form-switch'])>
                                                                                <input @class(['form-check-input', 'big']) type="checkbox" id="tutorSwitch-${tabId}" name="test_mode[]" value="tutor" checked>
                                                                                <label @class(['form-check-label']) for="tutorSwitch-${tabId}">Tutor</label>
                                                                            </div>
                                                                            <div @class(['form-check', 'form-switch'])>
                                                                                <input @class(['form-check-input', 'big']) type="checkbox" id="timedSwitch-${tabId}" name="test_mode[]" value="timed">
                                                                                <label @class(['form-check-label']) for="timedSwitch-${tabId}">Timed</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <hr>
                                                                    
                                                                    <!-- Question Mode Section -->
                                                                    <div @class(['d-flex', 'align-items-center', 'gap-3'])>
                                                                        <strong>Question Mode <i @class([
                                                                            'fa',
                                                                            'fa-info-circle',
                                                                            'ml-1',
                                                                            'info-icon',
                                                                            'cursor',
                                                                            'mx-2',
                                                                        ])></i></strong>
                                                                        <span @class(['text-muted', 'fst-italic'])>Total Available</span>
                                                                        <a href="#" @class(['text-primary', 'fw-bold', 'question-count'])>0P / 0Q</a>
                                                                    </div>

                                                                    <div @class(['col-xl-12'])>
                                                                        <div @class(['card'])>
                                                                            <div @class(['card-body'])>
                                                                                <ul @class(['nav', 'nav-pills', 'mb-4', 'light'])>
                                                                                    <li @class(['nav-item'])>
                                                                                        <a href="#navpills-1-${tabId}" @class(['nav-link', 'active']) data-bs-toggle="tab" aria-expanded="false" name="question_mode" value="standard">Standard</a>
                                                                                    </li>
                                                                                    <li @class(['nav-item'])>
                                                                                        <a href="#navpills-2-${tabId}" @class(['nav-link']) data-bs-toggle="tab" aria-expanded="false" name="question_mode" value="custom">Custom</a>
                                                                                    </li>
                                                                                </ul>
                                                                                <div @class(['tab-content'])>
                                                                                    <div id="navpills-1-${tabId}" @class(['tab-pane', 'fade', 'show', 'active'])>
                                                                                        <div @class(['row'])>
                                                                                            <div @class(['col-md-12'])>
                                                                                                <!-- Select Type Section -->
                                                                                                <div @class(['my-3'])>
                                                                                                    <label @class(['fw-bold'])>Select Type</label>
                                                                                                    <div @class(['d-flex', 'flex-wrap', 'gap-3', 'mt-2'])>
                                                                                                        <div @class(['form-check'])>
                                                                                                            <input @class(['form-check-input', 'type-checkbox']) type="checkbox" name="type[]" value="unused" id="unused-${tabId}">
                                                                                                            <label @class(['form-check-label']) for="unused-${tabId}">
                                                                                                                Unused <span @class(['badge', 'badge-info'])>0P / 0Q</span>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                        <div @class(['form-check'])>
                                                                                                            <input @class(['form-check-input', 'type-checkbox']) type="checkbox" name="type[]" value="incorrect" id="incorrect-${tabId}">
                                                                                                            <label @class(['form-check-label']) for="incorrect-${tabId}">
                                                                                                                Incorrect <span @class(['badge', 'badge-info'])>0P / 0Q</span>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                        <div @class(['form-check'])>
                                                                                                            <input @class(['form-check-input', 'type-checkbox']) type="checkbox" name="type[]" value="marked" id="marked-${tabId}">
                                                                                                            <label @class(['form-check-label']) for="marked-${tabId}">
                                                                                                                Marked <span @class(['badge', 'badge-info'])>0P / 0Q</span>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                        <div @class(['form-check'])>
                                                                                                            <input @class(['form-check-input', 'type-checkbox']) type="checkbox" name="type[]" value="omitted" id="omitted-${tabId}">
                                                                                                            <label @class(['form-check-label']) for="omitted-${tabId}">
                                                                                                                Omitted <span @class(['badge', 'badge-info'])>0P / 0Q</span>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                        <div @class(['form-check'])>
                                                                                                            <input @class(['form-check-input', 'type-checkbox']) type="checkbox" name="type[]" value="correct" id="correct-${tabId}">
                                                                                                            <label @class(['form-check-label']) for="correct-${tabId}">
                                                                                                                Correct <span @class(['badge', 'badge-info'])>0P / 0Q</span>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                
                                                                                                <hr>
                                                                                                
                                                                                                <!-- Difficulty Level Section -->
                                                                                                <div @class(['my-3'])>
                                                                                                    <label @class(['fw-bold'])>Difficulty Level</label>
                                                                                                    <div @class(['d-flex', 'flex-wrap', 'gap-3', 'mt-2'])>
                                                                                                        <div @class(['form-check'])>
                                                                                                            <input @class(['form-check-input', 'difficulty-checkbox']) type="checkbox" name="difficulty_levels[]" value="easy" id="easy-${tabId}">
                                                                                                            <label @class(['form-check-label']) for="easy-${tabId}">
                                                                                                                Easy <span @class(['badge', 'badge-info'])>0P / 0Q</span>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                        <div @class(['form-check'])>
                                                                                                            <input @class(['form-check-input', 'difficulty-checkbox']) type="checkbox" name="difficulty_levels[]" value="medium" id="medium-${tabId}">
                                                                                                            <label @class(['form-check-label']) for="medium-${tabId}">
                                                                                                                Medium <span @class(['badge', 'badge-info'])>0P / 0Q</span>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                        <div @class(['form-check'])>
                                                                                                            <input @class(['form-check-input', 'difficulty-checkbox']) type="checkbox" name="difficulty_levels[]" value="hard" id="hard-${tabId}">
                                                                                                            <label @class(['form-check-label']) for="hard-${tabId}">
                                                                                                                Hard <span @class(['badge', 'badge-info'])>0P / 0Q</span>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                
                                                                                                <hr>
                                                                                                
                                                                                                <!-- Practice Type Section -->
                                                                                                <div @class(['my-3'])>
                                                                                                    <label @class(['fw-bold'])>Practice Type</label>
                                                                                                    <div @class(['d-flex', 'gap-3', 'mt-2'])>
                                                                                                        <div @class(['form-check'])>
                                                                                                            <input @class(['form-check-input', 'practice-type']) type="radio" name="practiceType" id="full-length-${tabId}" value="full-length" checked>
                                                                                                            <label @class(['form-check-label']) for="full-length-${tabId}">
                                                                                                                Full-length ACT Passages 
                                                                                                                <span @class(['badge', 'badge-info'])>0P / 0Q</span>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                        <div @class(['form-check'])>
                                                                                                            <input @class(['form-check-input', 'practice-type']) type="radio" name="practiceType" id="skill-based-${tabId}" value="skill-based">
                                                                                                            <label @class(['form-check-label']) for="skill-based-${tabId}">
                                                                                                                Skill-Based 
                                                                                                                <span @class(['badge', 'badge-info'])>0P / 0Q</span>
                                                                                                            </label>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                
                                                                                                <hr>
                                                                                                
                                                                                                <!-- Subjects Selection -->
                                                                                                <div @class(['my-3'])>
                                                                                                    <div @class(['ms-3', 'mt-2', 'subject-checkboxes'])>
                                                                                                        <!-- Subject checkboxes will be inserted here -->
                                                                                                    </div>
                                                                                                </div>
                                                                                                
                                                                                                <hr>
                                                                                                
                                                                                                <!-- Number of Questions Section -->
                                                                                                <div @class(['mainpassage', 'my-4'])>
                                                                                                    <label @class(['fw-bold', 'mb-3'])>No. of Questions <i @class(['bi', 'bi-info-circle'])></i></label>
                                                                                                    <div @class(['d-flex', 'align-items-center', 'gap-2'])>
                                                                                                        <input type="text" @class(['form-control', 'text-center', 'num_of_questions']) name="num_of_questions" style="width: 60px;" value="">
                                                                                                        <span @class(['text-muted'])>Max allowed per test</span>
                                                                                                        <a href="javascript:void(0)" @class([
                                                                                                            'badge',
                                                                                                            'badge-circle',
                                                                                                            'badge-outline-dark',
                                                                                                            'badge-total-q',
                                                                                                        ])>0</a>
                                                                                                    </div>
                                                                                                </div>
                                                                                                
                                                                                                <!-- Generate Test Button -->
                                                                                                <button type="submit" @class(['btn', 'btn-primary'])>Generate Test1</button>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    
                                                                                    <!-- Custom Mode Tab Content -->
                                                                                    <div id="navpills-2-${tabId}" @class(['tab-pane', 'fade'])>
                                                                                        <div @class(['row'])>
                                                                                            <div @class(['col-md-12'])>
                                                                                                <div @class(['row'])>
                                                                                                    <div @class(['col-md-7'])>
                                                                                                        <h5 @class(['fw-bold'])>Instructions on using Custom mode</h5>
                                                                                                        <p @class(['text-muted'])>
                                                                                                            You may enter question ID numbers, separated by commas, into the field to create a custom test.<br>
                                                                                                            Question ID numbers must be currently active in the Question bank and belong to the selected subject area in order to be added.<br>
                                                                                                            When entering questions from a question set, all questions from that set must be included and placed in the correct order.<br>
                                                                                                            If you are missing questions from the set, the system will provide a list of the missing question IDs.
                                                                                                        </p>
                                                                                                    </div>
                                                                                                    <div @class(['col-md-5'])>
                                                                                                        <label @class(['fw-bold'])>Retrieve Questions of a Test #</label>
                                                                                                        <div @class(['input-group', 'mb-2'])>
                                                                                                            <input type="text" @class(['form-control', 'test-id-input']) placeholder="Enter Test Id">
                                                                                                            <button @class(['btn', 'btn-primary']) type="button">RETRIEVE</button>
                                                                                                        </div>
                                                                                                        <p @class(['text-danger', 'test-id-error', 'mt-1']) style="display: none;"></p>
                                                                                                        
                                                                                                        <label @class(['fw-bold', 'mt-2'])>Enter Question IDs separated by comma (,)</label>
                                                                                                        <textarea @class(['form-control']) rows="4" placeholder="Enter question IDs..."></textarea>
                                                                                                    </div>
                                                                                                </div>
                                                                                                
                                                                                                <!-- Generate Test Button for Custom Mode -->
                                                                                                <div @class(['mt-3'])>
                                                                                                    <button @class(['btn', 'btn-primary', 'generate-test-btn']) type="button">Generate Test2</button>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                            tabContentContainer.append(tabContentHtml);
                        });

                        // Set initial active tab value
                        if (filteredCourses.length > 0) {
                            const initialSubject = filteredCourses[0].title;
                            $('#active_tab').val(initialSubject);
                            loadQuestionCounts(initialSubject);
                        }

                        // Reattach click event handlers
                        attachTabClickHandlers();
                        attachFormHandlers();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading tabs:', error);
                    }
                });
            }

            // Load tabs when document is ready
            loadTabs();
        });

        // Function to attach form handlers
        function attachFormHandlers() {
            // Form submission handler
            $('.createTestForm').on('submit', function(e) {
                e.preventDefault();

                const form = $(this);
                const activeTab = $('#dynamicTabs .nav-link.active').first();
                const subjectType = activeTab.attr('data-type'); // e.g. "math", "science", etc.
                // ✅ exam_type properly fetch karo
                let examType = $('#exam_type').val();

                // ✅ Agar undefined hai to URL se lo
                if (!examType || examType === 'undefined') {
                    const urlParams = new URLSearchParams(window.location.search);
                    examType = urlParams.get('exam_type') || 'ACT';
                }
                // ✅ Uppercase me convert karo
                examType = examType.toUpperCase();

                console.log('Sending exam_type:', examType); // ✅ Debug ke liye

                let selectedSubjects = form.find("input[name='selected_subjects[]']:checked").map(function() {
                    return this.value;
                }).get();

                const selectedTopics = form.find("input[name='selected_topic[]']:checked").map(function() {
                    return this.value;
                }).get();

                // Add parent subject for each checked topic if not already in selectedSubjects
                form.find("input[name='selected_topic[]']:checked").each(function() {
                    // Find the parent accordion-item (subject block)
                    const subjectCheckbox = $(this).closest('.accordion-item').find(
                        "input[name='selected_subjects[]']");
                    const subjectValue = subjectCheckbox.val();
                    if (subjectValue && !selectedSubjects.includes(subjectValue)) {
                        selectedSubjects.push(subjectValue);
                    }
                });

                // Debugging: check values in console
                console.log('Subject Type:', subjectType);
                console.log('Selected Subjects:', selectedSubjects);
                console.log('Selected Topics:', selectedTopics);

                // 🧠 Conditional logic:
                if (subjectType.toLowerCase() === 'math') {
                    if (selectedSubjects.length === 0 && selectedTopics.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No Topic or Subject Selected',
                            text: 'Please select at least one topic or subject before submitting.',
                        });
                        return;
                    }
                } else {
                    if (selectedSubjects.length === 0) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'No Subject Selected',
                            text: 'Please select at least one subject before submitting.',
                        });
                        return;
                    }
                }

                // ✅ Build form data only after validation
                const formData = {
                    subject_type: subjectType,
                    exam_type: examType,
                    test_mode: form.find("input[name='test_mode[]']:checked").map(function() {
                        return this.value;
                    }).get(),
                    question_mode: form.find(".nav-pills .nav-item .nav-link.active").attr('value'),
                    difficulty_levels: form.find("input[name='difficulty_levels[]']:checked").map(function() {
                        return this.value;
                    }).get(),
                    types: form.find("input[name='type[]']:checked").map(function() {
                        return this.value;
                    }).get(),
                    practice_type: form.find("input[name='practiceType']:checked").val(),
                    selected_subjects: selectedSubjects,
                    selected_topics: selectedTopics,
                    num_of_questions: form.find(".num_of_questions").val(),
                    _token: "{{ csrf_token() }}"
                };

                console.log('Form Data being sent:', formData);
                // AJAX submit
                $.ajax({
                    url: "{{ route('tests.store') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            console.log(response.launch_url);
                            window.location.href = response.launch_url;
                        } else {
                            alert("Error creating test");
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            for (let field in errors) {
                                let message = errors[field][0];
                                let inputField = form.find(`[name='${field}[]'], [name='${field}']`);
                                if (inputField.length) {
                                    if (!inputField.next().hasClass("error-message")) {
                                        inputField.after(
                                            `<div @class(['error-message', 'text-danger'])>${message}</div>`
                                        );
                                    }
                                }
                            }
                        } else {
                            alert("Error: Test not created!");
                        }
                    }
                });
            });

            // Start Test button handler
            $('.start-test-btn').on('click', function(e) {
                e.preventDefault();

                // Get the active tab's value - be more specific with the selector
                const activeTab = $('#dynamicTabs .nav-link.active').first();
                const subjectType = activeTab.attr('data-type');
                const numOfPassages = $(this).closest('.col-md-2').next('.col-md-1').find('input.max_number').val();

                // ✅ exam_type properly fetch karo
                let examType = $('#exam_type').val();
                if (!examType || examType === 'undefined') {
                    const urlParams = new URLSearchParams(window.location.search);
                    examType = urlParams.get('exam_type') || 'ACT';
                }
                examType = examType.toUpperCase();

                console.log('START TEST - Subject:', subjectType, 'Exam Type:', examType);
                console.log("Active Tab Element:", activeTab);
                console.log("Active Tab Data Type:", activeTab.attr('data-type'));
                console.log("Subject Type:", subjectType);

                if (!numOfPassages) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing Input',
                        text: 'Please enter number of passages/questions',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }

                if (!subjectType) {
                    console.error("No subject type found");
                    return;
                }

                $.ajax({
                    url: "{{ route('create.test.manual') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        subject_type: subjectType,
                        exam_type: examType,
                        num_of_passages: numOfPassages
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = response.launch_url;
                        } else {
                            alert("Error creating test");
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });

            // Custom tab click handler
            $('.nav-pills .nav-link').on('click', function(e) {
                e.preventDefault();
                const tabId = $(this).attr('href');
                const parentTab = $(this).closest('.tab-pane');

                // Remove active class from all nav links in this tab
                parentTab.find('.nav-pills .nav-link').removeClass('active');
                // Add active class to clicked nav link
                $(this).addClass('active');

                // Hide all tab content in this tab
                parentTab.find('.tab-content > div').removeClass('show active');
                // Show the selected tab content
                parentTab.find(tabId).addClass('show active');
            });

            // Update input field handling
            $(document).on('input', '.max_number', function() {
                const max = parseInt($(this).attr('max')) || 0;
                let val = parseInt($(this).val()) || 0;

                if (val > max) {
                    $(this).val(max);
                }
            });

            // Update input field when tab changes
            function updateInputField(subject, passageCount) {
                const $input = $(`#num_of_passages_${subject.toLowerCase()}`);
                if ($input.length) {
                    $input.attr("max", passageCount);
                    $input.prop("disabled", false).val('');
                }
            }
        }

        let defaultSubject = $("#active_tab").val();
        loadQuestionCounts(defaultSubject);

        function loadQuestionCounts(subject) {
            document.getElementById('preloader').style.display = 'block';
            // ✅ Method 1: Hidden input se
            let examTypeRaw = $('#exam_type').val();

            // ✅ Method 2: Agar undefined hai to URL se lo
            if (!examTypeRaw || examTypeRaw === 'undefined') {
                const urlParams = new URLSearchParams(window.location.search);
                examTypeRaw = urlParams.get('exam_type') || 'act';
            }

            console.log('exam_type raw:', examTypeRaw);

            const examType = examTypeRaw.toLowerCase();
            console.log('exam_type used in ajax:', examType);

            $.ajax({
                url: "{{ route('questions.counts', ':subject') }}"
                    .replace(':subject', subject) + '?exam_type=' + examType,
                type: "GET",
                success: function(response) {
                    // console.log('Question counts response:', response);
                    $('.tab-pane .mainpassage').show();
                    if (subject === 'English') {
                        $('.tab-pane[data-type="English"]').find('.mainpassage').hide();
                    }

                    $(".difficulty-checkbox, .type-checkbox, .subject-checkbox, input[name='selected_topic[]']")
                        .each(function() {
                            let badge = $(this).next("label").find(".badge-info");
                            badge.text(`0P / 0Q`);
                            $(this).prop("disabled", true).prop("checked", false).css("opacity", "0.5");
                        });

                    if (response.passageCount !== undefined) {
                        let sub = subject.toLowerCase();

                        const activeTab = $('.tab-pane.active');
                        const badgeInActiveTab = activeTab.find('.badge-circle.badge-outline-dark');
                        const labelInActiveTab = activeTab.find('.form-group.mt-2 label');

                        if (labelInActiveTab.length) {
                            if (sub === 'math') {
                                // Math subject ke liye "Total Questions"
                                labelInActiveTab.html(
                                    'Total Questions <a href="javascript:void(0)" @class(['badge', 'badge-circle', 'badge-outline-dark']) id="max_passages_badge_' +
                                    sub + '">' + response.totalQuestions + '</a>');
                            } else {
                                // Baaki sab ke liye "Max Passages"
                                labelInActiveTab.html(
                                    'Max Passages <a href="javascript:void(0)" @class(['badge', 'badge-circle', 'badge-outline-dark']) id="max_passages_badge_' +
                                    sub + '">' + response.passageCount + '</a>');
                            }
                        }

                        // Input fields update
                        $(`#num_of_passages_${sub}, .max_number`).each(function() {
                            const $input = $(this);
                            const maxValue = (sub === 'math') ? response.totalQuestions : response
                                .passageCount;
                            $input.attr("max", maxValue);
                            $input.prop("disabled", false).val('');
                        });
                    }


                    // Update question count

                    $(".question-count").text(`${response.passageCount}P / ${response.totalQuestions}Q`);

                    // Update total questions badge based on checked subjects
                    updateTotalQuestions();

                    if (Array.isArray(response.difficulties)) {
                        response.difficulties.forEach(item => {
                            if (item.difficulty) {
                                let difficulty = item.difficulty.toLowerCase();
                                let checkbox = $(`.difficulty-checkbox[value="${difficulty}"]`);
                                let badge = checkbox.next("label").find(".badge-info");

                                if (badge.length) {
                                    let passageCount = item.passage_count || 0;
                                    let totalCount = item.total || 0;
                                    let passageQuestionCount = item.passage_question_count || 0;

                                    if (subject === 'English') {
                                        badge.text(
                                            `${passageCount}P / ${passageQuestionCount}Q`
                                        ); // ✅ now working
                                    } else {
                                        badge.text(`${passageCount}P / ${totalCount}Q`);
                                    }

                                    checkbox.prop("disabled", false).prop("checked", true).css(
                                        "opacity", "1");
                                }
                            }
                        });
                    }

                    let unusedCheckbox = $('.type-checkbox[value="unused"]');
                    let unusedBadge = unusedCheckbox.next("label").find(".badge-info");
                    if (unusedBadge.length) {
                        unusedBadge.text(`${response.totalQuestions}Q`);
                        unusedCheckbox.prop("disabled", false).prop("checked", true).css("opacity", "1");
                    }

                    $(document).on('input', '.max_number', function() {
                        const max = parseInt($(this).attr('max')) || 0;
                        let val = parseInt($(this).val()) || 0;

                        if (val > max) {
                            $(this).val(max);
                        }
                    });
                    $(document).on('keypress', '.max_number', function(e) {
                        if (e.which < 48 || e.which > 57) {
                            e.preventDefault();
                            return;
                        }

                        const max = parseInt($(this).attr('max')) || 0;
                        const currentVal = $(this).val();
                        const newVal = parseInt(currentVal + String.fromCharCode(e.which));

                        if (newVal > max) {
                            e.preventDefault();
                            $(this).val(max);
                        }
                    });
                    $(document).on('paste', '.max_number', function(e) {
                        e.preventDefault();
                        const max = parseInt($(this).attr('max')) || 0;
                        const pastedText = (e.originalEvent.clipboardData || window.clipboardData)
                            .getData('text');
                        const pastedNumber = parseInt(pastedText);

                        if (!isNaN(pastedNumber)) {
                            if (pastedNumber > max) {
                                $(this).val(max);
                            } else if (pastedNumber >= 0) {
                                $(this).val(pastedNumber);
                            }
                        }
                    });
                    $("#mathTotal").text(` ${response.totalQuestions}`);
                    $("#no_of_questions").attr("max", ` ${response.totalQuestions}`);
                    $(document).on("input", "#no_of_questions", function() {
                        let max = parseInt($(this).attr("max")) || 0;
                        let val = parseInt($(this).val());
                        if (val > max) {
                            $(this).val(max); // Force back to max if exceeded
                        } else if (val < 0 || isNaN(val)) {
                            $(this).val('');
                        }
                    });
                    $(".subject-checkboxes").empty();
                    if (Array.isArray(response.subjectCounts)) {
                        const subjects = response.subjectCounts;
                        const container = $(".subject-checkboxes");
                        let rowHtml = '';

                        const filteredSubjects = subjects.filter(item => {
                            if (subject === 'English' && !item.has_passages) {
                                return false; // skip karo
                            }
                            return true;
                        });

                        filteredSubjects.forEach((item, index) => {
                            const subjectName = item.subject_name;
                            const subjectId = subjectName.toLowerCase().replace(/\s+/g, '_').replace(
                                /[^\w\-]/g, '');
                            const total = item.total;
                            const total_passage = item.passage_count;
                            const subjectTopics = response.groupedTopics[subjectName] || [];

                            let columnHtml = '<div @class(['col-md-6', 'mb-3'])>';

                            if (subjectTopics.length > 0) {
                                const accordionId = `accordion_${subjectId}`;
                                const headingId = `heading_${subjectId}`;
                                const collapseId = `collapse_${subjectId}`;

                                columnHtml += `
                                <div @class(['accordion']) id="${accordionId}">
                                    <div @class(['accordion-item'])>
                                        <h2 @class(['accordion-header']) id="${headingId}">
                                            <button @class(['accordion-button', 'd-flex', 'align-items-center']) type="button"
                                                data-bs-toggle="collapse" data-bs-target="#${collapseId}"
                                                aria-expanded="true" aria-controls="${collapseId}">
                                                <input type="checkbox" @class(['me-2', 'subject-checkbox']) id="${subjectId}" name="selected_subjects[]" value="${subjectName}">
                                                <label for="${subjectId}" @class(['m-0'])>${subjectName}</label>
                                            </button>
                                        </h2>
                                    
                                        <div id="${collapseId}" @class(['accordion-collapse', 'collapse', 'show']) aria-labelledby="${headingId}">
                                            <div @class(['accordion-body'])>
                                                <div @class(['row'])>
                                                    ${subjectTopics.map((topic) => {
                                                        const topicId = topic.topic_name.toLowerCase().replace(/\s+/g, '_').replace(/[^\w\-]/g, '');
                                                        return `
                                                                                                                                                                                                                                                                                                                                                <div @class(['mb-2'])>
                                                                                                                                                                                                                                                                                                                                                    <div @class(['form-check'])>
                                                                                                                                                                                                                                                                                                                                                        <input @class(['form-check-input']) type="checkbox" id="${topicId}" name="selected_topic[]" value="${topic.topic_name}" data-q="${topic.total}">
                                                                                                                                                                                                                                                                                                                                                        <label @class(['form-check-label']) for="">
                                                                                                                                                                                                                                                                                                                                                            ${topic.topic_name}
                                                                                                                                                                                                                                                                                                                                                            <span @class(['badge', 'badge-info'])>${topic.passage_count}P / ${topic.total}Q</span>
                                                                                                                                                                                                                                                                                                                                                        </label>
                                                                                                                                                                                                                                                                                                                                                    </div>
                                                                                                                                                                                                                                                                                                                                                </div>
                                                                                                                                                                                                                                                                                                                                            `;
                                                    }).join('')}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            } else {
                                const isDisabled = total === 0 ? 'disabled' : '';
                                columnHtml += `
                                    <div @class(['form-check'])>
                                        <input @class(['form-check-input', 'subject-checkbox']) name="selected_subjects[]" type="checkbox"
                                            id="${subjectId}" value="${subjectName}" data-q="${total}" ${isDisabled}>
                                        <label @class(['form-check-label', 'text-muted']) for="">      
                                            ${subjectName} <span @class(['badge', 'badge-info'])>${total_passage}P / ${total}Q</span>
                                        </label>
                                    </div>
                                `;
                            }

                            columnHtml += '</div>';

                            rowHtml += columnHtml;

                            if ((index + 1) % 2 === 0 || index === filteredSubjects.length - 1) {
                                container.append(
                                    `<div @class(['row'])>${rowHtml}</div>`);
                                rowHtml = '';
                            }
                        });


                        // ✅ Checkbox behavior
                        $("input[name='selected_subjects[]']").off("change").on("change", function() {
                            const isChecked = $(this).prop("checked");
                            $(this).closest(".accordion-item").find(
                                "input[name='selected_topic[]']:not(:disabled)").prop("checked",
                                isChecked);
                            updateTotalQuestions();
                        });

                        $("input[name='selected_topic[]']").off("change").on("change", function() {
                            const body = $(this).closest(".accordion-body");
                            const allChecked = body.find(
                                    "input[name='selected_topic[]']:not(:disabled):checked").length ===
                                body.find("input[name='selected_topic[]']:not(:disabled)").length;
                            $(this).closest(".accordion-item").find("input[name='selected_subjects[]']")
                                .prop("checked", allChecked);
                            updateTotalQuestions();
                        });
                    }
                    document.getElementById('preloader').style.display = 'none';
                },
                error: function(xhr) {
                    console.error("Error fetching question counts:", xhr.responseText);
                }
            });
        }

        // Function to update total questions
        function updateTotalQuestions() {
            let totalQ = 0;
            // Math tab logic: enable num_of_questions if any chapter or topic is checked in Math
            $(".tab-pane").each(function() {
                const tabPane = $(this);
                const subjectType = tabPane.data('type');
                if (subjectType && subjectType.toLowerCase() === 'math') {
                    // Math tab: check for any checked chapter or topic
                    const anyMathChecked = tabPane.find(
                        "input.subject-checkbox:checked, input[name='selected_topic[]']:checked").length > 0;
                    // Enable/disable only Math's num_of_questions
                    tabPane.find(".num_of_questions").prop("disabled", !anyMathChecked);
                }
            });
            // **Yahan change karein:**
            let isAnyCheckboxChecked = $("input.subject-checkbox:checked").length > 0 || $(
                "input[name='selected_topic[]']:checked").length > 0;
            $("input.subject-checkbox:checked").each(function() {
                const qValue = parseInt($(this).data("q")) || 0;
                totalQ += qValue;
            });
            $("input[name='selected_topic[]']:checked").each(function() {
                const qValue = parseInt($(this).data("q")) || 0;
                totalQ += qValue;
            });
            // Set total in all blocks
            $(".badge-total-q").each(function() {
                $(this).text(totalQ);
            });
            // Enable/disable all .num_of_passages inputs (for non-Math tabs)
            $(".tab-pane").each(function() {
                const tabPane = $(this);
                const subjectType = tabPane.data('type');
                if (!subjectType || subjectType.toLowerCase() !== 'math') {
                    // For non-Math tabs, use updated logic
                    if (isAnyCheckboxChecked) {
                        tabPane.find(".num_of_questions").prop("disabled", false).val(totalQ);
                    } else {
                        tabPane.find(".num_of_questions").prop("disabled", true).val('');
                    }
                }
            });
        }

        // Correctly scoped input check
        $(document).on("input change", ".num_of_questions", function() {
            const $block = $(this).closest(".d-flex"); // assuming input + badge are in the same row
            const maxAllowed = parseInt($block.find(".badge-total-q").text()) || 0;
            let val = parseInt($(this).val());
            if (isNaN(val) || val < 0) {
                $(this).val(''); // Reset to 0 if NaN or negative value
                return;
            }
            if (val > maxAllowed) {
                $(this).val(maxAllowed); // Set to maximum allowed if exceeds
                // You can also add a visual cue to indicate the maximum allowed passages exceeded
                $(this).addClass('is-invalid'); // For example, add a class to highlight it
            } else {
                $(this).removeClass('is-invalid'); // Remove any previous validation error class
            }
        });

        // Trigger when subject is checked
        $(document).on("change", "input.subject-checkbox", updateTotalQuestions);

        // Run initially
        $(document).ready(function() {
            updateTotalQuestions();
        });

        $(document).on("click", ".generate-test-btn", function(e) {
            e.preventDefault();

            let parentDiv = $(this).closest(".tab-pane");
            let testIdInput = parentDiv.find(".test-id-input");
            let errorMessage = parentDiv.find(".test-id-error");

            let testId = testIdInput.val().trim();
            const activeTab = $('#dynamicTabs .nav-link.active').first();
            const subjectType = activeTab.attr('data-type');

            errorMessage.hide().text("");
            if (!testId) {
                errorMessage.text("Please enter a Test ID.").show();
                testIdInput.addClass("is-invalid");
                return;
            }
            if (!/^\d+$/.test(testId)) {
                errorMessage.text("Test ID must be a valid number.").show();
                testIdInput.addClass("is-invalid").val("").focus();
                return;
            }

            testIdInput.removeClass("is-invalid");

            $.ajax({
                url: "{{ route('custom.test') }}",
                method: "POST",
                data: {
                    test_id: testId,
                    subject_type: subjectType,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.redirect_url;
                    }
                },
                error: function(xhr) {
                    let response = xhr.responseJSON;
                    if (response && response.message) {
                        errorMessage.text(response.message).show();
                        testIdInput.addClass("is-invalid");

                        setTimeout(() => {
                            errorMessage.fadeOut();
                            testIdInput.removeClass("is-invalid").val(
                                ""); // ðŸ"¹ Clears the input value
                        }, 2000);
                    } else {
                        errorMessage.text("Something went wrong. Try again.").show();
                    }
                }
            });
        });

        $(".test-id-input").on("input", function() {
            $(this).removeClass("is-invalid");
            $(this).closest(".tab-pane").find(".test-id-error").hide();
        });
    </script>
