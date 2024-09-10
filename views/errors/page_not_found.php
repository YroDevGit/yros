<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 Page Not Found</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <div class="error-content">
      <h1>404</h1>
      <h2>Oops! Page Not Found</h2>
      <p>We can't seem to find the page you're looking for. It may have been moved or deleted.</p>
      <a href="<?=controller("")?>" class="back-button">Go Back Home</a>
    </div>
  </div>

  <script src="scripts.js"></script>
</body>
</html>

<style>
    * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Poppins', sans-serif;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background: linear-gradient(45deg, #ffcc00, #ff9900);
}

.container {
  text-align: center;
}

.error-content {
  background-color: white;
  padding: 40px;
  border-radius: 15px;
  box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
}

h1 {
  font-size: 6rem;
  color: #ff9900;
  margin-bottom: 20px;
}

h2 {
  font-size: 2rem;
  margin-bottom: 20px;
  color: #333;
}

p {
  font-size: 1.2rem;
  color: #666;
  margin-bottom: 30px;
}

.back-button {
  padding: 15px 30px;
  font-size: 1rem;
  background-color: #ffcc00;
  color: white;
  border: none;
  border-radius: 50px;
  text-decoration: none;
  transition: 0.3s ease-in-out;
}

.back-button:hover {
  background-color: #ff9900;
  box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.2);
}

@media (max-width: 768px) {
  h1 {
    font-size: 4rem;
  }

  h2 {
    font-size: 1.5rem;
  }

  p {
    font-size: 1rem;
  }
}

</style>