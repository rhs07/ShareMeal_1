<?php
// volunteer/notes.php

// 1. HANDLE FORM SUBMISSION
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // In a real application, you would handle the file upload here:
    // $note = $_POST['notes'];
    // $file = $_FILES['photo'];
    
    // Simulate success and redirect back to dashboard
    header("Location: complete_pickup.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Notes</title>
    <style>
        /* --- VARIABLES & RESET --- */
        :root {
            --primary: #2D6A4F;
            --primary-hover: #1B4332;
            --text-dark: #1f2937;
            --text-gray: #6b7280;
            --border: #e5e7eb;
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
            /* Using map background to match the theme */
            background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/e/ec/OpenStreetMap_Logo_2011.svg/1024px-OpenStreetMap_Logo_2011.svg.png');
            background-size: cover;
            background-position: center;
            filter: blur(6px); /* Blurs the background */
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
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- HEADER --- */
        .modal-header {
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
            padding: 0 25px 25px 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .label {
            display: block;
            font-size: 0.9rem;
            color: #4b5563; /* Gray text color */
            margin-bottom: 8px;
            font-weight: 500;
        }

        /* Textarea Styling */
        .custom-textarea {
            width: 100%;
            height: 120px;
            padding: 12px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 0.95rem;
            color: var(--text-dark);
            resize: none;
            font-family: inherit;
        }
        .custom-textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(45, 106, 79, 0.1);
        }
        .custom-textarea::placeholder {
            color: #9ca3af;
        }

        /* Upload Box Styling */
        .upload-container {
            border: 2px dashed #d1d5db;
            border-radius: 6px;
            background-color: #f9fafb;
            height: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        .upload-container:hover {
            border-color: var(--primary);
            background-color: #f0fdf4;
        }
        
        /* Hidden Input */
        .file-input {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .upload-icon {
            width: 24px;
            height: 24px;
            margin-bottom: 8px;
            stroke: #6b7280;
        }
        .upload-text {
            font-size: 0.9rem;
            color: #6b7280;
        }

        /* --- BUTTON --- */
        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 10px;
        }
        .btn-submit:hover {
            background-color: var(--primary-hover);
        }

    </style>
</head>
<body>

    <form class="modal-card" method="POST" enctype="multipart/form-data">
        
        <div class="modal-header">
            <h2 class="modal-title">Add Notes</h2>
            <a href="pickup_detail.php" class="close-btn">&times;</a>
        </div>

        <div class="modal-body">
            
            <div class="form-group">
                <label class="label">Food Condition & Notes</label>
                <textarea name="notes" class="custom-textarea" placeholder="e.g., Packages intact, looks fresh. Any issues?"></textarea>
            </div>

            <div class="form-group">
                <label class="label">Upload Photo</label>
                <div class="upload-container">
                    <input type="file" name="photo" class="file-input" accept="image/*">
                    
                    <svg class="upload-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    
                    <span class="upload-text">Drag & Drop or Click to Upload</span>
                </div>
            </div>

            <button type="submit" class="btn-submit">Submit Notes</button>

        </div>
    </form>

    <script>
        const fileInput = document.querySelector('.file-input');
        const uploadText = document.querySelector('.upload-text');

        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                uploadText.textContent = "Selected: " + this.files[0].name;
                uploadText.style.color = "#2D6A4F";
                uploadText.style.fontWeight = "bold";
            }
        });
    </script>

</body>
</html>