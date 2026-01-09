<?php
// volunteer/history.php

// 1. MOCK DATA (Matching the screenshot)
$history_data = [
    [
        'date' => 'Nov 27, 2025',
        'donor' => 'Taja Bakery Surplus',
        'ngo' => 'Gulshan Community Center',
        'status' => 'Completed',
        'duration' => '45 mins'
    ],
    [
        'date' => 'Nov 26, 2025',
        'donor' => 'Fresh Mart',
        'ngo' => 'Dhanmondi Orphanage',
        'status' => 'Completed',
        'duration' => '30 mins'
    ],
    [
        'date' => 'Nov 26, 2025',
        'donor' => 'Fresh Bakery Surplus',
        'ngo' => 'Gulshan Community Center',
        'status' => 'Completed',
        'duration' => '45 mins'
    ],
    [
        'date' => 'Nov 24, 2025',
        'donor' => 'Fresh Bakery Surplus',
        'ngo' => 'Gulshan Community Center',
        'status' => 'Completed',
        'duration' => '45 mins'
    ],
    [
        'date' => 'Nov 23, 2025',
        'donor' => 'Fresh Mart',
        'ngo' => 'Dhanmondi Orphanage',
        'status' => 'Completed',
        'duration' => '30 mins'
    ],
    [
        'date' => 'Nov 12, 2025',
        'donor' => 'Fresh Mart',
        'ngo' => 'Gulshan Community Center',
        'status' => 'Completed',
        'duration' => '30 mins'
    ],
    [
        'date' => 'Nov 11, 2025',
        'donor' => 'Fresh Bakery Surplus',
        'ngo' => 'Dhanmondi Orphanage',
        'status' => 'Completed',
        'duration' => '30 mins'
    ],
    [
        'date' => 'Nov 23, 2025',
        'donor' => 'Fresh Bakery Surplus',
        'ngo' => 'Gulshan Community Center',
        'status' => 'Completed',
        'duration' => '30 mins'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pickup History</title>
    <style>
        /* --- RESET & VARIABLES --- */
        :root {
            --primary: #2D6A4F;
            --bg-color: #f3f4f6;
            --white: #ffffff;
            --text-dark: #1f2937;
            --text-gray: #6b7280;
            --border: #e5e7eb;
            --sidebar-w: 260px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background: var(--bg-color); min-height: 100vh; }

        /* --- LAYOUT --- */
        .main-content {
            margin-left: var(--sidebar-w);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- HEADER --- */
        .header {
            height: 70px;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 0 30px;
            border-bottom: 1px solid var(--border);
        }
        .header-icons { display: flex; gap: 20px; }
        .icon-btn { font-size: 1.2rem; color: var(--text-gray); text-decoration: none; transition: color 0.2s; }
        .icon-btn:hover { color: var(--primary); }

        /* --- CONTENT AREA --- */
        .container { padding: 30px; }
        
        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 25px;
        }

        /* --- TABLE STYLES --- */
        .table-card {
            background: var(--white);
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            overflow: hidden; /* Ensures rounded corners for the table */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        thead {
            background-color: #E5E7EB; /* Gray header background */
        }

        th {
            padding: 16px 24px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #4b5563;
        }

        /* Zebra Striping (Alternating Row Colors) */
        tbody tr:nth-child(odd) { background-color: #ffffff; }
        tbody tr:nth-child(even) { background-color: #f9fafb; }
        
        tbody tr:hover { background-color: #f3f4f6; }

        td {
            padding: 16px 24px;
            font-size: 0.95rem;
            color: #374151;
            border-bottom: 1px solid var(--border);
            vertical-align: middle;
        }
        
        /* Remove border from last row */
        tbody tr:last-child td { border-bottom: none; }

        /* --- STATUS BADGE --- */
        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-align: center;
            min-width: 100px;
        }

        .badge-completed {
            background-color: #15803d; /* Dark Green */
            color: white;
        }

        /* Text colors for specific columns */
        .text-light { color: #6b7280; }
        
    </style>
</head>
<body>

    <?php include 'layout/sidebar.php'; ?>

    <main class="main-content">
        
        <header class="header">
            <div class="header-icons">
                <a href="chat.php" class="icon-btn">✉️</a>
                <a href="notifications.php" class="icon-btn">🔔</a>
                <a href="profile.php" class="icon-btn">👤</a>
            </div>
        </header>

        <div class="container">
            <h1 class="page-title">Pickup History</h1>

            <div class="table-card">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Donor</th>
                            <th>NGO</th>
                            <th>Status</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($history_data as $row): ?>
                            <tr>
                                <td class="text-light"><?php echo $row['date']; ?></td>
                                <td style="font-weight: 500;"><?php echo $row['donor']; ?></td>
                                <td class="text-light"><?php echo $row['ngo']; ?></td>
                                
                                <td>
                                    <span class="badge badge-completed">
                                        <?php echo $row['status']; ?>
                                    </span>
                                </td>
                                
                                <td class="text-light"><?php echo $row['duration']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </main>

</body>
</html>