<?php
// volunteer/notifications.php

// REALISTIC PROJECT NOTIFICATIONS
$notifications = [
    [
        'type'  => 'pickup',
        'color' => 'green', 
        'title' => 'New Pickup Assigned: Star Kabab',
        'desc'  => '20kg Rice & Curry at Dhanmondi.',
        'time'  => '2 min ago'
    ],
    [
        'type'  => 'urgent',
        'color' => 'red',
        'title' => 'Urgent: Volunteer needed in Gulshan',
        'desc'  => 'Large donation expiring in 2 hours.',
        'time'  => '15 min ago'
    ],
    [
        'type'  => 'success',
        'color' => 'blue',
        'title' => 'Delivery Verified: #D-1028',
        'desc'  => 'Recipient confirmed receipt of goods.',
        'time'  => '1 hour ago'
    ],
    [
        'type'  => 'info',
        'color' => 'gray',
        'title' => 'Pickup Canceled: Taja Bakery',
        'desc'  => 'Donor rescheduled for tomorrow.',
        'time'  => '3 hours ago'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <style>
        /* --- RESET & VARIABLES --- */
        :root {
            --text-dark: #1f2937;
            --text-gray: #6b7280;
            --border: #f3f4f6;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }

        /* --- BLURRED BACKGROUND --- */
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
            filter: blur(6px);
            z-index: -1;
        }

        /* --- MODAL CARD --- */
        .modal-card {
            background: white;
            width: 90%;
            max-width: 480px;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        /* --- HEADER --- */
        .modal-header {
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border);
        }
        .modal-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-dark);
        }
        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #9ca3af;
            cursor: pointer;
            text-decoration: none;
            line-height: 1;
        }
        .close-btn:hover { color: var(--text-dark); }

        /* --- BODY --- */
        .modal-body {
            padding: 0;
            max-height: 400px;
            overflow-y: auto;
        }

        .notif-item {
            display: flex;
            align-items: flex-start;
            padding: 20px 25px;
            border-bottom: 1px solid var(--border);
            transition: background 0.2s;
            text-decoration: none; /* Make clickable */
        }
        .notif-item:hover { background-color: #f9fafb; }
        .notif-item:last-child { border-bottom: none; }

        /* Icon Box */
        .icon-box {
            width: 40px;
            height: 40px;
            border-radius: 50%; /* Circle icons look cleaner for list */
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
            color: white;
        }

        /* Color Themes */
        .bg-green { background-color: #2D6A4F; }
        .bg-red   { background-color: #DC2626; }
        .bg-blue  { background-color: #3B82F6; }
        .bg-gray  { background-color: #6B7280; }

        .icon-box svg { width: 20px; height: 20px; stroke-width: 2; }

        /* Text Content */
        .content { display: flex; flex-direction: column; }
        .notif-title { font-size: 0.95rem; font-weight: 600; color: var(--text-dark); margin-bottom: 2px; }
        .notif-desc { font-size: 0.85rem; color: #4b5563; margin-bottom: 4px; line-height: 1.4; }
        .notif-time { font-size: 0.75rem; color: #9ca3af; }

        /* Mark all as read button (Optional Footer) */
        .modal-footer {
            padding: 15px;
            text-align: center;
            background-color: #f9fafb;
            border-top: 1px solid var(--border);
        }
        .mark-read { color: #2D6A4F; font-size: 0.9rem; font-weight: 600; text-decoration: none; }

    </style>
</head>
<body>

    <div class="modal-card">
        
        <div class="modal-header">
            <h2 class="modal-title">Notifications</h2>
            <a href="dashboard.php" class="close-btn">&times;</a>
        </div>

        <div class="modal-body">
            
            <?php foreach ($notifications as $n): ?>
                <a href="pickups.php" class="notif-item">
                    
                    <div class="icon-box bg-<?php echo $n['color']; ?>">
                        <?php if ($n['type'] == 'pickup'): ?>
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                        <?php elseif ($n['type'] == 'urgent'): ?>
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        <?php elseif ($n['type'] == 'success'): ?>
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                        <?php else: ?>
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <?php endif; ?>
                    </div>
                    
                    <div class="content">
                        <div class="notif-title"><?php echo $n['title']; ?></div>
                        <div class="notif-desc"><?php echo $n['desc']; ?></div>
                        <div class="notif-time"><?php echo $n['time']; ?></div>
                    </div>
                </a>
            <?php endforeach; ?>

        </div>
        
        <div class="modal-footer">
            <a href="#" class="mark-read">Mark all as read</a>
        </div>

    </div>

</body>
</html>