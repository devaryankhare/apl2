<?php
session_start();

// Database configuration
$servername = getenv("DB_HOST") ?: "localhost";
$username = getenv("DB_USER") ?: "root";
$password = getenv("DB_PASS") ?: "";
$dbname = getenv("DB_NAME") ?: "conference_db";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure database exists (safe for managed hosts without CREATE permissions)
try {
    $conn->query("CREATE DATABASE IF NOT EXISTS `$dbname`");
} catch (Exception $e) {
    // Ignore error, managed host databases are already created
}
$conn->select_db($dbname);

// Ensure users table exists
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
)");

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] == 'register') {
        $user = $conn->real_escape_string($_POST['username']);
        $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password) VALUES ('$user', '$pass')";
        if ($conn->query($sql) === TRUE) {
            $message = "Registration successful. Please log in.";
        } else {
            $message = "Error: Username might already exist.";
        }
    } elseif ($_POST['action'] == 'login') {
        $user = $conn->real_escape_string($_POST['username']);
        $pass = $_POST['password'];
        $sql = "SELECT id, username, password FROM users WHERE username='$user'";
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($pass, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $message = "Login successful. Welcome, " . htmlspecialchars($row['username']) . "!";
            } else {
                $message = "Invalid password.";
            }
        } else {
            $message = "User not found.";
        }
    } elseif ($_POST['action'] == 'logout') {
        session_destroy();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$sections = [];
// Fetch sections from database
$sql = "SELECT * FROM sections";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $sections[$row['section_name']] = [
            'id' => $row['id'],
            'title' => $row['title'],
            'content' => $row['content']
        ];
    }
}

// Prepare dynamic authentication section HTML
$auth_html = '<section class="content-section">
    <h2 class="section-title">Account</h2>';

if ($message) {
    $color = stripos($message, 'successful') !== false ? '#28a745' : '#dc3545';
    $auth_html .= '<p style="text-align:center; color: ' . $color . '; font-weight:bold; margin-bottom:20px; font-size:1.1rem;">' . htmlspecialchars($message) . '</p>';
}

if (!isset($_SESSION['user_id'])) {
    $auth_html .= '
    <div style="display:flex; justify-content:center; gap: 40px; flex-wrap: wrap;">
        <div class="card" style="min-width: 320px; text-align: left;">
            <h3 style="margin-bottom:10px; color: var(--primary-blue);">Login</h3>
            <p style="margin-bottom:20px; font-size:0.9rem; color:#666;">Already a registered user?</p>
            <form method="POST" action="">
                <input type="hidden" name="action" value="login">
                <div style="margin-bottom: 15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Username</label>
                    <input type="text" name="username" placeholder="Enter username" required style="width:100%; padding: 12px; border:1px solid #ccc; border-radius:4px; font-size:1rem;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Password</label>
                    <input type="password" name="password" placeholder="Enter password" required style="width:100%; padding: 12px; border:1px solid #ccc; border-radius:4px; font-size:1rem;">
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%">Login</button>
            </form>
        </div>
        <div class="card" style="min-width: 320px; text-align: left;">
            <h3 style="margin-bottom:10px; color: var(--primary-blue);">Register</h3>
            <p style="margin-bottom:20px; font-size:0.9rem; color:#666;">New user?</p>
            <form method="POST" action="">
                <input type="hidden" name="action" value="register">
                <div style="margin-bottom: 15px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Choose Username</label>
                    <input type="text" name="username" placeholder="Choose a username" required style="width:100%; padding: 12px; border:1px solid #ccc; border-radius:4px; font-size:1rem;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display:block; margin-bottom:5px; font-weight:600;">Choose Password</label>
                    <input type="password" name="password" placeholder="Create a password" required style="width:100%; padding: 12px; border:1px solid #ccc; border-radius:4px; font-size:1rem;">
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%; background-color: var(--primary-blue); color: white;">Register</button>
            </form>
        </div>
    </div>';
} else {
    $auth_html .= '
    <div class="card" style="max-width: 400px; margin: 0 auto;">
        <h3 style="margin-bottom:15px; color: var(--primary-blue);">Dashboard</h3>
        <p style="font-size:1.1rem; margin-bottom: 25px;">Welcome back, <strong>' . htmlspecialchars($_SESSION['username']) . '</strong>!</p>
        <form method="POST" action="">
            <input type="hidden" name="action" value="logout">
            <button type="submit" class="btn btn-primary" style="background-color: var(--accent-red); color: white;">Logout</button>
        </form>
    </div>';
}
$auth_html .= '</section>';

$sections['auth'] = [
    'id' => 999,
    'title' => 'Authentication',
    'content' => $auth_html
];

// Determine initial section based on auth presence
$initial_section = 'home';
if ($_SERVER['REQUEST_METHOD'] == 'POST' || $message) {
    $initial_section = 'auth';
}

$db_json = json_encode(['sections' => $sections]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academic Conference 2026</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        /* Core Variables & Resets */
        :root {
            --primary-blue: #1b3a7a;
            --accent-gold: #f4b41a;
            --accent-red: #c0392b;
            --text-main: #333333;
            --text-light: #f5f5f5;
            --bg-light: #ffffff;
            --bg-gray: #f8f9fa;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-gray);
            color: var(--text-main);
            padding-top: 100px;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        /* Navbar container */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: var(--primary-blue);
            color: var(--text-light);
            z-index: 1000;
            box-shadow: var(--shadow);
        }

        .nav-container {
            width: 100%;
            margin: 0 auto;
            padding: 10px 3%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            min-height: 80px;
        }

        .logos-container {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .nav-logo {
            height: 45px;
            width: auto;
            object-fit: contain;
        }

        .nav-links {
            list-style: none;
            display: flex;
            flex: 1;
            justify-content: center;
            gap: 1.5vw;
            margin-left: 20px;
        }

        .nav-item {
            text-decoration: none;
            color: #cbd5e1;
            font-size: 0.95rem;
            font-weight: 600;
            transition: var(--transition);
            padding: 10px 15px;
            border-radius: 4px;
            white-space: nowrap;
        }

        .nav-item:hover,
        .nav-item.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 5px;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background-color: white;
            border-radius: 2px;
        }

        /* Hero Section (Home) */
        .hero-section {
            background: var(--primary-blue);
            color: white;
            padding: 60px 20px;
            text-align: center;
        }

        .hero-theme {
            font-size: 1.1rem;
            color: #cbd5e1;
            margin-bottom: 20px;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1.2;
        }

        .hero-date,
        .hero-venue {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .hero-date {
            color: var(--accent-gold);
        }

        .hero-organized {
            font-size: 0.9rem;
            margin: 20px 0;
            color: #e2e8f0;
        }

        .hero-images {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin: 40px auto;
            max-width: 1000px;
        }

        .hero-images img {
            width: 48%;
            border-radius: 8px;
            border: 3px solid var(--accent-gold);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
            object-fit: cover;
        }

        .cta-buttons {
            margin-top: 30px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .btn {
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            border: none;
            transition: var(--transition);
        }

        .btn-primary {
            background-color: var(--accent-gold);
            color: var(--primary-blue);
        }

        .btn-primary:hover {
            background-color: #e0a316;
            transform: translateY(-2px);
        }

        .deadline-band {
            background-color: var(--accent-red);
            color: white;
            text-align: center;
            padding: 10px;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .content-section {
            padding: 60px 20px;
            max-width: 1100px;
            margin: 0 auto;
            background: var(--bg-light);
            border-radius: 8px;
            box-shadow: var(--shadow);
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .section-title {
            color: var(--primary-blue);
            font-size: 2rem;
            margin-bottom: 30px;
            text-align: center;
            position: relative;
            padding-bottom: 10px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background-color: var(--accent-red);
            border-radius: 2px;
        }

        .section-text {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #555;
            margin-bottom: 20px;
        }

        .grid-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: var(--shadow);
            text-align: center;
            border-top: 4px solid var(--primary-blue);
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
        }

        .card h3 {
            color: var(--primary-blue);
            font-size: 1.25rem;
            margin-bottom: 5px;
        }

        .card .role {
            font-weight: 600;
            color: var(--accent-red);
            margin-bottom: 10px;
        }

        .card p {
            font-size: 0.95rem;
            color: #666;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .data-table th,
        .data-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .data-table th {
            background-color: var(--primary-blue);
            color: white;
        }

        .data-table tr:hover {
            background-color: #f1f5f9;
        }

        .timeline {
            list-style: none;
            position: relative;
            padding-left: 20px;
            border-left: 3px solid var(--primary-blue);
        }

        .timeline li {
            margin-bottom: 25px;
            position: relative;
        }

        .timeline li::before {
            content: '';
            position: absolute;
            left: -29px;
            top: 0;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: var(--accent-gold);
            border: 3px solid white;
        }

        .timeline strong {
            display: block;
            color: var(--primary-blue);
            font-size: 1.1rem;
        }

        .timeline span {
            color: var(--accent-red);
            font-weight: bold;
        }

        footer {
            background-color: #112240;
            color: #8892b0;
            text-align: center;
            padding: 20px;
            margin-top: auto;
        }

        @media screen and (max-width: 1200px) {
            .nav-links {
                display: none;
                flex-direction: column;
                position: absolute;
                top: 80px;
                left: 0;
                width: 100%;
                background-color: var(--primary-blue);
                padding: 20px 0;
                text-align: center;
            }

            .nav-links.active {
                display: flex;
            }

            .hamburger {
                display: flex;
            }

            .hero-title {
                font-size: 2rem;
            }

            .hero-images {
                flex-direction: column;
            }

            .hero-images img {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">
        <div class="nav-container">
            <div class="logos-container">
                <img src="images/11252.png" alt="Logo 1" class="nav-logo"
                    onerror="this.src='https://via.placeholder.com/100x45?text=Logo+1'">
                <img src="images/69856.png" alt="Logo 2" class="nav-logo"
                    onerror="this.src='https://via.placeholder.com/100x45?text=Logo+2'">
                <img src="images/8523.png" alt="Logo 3" class="nav-logo"
                    onerror="this.src='https://via.placeholder.com/100x45?text=Logo+3'">
            </div>
            <ul class="nav-links">
                <li><a href="#" onclick="loadSection('home', event)" class="nav-item">Home</a></li>
                <li><a href="#" onclick="loadSection('committee', event)" class="nav-item">Committee</a></li>
                <li><a href="#" onclick="loadSection('important_dates', event)" class="nav-item">Important Dates</a>
                </li>
                <li><a href="#" onclick="loadSection('speakers', event)" class="nav-item">Speakers</a></li>
                <li><a href="#" onclick="loadSection('workshop', event)" class="nav-item">Workshop</a></li>
                <li><a href="#" onclick="loadSection('submission', event)" class="nav-item">Submission</a></li>
                <li><a href="#" onclick="loadSection('special_session', event)" class="nav-item">Special Session</a>
                </li>
                <li><a href="#" onclick="loadSection('registration', event)" class="nav-item">Registration</a></li>
                <li><a href="#" onclick="loadSection('sponsorship', event)" class="nav-item">Sponsorship</a></li>
                <li><a href="#" onclick="loadSection('contact', event)" class="nav-item">Contact</a></li>
                <!-- Login / Logout Option -->
                <li><a href="#" onclick="loadSection('auth', event)" class="nav-item">
                        <?php echo isset($_SESSION['user_id']) ? 'Logout' : 'Login / Register'; ?>
                    </a></li>
            </ul>
            <div class="hamburger" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </nav>

    <!-- Main Dynamic Content Container -->
    <main id="main-content">
        <!-- Content gets loaded here dynamically via JS -->
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 Academic Conference Platform. All rights reserved.</p>
        <p style="margin-top: 10px; font-weight: 600; color: var(--accent-gold);">Made by Shrey, 24u020037</p>
    </footer>

    <script>
        // Database embedded via PHP
        const database = <?php echo $db_json; ?>;

        // Function to Load Sections Dynamically
        function loadSection(sectionName, event) {
            if (event) event.preventDefault();

            // Validate if section exists
            if (!database.sections || !database.sections[sectionName]) {
                document.getElementById('main-content').innerHTML = `
                    <section class="content-section">
                        <h2 class="section-title">Database Error</h2>
                        <p class="section-text" style="text-align:center;">Could not load section data. Please ensure the database is imported properly.</p>
                    </section>
                `;
                return;
            }

            // Load content dynamically
            document.getElementById('main-content').innerHTML = database.sections[sectionName].content;

            // Highlight active menu item
            document.querySelectorAll('.nav-item').forEach(item => {
                item.classList.remove('active');
            });

            // Find the link that triggered the event, or find it by mapping to add 'active'
            let menuItems = document.querySelectorAll('.nav-item');
            menuItems.forEach(item => {
                let textMatch = item.textContent.toLowerCase().replace(' ', '_');
                if (textMatch === sectionName ||
                    (item.textContent === "Important Dates" && sectionName === "important_dates") ||
                    (item.textContent === "Special Session" && sectionName === "special_session") ||
                    (item.textContent.includes("Login") && sectionName === "auth") ||
                    (item.textContent.includes("Logout") && sectionName === "auth") ||
                    (item.textContent === "Home" && sectionName === "home")) {
                    item.classList.add('active');
                }
            });

            // Close mobile menu if open
            document.querySelector('.nav-links').classList.remove('active');

            // Scroll to top of content
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        // Mobile Menu Toggle
        function toggleMenu() {
            document.querySelector('.nav-links').classList.toggle('active');
        }

        // Load targeted section on first load
        window.onload = () => {
            loadSection('<?php echo $initial_section; ?>');
        };
    </script>
</body>

</html>