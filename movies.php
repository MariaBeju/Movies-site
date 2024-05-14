<?php require_once('includes/header.php'); ?>

      <div class="container">
        <h1>Movies</h1>
          <div class="row">

                <?php
                $pct = '...';
                  foreach($movies as $movie){ 
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
      </div>

<?php require_once('includes/footer.php'); ?>