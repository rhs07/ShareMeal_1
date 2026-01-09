<?php
// volunteer/reports.php

// MOCK DATA (For display list)
$pickups = [
    101 => ['code' => 'P-101', 'donor' => 'Taja Bakery', 'date' => 'Nov 27, 2025', 'notes' => 'Enter through main gate.'],
    102 => ['code' => 'P-102', 'donor' => 'Fresh Mart', 'date' => 'Nov 26, 2025', 'notes' => 'Call before arrival.'],
    103 => ['code' => 'P-103', 'donor' => 'Wedding Hall', 'date' => 'Nov 25, 2025', 'notes' => 'Packaged in large boxes.']
];

$distributions = [
    201 => ['code' => 'D-201', 'recipient' => 'Gulshan Center', 'date' => 'Nov 27, 2025', 'notes' => 'Handed to Manager.'],
    202 => ['code' => 'D-202', 'recipient' => 'Orphanage', 'date' => 'Nov 26, 2025', 'notes' => 'Verified by staff.'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reports & Downloads</title>
    <style>
        :root { --primary: #2D6A4F; --bg: #f3f4f6; --white: #ffffff; --text: #1f2937; }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: sans-serif; }
        body { background: var(--bg); display: flex; min-height: 100vh; }
        .main-content { margin-left: 260px; flex: 1; padding: 30px; }
        
        .page-title { font-size: 1.5rem; font-weight: bold; color: var(--text); margin-bottom: 25px; }

        /* CARDS FOR BULK DOWNLOAD */
        .bulk-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 40px; }
        .bulk-card { 
            background: white; padding: 25px; border-radius: 12px; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.05); display: flex; 
            justify-content: space-between; align-items: center; 
        }
        .bulk-info h3 { margin: 0 0 5px 0; color: var(--text); }
        .bulk-info p { margin: 0; color: #6b7280; font-size: 0.9rem; }
        
        .btn-download {
            background-color: var(--primary); color: white; padding: 10px 20px; 
            border-radius: 8px; text-decoration: none; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;
        }
        .btn-download:hover { background-color: #1B4332; }

        /* TABLE SECTIONS */
        .section-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 15px; color: #374151; }
        .table-box { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05); margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background: #e5e7eb; padding: 12px 20px; font-size: 0.9rem; color: #4b5563; }
        td { padding: 12px 20px; border-bottom: 1px solid #e5e7eb; color: #1f2937; font-size: 0.95rem; }
        
        .btn-sm { 
            background: white; border: 1px solid #d1d5db; color: #374151; 
            padding: 5px 12px; border-radius: 6px; text-decoration: none; font-size: 0.85rem; 
        }
        .btn-sm:hover { border-color: var(--primary); color: var(--primary); }

    </style>
</head>
<body>

    <?php include 'layout/sidebar.php'; ?>

    <div class="main-content">
        <h1 class="page-title">Reports & Downloads</h1>

        <div class="bulk-grid">
            <div class="bulk-card">
                <div class="bulk-info">
                    <h3>All Pickups Report</h3>
                    <p>Download full history CSV</p>
                </div>
                <a href="export.php?type=all_pickups" class="btn-download">
                    ⬇ CSV
                </a>
            </div>

            <div class="bulk-card">
                <div class="bulk-info">
                    <h3>All Distributions Report</h3>
                    <p>Download full history CSV</p>
                </div>
                <a href="export.php?type=all_distributions" class="btn-download">
                    ⬇ CSV
                </a>
            </div>
        </div>

        <div class="section-title">Specific Pickup Notes</div>
        <div class="table-box">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Donor</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($pickups as $id => $p): ?>
                    <tr>
                        <td><?php echo $p['code']; ?></td>
                        <td><?php echo $p['donor']; ?></td>
                        <td><?php echo $p['date']; ?></td>
                        <td>
                            <a href="export.php?type=note&category=pickup&id=<?php echo $id; ?>" class="btn-sm">
                                ⬇ Note
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="section-title">Specific Distribution Notes</div>
        <div class="table-box">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Recipient</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($distributions as $id => $d): ?>
                    <tr>
                        <td><?php echo $d['code']; ?></td>
                        <td><?php echo $d['recipient']; ?></td>
                        <td><?php echo $d['date']; ?></td>
                        <td>
                            <a href="export.php?type=note&category=distribution&id=<?php echo $id; ?>" class="btn-sm">
                                ⬇ Note
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>