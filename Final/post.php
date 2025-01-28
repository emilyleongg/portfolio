#!/usr/local/bin/php
<?php
header('Content-Type: text/plain; charset=utf-8');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    echo 'post successfully written';

    $file = fopen('posts.txt','a');

    if ($_POST['author'] === ''){
        $author = $_COOKIE['username'];
    }else{
        $author = $_POST['author'];
    }
    $content = $_POST['content'];    
    $content = str_replace("\n", "<br>", $content);
    $content = str_replace("  ", " &nbsp;", $content);

    fwrite($file, "<p><b>$author</b> says: $content<br></p>");
    fclose($file);

}

if($_SERVER['REQUEST_METHOD'] === 'GET'){
    echo 'Nobody has made a post.';
}

?>

