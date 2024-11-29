<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'includes/db.php'; 

    $stmt = $pdo->query("select id, answer from questions"); // truy vấn lấy ra id và đáp án từ cơ sở dữ liệu
    $answers = $stmt->fetchAll(PDO::FETCH_KEY_PAIR); // mảng $answers là 1 mảng chứa id và đáp án đúng của câu hỏi có id đó

    $score = 0;
    // duyệt các câu trả lời của người dùng
    foreach ($_POST as $key => $userAnswer) {
        $questionId = (int)filter_var($key, FILTER_SANITIZE_NUMBER_INT); // Lấy ID câu hỏi
        if (isset($answers[$questionId]) && $answers[$questionId] === $userAnswer) {
            // kiểm tra câu hỏi có trong cơ sở dữ liệu hay không (trong mảng $answers)
            // và so sánh đáp án đúng trong cơ sở dữ liệu và đáp án của người dùng 
            // nếu đúng tăng $score thêm 1 (điểm số của người dùng)
            $score++;
        }
    }

    $total = count($answers); // đếm tổng số lượng câu hỏi
    echo "<!DOCTYPE html>
    <html lang='vi'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Kết quả Trắc Nghiệm</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f9;
            }
            .container {
                max-width: 800px;
                margin: 0 auto;
                padding-top: 50px;
            }
            .alert {
                font-size: 18px;
                font-weight: bold;
            }
            .btn-primary {
                background-color: #007bff;
                border-color: #007bff;
            }
            .btn-primary:hover {
                background-color: #0056b3;
                border-color: #0056b3;
            }
            .footer {
                text-align: center;
                margin-top: 50px;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h1 class='text-center mb-4'>Kết quả Bài Trắc Nghiệm</h1>";
    echo "<div class='alert alert-success text-center'>";
    echo "Bạn trả lời đúng <strong>$score</strong>/$total câu."; // in ra số câu trả lời đúng / tổng số câu hỏi
    echo "</div>";

    // Kết quả hiển thị tùy theo điểm số
    // So sánh số đáp án đúng so với tổng số câu hỏi
    if ($score == $total) {
        echo "<div class='alert alert-success text-center'>Chúc mừng, bạn đã hoàn thành bài kiểm tra với số điểm tối đa!</div>";
    } elseif ($score >= $total / 2) {
        echo "<div class='alert alert-warning text-center'>Bạn đã làm khá tốt, nhưng vẫn có thể cải thiện!</div>";
    } else {
        echo "<div class='alert alert-danger text-center'>Cần cải thiện thêm, đừng bỏ cuộc!</div>";
    }

    echo "<a href='index.php' class='btn btn-primary'>Làm lại</a>";

    echo "<div class='footer'>
            <p>© 2024 Trắc nghiệm online. Chúc bạn học tốt!</p>
          </div>
        </div>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
    </body>
    </html>";
}
?>