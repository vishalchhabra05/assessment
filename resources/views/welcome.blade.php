<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
 

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    FORM
                </div>

               <form id="userForm" method="POST" action="" enctype="multipart/form-data" class="needs-validation">
                @csrf <!-- Laravel's CSRF Protection -->

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone" value="{{ old('phone') }}" required>
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" placeholder="Enter Description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="role_id" class="form-label">Role</label>
                    <select class="form-control" id="role_id" name="role_id" required>
                        <option value="">Select Role</option>
                        @foreach($roles as $role) <!-- Assuming $roles is passed to the view -->
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ $role->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="profile_image" class="form-label">Profile Image</label>
                    <input type="file" class="form-control" id="profile_image" name="profile_image">
                    @error('profile_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>



                <div id="userTable">
                    <!-- User data will be displayed here -->
                </div>

            </div>
        </div>
    </body>
</html>

 

<!-- Load jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- Load jQuery Validation Plugin -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validation/1.19.5/jquery.validate.min.js"></script>


<script>
    const BASE_URL = "{{ url('/') }}";
</script>

<script type="text/javascript">
    $(document).ready(function() {
        // Initialize jQuery Validation
        $('#userForm').validate({
            rules: {
                'name': {
                    required: true
                },
                'email': {
                    required: true,
                    email: true
                },
                'phone': {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                'role_id': {
                    required: true
                },
                'profile_image': {
                    required: false,
                    extension: "jpg|jpeg|png"
                }
            },
            messages: {
                'name': {
                    required: "Please enter your name"
                },
                'email': {
                    required: "Please enter a valid email",
                    email: "Please enter a valid email address"
                },
                'phone': {
                    required: "Please enter your phone number",
                    digits: "Phone number must contain only digits",
                    minlength: "Phone number must be exactly 10 digits",
                    maxlength: "Phone number must be exactly 10 digits"
                },
                'role_id': {
                    required: "Please select a role"
                },
                'profile_image': {
                    extension: "Profile image must be in jpg, jpeg, or png format"
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.mb-3').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>

<script type="text/javascript">

    $(function(){
    
    document.getElementById("userForm").addEventListener("submit", async (e) => {
        //alert('submit');
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    try {
        const response = await fetch(BASE_URL+"/api/users", {
            method: "POST",
            body: formData,
        });

        const result = await response.json();

        if (result.success) {
            alert(result.message);
            loadUsers(); // Refresh the table
        } else {
            alert("Error: " + JSON.stringify(result.errors));
        }
    } catch (error) {
        console.error("Error:", error);
    }
});
    });

async function loadUsers() {

    const response = await fetch(BASE_URL+"/api/users");
    const users = await response.json();
    const userTable = document.getElementById("userTable");
    userTable.innerHTML = `
        <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Role</th>
                <th>Profile Image</th>
                <th>Description</th>
            </tr>
            ${users
                .map(
                    (user) => `
                <tr>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.phone}</td>
                    <td>${user.role.name}</td>
                    <td><img src="`+BASE_URL+`/${user.profile_image}" width="50" /></td>
                    <td>${user.description}</td>
                </tr>
            `
                )
                .join("")}
        </table>
    `;
}

// Load users on page load
loadUsers();
</script>