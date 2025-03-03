<?php
require_once "/home/comotosho1/data/connect.php";

$connection= db_connect();

$imageDir = __DIR__ . '/product_images/';

$images = scandir($imageDir);


// Iterate over the images and insert them into the database

foreach ($images as $image) {
    if ($image !== '.' && $image !== '..') {
        $imagePath = $imageDir . '/' . $image;
        $imageData = file_get_contents($imagePath);

        // Assuming you have a title for each image
        $imageTitle = pathinfo($imagePath, PATHINFO_FILENAME);

        // Insert the image data and title into the database
        $sql = "INSERT INTO images (data, title) VALUES (?, ?)";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param('bs', $imageData, $imageTitle);
        $stmt->execute();
    }
}

// $imageId= 11;

// $sql = "SELECT data, title FROM images WHERE id = 910";
// $stmt = $connection->prepare($sql);
// $stmt->execute();
// $result = $stmt->get_result();

// if ($result->num_rows > 0) {
//     $row = $result->fetch_assoc();
//     $imageData = $row['data']; // Correctly assign image data
//     $title= $row['title'];
// }

// $file= $imageData;
// $file_name= $title;
// $file_temp_name= $title;
// $file_size= strlen($imageData);

// $file_new_name= $title. ".webp";
// $file_destination= "images/full/$file_new_name";
//             if(!is_dir("images/full/")){
//                 mkdir("images/full/", 0777, true);
//             }
//             if(!is_dir("images/thumbs/")){
//                 mkdir("images/thumbs/", 0777, true);
//             }

// if(isset($_POST['submit'])){

?> <div class="card text-bg-dark">
                    <img width="250" height="250" src="product_images/<?= $file_new_name ?>" alt="<?= $title ?>">
                    <div class="card-img-overlay">
                        <h5 class="card-title"><?= $title ?></h5>
                        <p><?= $title ?></p>
                    </div>
                </div>