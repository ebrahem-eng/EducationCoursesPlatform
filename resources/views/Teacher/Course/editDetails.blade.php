@php
    // Get selected subcategory IDs from relationship
    $selectedSubcategories = $course->categories->pluck('category_id')->toArray();
@endphp

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Course</title>
    @include('layouts.Teacher.LinkHeader')
</head>
<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        @include('layouts.Teacher.Sidebar')
        <div class="layout-page">
            @include('layouts.Teacher.NavBar')
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">

                    @if (session('success_message'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success_message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if (session('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error_message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Edit Course</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('teacher.course.update.details', $course->id) }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Name</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                                            <input name="name" type="text" class="form-control" value="{{ old('name', $course->name) }}" required />
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Code</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                            <input type="text" name="code" class="form-control" value="{{ old('code', $course->code) }}" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Category -->
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Category</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-category"></i></span>
                                            <select name="category" id="category" class="form-control" required>
                                                <option value="">Select Category</option>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat->id }}" {{ $cat->id == $course->categories->first()->category_id ? 'selected' : '' }}>
                                                        {{ $cat->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Subcategories -->
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Sub Categories</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-list-ul"></i></span>
                                            <select name="subcategories[]" id="subcategories" class="form-control" multiple>
                                                {{-- Options will be loaded via JS --}}
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Duration -->
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Duration (Week)</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-time"></i></span>
                                            <input type="number" name="duration" class="form-control" value="{{ old('duration', $course->duration) }}" max="48" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Image Upload -->
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Upload New Image (optional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bx-image"></i></span>
                                            <input type="file" name="img" class="form-control" accept="image/*" />
                                        </div>
                                        @if($course->image)
                                            <small>Current: <img src="{{ asset('CourseImage/' . $course->image) }}" width="100"></small>
                                        @endif
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Update <i class="bx bx-check"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                @include('layouts.Teacher.Footer')
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
    <div class="layout-overlay layout-menu-toggle"></div>
</div>

@include('layouts.Teacher.LinkJS')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryId = document.getElementById('category').value;
        const subcategoriesSelect = document.getElementById('subcategories');
        const selectedSubcategories = @json($selectedSubcategories);

        if (categoryId) {
            fetch(`/teacher/course/sub/category/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    subcategoriesSelect.innerHTML = '';
                    data.forEach(sub => {
                        const option = new Option(sub.name, sub.id);
                        if (selectedSubcategories.includes(sub.id)) {
                            option.selected = true;
                        }
                        subcategoriesSelect.add(option);
                    });
                });
        }
    });

    document.getElementById('category').addEventListener('change', function () {
        let categoryId = this.value;
        let subcategoriesSelect = document.getElementById('subcategories');

        if (categoryId) {
            subcategoriesSelect.disabled = false;
            fetch(`/teacher/course/sub/category/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    subcategoriesSelect.innerHTML = '';
                    data.forEach(sub => {
                        let option = new Option(sub.name, sub.id);
                        subcategoriesSelect.add(option);
                    });
                })
                .catch(() => {
                    subcategoriesSelect.disabled = true;
                });
        } else {
            subcategoriesSelect.disabled = true;
            subcategoriesSelect.innerHTML = '<option value="">Select Sub Categories</option>';
        }
    });
</script>
</body>
</html>
