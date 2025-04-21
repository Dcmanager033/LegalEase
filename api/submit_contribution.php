<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

// Validate required fields
$required = ['law_title', 'category_id', 'official_link', 'description', 'simple_explanation', 'example', 'contributor_id'];
foreach ($required as $field) {
    if (empty($_POST[$field])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => "$field is required"]);
        exit;
    }
}

// Sanitize inputs
$contributor_id = intval($_POST['contributor_id']);
$category_id = intval($_POST['category_id']);
$region_id = !empty($_POST['region_id']) ? intval($_POST['region_id']) : null;

$law_title = $db->real_escape_string(trim($_POST['law_title']));
$official_link = $db->real_escape_string(trim($_POST['official_link']));
$description = $db->real_escape_string(trim($_POST['description']));
$simple_explanation = $db->real_escape_string(trim($_POST['simple_explanation']));
$example = $db->real_escape_string(trim($_POST['example']));

// Insert submission
$sql = "INSERT INTO submissions (contributor_id, law_title, law_description, simple_explanation, example, 
                                official_link, region_id, category_id, status)
        VALUES ($contributor_id, '$law_title', '$description', '$simple_explanation', '$example',
                '$official_link', " . ($region_id ? $region_id : 'NULL') . ", $category_id, 'pending')";

if ($db->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Contribution submitted successfully']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $db->error]);
}

$db->close();
?>