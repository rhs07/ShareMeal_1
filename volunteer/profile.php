<?php
// volunteer/profile.php

// 1. MOCK USER DATA
// In a real app, fetch this from database using $_SESSION['user_id']
$user = [
    'name'      => 'Riajul Hasan Shakib',
    'email'     => 'Shakib.volunteer@example.com',
    'phone'     => '+880 1924 181120 ',
    'address'   => '12/A, Dhanmondi, Dhaka',
    'joined'    => 'Nov 1, 2024',
    'role'      => 'Senior Volunteer',
    'deliveries'=> 145,
    'rating'    => 4.9
];

// 2. HANDLE FORM SUBMISSION
$success_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Logic to update database would go here
    // $name = $_POST['name']; ... 
    
    $success_msg = "Profile updated successfully!";
    
    // Update mock data to reflect changes immediately in the UI
    if(isset($_POST['name'])) $user['name'] = $_POST['name'];
    if(isset($_POST['phone'])) $user['phone'] = $_POST['phone'];
    if(isset($_POST['address'])) $user['address'] = $_POST['address'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <style>
        /* --- RESET & VARIABLES --- */
        :root {
            --primary: #2D6A4F;
            --primary-hover: #1B4332;
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
        .icon-btn { font-size: 1.2rem; color: var(--text-gray); text-decoration: none; }
        .icon-btn:hover { color: var(--primary); }

        /* --- CONTENT --- */
        .container { padding: 30px; max-width: 1100px; margin: 0 auto; width: 100%; }

        .page-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 25px;
        }

        /* --- SUCCESS ALERT --- */
        .alert-success {
            background-color: #d1fae5;
            color: #065f46;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #a7f3d0;
        }

        /* --- GRID LAYOUT --- */
        .profile-grid {
            display: grid;
            grid-template-columns: 300px 1fr; /* Left sidebar fixed, right flexible */
            gap: 25px;
        }

        /* --- CARDS --- */
        .card {
            background: var(--white);
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            padding: 25px;
        }

        /* LEFT CARD: USER INFO */
        .profile-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-bottom: 20px;
        }
        .avatar-circle {
            width: 100px;
            height: 100px;
            background-color: #e5e7eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #9ca3af;
            margin-bottom: 15px;
            border: 4px solid #f9fafb;
        }
        .user-name { font-size: 1.25rem; font-weight: 700; color: var(--text-dark); margin-bottom: 5px; }
        .user-role { font-size: 0.9rem; color: var(--primary); font-weight: 600; background: #d1fae5; padding: 4px 12px; border-radius: 15px; }

        .info-list { margin-top: 20px; border-top: 1px solid var(--border); padding-top: 20px; text-align: left; width: 100%; }
        .info-item { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 0.9rem; }
        .info-label { color: var(--text-gray); }
        .info-val { font-weight: 600; color: var(--text-dark); }

        /* RIGHT CARD: EDIT FORM */
        .section-header {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 10px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-group { margin-bottom: 20px; }
        .form-group.full-width { grid-column: span 2; }
        
        .label { display: block; font-size: 0.9rem; color: #4b5563; margin-bottom: 8px; font-weight: 500; }
        
        .input-field {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 0.95rem;
            color: var(--text-dark);
        }
        .input-field:focus { outline: none; border-color: var(--primary); }
        .input-field[readonly] { background-color: #f9fafb; cursor: not-allowed; }

        /* BUTTONS */
        .btn-save {
            background-color: var(--primary);
            color: white;
            padding: 10px 24px;
            border-radius: 6px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            font-size: 0.95rem;
        }
        .btn-save:hover { background-color: var(--primary-hover); }

    </style>
</head>
<body>

    <?php include 'layout/sidebar.php'; ?>

    <main class="main-content">
        <header class="header">
            <div class="header-icons">
                <a href="chat.php" class="icon-btn">✉️</a>
                <a href="notifications.php" class="icon-btn">🔔</a>
                <a href="#" class="icon-btn" style="color: var(--primary);">👤</a>
            </div>
        </header>

        <div class="container">
            <div class="page-title">My Profile</div>

            <?php if($success_msg): ?>
                <div class="alert-success"><?php echo $success_msg; ?></div>
            <?php endif; ?>

            <div class="profile-grid">
                
                <div class="card">
                    <div class="profile-header">
                        <div class="avatar-circle">
                            <?php echo substr($user['name'], 0, 1); ?>
                        </div>
                        <div class="user-name"><?php echo $user['name']; ?></div>
                        <span class="user-role"><?php echo $user['role']; ?></span>
                    </div>

                    <div class="info-list">
                        <div class="info-item">
                            <span class="info-label">Joined</span>
                            <span class="info-val"><?php echo $user['joined']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Total Deliveries</span>
                            <span class="info-val"><?php echo $user['deliveries']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Rating</span>
                            <span class="info-val">⭐ <?php echo $user['rating']; ?>/5.0</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="section-header">Personal Information</div>
                    
                    <form method="POST">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="label">Full Name</label>
                                <input type="text" name="name" class="input-field" value="<?php echo $user['name']; ?>">
                            </div>

                            <div class="form-group">
                                <label class="label">Email Address</label>
                                <input type="email" class="input-field" value="<?php echo $user['email']; ?>" readonly title="Contact admin to change email">
                            </div>

                            <div class="form-group">
                                <label class="label">Phone Number</label>
                                <input type="text" name="phone" class="input-field" value="<?php echo $user['phone']; ?>">
                            </div>

                            <div class="form-group">
                                <label class="label">Location</label>
                                <input type="text" name="address" class="input-field" value="<?php echo $user['address']; ?>">
                            </div>
                        </div>

                        <div class="section-header" style="margin-top: 20px;">Security</div>
                        
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="label">Current Password</label>
                                <input type="password" class="input-field" placeholder="••••••••">
                            </div>
                            <div class="form-group">
                                <label class="label">New Password</label>
                                <input type="password" class="input-field" placeholder="Leave blank to keep current">
                            </div>
                        </div>

                        <div style="margin-top: 20px; text-align: right;">
                            <button type="submit" class="btn-save">Save Changes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </main>

</body>
</html>