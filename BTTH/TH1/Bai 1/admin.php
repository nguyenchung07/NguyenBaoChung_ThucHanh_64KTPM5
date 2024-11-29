<?php
// Kết nối với cơ sở dữ liệu
require 'includes/db.php';

// Lấy danh sách các loài hoa từ cơ sở dữ liệu
$stmt = $conn->prepare("SELECT * FROM flowers");
$stmt->execute();
$flowers = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Loài Hoa</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .action-btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin: 2px;
        }
        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            font-size: 14px;
            color: #777;
        }
        .add-btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .add-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Quản Lý Loài Hoa</h1>

        <!-- Nút thêm hoa -->
        <a href="creat.php"><button class="add-btn">Thêm Loài Hoa</button></a>

        <!-- Bảng danh sách các loài hoa -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Hoa</th>
                    <th>Mô Tả</th>
                    <th>Ảnh</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $search = $_GET['search'];
                    $stmt = $conn->prepare("SELECT * FROM flowers WHERE name LIKE ?");
                    $stmt->execute(['%' . $search . '%']);
                    $flowers = $stmt->fetchAll(PDO::FETCH_ASSOC);
                }

                // Hiển thị danh sách hoa
                foreach ($flowers as $flower) {
                    echo "<tr>
                        <td>{$flower['id']}</td>
                        <td>{$flower['name']}</td>
                        <td>{$flower['description']}</td>
                        <td><img src='{$flower['image_path']}' alt='{$flower['name']}' width='100px'></td>
                        <td>
                            <a href='edit.php?id={$flower['id']}'><button class='action-btn edit-btn'>Sửa</button></a>
                            <a href='delete.php?id={$flower['id']}'><button class='action-btn delete-btn'>Xóa</button></a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>© 2024 Tạo bởi Bạn. All rights reserved.</p>
    </div>

</body>
</html>
