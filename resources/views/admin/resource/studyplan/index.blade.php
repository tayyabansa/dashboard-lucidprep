@extends('admin.layouts.app')
@section('title', 'Luciderp | Study Plan')
@push('styles')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
 <link href="{{ asset('public/pflip/css/pdfflip.css') }}" rel="stylesheet" />
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
        .pdf-frame {
        border-radius: 20px; 
        overflow: hidden; 
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); 
    }

    .pdf-frame .card-body {
        padding: 0; 
    }

    iframe {
        border: none; 
    }
    #floatingReadButton{
        display:none;
    }
    #PDFF {
        height: 700px !important; 
    }
    </style>
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                        <h4>Study Plan</h4>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <!--<div class="PDFFlip" id="PDFF"-->
                            <!--    source="{{ asset('pdfs/ACT 1 Month , 2month, 3 month Study Plan.pdf') }}"-->
                            <!--    backgroundColor="#FFFFFF"-->
                            <!--    viewMode="flipbook"-->
                            <!--    enableDownload="true"-->
                            <!--    enablePrint="true">-->
                            <!--</div>-->
                            <iframe src="{{ asset('pdfs/ACT 1 Month , 2month, 3 month Study Plan.pdf') }}" width="100%" height="500px" style="border: none;"></iframe>

                        </div>
                        <button id="pdfReadButton" onclick="togglePdfVoiceReader()" style=" 
                        position: fixed;
                        bottom: 30px;
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

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.12.313/pdf.min.js"></script>
<script src="{{ asset('public/pflip/js/pdfflip.js') }}"></script>
 <script>
    const pdfVoice_pdfUrl = "{{ asset('pdfs/Lucid Prep - Digital Version [Final book] (1).pdf') }}";
    let pdfVoice_utterance = null;
    let pdfVoice_isReading = false;
    let pdfVoice_isPaused = false;

    async function pdfVoice_extractText(url, maxPages = 2) {
    const pdf = await pdfjsLib.getDocument(url).promise;
    let fullText = '';

    const pagesToRead = Math.min(pdf.numPages, maxPages);
    for (let pageNum = 1; pageNum <= pagesToRead; pageNum++) {
        const page = await pdf.getPage(pageNum);
        const content = await page.getTextContent();
        const pageText = content.items.map(item => item.str).join(' ');
        fullText += pageText + ' ';
    }

    return fullText;
}


    async function togglePdfVoiceReader() {
        const button = document.getElementById('pdfReadButton');

        if (pdfVoice_isPaused) {
            window.speechSynthesis.resume();
            pdfVoice_isPaused = false;
            button.innerText = "⏹️";
            return;
        }

        if (pdfVoice_isReading && !pdfVoice_isPaused) {
            window.speechSynthesis.pause();
            pdfVoice_isPaused = true;
            button.innerText = "▶️";
            return;
        }

        const text = await pdfVoice_extractText(pdfVoice_pdfUrl, 2); // Only first 2 pages
        if (!text) {
            alert("No text found in PDF.");
            return;
        }

        if (window.speechSynthesis.speaking) {
            window.speechSynthesis.cancel();
        }

        pdfVoice_utterance = new SpeechSynthesisUtterance(text);
        pdfVoice_utterance.lang = 'en-US';
        pdfVoice_utterance.rate = 1;

        pdfVoice_utterance.onend = function () {
            button.innerText = "🔊";
            pdfVoice_isReading = false;
            pdfVoice_isPaused = false;
        };

        window.speechSynthesis.speak(pdfVoice_utterance);
        button.innerText = "⏹️";
        pdfVoice_isReading = true;
        pdfVoice_isPaused = false;
    }

    window.addEventListener('beforeunload', function () {
        window.speechSynthesis.cancel();
    });
</script>


@endpush
