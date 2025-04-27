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

    <title>Create Course Skills</title>

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
                            <h5 class="mb-0">Add Course Skills</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{route('teacher.course.store.step2')}}" id="skillsForm">
                                @csrf
                                <div id="skills-container">
                                    <div class="row skill-row mb-3">
                                        <div class="col-md-5">
                                            <label class="form-label">Skill</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-brain"></i></span>
                                                <select name="skills[]" class="form-control" required>
                                                    <option value="">Select Skill</option>
                                                    @foreach($skills as $skill)
                                                        <option value="{{ $skill->id }}">{{ $skill->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label">Percentage</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-percentage"></i></span>
                                                <input type="number" name="percentages[]" class="form-control" min="1" max="100" required>
                                            </div>
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="button" class="btn btn-danger btn-sm remove-skill" style="display: none;">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <button type="button" class="btn btn-secondary" id="add-skill">
                                        <i class="bx bx-plus"></i> Add Another Skill
                                    </button>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Create Course</button>
                                    <a href="{{ route('teacher.course.create') }}" class="btn btn-outline-secondary">Back</a>
                                </div>
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
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('skills-container');
    const addButton = document.getElementById('add-skill');
    const form = document.getElementById('skillsForm');

    // Function to update remove buttons visibility
    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.remove-skill');
        removeButtons.forEach((button, index) => {
            if (document.querySelectorAll('.skill-row').length > 1) {
                button.style.display = 'block';
            } else {
                button.style.display = 'none';
            }
        });
    }

    // Add new skill row
    addButton.addEventListener('click', function() {
        const newRow = document.querySelector('.skill-row').cloneNode(true);
        newRow.querySelectorAll('input, select').forEach(input => {
            input.value = '';
        });
        container.appendChild(newRow);
        updateRemoveButtons();
    });

    // Remove skill row
    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-skill') || e.target.closest('.remove-skill')) {
            const row = e.target.closest('.skill-row');
            if (document.querySelectorAll('.skill-row').length > 1) {
                row.remove();
                updateRemoveButtons();
            }
        }
    });

    // Form validation
    form.addEventListener('submit', function(e) {
        let totalPercentage = 0;
        const percentages = document.querySelectorAll('input[name="percentages[]"]');
        
        percentages.forEach(input => {
            totalPercentage += parseInt(input.value || 0);
        });

        if (totalPercentage !== 100) {
            e.preventDefault();
            alert('Total percentage must equal 100%');
        }
    });
});
</script>

</body>
</html>
