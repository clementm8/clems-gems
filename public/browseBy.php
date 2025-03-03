<?php
require_once "/home/comotosho1/data/connect.php";
$connection = db_connect();
require_once "../private/prepared.php";

$title = "Browse by " . ucfirst($_GET['category']);
include('includes/header.php');

?>
<div class="container text-center">
<?php
// If category is provided and is category
if (isset($_GET['category']) && $_GET['category'] == 'Category' && !isset($_GET['subcategory'])): ?>
    <div >
        <h1 class="mb-4"><?= "Browse by Product Type" ?></h1>
        <?php
        $categories = select_from_category($_GET['category']);
        ?>
        <ul>
            <?php foreach ($categories as $subcategory): ?>
                <li class="mx-1 my-1 btn bg-success text-white" style="width: fit-content;">
                    <a class="text-white text-decoration-none"
                        href="browseBy.php?category=<?php echo $_GET['category']; ?>&subcategory=<?php echo $subcategory["Category"]; ?>"><?php echo $subcategory["Category"]; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif;?>

<!-- If category is provided and is brands -->
<?php
if (isset($_GET['category']) && $_GET['category'] == 'Brand' && !isset($_GET['subcategory'])): ?>
    <div>
        <h1 class=" mb-4"><?= $title ?></h1>
        <?php
        $categories = select_from_category($_GET['category']);
        ?>
        <ul>
            <?php foreach ($categories as $brands): ?>
                <li class="mx-1 my-1 btn bg-success text-white" style="width: fit-content;">
                    <a class="text-white text-decoration-none"
                        href="browseBy.php?category=<?php echo $_GET['category']; ?>&subcategory=<?php echo $brands["brand"]; ?>"><?php echo $brands["brand"]; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif;
?>


<?php

// If both category and subcategory are provided

if (isset($_GET['category']) && isset($_GET['subcategory'])): $subcategory= $_GET['subcategory'];?>
    <h1 class="mb-4 text-center"><?= "Browse by ". $subcategory ?></h1>
    <div class="text-center">
        
        <?php
        switch ($_GET['category']) {
            case 'Category':
                $items = get_by_category($subcategory);
                if (count($items) > 0): ?>
                    <div class="d-flex flex-wrap justify-content-center w-75 m-auto">
                    <?php
                            foreach ($items as $item) {
                                extract($items);
                                echo '<a class="text-center text-decoration-none text-dark" href="https://comotosho1.dmitstudent.ca/dmit2025/workbook/labs/catalog/public/view.php?title=' . $item['title'] .'">
        <div class="card" style="width: 18rem; margin: 10px;">
            <img src="https://comotosho1.dmitstudent.ca/dmit2025/workbook/labs/catalog/private/product_images'. $item['image'] .'" class="card-img-top" alt="Card image">
            <div class="card-body">
                <h5 class="card-title">' . $item['title'] . '</h5>
            </div>
        </div></a>
        ';
                            }
                            
                            ?>
                    </div>
                    
                <?php endif;
                break;

            case 'Brand':
                $items = get_by_brand($subcategory);
                if (count($items) > 0): ?>
                    <div class="d-flex flex-wrap justify-content-center w-75 m-auto">
                    <?php
                            foreach ($items as $item) {
                                extract($items);
                                echo '<a class="text-center text-decoration-none text-dark" href="https://comotosho1.dmitstudent.ca/dmit2025/workbook/labs/catalog/public/view.php?title=' . $item['title'] .'">
        <div class="card" style="width: 18rem; margin: 10px;">
            <img src="https://comotosho1.dmitstudent.ca/dmit2025/workbook/labs/catalog/private/product_images'. $item['image'] .'" class="card-img-top" alt="Card image">
            <div class="card-body">
                <h5 class="card-title">' . $item['title'] . '</h5>
            </div>
        </div></a>
        ';
                            }
                            
                            ?>
                    </div>
                    
                <?php endif;
                break;
        } ?>
    </div>
<?php endif; ?>
</div>




<?php
include('includes/footer.php');
?>