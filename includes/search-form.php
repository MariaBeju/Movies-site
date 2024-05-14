<form class="d-flex" method="GET" action="./search-results.php">
    <input class="form-control me-2" type="search" name="s" value="<?php if(isset($_GET['s'])){ echo $_GET['s'];}; ?>" placeholder="Search" aria-label="Search">
    <button class="btn btn-outline-success" type="submit">Search</button>
</form> 





