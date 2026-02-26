<?php
// Начало
if (!isset($_GET['store'])) { // если НЕ передано предыдущее значение
    $_GET['store'] = ''; // создаем пустое хранилище
} else { // иначе
    if (isset($_GET['key'])) { // если кнопка была нажата
        if ($_GET['key'] == 'reset') { // если нажата кнопка СБРОС
            $_GET['store'] = ''; // очистить хранилище
        } else { // если нажата другая кнопка
            $_GET['store'] .= $_GET['key']; // сохранить цифру в хранилище
        }
    }
}

// Подсчет общего числа нажатий
if (!isset($_GET['click_count'])) {
    $_GET['click_count'] = 0;
}
if (isset($_GET['key'])) {
    $_GET['click_count']++;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Ильина А.А. | Группа 241-352 | ЛР А-3</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="logo.png" alt="Логотип университета" class="logo">
            <span class="header-title">Ильина А.А. | Группа 241-352 | ЛР А-3</span>
        </div>
    </header>
    
    <main>
        <h1>Лабораторная работа №3</h1>
        <h2>Использование GET‐параметров в ссылках. Виртуальная клавиатура.</h2>
        
        <div class="calculator">
            <!-- Окно просмотра результата -->
            <div class="result"><?php echo htmlspecialchars($_GET['store']); ?></div>
            
            <div class="buttons">
                <!-- Кнопки с цифрами 1-9 (генерируются циклом) -->
                <?php for ($i = 1; $i <= 9; $i++): ?>
                    <a href="?key=<?php echo $i; ?>&store=<?php echo urlencode($_GET['store']); ?>&click_count=<?php echo $_GET['click_count']; ?>" class="btn btn-number"><?php echo $i; ?></a>
                <?php endfor; ?>
                
                <!-- Кнопка 0 (отдельно, занимает всю ширину) -->
                <a href="?key=0&store=<?php echo urlencode($_GET['store']); ?>&click_count=<?php echo $_GET['click_count']; ?>" class="btn btn-number zero-btn">0</a>
                
                <!-- Кнопка сброса -->
                <a href="?key=reset&click_count=<?php echo $_GET['click_count']; ?>" class="btn btn-reset">СБРОС</a>
            </div>
        </div>
    </main>
    
    <footer>
        <div class="footer-content">
            <span>Всего нажатий: <?php echo $_GET['click_count']; ?></span>
            <span>© Ильина А.А., 241-352</span>
        </div>
    </footer>
</body>
</html>