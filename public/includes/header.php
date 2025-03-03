<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?php echo $title; ?>
    </title>
    <!-- BS Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!-- BS Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body class="d-flex flex-column justify-content-between min-vh-100">
    <header class="text-center">
        <nav class="py-2 bg-dark border-bottom">
            <div class="container d-flex flex-wrap">
                <ul class="nav me-auto">
                    <li class="nav-item"><a href="#" class="nav-link link-light link-body-emphasis px-2">Browse by: </a>
                    </li>
                    <!-- Depending upon the categories that you choose, the link text and referenced page will differ. -->
                    <li class="nav-item"><a href="./browseBy.php?category=Category"
                            class="nav-link link-light link-body-emphasis px-2">Product Type&emsp;|</a></li>
                    <li class="nav-item"><a href="./browseBy.php?category=Brand"
                            class="nav-link link-light link-body-emphasis px-2"> Brand</a></li>
                </ul>
                <!-- <ul class="nav">
                    <li class="nav-item"><a href="search.php"
                            class="nav-link link-light link-body-emphasis px-2">Advanced Search</a></li>
                </ul> -->
                <ul class="nav">
                    <?php if(!isset($_SESSION['user_id'])) : ?>
              <li class="nav-item">
              <a class="nav-link text-white" href="login.php">Login</a>
            </li>
            <?php else : ?>
                <li class="nav-item">
              <a class="nav-link text-white" href="add.php">Add</a>
                <li class="nav-item">
              <a class="nav-link text-white" href="delete.php">Delete</a>
              <li class="nav-item">
              <a class="nav-link text-white" href="logout.php">Logout</a>
              <?php endif; ?>
              <li class="nav-item">
              <a class="nav-link text-white" href="search.php">Advanced Search</a>
              </ul>
                    <form action="search-results.php" method="get" class="d-flex align-items-center rounded">
                        <label for="index_search" class="me-2">Search:</label>
                        <input class="form-control me-2" type="text" name="index_search" id="index_search" value="<?php if($index_search ?? "") ?>" required>
                        <input class="btn btn-success" type="submit" value="Search" name="search">
                    </form>
            </div>
        </nav>
        <section class="py-3 mb-4 border-bottom">
            <div class="container d-flex flex-wrap justify-content-center">
                <a href="index.php"
                    class="d-flex align-items-center mb-3 mb-lg-0 me-lg-auto link-body-emphasis text-decoration-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width= "45" height= "45" viewBox="0 0 473 473" xml:space="preserve">
    <path d="M451.4 315c-.5-.3-1.8-.6-2.4-.9l-201-88.9v-28.8c38.2-4.6 57-29.9 57-62.3 0-36-25.2-63-59.3-63a66 66 0 0 0-65.8 64.3c0 6 5 11 11 11q2.7-.1 5-1.4c3.5-1.8 6-5.3 6-9.6A44.6 44.6 0 0 1 246 92.8c22 0 38 17.4 38 41.3 0 23.5-19 41.2-45 41.2-6 0-10.3 5-10.3 11v42.5l-.4.6-192.7 91.2C7.2 330.8-2.6 354 .6 371.9c3.1 18.3 18.7 30 38.7 30h383c23.7 0 42.4-12.3 48.6-32.9a48 48 0 0 0-19.5-54m-1.3 49c-3.4 11.5-13.6 18.8-27.8 18.8h-383c-9.7 0-16-5.4-17.5-13.3-1.5-9.1 4.3-22 21.9-28.5l199.5-94.5L440.1 334c9.2 6.6 13.3 19 10 30" fill="#198754"/>
</svg>

                    <h1 class="fs-4 fw-light px-3" style="color: #198754"> Clem's Gems</h1>
                </a>
            </div>
        </section>
    </header>