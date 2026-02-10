@extends('admin.layouts.app')
@section('title', 'Luciderp | Help')
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
    </style>
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Help</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4>How to Use</h4>
                            <div class="accordion accordion-primary" id="accordion-one">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#default-collapseOne" aria-expanded="false"
                                            aria-controls="default-collapseOne">
                                            How do I begin using my subscription? 

                                        </button>
                                    </h2>
                                    <div id="default-collapseOne" class="accordion-collapse collapse "
                                        data-bs-parent="#accordion-one">
                                        <div class="accordion-body">
                                            <p>Once you have purchased a subscription from UWorld, it will be available for activation from your&nbsp;<strong>My Account</strong>&nbsp;page on our website. &nbsp;You will need to sign in to your account every time you wish to access your subscription.</p>
                                            <P>To get started using the subscription, first click on Activate and acknowledge the displayed Terms of Use.  You will then see the option to Launch your subscription (you may need to refresh the page if you do not immediately see the Launch option).  When you click on Launch, you will be taken to the installation instructions for that subscription.</P>
                                            <P>For STEP1 and STEP2 CK Question Bank subscriptions, click on the installation instructions for Windows or Mac, whichever is applicable to your system.  All other subscriptions are browser-based and accessible via the web, so you should click on Launch.</P>
                                            <P>When you open a new Question Bank subscription, you will be presented with several different options for test creation.  Each question mode and test mode will provide a slightly different testing experience.  For new users, we recommend that you first generate tests in Unused Question Mode.  This will ensure that you see every question in the Question Bank at least once.  For more information on test creation options, please see the "How can I create a test?" section below. </P>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#default-collapseTwo" aria-expanded="false"
                                            aria-controls="default-collapseTwo">
                                            How do I begin using my subscription? 
                                        </button>
                                    </h2>
                                    <div id="default-collapseTwo" class="accordion-collapse collapse"
                                        data-bs-parent="#accordion-one">
                                        <div class="accordion-body">
                                            <p>Generate unlimited, customizable tests from UWorld's Question Banks. Here's how:</p>
                                        
                                            <p><strong>Test Modes</strong></p>
                                            <ul>
                                                <li><strong>Tutor:</strong> After you answer a question, the interface displays the correct answer and corresponding answer choice explanation(s). Explanations are retained for the remainder of the test. If you skip a question, the interface will NOT display its explanation(s). Deselecting "Tutor Mode" hides explanations until the test ends.</li>
                                                <li><strong>Timed:</strong> The test automatically ends when a predetermined time-constraint elapses.</li>
                                                <li><strong>Time Accommodation:</strong> Adjust the timer to simulate exam-like constraints.</li>
                                            </ul>
                                        
                                            <p><strong>Question Modes</strong></p>
                                            <p>Selecting Standard Questions Mode gives you the option to generate a test from a pool of questions by category—unused, incorrect, marked, omitted, or correct.</p>
                                            <ul>
                                                <li><strong>Unused:</strong> Questions that you have not used in previous tests. We recommend that new users begin with unused questions to guarantee that they see every question in the Question Bank at least once.</li>
                                                <li><strong>Incorrect:</strong> Questions that you answered incorrectly from previous tests.</li>
                                                <li><strong>Marked:</strong> Marked questions from previous tests. To add a question to the marked questions pool, click the checkbox beside the red flag icon during testing or review.</li>
                                                <li><strong>Omitted:</strong> Omitted questions from previous tests. If you answer the question correctly, it will be added to the correct question pool. If you answer the question incorrectly, it will be added to the incorrect question pool.</li>
                                                <li><strong>Correct:</strong> Questions that were answered correctly from previous tests. If you answer a question incorrectly, it will be removed from the correct question pool. If it is answered correctly again, it will be added back to the correct question pool.</li>
                                            </ul>
                                        
                                            <p>We've designed Custom Question Mode for study groups that want to share identical tests while using their individual subscriptions. Generate a custom test or list of questions in one member's subscription and provide the Test ID or Question IDs to the group. Simply enter this ID into the appropriate field to generate an identical test.</p>
                                        
                                            <p>You may receive an error if you try to use questions that have already been used in your subscription, or one of the questions has been deleted/deactivated from the Question Bank.</p>
                                        
                                            <p><strong>To generate a test:</strong></p>
                                            <ul>
                                                <li>Select a Test Mode [Tutor, Timed]</li>
                                                <li>Select a Question Mode [Standard Mode (Unused, Incorrect, Marked, Omitted, Correct), Custom Mode (Enter Test or Question IDs)]</li>
                                                <li>Select your preferred Subject(s) followed by the System(s). The number of available questions will vary depending on which Subject and System is selected. If you do not have enough available questions, we recommend adjusting your Question Mode selection. You can view the available question count in brackets [xxxx] beside the Subjects/Systems name.</li>
                                                <li>Enter your preferred number of questions. Depending on your exam, a maximum amount of questions can be used to generate your test</li>
                                                <li>In custom question mode, provide the list of Question IDs separated by a ',' or enter the ID of a previously generated test to retrieve the question list of that test.</li>
                                                <li>Click Generate.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#default-collapseThree" aria-expanded="false"
                                            aria-controls="default-collapseThree">
                                            What features are available while taking the test? 
                                        </button>
                                    </h2>
                                    <div id="default-collapseThree" class="accordion-collapse collapse"
                                        data-bs-parent="#accordion-one">
                                        <div class="accordion-body">
                                            <p>During the test, a clock will display either the time remaining (for timed mode) or time elapsed (for untimed and tutor modes). Navigation toolbars will be displayed on the top and bottom portion of the window. These toolbars contain the Next, Previous, Normal Labs, Notes, Feedback, Suspend, and End buttons. A box for marking or unmarking the test question is also located in one of the navigation toolbars.</p>
                                
                                            <ul>
                                                <li>
                                                    <p><strong>To view the next question,</strong> click on the <strong>Next</strong> button.</p>
                                                </li>
                                                <li>
                                                    <p><strong>To view the previous question,</strong> click on the <strong>Previous</strong> button.</p>
                                                </li>
                                                <li>
                                                    <p><strong>To view the normal laboratory values,</strong> click on the <strong>Normal Labs</strong> button.</p>
                                                </li>
                                                <li>
                                                    <p><strong>To type in notes during the test,</strong> click on the <strong>Notes</strong> button. These notes can later be compiled and printed for convenient study.</p>
                                                </li>
                                                <li>
                                                    <p><strong>To provide feedback for a particular question,</strong> click on the <strong>Feedback</strong> button while viewing the question for which you need to provide feedback.</p>
                                                </li>
                                                <li>
                                                    <p><strong>To mark/unmark a question,</strong> click on the checkbox next to the red flag icon.</p>
                                                </li>
                                                <li>
                                                    <p><strong>To pause the test at any time,</strong> click on the <strong>Suspend</strong> button. Your answers will be saved and stored. You may resume taking the test at a later date and time.</p>
                                                </li>
                                                <li>
                                                    <p><strong>To end the test at any time,</strong> click on the <strong>End</strong> button. The exam will be scored as soon as it is ended.</p>
                                                </li>
                                            </ul>
                                
                                            <p>Another navigation toolbar is displayed on the left side of the window. This toolbar contains the item number of each question.</p>
                                
                                            <ul>
                                                <li>
                                                    <p><strong>To directly view or answer a particular test question,</strong> click on the item number from the left navigation toolbar. This function is particularly useful during test reviews.</p>
                                                </li>
                                                <li>
                                                    <p>You can view the next question without answering the current question. Once you have answered the last question of the test, you will be prompted to either end the test or review your answers.</p>
                                                </li>
                                            </ul>
                                
                                            <p>A summary of your test results will be displayed once the test has been ended.</p>
                                
                                            <ul>
                                                <li><p>A green check mark indicates that the question is <strong>Correct</strong></p></li>
                                                <li><p>A red X indicates that the question is <strong>Incorrect</strong></p></li>
                                                <li><p>A blue exclamation point (!) indicates that the question was <strong>Omitted</strong> (skipped without answering)</p></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#default-collapseFour" aria-expanded="false"
                                            aria-controls="default-collapseFour">
                                            How can I view test results? 
                                        </button>
                                    </h2>
                                    <div id="default-collapseFour" class="accordion-collapse collapse"
                                        data-bs-parent="#accordion-one">
                                        <div class="accordion-body">
                                            <p>Once you complete a test, a summary of the completed test will automatically display when the test block is ended. This summary will show which questions were answered correctly, incorrectly, or omitted. It will also display the <strong>Avg. Score</strong>, which is calculated by averaging together the % of correct response for each question contained in the test block, and <strong>Your Score</strong>, which is the percentage of questions you answered correctly. If you wish to review individual test questions, click on <strong>Explanation</strong> beside the question you wish to review.</p>
                                
                                            <p>If you would like to go back and review an older test, go to the <strong>Previous Test</strong> section and select <strong>Review</strong> beside the test you wish to look at. You can also select <strong>Resume</strong> on any test you may have ended accidentally to correct your answers.</p>
                                
                                            <p>For a detailed view of your performance, click on <strong>Analysis</strong>. The correct, incorrect, and omitted questions will be presented graphically. If the test contained questions from all disciplines, then your performance for each discipline will be displayed.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#default-collapseFive" aria-expanded="false"
                                            aria-controls="default-collapseFive">
                                            How do I interpret my scores/performance? 
                                        </button>
                                    </h2>
                                    <div id="default-collapseFive" class="accordion-collapse collapse"
                                        data-bs-parent="#accordion-one">
                                        <div class="accordion-body">
                                            <p>The Performance section of the Question Bank displays your aggregate performance over the entire term of your subscription. It is separated into two sections, <strong>Reports</strong> and <strong>Graphs</strong>.</p>
                                
                                            <p><strong>Reports</strong> displays your Question Bank scoring in several different ways:</p>
                                
                                            <ul>
                                                <li>
                                                    <p><strong>Overall Performance:</strong> The pie graph at the top of this section displays the total number of questions you have answered correctly, incorrectly, or omitted (skipped without answering) during the term of your subscription. To the right of the pie graph is the count and percentage of your Total Correct, Total Incorrect, and Total Omitted questions. This section counts every instance of a question being answered, even repeated questions.</p>
                                                </li>
                                                <li>
                                                    <p><strong>Percentile Rank:</strong> The bell curve in this section compares your performance in the Question Bank to the performance of other active users. The <strong>Median Score</strong> is depicted by the red line, and <strong>Your Score</strong> is depicted by the green line. The percentile is the percentage of users which have scored below the line (i.e., if the Median Score is the 48th percentile, this indicates that the average user is performing better than 48% of other users).</p>
                                                </li>
                                                <li>
                                                    <p><strong>Subjects &amp; Systems:</strong> The bar charts in this section further break down your score by subject. Each bar visually represents the percentage of correct answers (green), incorrect answers (red), and omitted questions (blue). It additionally assigns a percentile rank to your performance in that subject/system.</p>
                                                </li>
                                            </ul>
                                
                                            <p><strong>Graphs</strong> displays a graphical representation of your aggregate performance.</p>
                                
                                            <ul>
                                                <li>
                                                    <p><strong>Performance by Test:</strong> This line graph displays <strong>Your Score</strong> (green), the <strong>Average Score</strong> (grey) and your overall <strong>Cumulative Performance</strong> (orange) from the first test you created to the most recent test.</p>
                                                </li>
                                                <li>
                                                    <p><strong>Performance by Date:</strong> This line graph displays the same information depicted in the Performance by Test section, ordered by the date each test was accessed.</p>
                                                </li>
                                            </ul>
                                
                                            <p>Both sub-sections of the Performance section may be printed by clicking the <strong>Printer</strong> icon in the top right corner of the page.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#default-collapseSix" aria-expanded="false"
                                            aria-controls="default-collapseSix">
                                            How do I study with my Flashcards? 
                                        </button>
                                    </h2>
                                    <div id="default-collapseSix" class="accordion-collapse collapse"
                                        data-bs-parent="#accordion-one">
                                        <div class="accordion-body">
                                            <p>Customize your study sessions with our Flashcards feature, including a "Browse" section that allows you to create and organize your flashcards, and a "Study" section that lets you review your flashcards with spaced repetition.</p>
                                
                                            <p><strong>Features Include:</strong></p>
                                
                                            <ul>
                                                <li>
                                                    <p><strong>Quick Content Transfer:</strong> A Flashcards pop-up within the test interface lets you add any UWorld content to a new or existing flashcard in mere seconds, and the cards you create will automatically be made available in your future study sessions.</p>
                                                </li>
                                                <li>
                                                    <p><strong>Filtering:</strong> When searching for a particular flashcard or organizing your decks, expanded filters (e.g., Subject, System) help you quickly identify the material you wish to review.</p>
                                                </li>
                                                <li>
                                                    <p><strong>Integrated Spaced Repetition:</strong> Customizable study sessions with spaced repetition are integrated within the Study section of the Question Bank. This feature allows you to use this proven study method with flashcards containing UWorld content.</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4>Faqs</h4>
                            <div class="accordion accordion-primary" id="accordion-two">
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#default-collapseSeven" aria-expanded="false"
                                            aria-controls="default-collapseSeven">
                                            I want to reset/delete my Question Bank test history (or) start all over again. Is this possible? 
                                        </button>
                                    </h2>
                                    <div id="default-collapseSeven" class="accordion-collapse collapse"
                                        data-bs-parent="#accordion-two">
                                        <div class="accordion-body">
                                            <p><strong>MBE Question Banks / NAPLEX Test Bank and Online Courses / MPJE and CPJE Online Courses:</strong> No resets are available for these specific products.</p>
                                
                                            <p><strong>All Other Question Banks and Courses:</strong> We offer a one-time reset option for subscriptions active for 180 days or more. Once a reset has been used, a subscription cannot be reset again, regardless of the duration remaining on the subscription or the purchase of additional renewals.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#default-collapseEight" aria-expanded="false"
                                            aria-controls="default-collapseEight">
                                            Can I access my subscriptions on a mobile device? 
                                        </button>
                                    </h2>
                                    <div id="default-collapseEight" class="accordion-collapse collapse"
                                        data-bs-parent="#accordion-two">
                                        <div class="accordion-body">
                                            <p>Access to Question Bank and Self-Assessment subscriptions is offered through our companion application for Android and iOS devices. The companion app is for convenient on-the-go access and is not intended to replace primary access from a laptop or desktop system. Refunds or other compensation will not be provided due to the inability to access the subscription from a mobile device. Please verify that your mobile device meets our system requirements.</p>
                                
                                            <p><strong>iOS and Android Apps:</strong></p>
                                
                                            <ul>
                                                <li>Medical - USMLE</li>
                                                <li>PA Prep - PA</li>
                                                <li>Boards - ABIM/ABFM</li>
                                                <li>Nursing - PN/RN/FNP</li>
                                                <li>PreMed - MCAT</li>
                                                <li>College Prep - SAT/ACT/AP</li>
                                                <li>Accounting - CPA/CMA/CIA</li>
                                                <li>Finance - CFA/CMT</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#default-collapseNine" aria-expanded="false"
                                            aria-controls="default-collapseNine">
                                            How do I reuse questions with no reset option available (to avoid repetition)? 
                                        </button>
                                    </h2>
                                    <div id="default-collapseNine" class="accordion-collapse collapse"
                                        data-bs-parent="#accordion-two">
                                        <div class="accordion-body">
                                            <p>We recommend using <strong>Marked Question Mode</strong> to redo specific questions and ensure no duplicates in future generated test blocks.</p>
                                
                                            <p>To mark a question, click the flag icon during testing or review. Once your questions are marked, you can generate new tests using Marked Question Mode.</p>
                                
                                            <p>Once a test is generated using Marked Question Mode, all questions within that test are no longer marked. If you would like to generate the same questions in a new test, you will need to mark these questions again.</p>
                                
                                            <p>You can also create tests using the <strong>Incorrect</strong> or <strong>Correct Question Modes</strong>.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#default-collapseTen" aria-expanded="false"
                                            aria-controls="default-collapseTen">
                                            Why are the images/media in the questions not loading? 
                                        </button>
                                    </h2>
                                    <div id="default-collapseTen" class="accordion-collapse collapse"
                                        data-bs-parent="#accordion-two">
                                        <div class="accordion-body">
                                            <p>This problem might arise if you lose your internet connection while course content is downloaded onto your computer. The test is downloaded on your machine while the images and media are stored on the server. Therefore, you can move from one question to another without an internet connection, but the images and media will not load. This is especially true if you are using an unstable connection.</p>
                                
                                            <p>Our Question Bank requires a reliable and stable connection to download images and save tests while communicating with our servers. Wireless connections are great in terms of offering flexibility with connection but are unreliable when providing sustained and reliable internet connectivity.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#default-collapseEleven" aria-expanded="false"
                                            aria-controls="default-collapseEleven">
                                            How can I delete a test block? 
                                        </button>
                                    </h2>
                                    <div id="default-collapseEleven" class="accordion-collapse collapse"
                                        data-bs-parent="#accordion-two">
                                        <div class="accordion-body">
                                            <p>Tests cannot be deleted once they have been generated. Suppose you have accidentally ended a test block and caused questions to be marked as omitted. In that case, you can continue the test by going to the <strong>Previous Tests</strong> section and clicking the <strong>Resume</strong> button under the Actions column next to the test you want to complete.</p>
                                
                                            <p>After creating a test, the Question Mode and number of questions cannot be changed. However, the Test Mode can be updated. It can be updated within a test or from the Previous Tests Page by selecting the <strong>Edit Test Mode</strong> button. If you want to recreate a test with your desired settings, we recommend marking all questions in the test you want to retake and then generating a new test using the <strong>Marked Question Mode</strong>.</p>
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

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script>

<script>
    let currentUtterance = null;
    let isReading = false;

    function toggleRead(elementId, button) {
        const text = document.getElementById(elementId).innerText;

        if (!isReading) {
            // If already speaking something else, stop it first
            if (window.speechSynthesis.speaking) {
                window.speechSynthesis.cancel();
            }

            currentUtterance = new SpeechSynthesisUtterance(text);
            currentUtterance.lang = 'en-US';
            currentUtterance.rate = 1;

            currentUtterance.onend = function () {
                button.innerText = "▶️ Read This";
                isReading = false;
            };

            window.speechSynthesis.speak(currentUtterance);
            button.innerText = "⏹️ Stop";
            isReading = true;
        } else {
            window.speechSynthesis.cancel();
            button.innerText = "▶️ Read This";
            isReading = false;
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        const accordionBodies = document.querySelectorAll(".accordion-body");

        accordionBodies.forEach((body, index) => {
            const uniqueId = "accordionContent" + (index + 1);
            body.setAttribute("id", uniqueId);

            const controlsDiv = document.createElement("div");
            controlsDiv.className = "controls my-3";

            controlsDiv.innerHTML = `
                <button onclick="toggleRead('${uniqueId}', this)" class="btn btn-primary btn-sm">
                    ▶️ Read This
                </button>
            `;

            body.appendChild(controlsDiv);
        });
    });
</script>

    <script></script>
@endpush
