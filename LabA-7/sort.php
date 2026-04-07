<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результат сортировки | Ильина А.А. | ЛР А-7</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="logo.png" alt="Логотип университета" class="logo">
            <span class="header-title">Ильина А.А. | Группа 241-352 | ЛР А-7</span>
        </div>
    </header>

    <div class="container">
        <div class="result-card">
            <?php
            // Функция проверки: является ли аргумент НЕ числом
            function arg_is_not_Num($arg) {
                if($arg === '') return true;
                $arg = trim($arg);
                if(is_numeric($arg)) {
                    return false;
                }
                return true;
            }
            
            // ------------------------------------------------------------
            // 1. СОРТИРОВКА ВЫБОРОМ
            // ------------------------------------------------------------
            function selectionSort(&$arr, &$iterations) {
                $n = count($arr);
                $iterations = 0;
                echo "<h3>Процесс сортировки выбором:</h3>";
                
                for($i = 0; $i < $n - 1; $i++) {
                    $min = $i;
                    for($j = $i + 1; $j < $n; $j++) {
                        if($arr[$j] < $arr[$min]) {
                            $min = $j;
                        }
                    }
                    if($min != $i) {
                        $temp = $arr[$i];
                        $arr[$i] = $arr[$min];
                        $arr[$min] = $temp;
                    }
                    $iterations++;
                    echo "<div class='iteration'>";
                    echo "<span class='iteration-number'>Итерация " . $iterations . ":</span> ";
                    echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
                    if($min == $i) {
                        echo " (минимальный элемент уже на месте)";
                    }
                    echo "</div>";
                }
            }
            
            // ------------------------------------------------------------
            // 2. ПУЗЫРЬКОВАЯ СОРТИРОВКА
            // ------------------------------------------------------------
            function bubbleSort(&$arr, &$iterations) {
                $n = count($arr);
                $iterations = 0;
                echo "<h3>Процесс пузырьковой сортировки:</h3>";
                
                echo "<div class='iteration'>";
                echo "<span class='iteration-number'>Начальное состояние:</span> ";
                echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
                echo "</div>";
                
                for($i = 0; $i < $n - 1; $i++) {
                    $swapped = false;
                    for($j = 0; $j < $n - $i - 1; $j++) {
                        if($arr[$j] > $arr[$j + 1]) {
                            $temp = $arr[$j];
                            $arr[$j] = $arr[$j + 1];
                            $arr[$j + 1] = $temp;
                            $swapped = true;
                        }
                    }
                    $iterations++;
                    echo "<div class='iteration'>";
                    echo "<span class='iteration-number'>Проход " . $iterations . ":</span> ";
                    echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
                    echo "</div>";
                    if(!$swapped) {
                        echo "<div class='iteration'>";
                        echo "<span class='iteration-number'>Досрочное завершение: массив отсортирован</span>";
                        echo "</div>";
                        break;
                    }
                }
            }
            
            // ------------------------------------------------------------
            // 3. СОРТИРОВКА ШЕЛЛА
            // ------------------------------------------------------------
            function shellSort(&$arr, &$iterations) {
                $n = count($arr);
                $iterations = 0;
                echo "<h3>Процесс сортировки Шелла:</h3>";
                
                echo "<div class='iteration'>";
                echo "<span class='iteration-number'>Начальное состояние:</span> ";
                echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
                echo "</div>";
                
                for($gap = floor($n / 2); $gap > 0; $gap = floor($gap / 2)) {
                    echo "<div class='iteration'>";
                    echo "<span class='iteration-number'>Шаг = " . $gap . ":</span>";
                    echo "</div>";
                    
                    for($i = $gap; $i < $n; $i++) {
                        $temp = $arr[$i];
                        $j = $i;
                        while($j >= $gap && $arr[$j - $gap] > $temp) {
                            $arr[$j] = $arr[$j - $gap];
                            $j -= $gap;
                        }
                        $arr[$j] = $temp;
                        $iterations++;
                        echo "<div class='iteration'>";
                        echo "<span class='iteration-number'>Итерация " . $iterations . ":</span> ";
                        echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
                        echo "</div>";
                    }
                }
            }
            
            // ------------------------------------------------------------
            // 4. СОРТИРОВКА САДОВОГО ГНОМА
            // ------------------------------------------------------------
            function gnomeSort(&$arr, &$iterations) {
                $n = count($arr);
                $iterations = 0;
                echo "<h3>Процесс сортировки садового гнома:</h3>";
                
                echo "<div class='iteration'>";
                echo "<span class='iteration-number'>Начальное состояние:</span> ";
                echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
                echo "</div>";
                
                $i = 1;
                while($i < $n) {
                    if($i == 0 || $arr[$i - 1] <= $arr[$i]) {
                        $i++;
                    } else {
                        $temp = $arr[$i];
                        $arr[$i] = $arr[$i - 1];
                        $arr[$i - 1] = $temp;
                        $i--;
                    }
                    $iterations++;
                    echo "<div class='iteration'>";
                    echo "<span class='iteration-number'>Шаг " . $iterations . ":</span> ";
                    echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
                    echo "</div>";
                }
            }
            
            // ------------------------------------------------------------
            // 5. БЫСТРАЯ СОРТИРОВКА
            // ------------------------------------------------------------
            function quickSort(&$arr, $left, $right, &$iterations, &$stepCounter) {
                if($left >= $right) return;
                
                $pivot = $arr[floor(($left + $right) / 2)];
                $l = $left;
                $r = $right;
                $partitionChanged = false;
                
                while($l <= $r) {
                    while($arr[$l] < $pivot) $l++;
                    while($arr[$r] > $pivot) $r--;
                    if($l <= $r) {
                        $temp = $arr[$l];
                        $arr[$l] = $arr[$r];
                        $arr[$r] = $temp;
                        $l++;
                        $r--;
                        $partitionChanged = true;
                    }
                }
                
                if($partitionChanged) {
                    $iterations++;
                    $stepCounter++;
                    echo "<div class='iteration'>";
                    echo "<span class='iteration-number'>Шаг " . $stepCounter . " (разбиение):</span> ";
                    echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
                    echo "</div>";
                }
                
                quickSort($arr, $left, $r, $iterations, $stepCounter);
                quickSort($arr, $l, $right, $iterations, $stepCounter);
            }
            
            function quickSortWrapper(&$arr, &$iterations) {
                $iterations = 0;
                $stepCounter = 0;
                echo "<h3>Процесс быстрой сортировки:</h3>";
                echo "<div class='iteration'>";
                echo "<span class='iteration-number'>Исходное состояние:</span> ";
                echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
                echo "</div>";
                quickSort($arr, 0, count($arr) - 1, $iterations, $stepCounter);
            }
            
            // ------------------------------------------------------------
            // 6. ВСТРОЕННАЯ СОРТИРОВКА (БЕЗ ИТЕРАЦИЙ)
            // ------------------------------------------------------------
            function builtinSort(&$arr, &$iterations) {
                // Количество итераций не определено для встроенной функции
                $iterations = 0;
                echo "<h3>Используется встроенная функция sort():</h3>";
                echo "<div class='iteration'>";
                echo "<span class='iteration-number'>Исходный массив:</span> ";
                echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
                echo "</div>";
                
                // Выполняем сортировку (внутренние шаги не выводятся)
                sort($arr);
                
                echo "<div class='iteration'>";
                echo "<span class='iteration-number'>Отсортированный массив:</span> ";
                echo "<span class='array-state'>[" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]</span>";
                echo "</div>";
            }
            
            // ------------------------------------------------------------
            // ОСНОВНАЯ ЛОГИКА
            // ------------------------------------------------------------
            $algorithmNames = [
                0 => "Сортировка выбором",
                1 => "Пузырьковая сортировка",
                2 => "Алгоритм Шелла",
                3 => "Алгоритм садового гнома",
                4 => "Быстрая сортировка",
                5 => "Встроенная функция PHP (sort)"
            ];
            
            // Проверка наличия данных
            if(!isset($_POST['element0'])) {
                echo "<div class='validation-error'>";
                echo "<strong>Ошибка:</strong> Массив не задан, сортировка невозможна.";
                echo "</div>";
                echo '<a href="index.php" class="back-link">← Вернуться к форме</a>';
                exit();
            }
            
            $arrLength = isset($_POST['arrLength']) ? (int)$_POST['arrLength'] : 0;
            
            if($arrLength == 0) {
                echo "<div class='validation-error'>";
                echo "<strong>Ошибка:</strong> Массив пуст, сортировка невозможна.";
                echo "</div>";
                echo '<a href="index.php" class="back-link">← Вернуться к форме</a>';
                exit();
            }
            
            // Проверка элементов на числа
            $inputArray = [];
            $hasError = false;
            
            for($i = 0; $i < $arrLength; $i++) {
                $fieldName = 'element' . $i;
                if(!isset($_POST[$fieldName])) {
                    echo "<div class='validation-error'>";
                    echo "<strong>Ошибка:</strong> Элемент с индексом $i отсутствует.";
                    echo "</div>";
                    $hasError = true;
                    break;
                }
                $value = trim($_POST[$fieldName]);
                if($value === '' || !is_numeric($value)) {
                    echo "<div class='validation-error'>";
                    echo "<strong>Ошибка:</strong> Элемент массива \"" . htmlspecialchars($value) . "\" (индекс $i) не является числом.";
                    echo "</div>";
                    $hasError = true;
                    break;
                }
                $inputArray[] = (float)$value;
            }
            
            if($hasError) {
                echo '<a href="index.php" class="back-link">← Вернуться к форме</a>';
                exit();
            }
            
            $algorithm = isset($_POST['algorithm']) ? (int)$_POST['algorithm'] : 0;
            
            // Вывод информации об алгоритме
            echo "<div class='algorithm-name'>";
            echo "<h2>" . $algorithmNames[$algorithm] . "</h2>";
            echo "</div>";
            
            // Вывод исходного массива
            echo "<div class='input-data'>";
            echo "<strong>Входные данные:</strong><br>";
            echo "[" . implode(", ", array_map(function($v) { return round($v, 4); }, $inputArray)) . "]";
            echo "</div>";
            
            // Вывод результата валидации
            echo "<div class='validation-success'>";
            echo "Проверка входных данных: все элементы являются числами. Сортировка возможна.";
            echo "</div>";
            
            // Создаем копию массива для сортировки
            $arr = $inputArray;
            
            // Засекаем время
            $timeStart = microtime(true);
            
            // Запуск сортировки
            $iterations = 0;
            
            echo '<div class="iterations-container">';
            
            switch($algorithm) {
                case 0:
                    selectionSort($arr, $iterations);
                    break;
                case 1:
                    bubbleSort($arr, $iterations);
                    break;
                case 2:
                    shellSort($arr, $iterations);
                    break;
                case 3:
                    gnomeSort($arr, $iterations);
                    break;
                case 4:
                    quickSortWrapper($arr, $iterations);
                    break;
                case 5:
                    builtinSort($arr, $iterations);
                    break;
                default:
                    selectionSort($arr, $iterations);
            }
            
            echo '</div>';
            
            // Вычисляем затраченное время
            $timeEnd = microtime(true);
            $timeElapsed = $timeEnd - $timeStart;
            
            // Вывод результатов
            echo "<div class='result'>";
            echo "Сортировка завершена";
            if($algorithm != 5) {
                echo ", проведено <strong>$iterations</strong> итераций.";
            } else {
                echo ". <strong>Количество итераций не определено</strong> (встроенная функция).";
            }
            echo "<br>";
            echo "Сортировка заняла <strong>" . number_format($timeElapsed, 6) . "</strong> секунд.<br>";
            echo "<strong>Отсортированный массив:</strong> [" . implode(", ", array_map(function($v) { return round($v, 4); }, $arr)) . "]";
            echo "</div>";
            
            echo '<a href="index.php" class="back-link">← Вернуться к форме ввода</a>';
            ?>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-info">
                © Ильина А.А., 241-352 | Сортировка завершена
            </div>
        </div>
    </footer>
</body>
</html>