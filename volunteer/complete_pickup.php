<?php
// volunteer/complete_pickup.php

// 1. GET ID & DATA
$id = $_GET['id'] ?? 101;

// Mock Data
$pickup_data = [
    101 => ['code' => 'D-1028', 'item' => '5 Boxes-Assorted Pastries (20kg total)'],
    102 => ['code' => 'D-1029', 'item' => '10 kg Fresh Vegetables'],
    103 => ['code' => 'D-1030', 'item' => '50 Packets Biryani'],
    104 => ['code' => 'D-1031', 'item' => '30 kg Rice and Dal']
];
$data = $pickup_data[$id] ?? $pickup_data[101];

// 2. HANDLE SUBMISSION
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // LOGIC: Pickup confirmed -> Now go to Delivery step
    header("Location: dashboard.php?id=$id"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Pickup</title>
    <style>
        /* --- RESET & VARS --- */
        :root {
            --primary: #2D6A4F;
            --primary-hover: #1B4332;
            --text-dark: #1f2937;
            --text-gray: #6b7280;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }

        /* --- BACKGROUND LAYER (THE BLURRED MAP) --- */
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background-color: #f3f4f6;
        }

        body::before {
            content: "";
            position: absolute;
            top: -10px; left: -10px; right: -10px; bottom: -10px;
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/OpenStreetMap_Logo_2011.svg/1024px-OpenStreetMap_Logo_2011.svg.png');
            background-size: cover;
            background-position: center;
            filter: blur(8px) brightness(0.9); 
            z-index: -1;
        }

        /* --- MODAL BOX --- */
        .modal-card {
            background: white;
            width: 90%;
            max-width: 500px;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
        }

        .modal-header { padding: 20px 25px; display: flex; justify-content: space-between; align-items: center; }
        .modal-title { font-size: 1.3rem; font-weight: 700; color: #374151; }
        .close-btn { background: none; border: none; font-size: 1.5rem; color: #9ca3af; cursor: pointer; text-decoration: none; }
        
        .modal-body { padding: 0 25px 25px 25px; }
        .section-title { color: #6b7280; font-size: 1rem; margin-bottom: 15px; }
        .checkbox-row { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; cursor: pointer; }
        input[type="checkbox"] { width: 20px; height: 20px; accent-color: var(--primary); cursor: pointer; }
        .checkbox-text { color: #4b5563; font-size: 0.95rem; }
        
        .notes-label { display: block; font-weight: 700; color: #4b5563; margin-top: 20px; margin-bottom: 10px; font-size: 0.95rem; }
        .notes-input { width: 100%; padding: 12px; border: 1px solid #e5e7eb; border-radius: 8px; font-size: 0.95rem; resize: none; height: 80px; font-family: inherit; }
        .notes-input:focus { outline: none; border-color: var(--primary); }

        .modal-footer { padding: 20px 25px; display: flex; gap: 10px; border-top: 1px solid #f3f4f6; }
        .btn { padding: 12px 24px; border-radius: 8px; font-weight: 600; font-size: 1rem; cursor: pointer; text-align: center; border: none; text-decoration: none; }
        .btn-confirm { background-color: var(--primary); color: white; flex-grow: 1; }
        .btn-confirm:hover { background-color: var(--primary-hover); }
        .btn-cancel { background-color: #f3f4f6; color: #4b5563; }
        .btn-cancel:hover { background-color: #e5e7eb; }
    </style>
</head>
<body>
    <form class="modal-card" method="POST">
        <div class="modal-header">
            <div class="modal-title">Complete Pickup: #<?php echo $data['code']; ?></div>
            <a href="pickup_detail.php?id=<?php echo $id; ?>" class="close-btn">&times;</a>
        </div>
        <div class="modal-body">
            <div class="section-title">Confirm Items Received</div>
            <label class="checkbox-row">
                <input type="checkbox" name="item_check" checked>
                <span class="checkbox-text"><?php echo $data['item']; ?></span>
            </label>
            <label class="checkbox-row">
                <input type="checkbox" name="quality_check">
                <span class="checkbox-text">Quality & Seal Verified</span>
            </label>
            <label class="notes-label">Food Condition Notes</label>
            <textarea name="notes" class="notes-input" placeholder="e.g., Packages intact, looks fresh."></textarea>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-confirm">Confirm Pickup</button>
            <a href="pickup_detail.php?id=<?php echo $id; ?>" class="btn btn-cancel">Cancel</a>
        </div>
    </form>
</body>
</html>