<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Add Module Exam</title>
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
                            <h5 class="mb-0">Create Exam for Module: {{ $module->name }}</h5>
                        </div>
                        <div class="card-body">
                            <!-- List of existing exams -->
                            @if($exams->count() > 0)
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Exam Name</th>
                                            <th>Description</th>
                                            <th>Total Mark</th>
                                            <th>Questions</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($exams as $existingExam)
                                        <tr>
                                            <td>{{ $existingExam->name }}</td>
                                            <td>{{ $existingExam->description }}</td>
                                            <td>{{ $existingExam->total_mark }}</td>
                                            <td>
                                                @php
                                                    $questionCount = optional($existingExam->questions)->count() ?? 0;
                                                @endphp
                                                {{ $questionCount }}
                                            </td>
                                            <td>
                                                <a href="{{ route('teacher.course.module.exam.questions', ['exam_id' => $existingExam->id]) }}" 
                                                   class="btn btn-primary btn-sm">
                                                    <i class="bx bx-plus"></i> Add Questions
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif

                            <!-- Form to create new exam -->
                            <form method="post" action="{{ route('teacher.course.module.exams.store') }}" id="examForm">
                                @csrf
                                <input type="hidden" name="module_id" value="{{ $module->id }}">
                                
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Exam Name</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-book-content"></i></span>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Description</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-detail"></i></span>
                                            <input type="text" name="description" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Total Mark</label>
                                        <div class="input-group input-group-merge">
                                            <span class="input-group-text"><i class="bx bx-trophy"></i></span>
                                            <input type="number" name="total_mark" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Create New Exam</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if(isset($exam))
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Add Questions to Exam: {{ $exam->name }}</h5>
                            <div>
                                <span class="badge bg-primary">Total Marks: {{ $exam->total_mark }}</span>
                                <span class="badge bg-info" id="remainingMarks">Remaining: {{ $exam->total_mark }}</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('teacher.course.module.exam.questions.store') }}" id="questionsForm">
                                @csrf
                                <input type="hidden" name="exam_id" value="{{ $exam->id }}">
                                <input type="hidden" name="module_id" value="{{ $module->id }}">
                                <input type="hidden" id="examTotalMark" value="{{ $exam->total_mark }}">
                                
                                <div id="questions-container">
                                    <div class="row question-row mb-4">
                                        <div class="col-md-12 mb-3">
                                            <label class="form-label">Question</label>
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-question-mark"></i></span>
                                                <input type="text" name="questions[0][question]" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Option A</label>
                                            <input type="text" name="questions[0][option_a]" class="form-control" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Option B</label>
                                            <input type="text" name="questions[0][option_b]" class="form-control" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Option C</label>
                                            <input type="text" name="questions[0][option_c]" class="form-control" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">Option D</label>
                                            <input type="text" name="questions[0][option_d]" class="form-control" required>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label">Correct Answer</label>
                                            <select name="questions[0][correct_answer]" class="form-control" required>
                                                <option value="a">A</option>
                                                <option value="b">B</option>
                                                <option value="c">C</option>
                                                <option value="d">D</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3 mt-3">
                                            <label class="form-label">Mark</label>
                                            <input type="number" name="questions[0][mark]" class="form-control" required>
                                        </div>
                                        <div class="col-md-1 mt-4">
                                            <button type="button" class="btn btn-danger btn-sm remove-question" style="display: none;">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <button type="button" class="btn btn-secondary" id="add-question">
                                        <i class="bx bx-plus"></i> Add Another Question
                                    </button>
                                </div>

                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Next Step</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endif
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
    const container = document.getElementById('questions-container');
    const addButton = document.getElementById('add-question');
    const remainingMarksSpan = document.getElementById('remainingMarks');
    const examTotalMark = parseFloat(document.getElementById('examTotalMark').value || 0);
    let questionCount = 0;

    function updateRemainingMarks() {
        let totalMarks = 0;
        document.querySelectorAll('input[name$="[mark]"]').forEach(input => {
            totalMarks += parseFloat(input.value || 0);
        });
        const remaining = examTotalMark - totalMarks;
        remainingMarksSpan.textContent = `Remaining: ${remaining}`;
        remainingMarksSpan.className = `badge ${remaining < 0 ? 'bg-danger' : 'bg-info'}`;
    }

    // Add event listener to all mark inputs
    container.addEventListener('input', function(e) {
        if (e.target.name && e.target.name.endsWith('[mark]')) {
            updateRemainingMarks();
        }
    });

    if (addButton) {
        function updateRemoveButtons() {
            const removeButtons = document.querySelectorAll('.remove-question');
            removeButtons.forEach(button => {
                button.style.display = document.querySelectorAll('.question-row').length > 1 ? 'block' : 'none';
            });
        }

        addButton.addEventListener('click', function() {
            questionCount++;
            const newRow = document.querySelector('.question-row').cloneNode(true);
            
            newRow.querySelectorAll('input, select').forEach(input => {
                input.value = '';
                const oldName = input.getAttribute('name');
                input.setAttribute('name', oldName.replace('[0]', `[${questionCount}]`));
            });
            
            container.appendChild(newRow);
            updateRemoveButtons();
        });

        container.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-question') || e.target.closest('.remove-question')) {
                const row = e.target.closest('.question-row');
                if (document.querySelectorAll('.question-row').length > 1) {
                    row.remove();
                    updateRemoveButtons();
                    updateRemainingMarks();
                }
            }
        });

        // Form validation for total marks
        document.getElementById('questionsForm').addEventListener('submit', function(e) {
            let totalMarks = 0;
            document.querySelectorAll('input[name$="[mark]"]').forEach(input => {
                totalMarks += parseFloat(input.value || 0);
            });
            
            if (totalMarks !== examTotalMark) {
                e.preventDefault();
                alert(`Total marks of all questions (${totalMarks}) must equal the exam total mark (${examTotalMark})`);
            }
        });
    }
});
</script>

</body>
</html> 