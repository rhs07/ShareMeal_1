<?php
// volunteer/complete_delivery.php

// 1. GET ID & DATA
$id = $_GET['id'] ?? 101;

// Mock Data for the current main delivery context
$delivery_data = [
    101 => ['code' => 'D-1028', 'recipient' => 'Gulshan Community Center staff'],
    102 => ['code' => 'D-1029', 'recipient' => 'Banani Orphanage Admin'],
    103 => ['code' => 'D-1030', 'recipient' => 'Wedding Coordinator'],
    104 => ['code' => 'D-1031', 'recipient' => 'Dhanmondi Club Manager']
];
$data = $delivery_data[$id] ?? $delivery_data[101];

// 2. MOCK AVAILABLE PICKUPS (Items the volunteer currently has)
$available_pickups = [
    'D-1028' => '5 Boxes-Assorted Pastries',
    'D-1029' => '10 kg Fresh Vegetables',
    'D-1045' => '20L Mineral Water (Extra)',
    'D-1046' => '50 Packets Biscuits'
];

// 3. HANDLE FINAL SAVE
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // In a real app, process $_POST['selected_pickups'] here
    // foreach ($_POST['selected_pickups'] as $pickup_code) { ...mark as delivered... }
    
    header("Location: dashboard.php"); 
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Complete Delivery</title>
    <style>
        /* --- RESET & VARS --- */
        :root {
            --primary: #2D6A4F;
            --primary-hover: #1B4332;
            --text-dark: #1f2937;
            --text-gray: #6b7280;
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
            filter: blur(8px) brightness(0.9); 
            z-index: -1;
        }

        /* --- MODAL --- */
        .modal-card {
            background: white;
            width: 90%;
            max-width: 500px;
            border-radius: 16px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            position: relative;
            z-index: 10;
            display: flex;
            flex-direction: column;
            max-height: 90vh; /* Ensure it fits on mobile */
            overflow-y: auto;
        }

        .modal-header { padding: 20px 25px; display: flex; justify-content: space-between; align-items: center; }
        .modal-title { font-size: 1.3rem; font-weight: 700; color: #374151; }
        .close-btn { background: none; border: none; font-size: 1.5rem; color: #9ca3af; cursor: pointer; text-decoration: none; }
        
        .modal-body { padding: 0 25px 25px 25px; }
        .section-title { color: #6b7280; font-size: 1rem; margin-bottom: 15px; }

        /* Checkboxes */
        .checkbox-row { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; cursor: pointer; }
        input[type="checkbox"] { width: 20px; height: 20px; accent-color: var(--primary); cursor: pointer; }
        .checkbox-text { color: #4b5563; font-size: 0.95rem; }

        /* Form Inputs */
        .label-bold { display: block; font-weight: 700; color: #4b5563; margin-top: 15px; margin-bottom: 8px; font-size: 0.95rem; }
        
        .form-input { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #e5e7eb; 
            border-radius: 8px; 
            font-size: 0.95rem; 
            font-family: inherit;
        }
        .form-input:focus { outline: none; border-color: var(--primary); }
        
        /* Select Styling */
        select[multiple] {
            height: 100px;
            background-color: #f9fafb;
        }
        option { padding: 8px; border-bottom: 1px solid #f3f4f6; }
        option:checked { background-color: #dcfce7; color: #166534; font-weight: 600; }

        /* --- SIGNATURE BOX STYLES --- */
        .signature-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 8px;
        }
        .sig-label { font-weight: 700; color: #4b5563; font-size: 0.95rem; }
        .sig-clear { 
            color: #6b7280; font-size: 0.85rem; cursor: pointer; 
            display: flex; align-items: center; gap: 4px; border: none; background: none; 
            padding: 5px;
        }
        .sig-clear:hover { color: #dc2626; }
        
        .signature-wrapper {
            position: relative;
            background-color: #e5e7eb;
            height: 120px;
            border-radius: 12px;
            overflow: hidden;
        }

        #sig-canvas {
            position: absolute;
            top: 0; left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            cursor: crosshair;
        }

        .sig-bg-layer {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            z-index: 1;
            pointer-events: none;
        }
        .sig-x {
            position: absolute;
            left: 15px;
            bottom: 30px;
            font-size: 1.2rem;
            color: #9ca3af;
            font-family: sans-serif;
        }
        .sig-line {
            position: absolute;
            left: 35px;
            right: 15px;
            bottom: 35px;
            border-bottom: 2px dotted #9ca3af;
        }

        /* --- FOOTER --- */
        .modal-footer { padding: 20px 25px; display: flex; justify-content: center; }
        .btn-save { 
            background-color: var(--primary); 
            color: white; 
            padding: 10px 40px; 
            border-radius: 8px; 
            font-weight: 600; 
            font-size: 1rem; 
            cursor: pointer; 
            border: none;
            width: auto;
        }
        .btn-save:hover { background-color: var(--primary-hover); }

    </style>
</head>
<body>

    <form class="modal-card" method="POST">
        <div class="modal-header">
            <div class="modal-title">Complete Delivery</div>
            <a href="dashboard.php" class="close-btn">&times;</a>
        </div>

        <div class="modal-body">
            
            <label class="label-bold">Select Items to Deliver</label>
            <select name="selected_pickups[]" multiple class="form-input">
                <?php foreach($available_pickups as $p_code => $p_name): ?>
                    <option value="<?php echo $p_code; ?>" <?php echo ($p_code == $data['code']) ? 'selected' : ''; ?>>
                        #<?php echo $p_code; ?> - <?php echo $p_name; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div style="font-size: 0.8rem; color: #9ca3af; margin-top: 5px; margin-bottom: 15px;">
                Tip: Hold Ctrl (Windows) or Cmd (Mac) to select multiple items.
            </div>

            <div class="section-title">Confirm Handover</div>

            <label class="checkbox-row">
                <input type="checkbox" name="handed_check" checked>
                <span class="checkbox-text">Handed to <?php echo $data['recipient']; ?></span>
            </label>

            <label class="checkbox-row">
                <input type="checkbox" name="verified_check">
                <span class="checkbox-text">Items verified by recipient</span>
            </label>

            <label class="label-bold">Food Condition Notes</label>
            <textarea name="notes" class="form-input" style="height: 80px; resize: none;" placeholder="e.g., Packages intact, looks fresh."></textarea>

            <div class="signature-header">
                <span class="sig-label">Recipient Confirmation Signature</span>
                <button type="button" class="sig-clear" id="clearBtn">🚫 Clear</button>
            </div>
            
            <div class="signature-wrapper">
                <canvas id="sig-canvas"></canvas>
                <div class="sig-bg-layer">
                    <span class="sig-x">X</span>
                    <div class="sig-line"></div>
                </div>
            </div>
            
            <input type="hidden" name="signature_data" id="sig-data">
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn-save">Save</button>
        </div>
    </form>

    <script>
        const canvas = document.getElementById('sig-canvas');
        const ctx = canvas.getContext('2d');
        const clearBtn = document.getElementById('clearBtn');
        const wrapper = document.querySelector('.signature-wrapper');

        // 1. Set Canvas Size
        function resizeCanvas() {
            const rect = wrapper.getBoundingClientRect();
            canvas.width = rect.width;
            canvas.height = rect.height;
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.strokeStyle = '#000000';
        }
        window.onload = resizeCanvas;
        window.onresize = resizeCanvas;

        // 2. Drawing State
        let isDrawing = false;
        let lastX = 0;
        let lastY = 0;

        function draw(e) {
            if (!isDrawing) return;
            const rect = canvas.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            ctx.lineTo(x, y);
            ctx.stroke();
            [lastX, lastY] = [x, y];
        }

        // 3. Mouse Events
        canvas.addEventListener('mousedown', (e) => {
            isDrawing = true;
            const rect = canvas.getBoundingClientRect();
            [lastX, lastY] = [e.clientX - rect.left, e.clientY - rect.top];
        });
        canvas.addEventListener('mousemove', draw);
        canvas.addEventListener('mouseup', () => isDrawing = false);
        canvas.addEventListener('mouseout', () => isDrawing = false);

        // 4. Touch Events (Mobile)
        function getTouchPos(canvasDom, touchEvent) {
            var rect = canvasDom.getBoundingClientRect();
            return {
                x: touchEvent.touches[0].clientX - rect.left,
                y: touchEvent.touches[0].clientY - rect.top
            };
        }
        canvas.addEventListener("touchstart", function (e) {
            e.preventDefault();
            var pos = getTouchPos(canvas, e);
            var touch = e.touches[0];
            var mouseEvent = new MouseEvent("mousedown", {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(mouseEvent);
        }, false);
        canvas.addEventListener("touchmove", function (e) {
            e.preventDefault();
            var touch = e.touches[0];
            var mouseEvent = new MouseEvent("mousemove", {
                clientX: touch.clientX,
                clientY: touch.clientY
            });
            canvas.dispatchEvent(mouseEvent);
        }, false);
        canvas.addEventListener("touchend", function (e) {
            var mouseEvent = new MouseEvent("mouseup", {});
            canvas.dispatchEvent(mouseEvent);
        }, false);

        // 5. Clear
        clearBtn.addEventListener('click', () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        });
    </script>

</body>
</html>