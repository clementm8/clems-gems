<?php
require_once "/home/comotosho1/data/connect.php";
$connection = db_connect();
$title = "Item Details: Clem's Gems";
include('includes/header.php');
require_once "../private/prepared.php";
$title = isset($_GET['title']) ? urldecode($_GET['title']) : "Oops";

?>

<main class="container flex-column d-flex align-items-center">
    <div class="card col-md-10 col-lg-8 col-xxl-6">
        <?php
            if ($title == "Oops"): ?>
                <h2 class="display-5"> Oh no!</h2>
                <p>We couldnt find that item.</p>
                <a href="index.php" class="btn btn-success">Back to item List</a>
            <?php else: ?>

                <?php
                $item= get_item_by_title($title);

                if ($item != []) { ?>
                    <?php
                        $title= $item['title'];
                        $description= $item['description'];
                        $rating= $item['rating'];
                        $review= $item['review'];
                        $category= $item['category'];
                        $material= $item['material'];
                        $brand= $item['brand'];
                        $size= $item['size'];
                        $image= $item['image'];
                 ?>
                <div class='card px-0'>
                    <div class="card-header text-bg-dark">
                        <h3 class="card-title fw-light fs-5">
                            <?= $title; ?>
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                        <img width="500" height="500"
                        src= <?="https://comotosho1.dmitstudent.ca/dmit2025/workbook/labs/catalog/private/product_images". $image; ?>>
                        </div>
                        <p class="card-text">
                            <span class="fw-bold">Title:</span>
                            <?= $title; ?>
                        </p>
                        <p class="card-text">
                            <span class="fw-bold">Description:</span>
                            <?= $description; ?>
                        </p>
                        <p class="card-text">
                            <span class="fw-bold">Size:</span>
                            <?= $size; ?>
                        </p>
                        <p class="card-text">
                            <span class="fw-bold">Rating:</span>
                            <?= $rating; ?>
                        </p>
                        <p class="card-text">
                            <span class="fw-bold">Review:</span>
                            <?= $review; ?>
                        </p>
                        <p class="card-text">
                            <span class="fw-bold">Category:</span>
                            <?= $category; ?>
                        </p>
                        <p class="card-text">
                            <span class="fw-bold">Material:</span>
                            <?= $material; ?>
                        </p>
                        <p class="card-text">
                            <span class="fw-bold">Brand:</span>
                            <?= $brand; ?>
                        </p>
                    </div>
                        <?php
                    }
                 else { ?>
                    <h2 class="display-5"> Oh no!</h2>
                    <p>We couldnt find that item.</p>
                    <a href="index.php" class="btn btn-success">Back to the Catalog</a>
                <?php }
                ?>
                <?php endif; ?>
    </div>
</main>

<?php

include('includes/footer.php');

?>