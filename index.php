<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Little Thinkers KOTA Puteri</title>
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&family=Roboto+Mono:ital,wght@0,100..700">
</head>
<body>

<header class="navbar">
  <div class="navbar-brand">
    <img src="LTKP.png" alt="Little Thinkers Kota Puteri" class="logo"> <!-- Replace with your logo -->
    <a href="#" class="brand-name">Little Thinkers Kota Puteri</a>
  </div>
  <nav class="navbar-nav">
    <a href="index.php" class="nav-link">Home</a>
    <a href="about.php" class="nav-link">About</a>
    <a href="howitworks.php" class="nav-link">How it works</a>
    <a href="fee.php" class="nav-link">Fee</a>
    <a href="login.php" class="nav-link login-button">Log in</a>
    <a href="register.php" class="nav-link signup-button">Sign up</a>
</nav>
</header> <!-- End of Navbar -->

<div class="hero-section" style="background-image: url('child care.jpg');"> <!-- Replace with your actual background image -->
  <div class="hero-text">
    <h1>Teachers with experience and references</h1>
    <p>Find A Teacher</p>
    
    
  </div>
</div>

<div class="info-section">
  <div class="info-box">
    <h2>Parents, Sign up!</h2>
    <p>Join our community of caring parents! Sign up now to connect with teachers and discover valuable resources for your little ones.</p>
    <a href="register.php" class="parent_signup-btn-link">
    <button class="Sign Up-btn">Sign Up</button>
    </a>
  </div>
  <div class="info-box">
    <h2>Find A Teachers</h2>
    <p>Need a trustworthy babysitter for your child? Explore our network of experienced caregivers ready to provide quality care when you need it.</p>
    <a href="#" class="find-babysitter-btn-link">
    <button class="find-babysitter-btn" id="findBabysitterButton" onclick="showLoginModal()">Find A Teacher</button>
</a>
<div id="loginModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <p>You have to login first.</p>
        <a href="login.php"><button class="login-btn">Login</button></a>
    </div>
</div>
  </div>
 
  <div class="info-box">
    <h2>About</h2>
    <p>Discover the story behind Little Thinkers Kota Puteri. Learn about our mission, values to create a safe and nurturing environment for your child.</p>
    <a href="about.php" class="about-btn-link">
    <button class="About-btn">About</button>
    </a>
  </div>
</div>

<!-- Welcome Section -->
<section class="welcome-section">
  <h2>Welcome to our website</h2>
  <p>Find all you need to know about hiring a teacher.</p>
  <p>Welcome to LTKP - the leading child care job site helping parents locate nannies, after-school carers, and teachers. With just the click of a button, you can access a wonderful range of child care providers just right for your family needs.</p>
  <hr> <!-- Horizontal line -->
  <!-- ... Additional content and layout as needed ... -->
  <style>
    /* Welcome Section Styles */
    .welcome-section {
      text-align: center;
      padding: 100px 20px; /* Increased padding */
      background-color: #fff; /* Background color */
      color: #fff; /* Text color */
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      border-radius: 10px; /* Rounded corners */
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle box shadow */
    }

    .welcome-section h2 {
      font-size: 36px; /* Increased font size */
      margin-bottom: 20px;
    }

    .welcome-section p {
      font-size: 18px; /* Increased font size */
      margin-bottom: 30px;
    }

    .welcome-section hr {
      width: 70%;
      margin: 20px auto;
      border: 1px solid #fff; /* White border */
    }
  </style>
</section>

<body>
    <div class="header">
        <h1>Find A Teacher quick & easy</h1>
    </div>
    <div class="step-container">
        <div class="step">
            <div class="step-icon">
                <img src="search.png" alt="Search Icon"> <!-- Replace with your icon path -->
            </div>
            <h2>Search</h2>
            <ul>
                <li>Check detailed profiles</li>
                <li>Review trustworthy user verifications</li>
                <li>Filter based on your needs</li>
                <li>Sign up</li>
                
            </ul>
        </div>
        <div class="step">
            <div class="step-icon">
                <img src="connect.png" alt="Connect Icon"> <!-- Replace with your icon path -->
            </div>
            <h2>Connect</h2>
            <ul>
                <li>Use our secure messaging service</li>
                <li>Screen, interview and choose</li>
                <li>Free for babysitters</li>
                <li>Affordable for families</li>
                <li>Pricing for families and teachers</li>
            </ul>
        </div>
        <div class="step">
            <div class="step-icon">
                <img src="meeting.png" alt="Meeting Icon"> <!-- Replace with your icon path -->
            </div>
            <h2>Introductory Meeting</h2>
            <ul>
                <li>Agree on a date and time</li>
                <li>Get to know the user in person</li>
            </ul>
        </div>
    </div>
    <script src="index.js"></script>

</body>
</html>

<body>

<footer>
    <div class="footer">
        <div class="footer-column">
            <h3>Search</h3>
            <a href="#">Find a Teacher</a>
            
        </div>
        <div class="footer-column">
            <h3>Popular</h3>
            <a href="#">Teacher Kuala Lumpur</a>
            <a href="#">Teacher Petaling Jaya</a>
            <a href="#">Teacher Johor Bahru</a>
            <a href="#">Teacher Shah Alam</a>
        </div>
        <div class="footer-column">
            <h3>About</h3>
            <a href="#">About LTKP</a>
            <a href="#">How it works</a>
            <a href="#">Fee</a>
            <a href="#">Contact</a>
        </div>
        <div class="footer-column">
            <h3>Contact</h3>
            <a href="#">Lorong Geliga Intan 15</a>
            <a href="#">khairuddin@gmail.com</a>
            <a href="#">016-6379437</a>
            <a href="#">019-2628025</a>
        </div>
    </div>
    <div class="footer-bottom">
        &copy; 2024 Little Thinker Kota Puteri
        <div class="app-stores">
            <a href="https://www.facebook.com/Lthinkers/" class="app-store">
                <img src="facebook.png" alt="App Store">
            </a>
           
        </div>
    </div>
</footer>





</body>
</html>
