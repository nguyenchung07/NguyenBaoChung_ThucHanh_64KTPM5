<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài tập trắc nghiệm</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Bài tập trắc nghiệm</h1>
    <form action="submit.php" method="post">
        <?php
        require 'includes/db.php';
        
        $stmt = $pdo->query("select * from questions");
        $questions = $stmt->fetchAll();
        $number = 0;

        foreach ($questions as $question) {
            $number++;
            // Tạo giao diện câu hỏi
            echo "<div class='card mb-4'>";
            echo "<div class='card-header'><strong>Câu $number: {$question['question']}</strong></div>";
            echo "<div class='card-body'>";  
            
            // Các tùy chọn A, B, C, D
            $options = ['option_a', 'option_b', 'option_c', 'option_d'];
            foreach ($options as $option) {
                $answer = substr($question[$option], 0, 1); // Lấy ký tự đầu làm giá trị đáp án (A, B, C, D)
                echo "<div class='form-check'>";
                echo "<input class='form-check-input' type='radio' name='question{$question['id']}' value='{$answer}' id='question{$question['id']}{$answer}'>";
                echo "<label class='form-check-label' for='question{$question['id']}{$answer}'>{$question[$option]}</label>";
                echo "</div>";
            }
            
            echo "</div></div>";
        }
        ?>
        <button type="submit" class="btn btn-primary">Nộp bài</button>
    </form>
</div>
</body>
</html>