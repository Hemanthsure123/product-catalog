<?php
require_once 'config/database.php';
require_once 'includes/header.php';

$db = (new Database())->getConnection();

// Build query based on filters and sorting, fixed to Mobiles category
$search = isset($_GET['search']) ? '%' . trim($_GET['search']) . '%' : '%';
$min_price = isset($_GET['min_price']) && is_numeric($_GET['min_price']) ? floatval($_GET['min_price']) : 0;
$max_price = isset($_GET['max_price']) && is_numeric($_GET['max_price']) ? floatval($_GET['max_price']) : PHP_INT_MAX;
$sort = isset($_GET['sort']) ? trim($_GET['sort']) : 'name_asc';

$query = "SELECT * FROM products WHERE name LIKE ? AND category = 'Mobiles' AND price >= ? AND price <= ?";
$params = [$search, $min_price, $max_price];

switch ($sort) {
    case 'name_asc':
        $query .= " ORDER BY name ASC";
        break;
    case 'name_desc':
        $query .= " ORDER BY name DESC";
        break;
    case 'price_asc':
        $query .= " ORDER BY price ASC";
        break;
    case 'price_desc':
        $query .= " ORDER BY price DESC";
        break;
    case 'stock_asc':
        $query .= " ORDER BY stock ASC";
        break;
    case 'stock_desc':
        $query .= " ORDER BY stock DESC";
        break;
    default:
        $query .= " ORDER BY name ASC";
}

$stmt = $db->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll();
?>

<h2>Mobiles</h2>
<div class="product-grid">
    <?php if (empty($products)): ?>
        <p>No mobiles found.</p>
    <?php else: ?>
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                <p class="category"><?php echo htmlspecialchars($product['category']); ?></p>
                <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                <p><?php echo $product['stock'] > 0 ? 'In Stock: ' . htmlspecialchars($product['stock']) : 'Out of Stock'; ?></p>
                <p><?php echo htmlspecialchars($product['description']); ?></p>
                <a href="/electronics_catalog/admin/edit_product.php?id=<?php echo $product['id']; ?>">Edit</a>
                <a href="/electronics_catalog/admin/delete_product.php?id=<?php echo $product['id']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php require_once 'includes/footer.php'; ?>