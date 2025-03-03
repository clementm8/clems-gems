<?php
require_once "/home/comotosho1/data/connect.php";
$connection = db_connect();
require_once "../private/prepared.php";
$title = "Clem's Gems";
include('includes/header.php');

$per_page = 9;
$total_count = count_records();
$total_pages = ceil($total_count / $per_page);
// if GET['page'] is an int save it or else set it to 1
$current_page = isset($_GET['page']) ? (int) $_GET['page'] : 1;

if ($current_page < 1 || $current_page > $total_pages) {
    $current_page = 1; // Reset to default page
}

$colors = isset($_GET['colors']) ? $_GET['colors'] : "";
$product_types = isset($_GET['product_types']) ? $_GET['product_types'] : "";
$sizes = isset($_GET['sizes']) ? $_GET['sizes'] : "";


$filter_colors = ['Red', 'Blue', 'Black'];
$filter_product_types = ['Outerwear', 'Footwear', 'Accessories'];
$filter_sizes = ['Small', 'Medium', 'Large', 'XL', '2XL', '3XL'];
$message = '';



$offset = $per_page * ($current_page - 1);
$result = find_records($per_page, $offset);
?>

<main class="container">
    <h1 class="text-center mb-5">Catalog</h1>
    <div class="container flex">
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class='container mt-4 w-25'>
            <h4 class="mb-4">Filters</h4>

            <!-- Filters Container with Flexbox -->
            <div class=" flex-wrap" style="gap: 10px;">

                <!-- Color Filter -->
                <fieldset><div class="card p-3 mb-3 h-25">
                    <legend class="fs-5">Filter by Color</legend>
                    <div class="mb-3 w-25">
                    <div class="d-flex flex-wrap">
                        <?php foreach ($filter_colors as $color): ?>
                            <div class="d-flex align-items-center">
                                <input type="checkbox" name="colors[]" id="<?= htmlspecialchars($color); ?>" value="<?= htmlspecialchars($color); ?>" class="form-check-input me-2"
                                <?php
                                // Check if the color is in the selected publishers array
                                if (isset($_GET['colors']) && in_array($color, $_GET['colors'])) {
                                    echo 'checked';
                                }
                                ?>>
                                <label for="<?= htmlspecialchars($color); ?>" class="form-check-label">
                                <?= htmlspecialchars($color) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </fieldset>

                <!-- Product Type Filter -->
                <fieldset><div class="card p-3 mb-3 h-25">
                    <legend class="fs-5">Filter by Product Type</legend>
                    <div class="mb-3 w-25">
                    <div class="d-flex flex-wrap">
                        <?php foreach ($filter_product_types as $product_type): ?>
                            <div class="d-flex align-items-center">
                                <input type="checkbox" name="product_types[]" id="<?= htmlspecialchars($product_type); ?>" value="<?= htmlspecialchars($product_type); ?>" class="form-check-input me-2"
                                <?php
                                // Check if the product type is in the selected publishers array
                                if (isset($_GET['product_types']) && in_array($product_type, $_GET['product_types'])) {
                                    echo 'checked';
                                }
                                ?>>
                                <label for="<?= htmlspecialchars($product_type); ?>" class="form-check-label">
                                <?= htmlspecialchars($product_type) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </fieldset>

                <!-- Size Filter -->
                <fieldset><div class="card p-3 mb-3 h-25">
                    <legend class="fs-5">Filter by Size</legend>
                    <div class="mb-3 w-25">
                    <div class="d-flex flex-wrap">
                        <?php foreach ($filter_sizes as $size): ?>
                            <div class="d-flex align-items-center">
                                <input type="checkbox" name="sizes[]" id="<?= htmlspecialchars($size); ?>" value="<?= htmlspecialchars($size); ?>" class="form-check-input me-2"
                                <?php
                                // Check if the size is in the selected publishers array
                                if (isset($_GET['sizes']) && in_array($size, $_GET['sizes'])) {
                                    echo 'checked';
                                }
                                ?>>
                                <label for="<?= htmlspecialchars($size); ?>" class="form-check-label">
                                <?= htmlspecialchars($size) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                </fieldset>

                <!-- Apply and Clear Filter Buttons -->
                <div class="m-3">
                            <input class="btn btn-success mx-3" type="submit" value="Apply" name="apply">
                            <input class="btn btn-secondary" type="submit" value="Clear" name="clear">
                </div>

                <?php
                    if (isset($_GET['apply'])) {
                        $query= $filter_records;
                        $parameters = [];
                        $types = "";
                        // Color search - color is a string column to look at
                        if ($colors != "") {
                            $placeholders = implode(",", array_fill(0, count($colors), "?"));
                            $query .= " AND color IN ($placeholders)";

                            // Add the color values to the parameters array
                            $parameters = array_merge($parameters, $colors);

                            // Update the types string to accommodate the new parameters
                            $types .= str_repeat("s", count($colors));
                        }

                        // Product Type search - category is a column to look at
                        if ($product_types != "") {
                            $placeholders = implode(",", array_fill(0, count($product_types), "?"));
                            $query .= " AND category IN ($placeholders)";

                            // Add the color values to the parameters array
                            $parameters = array_merge($parameters, $product_types);
                            

                            // Update the types string to accommodate the new parameters
                            $types .= str_repeat("s", count($product_types));
                        } 

                        
                         // Size search - category is only string column to look at
                         if ($sizes != "") {
                            $placeholders = implode(",", array_fill(0, count($sizes), "?"));
                            $query .= " AND size IN ($placeholders)";

                            // Add the color values to the parameters array
                            $parameters = array_merge($parameters, $sizes);
                            


                            // Update the types string to accommodate the new parameters
                            $types .= str_repeat("s", count($sizes));
                        } 
                        

                        // Sort results
                        // if ($sort_order != "") {
                        //     if ($sort_order == 'descending') {
                        //         $query .= " ORDER By title DESC";
                        //     } elseif ($sort_order == 'ascending') {
                        //         $query .= " ORDER By title ASC";
                        //     }
                        // }
                        if (empty($parameters)) {
                            $message = "<p class='alert alert-danger'>Please choose an option to search by</p>";
                        }

                        if ($message == "") {
                            // var_dump($types);
                            echo "<pre>";var_dump($product_types); echo "</pre>";
                            if ($statement = $connection->prepare($query)) {
                                // Bind parameters if types and parameters are set
                                if ($types && $parameters) {
                                    $statement->bind_param($types, ...$parameters);
                                }

                                // Execute the prepared statement
                                $statement->execute();

                                // Get the result from the executed statement
                                $result = $statement->get_result();

                                // Check if there are any rows returned
                                if ($result->num_rows > 0): ?>
                                    
                                <?php else: ?>
                                    <p>No records found.</p>
                                <?php endif;

                                // Close the statement
                                $statement->close();
                            }
                        } else {
                            echo $message;
                        }
                    }
                ?>
            </div>
        </form>


        <div class="container">
            <!-- Catalog of Records -->
            <?php
            if ($result->num_rows > 0): ?>
                <div class="d-flex flex-wrap justify-content-start mt-5 pt-3">
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        extract($row);
                        echo '<a class="text-centertext-decoration-none text-dark" href="https://comotosho1.dmitstudent.ca/dmit2025/workbook/labs/catalog/public/view.php?title=' . $row['title'] .'">
        <div class="card" style="width: 18rem; margin: 10px;">
            <img src="https://comotosho1.dmitstudent.ca/dmit2025/workbook/labs/catalog/private/product_images'. $row['image'] .'" class="card-img-top" alt="Card image">
            <div class="card-body">
                <h5 class="card-title">' . $row['title'] . '</h5>
            </div>
        </div></a>
        ';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="page-numbers">
            <ul class="pagination justify-content-center">
                <?php
                // Previous button
                if ($current_page > 1): ?>
                    <li class="page-item">
                        <a href="catalog.php?page=<?= $current_page - 1; ?>" class="page-link text-success">Previous</a>
                    </li>
                <?php endif;

                // Always show page 1
                if ($current_page > 2 || $current_page == 1): ?>
                    <li class="page-item">
                        <a href="catalog.php?page=1" class="page-link <?= ($current_page == 1) ? 'active ' : ''; ?>">1</a>
                    </li>
                    <?php if ($current_page > 5): ?>
                        <li class="page-item disabled"><span class="page-link text-success">...</span></li>
                    <?php endif;
                endif;

                // Loop through pages near the current page
                for ($i = max(2, $current_page - 1); $i <= min($total_pages - 1, $current_page + 1); $i++): ?>
                    <li class="page-item <?= ($current_page == $i) ? 'active' : ''; ?>">
                        <a href="catalog.php?page=<?= $i; ?>" class="page-link text-success"><?= $i; ?></a>
                    </li>
                <?php endfor;

                // Display ellipsis before the last page if needed
                if ($current_page < $total_pages - 3): ?>
                    <li class="page-item disabled"><span class="page-link text-success">...</span></li>
                <?php endif;

                // Always show the last page and highlight it if it's the current page
                if ($current_page != $total_pages): ?>
                    <li class="page-item <?= ($current_page == $total_pages) ? 'active' : ''; ?>">
                        <a href="catalog.php?page=<?= $total_pages; ?>" class="page-link text-success"><?= $total_pages; ?></a>
                    </li>
                <?php endif;

                // Always show page 1
                if ($current_page == 12): ?>
                    <li class="page-item">
                        <a href="catalog.php?page=1"
                            class="page-link text-success <?= ($current_page == 12) ? 'active' : ''; ?>">12</a>
                    </li>
                <?php endif;

                // Next button
                if ($current_page < $total_pages): ?>
                    <li class="page-item">
                        <a href="catalog.php?page=<?= $current_page + 1; ?>" class="page-link text-success">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>


    <?php endif;
            ?>

    <section>

    </section>
</main>

<?php

include('includes/footer.php');

?>



