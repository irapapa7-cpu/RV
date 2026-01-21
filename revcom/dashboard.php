<?php
session_start();
include "db.php";

// Check if user is logged in
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

// TMDB API
$api_key = "1163142a130a2e01a5fb73752ac05995"; // your API key
$tmdb_url = "https://api.themoviedb.org/3/movie/popular?api_key=$api_key&language=en-US&page=1";

// Fetch movies
$movies_json = file_get_contents($tmdb_url);
$movies = json_decode($movies_json, true)['results'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>REVCOM - Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: 'Montserrat', sans-serif; background: #f6f5f7; margin: 0; padding: 20px; }
        .movie-container { display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; }
        .movie-card { background: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); width: 200px; text-align: center; overflow: hidden; }
        .movie-card img { width: 100%; height: 300px; object-fit: cover; }
        .movie-card h3 { margin: 10px 0; font-size: 16px; }
        .movie-card p { font-size: 14px; color: #555; margin: 0 10px 10px; }
        .review-btn { background: #FF4B2B; color: #fff; border: none; padding: 8px 12px; border-radius: 5px; cursor: pointer; margin-bottom: 10px; }
        .logout { position: fixed; top: 20px; right: 20px; background: #FF4B2B; color: #fff; border: none; padding: 10px 15px; border-radius: 5px; cursor: pointer; }
    </style>
</head>
<body>
    <button class="logout" onclick="window.location.href='logout.php'">Logout</button>
    <h1>Welcome to REVCOM!</h1>
    <div class="movie-container">
        <?php foreach($movies as $movie): ?>
            <div class="movie-card">
                <img src="https://image.tmdb.org/t/p/w500<?php echo $movie['poster_path']; ?>" alt="<?php echo $movie['title']; ?>">
                <h3><?php echo $movie['title']; ?></h3>
                <p>Rating: <?php echo $movie['vote_average']; ?>/10</p>
                <button class="review-btn" onclick="window.location.href='reviews.php?movie_id=<?php echo $movie['id']; ?>'">Write Review</button>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
