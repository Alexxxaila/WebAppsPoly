<?php
// ЛР2, Вариант 10
$title = "Ильина А.А. | Группа 241-352 | ЛР A-2 | Вариант 10";

// Тип верстки
$layout_type = 'E'; // A, B, C, D, E
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="logo.png" alt="Логотип университета" class="logo">
            <span class="header-title"><?php echo $title; ?></span>
        </div>
    </header>
    <main>
        <h1>Табулирование функции (вариант 10)</h1>
        
        <!-- КРАСИВЫЙ ВЫВОД ФУНКЦИИ -->
        <div class="function-definition">
            <h2>Исследуемая функция</h2>
            <div class="function-formula">
                <div class="formula-branch">При x ≤ 10: <span class="formula">f(x) = 3/x + x/3 - 5</span></div>
                <div class="formula-branch">При 10 < x < 20: <span class="formula">f(x) = (x - 7) · (x / 8)</span></div>
                <div class="formula-branch">При x ≥ 20: <span class="formula">f(x) = 3x + 2</span></div>
            </div>
        </div>
        
        <h2>Результаты вычислений</h2>
        
        <?php
        // ----------------------------------------------
        // 1. ИНИЦИАЛИЗАЦИЯ ПЕРЕМЕННЫХ
        // ----------------------------------------------
        $x_start = -10;          // начальное значение аргумента
        $x_end = 40;              // конечное значение аргумента
        $step = 1;                // шаг изменения аргумента

        // ВЫЧИСЛЯЕМ КОЛИЧЕСТВО ШАГОВ АВТОМАТИЧЕСКИ
        $steps = (int)(($x_end - $x_start) / $step) + 1;

        // Ограничения по значению функции (остановка)
        $min_limit = -100;
        $max_limit = 1000;

        // Для статистики
        $sum = 0;
        $count = 0;
        $min_value = null;
        $max_value = null;
        $error_count = 0;

        // ----------------------------------------------
        // 2. ФУНКЦИЯ ВАРИАНТА 10
        // ----------------------------------------------
        function f($x) {
            if ($x <= 10) {
                // ПРОВЕРКА ДЕЛЕНИЯ НА НОЛЬ в первой функции
                if ($x == 0) {
                    return 'error'; // деление на ноль при x = 0
                }
                // f(x) = 3/x + x/3 - 5
                return (3 / $x) + ($x / 3) - 5;
                
            } elseif ($x < 20) {
                // f(x) = (x - 7) * (x / 8)
                return ($x - 7) * ($x / 8);
                
            } else { // x >= 20
                // f(x) = 3x + 2
                return 3 * $x + 2;
            }
        }

        // ----------------------------------------------
        // 3. ПРОВЕРКА КОРРЕКТНОСТИ ТИПА ВЁРСТКИ
        // ----------------------------------------------
        $allowed_types = ['A', 'B', 'C', 'D', 'E'];
        if (!in_array($layout_type, $allowed_types)) {
            $layout_type = 'A';
        }

        // ----------------------------------------------
        // 4. НАЧАЛО ВЫВОДА
        // ----------------------------------------------
        echo '<div class="results-block">';
        // Заголовок для типа D (таблица)
        if ($layout_type == 'D') {
            echo '<table class="function-table">';
            echo '<tr><th>№</th><th>x</th><th>f(x)</th></tr>';
        }

        // Открывающие теги для списков
        if ($layout_type == 'B') echo '<ul class="function-list">';
        if ($layout_type == 'C') echo '<ol class="function-list">';

        $x = $x_start;
        for ($i = 0; $i < $steps; $i++, $x += $step) {
            // Вычисляем значение
            $raw = f($x);
            
            // Проверка на ошибку
            if ($raw === 'error' || is_nan($raw) || is_infinite($raw)) {
                $val = 'error';
                $error_count++;
            } else {
                // ОКРУГЛЕНИЕ ДО 3-х ЗНАКОВ
                $val = round($raw, 3);
                
                // Накопление статистики
                $sum += $val;
                $count++;
                if ($min_value === null || $val < $min_value) $min_value = $val;
                if ($max_value === null || $val > $max_value) $max_value = $val;
            }

            // Форматируем x
            if (floor($x) == $x) {
                $x_formatted = number_format($x, 0);
            } else {
                $x_formatted = number_format($x, 2);
            }

            // ------------------------------------------
            // ВЫВОД В ЗАВИСИМОСТИ ОТ ТИПА ВЁРСТКИ
            // ------------------------------------------
            switch ($layout_type) {
                case 'A':
                    if ($val === 'error') {
                        echo "<div class='result-line error-line'>f($x_formatted) = <span class='error-text'>ОШИБКА (деление на 0)</span></div>";
                    } else {
                        echo "<div class='result-line'>f($x_formatted) = <strong>$val</strong></div>";
                    }
                    break;
                    
                case 'B':
                case 'C':
                    if ($val === 'error') {
                        echo "<li class='error-item'><span class='result-item'>f($x_formatted) = <span class='error-text'>error</span></span></li>";
                    } else {
                        echo "<li><span class='result-item'>f($x_formatted) = <strong>$val</strong></span></li>";
                    }
                    break;
                    
                case 'D':
                    $row_num = $i + 1;
                    if (floor($x) == $x) {
                        $x_display = number_format($x, 0);
                    } else {
                        $x_display = number_format($x, 2);
                    }
                    
                    if ($val === 'error') {
                        echo "<tr><td>$row_num</td><td>$x_display</td><td><span class='error-text'>error</span></td></tr>";
                    } else {
                        echo "<tr><td>$row_num</td><td>$x_display</td><td><strong>$val</strong></td></tr>";
                    }
                    break;
                    
                case 'E':
                    echo '<div class="function-block">';
                    echo "<span class='block-arg'>f($x_formatted)</span>";
                    echo "<span class='block-equals'>=</span>";
                    if ($val === 'error') {
                        echo "<span class='block-value error-text'>error</span>";
                    } else {
                        echo "<span class='block-value'>$val</span>";
                    }
                    echo '</div>';
                    break;
            }

            // Проверка на выход за пределы
            if (is_numeric($val) && ($val >= $max_limit || $val <= $min_limit)) {
                echo '<p class="limit-stop">❗ Остановка: f(x) вышла за пределы ['
                     . $min_limit . '; ' . $max_limit . ']</p>';
                break;
            }
        }

        // Закрывающие теги
        if ($layout_type == 'D') echo '</table>';
        if ($layout_type == 'B') echo '</ul>';
        if ($layout_type == 'C') echo '</ol>';

        echo '</div>';

        // ----------------------------------------------
        // 5. СТАТИСТИКА
        // ----------------------------------------------
        echo '<div class="statistics">';
        echo '<h3>Статистика</h3>';
        echo '<div class="stats-grid">';
        
        if ($count > 0) {
            $avg = round($sum / $count, 3);
            echo "<div class='stat-item'><span class='stat-label'>Сумма:</span> <strong>$sum</strong></div>";
            echo "<div class='stat-item'><span class='stat-label'>Минимум:</span> <strong>$min_value</strong></div>";
            echo "<div class='stat-item'><span class='stat-label'>Максимум:</span> <strong>$max_value</strong></div>";
            echo "<div class='stat-item'><span class='stat-label'>Среднее:</span> <strong>$avg</strong></div>";
        }
        
        echo '</div>';
        echo '</div>';

        // ----------------------------------------------
        // 6. НАЗВАНИЕ ТИПА ВЁРСТКИ
        // ----------------------------------------------
        $type_names = [
            'A' => 'Простой текст',
            'B' => 'Маркированный список',
            'C' => 'Нумерованный список',
            'D' => 'Таблица',
            'E' => 'Блочная верстка'
        ];
        $footer_layout_info = "Тип верстки: " . $type_names[$layout_type] . " (" . $layout_type . ")";
        ?>
    </main>
    <footer>
        <div class="footer-content">
            <span><?php echo $footer_layout_info; ?></span>
            <span>© Ильина А.А., 241-352</span>
        </div>
    </footer>
</body>
</html>