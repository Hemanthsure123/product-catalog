<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electronics Catalog</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/electronics_catalog/css/styles.css?v=4">
</head>
<body class="light-theme">
    <div class="container">
        <aside class="sidebar">
            <h2>Dashboard</h2>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="GET" class="dashboard-form">
                <h3>Search</h3>
                <input type="text" name="search" placeholder="Search products..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

                <h3>Filter by Category</h3>
                <select name="category">
                    <option value="">All Categories</option>
                    <option value="Mobiles" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Mobiles') ? 'selected' : ''; ?>>Mobiles</option>
                    <option value="Washing Machines" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Washing Machines') ? 'selected' : ''; ?>>Washing Machines</option>
                    <option value="Refrigerators" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Refrigerators') ? 'selected' : ''; ?>>Refrigerators</option>
                    <option value="Microwaves" <?php echo (isset($_GET['category']) && $_GET['category'] == 'Microwaves') ? 'selected' : ''; ?>>Microwaves</option>
                </select>

                <h3>Filter by Price</h3>
                <input type="number" name="min_price" placeholder="Min Price" step="0.01" value="<?php echo isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : ''; ?>">
                <input type="number" name="max_price" placeholder="Max Price" step="0.01" value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : ''; ?>">

                <h3>Sort By</h3>
                <select name="sort">
                    <option value="name_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'name_asc') ? 'selected' : ''; ?>>Name: A-Z</option>
                    <option value="name_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'name_desc') ? 'selected' : ''; ?>>Name: Z-A</option>
                    <option value="price_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : ''; ?>>Price: Low to High</option>
                    <option value="price_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : ''; ?>>Price: High to Low</option>
                    <option value="stock_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'stock_asc') ? 'selected' : ''; ?>>Stock: Available First</option>
                    <option value="stock_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'stock_desc') ? 'selected' : ''; ?>>Stock: Out of Stock First</option>
                </select>

                <button type="submit">Apply</button>
            </form>
        </aside>
        <div class="main-content">
            <header>
                <nav>
                    <h1>Electronics Catalog</h1>
                    <ul>
                        <li><a href="/electronics_catalog/index.php">Home</a></li>
                        <li><a href="/electronics_catalog/electronics.php">All Electronics</a></li>
                        <li><a href="/electronics_catalog/mobiles.php">Mobiles</a></li>
                        <li><a href="/electronics_catalog/washingmachine.php">Washing Machines</a></li>
                        <li><a href="/electronics_catalog/refrigerators.php">Refrigerators</a></li>
                        <li><a href="/electronics_catalog/microwave.php">Microwaves</a></li>
                        <li><a href="/electronics_catalog/admin/add_product.php">Add Product</a></li>
                    </ul>
                    <button id="theme-toggle">Theme</button>
                </nav>
            </header>
            <main>