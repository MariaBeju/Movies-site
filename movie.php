<?php require_once('includes/header.php'); ?>

<?php
              $fav_movies = array();

              $movie_favorites_filename = './assets/movie-favorites.json';
              $fav_stats = json_decode(file_get_contents($movie_favorites_filename), true);

              if(!$fav_stats) $fav_stats = array();

              if(isset($_COOKIE["fav_movies"])){
                $fav_movies = json_decode($_COOKIE["fav_movies"], true);
              }

              if(isset($_POST['fav'])){ 
                if($_POST['fav'] === '1' && !in_array($_GET['movie_id'], $fav_movies)){
                  $fav_movies[] = $_GET['movie_id'];
                  if(array_key_exists($_GET['movie_id'], $fav_stats)){
                    $fav_stats[$_GET['movie_id']]++;
                  }else{
                    $fav_stats[$_GET['movie_id']] = 1;
                  }
              }elseif($_POST['fav'] === '0' && in_array($_GET['movie_id'], $fav_movies)){
                  if(($key = array_search($_GET['movie_id'], $fav_movies)) !== false){
                    unset($fav_movies[$key]);
                    if($fav_stats[$_GET['movie_id']] > 0) $fav_stats[$_GET['movie_id']]--;
                  }
              }
              setcookie("fav_movies", json_encode($fav_movies), time() + (86400 * 30 * 12));
              file_put_contents($movie_favorites_filename, json_encode($fav_stats));
            }

            ?>

    <?php
    $movies_filtered = array_filter($movies, 'movie_by_id');    
        if(isset($movies_filtered) && $movies_filtered){
            $movie = reset($movies_filtered);
        }
    ?>


        <?php 
        $status = FALSE;
          if(isset($_GET['movie_id'])){
            $current_movie = array_filter($movies, function ($movie){
              return $movie['id'] == $_GET['movie_id'];
            });

            if($current_movie){
              $current_movie = reset($current_movie);
              $status = TRUE;
            }
          }
        ?>

    <div class="container">
      <?php if($status){ ?>
        <?php if (isset($movie) && $movie){ ?>
        <br>
        <h1><?php echo $movie['title'];?></h1>

        <div class="col-auto text-end">

                  <form action="" method="POST">
                    <input name="fav" type="hidden" value="<?php echo(in_array($_GET['movie_id'], $fav_movies)) ? "0" : "1";?>">
                    <button type="submit" class="btn btn-danger position-relative">
                      <?php echo(in_array($_GET['movie_id'], $fav_movies)) ? "Delete from favorite" : "Add to favorites";?>

                      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?php echo $current_movie_fav_stats = (isset($fav_stats[$_GET['movie_id']])) ? $fav_stats[$_GET['movie_id']] : 0;?>
                        <span class="visually-hidden"><?php echo $current_movie_fav_stats;?></span>
                      </span>

                    </button>
                  </form>
        </div> 

          <div class="row">
            <div class="col-md-4 col-lg-3">
              <img class="card-img-top" src="<?php echo $movie['posterUrl'];?>" alt="<?php echo $movie['title'];?>">
          </div>
            
          <div class="col-md-8 col-lg-9">

              <div class="row">
                <div class="col-auto">
                  <h2><?php echo $movie['year'];?></h2> 
                </div>
              </div>
  
              <p><?php echo $movie['plot'];?></p>
        <?php } ?>
              <p>Category: <strong><?php if(isset($movie['genres'])) print_r(implode(", ", $movie['genres'])); ?></strong></p>
              <p>Directerd By: <strong><?php echo $movie['director'];?></strong></p>
              <p>Runtime: <strong><?php echo runtime_prettier($movie['year']);?> </strong></p>
             <strong>Cast:</strong>
                <ul>
                    <?php $actors = explode(',',$movie['actors']);
                  foreach ($actors as $actor){echo $actor."<br>";} ?>
                </ul>
            </div>
    </div>

    <?php include_once('includes/movie-reviews.php'); ?>

      <?php } else {?>
        <div class="row">
          <div class="col-md-12">
            <br>
            <div class="d-flex justify-content-center">We have encountered an error!</div>
            <div class="d-flex justify-content-center"><a class="btn btn-outline-secondary" href="movies.php" role="button">All movies</a></div>
          </div>
        </div>
      <?php } ?>
      </div>

<?php require_once('includes/footer.php'); ?>