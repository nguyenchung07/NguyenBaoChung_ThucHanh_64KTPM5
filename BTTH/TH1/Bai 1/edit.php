<?php
require 'includes/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM flowers WHERE id = ?");
$stmt->execute([$id]);
$flower = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    
    // Giữ lại đường dẫn ảnh cũ mặc định
    $imagePath = $flower['image_path'];  
    
    if (!empty($_FILES['image']['name'])) {
        // Tải lên ảnh mới
        $uniqueName = time() . "_" . basename($_FILES['image']['name']);
        $target_file = "images/" . $uniqueName;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $imagePath = $target_file; // Cập nhật đường dẫn ảnh mới
        } else {
            echo "Lỗi khi tải ảnh lên!";
        }
    }
    
    // Cập nhật thông tin vào cơ sở dữ liệu
    $stmt = $conn->prepare("UPDATE flowers SET name = ?, description = ?, image_path = ? WHERE id = ?");
    $stmt->execute([$name, $description, $imagePath, $id]);
    
    // Chuyển hướng về trang admin
    header("Location: admin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Loài Hoa</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
        label {
            font-size: 16px;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"], textarea, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        textarea {
            resize: vertical;
            height: 120px;
        }
        button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            margin-right: 10px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
            display: inline-block;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            transition: background-color 0.3s;
            text-decoration: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }

        img {
            display: block;
            margin-bottom: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Sửa Loài Hoa</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="name">Tên Hoa:</label>
        <input type="text" name="name" id="name" value="<?= htmlspecialchars($flower['name']); ?>" required>

        <label for="description">Mô Tả:</label>
        <textarea name="description" id="description" required><?= htmlspecialchars($flower['description']); ?></textarea>

        <label for="image">Ảnh hiện tại:</label><br>
        <img src="<?php echo $flower['image_path']; ?>" width="200"><br><br>

        <label for="image">Chọn Ảnh Mới:</label>
        <input type="file" name="image" id="image" accept="image/*">

        <button type="submit">Lưu Thay Đổi</button>
        <a href="admin.php" class="btn btn-secondary">Hủy</a>
    </form>
</div>

<div class="footer">
    <p>© 2024 Tạo bởi Bạn. All rights reserved.</p>
</div>

</body>
</html>
