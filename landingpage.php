<?php
 error_reporting(E_ALL); ini_set('display_errors', 1);
 
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/Database.php';

startSecureSession();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduBridge - Bridging Education for the Future</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS (optional, inline for simplicity) -->
    <style>
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
        }
        .feature-icon {
            font-size: 3rem;
            color: #667eea;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">EduBridge</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <div class="container text-center">
            <h1 class="display-4">Welcome to EduBridge</h1>
            <p class="lead">Bridging the gap between education and innovation. Empowering learners with cutting-edge tools and resources.</p>
            <a href="#contact" class="btn btn-light btn-lg">Get Started</a>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Our Features</h2>
            <div class="row">
                <div class="col-md-4 text-center">
                    <div class="feature-icon mb-3">📚</div>
                    <h5>Interactive Learning</h5>
                    <p>Engage with dynamic content and real-time collaboration tools.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-icon mb-3">🌐</div>
                    <h5>Global Access</h5>
                    <p>Access educational resources from anywhere in the world.</p>
                </div>
                <div class="col-md-4 text-center">
                    <div class="feature-icon mb-3">🚀</div>
                    <h5>Innovative Tools</h5>
                    <p>Utilize AI-powered analytics to track and improve learning outcomes.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="bg-light py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>About EduBridge</h2>
                    <p>EduBridge is dedicated to revolutionizing education by providing a platform that connects educators, students, and innovators. Our mission is to make learning accessible, engaging, and effective for everyone.</p>
                    <p>Founded in 2023, we have helped thousands of learners achieve their goals through our comprehensive suite of tools and resources.</p>
                </div>
                <div class="col-md-6">
                    <img src="https://via.placeholder.com/500x300" alt="About EduBridge" class="img-fluid rounded">
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Contact Us</h2>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Message</label>
                            <textarea class="form-control" id="message" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container text-center">
            <p>&copy; 2023 EduBridge. All rights reserved.</p>
            <p>Follow us on <a href="#" class="text-white">Social Media</a></p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
