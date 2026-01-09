<?php
// volunteer/layout/sidebar.php

$current_page = basename($_SERVER['PHP_SELF']);
$active_tab = ''; // We will determine which tab should be green

// 1. DETERMINE ACTIVE TAB BASED ON PAGE & CONTEXT
if ($current_page == 'dashboard.php') {
    $active_tab = 'dashboard';

} elseif ($current_page == 'pickups.php' || $current_page == 'pickup_detail.php' || $current_page == 'complete_pickup.php') {
    $active_tab = 'pickups';

} elseif ($current_page == 'distribution.php' || $current_page == 'complete_delivery.php') {
    $active_tab = 'distribution';

} elseif ($current_page == 'notes.php') {
    // If on notes page, check if it's for distribution
    if (isset($_GET['context']) && $_GET['context'] == 'distribution') {
        $active_tab = 'distribution';
    } else {
        // Default to dashboard or its own tab if you had one
        $active_tab = 'dashboard'; 
    }

} elseif ($current_page == 'history.php') {
    $active_tab = 'history';

} elseif ($current_page == 'reports.php') {
    $active_tab = 'reports';
}
?>

<style>
    /* SIDEBAR STYLES */
    :root {
        --primary-green: #2D6A4F;
        --sidebar-width: 260px;
        --text-color: #4b5563;
        --bg-color: #f3f4f6;
    }

    .sidebar {
        width: var(--sidebar-width);
        background: #ffffff;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        border-right: 1px solid #e5e7eb;
        display: flex;
        flex-direction: column;
        padding: 25px;
        z-index: 1000;
        font-family: system-ui, -apple-system, sans-serif;
        box-sizing: border-box; 
    }

    .brand {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 40px;
        text-decoration: none;
        flex-shrink: 0; 
    }

    .nav-menu {
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex-grow: 1; 
        overflow-y: auto; 
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 16px;
        text-decoration: none;
        color: var(--text-color);
        font-weight: 500;
        border-radius: 8px;
        transition: 0.2s;
        flex-shrink: 0; 
    }

    .nav-item:hover {
        background-color: #f3f4f6;
        color: var(--primary-green);
    }

    /* Active State Style */
    .nav-item.active {
        background-color: var(--primary-green);
        color: white;
    }

    .logout-wrapper {
        margin-top: auto; 
        padding-top: 20px;
        flex-shrink: 0;
    }

    .logout-btn {
        color: #ef4444;
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px 16px;
        text-decoration: none;
        font-weight: 500;
        border-radius: 8px;
        transition: 0.2s;
    }
    
    .logout-btn:hover {
        background-color: #fef2f2;
        color: #dc2626;
    }
</style>

<aside class="sidebar">
    <a href="dashboard.php" class="brand">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
        Volunteer Portal
    </a>

    <nav class="nav-menu">
        <a href="dashboard.php" class="nav-item <?php echo ($active_tab == 'dashboard') ? 'active' : ''; ?>">
            <span>🏠</span> Dashboard
        </a>
        
        <a href="pickups.php" class="nav-item <?php echo ($active_tab == 'pickups') ? 'active' : ''; ?>">
            <span>📅</span> Pickups
        </a>
        
        <a href="distribution.php" class="nav-item <?php echo ($active_tab == 'distribution') ? 'active' : ''; ?>">
            <span>🚚</span> Distribution
        </a>

        <a href="history.php" class="nav-item <?php echo ($active_tab == 'history') ? 'active' : ''; ?>">
            <span>⏱️</span> History
        </a>

        <a href="reports.php" class="nav-item <?php echo ($active_tab == 'reports') ? 'active' : ''; ?>">
            <span>📂</span> Reports
        </a>
    </nav>

    <div class="logout-wrapper">
        <a href="logout.php" class="logout-btn">
            <span>🚪</span> Log Out
        </a>
    </div>
</aside>