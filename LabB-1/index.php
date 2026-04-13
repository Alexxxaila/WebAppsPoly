<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Записная книжка | Ильина А.А. | ЛР В-1</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="logo.png" alt="Логотип университета" class="logo">
            <span class="header-title">Ильина А.А. | Группа 241-352 | ЛР В-1</span>
        </div>
    </header>

    <div class="container">
        <div class="content-card">
            <?php
            // Подключаем модуль меню
            require 'menu.php';
            
            // Определяем параметр p (по умолчанию 'viewer')
            $page = isset($_GET['p']) ? $_GET['p'] : 'viewer';
            
            // Подключаем соответствующий модуль в зависимости от параметра
            if ($page == 'viewer') {
                // Просмотр записей
                include 'viewer.php';
                $viewer = new Viewer();
                echo $viewer->getContactsList(
                    isset($_GET['sort']) ? $_GET['sort'] : 'byid',
                    isset($_GET['pg']) ? (int)$_GET['pg'] : 0
                );
            } elseif ($page == 'add') {
                // Добавление записи
                include 'add.php';
            } elseif ($page == 'edit') {
                // Редактирование записи
                include 'edit.php';
            } elseif ($page == 'delete') {
                // Удаление записи
                include 'delete.php';
            } else {
                echo '<div class="message-error">Ошибка: неизвестный раздел</div>';
            }
            ?>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-info">
                © Ильина А.А., 241-352 | Записная книжка
            </div>
        </div>
    </footer>
</body>
</html>