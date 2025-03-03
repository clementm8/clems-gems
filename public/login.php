<?php 

// echo password_hash("phprocks",PASSWORD_DEFAULT );


require_once "/home/comotosho1/data/connect.php";

$connection= db_connect();
$message= '';
require_once "../private/login-process.php";
$page_title = "Login";
include('includes/header.php');
if(isset($_SESSION['user_id'])){
    header("location: index.php");
}
?>

<div class="container my-5">
    <h1 class="fw-light text-center mt-5">Login</h1>
    <p class="text-muted mb-5">
        To access the admin area please login
    </p>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
    <div class="form-group mb-3">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php if (isset($_POST['username'])) echo $username ?>">
    </div>
    <div class="form-group mb-3">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" value="<?php if (isset($_POST['password'])) echo $password ?>">
    </div>
    <input type="submit" vaue="login" class='btn btn-primar mt-4' name='login'>

    </form>

    <div class="row justify-content-center">
        <div class="col-md-8 col-xl-6">
        <?=$message; ?>
        </div>
    </div>

</div>

<?php 

include "includes/footer.php"

?>