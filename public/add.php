<?php
require_once "/home/comotosho1/data/connect.php";
$connection = db_connect();
require_once "../private/prepared.php";

include('includes/header.php');
$title = "Add an item";

$message = '';
$categories = ['Please select a category', 'OuterWear and Jackets', 'Footwear', 'Tshirts', 'Accessories', 'Colognes'];

if (isset($_POST['submit'])) {
    extract($_POST);
    $do_i_proceed = true;

    if (trim($item_name) === "") {
        $do_i_proceed = false;
        $message .= "<p>Please enter an item name</p>";
    } else {
        $item_name = trim($item_name);
        if (strlen($item_name) < 2 || strlen($item_name) > 255) {
            $do_i_proceed = false;
            $message .= "<p> Please enter an item name between 2 and 255 characters </p>";
        }
    }

    if (trim($color) === "") {
        $do_i_proceed = false;
        $message .= "<p>Please enter an item size</p>";
    } else {
        $color = trim($color);
        if (strlen($color) < 2 || strlen($color) > 20) {
            $do_i_proceed = false;
            $message .= "<p> Please enter an item color between 2 and 20 characters </p>";
        }
    }

    if (trim($brand) === "") {
        $do_i_proceed = false;
        $message .= "<p>Please enter a brand</p>";
    } else {
        $brand = trim($brand);
        if (strlen($brand) < 2 || strlen($brand) > 255) {
            $do_i_proceed = false;
            $message .= "<p> Please enter an brand between 2 and 255 characters </p>";
        }
    }

    $rating = filter_var($rating, FILTER_SANITIZE_NUMBER_INT);
    if ($rating < 0 || !is_numeric($rating) || $rating == false)
        ;
    $do_i_proceed = false;
    $message = "<p>Please enter a positive number for the rating</p>";

    if (!in_array($category, $categories)) {
        $do_i_proceed = false;
        $message = "<p>Please select a category from the list</p>";
    }

    if ($do_i_proceed = true) {
        insert_item($item_name, $category, $rating, $review, $color, $size, $description, $season, $material, $brand);
        $message = "<p>" . $item_name . " has been added Successfully</p>";
    } else {
        echo (error_get_last());
        $message = "<p> There was a problem. " . $item_name . " was not added.</p>";
    }
    ;

}

?>



<div class=" container my-5">
    <h1 class="fw-light text-center mt-5">Add an item</h1>
    <p class="text-muted mb-5 text-center">To add an item to the catalog, simply fill out the form below and hit 'save'.
    </p>

    <form action="" method="post">
        <?php if ($message != ''): ?>
            <div class="bg-danger p-3 text-white">
                <?= $message ?>
            </div>
        <?php endif; ?>
        <div class="form-group mb-3">
            <label for="item_name">Item Name</label>
            <input type="text" class="form-control" id="item_name" name="item_name" value=" <?php if (isset($_POST['item_name']))
                echo $item_name ?>">
            </div>
            <div class="form-group mb-3">
            <label for="description">Description</label>
            <input type="text" class="form-control" id="description" name="description" value=" <?php if (isset($_POST['description']))
                echo $description ?>">
            </div>
            <div class="form-group mb-3">
                <label for="category">Category</label>
                <select class="form-control" id="category" name="category">
                    <?php
            foreach ($categories as $key) {
                $selected = isset($_POST['category']) && $_POST['category'] == $key ? 'selected' : '';
                echo "<option value=\"$key\" $selected> $key</option>";
            }
            ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="rating">Rating</label>
            <input type="text" class="form-control" id="rating" name="rating" value=" <?php if (isset($_POST['rating']))
                echo $_POST['rating'] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="review">Review</label>
                <input type="text" class="form-control" id="review" name="review" value=" <?php if (isset($_POST['review']))
                echo $_POST['review'] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="color">Color</label>
                <input type="text" class="form-control" id="color" name="color" value=" <?php if (isset($_POST['color']))
                echo $_POST['color'] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="season">Season</label>
                <input type="text" class="form-control" id="season" name="season" value=" <?php if (isset($_POST['season']))
                echo $_POST['season'] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="material">Material</label>
                <input type="text" class="form-control" id="material" name="material" value=" <?php if (isset($_POST['material']))
                echo $_POST['material'] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="rating">Brand</label>
                <input type="text" class="form-control" id="brand" name="brand" value=" <?php if (isset($_POST['brand']))
                echo $_POST['brand'] ?>">
            </div>

            <div class="form-group mb-3">
                <label for="size">Size</label>
                <input type="text" class="form-control" id="size" name="size" value=" <?php if (isset($_POST['size']))
                echo $_POST['size'] ?>">
            </div>

            <input type="submit" value="Save" name="submit" class="btn btn-success">
        </form>
    </div>
    <?php
            include "includes/footer.php";

            ?>