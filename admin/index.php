<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once '../includes/db.php';

// Check if user is logged in as admin/contributor
if (!isset($_SESSION['contributor_id'])) {
    header('Location: ../login.php');
    exit;
}

// Get contributor info
$contributor_id = intval($_SESSION['contributor_id']); // Sanitize input
$contributor_stmt = $db->prepare("SELECT * FROM contributors WHERE id = ?");
$contributor_stmt->bind_param("i", $contributor_id);
$contributor_stmt->execute();
$contributor_result = $contributor_stmt->get_result();
$contributor = $contributor_result->fetch_assoc();

if (!$contributor) {
    // Contributor not found in database
    header('Location: ../logout.php');
    exit;
}

// Get submissions count using prepared statements to prevent SQL injection
$submissions_stmt = $db->prepare("SELECT COUNT(*) as count FROM submissions WHERE contributor_id = ?");
$submissions_stmt->bind_param("i", $contributor_id);
$submissions_stmt->execute();
$submissions_count = $submissions_stmt->get_result()->fetch_assoc()['count'];

$approved_stmt = $db->prepare("SELECT COUNT(*) as count FROM submissions WHERE contributor_id = ? AND status = 'approved'");
$approved_stmt->bind_param("i", $contributor_id);
$approved_stmt->execute();
$approved_count = $approved_stmt->get_result()->fetch_assoc()['count'];

$pending_stmt = $db->prepare("SELECT COUNT(*) as count FROM submissions WHERE contributor_id = ? AND status = 'pending'");
$pending_stmt->bind_param("i", $contributor_id);
$pending_stmt->execute();
$pending_count = $pending_stmt->get_result()->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LegalEase - Contributor Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-800 text-white min-h-screen">
            <div class="p-4">
                <h1 class="text-xl font-bold">LegalEase</h1>
                <p class="text-blue-200 text-sm">Contributor Dashboard</p>
            </div>
            
            <nav class="mt-6">
                <div class="px-4 py-3 bg-blue-700">
                    <p class="text-sm font-medium">Welcome, <?= htmlspecialchars($contributor['name']) ?></p>
                </div>
                
                <a href="index.php" class="block px-4 py-3 text-white bg-blue-900">
                    Dashboard
                </a>
                <a href="submissions.php" class="block px-4 py-3 text-white hover:bg-blue-700">
                    My Submissions
                </a>
                <a href="new.php" class="block px-4 py-3 text-white hover:bg-blue-700">
                    New Submission
                </a>
                <a href="../logout.php" class="block px-4 py-3 text-white hover:bg-blue-700">
                    Logout
                </a>
            </nav>
        </aside>
        
        <!-- Main content -->
        <main class="flex-1 p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">Contributor Dashboard</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Total Submissions</h3>
                    <p class="text-3xl font-bold text-blue-600"><?= $submissions_count ?></p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Approved</h3>
                    <p class="text-3xl font-bold text-green-600"><?= $approved_count ?></p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-700 mb-2">Pending</h3>
                    <p class="text-3xl font-bold text-yellow-600"><?= $pending_count ?></p>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Recent Submissions</h3>
                
                <?php
                $recent_stmt = $db->prepare("
                    SELECT s.*, c.name as category_name, r.name as region_name 
                    FROM submissions s
                    LEFT JOIN categories c ON s.category_id = c.id
                    LEFT JOIN regions r ON s.region_id = r.id
                    WHERE s.contributor_id = ?
                    ORDER BY s.created_at DESC
                    LIMIT 5
                ");
                $recent_stmt->bind_param("i", $contributor_id);
                $recent_stmt->execute();
                $recent_submissions = $recent_stmt->get_result();
                
                if ($recent_submissions->num_rows > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Region</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php while ($sub = $recent_submissions->fetch_assoc()): ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900"><?= htmlspecialchars($sub['law_title']) ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500"><?= htmlspecialchars($sub['category_name']) ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500"><?= htmlspecialchars($sub['region_name'] ?? 'National') ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                <?= $sub['status'] === 'approved' ? 'bg-green-100 text-green-800' : 
                                                   ($sub['status'] === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') ?>">
                                                <?= ucfirst($sub['status']) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= date('M d, Y', strtotime($sub['created_at'])) ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500">No submissions found.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>