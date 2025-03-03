<?php
require_once "/home/comotosho1/data/connect.php";
$connection = db_connect();
$title = "Search Results: Clem's Gems";
include('includes/header.php');
require_once "../private/prepared.php";
if(isset($_GET['index_search']) & $_GET['index_search'] != ""){
    $index_search_value= urldecode($_GET['index_search']);
    $index_search_results= index_search($index_search_value);
}
$per_page = 9;
$total_count = count_records();
$total_pages = ceil($total_count / $per_page);
// if GET['page'] is an int save it or else set it to 1
$current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($current_page < 1 || $current_page > $total_pages) {
    $current_page = 1; // Reset to default page
}

$offset = $per_page * ($current_page - 1);
$result = find_records($per_page, $offset);
?>

<main class="container">


    <section class="row justify-content-center mb-5">
    <h1 class="text-center">Search Results</h1>
        <div class="col col-md-10 col-xl-8">
        <?php
    if ($index_search_results): ?>
                <?php
                while ($items = $index_search_results->fetch_assoc()) {
                    echo '
                    <div class="card" style="width: 18rem; margin: 10px;">
                        <img src="https://comotosho1.dmitstudent.ca/dmit2025/workbook/labs/catalog/private/product_images'. $items['image'] .'" class="card-img-top" alt="Card image">
                        <div class="card-body">
                            <h5 class="card-title">' . $items['title'] . '</h5>
                        </div>
                    </div>
                    ';
                }
                ?>
        </div>
    <?php endif;?>

    </section>
</main>


<?php

include('includes/footer.php');

?>