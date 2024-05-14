<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Beju Maria</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
      <link rel="stylesheet" href="styles.css"/>
  </head>

  <body>
    <?php require('includes/functions.php'); ?>

      <section class="header-section">
      <?php define('LOGO', 'BM'); ?>
        
          <?php 
            $navItems = array(
              array(
                'title' => 'Movies',
                'permalink' => 'movies.php',
              ),
              array(
                'title' => 'Contact',
                'permalink' => 'contact.php',
              ),
            );
          ?>

          <nav class="navbar navbar-expand-lg navbar-light bg-light" id="header">
            <div class="container-fluid">

              <a class="navbar-brand" href="movies.php"><?php echo LOGO; ?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php foreach($navItems as $item) { ?>
                      <li class="nav-item">
                        <a class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == $item['permalink']) ? "active" : ""; ?>" aria-current="page" href="<?php echo $item['permalink']; ?>"> <?php echo $item['title']; ?> </a>
                      </li>
                    <?php } ?>
                  </ul>
                  <?php require('includes/search-form.php'); ?>  
                </div>    
            </div>
          </nav>
      </section>

          <?php 
          $i=0;
              $movies = json_decode(file_get_contents('./assets/movies-list-db.json'), true)['movies'];
           ?>

          


              