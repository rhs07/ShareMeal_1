<?php
// volunteer/distribution.php

// MOCK DATA: List of NGOs/Clubs to distribute to
$ngos = [
    1 => ['name' => 'Gulshan Community Center', 'location' => 'Gulshan 2', 'type' => 'Community Center'],
    2 => ['name' => 'Dhanmondi Orphanage', 'location' => 'Road 27, Dhanmondi', 'type' => 'Orphanage'],
    3 => ['name' => 'Bidyanondo Foundation', 'location' => 'Mirpur 12', 'type' => 'NGO'],
    4 => ['name' => 'Uttara Youth Club', 'location' => 'Sector 4, Uttara', 'type' => 'Club'],
    5 => ['name' => 'Anjuman Mufidul Islam', 'location' => 'Kakrail', 'type' => 'Charity']
];

// Handle Selection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_id = $_POST['ngo_id'];
    $selected_name = $ngos[$selected_id]['name'];
    
    // Redirect to notes.php with the selected NGO info
    header("Location: complete_delivery.php?context=distribution&recipient=" . urlencode($selected_name));
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Distribution</title>
    <style>
        :root { --primary: #2D6A4F; --bg: #f3f4f6; --white: #ffffff; --text: #1f2937; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: system-ui, sans-serif; }
        body { background: var(--bg); min-height: 100vh; display: flex; }
        
        .main-content { margin-left: 260px; flex: 1; padding: 30px; }
        .page-title { font-size: 1.5rem; font-weight: bold; color: var(--text); margin-bottom: 25px; }

        /* SELECTION GRID */
        .ngo-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        
        /* CARD STYLES */
        .ngo-card {
            background: white; border-radius: 12px; padding: 20px;
            border: 2px solid transparent; cursor: pointer;
            transition: 0.2s; box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            display: flex; align-items: center; justify-content: space-between;
        }
        .ngo-card:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        
        /* HIDDEN RADIO BUTTON LOGIC */
        input[type="radio"] { display: none; }
        input[type="radio"]:checked + .ngo-card {
            border-color: var(--primary);
            background-color: #f0fdf4;
        }
        input[type="radio"]:checked + .ngo-card .check-icon {
            display: block; background: var(--primary); color: white;
        }

        .ngo-info h3 { margin: 0 0 5px 0; font-size: 1.1rem; color: #374151; }
        .ngo-info p { margin: 0; font-size: 0.9rem; color: #6b7280; }
        .badge { font-size: 0.75rem; background: #e5e7eb; padding: 3px 8px; border-radius: 10px; color: #4b5563; margin-top: 8px; display: inline-block; }

        .check-icon {
            width: 24px; height: 24px; border-radius: 50%; border: 2px solid #d1d5db;
            display: none; text-align: center; line-height: 20px; font-size: 14px;
        }

        /* NEXT BUTTON */
        .footer-action { margin-top: 30px; text-align: right; }
        .btn-next {
            background-color: var(--primary); color: white; border: none;
            padding: 12px 30px; border-radius: 8px; font-size: 1rem; font-weight: 600;
            cursor: pointer; transition: 0.2s;
        }
        .btn-next:hover { background-color: #1B4332; }
    </style>
</head>
<body>

    <?php include 'layout/sidebar.php'; ?>

    <div class="main-content">
        <h1 class="page-title">Select Destination</h1>
        <p style="margin-bottom: 25px; color: #6b7280;">Choose the NGO or Center you are delivering to:</p>

        <form method="POST">
            <div class="ngo-grid">
                <?php foreach ($ngos as $id => $ngo): ?>
                    <label>
                        <input type="radio" name="ngo_id" value="<?php echo $id; ?>" required>
                        <div class="ngo-card">
                            <div class="ngo-info">
                                <h3><?php echo $ngo['name']; ?></h3>
                                <p>📍 <?php echo $ngo['location']; ?></p>
                                <span class="badge"><?php echo $ngo['type']; ?></span>
                            </div>
                            <div class="check-icon">✓</div>
                        </div>
                    </label>
                <?php endforeach; ?>
            </div>

            <div class="footer-action">
                <button type="submit" class="btn-next">Confirm →</button>
            </div>
        </form>
    </div>

</body>
</html>