<?php
require_once "/home/comotosho1/data/connect.php";
$connection = db_connect();


$insert_statement = $connection -> prepare("INSERT INTO wardrobe_catalog (title, category, rating, review, color, size, description, season, material, brand) VALUES(?,?,?,?,?,?,?,?,?,?)");

$update_statement= $connection -> prepare("UPDATE wardrobe_catalog SET title= ?, rating= ?, review = ?, category = ?, color = ?, season = ?, material = ? , brand = ?, size = ?, description = ? WHERE id = ?");

$delete_statement= $connection -> prepare("DELETE FROM wardrobe_catalog WHERE id= ?");

$get_all_items= $connection -> prepare("SELECT * FROM wardrobe_catalog");
$get_by_category= $connection -> prepare("SELECT * FROM wardrobe_catalog where category = ?");
$get_by_brand= $connection -> prepare( "SELECT * FROM wardrobe_catalog where brand LIKE ? ");
$count_records= $connection -> prepare("SELECT count(*) FROM wardrobe_catalog ");
$get_item_by_title= $connection -> prepare("SELECT * FROM wardrobe_catalog where title = ? ");
$index_search= $connection -> prepare( "SELECT * from wardrobe_catalog WHERE title LIKE ? or description LIKE ? or category LIKE ? or brand LIKE ? or size LIKE ? or review LIKE ?");
$get_item_by_id= $connection -> prepare("SELECT * FROM wardrobe_catalog where id = ? ");
$filter_records = "SELECT * FROM wardrobe_catalog WHERE 1 = 1";

function insert_item( $item_name, $category, $rating, $review, $color, $size, $description, $season, $material, $brand){
    global $connection;
    global $insert_statement;
    $insert_statement->bind_param("ssisssssss", $item_name, $category, $rating, $review, $color, $size, $description, $season, $material, $brand);

    if(!$insert_statement->execute()){
        handle_database_error("Inserting item");
    }
}

function update_item( $item_name, $category, $rating, $review, $color, $size, $description, $season, $material, $brand){
    global $connection;
    global $update_statement;
    $update_statement->bind_param("ssisssssss", $item_name, $category, $rating, $review, $color, $size, $description, $season, $material, $brand);

    if(!$update_statement->execute()){
        handle_database_error("Updating item");
    }
}

function delete_item($item_id){
    global $connection;
    global $delete_statement;
    $delete_statement->bind_param("i", $item_id);

    if(!$delete_statement->execute()){
        handle_database_error("Deleting item");
    }
}

function select_from_category($category)
{
    if ($category == "Category") {
        global $connection;
        $sql = "SELECT DISTINCT(Category) FROM wardrobe_catalog";
        $result = $connection->query($sql);

        if (!$result) {
            handle_database_error("Getting $category records failed: " . $connection->error);
        }

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        return $categories;
    } elseif ($category == "Brand") {
        global $connection;
        $sql = "SELECT DISTINCT(brand) FROM wardrobe_catalog";
        $result = $connection->query($sql);

        if (!$result) {
            handle_database_error("Getting $category failed: " . $connection->error);
        }

        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        return $categories;
    }
    else{
        handle_database_error("Category $category failed because it doesnt exist: " . $connection->error);
    }
}

function get_by_category($category)
{
    global $connection;
    global $get_by_category;
    $get_by_category->bind_param("s", $category);
    if (!$get_by_category->execute()) {
        handle_database_error("Getting $category items failed: " . $connection->error);
    }
    $result = $get_by_category ->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    return $items;
}
function get_by_brand($brand)
{
    global $connection;
    global $get_by_brand;
    $get_by_brand->bind_param("s", $brand);
    if (!$get_by_brand->execute()) {
        handle_database_error("Getting $brand items failed: " . $connection->error);
    }
    $result = $get_by_brand ->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    return $items;
}

function get_all_items(){
    global $connection;
    global $get_all_items;
    if (!$get_all_items->execute()) {
        handle_database_error("Getting items failed: " . $connection->error);
    }
    $result = $get_all_items ->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    return $items;
}

function get_by_decade($decade)
{
    global $connection;
    global $get_by_decade;
    $decade = $decade . '%';
    $get_by_decade->bind_param("s", $decade);
    if (!$get_by_decade->execute()) {
        handle_database_error("Getting items from $decade 0's failed: " . $connection->error);
    }
    
    $result = $get_by_decade ->get_result();
    

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
    return $items;
}

function count_records(){
    global $connection;
    global $count_records;
    if (!$count_records->execute()) {
        handle_database_error("Getting record count: " . $connection->error);
    }
    $result = $count_records ->get_result();
    $count= $result->fetch_assoc();
    $count= $count["count(*)"];
    return $count;
}

function find_records($limit = 0, $offset=0){
    global $connection;
    $sql= "SELECT * from wardrobe_catalog ";
    if ($limit > 0){
        $sql .= "LIMIT $limit";
    }
    if ($offset > 0){
        $sql .= " OFFSET $offset";
    }
    $result= $connection->query($sql);
    return $result;
}


function get_item_by_title($title){
    global $connection;
    global $get_item_by_title;
    $get_item_by_title -> bind_param('s',$title);
    if (!$get_item_by_title->execute()) {
        handle_database_error("Getting item $title failed: " . $connection->error);
    }
    $result = $get_item_by_title ->get_result();
    $item= $result->fetch_assoc();
    return $item;
}

function get_item_by_id($id){
    global $connection;
    global $get_item_by_id;
    $get_item_by_id -> bind_param('s',$id);
    if (!$get_item_by_id->execute()) {
        handle_database_error("Getting item $id failed: " . $connection->error);
    }
    $result = $get_item_by_id ->get_result();
    $item= $result->fetch_assoc();
    return $item;
}

function index_search($search_param) {
    global $connection;
    global $index_search;

    // Ensure that the index_search is already prepared
    if (!$index_search) {
        die("Prepared statement not found.");
    }

    $searchParam = '%' . $search_param . '%'; 
    $params = [$searchParam, $searchParam, $searchParam, $searchParam, $searchParam, $searchParam];
    $types = str_repeat("s", count($params)); 


    if (!$index_search->bind_param($types, ...$params)) {
        die("Error binding parameters: " . $index_search->error);
    }


    if (!$index_search->execute()) {
        die("Error executing query: " . $index_search->error);
    }


    $result = $index_search->get_result();
    if (!$result) {
        die("Error fetching result: " . $index_search->error);
    }

    return $result;
}

// function fetch_image($image){
//     if(isset($_POST['submit'])){
//         $file= $_FILES['img-file'];
//         $file_name= $_FILES['img-file']['name'];
//         $file_temp_name= $_FILES['img-file']['tmp_name'];
//         $file_size= $_FILES['img-file']['size'];
//         $file_error= $_FILES['img-file']['error'];
    
//         $file_extension= explode('.', $file_name);
//         $file_extension= strtolower(end($file_extension));
    
//         $allowed=['jpg','jpeg','png','webp'];
    
//         if (in_array($file_extension,$allowed)){
//             if($file_error == 0){
//                 if($file_size < 2000000){
//                     $file_name_new= uniqid("", true) . "." . $file_extension;
//                     $file_destination= "images/full/$file_name_new";
//                     if(!is_dir("images/full/")){
//                         mkdir("images/full/", 0777, true);
//                     }
//                     if(!is_dir("images/thumbs/")){
//                         mkdir("images/thumbs/", 0777, true);
//                     }
    
//                     if(!file_exists($file_destination)){
//                         move_uploaded_file($file_temp_name, $file_destination);
//                         // do the thumbnail
    
                        
    
//                         $sql= 'INSERT INTO gallery_prep (title,description,filename,uploaded_on) VALUES (?,?,?, NOW())';
//                         $statement= $connection->prepare($sql);
//                         $statement->bind_param('sss', $img_title, $img_desc, $file_name_new);
//                         $statement->execute();
    
//                         $message= "Image saved successfully";
//                     }
//                     else{
//                         $message= "Sorry the file exists there already";
//                     }
//                 }else{
//                     $message= "Sorry images must be under ";
//                 }
//             }else{
//                 $message= "Sorry there was an error uploading your file";
//             }
//         }else{
//             $message= "Sorry only img formats allowed, except gif, no gif. ";
//         }
//     }
// }

?>