<!DOCTYPE html>

<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Create Course</title>

    <meta name="description" content="" />

    @include('layouts.Teacher.LinkHeader')

</head>

<body>
<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->


        @include('layouts.Teacher.Sidebar')

        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
            <!-- Navbar -->

            @include('layouts.Teacher.NavBar')

            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">

                    {{-- message Section --}}
                    @if (session('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success_message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error_message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    {{-- end message Section --}}

                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Create Teacher</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{route('teacher.course.store')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- Full Name -->
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="basic-icon-default-fullname">Name</label>
                                        <div class="input-group input-group-merge">
                        <span id="basic-icon-default-fullname2" class="input-group-text">
                            <i class="bx bx-user"></i>
                                           </span>
                                            <input
                                                name="name"
                                                type="text"
                                                class="form-control"
                                                id="basic-icon-default-fullname"
                                                placeholder="John Doe"
                                                aria-label="John Doe"
                                                aria-describedby="basic-icon-default-fullname2"
                                                required
                                            />
                                        </div>
                                    </div>


                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="basic-icon-default-email">Code</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                            <input
                                                type="text"
                                                name="code"
                                                id="basic-icon-default-email"
                                                class="form-control"
                                                placeholder="p-x-zwfml0"
                                                aria-label="p-x-zwfml0"
                                                aria-describedby="basic-icon-default-email2"
                                                required
                                            />
                                            <span id="basic-icon-default-email2" class="input-group-text"></span>
                                        </div>
                                        <div class="form-text">You can use letters, numbers & periods</div>
                                    </div>
                                </div>

                                <div class="row">


                                </div>

                                <div class="row">

                                    <div class="mb-3 col-md-4">
                                        <label class="form-label" for="category">Category</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-category"></i></span>
                                            <select
                                                name="category"
                                                id="category"
                                                class="form-control"
                                                required>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label class="form-label" for="subcategories">Sub Categories</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-list-ul"></i></span>
                                            <select
                                                name="subcategories[]"
                                                id="subcategories"
                                                class="form-control"
                                                multiple
                                                disabled>
                                                <option value="">Select Sub Categories</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <!-- Image Upload Input -->
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label" for="basic-icon-default-image">Upload Image</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-image"></i></span>
                                            <input
                                                type="file"
                                                name="img"
                                                id="basic-icon-default-image"
                                                class="form-control"
                                                aria-label="Upload image"
                                                accept="image/*"
                                                required
                                            />
                                        </div>
                                        <div class="form-text">Allowed formats: JPG, PNG, GIF</div>
                                    </div>
                                </div>



                                <button type="submit" class="btn btn-primary">Create</button>
                            </form>
                        </div>
                    </div>



                </div>
                <!-- / Content -->

                <!-- Footer -->
                @include('layouts.Teacher.Footer')
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->

@include('layouts.Teacher.LinkJS')

<script>
    document.getElementById('category').addEventListener('change', function() {
        let categoryId = this.value;
        let subcategoriesSelect = document.getElementById('subcategories');

        if (categoryId) {
            // Enable the subcategories select
            subcategoriesSelect.disabled = false;

            // Fetch subcategories
            fetch(`/teacher/course/sub/category/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    // Clear existing options
                    subcategoriesSelect.innerHTML = '';

                    // Add new options
                    data.forEach(subcategory => {
                        let option = new Option(subcategory.name, subcategory.id);
                        subcategoriesSelect.add(option);
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    subcategoriesSelect.disabled = true;
                });
        } else {
            // Disable and clear subcategories select if no category is selected
            subcategoriesSelect.disabled = true;
            subcategoriesSelect.innerHTML = '<option value="">Select Sub Categories</option>';
        }
    });
</script>

</body>
</html>
