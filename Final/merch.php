#!/usr/local/bin/php
<?php
session_save_path(__DIR__.'/sessions/');
session_name('myWebPage');
session_start(); // Start the session

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php'); // Redirect to login.php if not logged in
    exit;
}

if (!isset($_COOKIE['username']) || $_COOKIE['username'] === '') {
    header('Location: login.php'); // Redirect to login.php if no username cookie
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Our Merchandise</title>
    <link rel="stylesheet" href="style.css?v=<?php echo rand(); ?>">
    <script src="merch.js?v=32" defer></script>
  </head>

<?php

$username = $_COOKIE['username'];

$db = new SQLite3('credit.db');

// Create table in db if not exists
$db->exec("CREATE TABLE IF NOT EXISTS users (username TEXT, credit REAL)");

$query = "SELECT credit FROM users WHERE username = '$username'";
$result = $db->query($query);

if($row = $result->fetchArray()){
  // If existing user gets credit from before
  $credit = $row['credit'];
} else {
  // New user gets default credit
  $credit = 20.00;
  $db->exec("INSERT INTO users (username, credit) VALUES ('$username', $credit)");
}

$db->close();

?>
<main>
<body id=background-4>
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
        <h1>Our Merchandise</h1>
    </header>
    
    <section>
        <h2>Sonny Angels</h2>
        <p>Please have a look around. Our new members are awarded with $20.00 in credit. You can add credit at any time with a coupon code. When you want to make a purchase, please select the checkboxes of the items you wish to purchase and click the "Checkout" button below.</p>
        <p id='credit'>
          <?php
            echo 'Your Credit: $' . number_format($credit, 2);
          ?>
        </p>
        
        <table>
            <tbody>
            <tr>
                <td>
                    <img src="https://sonnyangelusa.com/cdn/shop/products/products_thumbnail_animal-series-ver-1_1.jpg?v=1610115126" alt="Sonny Angel Animal Series">
                    <h3>Animal Series</h3>
                    <input type="checkbox" id="check1" class="price"><span></span>
                    <p>One Sonny Angel Animal Series blind box</p>
                </td>
                <td>
                    <img src="https://sonnyangelusa.com/cdn/shop/products/products_thumbnail_minifigure-sweets-series-2019_1_828x.jpg?v=1610121513" alt="Sonny Angel Sweets Series">
                    <h3>Sweets Series</h3>
                    <input type="checkbox" id="check2" class="price"><span></span>
                    <p>One Sonny Angel Sweets Series blind box</p>
                </td>
            </tr>
            <tr>
                <td>
                    <img src="https://sonnyangelusa.com/cdn/shop/products/products_thumbnail_minifigure-fruit-series-2019_1_828x.jpg?v=1610116999" alt="Sonny Angel Fruit Series">
                    <h3>Fruit Series</h3>
                    <input type="checkbox" id="check3" class="price"><span></span>
                    <p>One Sonny Angel Fruit Series blind box</p>
                </td>
                <td>
                    <img src="https://sonnyangelusa.com/cdn/shop/products/products_thumbnail_minifigure-marine-series-2019_1_828x.jpg?v=1610117542" alt="Sonny Angel Marine Series">
                    <h3>Marine Series</h3>
                    <input type="checkbox" id="check4" class="price"><span></span>
                    <p>One Sonny Angel Marine Series blind box</p>
                </td>
            </tr>
    </tbody>
        </table>
    </section>

    <section aria-label="Merch">
        <div>
            <fieldset>
                <label for="coupon">Coupon Code:</label>
                <input type="text" id="coupon">
                <button type="button" id="checkout">Checkout</button>
                <p></p>
                <span id="response"></span>
            </fieldset>
        </div>
    </section>

    <footer>
        <p>&copy; Emily Leong 2024</p>
    </footer>
</body>
</main>
</html>
