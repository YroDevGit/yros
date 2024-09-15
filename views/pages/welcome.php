<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Yros</title>

    <link rel="shortcut icon" href="<?=img('yros.png')?>" type="image/x-icon" height="100%" >
</head>
<body>
    <div class="body">
    <div class="container">
        <div class="logo">
            <img src="<?=img('giphy.gif')?>" alt="Yros Logo">
        </div>
        <h1>Welcome to Yros Framework</h1>
        <p><small style="font-family:monospace;font-size:16px;">Yros is a light-weight PHP framework but can create high quality web applications</small></p>
        <a href="#" class="get-started">Get Started</a>
    </div>
    </div>
    <footer style="display:block;">
        <section>
            Developed by Tyrone Limen Malocon
        </section>
</footer>
    
</body>

<div>

</div>
</html>


<style>
    body{
        background: linear-gradient(to right, rgba(254, 197, 19, 0.8), rgba(255, 255, 255, 0.9));
    }
    .body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    
    display: flex;
    justify-content: center;
    align-items: center;
    height: 90vh;
}

.container {
    text-align: center;
    padding: 20px;
    border-radius: 10px;
    background-color: #fff;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.logo img {
    width: 100px; 
    margin-bottom: 20px;
}

h1 {
    color: #333;
    font-size: 2.5em;
    margin: 0;
    font-family:cursive;
}

p {
    color: #666;
    font-size: 1.2em;
    margin: 10px 0 20px;
}

.get-started {
    display: inline-block;
    padding: 10px 20px;
    font-size: 1em;
    color: #fff;
    background-color: rgba(254, 197, 19, 0.9);
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.get-started:hover {
    background-color: rgba(254, 197, 19, 1);
}

</style>