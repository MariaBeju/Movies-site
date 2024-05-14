<?php require_once('includes/header.php'); ?>

<div class="container">
        <h1>Search results for: <?php echo $_GET['s']; ?></h1>

        <?php require_once('includes/search-form.php'); ?>

        <?
        $find_movies = array_filter($movies, function($movie){

            if(str_contains(strtolower($movie['title']), strtolower($_GET['s']))){
                return true; 
            }else{
                return false;
            }
                
        }) ?>

        <?php if(count($find_movies)>0){ ?>

        
    <div class="row">
        <?php
                $pct = '...';
                  foreach($find_movies as $movie){ 
                      if(array_key_exists('plot', $movie)){
                        $description = substr($movie['plot'], 0, 110). $pct;
                      } else{
                        $description = '';
                      }
                    ?>
                    <div class="col-md-4" id="<?php echo "movie_" . $movie['id']; ?>">
                      <?php require('includes/archive-movie.php'); ?>
                    </div>
                 <?php unset($description); } ?>
    </div> 
         <?php } else { echo 'No movies';} ?>

</div>

<?php require_once('includes/footer.php'); ?>
