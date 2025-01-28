#!/usr/local/bin/php
<?php
session_save_path(__DIR__.'/sessions/');
session_name('myWebPage');
session_start(); // Start the session

// Check if the user is logged in, if not, redirect them to login.php
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Check if the username is set in the cookies, if not, redirect them to login.php
if (!isset($_COOKIE['username']) || $_COOKIE['username'] === '') {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Our Posts</title>
<link rel="stylesheet" href="style.css?v=<?php echo rand(); ?>">
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
<body>
<header>
    <h1>Blog Posts</h1>   
</header>
<main>
<div id = 'contentbox'>
    <form enctype = "multipart/form-data" method="POST" action= "post.php">
        <label for= "author">Author:</label>
        <input type="text" id="author" name="author" value = "<?php echo $_COOKIE['username'];?>">
        <br>
        <label for="content">Content:</label>
        <textarea id="content" name="content"></textarea><br><br>
        <input type="submit" value="Post">
    </form>
    <section>
        <h2>Posts by other users:</h2>
        <?php
        $file = @fopen('posts.txt', 'r');
        if($file){
            while(!feof($file)){
                $line = fgets($file);
                echo $line;
            }
            fclose($file);
        }
        ?>
    </section>
    </div>
</main>
<hr></hr>
<footer>
    &copy; Emily Leong 2024
</footer>
</body>
</html>