<?php
require_once 'includes/header.php';

// Get search parameters
$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$category_id = isset($_GET['category']) ? intval($_GET['category']) : 0;
$region_id = isset($_GET['region']) ? intval($_GET['region']) : 0;
?>

<main class="container mx-auto px-4 py-8">
    <!-- Search and Filters -->
    <div class="bg-white p-6 rounded-lg shadow-sm mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Explore Laws</h1>
        
        <!-- Search Bar -->
        <form method="GET" class="mb-6">
            <div class="flex">
                <input type="text" name="q" value="<?= htmlspecialchars($search) ?>" 
                       placeholder="Search by law name or keywords..."
                       class="flex-grow p-3 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <button type="submit" class="bg-blue-600 text-white px-4 py-3 rounded-r-lg hover:bg-blue-700 transition">
                    Search
                </button>
            </div>
        </form>
        
        <!-- Filter Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category" onchange="this.form.submit()" class="w-full p-2 border rounded-md">
                    <option value="">All Categories</option>
                    <?php
                    $categories = $db->query("SELECT * FROM categories ORDER BY name");
                    while ($cat = $categories->fetch_assoc()):
                        $selected = ($category_id == $cat['id']) ? 'selected' : '';
                    ?>
                        <option value="<?= $cat['id'] ?>" <?= $selected ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Region</label>
                <select name="region" onchange="this.form.submit()" class="w-full p-2 border rounded-md">
                    <option value="">All Regions</option>
                    <?php
                    $regions = $db->query("SELECT * FROM regions ORDER BY name");
                    while ($reg = $regions->fetch_assoc()):
                        $selected = ($region_id == $reg['id']) ? 'selected' : '';
                    ?>
                        <option value="<?= $reg['id'] ?>" <?= $selected ?>>
                            <?= htmlspecialchars($reg['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
        </div>
    </div>
    
    <!-- Results Section -->
    <div class="bg-white p-6 rounded-lg shadow-sm">
        <?php
        // Build query
        $sql = "SELECT l.*, r.name as region_name, c.name as category_name 
                FROM laws l
                LEFT JOIN regions r ON l.region_id = r.id
                LEFT JOIN categories c ON l.category_id = c.id
                WHERE 1=1";
        
        $params = [];
        
        if (!empty($search)) {
            $sql .= " AND (l.title LIKE ? OR l.description LIKE ? OR l.simple_explanation LIKE ?)";
            $params = array_merge($params, ["%$search%", "%$search%", "%$search%"]);
        }
        
        if ($category_id > 0) {
            $sql .= " AND l.category_id = ?";
            $params[] = $category_id;
        }
        
        if ($region_id > 0) {
            $sql .= " AND l.region_id = ?";
            $params[] = $region_id;
        }
        
        $sql .= " ORDER BY l.title";
        
        // Execute query
        $stmt = $db->prepare($sql);
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $laws = $stmt->get_result();
        ?>
        
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            <?= $laws->num_rows ?> Law<?= $laws->num_rows != 1 ? 's' : '' ?> Found
        </h2>
        
        <?php if ($laws->num_rows > 0): ?>
            <div class="space-y-6">
                <?php while ($law = $laws->fetch_assoc()): ?>
                    <article class="law-card p-6 border border-gray-200 rounded-lg hover:border-blue-400 transition">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-medium text-blue-700">
                                <?= htmlspecialchars($law['title']) ?>
                            </h3>
                            <div class="flex space-x-2">
                                <?php if ($law['category_name']): ?>
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                        <?= htmlspecialchars($law['category_name']) ?>
                                    </span>
                                <?php endif; ?>
                                <?php if ($law['region_name']): ?>
                                    <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                        <?= htmlspecialchars($law['region_name']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="prose max-w-none mb-4">
                            <p class="text-gray-700"><?= nl2br(htmlspecialchars($law['description'])) ?></p>
                        </div>
                        
                        <div class="bg-blue-50 p-4 rounded-lg mb-3">
                            <h4 class="font-medium text-blue-800 mb-1">Simple Explanation</h4>
                            <p class="text-gray-700"><?= nl2br(htmlspecialchars($law['simple_explanation'])) ?></p>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-medium text-gray-800 mb-1">Real Example</h4>
                            <p class="text-gray-700"><?= nl2br(htmlspecialchars($law['example'])) ?></p>
                        </div>
                        
                        <?php if (!empty($law['official_link'])): ?>
                            <div class="mt-4">
                                <a href="<?= htmlspecialchars($law['official_link']) ?>" 
                                   target="_blank" 
                                   class="text-blue-600 hover:underline inline-flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    View Official Document
                                </a>
                            </div>
                        <?php endif; ?>
                    </article>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-700">No laws found</h3>
                <p class="mt-1 text-gray-500">Try adjusting your search or filters</p>
                <a href="explore.php" class="mt-4 inline-block text-blue-600 hover:underline">Clear all filters</a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>