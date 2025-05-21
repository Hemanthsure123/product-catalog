<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$db = (new Database())->getConnection();
$message = '';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid product ID.");
}

$product_id = intval($_GET['id']);
$stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    die("Product not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Delete the image if it's not the default
        if ($product['image'] !== 'https://res.cloudinary.com/darsfmavs/image/upload/v1747819361/27002_lpg3iz.jpg' && file_exists($product['image'])) {
            unlink($product['image']);
        }
        $stmt = $db->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$product_id]);
        $message = "Product deleted successfully!";
        header("Location: ../index.php");
        exit;
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<h2>Delete Product</h2>
<?php if ($message): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>
<p>Are you sure you want to delete the product "<strong><?php echo htmlspecialchars($product['name']); ?></strong>"?</p>
<form method="POST">
    <button type="submit" class="delete">Confirm Delete</button>
    <a href="../index.php">Cancel</a>
</form>

<?php require_once '../includes/footer.php'; ?>