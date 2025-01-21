<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Courses - Elzero</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f1f5f9;
        }

        .container {
            padding: 0 15px;
            margin: 0 auto;
            max-width: 1200px;
        }

        .header {
            background-color: white;
            box-shadow: 0 2px 15px rgb(0 0 0 / 10%);
            position: relative;
        }

        .header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            position: relative;
        }

        .my-courses {
            padding: 40px 0;
        }

        .my-courses h1 {
            color: #2196f3;
            text-align: center;
            margin-bottom: 40px;
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        .course-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 2px 15px rgb(0 0 0 / 10%);
            transition: transform 0.3s;
            position: relative;
        }

        .course-card:hover {
            transform: translateY(-10px);
        }

        .course-image {
            position: relative;
            overflow: hidden;
            height: 200px;
        }

        .course-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .course-info {
            padding: 20px;
        }

        .course-title {
            color: #2196f3;
            font-size: 1.2em;
            margin-bottom: 15px;
        }

        .week-circle {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: #2196f3;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: bold;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .week-number {
            font-size: 1.2em;
        }

        .week-text {
            font-size: 0.8em;
        }

        .progress-container {
            margin-top: 20px;
            background: #eee;
            height: 10px;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background: #2196f3;
            border-radius: 5px;
            transition: width 0.3s ease;
        }

        .progress-text {
            margin-top: 5px;
            color: #666;
            font-size: 0.9em;
            text-align: right;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="container">
        <a href="#" class="logo">Elzero</a>
        <div class="user-profile">
            <img src="/api/placeholder/40/40" alt="User Profile" class="profile-img">
        </div>
    </div>
</div>

<div class="my-courses">
    <div class="container">
        <h1>My Courses</h1>
        <div class="courses-grid">
            <!-- Course Card 1 -->
            <div class="course-card">
                <div class="course-image">
                    <img src="/api/placeholder/300/200" alt="Web Development">
                    <div class="week-circle">
                        <span class="week-number">12</span>
                        <span class="week-text">weeks</span>
                    </div>
                </div>
                <div class="course-info">
                    <h3 class="course-title">Web Development</h3>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: 75%"></div>
                    </div>
                    <div class="progress-text">75% Complete</div>
                </div>
            </div>

            <!-- Course Card 2 -->
            <div class="course-card">
                <div class="course-image">
                    <img src="/api/placeholder/300/200" alt="Python Programming">
                    <div class="week-circle">
                        <span class="week-number">8</span>
                        <span class="week-text">weeks</span>
                    </div>
                </div>
                <div class="course-info">
                    <h3 class="course-title">Python Programming</h3>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: 45%"></div>
                    </div>
                    <div class="progress-text">45% Complete</div>
                </div>
            </div>

            <!-- Course Card 3 -->
            <div class="course-card">
                <div class="course-image">
                    <img src="/api/placeholder/300/200" alt="UI/UX Design">
                    <div class="week-circle">
                        <span class="week-number">6</span>
                        <span class="week-text">weeks</span>
                    </div>
                </div>
                <div class="course-info">
                    <h3 class="course-title">UI/UX Design</h3>
                    <div class="progress-container">
                        <div class="progress-bar" style="width: 30%"></div>
                    </div>
                    <div class="progress-text">30% Complete</div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
