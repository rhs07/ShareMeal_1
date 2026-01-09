<?php
// volunteer/chat.php

// 1. GET ACTIVE USER ID (Default to 1)
$active_id = $_GET['id'] ?? 1;

// 2. MOCK CONTACTS DATA
$contacts = [
    1 => [
        'id' => 1, 'name' => 'Gulshan Community Center', 'role' => 'NGO',
        'last_msg' => 'Great, see you then!', 'time' => '10:30 AM', 'unread' => 0, 'status' => 'online'
    ],
    2 => [
        'id' => 2, 'name' => 'Dhanmondi Orphanage', 'role' => 'NGO',
        'last_msg' => 'Can you pick up earlier?', 'time' => 'Yesterday', 'unread' => 2, 'status' => 'offline'
    ],
    3 => [
        'id' => 3, 'name' => 'John (Volunteer)', 'role' => 'Volunteer',
        'last_msg' => 'Meeting at 3 PM', 'time' => 'Yesterday', 'unread' => 0, 'status' => 'online'
    ],
    4 => [
        'id' => 4, 'name' => 'Support Admin', 'role' => 'Admin',
        'last_msg' => 'Your account is verified.', 'time' => 'Mon', 'unread' => 0, 'status' => 'offline'
    ]
];

// 3. MOCK MESSAGES FOR ACTIVE USER
$messages = [
    ['sender' => 'them', 'text' => 'Hello! Are you available for the pickup today?', 'time' => '10:00 AM'],
    ['sender' => 'me',   'text' => 'Yes, I am on my way. ETA 20 mins.', 'time' => '10:05 AM'],
    ['sender' => 'them', 'text' => 'Perfect. The donor is ready.', 'time' => '10:06 AM'],
    ['sender' => 'me',   'text' => 'Great, see you then!', 'time' => '10:30 AM'],
];

// Handle Message Send (Simulation)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Add new message to array (visual only for demo)
    $new_msg = trim($_POST['message']);
    if ($new_msg) {
        $messages[] = ['sender' => 'me', 'text' => $new_msg, 'time' => date('h:i A')];
    }
}

$current_contact = $contacts[$active_id];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <style>
        /* --- VARIABLES --- */
        :root {
            --primary: #2D6A4F;
            --primary-light: #40916C;
            --bg-gray: #f3f4f6;
            --white: #ffffff;
            --text-dark: #1f2937;
            --text-gray: #6b7280;
            --border: #e5e7eb;
            --sidebar-w: 260px;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; }
        body { background: var(--bg-gray); height: 100vh; overflow: hidden; }

        /* --- LAYOUT --- */
        .main-wrapper {
            display: flex;
            height: 100vh;
        }

        /* Adjusting for your existing sidebar include */
        .content-area {
            flex: 1;
            margin-left: var(--sidebar-w);
            display: flex;
            background: white;
            height: 100%;
        }

        /* --- LEFT SIDE: CONTACT LIST --- */
        .chat-sidebar {
            width: 350px;
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            background: #fff;
        }

        .chat-sidebar-header {
            padding: 20px;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-title { font-size: 1.2rem; font-weight: 700; color: var(--text-dark); }
        .user-status { font-size: 0.9rem; color: var(--text-gray); }

        .contact-list {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
        }

        .contact-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-radius: 12px;
            cursor: pointer;
            margin-bottom: 8px;
            transition: 0.2s;
            text-decoration: none;
            color: inherit;
        }

        .contact-item:hover { background-color: #f9fafb; }
        
        /* Active State (Green) */
        .contact-item.active {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 6px rgba(45, 106, 79, 0.2);
        }
        
        /* Adjust text colors inside active item */
        .contact-item.active .contact-name { color: white; }
        .contact-item.active .contact-msg { color: rgba(255,255,255,0.8); }
        .contact-item.active .contact-time { color: rgba(255,255,255,0.8); }

        .avatar {
            width: 45px;
            height: 45px;
            background-color: #e5e7eb;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #4b5563;
            margin-right: 15px;
            position: relative;
            flex-shrink: 0;
        }
        
        /* Online Dot */
        .status-dot {
            position: absolute;
            bottom: 2px; right: 2px;
            width: 10px; height: 10px;
            background: #10b981;
            border: 2px solid white;
            border-radius: 50%;
        }

        .contact-info { flex: 1; min-width: 0; }
        .contact-top { display: flex; justify-content: space-between; margin-bottom: 4px; }
        .contact-name { font-weight: 600; font-size: 0.95rem; color: var(--text-dark); }
        .contact-time { font-size: 0.75rem; color: var(--text-gray); }
        
        .contact-bottom { display: flex; justify-content: space-between; align-items: center; }
        .contact-msg { font-size: 0.85rem; color: var(--text-gray); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px; }
        
        .unread-badge {
            background-color: #ef4444; /* Red badge for alerts */
            color: white;
            font-size: 0.7rem;
            padding: 2px 6px;
            border-radius: 10px;
            font-weight: bold;
        }
        /* Make badge white if active */
        .contact-item.active .unread-badge { background-color: white; color: var(--primary); }


        /* --- RIGHT SIDE: CHAT WINDOW --- */
        .chat-window {
            flex: 1;
            display: flex;
            flex-direction: column;
            background-color: white;
        }

        .chat-header {
            height: 70px;
            padding: 0 25px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .chat-user-details { display: flex; align-items: center; gap: 12px; }
        .chat-user-name { font-weight: 700; color: var(--text-dark); }
        .chat-user-status { font-size: 0.8rem; color: #10b981; display: flex; align-items: center; gap: 5px; }

        /* Messages Area */
        .messages-area {
            flex: 1;
            padding: 25px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 15px;
            background-color: #f9fafb; /* Light background for chat area */
        }

        .message {
            max-width: 70%;
            padding: 12px 16px;
            border-radius: 12px;
            font-size: 0.95rem;
            line-height: 1.5;
            position: relative;
        }

        /* Incoming Message (Gray) */
        .msg-them {
            background-color: #e5e7eb;
            color: var(--text-dark);
            align-self: flex-start;
            border-bottom-left-radius: 2px;
        }

        /* Outgoing Message (Green) */
        .msg-me {
            background-color: var(--primary);
            color: white;
            align-self: flex-end;
            border-bottom-right-radius: 2px;
        }

        .msg-time {
            font-size: 0.7rem;
            margin-top: 5px;
            display: block;
            text-align: right;
            opacity: 0.7;
        }

        /* Input Area */
        .chat-input-area {
            padding: 20px;
            background: white;
            border-top: 1px solid var(--border);
        }

        .input-wrapper {
            background-color: #f3f4f6;
            border-radius: 30px;
            padding: 8px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .attach-btn {
            background: none; border: none; font-size: 1.2rem; cursor: pointer; color: #6b7280; padding: 5px;
        }
        .attach-btn:hover { color: var(--text-dark); }

        .msg-input {
            flex: 1;
            border: none;
            background: transparent;
            padding: 10px;
            font-size: 0.95rem;
        }
        .msg-input:focus { outline: none; }

        .send-btn {
            background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--primary); padding: 5px;
        }
        .send-btn:hover { transform: scale(1.1); transition: 0.2s; }

    </style>
</head>
<body>

    <?php include 'layout/sidebar.php'; ?>

    <div class="content-area">
        
        <div class="chat-sidebar">
            <div class="chat-sidebar-header">
                <div class="header-title">Messages</div>
                <div class="user-status">You</div>
            </div>

            <div class="contact-list">
                <?php foreach ($contacts as $contact): ?>
                    <?php $isActive = ($contact['id'] == $active_id); ?>
                    
                    <a href="?id=<?php echo $contact['id']; ?>" class="contact-item <?php echo $isActive ? 'active' : ''; ?>">
                        <div class="avatar">
                            <?php echo substr($contact['name'], 0, 1); ?>
                            <?php if($contact['status'] == 'online'): ?>
                                <span class="status-dot"></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="contact-info">
                            <div class="contact-top">
                                <span class="contact-name"><?php echo $contact['name']; ?></span>
                                <span class="contact-time"><?php echo $contact['time']; ?></span>
                            </div>
                            <div class="contact-bottom">
                                <span class="contact-msg"><?php echo $contact['last_msg']; ?></span>
                                <?php if($contact['unread'] > 0): ?>
                                    <span class="unread-badge"><?php echo $contact['unread']; ?> NEW</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="chat-window">
            
            <div class="chat-header">
                <div class="chat-user-details">
                    <div class="avatar" style="width: 40px; height: 40px; color: white; background: var(--primary);">
                        <?php echo substr($current_contact['name'], 0, 1); ?>
                    </div>
                    <div>
                        <div class="chat-user-name"><?php echo $current_contact['name']; ?></div>
                        <div class="chat-user-status">
                            <?php if($current_contact['status'] == 'online'): ?>
                                <span style="font-size: 8px;">●</span> Active now
                            <?php else: ?>
                                <span style="color: #9ca3af;">Offline</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div style="font-size: 1.2rem; color: #9ca3af; cursor: pointer;">⋮</div>
            </div>

            <div class="messages-area" id="msgArea">
                <div style="text-align: center; font-size: 0.8rem; color: #9ca3af; margin-bottom: 10px;">Today</div>
                
                <?php foreach ($messages as $msg): ?>
                    <div class="message <?php echo ($msg['sender'] == 'me') ? 'msg-me' : 'msg-them'; ?>">
                        <?php echo $msg['text']; ?>
                        <span class="msg-time"><?php echo $msg['time']; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="chat-input-area">
                <form method="POST" class="input-wrapper">
                    <button type="button" class="attach-btn">📷</button>
                    <input type="text" name="message" class="msg-input" placeholder="Type a message..." autocomplete="off">
                    <button type="submit" class="send-btn">➤</button>
                </form>
            </div>

        </div>
    </div>

    <script>
        const msgArea = document.getElementById('msgArea');
        msgArea.scrollTop = msgArea.scrollHeight;
    </script>

</body>
</html>