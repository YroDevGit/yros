<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Yros</title>

    <link rel="shortcut icon" href="<?=img('yros.ico')?>" type="image/x-icon" height="100%" >
</head>
<body>
    <div class="body">
        <div class="container">
            <div class="logo">
                <img src="<?=img('giphy.gif')?>" alt="Yros Logo">
            </div>
            <h1>Welcome to Yros Framework</h1>
            <div>
                <p><small>version <b>2.2</b> (Updated: Oct 14 2024)</small></p>
            </div>
            <p><small style="font-family:monospace;font-size:16px;">Yros is a light-weight PHP framework but can create high quality web applications</small></p>
            <div class="row">
                <small>Download updated version <a href="https://yrosframework.blogspot.com/p/blog-page.html" target="_blank">@Yros website</a></small>
            </div>
            <a href="https://www.youtube.com/@YROS-z4y/videos" target="_blank" class="get-started">Get Started</a>
        </div>
    </div>
    <footer style="display:block;">
        <section align='center'>
            <a href="" target="_blank" class="anchored-link dev-mono" title="Tyrone Limen Malocon"><small>Developed by: CodeYro Team</small></a>
        </section>
    </footer>

    <script>
        document.addEventListener('mousemove', function(e) {
            const fire = document.createElement('div');
            fire.classList.add('fire-flame');
            fire.style.left = `${e.pageX}px`;
            fire.style.top = `${e.pageY}px`;

            document.body.appendChild(fire);

            setTimeout(() => {
                fire.remove();
            }, 10000); 
        });
    </script>
</body>
</html>


<style>
    body {
        background: linear-gradient(to right, rgba(254, 197, 19, 0.8), rgba(255, 255, 255, 0.9));
    }


    .row{
        padding: 5px 0px 15px 0px;
    }
    .dev-mono{
        font-family: monospace;
        font-size: 15px;
    }

    .body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 80vh;
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
        font-family: cursive;
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

    .anchored-link {
        text-decoration: none;
        color: black;
        cursor: pointer;
    }

    .anchored-link:hover {
        color: blue;
    }

    .fire-flame {
        position: absolute;
        width: 12px;
        height: 8px;
        background: linear-gradient(to top, rgba(255, 69, 0, 0.8), rgba(255, 140, 0, 0.6), transparent);
        border-radius: 50%;
        pointer-events: none;
        animation: fire-animation 0.3s ease-out forwards;
        filter: blur(1px);
        opacity: 0.7;
    }

    @keyframes fire-animation {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        100% {
            transform: scale(1.5) translateY(-20px);
            opacity: 0;
        }
    }

    .fire-flame::before {
        content: '';
        position: absolute;
        top: -10px;
        left: -5px;
        width: 13px;
        height: 10px;
        background: linear-gradient(to top, rgba(255, 140, 0, 0.6), transparent);
        border-radius: 50%;
        filter: blur(1px);
        animation: fire-glow 0.3s ease-out forwards;
    }

    @keyframes fire-glow {
        0% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }
</style>
