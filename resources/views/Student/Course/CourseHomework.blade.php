<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $homework->name }} - Course Homework</title>
    <link rel="stylesheet" href="{{ asset('web_assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('web_assets/css/elzero.css') }}">
    <link rel="stylesheet" href="{{ asset('web_assets/css/all.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .homework-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }

        .homework-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .homework-header h1 {
            color: #2196f3;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .homework-info {
            display: flex;
            justify-content: space-around;
            margin: 20px 0;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .info-item {
            text-align: center;
        }

        .info-item i {
            color: #2196f3;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .info-item span {
            display: block;
            color: #666;
            font-size: 14px;
        }

        .questions-container {
            margin-top: 30px;
        }

        .question-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .question-text {
            font-size: 18px;
            color: #333;
            margin-bottom: 15px;
            display: flex;
            align-items: flex-start;
        }

        .question-number {
            background: #2196f3;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .mark-label {
            color: #2196f3;
            font-size: 14px;
            margin-left: 10px;
        }

        .options-list {
            list-style: none;
            padding: 0;
        }

        .option-item {
            margin: 10px 0;
        }

        .option-label {
            display: flex;
            align-items: center;
            padding: 10px 15px;
            background: white;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .option-label:hover {
            border-color: #2196f3;
            background: #e3f2fd;
        }

        .option-label.selected {
            border-color: #2196f3;
            background: #e3f2fd;
        }

        .option-input {
            margin-right: 10px;
        }

        .submit-btn {
            display: block;
            width: 100%;
            padding: 15px;
            background: #2196f3;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s;
            margin-top: 30px;
        }

        .submit-btn:hover {
            background: #1976d2;
        }

        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #f0f0f0;
            color: #333;
            text-decoration: none;
            border-radius: 6px;
            margin-bottom: 20px;
            transition: background 0.3s;
        }

        .back-btn:hover {
            background: #e0e0e0;
        }

        .result-container {
            margin-top: 30px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .result-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .score {
            font-size: 24px;
            color: #2196f3;
            font-weight: bold;
        }

        .question-result {
            margin-top: 10px;
            padding: 10px;
            border-radius: 4px;
        }

        .question-result.correct {
            background: #d4edda;
            color: #155724;
        }

        .question-result.incorrect {
            background: #f8d7da;
            color: #721c24;
        }

        .correct-answer {
            color: #28a745;
            font-weight: bold;
        }

        .incorrect-answer {
            color: #dc3545;
            font-weight: bold;
        }

        .deadline-info {
            background: #fff3cd;
            color: #856404;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .homework-container {
                margin: 20px;
                padding: 15px;
            }

            .homework-header h1 {
                font-size: 20px;
            }

            .question-text {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    @include('layouts.Student.header')

    <div class="homework-container">
        <a href="{{ route('student.course.content', $course->id) }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Back to Course
        </a>

        <div class="homework-header">
            <h1>{{ $homework->name }}</h1>
            <p>{{ $homework->description }}</p>
        </div>

        <div class="homework-info">
            <div class="info-item">
                <i class="fas fa-clock"></i>
                <span>Due Date: {{ \Carbon\Carbon::parse($homework->deadline)->format('M d, Y') }}</span>
            </div>
            <div class="info-item">
                <i class="fas fa-star"></i>
                <span>Total Marks: {{ $homework->total_mark }}</span>
            </div>
            <div class="info-item">
                <i class="fas fa-question-circle"></i>
                <span>Questions: {{ $homework->questions->count() }}</span>
            </div>
        </div>

        @php
            $submission = \App\Models\StudentSubmission::where('student_id', Auth::guard('student')->id())
                ->where('submittable_type', \App\Models\CourseModuleHomeWork::class)
                ->where('submittable_id', $homework->id)
                ->first();
            
            $isDeadlinePassed = \Carbon\Carbon::now()->gt($homework->deadline);
        @endphp

        @if($submission)
            <div class="result-container">
                <div class="result-header">
                    <h2>Your Results</h2>
                    <div class="score">Score: {{ $submission->score }}/{{ $homework->total_mark }}</div>
                    <p>Submitted on: {{ $submission->submitted_at->format('M d, Y H:i') }}</p>
                </div>

                @foreach($homework->questions as $index => $question)
                    @php
                        $answers = is_array($submission->answers) ? $submission->answers : json_decode($submission->answers, true);
                        $isCorrect = isset($answers[$question->id]) && $answers[$question->id] === $question->correct_answer;
                    @endphp
                    <div class="question-card">
                        <div class="question-text">
                            <span class="question-number">{{ $index + 1 }}</span>
                            {{ $question->question }}
                            <span class="mark-label">({{ $question->mark }} marks)</span>
                        </div>
                        <div class="question-result {{ $isCorrect ? 'correct' : 'incorrect' }}">
                            <p>Your answer: <span class="{{ $isCorrect ? 'correct-answer' : 'incorrect-answer' }}">{{ $answers[$question->id] ?? 'Not answered' }}</span></p>
                            @if(!$isCorrect)
                                <p>Correct answer: <span class="correct-answer">{{ $question->correct_answer }}</span></p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif($isDeadlinePassed)
            <div class="deadline-info">
                <i class="fas fa-exclamation-circle"></i>
                <p>The deadline for this homework has passed.</p>
            </div>
        @else
            <form id="homeworkForm" action="{{ route('student.course.homework.submit', $homework->id) }}" method="POST">
                @csrf
                <div class="questions-container">
                    @foreach($homework->questions as $index => $question)
                    <div class="question-card">
                        <div class="question-text">
                            <span class="question-number">{{ $index + 1 }}</span>
                            {{ $question->question }}
                            <span class="mark-label">({{ $question->mark }} marks)</span>
                        </div>
                        <ul class="options-list">
                            @php
                                $options = [
                                    'option_a' => $question->option_a,
                                    'option_b' => $question->option_b,
                                    'option_c' => $question->option_c,
                                    'option_d' => $question->option_d,
                                ];
                            @endphp
                            @foreach($options as $key => $option)
                            <li class="option-item">
                                <label class="option-label">
                                    <input type="radio" 
                                           name="answers[{{ $question->id }}]" 
                                           value="{{ $option }}" 
                                           class="option-input"
                                           required>
                                    {{ $option }}
                                </label>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> Submit Homework
                </button>
            </form>
        @endif
    </div>

    <script>
        // Style selected options
        document.querySelectorAll('.option-label').forEach(label => {
            label.addEventListener('click', function() {
                const questionCard = this.closest('.question-card');
                questionCard.querySelectorAll('.option-label').forEach(l => l.classList.remove('selected'));
                this.classList.add('selected');
            });
        });

        // Handle form submission
        document.getElementById('homeworkForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => Promise.reject(err));
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.reload();
                } else {
                    alert(data.message || 'An error occurred while submitting the homework.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert(error.message || 'An error occurred while submitting the homework. Please try again.');
            });
        });
    </script>
</body>
</html> 