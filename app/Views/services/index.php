<h2 class="section-title">خدمات الفندق</h2>

<?php
function showSection($title, $items) {
    if (empty($items)) return;

    echo "<h3 class='section-subtitle'>$title</h3>";
    echo "<div class='services-grid'>";

    foreach ($items as $item) {
        echo "
        <div class='service-box'>
            <img src='" . base_url('uploads/' . $item['image']) . "' alt=''>
            <p class='service-title'>" . esc($item['dish_name']) . "</p>
        </div>";
    }

    echo "</div>";
}
?>

<?php showSection('المطبخ العربي', $arabic); ?>
<?php showSection('المطبخ الآسيوي', $asian); ?>
<?php showSection('المطبخ الفرنسي', $french); ?>
<?php showSection('المطبخ الإيطالي', $italian); ?>
<?php showSection('النادي الرياضي', $gym); ?>
