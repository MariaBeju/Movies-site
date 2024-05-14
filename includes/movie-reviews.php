<?php 

$conn = db_connect();
$reviews_data = array(
    'show_reviews_form' => false
);

if(!$conn){
    $reviews_data['show_reviews_form'] = false;
}

$sql = "CREATE TABLE IF NOT EXISTS reviews (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    movie_id bigint(20) UNSIGNED NOT NULL,
    full_name tinytext NOT NULL,
    email varchar(100) NOT NULL,
    review TEXT NOT NULL
)";

if(mysqli_query($conn, $sql)){

    $reviews_data['show_reviews_form'] = true;
    $sql_all_reviews = "SELECT full_name, email, review FROM reviews WHERE movie_id = " . $_GET['movie_id'];
    $reviews_list = mysqli_query($conn, $sql_all_reviews);

    $reviews_data['count'] = mysqli_num_rows($reviews_list);

    if($reviews_data['count'] > 0){
        $reviews_data['list'] = mysqli_fetch_all($reviews_list, MYSQLI_ASSOC);
        $reviews_emails = array_column($reviews_data['list'], 'email');
    }

    if(isset($_POST['reviews_form'])){
        if(isset($reviews_emails) && in_array($_POST['email'], $reviews_emails)){
            $reviews_data['alert'] = 'danger'; 
            $reviews_data['message'] = 'A aparut o eroare. Review-ul nu a putut fi adaugat. Mai incearca!';
        }else{
            $movie_id = mysqli_real_escape_string($conn, $_GET['movie_id']);
            $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $review = mysqli_real_escape_string($conn, $_POST['review']);
            $sql = "INSERT INTO reviews (movie_id, full_name, email, review)
            VALUES ('" . $movie_id ."','". $full_name ."', '". $email ."', '". $review ."')";

            if(mysqli_query($conn, $sql)){
                // If the review was successfully added to the database
                $reviews_data['show_reviews_form'] = false;
                $reviews_data['alert'] = 'success';
                $reviews_data['message'] = 'Formularul a fost trimis cu succes.';

                $reviews_data['list'] [] = array(
                    'full_name' =>  $_POST['full_name'],
                    'email' =>  $_POST['email'],
                    'review' => $_POST['review']
                );
                $reviews_data['count']++;
            }else {
                // If the review has not been added to the database, I set an error
                $reviews_data['alert'] = 'danger';
                $reviews_data['message'] = 'A aparut o eroare. Review-ul nu a putut fi adaugat. Mai incearca!';
            }
        }
    }
}

?>

<?php if(isset($reviews_data['message']) && isset($reviews_data['alert'])){ ?>

<div class="alert my-3 alert-<?php echo $reviews_data['alert']; ?>" role="alert">
    <?php echo $reviews_data['message']; ?>
</div>
<?php } ?>

<?php if($reviews_data['show_reviews_form'] == true){ ?>
    <div class = "my-3 p-3 bg-light border">
        <div class = "mb-3 pb-3 border-bottom">
            <?php
                if($reviews_data['count'] > 0){
                    echo 'Lasa un review pentru acest film';
                } else {
                    echo 'Fi primul care lasa un review pentru acest film';
                }
        }     ?>
        </div>
<?php if($reviews_data['show_reviews_form'] == true){?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="full_name">Full name</label> <br>
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?php if(isset($_POST['full_name'])) echo $_POST['full_name']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="email">Email</label> <br>
                <input type="email" class="form-control" id="email" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="review">Review</label> <br>
                <textarea class="form-control" id="review" name="review" required><?php if(isset($_POST['review'])) echo $_POST['review']; ?></textarea>
            </div>

            <div class="mb-3">
                <input type="checkbox" id="acceptance" name="acceptance" value="acceptance" required>
                <label for="acceptance"> Accept termenii de procesare a datelor cu caracter personal</label>
            </div>

            <input type="submit" class="btn btn-primary" name="reviews_form" value="Trimite">

        </form>
    </div>
<?php } ?>

<?php if(isset($reviews_data['count']) && $reviews_data['count'] > 0){ ?>
    <div class = "h4 mt-4">
        Reviews
    </div>
    <?php foreach(array_reverse($reviews_data['list']) as $review){ ?>
        <div class = "my-3 p-3 border">
            <div class = "fw-bold pb-3 mb-3 border-bottom">
                <?php echo $review['full_name']; ?>
            </div>

            <?php echo $review['review']; ?>
        </div>
    <?php } ?>
<?php } ?>