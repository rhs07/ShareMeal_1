<?php
// volunteer/export.php

$type = $_GET['type'] ?? '';

// ------------------------------------------
// 1. EXPORT ALL PICKUPS (CSV)
// ------------------------------------------
if ($type === 'all_pickups') {
    $filename = "pickups_report_" . date('Y-m-d') . ".csv";
    
    // Headers to force download
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    
    // CSV Header Row
    fputcsv($output, ['ID', 'Donor Name', 'Date', 'Status', 'Weight (kg)', 'Notes']);
    
    // Mock Data Rows
    fputcsv($output, ['P-101', 'Taja Bakery', '2025-11-27', 'Completed', '20', 'Main gate entry']);
    fputcsv($output, ['P-102', 'Fresh Mart', '2025-11-26', 'Completed', '15', 'Call on arrival']);
    fputcsv($output, ['P-103', 'Wedding Hall', '2025-11-25', 'Completed', '50', 'Packaged boxes']);
    
    fclose($output);
    exit;
}

// ------------------------------------------
// 2. EXPORT ALL DISTRIBUTIONS (CSV)
// ------------------------------------------
if ($type === 'all_distributions') {
    $filename = "distributions_report_" . date('Y-m-d') . ".csv";
    
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    $output = fopen('php://output', 'w');
    
    fputcsv($output, ['ID', 'Recipient', 'Date', 'Items', 'Verified By']);
    
    fputcsv($output, ['D-201', 'Gulshan Center', '2025-11-27', 'Pastries', 'Manager']);
    fputcsv($output, ['D-202', 'Orphanage', '2025-11-26', 'Vegetables', 'Staff']);
    
    fclose($output);
    exit;
}

// ------------------------------------------
// 3. EXPORT SPECIFIC NOTE (TXT)
// ------------------------------------------
if ($type === 'note') {
    $id = $_GET['id'] ?? '000';
    $cat = $_GET['category'] ?? 'general';
    
    // Mock fetching note content based on ID
    $note_content = "Details for ID: $id\n";
    $note_content .= "Category: " . ucfirst($cat) . "\n";
    $note_content .= "Date Generated: " . date('Y-m-d H:i:s') . "\n";
    $note_content .= "---------------------------\n";
    $note_content .= "NOTE CONTENT:\n";
    $note_content .= "This is the specific note content for this transaction.\n";
    $note_content .= "Food condition was verified. No issues reported.\n";
    
    $filename = "note_{$cat}_{$id}.txt";
    
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    
    echo $note_content;
    exit;
}

// If no valid type
echo "Invalid request.";
?>