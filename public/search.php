<?php
require_once "/home/comotosho1/data/connect.php";
$connection = db_connect();

$title = "Advanced Search: Clem's Gems";
include('includes/header.php');
require_once "../private/prepared.php";
$message = '';
$title_search = isset($_GET['title_search']) ? htmlspecialchars(trim($_GET['title_search'])) : "";
$category_name = isset($_GET['category_name']) ? trim($_GET['category_name']) : "";
$brands = isset($_GET['brands']) ? $_GET['brands'] : "";
$sort_order = isset($_GET['sort_order']) ? trim($_GET['sort_order']) : "";
$categories = [
    "Please select a category",
    "Colognes",
    "Accessories",
    "Tshirts",
    "Footwear",
    "Hoodies and Sweatshirts",
    "OuterWear and Jackets",
    "Characters"
];
$brands_options = [
    "Nike",
    "Timberland",
    "Tommy Hilfiger",
    "Dime",
    "AsianSupplyCo",
    "Fubu",
    "Market",
    "LE31",
    "Jordan",
    "Puma",
    "Adidas",
    "Vitaly",
    "Dior",
    "Hugo Boss",
    "Versace",
    "Ysl",
    "Zara"
];


?>

<main class="container">
    <section class="row justify-content-center mb-5">
        <div class="col col-md-10 col-xl-8">
            <h2 class="display-5 mb-5">Advanced Search</h2>
            <section class="row justify-content-center">
                <div class=" col-12">
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>"
                        class="px-3 mb-5 border border-success pt-3 rounded">

                        <!-- By name -->
                        <div class="mb-3 m-3">
                            <label for="title_search">Enter Item Name:</label>
                            <input type="search" name="title_search" id="title_search" class="form-control"
                                value="<?= isset($_GET['title_search']) ? htmlspecialchars(trim($_GET['title_search'])) : ''; ?>">
                        </div>

                        <!-- By Category -->
                        <fieldset class='my-5'>
                            <legend class="fs-5"> By Category: </legend>
                            <div class="mb-3">
                                <select name="category_name" id="category_name" class="form-select">
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= htmlspecialchars($category) ?>" <?php if ($category_name == $category)
                                              echo 'selected'; ?>>
                                            <?= $category ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </fieldset>

                        <!-- By Brand -->
                        <fieldset class='my-5'>
                            <legend class="fs-5">Filter by Brand</legend>
                            <div class="mb-3">
                                <div class="d-flex flex-wrap gap-2">
                                    <?php foreach ($brands_options as $brand): ?>
                                        <div class="d-flex align-items-center">
                                            <input type="checkbox" name="brands[]" id="<?= htmlspecialchars($brand); ?>"
                                                value="<?= htmlspecialchars($brand); ?>" class="form-check-input me-2"; <?php
                                                  // Check if the brand is in the selected brands array
                                                  if (isset($_GET['brands']) && in_array($brand, $_GET['brands'])) {
                                                      echo 'checked';
                                                  }
                                                  ?>>
                                            <label for="<?= htmlspecialchars($brand); ?>" class="form-check-label">
                                                <?= htmlspecialchars($brand); ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </fieldset>


                        <!-- Sort Results -->
                        <fieldset class='my-5'>
                            <legend class="fs-5"> Sort results by: </legend>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="radio" name="sort_order" id="ascending" value="ascending"
                                        class="form-check-input" <?php if ($sort_order === "ascending")
                                            echo "checked"; ?>>
                                    <label for="ascending" class="form-check-label">Ascending</label>
                                </div>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="sort_order" id="descending" value="descending"
                                    class="form-check-input" <?php if ($sort_order === "descending")
                                        echo "checked"; ?>>
                                <label for="descending" class="form-check-label">Descending</label>
                            </div>

                        </fieldset>

                        <div class="m-3">
                            <input class="btn btn-success" type="submit" value="Search" name="search">
                        </div>
                    </form>
                </div>
                    <?php
                    if (isset($_GET['search'])) {
                        $query = "SELECT * FROM wardrobe_catalog WHERE 1 = 1";

                        $parameters = [];
                        $types = "";

                        // text search - title is only string column to look at
                        if (!$title_search == "") {
                            $query .= " AND title LIKE CONCAT('%',?,'%')";
                            $parameters[] = $title_search;
                            $types .= "s";
                        }

                        // brand search - brand is only string column to look at
                        if (!$brands == "") {
                            $placeholders = implode(",", array_fill(0, count($brands), "?"));
                            $query .= " AND brand IN ($placeholders)";

                        // Add the brand values to the parameters array
                        $parameters = array_merge($parameters, $brands);

                        // Update the types string to accommodate the new parameters
                            $types .= str_repeat("s", count($brands));
                        }

                        // category search - category is only string column to look at
                        if ($category_name != "Please select a category") {
                            $query .= " AND category LIKE CONCAT('%',?,'%')";
                            $parameters[] = $category_name;
                            $types .= "s";
                        }

                        // Sort results
                        if ($sort_order != "") {
                            if ($sort_order == 'descending') {
                                $query .= " ORDER By title DESC";
                            } elseif ($sort_order == 'ascending') {
                                $query .= " ORDER By title ASC";
                            }
                        }

                        if (empty($parameters) || $parameters == ["Please select a category"]) {
                            $message = "<p class='alert alert-danger'>Please choose an option to search by</p>";
                        }

                        if ($message == "") {
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
                                if ($result->num_rows > 0) : ?>
                                <div class="col-xs-12 col-md-10 border border-success pt-3 rounded w-100  text-center">
                                <h2 class="display-5 mb-5">Results</h2>
                                        <div class="d-flex flex-wrap justify-content-around mt-5 pt-3">
                                        
                                            <?php
                                            while ($row = $result->fetch_assoc()) {
                                                extract($row);
                                                echo '<a class="text-centertext-decoration-none text-dark" href="https://comotosho1.dmitstudent.ca/dmit2025/workbook/labs/catalog/public/view.php?title=' . $row['title'] . '">
                                                        <div class="card" style="width: 18rem; margin: 10px;">
                                                        <img src="https://comotosho1.dmitstudent.ca/dmit2025/workbook/labs/catalog/private/product_images' . $row['image'] . '" class="card-img-top" alt="Card image">
                                                        <div class="card-body">
                                                    <h5 class="card-title">' . $row['title'] . '</h5>
                                                </div>
                                            </div></a>
                                                ';
                                            }
                                            ?>
                                        </div>
                            <?php endif;

                                // Close the statement
                                $statement->close();
                            }
                        } else {
                            echo $message;
                        }
                        ;

                    }
                    ?>
        </div>
    </section>
    </div>
    </section>
</main>


<?php

include('includes/footer.php');

?>