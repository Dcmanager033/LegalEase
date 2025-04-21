<?php
require_once 'includes/header.php';

// Get popular categories and regions
$categories = $db->query("SELECT * FROM categories ORDER BY RAND() LIMIT 6");
$regions = $db->query("SELECT * FROM regions ORDER BY RAND() LIMIT 4");
?>

<main class="container mx-auto px-4 py-8">
    <!-- Hero Section -->
    <section class="text-center mb-12">
        <h1 class="text-4xl font-bold text-blue-800 mb-4">Understand Your Rights</h1>
        <p class="text-xl text-gray-600 max-w-2xl mx-auto">
            LegalEase simplifies complex laws with plain-language explanations and real-world examples.
        </p>
        
        <!-- Quick Search -->
        <div class="mt-8 max-w-md mx-auto">
            <form action="explore.php" method="get" class="flex flex-col sm:flex-row gap-2">
                <input type="text" name="q" placeholder="Search laws..." 
                       class="flex-grow p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 transition">
                    Search Laws
                </button>
            </form>
        </div>
    </section>

    <!-- Categories Grid -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Browse by Category</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while ($cat = $categories->fetch_assoc()): ?>
                <a href="explore.php?category=<?= $cat['id'] ?>" 
                   class="block p-6 border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition">
                    <h3 class="text-xl font-medium text-blue-700 mb-2"><?= htmlspecialchars($cat['name']) ?></h3>
                    <p class="text-gray-600"><?= htmlspecialchars(substr($cat['description'] ?? '', 0, 100)) ?>...</p>
                </a>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- Regions Section -->
    <section class="mb-12">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Laws by Region</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <?php while ($reg = $regions->fetch_assoc()): ?>
                <a href="explore.php?region=<?= $reg['id'] ?>" 
                   class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 hover:border-green-500 transition text-center">
                    <h3 class="text-lg font-medium text-gray-800"><?= htmlspecialchars($reg['name']) ?></h3>
                    <p class="text-sm text-gray-500 mt-1"><?= htmlspecialchars($reg['code']) ?></p>
                </a>
            <?php endwhile; ?>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>