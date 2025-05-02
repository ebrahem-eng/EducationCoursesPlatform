<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details - Elzero</title>
    <link rel="stylesheet" href="{{ asset('web_assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('web_assets/css/elzero.css') }}">
    <link rel="stylesheet" href="{{ asset('web_assets/css/all.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;700&display=swap" rel="stylesheet">

    <style>
        .course-details {
            padding: 100px 0;
            position: relative;
        }

        .course-details .container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 40px;
            position: relative;
        }

        .course-details .image {
            text-align: center;
        }

        .course-details .image img {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgb(0 0 0 / 10%);
        }

        .course-details .info {
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgb(0 0 0 / 10%);
        }

        .course-details .info h2 {
            color: var(--main-color, #2196f3);
            margin: 0 0 20px;
            font-size: 30px;
        }

        .course-details .info p {
            line-height: 1.6;
            color: #777;
            margin: 15px 0;
        }

        .course-details .info .code {
            color: #2196f3;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 15px;
        }

        .course-details .teacher-info {
            display: flex;
            align-items: center;
            margin: 30px 0;
            padding: 20px;
            background-color: #fafafa;
            border-radius: 10px;
        }

        .course-details .teacher-info img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-right: 20px;
        }

        .course-details .teacher-info .text h3 {
            margin: 0;
            font-size: 18px;
            color: #2196f3;
        }

        .course-details .teacher-info .text p {
            margin: 5px 0 0;
            color: #777;
            font-size: 14px;
        }

        .register-btn {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #2196f3;
            color: white;
            text-align: center;
            border: none;
            border-radius: 6px;
            font-weight: bold;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
            text-decoration: none;
            margin-top: 20px;
        }

        .register-btn:hover {
            background-color: #1787e0;
            transform: translateY(-5px);
        }

        .course-content {
            margin-top: 40px;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 15px rgb(0 0 0 / 10%);
        }

        .course-content h3 {
            color: #2196f3;
            margin: 0 0 20px;
        }

        .course-content ul {
            list-style: none;
            padding: 0;
        }

        .course-content ul li {
            padding: 15px;
            margin-bottom: 15px;
            background-color: #fafafa;
            border-radius: 6px;
            position: relative;
        }

        .course-content ul li::before {
            font-family: "Font Awesome 5 Free";
            content: "\f00c";
            font-weight: 900;
            margin-right: 10px;
            color: #2196f3;
        }

        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            object-fit: cover;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            min-width: 200px;
            z-index: 1000;
        }

        .profile-trigger:hover .dropdown-content {
            display: block;
        }

        .user-info {
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .user-name {
            margin: 0;
            font-size: 16px;
            color: #333;
        }

        .user-email {
            font-size: 14px;
            color: #666;
        }

        .dropdown-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .dropdown-menu li a {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            transition: background 0.3s;
        }

        .dropdown-menu li a:hover {
            background: #f5f5f5;
        }

        .login-btn {
            padding: 8px 20px;
            background: #2196f3;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            transition: background 0.3s;
        }

        .login-btn:hover {
            background: #1976d2;
        }

        /* Error message styling */
        .error-message {
            color: #ff4444;
            font-size: 0.85em;
            margin-top: 5px;
            display: none;
        }

        /* Success animation */
        .success-animation {
            animation: successPulse 0.5s ease;
        }

        /* Success message styling */
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.95em;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /* Error message styling */
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.95em;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /* Dismiss button styling */
        .alert .btn-close {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: inherit;
            font-size: 1.2em;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .alert .btn-c
        @keyframes successPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }

        .module-section {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            margin-bottom: 32px;
            padding: 24px 18px;
        }
        .module-section h3 {
            color: #2196f3;
            margin-bottom: 8px;
            font-size: 1.4rem;
        }
        .module-desc {
            color: #666;
            margin-bottom: 18px;
        }
        .module-block {
            margin-bottom: 18px;
        }
        .videos-list {
    display: flex;
    flex-wrap: wrap;
    gap: 18px;
    margin-bottom: 10px;
}

.video-card {
    background: #f9f9f9;
    border-radius: 8px;
    padding: 10px;
    width: 300px; /* زودت العرض قليلاً ليتناسب مع الفيديو */
    box-shadow: 0 1px 6px rgba(0,0,0,0.04);
    display: flex;
    flex-direction: column;
    align-items: center;
}

.video-card video {
    width: 100%;
    height: auto;
    border-radius: 8px;
}

.video-info {
    margin-top: 8px;
    text-align: center;
}
am-card, .homework-card {
            background: #f5f7fa;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 10px;
        }
        .exam-mark, .homework-mark {
            color: #2196f3;
            font-size: 0.95em;
            margin-right: 8px;
        }

        .course-details .container {
    display: flex;
    flex-direction: row;
    gap: 40px;
    align-items: flex-start;
    position: relative;
    flex-wrap: wrap;
}
.course-details .image {
    flex: 0 0 260px;
    text-align: center;
}
.course-details .info {
    flex: 1 1 0;
    min-width: 320px;
}

.progress-overview {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.progress-bar-container {
    height: 20px;
    background: #f0f0f0;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 15px;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(to right, #2196f3, #1976d2);
    border-radius: 10px;
    position: relative;
    transition: width 0.3s ease;
}

.progress-text {
    position: absolute;
    right: 10px;
    color: white;
    font-size: 12px;
    line-height: 20px;
}

.progress-stats {
    display: flex;
    justify-content: space-around;
    margin-top: 20px;
}

.stat {
    text-align: center;
}

.stat i {
    font-size: 24px;
    color: #2196f3;
    margin-bottom: 5px;
}

.stat span {
    display: block;
    color: #666;
    font-size: 14px;
}

.module-card {
    background: white;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.module-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.module-progress {
    position: relative;
}

.progress-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #f0f0f0;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.progress-circle::before {
    content: '';
    position: absolute;
    width: 54px;
    height: 54px;
    border-radius: 50%;
    background: white;
}

.progress-circle::after {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: conic-gradient(#2196f3 var(--progress), transparent 0);
    --progress: calc(var(--data-progress) * 3.6deg);
}

.content-section {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.content-section h4 {
    margin-bottom: 15px;
    color: #333;
}

.videos-grid, .exams-grid, .assignments-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.video-card, .exam-card, .assignment-card {
    background: #f8f9fa;
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s;
}

.video-card:hover, .exam-card:hover, .assignment-card:hover {
    transform: translateY(-5px);
}

.video-card.completed, .exam-card.completed, .assignment-card.completed {
    border: 2px solid #4caf50;
}

.video-thumbnail {
    position: relative;
    height: 180px;
    background: #eee;
}

.video-thumbnail video {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.completion-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 30px;
    height: 30px;
    background: #4caf50;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.video-info, .exam-info, .assignment-info {
    padding: 15px;
}

.watch-btn, .take-exam-btn, .submit-homework-btn {
    display: inline-block;
    padding: 8px 16px;
    background: #2196f3;
    color: white;
    text-decoration: none;
    border-radius: 4px;
    margin-top: 10px;
    transition: background 0.3s;
}

.watch-btn:hover, .take-exam-btn:hover, .submit-homework-btn:hover {
    background: #1976d2;
}

.submission-info {
    margin-top: 10px;
    padding: 10px;
    background: #e3f2fd;
    border-radius: 4px;
}

.score {
    color: #1976d2;
    font-weight: bold;
}

.submission-date {
    font-size: 12px;
    color: #666;
}

.no-modules {
    text-align: center;
    padding: 40px;
    color: #666;
}

.no-modules i {
    font-size: 48px;
    color: #ccc;
    margin-bottom: 20px;
}

.chat-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #2196f3;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
    margin-top: 10px;
}

.chat-btn:hover {
    background: #1976d2;
    transform: translateY(-2px);
}

.chat-btn i {
    font-size: 1.1em;
}

.teacher-info {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
}
    </style>
</head>
<body>

@include('layouts.Student.header')

<!-- Course Details Section -->
<div class="course-details">
    {{-- message Section --}}
    @if (session('success_message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success_message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</button>
        </div>
    @endif

    @if (session('error_message'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error_message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">&times;</button>
        </div>
    @endif

    {{-- end message Section --}}

    <div class="container">

    <div class="image">
    <img src="{{ asset('Image/' . $course->image) }}" alt="{{ $course->name }}">
</div>

<div class="info" style="display: flex; align-items: flex-start; gap: 20px;">
    <!-- Teacher Image on the Left -->
    <img src="{{ asset('Image/' . $course->teacher->img) }}" 
         alt="{{ $course->teacher->name }}" 
         style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">

    <!-- Course Info on the Right -->
    <div class="text">
        <h2>{{ $course->name }}</h2>
        <div class="code">Course Code: {{ $course->code }}</div>
        <p>{{ $course->code }}</p>
        <div class="code">Course Duration: {{ $course->duration }} (Week)</div>

        <div class="teacher-info">
            <h3>{{ $course->teacher->name }}</h3>
            <a href="{{ route('student.course.chat', ['course_id' => $course->id, 'teacher_id' => $course->teacher->id]) }}" 
               class="chat-btn">
                <i class="fas fa-comments"></i> Chat with Teacher
            </a>
        </div>
    </div>
</div>


            <div class="course-content">
                <h3>Course Modules & Content</h3>
                <div class="module-section">
                    <div class="progress-overview">
                        <div class="progress-bar-container">
                            <div class="progress-bar" style="width: {{ optional($courseProgress)->overall_progress ?? 0 }}%">
                                <span class="progress-text">{{ number_format(optional($courseProgress)->overall_progress ?? 0, 1) }}% Complete</span>
                            </div>
                        </div>
                        <div class="progress-stats">
                            <div class="stat">
                                <i class="fas fa-video"></i>
                                <span>{{ optional($courseProgress)->completed_videos ?? 0 }} Videos</span>
                            </div>
                            <div class="stat">
                                <i class="fas fa-tasks"></i>
                                <span>{{ optional($courseProgress)->completed_assignments ?? 0 }} Assignments</span>
                            </div>
                            <div class="stat">
                                <i class="fas fa-clipboard-check"></i>
                                <span>{{ optional($courseProgress)->completed_exams ?? 0 }} Exams</span>
                            </div>
                        </div>
                    </div>

                    @forelse($course->modules as $module)
                    <div class="module-card">
                        <div class="module-header">
                            <h3>{{ $module->name }}</h3>
                            <div class="module-progress">
                                @php
                                    $totalItems = $module->courseModuleVideos->count() + 
                                                $module->courseModelExams->count() + 
                                                $module->courseModuleHomeWorks->count();
                                    
                                    $completedItems = $module->courseModuleVideos->whereIn('id', $videoProgress->where('completed', true)->pluck('video_id'))->count() +
                                                    $module->courseModelExams->whereIn('id', $examSubmissions->where('completed', true)->pluck('submittable_id'))->count() +
                                                    $module->courseModuleHomeWorks->whereIn('id', $homeworkSubmissions->where('completed', true)->pluck('submittable_id'))->count();
                                    
                                    $moduleProgress = $totalItems > 0 ? ($completedItems / $totalItems) * 100 : 0;
                                @endphp
                                <div class="progress-circle" data-progress="{{ $moduleProgress }}">
                                    <span class="progress-text">{{ number_format($moduleProgress, 0) }}%</span>
                                </div>
                            </div>
                        </div>
                        <p class="module-desc">{{ $module->description }}</p>

                        @if($module->courseModuleVideos->count())
                        <div class="content-section">
                            <h4><i class="fas fa-video"></i> Videos</h4>
                            <div class="videos-grid">
                                @foreach($module->courseModuleVideos as $video)
                                <div class="video-card {{ isset($videoProgress[$video->id]) && $videoProgress[$video->id]->completed ? 'completed' : '' }}">
                                    <div class="video-thumbnail">
                                        <video>
                                            <source src="{{ asset('storage/' . $video->video_url) }}" type="video/mp4">
                                        </video>
                                        @if(isset($videoProgress[$video->id]) && $videoProgress[$video->id]->completed)
                                        <div class="completion-badge">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="video-info">
                                        <h5>{{ $video->name }}</h5>
                                        <p>{{ $video->description }}</p>
                                        <a href="{{ route('student.course.video.show', ['course_id' => $course->id, 'id' => $video->id]) }}" 
                                           class="watch-btn">
                                            <i class="fas fa-play"></i> Watch Video
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($module->courseModelExams->count())
                        <div class="content-section">
                            <h4><i class="fas fa-clipboard-check"></i> Exams</h4>
                            <div class="exams-grid">
                                @foreach($module->courseModelExams as $exam)
                                <div class="exam-card {{ isset($examSubmissions[$exam->id]) && $examSubmissions[$exam->id]->completed ? 'completed' : '' }}">
                                    <div class="exam-info">
                                        <h5>{{ $exam->name }}</h5>
                                        <p>{{ $exam->description }}</p>
                                        <div class="exam-meta">
                                            <span><i class="fas fa-star"></i> {{ $exam->total_mark }} marks</span>
                                            <span><i class="fas fa-clock"></i> {{ $exam->duration }} minutes</span>
                                            <span><i class="fas fa-question-circle"></i> {{ $exam->questions->count() }} questions</span>
                                        </div>
                                        @if(isset($examSubmissions[$exam->id]))
                                        <div class="submission-info">
                                            <div class="score">Score: {{ $examSubmissions[$exam->id]->score }}/{{ $exam->total_mark }}</div>
                                            <div class="submission-date">Submitted: {{ $examSubmissions[$exam->id]->submitted_at->format('M d, Y') }}</div>
                                        </div>
                                        @endif
                                        <a href="{{ route('student.course.exam.show', ['course_id' => $course->id, 'id' => $exam->id]) }}" 
                                           class="take-exam-btn">
                                            @if(isset($examSubmissions[$exam->id]))
                                                <i class="fas fa-eye"></i> View Results
                                            @else
                                                <i class="fas fa-pen"></i> Take Exam
                                            @endif
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        @if($module->courseModuleHomeWorks->count())
                        <div class="content-section">
                            <h4><i class="fas fa-tasks"></i> Assignments</h4>
                            <div class="assignments-grid">
                                @foreach($module->courseModuleHomeWorks as $homework)
                                <div class="assignment-card {{ isset($homeworkSubmissions[$homework->id]) && $homeworkSubmissions[$homework->id]->completed ? 'completed' : '' }}">
                                    <div class="assignment-info">
                                        <h5>{{ $homework->name }}</h5>
                                        <p>{{ $homework->description }}</p>
                                        <div class="assignment-meta">
                                            <span><i class="fas fa-star"></i> {{ $homework->total_mark }} marks</span>
                                            <span><i class="fas fa-clock"></i> {{ $homework->questions->count() }} questions</span>
                                        </div>
                                        @if(isset($homeworkSubmissions[$homework->id]))
                                        <div class="submission-info">
                                            <div class="score">Score: {{ $homeworkSubmissions[$homework->id]->score }}/{{ $homework->total_mark }}</div>
                                            <div class="submission-date">Submitted: {{ $homeworkSubmissions[$homework->id]->submitted_at->format('M d, Y') }}</div>
                                        </div>
                                        @endif
                                        <a href="{{ route('student.course.homework.show', ['course_id' => $course->id, 'id' => $homework->id]) }}" 
                                           class="submit-homework-btn">
                                            @if(isset($homeworkSubmissions[$homework->id]))
                                                <i class="fas fa-eye"></i> View Submission
                                            @else
                                                <i class="fas fa-upload"></i> Submit Assignment
                                            @endif
                                        </a>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                    @empty
                    <div class="no-modules">
                        <i class="fas fa-book"></i>
                        <h3>No modules available</h3>
                        <p>The course content will be added soon.</p>
                    </div>
                    @endforelse
                </div>
            </div>

           

        </div>
    </div>
</div>

<!-- Footer from your original page -->
<div class="footer">
    <div class="container">
        <!-- Footer content -->
    </div>
</div>

<script src="{{ asset('web_assets/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<div class="footer">
    <div class="container">
        <div class="box">
            <h3>Elzero</h3>
            <ul class="social">
                <li>
                    <a href="#" class="facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                </li>
                <li>
                    <a href="#" class="twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                </li>
                <li>
                    <a href="#" class="youtube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </li>
            </ul>
            <p class="text">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Temporibus nulla rem, dignissimos iste aspernatur
            </p>
        </div>
        <div class="box">
            <ul class="links">
                <li><a href="#">Important Link 1</a></li>
                <li><a href="#">Important Link 2</a></li>
                <li><a href="#">Important Link 3</a></li>
                <li><a href="#">Important Link 4</a></li>
                <li><a href="#">Important Link 5</a></li>
            </ul>
        </div>
        <div class="box">
            <div class="line">
                <i class="fas fa-map-marker-alt fa-fw"></i>
                <div class="info">Egypt, Giza, Inside The Sphinx, Room Number 220</div>
            </div>
            <div class="line">
                <i class="far fa-clock fa-fw"></i>
                <div class="info">Business Hours: From 10:00 To 18:00</div>
            </div>
            <div class="line">
                <i class="fas fa-phone-volume fa-fw"></i>
                <div class="info">
                    <span>+20123456789</span>
                    <span>+20198765432</span>
                </div>
            </div>
        </div>
        <div class="box footer-gallery">
            <img src="{{ asset('web_assets/imgs/gallery-01.png') }}" alt="" />
            <img src="{{ asset('web_assets/imgs/gallery-02.png') }}" alt="" />
            <img src="{{ asset('web_assets/imgs/gallery-03.jpg') }}" alt="" />
            <img src="{{ asset('web_assets/imgs/gallery-04.png') }}" alt="" />
            <img src="{{ asset('web_assets/imgs/gallery-05.jpg') }}" alt="" />
            <img src="{{ asset('web_assets/imgs/gallery-06.png') }}" alt="" />
        </div>
        <p class="copyright">Made With &lt;3 By Elzero</p>
        <!-- End Footer -->
        <script src="{{ asset('web_assets/js/main.js') }}"></script>

</body>
</html>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize progress circles
    document.querySelectorAll('.progress-circle').forEach(circle => {
        circle.style.setProperty('--data-progress', circle.dataset.progress);
    });

    // Video completion tracking
    document.querySelectorAll('video').forEach(video => {
        video.addEventListener('ended', function() {
            const videoCard = this.closest('.video-card');
            const videoId = videoCard.dataset.videoId;
            
            fetch(`/courses/videos/${videoId}/complete`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    videoCard.classList.add('completed');
                    // Update progress indicators
                    location.reload();
                }
            });
        });
    });
});
</script>
