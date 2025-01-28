#!/usr/local/bin/php
<?php
session_save_path(__DIR__.'/sessions/');
session_name('myWebPage');
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

// If the session is valid, use the username from the session (or cookie)
$username = isset($_COOKIE['username']) ? $_COOKIE['username'] : '';

// Greet the user if they are logged in
$greeting = "Hello, " . htmlspecialchars($username) . "!";
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Emily Leong</title>
    <link rel="stylesheet" href="style.css?v=<?php echo rand(); ?>">
</head>
<body id = 'background-1'>
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
        <span id="greeting" class = "greeting"><?php echo $greeting;?></span>
        <h1>My Favorite Food: Pho</h1>
    </header>
    <main>
        <section>
            <h2>What is Pho?</h2>
            <p>Pho is a Vietnamese soup made with broth, rice noodles, meat or protein, and various toppings.</p>
            <img src="https://www.pic.ucla.edu/~emleong/images/pho.jpeg" alt="pho">
        </section>
        <section>
            <h2>Types of Pho</h2>
            <ol>
                <li>pho bo (beef pho)</li>
                <li>pho ga (chicken pho)</li>
            </ol>
        </section>
        <section>
            <h2>Why I love Pho</h2>
            <p>There are several reasons why I LOVE PHO!!!</p>
            <ul>
                <li>It's comforting and makes me feel warm on the inside.</li>
                <li>The broth is super flavorful.</li>
                <li>When you put the noodles with the meat and sauce together it makes for the perfect bite.</li>
            </ul>
        </section>
        <section>
            <h2>Some recent posts by other users:</h2>
            <p><b>GerryActressKnits</b> says: Does anyone have a good suggestion for how to join yarn best? I usually would do a Russian join, but I am using cotton and the yarn is slippery.</p>
            <p><b>malicious666</b> says: Could anyone see how I can fix my <a href="scarf1.html" target="_blank" rel="opener">scarf</a>? Please help. I'm so sad. Here's a <a href="scarf2.html" target="_blank" rel="opener">picture</a> of the other side.</p>
            <p><b>MargeSimpson</b> says: I like yarn. I just think they're neat.</p>
        </section>
    </main>
    <footer>
        &copy; Emily Leong, 2024
    </footer>
</body>
</html>