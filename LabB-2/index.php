<?php
// Запуск сессии (должен быть до любого вывода)
session_start();

// Инициализация истории, если первая загрузка
if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];      // массив для истории
    $_SESSION['iteration'] = 0;     // счётчик загрузок
}
$_SESSION['iteration']++; // увеличиваем счётчик при каждом заходе

// ------------------------------------------------------------
// Функция проверки, является ли строка числом
// ------------------------------------------------------------
function isnum($x)
{
    // если это уже число (int или float), возвращаем true
    if (is_int($x) || is_float($x)) {
        return true;
    }
    
    // если не строка, преобразуем в строку
    if (!is_string($x)) {
        $x = (string)$x;
    }
    
    if ($x === '') return false; // пустая строка – не число
    
    // Число может быть "0" или "0.5" — это нормально
    if ($x[0] == '.') return false; // не начинается с точки
    if ($x[strlen($x) - 1] == '.') return false; // не заканчивается точкой

    $point_count = false;
    for ($i = 0; $i < strlen($x); $i++) {
        $ch = $x[$i];
        // допустимые символы: цифры и точка
        if (!($ch >= '0' && $ch <= '9') && $ch != '.') {
            return false;
        }
        if ($ch == '.') {
            if ($point_count) return false; // вторая точка
            $point_count = true;
        }
    }
    return true;
}

// ------------------------------------------------------------
// Функция вычисления выражения (правильный порядок операций)
// ------------------------------------------------------------
function calculate($val)
{
    // Удаляем пробелы
    $val = str_replace(' ', '', $val);
    
    if ($val === '') return 'Выражение не задано!';
    if (isnum($val)) return $val; // если просто число

    // ========================================================
    // 1. СНАЧАЛА УМНОЖЕНИЕ И ДЕЛЕНИЕ (высший приоритет)
    // ========================================================
    
    // Обработка умножения (*)
    $args = explode('*', $val);
    if (count($args) > 1) {
        $prod = 1;
        foreach ($args as $arg) {
            $res = calculate($arg);
            if (!isnum($res)) return $res;
            $prod *= $res;
        }
        return $prod;
    }

    // Обработка деления (/ и :)
    $args = preg_split('/(\/|:)/', $val);
    if (count($args) > 1) {
        $div = calculate($args[0]);
        if (!isnum($div)) return $div;
        for ($i = 1; $i < count($args); $i++) {
            $arg = calculate($args[$i]);
            if (!isnum($arg)) return $arg;
            if ($arg == 0) return 'Деление на ноль!';
            $div /= $arg;
        }
        return $div;
    }

    // ========================================================
    // 2. ПОТОМ СЛОЖЕНИЕ И ВЫЧИТАНИЕ (низший приоритет)
    // ========================================================
    
    // Обработка сложения (+)
    $args = explode('+', $val);
    if (count($args) > 1) {
        $sum = 0;
        foreach ($args as $arg) {
            $res = calculate($arg);
            if (!isnum($res)) return $res;
            $sum += $res;
        }
        return $sum;
    }

    // Обработка вычитания (-)
    $args = explode('-', $val);
    if (count($args) > 1) {
        $diff = calculate($args[0]);
        if (!isnum($diff)) return $diff;
        for ($i = 1; $i < count($args); $i++) {
            $res = calculate($args[$i]);
            if (!isnum($res)) return $res;
            $diff -= $res;
        }
        return $diff;
    }

    return 'Недопустимые символы в выражении';
}

// ------------------------------------------------------------
// Функция проверки правильности расстановки скобок
// ------------------------------------------------------------
function sqValidator($val)
{
    $open = 0;
    for ($i = 0; $i < strlen($val); $i++) {
        if ($val[$i] == '(') {
            $open++;
        } elseif ($val[$i] == ')') {
            $open--;
            if ($open < 0) return false;
        }
    }
    return $open == 0;
}

// ------------------------------------------------------------
// Функция вычисления выражения со скобками
// ------------------------------------------------------------
function calculateSq($val)
{
    // Проверка корректности расстановки скобок
    if (!sqValidator($val)) return 'Неправильная расстановка скобок!';
    
    // Ищем первую открывающуюся скобку
    $start = strpos($val, '(');
    
    // Если скобок нет — вычисляем обычной функцией
    if ($start === false) {
        return calculate($val);
    }
    
    // Ищем соответствующую закрывающуюся скобку
    $end = $start + 1;
    $open = 1;
    while ($open > 0 && $end < strlen($val)) {
        if ($val[$end] == '(') $open++;
        if ($val[$end] == ')') $open--;
        $end++;
    }
    
    // Формируем новое выражение
    $left = substr($val, 0, $start);                                    // часть левее скобок
    $middle = calculateSq(substr($val, $start + 1, $end - $start - 2)); // выражение в скобках
    $right = substr($val, $end);                                        // часть правее скобок
    
    // Проверка результата вычисления в скобках
    if (!isnum($middle)) return $middle;
    
    // Рекурсивно вычисляем новое выражение
    return calculateSq($left . $middle . $right);
}

// ------------------------------------------------------------
// Обработка формы
// ------------------------------------------------------------
$res = null;
$expression = '';

if (isset($_POST['val']) && $_POST['val'] !== '') {
    $expression = trim($_POST['val']);
    
    // Проверка: это не повторная отправка (обновление страницы)
    if (isset($_POST['iteration']) && $_POST['iteration'] + 1 == $_SESSION['iteration']) {
        $res = calculateSq($expression);
        
        // Сохраняем в историю
        $_SESSION['history'][] = $expression . ' = ' . $res;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Калькулятор | Ильина А.А. | ЛР В-2</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="logo.png" alt="Логотип университета" class="logo">
            <span class="header-title">Ильина А.А. | Группа 241-352 | ЛР В-2</span>
        </div>
    </header>

    <div class="container">
        <div class="content-card">
            <h1>Арифметический калькулятор</h1>
            <p>Поддерживаются операции: <strong>+</strong>, <strong>-</strong>, <strong>*</strong>, <strong>/</strong>, <strong>:</strong> и круглые скобки <strong>( )</strong></p>

            <!-- РЕЗУЛЬТАТ ВЫВОДИТСЯ ПЕРЕД ФОРМОЙ -->
            <?php if ($res !== null): ?>
                <div class="result-box <?php echo isnum($res) ? '' : 'error'; ?>">
                    <strong>Результат:</strong><br>
                    <?php echo htmlspecialchars($expression); ?> = 
                    <?php echo htmlspecialchars($res); ?>
                </div>
            <?php endif; ?>

            <!-- ФОРМА ДЛЯ ВВОДА ВЫРАЖЕНИЯ -->
            <form method="post" class="calculator-form">
                <div class="form-group">
                    <label for="val">Введите выражение:</label>
                    <input type="text" name="val" id="val" class="expression-input" 
                           placeholder="Пример: 2+3*(4-1)/2" value="<?php echo htmlspecialchars($expression); ?>" required>
                </div>
                <input type="hidden" name="iteration" value="<?php echo $_SESSION['iteration']; ?>">
                <button type="submit" class="btn btn-primary">Вычислить</button>
            </form>

            <!-- ИСТОРИЯ ВЫЧИСЛЕНИЙ В ПОДВАЛЕ -->
            <h2>История вычислений</h2>
            <div class="history-box">
                <?php if (empty($_SESSION['history'])): ?>
                    <p class="history-empty">История пуста. Выполните хотя бы одно вычисление.</p>
                <?php else: ?>
                    <?php foreach ($_SESSION['history'] as $record): ?>
                        <div class="history-item"><?php echo htmlspecialchars($record); ?></div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-info">
                © Ильина А.А., 241-352 | Арифметический калькулятор
            </div>
        </div>
    </footer>
</body>
</html>