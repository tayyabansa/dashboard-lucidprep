@extends('admin.layouts.app')
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

        .left-panel {
            padding: 20px;
            border-right: 1px solid #eee;
            height: 100vh;
            /* Make left panel full height */
            overflow-y: auto;
            /* Add scroll if notes overflow */
        }

        .search-box {
            margin-bottom: 10px;
        }

        .note-list {
            list-style: none;
            padding: 0;
        }

        .note-list li {
            cursor: pointer;
            padding: 5px 10px;
        }

        .note-list .nested {
            display: none;
            margin-left: 20px;
        }

        .note-list li.active {
            font-weight: bold;
        }

        .note-list li i {
            margin-right: 5px;
        }

        /* Styling for the "+" button */
        .add-button {
            cursor: pointer;
            margin-left: 10px;
            /* Adjust spacing as needed */
            color: #007bff;
            /* Example: Bootstrap primary color */
        }

        .add-button:hover {
            color: #0056b3;
            /* Darker shade on hover */
        }

        .right-panel {
            padding: 20px;
            height: 100vh;
            overflow-y: auto;
        }

        .front-card-content {
            height: calc(100vh - 100px);
            /* Adjust height as needed */
            border: none;
            /* Remove default textarea border */
            padding: 10px;
            resize: none;
            /* Prevent manual resizing */
            box-sizing: border-box;
            /* Include padding in height calculation */
        }

        .tag {
            display: inline-block;
            margin-right: 5px;
            padding: 3px 8px;
            border-radius: 3px;
            background-color: #f0f0f0;
            /* Light gray background */
        }

        .toolbar {
            background-color: #f8f9fa;
            /* Light gray background for toolbar */
            padding: 5px;
            border-bottom: 1px solid #eee;
            display: flex;
            /* Use flexbox for alignment */
            align-items: center;
            /* Vertically align items */
        }

        .toolbar button {
            margin-right: 5px;
        }

        #tag-container {
            /* Style the tag container area */
            margin-top: 10px;
        }

        .btn-primary {
            /* Example customization */
            background-color: #007bff;
            /* Example color */
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            /* Darker shade on hover */
            border-color: #0062cc;
        }

        .card {
            border: 1px solid #e3e6f0;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .list-unstyled a {
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
        }

        .list-unstyled a:hover {
            text-decoration: underline;
        }

        #ckeditor {
            min-height: 400px;
        }

        .btn {
            border-radius: 5px;
        }
    </style>
@endpush
@section('content')
 <h1>{{ $notebook->name }}</h1>
    <a href="{{ route('notes.create', $notebook) }}">Add Note</a>
    <ul>
        @foreach($notebook->notes as $note)
            <li>
                {{ $note->title }}
                <a href="{{ route('notes.edit', $note) }}">Edit</a>
                <form action="{{ route('notes.destroy', $note) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
    @endsection

    @push('scripts')
        <script></script>
    @endpush
