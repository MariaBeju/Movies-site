<div class="card">
  <img alt="<?php echo $movie["posterUrl"]; ?>" loading="lazy" slot="image" src="<?php echo $movie["posterUrl"]; ?>">
    <div class="card-body">
      <h5 class="card-title"><?php echo $movie["title"]; ?></h5>
      <p class="card-text"><?php echo  $description; ?></p>
      <a href="./movie.php?movie_id=<?php echo $movie["id"];?>" class="btn btn-outline-secondary">Read more</a>
    </div>
</div>
