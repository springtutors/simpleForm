<?php
$message = '';
$messageType = '';

// Check if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and collect input values
    $name  = trim($_POST['name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (!empty($name) && !empty($phone) && !empty($email)) {
        $dataDir = __DIR__ . '/data';
        $filePath = $dataDir . '/users.txt';

        // Create data directory if it doesn't exist
        if (!is_dir($dataDir)) {
            mkdir($dataDir, 0755, true);
        }

        // Format: name | phone | email | register time
        $registerTime = date('Y-m-d H:i:s');
        $record = "{$name} | {$phone} | {$email} | {$registerTime}" . PHP_EOL;

        // Append record to data/users.txt
        if (file_put_contents($filePath, $record, FILE_APPEND | LOCK_EX) !== false) {
            $message = 'Registration successful!';
            $messageType = 'success';
        } else {
            $message = 'Failed to write data to file.';
            $messageType = 'error';
        }
    } else {
        $message = 'Please fill in all required fields.';
        $messageType = 'error';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration (PHP)</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #218838;
        }
        .alert {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .alert.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .alert.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>

    <h2>Register</h2>

    <?php if (!empty($message)): ?>
        <div class="alert <?= $messageType ?>">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form action="index.php" method="POST">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required placeholder="Enter full name">
        </div>
        
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="tel" id="phone" name="phone" required placeholder="Enter phone number">
        </div>
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required placeholder="Enter email address">
        </div>

        <button type="submit">Submit</button>
    </form>

</body>
</html>