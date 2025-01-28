#!/usr/local/bin/php
<?php
session_save_path(__DIR__.'/sessions/');
session_name('myWebPage');
session_start(); // Start the session

$incorrect_submission = false;  // Initialize the invalid password flag
$username = '';
if (isset($_COOKIE['username'])) {
    $username = $_COOKIE['username'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $submiss = isset($_POST['password']) ? $_POST['password'] : ''; // Get the submitted password
    $submitted_username = isset($_POST['username']) ? $_POST['username'] : '';

    // Read the stored hashed password
    $file = fopen('h_password.txt', 'r');
    $hashedPassword = trim(fgets($file)); // Get and trim the stored hashed password
    fclose($file);

    $hashed_submiss = hash('md2', trim($submiss)); // Hash the submitted password

    if ($hashedPassword === $hashed_submiss) {
        $_SESSION['loggedin'] = true; // Mark user as logged in
        setcookie('username', $submitted_username, time() + 3600, '/'); // Set the username cookie
        header("Location: index.php"); 
        exit; // Stop execution here
    } else {
        $incorrect_submission = true; // Login failed
        session_unset();
        session_destroy();
        setcookie('username', '', time() - 3600, '/'); // Clear cookie
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style.css?v=<?php echo rand(); ?>">
    <script src="username.js" defer></script>
    <script src="login.js" defer></script>
</head>
<header>
<nav class = 'navbar'>
            <ul>
            <li> <a href = "https://www.pic.ucla.edu/~emleong/Final/index.php">Home</a></li>
            <li> <a href = "https://www.pic.ucla.edu/~emleong/Final/login.php">Login</a></li>
            <li> <a href = "https://www.pic.ucla.edu/~emleong/Final/blog.php">Our Posts</a></li>
            <li> <a href = "https://www.pic.ucla.edu/~emleong/Final/merch.php">Our Products</a></li>
            <li><a href = "https://youtu.be/dQw4w9WgXcQ?si=2LzXA3DpYj7KunkK">Contact Us</a></li>
</ul>
</nav>
</header>
<main>
<body id = 'background-3'>
    <div>
    <h1 id="title">Welcome! Ready to check out my webpage?</h1>
    <section id= section>
        <h2>Enter a username.</h2>
        <p>So that you can make your own posts and purchases, select a username and password.</p>
        <form method="POST" action="login.php">
            <fieldset>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" />
                <br/>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" />
                <input type="submit" id="button" value="Login">
            </fieldset>
            <?php if ($incorrect_submission) {
    echo 'Invalid password!';
}
?>
        </form>
        </div>
    </section>
    <hr>
    <footer>&copy; Emily Leong 2024</footer>
</body>
</main>
</html>
