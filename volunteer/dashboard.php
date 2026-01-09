<?php
// volunteer/dashboard.php

// 1. MOCK DATA
$stats = [
    ['title' => 'Active Pickups', 'value' => 3, 'unit' => '', 'link' => 'pickups.php'],
    ['title' => 'Completed Deliveries', 'value' => 145, 'unit' => '', 'link' => 'history.php'],
    ['title' => 'Total Distance', 'value' => 320, 'unit' => 'km', 'link' => 'history.php']
];

$chartData = [
    ['label' => 'Nov 1', 'val' => 5], ['label' => 'Nov 5', 'val' => 15],
    ['label' => 'Nov 10', 'val' => 35], ['label' => 'Nov 15', 'val' => 45],
    ['label' => 'Nov 20', 'val' => 60], ['label' => 'Nov 25', 'val' => 85],
    ['label' => 'Nov 30', 'val' => 95]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <style>
        /* PAGE SPECIFIC STYLES */
        body { margin: 0; background-color: #f3f4f6; font-family: system-ui, sans-serif; }
        .main-content { margin-left: 260px; min-height: 100vh; display: flex; flex-direction: column; }
        
        /* Header */
        .header { height: 70px; background: white; padding: 0 30px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #e5e7eb; }
        .header-icons a { font-size: 1.2rem; margin-left: 15px; text-decoration: none; }
        
        /* Dashboard Grid */
        .container { padding: 30px; }
        .stats-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .card { background: white; padding: 25px; border-radius: 12px; text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,0.05); text-decoration: none; color: inherit; display: block; transition: transform 0.2s; }
        .card:hover { transform: translateY(-3px); }
        .card-val { font-size: 2.5rem; font-weight: bold; color: #2D6A4F; margin: 10px 0; }
        
        /* Chart */
        .chart-box { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <?php include 'layout/sidebar.php'; ?>

    <div class="main-content">
        <div class="header">
            <h3>Dashboard</h3>
            <div class="header-icons">
                <a href="chat.php">✉️</a>
                <a href="notifications.php">🔔</a>
                <a href="profile.php">👤</a>
            </div>
        </div>

        <div class="container">
            <div class="stats-grid">
                <?php foreach($stats as $s): ?>
                    <a href="<?php echo $s['link']; ?>" class="card">
                        <div style="color: #6b7280; font-weight: 600;"><?php echo $s['title']; ?></div>
                        <div class="card-val">
                            <?php echo $s['value']; ?> <span style="font-size: 1.2rem;"><?php echo $s['unit']; ?></span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>

            <div class="chart-box">
                <h4 style="margin: 0 0 20px 0; color: #4b5563;">Activity Overview (Nov 2025)</h4>
                <?php
                    $w = 800; $h = 250; $pad = 30;
                    $points = []; $max = 100;
                    $step = ($w - 2*$pad) / (count($chartData) - 1);
                    
                    foreach($chartData as $i => $d) {
                        $x = $pad + ($i * $step);
                        $y = $h - $pad - (($d['val']/$max)*($h - 2*$pad));
                        $points[] = ['x'=>$x, 'y'=>$y, 'lbl'=>$d['label']];
                    }
                    // Build path
                    $path = "M {$points[0]['x']} {$points[0]['y']}";
                    foreach($points as $p) $path .= " L {$p['x']} {$p['y']}";
                    $area = $path . " L {$points[count($points)-1]['x']} " . ($h-$pad) . " L {$points[0]['x']} " . ($h-$pad) . " Z";
                ?>
                <svg width="100%" height="250" viewBox="0 0 <?php echo $w; ?> <?php echo $h; ?>">
                    <path d="<?php echo $area; ?>" fill="rgba(45, 106, 79, 0.1)" />
                    <path d="<?php echo $path; ?>" fill="none" stroke="#2D6A4F" stroke-width="3" />
                    <?php foreach($points as $p): ?>
                        <circle cx="<?php echo $p['x']; ?>" cy="<?php echo $p['y']; ?>" r="5" fill="#2D6A4F" stroke="white" stroke-width="2"/>
                        <text x="<?php echo $p['x']; ?>" y="<?php echo $h-10; ?>" text-anchor="middle" fill="#6b7280" font-size="12"><?php echo $p['lbl']; ?></text>
                    <?php endforeach; ?>
                </svg>
            </div>
        </div>
    </div>
</body>
</html>