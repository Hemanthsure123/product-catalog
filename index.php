<?php
require_once 'config/database.php';
require_once 'includes/header.php';
?>

<h2>Welcome to Electronics Catalog</h2>
<div class="category-grid">
    <?php
    $categories = [
        [
            'name' => 'Mobiles',
            'url' => 'mobiles.php',
            'image' => '/electronics_catalog/uploads/mobiles_category.jpg'
        ],
        [
            'name' => 'Washing Machines',
            'url' => 'washingmachine.php',
            'image' => '/electronics_catalog/uploads/washingmachine_category.jpg'
        ],
        [
            'name' => 'Refrigerators',
            'url' => 'refrigerators.php',
            'image' => '/electronics_catalog/uploads/refrigerator_category.jpg'
        ],
        [
            'name' => 'Microwaves',
            'url' => 'microwave.php',
            'image' => '/electronics_catalog/uploads/microwave_category.jpg'
        ]
    ];

    foreach ($categories as $category) {
        echo '<div class="category-card">';
        echo '<img src="' . htmlspecialchars($category['image']) . '" alt="' . htmlspecialchars($category['name']) . '">';
        echo '<a href="' . htmlspecialchars($category['url']) . '">' . htmlspecialchars($category['name']) . '</a>';
        echo '</div>';
    }
    ?>
</div>

<?php require_once 'includes/footer.php'; ?>