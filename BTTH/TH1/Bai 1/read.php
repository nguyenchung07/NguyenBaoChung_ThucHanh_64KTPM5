<?php
require 'includes/db.php';

$stmt = $conn->query("SELECT * FROM flowers");
$flowers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Hoa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
        }
        h1 {
            font-size: 2em;
            margin-bottom: 20px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
            padding: 20px;
        }
        .flower {
            background-color: white;
            margin: 15px;
            padding: 15px;
            width: 280px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }
        .flower img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
        }
        .flower h3 {
            font-size: 1.2em;
            color: #333;
            margin: 10px 0;
        }
        .flower p {
            font-size: 1em;
            color: #666;
            margin-bottom: 15px;
        }
        .flower:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <header>
        <h1>Danh Sách Các Loài Hoa</h1>
    </header>

    <div class="container">
        <?php foreach ($flowers as $flower): ?>
            <div class="flower">
                <h3><?= htmlspecialchars($flower['name']); ?></h3>
                <p><?= htmlspecialchars($flower['description']); ?></p>
                <img src="<?= htmlspecialchars($flower['image_path']); ?>" alt="<?= htmlspecialchars($flower['name']); ?>">
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
