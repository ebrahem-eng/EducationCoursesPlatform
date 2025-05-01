<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Course Skills</title>
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
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if (session('error_message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error_message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Edit Course Skills</h5>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('teacher.course.update.skills', $course_id) }}" id="skillsForm">
                                @csrf
                                <div id="skills-container">
                                    @foreach($courseSkills as $index => $cs)
                                        <div class="row skill-row mb-3">
                                            <div class="col-md-5">
                                                <label class="form-label">Skill</label>
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text"><i class="bx bx-brain"></i></span>
                                                    <select name="skills[]" class="form-control" required>
                                                        <option value="">Select Skill</option>
                                                        @foreach($skills as $skill)
                                                            <option value="{{ $skill->id }}" {{ $skill->id == $cs->skill_id ? 'selected' : '' }}>
                                                                {{ $skill->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="form-label">Percentage</label>
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text"><i class="bx bx-percentage"></i></span>
                                                    <input type="number" name="percentages[]" class="form-control" min="1" max="100" required value="{{ $cs->percentage }}">
                                                </div>
                                            </div>
                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-skill" style="{{ $index == 0 ? 'display:none;' : '' }}">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mb-3">
                                    <button type="button" class="btn btn-secondary" id="add-skill">
                                        <i class="bx bx-plus"></i> Add Another Skill
                                    </button>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Update Skills</button>
                                    <a href="{{ route('teacher.course.index') }}" class="btn btn-outline-secondary">Back</a>
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
    const container = document.getElementById('skills-container');
    const addButton = document.getElementById('add-skill');
    const form = document.getElementById('skillsForm');

    function updateRemoveButtons() {
        const removeButtons = document.querySelectorAll('.remove-skill');
        removeButtons.forEach((button, index) => {
            button.style.display = document.querySelectorAll('.skill-row').length > 1 ? 'block' : 'none';
        });
    }

    addButton.addEventListener('click', function() {
        const newRow = document.querySelector('.skill-row').cloneNode(true);
        newRow.querySelectorAll('input, select').forEach(input => input.value = '');
        container.appendChild(newRow);
        updateRemoveButtons();
    });

    container.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-skill') || e.target.closest('.remove-skill')) {
            const row = e.target.closest('.skill-row');
            if (document.querySelectorAll('.skill-row').length > 1) {
                row.remove();
                updateRemoveButtons();
            }
        }
    });

    form.addEventListener('submit', function(e) {
        let total = 0;
        document.querySelectorAll('input[name="percentages[]"]').forEach(input => {
            total += parseInt(input.value || 0);
        });
        if (total !== 100) {
            e.preventDefault();
            alert("Total percentage must equal 100%");
        }
    });

    updateRemoveButtons();
});
</script>

</body>
</html>
