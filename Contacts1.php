<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Little Thinkers KOTA Puteri</title>
<link rel="stylesheet" href="Contacts.css">
</head>
<body>

<header class="navbar">
  <div class="navbar-brand">
    <img src="LTKP.png" alt="Little Thinkers Kota Puteri" class="logo"> <!-- Replace with your logo -->
    <a href="#" class="brand-name">Little Thinkers Kota Puteri</a>
  </div>
  <nav class="navbar-nav">
    <a href="homepage.php" class="nav-link">Home</a>
    <a href="about1.php" class="nav-link">About</a>
    <a href="howitworks1.php" class="nav-link">How it works</a>
    <a href="fee1.php" class="nav-link">Fee</a>
    <a href="Contacts1.php" class="nav-link">Contacts</a>
    <a href="profile.php" class="nav-link">👤</a>
    
  </nav>
</header> <!-- End of Navbar -->

<div class="hero-section" style="background-image: url('contact background.webp');"> <!-- Replace with your actual background image -->
  <div class="hero-text">
    <h1>Contact LTKP</h1>
    <p>Browse through our most frequently asked questions or fill in the form below to contact us.</p>
    </a>
  </div>
</div>

<body>

<div class="faq-container">
    <h2>Do you have a question for us?</h2>
    <p>These are the three most frequently asked questions.</p>

    <div class="faq">
        <div class="faq-question" onclick="toggleFAQ('faq1')">
            <h3>What is LTKP?</h3>
            <span>+</span>
        </div>
        <div class="faq-answer" id="faq1">
            <p>LTKP is a platform that connects parents with babysitters and child care providers.</p>
        </div>
    </div>

    <div class="faq">
        <div class="faq-question" onclick="toggleFAQ('faq2')">
            <h3>Does registration mean any kind of commitment?</h3>
            <span>+</span>
        </div>
        <div class="faq-answer" id="faq2">
            <p>No, registration is free and you can browse profiles without any commitment.</p>
        </div>
    </div>

    <div class="faq">
        <div class="faq-question" onclick="toggleFAQ('faq3')">
            <h3>Are parents and teachers screened by LTKP?</h3>
            <span>+</span>
        </div>
        <div class="faq-answer" id="faq3">
            <p>Yes, we take measures to ensure the safety and reliability of our users.</p>
        </div>
    </div>
</div>
<script src="Contacts.js" defer></script>
<body>

<div class="contact-form-container">
    <h2>Contact us</h2>
    <p>Fill out the form below to contact us, or send an email to info.LTKP.my</p>
    <form action="submit_contact.php" method="post">
        <label for="name">Your name</label>
        <input type="text" id="name" name="name" required>

        <label for="email">E-mail address</label>
        <input type="email" id="email" name="email" required>

        <label for="subject">Subject</label>
        <input type="text" id="subject" name="subject" required>

        <label for="message">Your question or feedback</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit">Send message</button>
    </form>
</div>

<body>

<footer>
    <div class="footer">
        <div class="footer-column">
            <h3>Search</h3>
            <a href="#">Find a babysitter</a>
            <a href="#">Find babysitting jobs</a>
        </div>
        <div class="footer-column">
            <h3>Popular</h3>
            <a href="#">Babysitter Kuala Lumpur</a>
            <a href="#">Babysitter Petaling Jaya</a>
            <a href="#">Babysitter Johor Bahru</a>
            <a href="#">Babysitter Shah Alam</a>
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