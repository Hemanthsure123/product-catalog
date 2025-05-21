<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$db = (new Database())->getConnection();
$message = '';
$product = null;

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo '<div class="message error">Invalid product ID.</div>';
    require_once '../includes/footer.php';
    exit;
}

$id = intval($_GET['id']);
$query = "SELECT * FROM products WHERE id = ?";
$stmt = $db->prepare($query);
$stmt->execute([$id]);
$product = $stmt->fetch();

if (!$product) {
    echo '<div class="message error">Product not found.</div>';
    require_once '../includes/footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $category = trim($_POST['category']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $description = trim($_POST['description']);
    $image_path = $product['image'];

    // Handle image upload (optional)
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB
        $file_type = mime_content_type($_FILES['image']['tmp_name']);
        $file_size = $_FILES['image']['size'];
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $file_name = uniqid() . '.' . $file_ext;
        $upload_dir = '../uploads/';
        $image_path = '/electronics_catalog/uploads/' . $file_name;

        if (!in_array($file_type, $allowed_types)) {
            $message = '<div class="message error">Invalid file type. Only JPG, PNG, GIF allowed.</div>';
        } elseif ($file_size > $max_size) {
            $message = '<div class="message error">File size exceeds 2MB limit.</div>';
        } elseif (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $file_name)) {
            $message = '<div class="message error">Failed to upload image.</div>';
        } else {
            // Delete old image if it exists
            $old_image = '../' . ltrim($product['image'], '/');
            if (file_exists($old_image) && $product['image'] !== $image_path) {
                unlink($old_image);
            }
        }
    }

    // Update product if no errors
    if (empty($message)) {
        $query = "UPDATE products SET name = ?, category = ?, price = ?, stock = ?, description = ?, image = ? WHERE id = ?";
        $stmt = $db->prepare($query);
        if ($stmt->execute([$name, $category, $price, $stock, $description, $image_path, $id])) {
            $message = '<div class="message success">Product updated successfully.</div>';
            // Refresh product data
            $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $product = $stmt->fetch();
        } else {
            $message = '<div class="message error">Failed to update product.</div>';
        }
    }
}
?>

<div class="form-container">
    <h2>Edit Product</h2>
    <?php echo $message; ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) . '?id=' . $id; ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select id="category" name="category" required>
                <option value="Mobiles" <?php echo $product['category'] === 'Mobiles' ? 'selected' : ''; ?>>Mobiles</option>
                <option value="Microwaves" <?php echo $product['category'] === 'Microwaves' ? 'selected' : ''; ?>>Microwaves</option>
                <option value="Refrigerators" <?php echo $product['category'] === 'Refrigerators' ? 'selected' : ''; ?>>Refrigerators</option>
                <option value="Washing Machines" <?php echo $product['category'] === 'Washing Machines' ? 'selected' : ''; ?>>Washing Machines</option>
            </select>
        </div>
        <div class="form-group">
            <label for="price">Price ($)</label>
            <input type="number" id="price" name="price" step="0.01" value="<?php echo htmlspecialchars($product['price']); ?>" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/gif">
            <p class="note">Max 2MB. JPG, PNG, GIF only. Leave blank to keep existing image.</p>
            <?php if ($product['image']): ?>
                <div class="image-preview">
                    <p>Current Image:</p>
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Current Image">
                </div>
            <?php endif; ?>
        </div>
        <div class="form-actions">
            <button type="submit">Update Product</button>
            <a href="/electronics_catalog/electronics.php" class="delete">Cancel</a>
        </div>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>