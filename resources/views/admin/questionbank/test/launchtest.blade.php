<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Luciderp | Questions test</title>
    <link rel="shortcut icon" href="{{ asset('public/images/favicon.png') }}">
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trumbowyg@2.25.1/dist/ui/trumbowyg.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Trumbowyg JS -->
    <script src="https://cdn.jsdelivr.net/npm/trumbowyg@2.25.1/dist/trumbowyg.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.2/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: ".tinymce-editor", // Apply to all elements with this class
            height: 300,
            menubar: false,
            plugins: "advlist autolink lists link charmap preview anchor",
            toolbar: "bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent",
        });
    </script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Math.js Library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mathjs/11.5.0/math.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.4/dist/katex.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
        }
        
        .btn-loader {
    margin-left: 6px;
}

        /* Popup Styling */
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: #f1f1f1;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            width: 500px;
        }

        button.scientific {
            background: #343a40;
        }

        .popup-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .close-btn {
            cursor: pointer;
            font-size: 18px;
            background: none;
            border: none;
        }

        span.Passage-underline {
            text-decoration: underline !important;
            display: inline-block !important;
            text-align: center !important;
            line-height: 1.2 !important;
        }

        span.Passage-number {
            font-size: 0.8em !important;
            position: relative !important;
            top: 20px !important;
            left: -40px !important;
            line-height: 65px !important;
        }

        .shortcut {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }

        .shortcut-key {
            background: black;
            color: white;
            padding: 5px;
            border-radius: 5px;
        }

        .header {
            background-color: #343a40;
            color: white;
            padding: 0.5rem 1rem;
        }

        .header-left,
        .header-center,
        .header-right {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-icons {
            display: flex;
            align-items: center;
        }

        #current-time {
            margin-left: 0.5rem;
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
        }

        .footer .btn {
            background-color: #6c757d;
            border-color: #6c757d;
            margin-right: 0.5rem;
        }

        .color-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            cursor: pointer;
            border: 2px solid transparent;
        }

        .color-circle:hover,
        .color-circle.selected {
            border: 2px solid #000;
        }

        #ckeditor {
            min-height: 300px;
        }

        .footer .btn:hover {
            background-color: #5c636a;
            border-color: #565e64;
        }

        .footer a {
            color: white;
            text-decoration: none;
            margin-left: 0.5rem;
        }

        .footer a:hover {
            color: lightgray;
        }

        .footer-feedback {
            display: flex;
            align-items: center;
        }

        .footer-feedback i {
            margin-right: 0.3rem;
        }

        .footer-nav a {
            position: relative;
        }

        .footer-nav a::before,
        .footer-nav a::after {
            content: "";
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            border-top: 5px solid transparent;
            border-bottom: 5px solid transparent;
        }

        .footer-nav a::before {
            left: -10px;
            border-right: 5px solid white;
        }

        .footer-nav a::after {
            right: -10px;
            border-left: 5px solid white;
        }

        .question-area {
            padding: 20px;
            height: 100vh;
            margin-bottom: 60px;
        }

        .col-md-6.question-area.english.resizable.col1 {
            height: none;
            height: auto;
        }

        .description-area {
            padding: 20px;
            border-left: 1px solid #dee2e6;
            height: 100%;
        }

        .options-list {
            list-style-type: none;
            padding: 0;
        }

        .options-list li {
            margin-bottom: 10px;
        }

        .header-icons span {
            cursor: pointer;
            margin: 0 9px;
            font-size: 20px;
            color: rgb(61 138 201);
        }

        .resizable {
            resize: horizontal;
            overflow: auto;
            min-width: 200px;
            max-width: 100%;
        }

        .col1 {
            border-right: 1px solid #000;
        }


        .drag-handle {
            width: 1px;
            cursor: ew-resize;
            position: absolute;
            right: 50%;
            top: 0;
            bottom: 0;
        }

        .custom-alert {
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-family: sans-serif;
            display: flex;
            align-items: center;
        }

        .custom-alert>div {
            flex: 1;
            text-align: center;
        }

        .custom-alert strong {
            font-size: 1.1rem;
        }

        .correct-answer {
            color: green;
        }

        .incorrect-answer {
            color: red;
        }

        .alert-icon {
            margin-right: 5px;
        }

        .time-accuracy {
            font-size: 0.9rem;
        }

        .flashcard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-box {
            width: 200px;
        }

        .flashcard-actions {
            display: flex;
            gap: 5px;
        }

        .btn-sm {
            font-size: 0.8rem;
            padding: 0.2rem 0.5rem;
        }

        .flashcard-card {
            border: 1px solid #ced4da;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .flashcard-card-header {
            background-color: #fff;
            padding: 10px 15px;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            align-items: center;
        }

        .flashcard-card-title {
            font-weight: bold;
            margin-left: 10px;
        }

        .flashcard-card-body {
            background-color: #fff;
            padding: 20px;
            text-align: center;
            min-height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .flashcard-card-footer {
            background-color: #f9f9f9;
            padding: 10px 15px;
            border-top: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .flashcard-notes {
            font-size: 0.9rem;
        }

        .no-cards {
            color: #6c757d;
            font-style: italic;
        }

        .front-card {
            border: 1px solid #ced4da;
            border-radius: 5px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: white;
            text-align: center;
        }

        /* Target ONLY elements within newCardModal */

        #newCardModal .modal-content,
        #editCardModal .modal-content {
            border-radius: 10px;
            font-family: sans-serif;
        }

        #newCardModal .modal-header,
        #editCardModal .modal-header {
            border-bottom: 1px solid #dee2e6;
            padding: 20px 30px 10px;
        }

        #newCardModal .modal-title,
        #editCardModal .modal-title {
            font-weight: bold;
        }

        #newCardModal .modal-body {
            padding: 20px 30px;
        }

        #newCardModal .card-container,
        #editCardModal .card-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        #newCardModal .card,
        #editCardModal .card {
            border: 1px solid #ced4da;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        #newCardModal .card-header,
        #editCardModal .card-header {
            background-color: #f0f0f0;
            border-bottom: none;
            padding: 10px 15px;
            text-align: center;
            font-weight: 500;
        }

        #newCardModal .card-body,
        #editCardModal .card-body {
            padding: 20px;
            height: 300px;
            width: 350px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        #newCardModal .form-control,
        #editCardModal .form-control {
            border-radius: 5px;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        #newCardModal .tag-input,
        #editCardModal .tag-input {
            margin-top: 20px;
        }

        #newCardModal .modal-footer,
        #editCardModal .modal-footer {
            border-top: 1px solid #dee2e6;
            padding: 10px 30px 20px;
            display: flex;
            justify-content: flex-end;
        }

        #newCardModal .btn,
        #editCardModal .btn {
            border-radius: 5px;
            padding: 8px 20px;
        }

        #newCardModal .front-card-content,
        #newCardModal .back-card-content,
        #editCardModal .back-card-content,
        #editCardModal .front-card-content {
            width: 100%;
            height: 100%;
            border: none;
            resize: none;
            text-align: center;
            padding: 10px;
            box-sizing: border-box;
        }

        #newCardModal .notes-section,
        #editCardModal .notes-section {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        #newCardModal .notes-icon,
        #editCardModal .notes-icon {
            background-color: #28a745;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
        }

        #newCardModal .notes-content {}

        .modal-xl {
            max-width: 900px;
            width: 60%;
            margin: 0 auto;
        }

        .card .ck-editor {
            width: 100%;
        }

        .card .ck-editor__editable {
            min-height: 200px;
        }

        .front-card-content,
        .back-card-content {
            width: 100%;
            height: 100%;
            border: none;
            resize: none;
            text-align: left;
            padding: 10px;
            box-sizing: border-box;
            font-size: 1rem;
            font-family: sans-serif;
        }

        #flashcardModal .modal-content {
            padding: 20px;
        }

        #flashcardModal .modal-header {
            display: flex;
            align-items: center;
            border-bottom: none;
            padding-bottom: 0;
        }

        #flashcardModal .modal-title {
            flex-grow: 1;
            font-weight: normal;
        }

        #flashcardModal .modal-header .btn-close {
            margin-left: auto;
        }

        #flashcardModal .badge {
            margin-right: 10px;
            background-color: #dc3545;
        }

        #flashcardModal .star-icon {
            font-size: 1.5rem;
            margin-left: 10px;
            color: gold;
        }

        #flashcardModal .tab-button {
            padding: 8px 16px;
            border: 1px solid #ced4da;
            background-color: #f8f9fa;
            color: #495057;
            cursor: pointer;
            border-radius: 0;
            margin: 0;
        }

        #flashcardModal .tab-button.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        #flashcardModal .tab-button+.tab-button {
            margin-left: 5px;
        }

        #flashcardModal .flashcard-content {
            padding: 20px;
            border: 1px solid #ced4da;
            margin-top: 10px;
            min-height: 100px;
            border-radius: 0;
        }

        #flashcardModal .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        #flashcardModal .nav-buttons .btn {
            border-radius: 0;
        }

        #flashcardModal .modal-footer {
            border-top: none;
            padding-top: 0;
            display: flex;
            justify-content: space-between;
        }

        #flashcardModal .modal-footer .page-item .page-link {
            border-radius: 0;
        }

        #flashcardModal .modal-footer span {
            margin-left: auto;
        }

        #flashcardModal .dropdown .dropdown-toggle {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
            color: #495057;
            border-radius: 0;
            padding: 5px 10px;
            font-size: 14px;
        }

        #flashcardModal .dropdown-menu {
            border-radius: 0;
        }

        #editCardModal .card-body {
            width: 400px !important;
        }

        body.dark-mode {
            background-color: #121212;
            color: white;
        }

        .calculator {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 8px;
            padding: 15px;
        }

        .calculator button {
            padding: 12px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            background-color: #f1f1f1;
        }

        .calculator button.operator {
            background-color: #ff9f00;
            color: white;
        }

        .calculator button.equal {
            background-color: #28a745;
            color: white;
        }

        .calculator button.clear {
            background-color: #dc3545;
            color: white;
        }

        .calculator button.scientific {
            background-color: #007bff;
            color: white;
        }

        .calculator-display {
            font-size: 28px;
            text-align: right;
            padding: 10px;
            width: 100%;
            height: 60px;
            border: none;
            background: #f8f9fa;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .history {
            max-height: 100px;
            overflow-y: auto;
            font-size: 14px;
        }

        .tag-container {
            display: flex;
            flex-wrap: wrap;
            border: 1px solid #ccc;
            padding: 5px;
            border-radius: 5px;
            min-height: 40px;
            cursor: text;
        }

        .tag {
            background-color: wheat;
            padding: 5px 10px;
            margin: 5px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            font-size: 14px;
        }

        .tag .remove-tag {
            margin-left: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .tag-input {
            border: none;
            outline: none;
            flex-grow: 1;
            padding: 5px;
            font-size: 14px;
            min-width: 100px;
        }

        @media (max-width: 992px) {
            .question-area {
                border-right: none !important;
                border-bottom: 1px solid #dee2e6;
                max-height: 40vh;
            }

            .col1,
            .col2 {
                width: 100% !important;
            }

            .drag-handle {
                display: none !important;
            }
        }

        .validation-error {
            font-weight: 500;
            color: #dc3545;
            /* Bootstrap's danger/red */
            margin-top: 0.25rem;
            font-size: 0.9rem;
        }

        .timer-danger {
            color: red;
            font-weight: bold;
        }

        @media (max-width: 991px) {

            #newCardModal .card-body,
            #editCardModal .card-body {
                width: 100%;
                padding: 10px !important;
            }

            #newCardModal .card-body {
                width: 100% !important;
            }
        }


        @media (max-width: 768px) {
            .modal-xl {
                width: 92% !important;
            }
        }

        @media (max-width: 548px) {
            .resizable {
                height: 480px;
            }

            .footer .btn {
                margin-bottom: 20px;
            }

            .footer-feedback {
                margin-right: 30px;
                margin-top: 50px;
            }

            #newCardModal .card-container,
            #editCardModal .card-container {
                flex-direction: column;
            }

            #floatingReadButton1 {
                bottom: 85px !important;
                right: 170px !important;
                z-index: 999 !important;
            }

            #floatingReadButton2 {
                bottom: 85px !important;
                left: 120px !important;
                z-index: 999 !important;
            }

            #newCardModal .card-body,
            #editCardModal .card-body {
                width: 100%;
                padding: 10px !important;
            }

            .modal-xl {
                width: 90% !important;
            }

            .modal-content {
                z-index: 9999;
            }
        }

        @media (max-width: 398px) {
            #floatingReadButton1 {
                right: 140px !important;
            }

            #floatingReadButton2 {
                left: 110px !important;
            }

            #newCardModal .card-body,
            #editCardModal .card-body {
                width: 290px;
            }
        }

        @media (max-width: 378px) {
            .resizable {
                height: 150px;
            }
        }

        .col-md-12.question-area.resizable.col1 {
            border: none;
            height: auto !important;
        }
    </style>
</head>

<body>

    <div class="header container-fluid">
        <div class="row w-100">
            <!-- Left section (Icons) -->
            <div class="col-12 col-sm-4 d-flex justify-content-center justify-content-sm-start mb-2 mb-sm-0">
                <div class="header-icons">
                    <!--<span><i class="fas fa-bookmark mx-1"></i></span>-->
                    <span><i id="bookmarkIcon" class="fas fa-bookmark mx-1" data-question-id=""></i></span>
                    <!--<span><i class="fas fa-bolt mx-1  " data-toggle="modal" data-target="#newCardModal"></i></span>-->
                    <span><i class="fas fa-book mx-1" data-toggle="modal" data-target="#noteModal"></i></span>
                    <!--  <span>-->
                    <!--    <a href="{{ route('notes.index') }}" target="_blank">-->
                    <!--        <i class="fas fa-book mx-1"></i>-->
                    <!--    </a>-->
                    <!--</span>-->
                    <span data-bs-toggle="modal" data-bs-target="#calculatorModal"
                        style="cursor: pointer; font-size: 24px;">
                        <i class="fas fa-calculator mx-1"></i>
                    </span>
                    <span><i id="hintIcon" style="cursor: pointer;" class="far fa-lightbulb mx-1"></i></span>
                </div>
            </div>

            <!-- Center section (1/1) -->
            <div class="col-12 col-sm-4 text-center mb-2 mb-sm-0">
                <span id="currentQuestionNumber">1</span> / <span id="totalQuestionCount"><span
                        id="totalQuestionCountinner">{{ count($questions) }}</span>
                    <i class="fas fa-angle-down" data-bs-toggle="modal" data-bs-target="#myModal"
                        style="cursor: pointer;"></i>
                </span>
            </div>

            <!-- Right section (Icons + Time) -->
            <div class="col-12 col-sm-4 d-flex justify-content-center justify-content-sm-end align-items-center">
                <div class="header-icons">
                    <button class="scientific" onclick="toggleDarkMode()">🌙</button>
                    <span><i class="fas fa-expand d-none d-lg-inline mx-1" id="fullscreenBtn"></i></span>
                    <span id="helpIcon">
                        <i class="fas fa-question-circle d-none d-md-inline mx-1"></i>
                    </span>
                    <!--<span><i class="fas fa-cog mx-1"></i></span>-->
                    <span id="taskIcon">
                        <i class="fas fa-tasks mx-1" style="cursor: pointer;"></i>
                    </span>
                </div>
                <span id="timer" class="ml-2"></span>
                <input type="hidden" id="elapsed_time" name="elapsed_time" value="">
            </div>
        </div>
    </div>
    <div class="container">
        <input type="hidden" id="totalQuestions" value="{{ count($questions) }}">
        @php

            // Sort questions by id (ascending)
            $sortedQuestions = collect($questions)->sortBy('id')->values();
            $groupedByPassageId = [];
            $isPassages = 0;
            foreach ($sortedQuestions as $question) {
                if (!empty($question['passages']) && isset($question['passages'][0]['id'])) {
                    $passageId = $question['passages'][0]['id'];
                    $isPassages = 1;
                    // Initialize array if not already
                    if (!isset($groupedByPassageId[$passageId])) {
                        $groupedByPassageId[$passageId] = [];
                    }

                    $groupedByPassageId[$passageId][] = $question;
                }
            }
            if ($subject != 'english') {
                $isPassages = 0;
            }
        @endphp
        @php $i = 0; @endphp
        @php
            $allPassages = [];
            foreach ($questions as $q) {
                if (!empty($q['passages'])) {
                    foreach ($q['passages'] as $p) {
                        $allPassages[$p['id']] = $p;
                    }
                }
            }
        @endphp
        @if ($subject == 'english' && $test->wp_test == '' && $isPassages == 1)
            {{-- ✅ English with passages - Show all questions at once --}}
            <div class="question-item" data-index="0" data-hint="English Test" data-question-id="english-bulk"
                style="display: none;">
                    <div class="col-md-12 question-area english resizable col1">
                         <div style="text-align: center;">
            <strong>ENGLISH PRACTICE TEST</strong><br><br>
            <strong>45 Minutes – 75 Questions</strong><br><br>
            </div>
                    <strong>DIRECTIONS:</strong> In the passage that follows, certain words and phrases are underlined
                    and numbered. In the right-hand column, you will find alternatives for the underlined part. In most
                    cases, you are to choose the one that best expresses the idea, makes the statement appropriate for
                    standard written English, or is worded most consistently with the style and tone of the passage as a
                    whole. If you think the original version is best, choose "NO CHANGE," which will always be either
                    answer choice A or F. In some cases, you will find in the right-hand column a question about the
                    underlined portion or by a number in a box. For some questions, you should read beyond the indicated
                    portion before you answer. You are to choose the best answer to the question.
                </div>
                <hr>
                <div class="row">
              
                    
                    <div class="col-md-6 question-area english resizable col1">
                        {{-- Show first passage content --}}
                        @if (!empty($questions[0]['passages']))
                            @foreach ($allPassages as $passage)
                                <div class="passage-container specialContent"
                                    style="font-size: 20px;
    line-height: 30px; margin-bottom: 70px; ">
                                    <p>{!! $passage['content'] !!}</p>
                                </div>
                                <button class="floatingReadButton2"
                                    style="position:fixed;bottom:90px;left:30px;z-index:9999;
                    background:#007bff;color:#fff;border:none;border-radius:50%;
                    width:60px;height:60px;font-size:24px;box-shadow:0 4px 8px rgba(0,0,0,.3);">
                                    🔊
                                </button>
                            @endforeach
                        @endif
                    </div>
                    <div class="drag-handle" id="dragHandle"></div>
                    <div class="col-md-6 resizable col2 myReadDiv" id="myReadDiv">
                        @if (!empty($questions[0]['exercise']))
                            <p><strong class="me-2">Exercise:</strong>{!! $questions[0]['exercise'] !!}</p>
                        @endif

                        {{-- All questions in one form --}}
                        <form id="englishQuiz" action="{{ route('english.bulk.submit', ['test_id' => $test->id]) }}"
                            method="POST">
                            @csrf
                            @foreach ($questions as $index => $question)
                                @php

                                    $rawOptions = is_array($question['quiz_options'])
                                        ? $question['quiz_options']
                                        : json_decode($question['quiz_options'], true);

                                    $options = array_values(array_filter($rawOptions, fn($opt) => trim($opt) !== ''));

                                    $savedAnswer = $userAnswers[$question['id']] ?? null;
                                    $savedIndex = null;
                                    if ($savedAnswer !== null) {
                                        foreach ($options as $idx => $opt) {
                                            if (trim($opt) == trim($savedAnswer)) {
                                                $savedIndex = $idx;
                                                break;
                                            }
                                        }
                                    }
                                @endphp

                                <div class="question-block mb-4">
                                    <p class="mt-2"><strong>Q:{{ $index + 1 }}</strong> {!! $question['title'] !!}</p>


                                    @foreach ($options as $optIndex => $option)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="answers[{{ $question['id'] }}]" value="{{ chr(65 + $optIndex) }}"
                                                id="q{{ $question['id'] }}o{{ $optIndex }}"
                                                @checked($savedIndex !== null && $savedIndex == $optIndex)>

                                            <label class="form-check-label"
                                                for="q{{ $question['id'] }}o{{ $optIndex }}">
                                                <strong>{{ chr(65 + $optIndex) }}.</strong>


                                                @if (\Illuminate\Support\Str::contains($option, '<img'))
                                                    {!! $option !!}
                                                @else
                                                    {{ trim($option) }}
                                                @endif
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                            
                            {{-- Add hidden time_spent fields for each question --}}
                            @foreach ($questions as $question)
                                <input type="hidden" name="time_spent[{{ $question['id'] }}]" id="time_spent_{{ $question['id'] }}" value="0">
                            @endforeach

                            <div class="text-center mt-4 mb-5" style="margin-bottom: 80px !important;">
                                <button type="submit" class="btn btn-primary btn-lg px-5 submitBtn">Save All</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                $('#totalQuestionCountinner').text({{ count($questions) }});
                $('#totalQuestions').val({{ count($questions) }});
            </script>
        @else
            @php
                $sortedQuestions = collect($questions)->sortBy('id')->values();
            @endphp
            @foreach ($sortedQuestions as $index => $question)
                @php
                    $options = is_array($question['quiz_options'])
                        ? $question['quiz_options']
                        : json_decode($question['quiz_options'], true);
                    $savedAnswer = $userAnswers[$question['id']] ?? null;
                    $savedIndex = null;
                    if ($savedAnswer !== null && is_array($options)) {
                        foreach ($options as $idx => $opt) {
                            if (trim($opt) == trim($savedAnswer)) {
                                $savedIndex = $idx;
                                break;
                            }
                        }
                    }
                @endphp
                <div class="question-item" data-index="{{ $index }}"
                    data-hint="{{ $question['hint'] ?? 'No hint available' }}"
                    data-question-id="{{ $question['id'] }}" style="display: none;">
                    <div class="row">
                        @if (!empty($question['passages']))
                            <div class="row">
                                <div class="col-md-6 question-area resizable col1">
                                    @foreach ($question['passages'] as $passage)
                                        <div class="passage-container" id="specialContent">
                                            <p>{!! $passage['content'] !!}</p>
                                        </div>
                                        <button id="floatingReadButton2"
                                            style="position: fixed; bottom: 90px; left: 30px; z-index: 9999; background-color: #007bff; color: white; border: none; border-radius: 50%; width: 60px; height: 60px; font-size: 24px; box-shadow: 0 4px 8px rgba(0,0,0,0.3); cursor: pointer;">
                                            🔊
                                        </button>
                                    @endforeach
                                </div>
                                <div class="drag-handle" id="dragHandle"></div>
                                <div class="col-md-6 resizable col2 myReadDiv" id="myReadDiv">
                                    @if (!empty($question['exercise']))
                                        <p><strong class="me-2">Exercise:</strong>{!! $question['exercise'] !!}</p>
                                    @endif
                                    <p class="mt-2"><strong>Q:</strong> {!! $question['title'] !!}</p>
                                    
                                    @php
    $content = $question['content'] ?? '';
@endphp

                                    @if ($content && strip_tags($content) !== $content)
    {!! $content !!}                                 
@else
    {{ $content }}                                 
@endif
                                    
                                    @if (!empty($options) && count($options) > 0)
                                        <ul class="options-list">
                                            @php

                                                $cleanOptions = array_values(
                                                    array_filter($options, fn($opt) => trim($opt) !== ''),
                                                );
                                            @endphp

                                            @foreach ($cleanOptions as $key => $option)
                                                <li>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio"
                                                            name="user_answer_{{ $index }}"
                                                            value="{{ chr(65 + $key) }}"
                                                            id="option_{{ $index }}_{{ $key }}"
                                                            @checked($savedIndex !== null && $savedIndex == $key)>

                                                        <label class="form-check-label"
                                                            for="option_{{ $index }}_{{ $key }}">
                                                            <strong>{{ chr(65 + $key) }}.</strong>

                                                            @if (\Illuminate\Support\Str::contains($option, '<img'))
                                                                {!! $option !!}
                                                            @else
                                                                {{ trim($option) }}
                                                            @endif
                                                        </label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="text-muted">No options available.</p>
                                    @endif
                                    <form id="quizForm"
                                        action="{{ route('launch-test', ['test_id' => $test->id, 'question_id' => $question['id']]) }}"
                                        method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary mt-3 submitBtn submitNext" id="saveNextBtn">
                                         <span class="btn-text">Save & Next</span>
                                         <span class="btn-loader d-none"><i class="fa fa-spinner fa-spin"></i></span>
                                            </button>
                                    </form>
                                    <div id="feedbackAlert_{{ $index }}"
                                        class="alert d-none custom-alert mt-3"></div>
                                    <div class="tab-pane fade show active" id="explanation_{{ $index }}">
                                        {{ $question['explanation'] ?? '' }}
                                    </div>
                                </div>
                            </div>
                        @else
                            @if (!empty($question['directions']))
                                @foreach ($question['directions'] as $directions)
                                    <p>{!! $directions['content'] !!}</p>
                                    <hr>
                                @endforeach
                            @endif
                            <div class="col-md-12 question-area resizable col1 myReadDiv">
                                @if (!empty($question['exercise']))
                                    <p><strong class="me-2">Exercise:</strong>{!! $question['exercise'] !!}</p>
                                @endif
                                <p><strong>Q:</strong> {!! $question['title'] !!}</p>
                                
@php
    $content = $question['content'] ?? '';
    $cleanOptions = array_values(
        array_filter($options ?? [], fn($opt) => trim($opt) !== '')
    );
@endphp

@if ($content && strip_tags($content) !== $content)
    {!! $content !!}
@else
    {{ $content }}
@endif

@if (!empty($cleanOptions) && count($cleanOptions) > 0)
    {{-- Multiple Choice Options --}}
    <ul class="options-list">
        @foreach ($cleanOptions as $key => $option)
            <li>
                <div class="form-check">
                    <input class="form-check-input" type="radio"
                        name="user_answer_{{ $index }}"
                        value="{{ chr(65 + $key) }}"
                        id="option_{{ $index }}_{{ $key }}"
                        @checked($savedIndex !== null && $savedIndex == $key)>

                    <label class="form-check-label" for="option_{{ $index }}_{{ $key }}">
                        <strong>{{ chr(65 + $key) }}.</strong>
                        @if (\Illuminate\Support\Str::contains($option, '<img'))
                            {!! $option !!}
                        @else
                            {{ trim($option) }}
                        @endif
                    </label>
                </div>
            </li>
        @endforeach
    </ul>
@else
    {{-- Subjective Answer (Textarea + Final Answer) --}}
    <div class="form-group mt-3">
        @if ($test->subject_type !== 'English')
            <label for="user_answer_textarea_{{ $index }}">Your Solution:</label>
            <textarea name="user_answer_textarea_{{ $index }}" id="user_answer_textarea_{{ $index }}"
                class="form-control trumbowyg-editor" rows="4"></textarea>
        @endif

        <label for="user_answer_input_{{ $index }}" class="mt-2">Your Final Answer:</label>
        <input type="text" name="user_answer_input_{{ $index }}"
            id="user_answer_input_{{ $index }}"
            class="form-control short-answer-input">
    </div>
@endif
                                <form id="quizForm"
                                    action="{{ route('launch-test', ['test_id' => $test->id, 'question_id' => $question['id']]) }}"
                                    method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary mt-3 submitBtn submitNext">Save &
                                        Next</button>
                                </form>
                                <div id="feedbackAlert_{{ $index }}" class="alert d-none custom-alert mt-3">
                                </div>
                                @if (!empty($question['explanation']))
                                    <div class="mt-3">
                                        <strong>Explanation:</strong>
                                        <p>{{ $question['explanation'] }}</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
            <script>
                $('#totalQuestionCountinner').text({{ count($questions) }});
                $('#totalQuestions').val({{ count($questions) }});
            </script>
        @endif
    </div>
    </div>
    <button id="floatingReadButton1"
        style="
    position: fixed;
    bottom: 90px;
    right: 30px;
    z-index: 9999;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    font-size: 24px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.3);
    cursor: pointer;
">
        🔊
    </button>
    <footer class="footer">
        <div class="footer-left">
            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#endExamModal">
                <i class="fas fa-times-circle"></i> End
            </button>
            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#suspendExamModal"
                data-test-id="{{ $test->id }}">
                <i class="fas fa-pause-circle"></i> Suspend
            </button>

        </div>
        <div class="footer-feedback text-primary fw-bold" data-bs-toggle="modal" data-bs-target="#feedbackModal"
            style="cursor: pointer;">
            <i class="fas fa-exclamation-circle"></i> Feedback
        </div>
        <div class="footer-right footer-nav">
            <div class="navigation-buttons mt-3">
                <button id="prevQuestion" class="btn btn-primary" disabled>Previous</button>
                <button id="nextQuestion" class="btn btn-success nextQuestion">Next</button>
            </div>
        </div>
    </footer>

    {{-- flashcard modal  --}}
    <div class="modal fade" id="newCardModal" tabindex="-1" aria-labelledby="newCardModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newCardModalLabel">Flashcards</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="CardForm">
                        @csrf
                        <div class="mb-3">
                            <div class="input-group" style="width: 50%;">
                                <select class="form-select" name="deck" id="deck-dropdown">
                                    <option value="">Select a Deck</option>
                                    <option value="create_deck">+ Create a Deck</option>
                                    @foreach ($decks as $singleDeck)
                                        <option value="{{ $singleDeck->id }}">{{ $singleDeck->deck_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="card-container">
                            <div class="card">
                                <div class="card-header front-header">Front</div>
                                <div class="card-body">
                                    <textarea class="form-control front-card-content tinymce-editor" placeholder="Max 2000 characters allowed"
                                        id="editor1"></textarea>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header back-header">Back</div>
                                <div class="card-body">
                                    <textarea class="form-control back-card-content tinymce-editor" placeholder="Max 2000 characters allowed"
                                        id="editor2"></textarea>
                                </div>
                            </div>
                        </div>


                        <div class="notes-section">
                            <div class="notes-icon">N</div>
                            <div class="notes-content">
                                Notes
                            </div>
                        </div>

                        <div class="tag-input-container">
                            <div class="tag-container" onclick="focusInput()">
                                <input type="text" id="tag-input" class="tag-input" placeholder="Enter tags...">
                            </div>
                            <input type="hidden" id="tag-values" name="tags">
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- deck model --}}
    <div class="modal fade" id="createDeckModal" tabindex="-1" aria-labelledby="createDeckModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="deckForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createDeckModalLabel">Create Deck</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">


                        <div class="mb-3">
                            <label for="deckName" class="form-label">Deck Name</label>
                            <input type="text" class="form-control" id="deckName" placeholder="Enter deck name">
                            <div class="invalid-feedback" id="deckNameError"></div>
                        </div>

                        <!-- Color Selection -->
                        <div class="mb-3">
                            <label class="form-label">Choose Color</label>
                            <div class="d-flex flex-wrap gap-2">
                                <div class="color-circle" style="background-color: #63B3ED;"
                                    onclick="selectColor('#63B3ED')"></div>
                                <div class="color-circle" style="background-color: #EF5350;"
                                    onclick="selectColor('#EF5350')"></div>
                                <div class="color-circle" style="background-color: #FB8C00;"
                                    onclick="selectColor('#FB8C00')"></div>
                                <div class="color-circle" style="background-color: #FDD835;"
                                    onclick="selectColor('#FDD835')"></div>
                                <div class="color-circle" style="background-color: #AB47BC;"
                                    onclick="selectColor('#AB47BC')"></div>

                                <div class="color-circle" style="background-color: #7E57C2;"
                                    onclick="selectColor('#7E57C2')"></div>
                                <div class="color-circle" style="background-color: #757575;"
                                    onclick="selectColor('#757575')"></div>
                                <div class="color-circle" style="background-color: #D84315;"
                                    onclick="selectColor('#D84315')"></div>
                                <div class="color-circle" style="background-color: #FF80AB;"
                                    onclick="selectColor('#FF80AB')"></div>

                            </div>
                            <input type="hidden" id="selectedColor" value="">
                            <div class="invalid-feedback" id="deckColorError"></div>
                        </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </div>
    </form>
    </div>
    </div>

    {{-- notes modal  --}}
    <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="noteModalLabel">My Notebook</h5> <button type="button"
                        class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 id="editorTitle" class="card-title">Getting Started</h4>
                                        <form id="noteForm">
                                            @csrf
                                            <input type="hidden" id="noteId">
                                            <input type="text" id="title" class="form-control mb-2"
                                                placeholder="Title">
                                            <span class="text-danger error-title"></span>
                                            <textarea id="ckeditor" class=" tinymce-editor"></textarea>
                                            <span class="text-danger error-content"></span>
                                            <div><button type="submit" class="btn btn-success mt-2">Save</button>
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
    </div>


    {{-- questions status  --}}
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Navigator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive-md">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Question</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody id="questionStatusBody">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- feedback modal  --}}
    <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="feedbackModalLabel">Feedback</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">We value your feedback. Please share your thoughts below:</p>
                    <form id="feedbackForm">
                        <input type="hidden" id="test_id" value="{{ $test->id }}">
                        <div class="mb-3">
                            @if (isset($test))
                                <textarea class="form-control" id="feedbackText" rows="4" placeholder="Write your feedback here...">{{ $test->feedback }}</textarea>
                            @else
                                <textarea class="form-control" id="feedbackText" rows="4" placeholder="Write your feedback here..."></textarea>
                            @endif


                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="techIssue">
                            <label class="form-check-label" for="techIssue">
                                Report a technical issue
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="submitFeedback">Submit Feedback</button>
                </div>
            </div>
        </div>
    </div>

    {{-- end test  --}}
    <div class="modal fade" id="endExamModal" tabindex="-1" aria-labelledby="endExamModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="endExamModalLabel">End Test</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p>Do you want to end this exam?</p>
                    <p>You can resume previous attempts anytime, but only view access is allowed—no changes can be made.
                    </p>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="confirmEndExam">Yes</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="userId" value="{{ auth()->id() }}">
    <input type="hidden" id="testId" value="{{ $test->id }}">
    {{-- suspend modal --}}
    <div class="modal fade" id="suspendExamModal" tabindex="-1" aria-labelledby="suspendExamModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header bg-warning">
                    <h5 class="modal-title" id="suspendExamModalLabel">Suspend Test</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    You are about to suspend this exam.<br><br>
                    Do you want to suspend this exam?
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>

                    <!-- Dynamic delete form -->
                    <form id="suspendForm" method="POST" style="display:inline;"
                        data-route="{{ route('tests.suspendDestroy', ['id' => '__ID__']) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Yes</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- hint modal  --}}
    <div class="modal fade" id="hintModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hint</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="hintText">No hint available.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Calculator Modal -->
    <div class="modal fade" id="calculatorModal" tabindex="-1" aria-labelledby="calculatorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="calculatorModalLabel">Scientific Calculator</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Display -->
                    <input type="text" id="calcDisplay" class="calculator-display" readonly>

                    <!-- Calculation History -->
                    <div class="history mt-2 p-2 border rounded" id="history"></div>

                    <!-- Calculator Buttons -->
                    <div class="calculator">
                        <button class="clear" onclick="clearDisplay()">C</button>
                        <button onclick="appendToDisplay('%')">%</button>
                        <button onclick="appendToDisplay('/')">÷</button>
                        <button class="operator" onclick="appendToDisplay('*')">×</button>
                        <button class="operator" onclick="appendToDisplay('-')">−</button>

                        <button onclick="appendToDisplay('7')">7</button>
                        <button onclick="appendToDisplay('8')">8</button>
                        <button onclick="appendToDisplay('9')">9</button>
                        <button class="operator" onclick="appendToDisplay('+')">+</button>
                        <button class="scientific" onclick="appendToDisplay('Math.PI')">π</button>

                        <button onclick="appendToDisplay('4')">4</button>
                        <button onclick="appendToDisplay('5')">5</button>
                        <button onclick="appendToDisplay('6')">6</button>
                        <button class="scientific" onclick="appendToDisplay('Math.sqrt(')">√</button>
                        <button class="scientific" onclick="appendToDisplay('Math.log(')">log</button>

                        <button onclick="appendToDisplay('1')">1</button>
                        <button onclick="appendToDisplay('2')">2</button>
                        <button onclick="appendToDisplay('3')">3</button>
                        <button class="scientific" onclick="appendToDisplay('Math.sin(')">sin</button>
                        <button class="scientific" onclick="appendToDisplay('Math.cos(')">cos</button>

                        <button class="number" onclick="appendToDisplay('0')" style="grid-column: span 2;">0</button>
                        <button onclick="appendToDisplay('.')">.</button>
                        <button class="equal" onclick="calculateResult()">=</button>
                        <button class="scientific" onclick="appendToDisplay('Math.tan(')">tan</button>
                        <button class="scientific" onclick="appendToDisplay('Math.exp(')">e^x</button>

                        <button class="scientific" onclick="appendToDisplay('factorial(')">x!</button>
                        <!--<button class="scientific" onclick="toggleDarkMode()">🌙</button>-->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Keyboard  Popup Content -->
    <div id="keyboardPopup" class="popup">
        <div class="popup-header">
            <span>Keyboard Shortcuts</span>
            <button class="close-btn" onclick="closePopup()">×</button>
        </div>
        <div class="shortcut">
            <span class="shortcut-key">a, b, c, d</span> Answer choice selector
        </div>
        <div class="shortcut">
            <span class="shortcut-key">Alt + p</span> Previous question
        </div>
        <div class="shortcut">
            <span class="shortcut-key">Alt + n</span> Next question
        </div>
        <div class="shortcut">
            <span class="shortcut-key">Alt + c</span> Close window
        </div>
        <div class="shortcut">
            <span class="shortcut-key">Alt + v</span> Navigator
        </div>
        <div class="shortcut">
            <span class="shortcut-key">F11</span> Full Screen
        </div>
        <div class="shortcut">
            <span class="shortcut-key">Alt + m</span> Mark question
        </div>
        <div class="shortcut">
            <span class="shortcut-key">Alt + f</span> Feedback
        </div>
        <div class="shortcut">
            <span class="shortcut-key">Alt + u</span> Calculator
        </div>
    </div>


    <!-- Bootstrap Modal -->
    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-warning text-black">
                    <h5 class="modal-title" id="warningModalLabel">Warning</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Edit Test Mode feature is available during test mode only.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="timeUpModal" tabindex="-1" aria-labelledby="timeUpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="timeUpModalLabel">
                        <i class="bi bi-alarm-fill me-2"></i>Time's Up!
                    </h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="fs-5 fw-bold text-danger">Your exam time has ended.</p>
                    <p>Please click below to view your results.</p>
                    <img src="https://cdn-icons-png.flaticon.com/512/565/565547.png" alt="Time Up" width="80"
                        class="mb-3">
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger px-4" id="confirmTimeUpBtn">
                        <i class="bi bi-check-circle me-1"></i> OK, Show Result
                    </button>
                </div>
            </div>
        </div>
    </div>



    <!-- Bootstrap JS (Include this if not already added) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById("taskIcon").addEventListener("click", function() {
            var myModal = new bootstrap.Modal(document.getElementById("warningModal"));
            myModal.show();
        });

        document.getElementById("okButton").addEventListener("click", function() {
            var warningModal = new bootstrap.Modal(document.getElementById("warningPopup"));
            warningModal.hide(); // Hides the modal
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.trumbowyg-editor').trumbowyg();
        });

        //flashcard
        function selectColor(color) {
            document.getElementById('selectedColor').value = color;
            document.getElementById("deckName").style.border = `3px solid ${color}`;
            document.getElementById('deckColorError').textContent = '';
            document.querySelectorAll('.color-circle').forEach(circle => circle.classList.remove('is-invalid', 'selected'));

            event.target.classList.add('selected');
        }

        // hint
        document.addEventListener("DOMContentLoaded", function() {
            const hintIcon = document.getElementById("hintIcon");
            const hintText = document.getElementById("hintText");

            hintIcon.addEventListener("click", function() {
                // Find the currently visible question
                const activeQuestion = document.querySelector(
                    ".question-item:not([style*='display: none'])");

                if (activeQuestion) {
                    const hint = activeQuestion.getAttribute("data-hint") || "No hint available.";
                    hintText.textContent = hint; // Update modal content

                    // Show the modal
                    const hintModal = new bootstrap.Modal(document.getElementById("hintModal"));
                    hintModal.show();
                }
            });
        });

        //calculator
        function appendToDisplay(value) {
            document.getElementById('calcDisplay').value += value;
        }

        function clearDisplay() {
            document.getElementById('calcDisplay').value = '';
        }

        function calculateResult() {
            try {
                let expression = document.getElementById('calcDisplay').value;
                let result = eval(expression);

                document.getElementById('calcDisplay').value = result;
                addToHistory(expression + " = " + result);
            } catch (error) {
                document.getElementById('calcDisplay').value = 'Error';
            }
        }

        function addToHistory(entry) {
            let historyDiv = document.getElementById('history');
            let newEntry = document.createElement('p');
            newEntry.textContent = entry;
            historyDiv.prepend(newEntry);
        }

        function factorial(n) {
            return n === 0 ? 1 : n * factorial(n - 1);
        }

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }


        document.addEventListener("DOMContentLoaded", function() {
            const deckDropdown = document.getElementById("deck-dropdown");

            deckDropdown.addEventListener("change", function() {
                if (this.value === "create_deck") {
                    let createDeckModal = new bootstrap.Modal(document.getElementById("createDeckModal"));
                    createDeckModal.show();
                    setTimeout(() => {
                        this.value = "";
                    }, 500);
                }
            });
        });


        $(document).ready(function() {

            let tags = [];

            $("#tag-input").on("keypress", function(event) {
                if (event.key === " " || event.key === "Enter") {
                    event.preventDefault();
                    let tagText = $(this).val().trim();
                    if (tagText !== "" && !tags.includes(tagText)) {
                        tags.push(tagText);
                        updateTags();
                    }
                    $(this).val("");
                }
            });

            function updateTags() {
                let tagContainer = $(".tag-container");
                tagContainer.find(".tag").remove();

                tags.forEach((tag, index) => {
                    let tagElement = $(
                        `<div class="tag">${tag} <span class="remove-tag" data-index="${index}">×</span></div>`
                    );
                    tagContainer.prepend(tagElement);
                });

                $("#tag-values").val(tags.join(","));
            }

            $(document).on("click", ".remove-tag", function() {
                let index = $(this).data("index");
                tags.splice(index, 1);
                updateTags();
            });

            window.focusInput = function() {
                $("#tag-input").focus();
            };

            $('#CardForm').submit(function(e) {
                e.preventDefault();

                let deckId = $('#deck-dropdown').val();
                let frontContent = tinymce.get("editor1").getContent();
                let backContent = tinymce.get("editor2").getContent();
                let tags = $('#tag-values').val();

                if (!deckId) {
                    alert("Please select a deck.");
                    return;
                }

                console.log("Tags: ", tags);

                $.ajax({
                    url: "{{ route('newcards.store') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        deck_id: deckId,
                        front_content: frontContent,
                        back_content: backContent,
                        tags: tags
                    },
                    success: function(response) {
                        $('#newCardModal').modal('hide');
                        $('#CardForm')[0].reset();
                        window.location.reload();
                    },
                    error: function(xhr) {
                        alert("Error saving Card");
                    }
                });
            });

            $('#deckForm').submit(function(e) {
                e.preventDefault();
                let deckName = $('#deckName').val();
                let deckColor = $('#selectedColor').val();

                $.ajax({
                    url: "{{ route('flashcards.store') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        deck_name: deckName,
                        deck_color: deckColor
                    },
                    success: function(response) {
                        $('#createDeckModal').modal('hide');
                        $('#deckForm')[0].reset();
                        $('.color-circle').removeClass('is-invalid'); // Remove error styles
                        $('#deckName').removeClass('is-invalid');
                        window.location.reload();
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) { // Validation error
                            var errors = xhr.responseJSON.errors;

                            if (errors.deck_name) {
                                $('#deckName').addClass('is-invalid');
                                $('#deckNameError').text(errors.deck_name[0]);
                            } else {
                                $('#deckName').removeClass('is-invalid');
                                $('#deckNameError').text('');
                            }

                            if (errors.deck_color) {
                                $('#selectedColor').addClass('is-invalid');
                                $('#deckColorError').text(errors.deck_color[0]);
                            } else {
                                $('#selectedColor').removeClass('is-invalid');
                                $('#deckColorError').text('');
                            }
                        } else {
                            alert("Error creating deck");
                        }
                    }
                });
            });

            $('#submitFeedback').click(function() {
                var test_id = $('#test_id').val();
                var feedback = $('#feedbackText').val();

                if (feedback.trim() === '') {
                    alert('Please enter your feedback.');
                    return;
                }

                $.ajax({
                    url: "{{ route('submit.feedback') }}",
                    type: 'POST',
                    data: {
                        test_id: test_id,
                        feedback: feedback,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        // alert(response.message);
                        $('#feedbackModal').modal('hide');
                        $('#feedbackForm')[0].reset();
                        window.location.reload();
                    },
                    error: function(xhr) {
                        alert('Error submitting feedback. Please try again.');
                    }
                });
            });
            $('#noteForm').submit(function(e) {
                e.preventDefault();

                let formData = {
                    _token: '{{ csrf_token() }}',
                    title: $('#title').val(),
                    content: tinymce.get('ckeditor').getContent(),
                };

                $.ajax({
                    url: "{{ route('notes.modal.save') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#noteModal').modal('hide');
                            window.location.reload();
                        }
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;

                        // Clear previous errors
                        $('.text-danger').text('');

                        if (errors) {
                            if (errors.title) {
                                $('.error-title').text(errors.title[0]);
                            }
                            if (errors.content) {
                                $('.error-content').text(errors.content[0]);
                            }
                        }
                    }
                });
            });



            // bookmark questions

            $("#bookmarkIcon").on("click", function() {
                let $icon = $(this);
                let questionId = $icon.data("question-id");
                let testId = "{{ $test->id }}";

                // Toggle bookmark visually
                $icon.toggleClass("text-warning"); // Optional: style with yellow color if bookmarked

                // Determine bookmark status: 1 = bookmarked, 0 = not
                let isBookmarked = $icon.hasClass("text-warning") ? 1 : 0;

                $.ajax({
                    url: "{{ route('bookmark.question') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        test_id: testId,
                        question_id: questionId,
                        bookmark: isBookmarked
                    },
                    success: function(res) {
                        console.log("Bookmark updated:", res.message);
                        window.location.reload();
                    },
                    error: function(err) {
                        console.error("Error updating bookmark:", err.responseText);
                    }
                });
            });



        });


        //resizer
        document.getElementById('fullscreenBtn').addEventListener('click', function() {
            let elem = document.documentElement;
            let icon = this.querySelector('i');

            if (!document.fullscreenElement) {
                if (elem.requestFullscreen) {
                    elem.requestFullscreen();
                } else if (elem.mozRequestFullScreen) {
                    elem.mozRequestFullScreen();
                } else if (elem.webkitRequestFullscreen) {
                    elem.webkitRequestFullscreen();
                } else if (elem.msRequestFullscreen) {
                    elem.msRequestFullscreen();
                }
                icon.classList.remove('fa-expand');
                icon.classList.add('fa-compress');
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
                icon.classList.remove('fa-compress');
                icon.classList.add('fa-expand');
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            var tabLinks = document.querySelectorAll('.nav-tabs .nav-link');

            tabLinks.forEach(function(tab) {
                tab.addEventListener("click", function(event) {
                    event.preventDefault(); // Prevent URL change
                    var target = this.getAttribute("href");

                    // Remove active class from all tabs
                    tabLinks.forEach(t => t.classList.remove("active"));
                    this.classList.add("active");

                    // Hide all tab content
                    document.querySelectorAll(".tab-pane").forEach(pane => {
                        pane.classList.remove("show", "active");
                    });

                    // Show selected tab content
                    document.querySelector(target).classList.add("show", "active");
                });
            });
        });

        // resize
        document.addEventListener("DOMContentLoaded", function() {
            const col1Elements = document.querySelectorAll(".col1");
            const col2Elements = document.querySelectorAll(".col2");
            const dragHandles = document.querySelectorAll(".drag-handle");

            dragHandles.forEach((dragHandle, index) => {
                const col1 = col1Elements[index];
                const col2 = col2Elements[index];

                let isResizing = false;

                dragHandle.addEventListener("mousedown", function(e) {
                    isResizing = true;
                    document.addEventListener("mousemove", resizeColumns);
                    document.addEventListener("mouseup", stopResizing);
                });

                function resizeColumns(e) {
                    if (!isResizing) return;

                    let container = dragHandle.parentElement; // Get the parent container
                    let containerRect = container.getBoundingClientRect();
                    let newCol1Width = e.clientX - containerRect.left;
                    let totalWidth = containerRect.width;
                    let newCol2Width = totalWidth - newCol1Width - dragHandle.offsetWidth;

                    // Prevent extreme sizes
                    if (newCol1Width > 200 && newCol2Width > 200) {
                        col1.style.width = newCol1Width + "px";
                        col2.style.width = newCol2Width + "px";
                    }
                }

                function stopResizing() {
                    isResizing = false;
                    document.removeEventListener("mousemove", resizeColumns);
                    document.removeEventListener("mouseup", stopResizing);
                }
            });
        });


        const suspendExamModal = document.getElementById('suspendExamModal');
        suspendExamModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const testId = button.getAttribute('data-test-id');

            const form = document.getElementById('suspendForm');
            const routeTemplate = form.getAttribute('data-route');
            form.action = routeTemplate.replace('__ID__', testId);
        });




        document.addEventListener('DOMContentLoaded', function() {
            let quizForms = document.querySelectorAll('.question-item form');
            var testId = "{{ $test->id }}";
            quizForms.forEach((quizForm) => {
                // Skip the English bulk form - it has its own validation
                if (quizForm.id === 'englishQuiz') {
                    return;
                }

                let questionItem = quizForm.closest('.question-item');
                let questionIndex = questionItem.getAttribute('data-index');
                let questionId = questionItem.getAttribute('data-question-id');
                let textInput = questionItem.querySelector(`#user_answer_input_${questionIndex}`);
                let textArea = questionItem.querySelector(`#user_answer_textarea_${questionIndex}`);

                // Step 1: Disable input initially
                if (textArea) {
                    // ✅ No textarea found — disable input initially
                    textInput.disabled = true;
                }

                if (textArea) {
                    $(textArea).on('tbwinit', function() {
                        let editorDiv = questionItem.querySelector('.trumbowyg-editor');
                        console.log('Editor ready:', editorDiv);

                        // Initial check (e.g. from localStorage or restored value)
                        if (editorDiv.innerText.trim() !== '') {
                            textInput.disabled = false;
                        }

                        editorDiv.addEventListener('input', () => {
                            textInput.disabled = editorDiv.innerText.trim() === '';
                        });

                        editorDiv.addEventListener('focus', () => {
                            textInput.disabled = false;
                        });
                    });
                }

                let storedData = JSON.parse(localStorage.getItem(`answered_${testId}_${questionId}`));
                if (storedData) {
                    // Restore selected option (radio) if any
                    let selectedOption = questionItem.querySelector(
                        `input[value="${storedData.userAnswer}"]`);
                    if (selectedOption) {
                        selectedOption.checked = true;
                    } else {
                        // If no radio selected, restore to text input or textarea
                        let textInput = questionItem.querySelector(`#user_answer_input_${questionIndex}`);
                        if (textInput) {
                            textInput.value = storedData.userAnswer;
                        } else {
                            let textArea = questionItem.querySelector(
                                `#user_answer_textarea_${questionIndex}`);
                            if (textArea) {
                                textArea.value = storedData.userAnswer;
                            }
                        }
                    }

                    // Always disable inputs and submit button if answer saved
                    disableOptions(questionItem);

                    // restoreAlert(questionIndex, storedData.isCorrect, storedData.correctAnswer, storedData
                    //     .explanation, storedData.accuracy, storedData.timeSpent);
                }

                const submitBtn = quizForm.querySelector('.submitNext');

                submitBtn.addEventListener('click', function(event) {
                    event.preventDefault();

                    let selectedAnswer = questionItem.querySelector(
                        'input[name="user_answer_' + questionIndex + '"]:checked'
                    );

                    let userAnswer = null;
                    let textAnswerInput = questionItem.querySelector(
                        `#user_answer_input_${questionIndex}`);
                    let textAreaAnswer = questionItem.querySelector(
                        `#user_answer_textarea_${questionIndex}`);
                    let isTextAreaVisible = textAreaAnswer && textAreaAnswer.offsetParent !== null;

                    if (selectedAnswer) {
                        userAnswer = selectedAnswer.value;
                    } else {
                        // Check for text input answer
                        let textAnswerInput = questionItem.querySelector(
                            `#user_answer_input_${questionIndex}`);
                        if (textAnswerInput && textAnswerInput.value.trim() !== '') {
                            userAnswer = textAnswerInput.value.trim();
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Required!',
                                text: 'Please provide an answer before submitting.',
                                confirmButtonColor: '#3085d6',
                                width: '300px',
                            });
                            return;
                        }
                    }
                    
                        let csrfToken = document.querySelector('input[name="_token"]').value;
    
                        let startTime = localStorage.getItem(
                            `questionStartTime_${testId}_${questionId}`);
                        let elapsedTime = startTime ? Math.floor((Date.now() - startTime) / 1000) : 0;
    
                        fetch(quizForm.action, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken
                                },
                                body: JSON.stringify({
                                    user_answer: userAnswer,
                                    elapsed_time: elapsedTime
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.error) {
                                    alert("Error: " + data.error);
                                    return;
                                }
    
                                // showAlert(questionIndex, data.isCorrect, data.correctAnswer, data.explanation, data.accuracy, data.timeSpent);
    
                                localStorage.setItem(`answered_${testId}_${questionId}`, JSON
                                    .stringify({
                                        userAnswer: userAnswer,
                                        isCorrect: data.isCorrect,
                                        correctAnswer: data.correctAnswer,
                                        explanation: data.explanation,
                                        accuracy: data.accuracy,
                                        timeSpent: data.timeSpent
                                    }));
    
                                disableOptions(questionItem);
                            })
                            .catch(error => console.error("Error:", error));
                });
            });
        });

        // Improved disableOptions to disable radio, text, textarea inputs & submit button
        function disableOptions(questionItem) {
            // Disable radio inputs
            let radioOptions = questionItem.querySelectorAll('input[type="radio"]');
            radioOptions.forEach(option => option.disabled = true);

            // Disable text inputs
            let textInputs = questionItem.querySelectorAll('input[type="text"]');
            textInputs.forEach(input => {
                input.disabled = true;
            });

            // Disable textareas
            let textAreas = questionItem.querySelectorAll('textarea');
            textAreas.forEach(area => area.disabled = true);

            // Disable submit button
            let submitButton = questionItem.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Already Answered';
                submitButton.classList.add('btn-secondary');
                submitButton.classList.remove('btn-primary');
            }
        }

        // Function to check if question is already answered from database
        function checkAnsweredQuestions() {
            var testId = "{{ $test->id }}";
            var userId = {{ auth()->id() }};

            $.ajax({
                url: "{{ route('fetch.question.statuses', ['user_id' => '__USER_ID__', 'test_id' => '__TEST_ID__']) }}"
                    .replace('__USER_ID__', userId)
                    .replace('__TEST_ID__', testId),
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    let completedCount = 0;
                    let totalQuestions = data.length;

                    data.forEach(function(question) {
                        if (question.status === 'Completed') {
                            completedCount++;

                            // Find the question element and disable it
                            let questionElement = $(
                                `.question-item[data-question-id="${question.id}"]`);
                            if (questionElement.length > 0) {
                                disableOptions(questionElement[0]);

                                // Also store in localStorage for consistency
                                localStorage.setItem(`answered_${testId}_${question.id}`, JSON
                                    .stringify({
                                        userAnswer: 'Already answered',
                                        isCorrect: true,
                                        correctAnswer: 'Already answered',
                                        explanation: 'Already answered',
                                        accuracy: '100%',
                                        timeSpent: 0
                                    }));
                            }
                        }
                    });

                    // For English bulk form, check if all questions are completed
                    @if ($subject == 'english' && $test->wp_test == '' && $isPassages == 1)
                        if (completedCount === totalQuestions && totalQuestions > 0) {
                            // All questions completed, disable the bulk submit button
                            let englishSubmitBtn = $('#englishQuiz button[type="submit"]');
                            if (englishSubmitBtn.length > 0) {
                                englishSubmitBtn.prop('disabled', true);
                                englishSubmitBtn.text('Test Already Completed');
                                englishSubmitBtn.removeClass('btn-primary').addClass('btn-secondary');
                            }
                        }
                    @endif
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching question statuses:', error);
                }
            });
        }

        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = seconds % 60;
            if (mins > 0) {
                return `${mins} min ${secs} sec`;
            } else {
                return `${secs} sec`;
            }
        }

        //     function showAlert(questionIndex, isCorrect, correctAnswer, explanation, accuracy, timeSpent) {
        //         let alertBox = document.getElementById('feedbackAlert_' + questionIndex);
        //         let explanationBox = document.getElementById('explanation_' + questionIndex);

        //         let alertClass = isCorrect ? "alert-success" : "alert-danger";
        //         let formattedTime = formatTime(timeSpent); 
        //         let message = `
    //     <strong>${isCorrect ? "Correct!" : "Incorrect!"}</strong>
    //     <br>Correct Answer: <b>${correctAnswer}</b>
    //     <br>Accuracy: <b>${accuracy}</b>
    //      <br>Time: <b>${formattedTime} </b>
    // `;

        //         alertBox.className = `alert ${alertClass} mt-3`;
        //         alertBox.innerHTML = message;
        //         alertBox.classList.remove('d-none');

        //         explanationBox.innerHTML = `<h2>Explanation</h2><p>${explanation}</p>`;
        //     }

        //     function restoreAlert(questionIndex, isCorrect, correctAnswer, explanation, accuracy, timeSpent) {
        //         let alertBox = document.getElementById('feedbackAlert_' + questionIndex);
        //         let explanationBox = document.getElementById('explanation_' + questionIndex);

        //         let alertClass = isCorrect ? "alert-success" : "alert-danger";
        //          let formattedTime = formatTime(timeSpent); 
        //         let message = `
    //     <strong>${isCorrect ? "Correct!" : "Incorrect!"}</strong>
    //     <br>Correct Answer: <b>${correctAnswer}</b>
    //     <br>Accuracy: <b>${accuracy}</b>
    //     <br>Time: <b>${formattedTime} </b>
    // `;

        //         alertBox.className = `alert ${alertClass} mt-3`;
        //         alertBox.innerHTML = message;
        //         alertBox.classList.remove('d-none');

        //         explanationBox.innerHTML = `<h2>Explanation</h2><p>${explanation}</p>`;
        //     }
    </script>



    <script>
        $(document).ready(function() {
            var testId = "{{ $test->id }}";
            let storedTestId = localStorage.getItem("testId");
            let elapsedTimeKey = `elapsedTime_${testId}`;

            if (storedTestId !== testId) {
                localStorage.setItem("currentQuestionIndex", 0);
                localStorage.setItem("testId", testId);
            }

            let currentIndex = localStorage.getItem("currentQuestionIndex") ?
                parseInt(localStorage.getItem("currentQuestionIndex")) : 0;

            const totalQuestions = $(".question-item").length;
            let timerInterval;

            function showQuestion(index) {
                $(".question-item").hide();
                let questionElement = $(`[data-index='${index}']`);
                questionElement.show();
                questionElement.find(".passage-container").each(function() {
                    let highlights = $(this).find(".highlight-phrase");

                    // highlight based on index (modulo for group logic if needed)
                    let highlightToShow = index % highlights.length;

                    highlights.each(function(i) {
                        if (i === highlightToShow) {
                            $(this).css({
                                "background": "#eac1c1",
                                "border-bottom": "1px solid rgb(183, 110, 110)"
                            });
                        }
                    });
                });

                $("#currentQuestionNumber").text(index + 1);
                $("#prevQuestion").prop("disabled", index === 0);

                // $(".nextQuestion").prop("disabled", index == totalQuestions - 1);
                let modalClickedOnce = false;
                $(".submitNext").on("click", function() {
                    if (index < totalQuestions - 1) {
                        const questionItems = document.querySelectorAll(
                                                    '.question-item:not([style*="display: none"])'
                                                );
                        questionItems.forEach((questionItem, indexnum) => {

                            const selectedAnswer = questionItem.querySelector(
                                'input[name="user_answer_' + index + '"]:checked'
                            );
                        
                            if (selectedAnswer) {
                                index++;
                                showQuestion(index);
                            }
                        });
                    } else {
                        if (!modalClickedOnce) {
                            modalClickedOnce = true;
                            // First click on last question does nothing (or maybe grey out button, etc.)
                        } else {
                            $('#endExamModal').modal('show');
                        }
                    }
                });

                let questionId = questionElement.data('question-id');
                markQuestionAsSeen(questionId, testId);

                localStorage.setItem("currentQuestionIndex", index);

                localStorage.setItem(`questionStartTime_${testId}_${questionId}`, Date.now());
                updateQuestionStatuses();

                // ✅ === Update bookmark icon ===
                $("#bookmarkIcon").attr("data-question-id", questionId);

                $.ajax({
                    url: "{{ route('check.bookmark') }}", // <-- You'll create this route
                    method: "GET",
                    data: {
                        test_id: testId,
                        question_id: questionId
                    },
                    success: function(response) {
                        if (response.bookmarked) {
                            $("#bookmarkIcon").addClass("text-warning");
                        } else {
                            $("#bookmarkIcon").removeClass("text-warning");
                        }
                    }
                });
            }
            // Automatically assign highlight indexes to spans per passage
            $(".question-item").each(function() {
                let passageContainers = $(this).find(".passage-container");
                passageContainers.each(function(_, passageEl) {
                    let highlights = $(passageEl).find(".highlight-phrase");
                    highlights.each(function(i) {
                        $(this).attr("data-highlight-index", i);
                    });
                });
            });

            // First, remove all highlights
            $(".highlight-phrase").css({
                "background": "transparent",
                "border-bottom": "none"
            });





            function markQuestionAsSeen(questionId, testId) {
                $.ajax({
                    url: "{{ route('markQuestionSeen') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        test_id: testId,
                        question_id: questionId
                    },
                    success: function(response) {
                        // console.log("Question marked as seen:", response);
                    },
                    error: function(xhr) {
                        console.error("Error marking question as seen:", xhr.responseText);
                    }
                });
            }

            showQuestion(currentIndex);

            @if ($subject == 'english' && $test->wp_test == '' && $isPassages == 1) // ✅ English with passages - Show all questions at once
            $(".question-item[data-question-id='english-bulk']").show();
            $("#currentQuestionNumber").text("All");
            $("#totalQuestionCount").text({{ count($questions) }});
            
            // Disable navigation buttons for English
            $("#prevQuestion, #nextQuestion").prop("disabled", true);
            
            // Check if English test is already completed
            checkAnsweredQuestions();
            @else
            // Check for already answered questions for non-English subjects
            checkAnsweredQuestions(); @endif

            $(".nextQuestion").click(function() {
                if (currentIndex < totalQuestions - 1) {
                    currentIndex++;
                    showQuestion(currentIndex);
                }
            });

            $(".submitNext").click(function() {
                if (currentIndex < totalQuestions - 1) {
                    const questionItems = document.querySelectorAll(
                                                    '.question-item:not([style*="display: none"])'
                                                );
                    questionItems.forEach((questionItem, index) => {

                    const selectedAnswer = questionItem.querySelector(
                        'input[name="user_answer_' + currentIndex + '"]:checked'
                    );
                
                    if (selectedAnswer) {
                        currentIndex++;
                        showQuestion(currentIndex);
                    }
                    
                    });
                }
            });

            $("#prevQuestion").click(function() {
                if (currentIndex > 0) {
                    currentIndex--;
                    showQuestion(currentIndex);
                }
            });

            // function startTimer() {
            //     clearTimeout(timerInterval);

            //     let storedElapsedTime = localStorage.getItem(elapsedTimeKey);
            //     let elapsedTime = storedElapsedTime ? parseInt(storedElapsedTime) : 0;

            //     function updateTimer() {
            //         let hours = Math.floor(elapsedTime / 3600);
            //         let minutes = Math.floor((elapsedTime % 3600) / 60);
            //         let seconds = elapsedTime % 60;

            //         let formattedTime =
            //             (hours < 10 ? "0" : "") + hours + ":" +
            //             (minutes < 10 ? "0" : "") + minutes + ":" +
            //             (seconds < 10 ? "0" : "") + seconds;

            //         $("#timer").text(formattedTime);
            //         $("#elapsed_time").val(elapsedTime);

            //         elapsedTime++; 
            //         localStorage.setItem(elapsedTimeKey, elapsedTime); 

            //         timerInterval = setTimeout(updateTimer, 1000);
            //     }

            //     updateTimer();
            // }
            const hasLimit = @json($totalTimeInSeconds !== null);
            const totalTimeInSeconds = hasLimit ? @json($totalTimeInSeconds) : null;

            var userId = {{ auth()->id() }};
            var testId = "{{ $test->id }}";
            const testEndedKey = "testEnded_" + testId;
            const elapsedTimeKeyend = "elapsedTimeend_" + testId;
            const isTestEnded = localStorage.getItem(testEndedKey);

            if (hasLimit && isTestEnded === 'true') {
                $("#timer").text("Time's up!");
                disableTestForm();

                // ✅ Show modal even after refresh
                const modal = new bootstrap.Modal(document.getElementById('timeUpModal'));
                modal.show();

                document.getElementById("confirmTimeUpBtn").addEventListener("click", function() {
                    const redirectUrl = resultTestRoute
                        .replace('__USER_ID__', userId)
                        .replace('__TEST_ID__', testId);
                    window.location.href = redirectUrl;
                });
            } else {
                startTimer();
            }

            function startTimer() {
                clearTimeout(timerInterval);

                let storedElapsedTime = localStorage.getItem(elapsedTimeKeyend);
                let elapsedTime = storedElapsedTime ? parseInt(storedElapsedTime) : 0;

                function updateTimer() {
                    const remainingTime = hasLimit ? totalTimeInSeconds - elapsedTime : elapsedTime;

                    if (hasLimit && remainingTime <= 0) {
                        clearTimeout(timerInterval);
                        localStorage.removeItem(elapsedTimeKeyend);
                        localStorage.setItem(testEndedKey, 'true');

                        disableTestForm();

                        const modal = new bootstrap.Modal(document.getElementById('timeUpModal'));
                        modal.show();

                        document.getElementById("confirmTimeUpBtn").addEventListener("click", function() {
                            const redirectUrl = resultTestRoute
                                .replace('__USER_ID__', userId)
                                .replace('__TEST_ID__', testId);
                            window.location.href = redirectUrl;
                        });

                        return;
                    }

                    const displayTime = hasLimit ? remainingTime : elapsedTime;

                    const hours = Math.floor(displayTime / 3600);
                    const minutes = Math.floor((displayTime % 3600) / 60);
                    const seconds = displayTime % 60;

                    const formattedTime =
                        (hours < 10 ? "0" : "") + hours + ":" +
                        (minutes < 10 ? "0" : "") + minutes + ":" +
                        (seconds < 10 ? "0" : "") + seconds;

                    if (hasLimit && remainingTime <= 60) {
                        $("#timer").css("color", "red");
                        $("#timer").addClass("timer-danger");
                    }

                    $("#timer").text(formattedTime);
                    $("#elapsed_time").val(elapsedTime);

                    elapsedTime++;
                    localStorage.setItem(elapsedTimeKeyend, elapsedTime);

                    timerInterval = setTimeout(updateTimer, 1000);
                }

                updateTimer();
            }

            function disableTestForm() {
                $(".submitBtn, .form-check-input").prop("disabled", true);
            }

            $(window).on("beforeunload", function() {
                clearTimeout(timerInterval);
            });



            function updateQuestionStatuses() {
                var userId = {{ auth()->id() }};
                
                var testId = "{{ $test->id }}";

                var url =
                    "{{ route('fetch.question.statuses', ['user_id' => '__USER_ID__', 'test_id' => '__TEST_ID__']) }}"
                    .replace('__USER_ID__', userId)
                    .replace('__TEST_ID__', testId);

                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(data) {

                        $('#questionStatusBody').empty();

                        if (data.length === 0) {
                            $('#questionStatusBody').append(
                                "<tr><td colspan='2'>No questions found</td></tr>");
                            return;
                        }
                        var sortedQuestions = data;
                        @if ($subject != 'english')
                            sortedQuestions = data.sort((a, b) => b.id - a.id);
                        @endif

                        sortedQuestions.forEach(function(question, index) {
                            <?php if($maxPassages >0){ ?>


                            if (question.ispassage != "") {
                                var row = `<tr>
                                                     <td>${index + 1}  ${question.bookmark}</td>
                                                    <td>${question.status}</td>
                                                    </tr>`;
                                $('#questionStatusBody').append(row);
                            } else {
                                var row = `<tr>
                                                     <td>${index + 1}  ${question.bookmark}</td>
                                                    <td>${question.status}</td>
                                                    </tr>`;
                                $('#questionStatusBody').append(row);
                            }

                            <?php  }else{   ?>
                            var row = `<tr>
                                            <td>${index + 1}  ${question.bookmark}</td>
                                            <td>${question.status}</td>
                                        </tr>`;
                            $('#questionStatusBody').append(row);
                            <?php } ?>
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching question statuses:', error);
                    }
                });
            }

            updateQuestionStatuses();
            // setInterval(updateQuestionStatuses, 3000);
            

            // var resultTestRoute = @json(route('test.result', ['user_id' => '__USER_ID__', 'test_id' => '__TEST_ID__']));
            var resultTestRoute = @json(route('results.index', ['user_id' => '__USER_ID__', 'test_id' => '__TEST_ID__']));


            // $("#confirmEndExam").click(function() {
            //     let userId = $("#userId").val();
            //     let testId = $("#testId").val();
            //     const elapsedTime = localStorage.getItem(elapsedTimeKey) || 0;


            //         localStorage.setItem(elapsedTimeKey, elapsedTime);

            //     let redirectUrl = resultTestRoute.replace('__USER_ID__', userId).replace('__TEST_ID__',
            //         testId);

            //     // Redirect to the result page
            //     window.location.href = redirectUrl;
            // });
            
            // old code 
            
            // $("#confirmEndExam").click(function() {
            //     let userId = $("#userId").val() || "{{ auth()->id() }}";
            //     let testId = $("#testId").val() || "{{ $test->id }}";

            //     const testEndedKey = "testEnded_" + testId;
            //     const elapsedTimeKey = "elapsedTimeend_" + testId;
            //     const elapsedTime = localStorage.getItem(elapsedTimeKey) || 0;

            //     localStorage.setItem(testEndedKey, 'true');
            //     localStorage.setItem(elapsedTimeKey, elapsedTime);

            //     disableTestForm();

            //     let redirectUrl = resultTestRoute
            //         .replace('__USER_ID__', userId)
            //         .replace('__TEST_ID__', testId);
            //     window.location.href = redirectUrl;
            // });
            
            $("#confirmEndExam").click(function() {
                let userId = $("#userId").val() || "{{ auth()->id() }}";
                let testId = $("#testId").val() || "{{ $test->id }}";

                const testEndedKey = "testEnded_" + testId;
                const elapsedTimeKey = "elapsedTimeend_" + testId;
                // const elapsedTime = localStorage.getItem(elapsedTimeKey) || 0;

                localStorage.setItem(testEndedKey, 'true');
                // localStorage.setItem(elapsedTimeKey, elapsedTime);

                // ✅ Timer ko local storage se hatao
                localStorage.removeItem(elapsedTimeKey);

                disableTestForm();

                let redirectUrl = resultTestRoute
                    .replace('__USER_ID__', userId)
                    .replace('__TEST_ID__', testId);
                window.location.href = redirectUrl;
            });
        });
    </script>
    <script>
        // document.addEventListener('DOMContentLoaded', function () {
        //     // Disable right-click
        //     document.addEventListener('contextmenu', function (e) {
        //         e.preventDefault();
        //     });

        //     // Disable text selection
        //     document.addEventListener('selectstart', function (e) {
        //         e.preventDefault();
        //     });

        //     // Disable copy shortcut (Ctrl+C or Command+C)
        //     document.addEventListener('copy', function (e) {
        //         e.preventDefault();
        //     });

        //     // Disable specific keyboard shortcuts (Ctrl+C, Ctrl+U, Ctrl+Shift+I, F12)
        //     document.addEventListener('keydown', function (e) {
        //         if ((e.ctrlKey && (e.key === 'c' || e.key === 'u')) || 
        //             (e.ctrlKey && e.shiftKey && e.key === 'I') || 
        //             e.key === 'F12') {
        //             e.preventDefault();
        //         }
        //     });
        // });
    </script>


    <script>
        // Open popup when clicking the help icon
        document.getElementById("helpIcon").addEventListener("click", function() {
            document.getElementById("keyboardPopup").style.display = "block";
        });

        // Close popup function
        function closePopup() {
            document.getElementById("keyboardPopup").style.display = "none";
        }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Normalize acronyms, vs, and Q:
        //   function normalizeSpeechText(text) {
        //     text = text.replace(/\bvs\.?\b/gi, "versus");
        //     text = text.replace(/\bQ\s*:\s*(\d+)\b/gi, (_, num) => `Question number ${num}`);
        //     text = text.replace(/\bQ\s*:\b/gi, "Question");

        //     const knownAcronyms = ['ACT', 'SAT', 'FBI', 'NASA', 'HTML', 'USA'];
        //     knownAcronyms.forEach(acronym => {
        //         const regex = new RegExp('\\b' + acronym + '\\b', 'g');
        //         const spaced = acronym.split('').join(' ');
        //         text = text.replace(regex, spaced);
        //     });

        //     return text;
        // }

        function normalizeSpeechText(text) {
            // Remove extra spaces and trim
            text = text.replace(/\s+/g, ' ').trim();

            // Replace common labels
            text = text.replace(/\bvs\.?\b/gi, "versus");
            text = text.replace(/\bQ\s*:\s*(\d+)?/gi, (_, num) => num ? `Question number ${num}` : "Question");

            // Expand acronyms
            const knownAcronyms = ['ACT', 'SAT', 'FBI', 'NASA', 'HTML', 'USA'];
            knownAcronyms.forEach(acronym => {
                const regex = new RegExp(`\\b${acronym}\\b`, 'gi');
                const spaced = acronym.split('').join(' ');
                text = text.replace(regex, spaced);
            });

            // Handle superscript ², ³ (for x², x³)
            text = text.replace(/([a-zA-Z])\s*[\u00B2]/g, '$1 squared');
            text = text.replace(/([a-zA-Z])\s*[\u00B3]/g, '$1 cubed');

            // Handle powers like x^2, x^3, x^n
            text = text.replace(/([a-zA-Z])\^2/g, '$1 squared');
            text = text.replace(/([a-zA-Z])\^3/g, '$1 cubed');
            text = text.replace(/([a-zA-Z])\^(\d+)/g, '$1 to the power $2');

            // Handle fractions like 3x/2, x/2, 3/2
            text = text.replace(/(\d+)([a-zA-Z])\/(\d+)/g, '$1 $2 over $3');
            text = text.replace(/([a-zA-Z])\/(\d+)/g, '$1 over $2');
            text = text.replace(/(\d+)\s*\/\s*(\d+)/g, '$1 over $2');

            // Replace basic math symbols
            text = text.replace(/=/g, ' equals ');
            text = text.replace(/\+/g, ' plus ');
            text = text.replace(/-/g, ' minus ');
            text = text.replace(/\*/g, ' times ');
            text = text.replace(/\//g, ' over ');

            // Read ? as "what"
            text = text.replace(/\?/g, " what");

            // Remove extra spaces again
            text = text.replace(/\s+/g, ' ').trim();

            return text;
        }



        // Generic reader function builder
        function createReader(buttonId, contentDivId) {
            let currentUtterance = null;
            let isReading = false;
            let isPaused = false;

            function getText() {
                // Special handling for non-English subjects: find visible question's .myReadDiv
                if (contentDivId === 'myReadDiv') {
                    const activeQuestion = document.querySelector('.question-item:not([style*="display: none"])');
                    if (activeQuestion) {
                        const targetDiv = activeQuestion.querySelector('.myReadDiv');
                        return targetDiv ? normalizeSpeechText(targetDiv.innerText.trim()) : "No readable content found.";
                    }
                    return "No readable content found.";
                } else {
                    // Default fallback for other ids
                    const targetDiv = document.getElementById(contentDivId);
                    return targetDiv ? normalizeSpeechText(targetDiv.innerText.trim()) : "No readable content found.";
                }
            }

            function toggleRead() {
                const button = document.getElementById(buttonId);

                if (isPaused) {
                window.speechSynthesis.resume();
                    isPaused = false;
                button.innerText = "⏹️";
                return;
            }

                if (isReading && !isPaused) {
                    window.speechSynthesis.pause();
                    isPaused = true;
                    button.innerText = "▶️";
                    return;
                }

            if (window.speechSynthesis.speaking) {
                window.speechSynthesis.cancel();
            }

                const textContent = getText();
            if (!textContent || textContent === "No readable content found.") {
                    alert("Nothing to read — check that #" + contentDivId + " exists and has text.");
                return;
            }

                currentUtterance = new SpeechSynthesisUtterance(textContent);
                currentUtterance.lang = 'en-US';
                currentUtterance.rate = 1;

                currentUtterance.onend = function() {
                button.innerText = "🔊";
                    isReading = false;
                    isPaused = false;
            };

                window.speechSynthesis.speak(currentUtterance);
            button.innerText = "⏹️";
                isReading = true;
                isPaused = false;
        }

            return toggleRead;
        }

        // On page load, connect buttons
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('floatingReadButton1')?.addEventListener('click', createReader(
                'floatingReadButton1', 'myReadDiv'));
            document.getElementById('floatingReadButton2')?.addEventListener('click', createReader(
                'floatingReadButton2', 'specialContent'));
            document.getElementById('question_say')?.addEventListener('click', createReader('question_say',
                'questionReadDiv'));
        });

        // Stop all speech when user navigates away
        window.addEventListener('beforeunload', function() {
            window.speechSynthesis.cancel();
        });
    </script>


    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.4/dist/katex.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.4/dist/contrib/auto-render.min.js" onload="renderMathInElement(document.body, {
                                                        delimiters: [
                                                            {left: '$$', right: '$$', display: true},
                                                            {left: '$', right: '$', display: false},
                                                            {left: '\\(', right: '\\)', display: false},
                                                            {left: '\\[', right: '\\]', display: true}
                                                        ]
                                                    });"></script>

    //
    <script>
        // (function() {
        //     var testId = "{{ $test->id }}";
        //     // Remove main test keys
        //     localStorage.removeItem("testEnded_" + testId);
        //     localStorage.removeItem("elapsedTimeend_" + testId);
        //     localStorage.removeItem("currentQuestionIndex");
        //     localStorage.removeItem("testId");
        //     // Remove all answered_ and questionStartTime_ keys for this test
        //     for (var key in localStorage) {
        //         if (key.startsWith("answered_" + testId + "_")) {
        //             localStorage.removeItem(key);
        //         }
        //         if (key.startsWith("questionStartTime_" + testId + "_")) {
        //             localStorage.removeItem(key);
        //         }
        //     }
        // })();
        // 
    </script>

    <script>
        $(document).ready(function() {
            $('.trumbowyg-editor').trumbowyg();
        });

        // ✅ English bulk form submission
        $(document).ready(function() {
            $('#englishQuiz').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                let answers = {};
                let timeSpent = {};
                
                // Get current elapsed time from timer
                let elapsedTime = parseInt($('#elapsed_time').val()) || 0;
                let totalQuestions = $(this).find('.question-block').length;
                
                // If elapsed time seems too low, calculate manually
                if (elapsedTime < 60) { // Less than 1 minute
                    let testStartTime = localStorage.getItem('testStartTime_' + "{{ $test->id }}");
                    if (testStartTime) {
                        elapsedTime = Math.floor((Date.now() - parseInt(testStartTime)) / 1000);
                    }
                }
                
                let avgTimePerQuestion = totalQuestions > 0 ? Math.round(elapsedTime / totalQuestions) : 0;
                
                // Debug: Log the values
                console.log('Elapsed Time:', elapsedTime);
                console.log('Total Questions:', totalQuestions);
                console.log('Avg Time Per Question:', avgTimePerQuestion);
                
                // Collect all selected answers
                $(this).find('input[type="radio"]:checked').each(function() {
                    let name = $(this).attr('name');
                    let value = $(this).val();
                    let questionId = name.match(/answers\[(\d+)\]/)[1];
                    answers[questionId] = value;
                });
                
                // Set time_spent for each question (equal distribution)
                $(this).find('input[type="hidden"][id^="time_spent_"]').each(function() {
                    let qid = $(this).attr('id').replace('time_spent_', '');
                    $(this).val(avgTimePerQuestion);
                    timeSpent[qid] = avgTimePerQuestion;
                });
                
                // Check if all questions are answered
                let answeredQuestions = Object.keys(answers).length;
                if (answeredQuestions < totalQuestions) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Incomplete Answers',
                        text: 'Please answer all questions before submitting.',
                        confirmButtonColor: '#3085d6',
                    });
                    return;
                }
                
                // Submit via AJAX
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        answers: answers,
                        time_spent: timeSpent,
                        elapsed_time: elapsedTime
                    },
                    success: function(response) {
                        if (response.success) {
                            // Show endExamModal
                            const endExamModal = new bootstrap.Modal(document.getElementById('endExamModal'));
                            endExamModal.show();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.error || 'Something went wrong!',
                                confirmButtonColor: '#3085d6',
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Failed to submit answers. Please try again.',
                            confirmButtonColor: '#3085d6',
                        });
                    }
                });
            });
        });
    </script>

    <script>
        // Function to restore answers from backend (TestResult) and sync to UI/localStorage
        function restoreUserAnswers() {
            var testId = "{{ $test->id }}";
            var userId = {{ auth()->id() }};
            $.ajax({
                url: "{{ route('fetch.question.statuses', ['user_id' => '__USER_ID__', 'test_id' => '__TEST_ID__']) }}"
                    .replace('__USER_ID__', userId)
                    .replace('__TEST_ID__', testId),
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    data.forEach(function(question) {
                        if (question.status === 'Completed') {
                            // Fetch the answer from TestResult (need to expose user_answer in API or blade)
                            // We'll use a data attribute for now (see below for blade change if needed)
                            let userAnswer = question.user_answer || null;
                            let questionId = question.id;
                            let questionElement = $(`.question-item[data-question-id="${questionId}"]`);
                            if (userAnswer && questionElement.length > 0) {
                                // For radio buttons
                                let radio = questionElement.find(
                                    `input[type='radio'][value='${userAnswer}']`);
                                if (radio.length > 0) {
                                    radio.prop('checked', true);
                                }
                                // For text input/textarea (if any)
                                let textInput = questionElement.find('input[type="text"]');
                                if (textInput.length > 0) {
                                    textInput.val(userAnswer);
                                }
                                let textArea = questionElement.find('textarea');
                                if (textArea.length > 0) {
                                    textArea.val(userAnswer);
                                }
                                // Store in localStorage for consistency
                                localStorage.setItem(`answered_${testId}_${questionId}`, JSON
                                    .stringify({
                                        userAnswer: userAnswer,
                                        isCorrect: question.isCorrect || false,
                                        correctAnswer: question.correctAnswer || '',
                                        explanation: question.explanation || '',
                                        accuracy: question.accuracy || '',
                                        timeSpent: question.timeSpent || 0
                                    }));
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error restoring answers:', error);
                }
            });
        }

        // Call restoreUserAnswers on page load
        $(document).ready(function() {
            restoreUserAnswers();
        });
    </script>

    <script>
        // Only for English bulk passage/questions view
        // Pause/Resume/Stop support for floatingReadButton2
        (function() {
            let currentUtterance2 = null;
            let isReading2 = false;
            let isPaused2 = false;

            // Function to convert Roman numerals in PASSAGE headings to numbers
            function convertRomanToNumber(text) {
                const romanMap = {
                    'I': 1,
                    'II': 2,
                    'III': 3,
                    'IV': 4,
                    'V': 5,
                    'VI': 6,
                    'VII': 7,
                    'VIII': 8,
                    'IX': 9,
                    'X': 10
                };
                return text.replace(/\bPASSAGE (I{1,3}|IV|V|VI{0,3}|IX|X)\b/g, (match, roman) => {
                    return 'PASSAGE ' + romanMap[roman];
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('.floatingReadButton2').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        // If already reading and not paused, pause
                        if (isReading2 && !isPaused2) {
                            window.speechSynthesis.pause();
                            isPaused2 = true;
                            btn.innerText = '▶️';
                            return;
                        }

                        // If paused, resume
                        if (isPaused2) {
                            window.speechSynthesis.resume();
                            isPaused2 = false;
                            btn.innerText = '⏸️';
                            return;
                        }

                        // If already speaking, cancel and start new
                        if (window.speechSynthesis.speaking) {
                            window.speechSynthesis.cancel();
                        }

                        // Find the nearest passage-container for this button
                        const passageDiv = btn.closest(
                                '.col-md-6.question-area.english.resizable.col1')
                            .querySelector('.passage-container.specialContent');

                        let textContent = passageDiv ? passageDiv.innerText.trim() :
                            "No readable content found.";
                        if (!textContent || textContent === "No readable content found.") {
                            alert("Nothing to read — check that passage exists and has text.");
                            return;
                        }

                        // Replace Roman numerals in PASSAGE headings with numbers
                        textContent = convertRomanToNumber(textContent);

                        currentUtterance2 = new SpeechSynthesisUtterance(textContent);
                        currentUtterance2.lang = 'en-US';
                        currentUtterance2.rate = 1;
                        currentUtterance2.onend = function() {
                            btn.innerText = '🔊';
                            isReading2 = false;
                            isPaused2 = false;
                        };
                        window.speechSynthesis.speak(currentUtterance2);
                        btn.innerText = '⏸️';
                        isReading2 = true;
                        isPaused2 = false;
                    });
                });
            });

            // Cancel speech on page unload
            window.addEventListener('beforeunload', function() {
                window.speechSynthesis.cancel();
            });
        })();
        

let is_request_completed = 0;

/* ---------- BUTTON UI HANDLER ---------- */
function updateSubmitButton() {
    if (is_request_completed > 0) {
        $('.submitNext').prop('disabled', true);
        $('.submitNext').addClass('disabled');
        $('#saveNextBtn .btn-text').addClass('d-none');
        $('#saveNextBtn .btn-loader').removeClass('d-none');
    } else {
        $('.submitNext').prop('disabled', false);
        $('.submitNext').removeClass('disabled');
        $('#saveNextBtn .btn-text').removeClass('d-none');
        $('#saveNextBtn .btn-loader').addClass('d-none');
    }
}

/* ---------- JQUERY AJAX TRACKING ---------- */
$(document).ajaxSend(function () {
    is_request_completed++;
    updateSubmitButton();
});

$(document).ajaxComplete(function () {
    is_request_completed = Math.max(0, is_request_completed - 1);
    updateSubmitButton();
});

/* ---------- FETCH TRACKING (GLOBAL OVERRIDE) ---------- */
(function () {
    const originalFetch = window.fetch;

    window.fetch = function (...args) {
        is_request_completed++;
        updateSubmitButton();

        return originalFetch.apply(this, args)
            .catch(err => {
                throw err;
            })
            .finally(() => {
                is_request_completed = Math.max(0, is_request_completed - 1);
                updateSubmitButton();
            });
    };
})();

/* ---------- SAFETY CHECK (OPTIONAL) ---------- */
setInterval(updateSubmitButton, 3000);

    </script>


</body>

</html>
