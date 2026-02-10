@extends('admin.layouts.app')
@section('title', 'Luciderp | My Notebook')
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
        .view-note{
       background-color: transparent !important;
       border: 1px solid black;
       color: black!important;
     }
     .modal-top {
    display: flex;
    align-items: flex-start; /* Align to top */
    justify-content: center; /* Center horizontally */
    min-height: 100vh; /* Full height of viewport */
    padding-top: 10vh; /* Move modal slightly down */
}

    </style>
@endpush
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles mx-0">
                <div class="col-sm-12 p-md-0">
                    <div class="welcome-text">
                        <h4>My Notebook</h4>
                    </div>
                </div>
               
            </div>
            <div class="row">
               
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            
                            
                            
                           <input type="text" id="search" class="form-control mb-2" placeholder="Search Notes">
   <div class="d-flex align-items-center">
    <h4 class="mb-0">Create New Note</h4>
    <button class="btn btn-primary btn-sm ml-2 d-flex align-items-center justify-content-center" id="addNote" style="width: 32px; height: 32px; padding: 0; margin-left:5px;">
        <i class="la la-plus"></i>
    </button>
</div>
   
             <ul class="list-group" id="notesList">
                            @foreach($notes as $note)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $note->title }}</span>
                                    <div>
                                        <button class="btn btn-info btn-sm view-note" id="view-btn" data-id="{{ $note->id }}"><i class="la la-eye"></i></button>
                                        <button class="btn btn-danger btn-sm delete-note" data-id="{{ $note->id }}">X</button>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                            
                        </div>
                    </div>
                </div>
                
                
            
                <!-- Right Editor Section -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            
                       <h4 id="editorTitle" class="card-title">Getting Started</h4>
                        <form id="noteForm">
                            @csrf
                            <input type="hidden" id="noteId">
                            <input type="text" id="title" class="form-control mb-2" placeholder="Title">
                            <textarea id="ckeditor"></textarea>
                            <button type="submit" class="btn btn-success mt-2">Save</button>
                        </form>
            
            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap Modal Alert -->
<!-- Modal (Now positioned at the top) -->
<div class="modal fade" id="alertModal" role="dialog" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-top"> <!-- Custom class added -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title " id="alertModalLabel">Notification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="alertMessage"></p> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-top modal-dialog-centered"> <!-- Centered & positioned at top -->
        <div class="modal-content">
            <div class="modal-header  text-light">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this note? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="confirmDeleteBtn">Yes, Delete</button>
            </div>
        </div>
    </div>
</div>




        
    @endsection

    @push('scripts')

     <script>


const preloader = document.getElementById('preloader');

// Function to show loader
function showLoader() {
    preloader.style.display = "block";
}

// Function to hide loader
function hideLoader() {
    preloader.style.display = "none";
}

// Add New Note
document.getElementById('addNote').addEventListener('click', () => {
    document.getElementById('noteId').value = '';
    document.getElementById('title').value = '';
    editor.setData('');
    document.getElementById('editorTitle').innerText = "New Note";
});

// View Note (Load into Edit Form)
document.querySelectorAll('.view-note').forEach(button => {
    button.addEventListener('click', function() {
        const noteId = this.getAttribute('data-id');
        showLoader();

        fetch(`/notes/${noteId}`)
            .then(response => response.json())
            .then(note => {
                document.getElementById('noteId').value = note.id;
                document.getElementById('title').value = note.title;
                editor.setData(note.content);
                document.getElementById('editorTitle').innerText = "Edit Note";
            })
            .finally(() => hideLoader());
    });
});

// Save or Update Note
document.getElementById('noteForm').addEventListener('submit', function(e) {
    e.preventDefault();
    showLoader();

    const id = document.getElementById('noteId').value;
    const title = document.getElementById('title').value;
    const content = editor.getData();
    const url = id ? `/notes/${id}` : '/notes';
    const method = id ? 'PUT' : 'POST';

    fetch(url, {
        method: method,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' },
        body: JSON.stringify({ title, content })
    })
    .then(response => response.json())
    .then(data => {
        // if (data.success) {
        //     alert("Note saved successfully!");
        //     location.reload();
        // }
        if (data.success) {
            if (data.success) {
            showModalAlert("Note saved successfully!", true); 
            setTimeout(() => location.reload(), 1000); 
            } else {
                showModalAlert("Failed to save note.", false); 
            }
        }
    })
    .finally(() => hideLoader());
});
function showModalAlert(message, isSuccess) {
    let alertModal = new bootstrap.Modal(document.getElementById("alertModal"), {
        backdrop: 'static', 
        keyboard: false 
    });

    document.getElementById("alertMessage").innerText = message; 
    document.getElementById("alertModalLabel").innerText = isSuccess ? "Success" : "Error"; 

    let modalHeader = document.querySelector("#alertModal .modal-header");
    modalHeader.classList.remove("bg-success", "bg-danger"); 

    alertModal.show(); 
}




// Delete Note with Confirmation
// document.querySelectorAll('.delete-note').forEach(button => {
//     button.addEventListener('click', function(event) {
//         event.stopPropagation();
//         const noteId = this.getAttribute('data-id');

//         if (confirm("Are you sure you want to delete this note?")) {
//             showLoader();
//             fetch(`/notes/${noteId}`, { 
//                 method: 'DELETE', 
//                 headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } 
//             })
//             .then(response => response.json())
//             .then(data => {
//                 if (data.success) {
//                     alert("Note deleted!");
//                     location.reload();
//                 }
//             })
//             .finally(() => hideLoader());
//         }
//     });
// });
let deleteNoteId = null; 


document.querySelectorAll('.delete-note').forEach(button => {
    button.addEventListener('click', function(event) {
        event.stopPropagation();
        deleteNoteId = this.getAttribute('data-id'); 
        let deleteModal = new bootstrap.Modal(document.getElementById("confirmDeleteModal"), {
            backdrop: 'static', 
            keyboard: false 
        });
        deleteModal.show();
    });
});

document.getElementById("confirmDeleteBtn").addEventListener("click", function() {
    if (deleteNoteId) {
        fetch(`/notes/${deleteNoteId}`, { 
            method: 'DELETE', 
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } 
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload(); 
            }
        });
    }
});


// Search Notes with Loader
// Search Notes with Loader
document.getElementById('search').addEventListener('input', function() {
    let query = this.value.trim(); // Trim spaces
    showLoader();

    // If search query is empty, fetch all notes
    let url = query ? `/search-note/${encodeURIComponent(query)}` : `/notes_all`; 

    fetch(url)
        .then(response => response.json())
        .then(notes => {
            let notesList = document.getElementById('notesList');
            notesList.innerHTML = '';

            notes.forEach(note => {
                let li = document.createElement('li');
                li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center', 'note-item');
                li.setAttribute('data-id', note.id);
                li.textContent = note.title;

                // Create Button Container Div
                let buttonContainer = document.createElement('div');
                buttonContainer.classList.add('d-flex', 'gap-2'); // Use Bootstrap flex styling

                // Create View Button
                let viewButton = document.createElement('button');
                viewButton.classList.add('btn', 'btn-info', 'btn-sm', 'view-note');
                viewButton.innerHTML = '<i class="la la-eye"></i>';
                viewButton.setAttribute('data-id', note.id);
                viewButton.addEventListener('click', function() {
                    showLoader();
                    fetch(`/notes/${note.id}`)
                        .then(response => response.json())
                        .then(note => {
                            document.getElementById('noteId').value = note.id;
                            document.getElementById('title').value = note.title;
                            editor.setData(note.content);
                            document.getElementById('editorTitle').innerText = "Edit Note";
                        })
                        .finally(() => hideLoader());
                });

                // Create Delete Button
                let deleteButton = document.createElement('button');
                deleteButton.classList.add('btn', 'btn-danger', 'btn-sm', 'delete-note');
                deleteButton.innerHTML = '<i class="la la-trash"></i>';
                deleteButton.setAttribute('data-id', note.id);
                deleteButton.addEventListener('click', function(event) {
                    event.stopPropagation();
                    if (confirm("Are you sure you want to delete this note?")) {
                        showLoader();
                        fetch(`/notes/${note.id}`, { 
                            method: 'DELETE', 
                            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } 
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert("Note deleted!");
                                location.reload();
                            }
                        })
                        .finally(() => hideLoader());
                    }
                });

                // Append buttons to the button container div
                buttonContainer.appendChild(viewButton);
                buttonContainer.appendChild(deleteButton);

                // Append button container to the list item
                li.appendChild(buttonContainer);
                notesList.appendChild(li);
            });
        })
        .finally(() => hideLoader());
});


</script>
    @endpush
