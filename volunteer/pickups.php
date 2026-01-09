<?php
// volunteer/pickups.php

// 1. MOCK DATABASE (Matches your screenshot)
$pickups = [
    [
        'id' => 101, 
        'donor' => 'Rahim Uddin', 
        'time' => 'Today, 2:00 PM', 
        'location' => 'Gulshan 1, Dhaka', 
        'status' => 'Pending'
    ],
    [
        'id' => 102, 
        'donor' => 'Dhaka Fresh Foods', 
        'time' => 'Today, 2:30 PM', 
        'location' => 'Banani, Dhaka', 
        'status' => 'In Progress'
    ],
    [
        'id' => 103, 
        'donor' => 'Karim Ahmed', 
        'time' => 'Today, 3:00 PM', 
        'location' => 'Motijheel, Dhaka', 
        'status' => 'Completed'
    ],
    [
        'id' => 104, 
        'donor' => 'Anjuman Mufidul', 
        'time' => 'Today, 3:30 PM', 
        'location' => 'Dhanmondi, Dhaka', 
        'status' => 'Completed'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assigned Pickups</title>
    <style>
        /* PAGE STYLES */
        body { margin: 0; background-color: #f3f4f6; font-family: system-ui, sans-serif; }
        .main-content { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; }
        .header { height: 70px; background: white; padding: 0 30px; display: flex; justify-content: flex-end; align-items: center; border-bottom: 1px solid #e5e7eb; }
        .header-icons a { font-size: 1.2rem; margin-left: 15px; text-decoration: none; }
        .container { padding: 30px; }
        .table-box { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        thead { background: #e5e7eb; }
        th { padding: 15px 20px; color: #4b5563; font-weight: 600; font-size: 0.9rem; }
        td { padding: 15px 20px; border-bottom: 1px solid #e5e7eb; color: #1f2937; }
        tr:hover { background: #f9fafb; }
        
        .badge { padding: 4px 12px; border-radius: 20px; font-size: 0.8rem; font-weight: 600; }
        .status-Pending { background: #ffedd5; color: #c2410c; }
        .status-In { background: #0ea5e9; color: white; }
        .status-Completed { background: #15803d; color: white; }

        .btn { padding: 5px 10px; border: 1px solid #d1d5db; background: white; border-radius: 5px; text-decoration: none; font-size: 0.85rem; color: #4b5563; margin-right: 5px; }
        .btn:hover { border-color: #2D6A4F; color: #2D6A4F; background: #f0fdf4; }
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
            <h2 style="margin-top: 0; color: #1f2937;">Assigned Pickups</h2>
            <div class="table-box">
                <table>
                    <thead>
                        <tr>
                            <th>Donor Name</th>
                            <th>Pickup Time</th>
                            <th>Location</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pickups as $row): ?>
                            <?php
                                $statusClass = 'status-Completed';
                                if($row['status'] == 'Pending') $statusClass = 'status-Pending';
                                if(strpos($row['status'], 'In') !== false) $statusClass = 'status-In';
                            ?>
                            <tr>
                                <td><?php echo $row['donor']; ?></td>
                                <td style="color: #6b7280;"><?php echo $row['time']; ?></td>
                                <td><?php echo $row['location']; ?></td>
                                <td><span class="badge <?php echo $statusClass; ?>"><?php echo $row['status']; ?></span></td>
                                <td>
                                    <a href="http://maps.google.com/?q=<?php echo urlencode($row['location']); ?>" target="_blank" class="btn">📍</a>
                                    
                                    <a href="pickup_detail.php?id=<?php echo $row['id']; ?>" class="btn">View</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>