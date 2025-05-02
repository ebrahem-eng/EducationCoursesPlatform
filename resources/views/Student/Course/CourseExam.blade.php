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
     .course-details {
        padding: 40px 0;
    }
    
    .videos-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .video-card {
        background: #fff;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    
    .video-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
    }
    
    .video-card video {
        width: 100%;
        height: auto;
        min-height: 250px;
        border-radius: 8px;
        background: #000;
    }
    
    .video-info {
        padding: 15px 5px 5px;
        text-align: right;
    }
    
    .video-info strong {
        display: block;
        font-size: 18px;
        color: #333;
        margin-bottom: 8px;
    }
    
    .video-info p {
        color: #666;
        font-size: 14px;
        line-height: 1.5;
        margin: 0;
    }
    
    .module-section h3 {
        color: #2196f3;
        font-size: 24px;
        margin-bottom: 15px; 
        padding-bottom: 10px;
        border-bottom: 2px solid #f0f0f0;
    }
    
    .module-section h4 {
        color: #444;
        font-size: 20px;
        margin: 25px 0 15px;
    }
    
    @media (max-width: 768px) {
        .videos-list {
            grid-template-columns: 1fr;
        }
        
        .video-card video {
            min-height: 200px;
        }
    }
    
    @media (max-width: 480px) {
        .videos-list {
            gap: 15px;
        }
        
        .video-card {
            padding: 10px;
        }
        
        .module-section h3 {
            font-size: 20px;
        }
        
        .module-section h4 {
            font-size: 18px;
        }
    }
</style>
</head>

<body>

    @include('layouts.Student.header')



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
                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Temporibus nulla rem, dignissimos iste
                    aspernatur
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
