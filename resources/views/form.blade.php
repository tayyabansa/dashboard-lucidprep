<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>


</head>

<body>
    <header>
        <!-- place navbar here -->
        <ul class="nav justify-content-center  bg-secondary">
            <li class="nav-item">
                <a class="nav-link text-light" href="" aria-current="page">Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="">Show data</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-light" href="">Chat</a>
            </li>
            
            
            
        </ul>
    </header>
    <main>
        <div class="container">
            <h2 class="text-center">Register Form</h2>
            <div class="row d-flex justify-content-center">
                <div class="col-md-6 border">
                    <form action="{{ route('user.create') }}" id="myForm" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }} " name="name" id=""
                                aria-describedby="emailHelpId" placeholder="">
                            <span class="text-danger">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" name="email" id="" aria-describedby="emailHelpId"
                                placeholder="abc@mail.com">
                            <span class="text-danger">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Phone Number</label>
                            <input type="text" class="form-control  @error('number') is-invalid @enderror"
                                name="number" id="" placeholder="">
                            <span class="text-danger">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                        <!--<div class="mb-3">-->
                        <!--    <label for="" class="form-label">Confirm Password</label>-->
                        <!--    <input type="password" class="form-control  @error('password_confirm') is-invalid @enderror"-->
                        <!--        name="password_confirm" id="" placeholder="">-->
                        <!--    <span class="text-danger">-->
                        <!--        @error('password_confirm')-->
                        <!--            {{ $message }}-->
                        <!--        @enderror-->
                        <!--    </span>-->
                        <!--</div>-->
                        <!--<div class="mb-3 d-flex">-->
                        <!--    <label for="">Gender</label>-->
                        <!--    <div class="form-check mx-4">-->
                        <!--        <input class="form-check-input " type="radio" name="gender" value="male"-->
                        <!--            id="one">-->
                        <!--        <label class="form-check-label" for="one">-->
                        <!--            Male-->
                        <!--        </label>-->
                        <!--    </div>-->
                        <!--    <div class="form-check mx-4">-->
                        <!--        <input class="form-check-input" type="radio" name="gender" value="female"-->
                        <!--            id="two">-->
                        <!--        <label class="form-check-label" for="two">-->
                        <!--            Female-->
                        <!--        </label>-->
                        <!--        <span class="text-danger">-->
                        <!--            @error('gender')-->
                        <!--                {{ $message }}-->
                        <!--            @enderror-->
                        <!--        </span>-->
                        <!--    </div>-->
                        <!--</div>-->
                     
                        <!--<div class="mb-3">-->
                        <!--    <label for="" class="form-label">City</label>-->
                        <!--    <select class="form-select " name="city" id="">-->
                        <!--        <option>Select one</option>-->
                        <!--        <option value="Delhi">Delhi</option>-->
                        <!--        <option value="Mumbai">Mumbai</option>-->
                        <!--        <option value="Nasik">Nasik</option>-->
                        <!--        <span class="text-danger">-->
                        <!--            @error('city')-->
                        <!--                {{ $message }}-->
                        <!--            @enderror-->
                        <!--        </span>-->
                        <!--    </select>-->
                        <!--</div>-->
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>

    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $("#myForm").on("submit", function(event) {
                event.preventDefault();
                let formData = $(this).serialize();
                $.ajax({
                    url: $(this).attr("action"),
                    method: "POST",
                    data: formData,
                    headers: {
                        "X-CSRF-TOKEN": $('input[name="_token"]').val()
                    },
                    success: function(response) {
                        // Show success toast
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "top-end",
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: (toast) => {
                                toast.onmouseenter = Swal.stopTimer;
                                toast.onmouseleave = Swal.resumeTimer;
                            }
                        });
                        Toast.fire({
                            icon: "success",
                            title: response.message || "Registration successful!"
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 3100);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMessages = Object.values(errors).map(
                                (messages) => messages.join(", ")
                            );
                            Swal.fire({
                                icon: "error",
                                title: "Validation Error",
                                html: errorMessages.join("<br>")
                            });
                        } else {
                            console.error("Error submitting form:", xhr.responseJSON || xhr
                                .responseText);
                            Swal.fire({
                                icon: "error",
                                title: "Submission Failed",
                                text: "Something went wrong. Please try again later."
                            });
                        }
                    }
                });
            });
        });
    </script>
  
</body>

</html>
