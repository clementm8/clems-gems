<?php
require_once "/home/comotosho1/data/connect.php";
$connection = db_connect();
require_once "../private/prepared.php";

include('includes/header.php');
$title = "Delete an item";
$message = '';
$result = find_records();

?>


<div class=" container my-5">
    <h1 class="fw-light text-center mt-5">Current items in the catalog</h1>
    <p class="text-muted mb-5 text-center">To delete an item, click delete.</p>
    <?php if ($message != ''): ?>
        <div class="bg-danger p-3 text-white">
            <?= $message ?>
        </div>
    <?php endif; ?>

    <div class="container">
            <!-- Catalog of Records -->
            <?php
            if ($result->num_rows > 0): ?>
                <div class="d-flex flex-wrap justify-content-start mt-5 pt-3">
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        extract($row);
                        echo '<a class="text-center text-decoration-none text-dark" href="https://comotosho1.dmitstudent.ca/dmit2025/workbook/labs/catalog/public/view.php?title=' . $row['title'] .'">
        <div class="card" style="width: 18rem; margin: 10px;">
            <img src="https://comotosho1.dmitstudent.ca/dmit2025/workbook/labs/catalog/private/product_images'. $row['image'] .'" class="card-img-top" alt="Card image">
            <div class="card-body">
                <h5 class="card-title">' . $row['title'] . '</h5>
                <div class="text-center mt-2">
                    <a href="delete-confirmation.php?id=' . urlencode($id) . '" class="btn btn-danger text-decoration-none text-white">Delete</a>
                </div>
            </div>
        </div></a>
        ';
                    }
                    ?>
                </div>
            </div>
        </div>
</div>
<?php endif;?>
</main>
<?php include "includes/footer.php";