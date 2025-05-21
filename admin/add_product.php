<?php
require_once '../config/database.php';
require_once '../includes/header.php';

$db = (new Database())->getConnection();
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $category = trim($_POST['category']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $description = trim($_POST['description']);
    $image_path = '';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB
        $file_type = mime_content_type($_FILES['image']['tmp_name']);
        $file_size = $_FILES['image']['size'];
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $file_name = uniqid() . '.' . $file_ext; // Unique filename
        $upload_dir = '../uploads/';
        $image_path = '/electronics_catalog/uploads/' . $file_name;

        if (!in_array($file_type, $allowed_types)) {
            $message = '<div class="message error">Invalid file type. Only JPG, PNG, GIF allowed.</div>';
        } elseif ($file_size > $max_size) {
            $message = '<div class="message error">File size exceeds 2MB limit.</div>';
        } elseif (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_dir . $file_name)) {
            $message = '<div class="message error">Failed to upload image.</div>';
        }
    } else {
        $message = '<div class="message error">Please upload an image.</div>';
    }

    // Insert product if no errors
    if (empty($message)) {
        $query = "INSERT INTO products (name, category, price, stock, description, image) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($query);
        if ($stmt->execute([$name, $category, $price, $stock, $description, $image_path])) {
            $message = '<div class="message success">Product added successfully.</div>';
        } else {
            $message = '<div class="message error">Failed to add product.</div>';
        }
    }
}
?>

<div class="form-container">
    <h2>Add New Product</h2>
    <?php echo $message; ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Product Name</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="category">Category</label>
            <select id="category" name="category" required>
                <option value="Mobiles">Mobiles</option>
                <option value="Microwaves">Microwaves</option>
                <option value="Refrigerators">Refrigerators</option>
                <option value="Washing Machines">Washing Machines</option>
            </select>
        </div>
        <div class="form-group">
            <label for="price">Price ($)</label>
            <input type="number" id="price" name="price" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="stock">Stock</label>
            <input type="number" id="stock" name="stock" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="image">Product Image</label>
            <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/gif" required>
            <p class="note">Max 2MB. JPG, PNG, GIF only.</p>
        </div>
        <div class="form-actions">
            <button type="submit">Add Product</button>
        </div>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>