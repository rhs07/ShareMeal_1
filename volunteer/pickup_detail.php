<?php
// volunteer/pickup_detail.php

// 1. GET THE ID FROM URL (Default to 101 if missing)
$id = $_GET['id'] ?? 101;

// 2. MOCK DATABASE (Contains details for ALL pickups)
// In a real project, this would be a SQL query: "SELECT * FROM pickups WHERE id = $id"
$all_pickups = [
    101 => [
        'id' => 101, 'status' => 'Pending',
        'donor_name' => 'Rahim Uddin', 'contact' => 'Rahim Uddin', 'phone' => '0171-2345678',
        'food_type' => '20kg Assorted Pastries', 'quantity' => '5 Boxes',
        'address' => 'House 12, Road 5, Gulshan 1, Dhaka',
        'notes' => 'Please enter through the main gate. Ask for Rahman.'
    ],
    102 => [
        'id' => 102, 'status' => 'In Progress',
        'donor_name' => 'Dhaka Fresh Foods', 'contact' => 'Manager Hasan', 'phone' => '0181-9876543',
        'food_type' => 'Fresh Vegetables', 'quantity' => '10 kg',
        'address' => 'Plot 7, Block C, Banani, Dhaka',
        'notes' => 'Call before arriving.'
    ],
    103 => [
        'id' => 103, 'status' => 'Completed',
        'donor_name' => 'Karim Ahmed', 'contact' => 'Karim Ahmed', 'phone' => '0191-1122334',
        'food_type' => 'Biryani & Chicken Roast', 'quantity' => '50 Packets',
        'address' => '32 Topkhana Road, Motijheel, Dhaka',
        'notes' => 'Food is packed in boxes.'
    ],
    104 => [
        'id' => 104, 'status' => 'Completed',
        'donor_name' => 'Anjuman Mufidul', 'contact' => 'Office Staff', 'phone' => '0161-5566778',
        'food_type' => 'Rice and Dal', 'quantity' => '30 kg',
        'address' => '45 Dhanmondi, Road 27, Dhaka',
        'notes' => 'Pickup from back door.'
    ]
];

// 3. FETCH DATA FOR CURRENT ID
$pickup = $all_pickups[$id] ?? $all_pickups[101]; // Fallback if ID not found

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pickup Detail</title>
    <style>
        /* CSS VARIABLES */
        :root { --primary: #2D6A4F; --bg: #f3f4f6; }
        body { margin: 0; background: var(--bg); font-family: system-ui, sans-serif; }
        
        .main-content { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; }
        
        /* HEADER */
        .header { height: 70px; background: white; padding: 0 30px; display: flex; justify-content: flex-end; align-items: center; border-bottom: 1px solid #e5e7eb; }
        .header-icons a { font-size: 1.2rem; margin-left: 15px; text-decoration: none; }

        /* CONTAINER */
        .container { padding: 30px; max-width: 1000px; margin: 0 auto; width: 100%; }
        
        /* BACK BUTTON & TITLE */
        .top-bar { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
        .back-btn { background: white; border: 1px solid #ddd; width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 8px; text-decoration: none; color: #333; }
        .page-title { font-size: 1.5rem; font-weight: bold; color: #1f2937; }

        /* GRID LAYOUT */
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .card-head { padding: 15px 20px; background: white; border-bottom: 1px solid #eee; font-weight: 600; display: flex; align-items: center; gap: 10px; }
        .card-body { padding: 20px; }

        /* DATA ROWS */
        .row { margin-bottom: 20px; }
        .label { font-size: 0.85rem; color: #6b7280; margin-bottom: 5px; }
        .value { font-size: 1rem; color: #1f2937; font-weight: 500; border-bottom: 1px solid #f9fafb; padding-bottom: 10px; }

        /* MAP BOX */
        .map-box { height: 150px; background: #e5e7eb; border-radius: 8px; position: relative; margin-bottom: 20px; background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/OpenStreetMap_Logo_2011.svg/1024px-OpenStreetMap_Logo_2011.svg.png'); background-size: cover; background-position: center; }
        .map-add { position: absolute; bottom: 10px; left: 50%; transform: translateX(-50%); background: white; padding: 5px 10px; border-radius: 15px; font-size: 0.8rem; font-weight: 600; white-space: nowrap; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }

        /* NOTES */
        .notes { background: #F0FDF4; border: 1px solid #DCFCE7; padding: 15px; border-radius: 8px; color: #166534; font-size: 0.95rem; }

        /* BUTTON FOOTER */
        .footer { margin-top: 30px; display: flex; justify-content: flex-end; }
        .btn-complete { background: var(--primary); color: white; padding: 12px 30px; border-radius: 8px; text-decoration: none; font-weight: 600; transition: 0.2s; }
        .btn-complete:hover { background: #1B4332; }
        
        .status-badge-large { background: #15803d; color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold; }
    </style>
</head>
<body>

    <?php include 'layout/sidebar.php'; ?>

    <div class="main-content">
        <div class="header">
            <div class="header-icons">
                <a href="chat.php">✉️</a>
                <a href="notifications.php">🔔</a>
                <a href="profile.php">👤</a>
            </div>
        </div>

        <div class="container">
            <div class="top-bar">
                <a href="pickups.php" class="back-btn">←</a>
                <div class="page-title">Pickup Detail</div>
            </div>

            <div class="grid">
                <div class="card">
                    <div class="card-head">👤 Donor & Food Details</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="label">Donor</div>
                            <div class="value"><?php echo $pickup['donor_name']; ?></div>
                        </div>
                        <div class="row">
                            <div class="label">Contact</div>
                            <div class="value"><?php echo $pickup['contact']; ?>, <?php echo $pickup['phone']; ?></div>
                        </div>
                        <div class="row">
                            <div class="label">Food Type</div>
                            <div class="value"><?php echo $pickup['food_type']; ?></div>
                        </div>
                        <div class="row">
                            <div class="label">Quantity</div>
                            <div class="value"><?php echo $pickup['quantity']; ?></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-head">📍 Location & Notes</div>
                    <div class="card-body">
                        <div class="map-box">
                            <div class="map-add">📍 <?php echo substr($pickup['address'], 0, 25); ?>...</div>
                        </div>
                        <div class="notes">
                            <strong>📝 Pickup Notes:</strong><br>
                            <?php echo $pickup['notes']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <?php if ($pickup['status'] !== 'Completed'): ?>
                    <a href="notes.php?id=<?php echo $pickup['id']; ?>" class="btn-complete">
                        Complete Pickup
                    </a>
                <?php else: ?>
                    <span class="status-badge-large">
                        ✅ Completed
                    </span>
                <?php endif; ?>
            </div>

        </div>
    </div>
</body>
</html>