<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Ильина А.А. | Группа 241-352 | ЛР А-6</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="logo.png" alt="Логотип университета" class="logo">
            <span class="header-title">Ильина А.А. | Группа 241-352 | ЛР А-6</span>
        </div>
    </header>
    
    <div class="container">
        <?php
        // Устанавливаем часовой пояс Москвы
        date_default_timezone_set('Europe/Moscow');
        
        // Функция для получения случайного числа (от 1 до 100, целое или вещественное)
        function getRandomValue() {
            if (mt_rand(0, 1)) {
                return mt_rand(1, 100);        // целое число
            } else {
                return mt_rand(100, 10000) / 100; // вещественное число
            }
        }
        
        // Функция для генерации трех чисел, образующих треугольник
        function getRandomTriangleSides() {
            do {
                $a = getRandomValue();
                $b = getRandomValue();
                $c = getRandomValue();
                // Условие существования треугольника: сумма любых двух сторон больше третьей
            } while (!($a + $b > $c && $a + $c > $b && $b + $c > $a));
            
            return [$a, $b, $c];
        }
        
        // Функция для решения задачи (все задачи используют A, B, C)
        function solveTask($task, $a, $b, $c) {
            switch ($task) {
                case 'triangle_area':
                    // Площадь треугольника по формуле Герона
                    $p = ($a + $b + $c) / 2;
                    $area = sqrt($p * ($p - $a) * ($p - $b) * ($p - $c));
                    return round($area, 2);
                    
                case 'triangle_perimeter':
                    // Периметр треугольника
                    return round($a + $b + $c, 2);
                    
                case 'parallelepiped_volume':
                    // Объем параллелепипеда
                    return round($a * $b * $c, 2);
                    
                case 'arithmetic_mean':
                    // Среднее арифметическое
                    return round(($a + $b + $c) / 3, 2);
                    
                case 'sum_of_squares':
                    // Сумма квадратов трех чисел
                    return round(pow($a, 2) + pow($b, 2) + pow($c, 2), 2);
                    
                case 'product_of_sum':
                    // Произведение суммы двух чисел на третье
                    return round(($a + $b) * $c, 2);
                    
                default:
                    return null;
            }
        }
        
        // Функция для получения названия задачи
        function getTaskName($task) {
            switch ($task) {
                case 'triangle_area': return 'Площадь треугольника';
                case 'triangle_perimeter': return 'Периметр треугольника';
                case 'parallelepiped_volume': return 'Объем параллелепипеда';
                case 'arithmetic_mean': return 'Среднее арифметическое';
                case 'sum_of_squares': return 'Сумма квадратов (A²+B²+C²)';
                case 'product_of_sum': return 'Произведение суммы (A+B)×C';
                default: return 'Неизвестная задача';
            }
        }
        
        // Получаем параметры из GET для повторного заполнения формы
        $default_fio = isset($_GET['FIO']) ? htmlspecialchars($_GET['FIO']) : '';
        $default_group = isset($_GET['GROUP']) ? htmlspecialchars($_GET['GROUP']) : '';
        
        // Проверяем, были ли переданы данные из формы
        if (isset($_POST['A'])) {
            // Получаем данные из формы
            $fio = htmlspecialchars($_POST['FIO']);
            $group = htmlspecialchars($_POST['GROUP']);
            $a = floatval($_POST['A']);
            $b = floatval($_POST['B']);
            $c = floatval($_POST['C']);
            $user_answer = isset($_POST['user_answer']) ? trim($_POST['user_answer']) : '';
            $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
            $about = htmlspecialchars($_POST['about']);
            $task = $_POST['task'];
            $send_mail = isset($_POST['send_mail']);
            $view_mode = $_POST['view_mode']; // browser или print
            
            // ВАЛИДАЦИЯ: если флажок отмечен, email обязателен
            if ($send_mail && empty($email)) {
                echo '<div class="result-container result-error">';
                echo '<b style="color: red;">ОШИБКА!</b><br><br>';
                echo 'Для отправки результата по e-mail необходимо указать адрес электронной почты.<br><br>';
                echo '<a href="javascript:history.back()" class="back-button">Вернуться к форме</a>';
                echo '</div>';
                exit;
            }
            
            // Решаем задачу
            $correct_result = solveTask($task, $a, $b, $c);
            
            // Проверяем ответ пользователя
            $user_answer_clean = str_replace(',', '.', $user_answer);
            $is_correct = false;
            $user_result = null;
            
            if ($user_answer_clean === '') {
                $answer_status = 'Задача самостоятельно решена не была';
            } else {
                $user_result = floatval($user_answer_clean);
                $is_correct = (abs($correct_result - $user_result) < 0.01);
                $answer_status = $is_correct ? 'ВЕРНО' : 'НЕВЕРНО';
            }
            
            // Формируем отчет
            $out_text = '';
            $out_text .= 'ФИО: ' . $fio . '<br>';
            $out_text .= 'Группа: ' . $group . '<br>';
            if ($send_mail && !empty($email)) {
                $out_text .= 'E-mail: ' . $email . '<br>';
            }
            if (!empty($about)) {
                $out_text .= '<br>О себе: ' . $about . '<br><br>';
            }
            $out_text .= '----------------------------------------<br>';
            $out_text .= 'Входные данные:<br>';
            $out_text .= 'A = ' . $a . '<br>';
            $out_text .= 'B = ' . $b . '<br>';
            $out_text .= 'C = ' . $c . '<br>';
            $out_text .= '----------------------------------------<br>';
            $out_text .= 'Решаемая задача: ' . getTaskName($task) . '<br>';
            $out_text .= 'Правильный ответ: ' . $correct_result . '<br>';
            $out_text .= 'Ваш ответ: ';
            
            if ($user_answer_clean === '') {
                $out_text .= 'не указан<br>';
                $out_text .= '<br><b>СТАТУС: ЗАДАЧА САМОСТОЯТЕЛЬНО РЕШЕНА НЕ БЫЛА</b><br>';
            } else {
                $out_text .= $user_result . '<br>';
                if ($is_correct) {
                    $out_text .= '<br><b style="color: green;">ТЕСТ ПРОЙДЕН!</b><br>';
                } else {
                    $out_text .= '<br><b style="color: red;">ОШИБКА: ТЕСТ НЕ ПРОЙДЕН!</b><br>';
                }
            }
            
            $out_text .= '----------------------------------------<br>';
            $out_text .= 'Дата и время: ' . date("d.m.Y H:i:s") . ' (МСК)<br>';
            
            // Отправка письма, если установлен флажок (email уже проверен)
            if ($send_mail && !empty($email)) {
                $plain_text = str_replace('<br>', "\r\n", strip_tags($out_text));
                $plain_text = str_replace('----------------------------------------', '----------------------------------------', $plain_text);
                
                $subject = '=?UTF-8?B?' . base64_encode('Результаты математического тестирования') . '?=';
                $headers = "From: auto@test.ru\r\n";
                $headers .= "Content-Type: text/plain; charset=utf-8\r\n";
                
                if (mail($email, $subject, $plain_text, $headers)) {
                    $out_text .= '<br><span style="color: green;">✓ Результаты теста были отправлены на e-mail: ' . $email . '</span><br>';
                } else {
                    $out_text .= '<br><span style="color: red;">✗ Ошибка при отправке письма на e-mail: ' . $email . '</span><br>';
                }
            }
            
            // Вывод в зависимости от режима просмотра
            if ($view_mode == 'print') {
                echo '<div class="print-version">';
            }
            
            echo '<div class="result-container ' . ($is_correct ? 'result-success' : 'result-error') . '">';
            echo $out_text;
            echo '</div>';
            
            // Кнопка "Повторить тест" (только для режима просмотра в браузере)
            if ($view_mode == 'browser') {
                $repeat_link = '?FIO=' . urlencode($fio) . '&GROUP=' . urlencode($group);
                echo '<a href="' . $repeat_link . '" class="back-button">Повторить тест</a>';
            }
            
            if ($view_mode == 'print') {
                echo '</div>';
                echo '<script>window.print();</script>';
            }
            
        } else {
            // Вывод формы (при первой загрузке или после нажатия "Повторить")
            // Генерируем три числа, образующие треугольник
            list($rand_a, $rand_b, $rand_c) = getRandomTriangleSides();
        ?>
        
        <form method="post" action="" class="test-form" id="testForm">
            <div class="form-row">
                <div class="form-group">
                    <label>ФИО:</label>
                    <input type="text" name="FIO" value="<?php echo $default_fio; ?>" required>
                </div>
                <div class="form-group">
                    <label>Номер группы:</label>
                    <input type="text" name="GROUP" value="<?php echo $default_group; ?>" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Значение А:</label>
                    <input type="text" name="A" value="<?php echo $rand_a; ?>" required>
                </div>
                <div class="form-group">
                    <label>Значение В:</label>
                    <input type="text" name="B" value="<?php echo $rand_b; ?>" required>
                </div>
                <div class="form-group">
                    <label>Значение С:</label>
                    <input type="text" name="C" value="<?php echo $rand_c; ?>" required>
                </div>
            </div>
            
            <div class="form-group">
                <label>Выберите задачу:</label>
                <select name="task" required>
                    <option value="triangle_area">Площадь треугольника</option>
                    <option value="triangle_perimeter">Периметр треугольника</option>
                    <option value="parallelepiped_volume">Объем параллелепипеда</option>
                    <option value="arithmetic_mean">Среднее арифметическое</option>
                    <option value="sum_of_squares">Сумма квадратов (A²+B²+C²)</option>
                    <option value="product_of_sum">Произведение суммы (A+B)×C</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Ваш ответ:</label>
                <input type="text" name="user_answer" placeholder="Введите ваш ответ">
            </div>
            
            <!-- ФЛАЖОК (изначально не отмечен) -->
            <div class="form-group checkbox-group">
                <input type="checkbox" name="send_mail" id="send_mail" onclick="toggleEmailField()">
                <label for="send_mail">Отправить результат теста по e-mail</label>
            </div>
            
            <!-- ПОЛЕ E-MAIL (изначально скрыто) -->
            <div class="form-group" id="email_field" style="display: none;">
                <label>Ваш e-mail:</label>
                <input type="email" name="email" id="email_input">
            </div>
            
            <div class="form-group">
                <label>Немного о себе:</label>
                <textarea name="about" placeholder="Расскажите немного о себе..."></textarea>
            </div>
            
            <div class="form-group">
                <label>Версия для:</label>
                <select name="view_mode" required>
                    <option value="browser">просмотра в браузере</option>
                    <option value="print">печати</option>
                </select>
            </div>
            
            <button type="submit" class="submit-btn">Проверить</button>
        </form>
        
        <script>
        function toggleEmailField() {
            let checkbox = document.getElementById('send_mail');
            let emailField = document.getElementById('email_field');
            let emailInput = document.getElementById('email_input');
            
            if (checkbox.checked) {
                emailField.style.display = 'block';
                emailInput.required = true;  // делаем поле обязательным
            } else {
                emailField.style.display = 'none';
                emailInput.required = false; // снимаем обязательность
                emailInput.value = '';       // очищаем значение
            }
        }
        
        // Дополнительная валидация перед отправкой формы
        document.getElementById('testForm').addEventListener('submit', function(e) {
            let checkbox = document.getElementById('send_mail');
            let emailInput = document.getElementById('email_input');
            
            if (checkbox.checked && !emailInput.value.trim()) {
                alert('Если вы хотите отправить результат по e-mail, пожалуйста, укажите адрес электронной почты.');
                e.preventDefault();
                return false;
            }
        });
        </script>
        
        <?php } ?>
    </div>
    
    <footer>
        <div class="footer-content">
            <div class="footer-info">
                © Ильина А.А., 241-352 | <?php echo date("d.m.Y H:i:s"); ?> (МСК)
            </div>
        </div>
    </footer>
</body>
</html>