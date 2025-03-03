<?php
require_once "/home/comotosho1/data/connect.php";
$connection = db_connect();
require_once "../private/prepared.php";
$title = "Clem's Gems";
include('includes/header.php');

$per_page = 10;
$total_count = count_records();
$random_number = rand(1, $total_count);
$featured= get_item_by_id($random_number);
$total_pages = ceil($total_count / $per_page);
// if GET['page'] is an int save it or else set it to 1
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

if ($current_page < 1 || $current_page > $total_pages) {
    $current_page = 1; // Reset to default page
}

// No warnings will occur with this approach


$offset = $per_page * ($current_page - 1);
$result = find_records($per_page, $offset);
?>

<main class="container">
    <section class="row justify-content-between my-5">

        <!-- Introduction -->
        <div class="col-md-10 col-lg-8 col-xxl-6 mb-4">
            <h2 class="display-4">Welcome to <span class="d-block" style="color: #198754">Clem's Gems</span></h2>
            <p>Take a peek into my wardrobe and explore all my favorite pieces. Search, sort, and filter to find something you love in my collection.</p>
            <div class="btn btn-success text-align-left w-25 "> <a href="catalog.php" class="text-decoration-none text-white">Browse the catalog</a></div>
        </div>

        <!-- Random Title Feature: If you choose to do the randomised title challenge, include it here. -->
        <div
            class="col col-lg-4 col-xxl-3 m-4 m-md-0 mb-md-4 border border-success rounded p-3 d-flex flex-column justify-content-center align-items-center">
            <h2 class="fw-light mb-3">Featured Item</h2>
            <img wuidth='250' height='250' src="https://comotosho1.dmitstudent.ca/dmit2025/workbook/labs/catalog/private/product_images<?= $featured['image']?>" alt="Card image">
            <p><?= $featured['title'] ?></p>

            <?php echo "<a class='btn btn-success' href='view.php?title=" . urlencode($featured['title']) . "'>View Item</a>"?>
        </div>
    </section>

    <section>

    </section>
</main>

<?php

include('includes/footer.php');

?>