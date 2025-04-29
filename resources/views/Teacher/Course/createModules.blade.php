<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Create Course Modules</title>
    <meta name="description" content="" />
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

                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Add Course Modules</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('teacher.course.store.modules') }}" id="modulesForm">
                                @csrf
                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                
                                <div id="modules-container">
                                    <div class="row module-row mb-3">
                                        <div class="col-md-5">
                                            <label class="form-label">Module Name</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-book"></i></span>
                                                <input type="text" name="modules[0][name]" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">Description</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-detail"></i></span>
                                                <input type="text" name="modules[0][description]" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-module" style="display: none;">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <button type="button" class="btn btn-secondary" id="add-module">
                                        <i class="bx bx-plus"></i> Add Another Module
                                    </button>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Next Step</button>
                                </div>
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
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('modules-container');
    const addButton = document.getElementById('add-module');
    let moduleCount = 0;

    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.remove-module');
        removeButtons.forEach(button => {
            button.style.display = document.querySelectorAll('.module-row').length > 1 ? 'block' : 'none';
        });
    }

    addButton.addEventListener('click', function() {
        moduleCount++;
        const newRow = document.querySelector('.module-row').cloneNode(true);
        
        newRow.querySelectorAll('input').forEach(input => {
            input.value = '';
            const oldName = input.getAttribute('name');
            input.setAttribute('name', oldName.replace('[0]', `[${moduleCount}]`));
        });
        
        container.appendChild(newRow);
        updateRemoveButtons();
    });

    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-module') || e.target.closest('.remove-module')) {
            const row = e.target.closest('.module-row');
            if (document.querySelectorAll('.module-row').length > 1) {
                row.remove();
                updateRemoveButtons();
            }
        }
    });
});
</script>

</body>
</html> 