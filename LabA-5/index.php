<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Ильина А.А. | Группа 241-352 | ЛР А-5</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="logo.png" alt="Логотип университета" class="logo">
            <span class="header-title">Ильина А.А. | Группа 241-352 | ЛР А-5</span>
        </div>
        
        <!-- ГЛАВНОЕ МЕНЮ (горизонтальное) -->
        <nav class="main-menu">
            <?php
            // Получаем параметры из URL
            $html_type = isset($_GET['html_type']) ? $_GET['html_type'] : null;
            $content = isset($_GET['content']) ? $_GET['content'] : null;
            
            // Устанавливаем часовой пояс Москвы
            date_default_timezone_set('Europe/Moscow');
            
            // Функция для формирования ссылки с сохранением параметров
            function buildLink($baseHtmlType, $currentHtmlType, $currentContent) {
                $params = [];
                
                // Добавляем html_type
                $params[] = 'html_type=' . $baseHtmlType;
                
                // Сохраняем content, если он есть
                if ($currentContent !== null) {
                    $params[] = 'content=' . $currentContent;
                }
                
                return '?' . implode('&', $params);
            }
            
            // Ссылка на табличную верстку
            $tableLink = buildLink('TABLE', $html_type, $content);
            // По умолчанию (при первой загрузке) ни один пункт не выделен
            $tableClass = (isset($_GET['html_type']) && $_GET['html_type'] == 'TABLE') ? 'class="selected"' : '';
            echo "<a href=\"$tableLink\" $tableClass>Табличная верстка</a>";
            
            // Ссылка на блочную верстку
            $divLink = buildLink('DIV', $html_type, $content);
            $divClass = (isset($_GET['html_type']) && $_GET['html_type'] == 'DIV') ? 'class="selected"' : '';
            echo "<a href=\"$divLink\" $divClass>Блочная верстка</a>";
            ?>
        </nav>
    </header>
    
    <div class="container">
        <!-- ОСНОВНОЕ МЕНЮ (вертикальное слева) -->
        <aside class="side-menu">
            <?php
            // Ссылка "Всё" (без параметра content) - выделена по умолчанию
            $allLink = '?html_type=' . ($html_type ?: 'TABLE');
            $allClass = !isset($_GET['content']) ? 'class="selected"' : '';
            echo "<a href=\"$allLink\" $allClass>Всё</a>";
            
            // Ссылки на цифры от 2 до 9
            for ($i = 2; $i <= 9; $i++) {
                // Сохраняем текущий тип верстки
                $numLink = '?html_type=' . ($html_type ?: 'TABLE') . '&content=' . $i;
                $numClass = (isset($_GET['content']) && $_GET['content'] == $i) ? 'class="selected"' : '';
                echo "<a href=\"$numLink\" $numClass>$i</a>";
            }
            ?>
        </aside>
        
        <!-- ОСНОВНОЙ КОНТЕНТ - ТАБЛИЦА УМНОЖЕНИЯ -->
        <main class="content">
            <h1>Таблица умножения</h1>
            
            <?php
            /**
             * Функция преобразует число в ссылку (для всех цифр от 2 до 9)
             */
            function outNumAsLink($num) {
                // Сохраняем текущий тип верстки из глобальной области
                global $html_type;
                
                // Все цифры (и только цифры) должны быть ссылками на соответствующие таблицы умножения
                // Ссылки всегда сбрасывают тип верстки - параметр html_type не указывается
                if ($num >= 2 && $num <= 9) {
                    // Ссылка на таблицу умножения этого числа (сбрасываем html_type)
                    return "<a href=\"?content=$num\">$num</a>";
                } else {
                    // Для чисел >9 просто возвращаем число без ссылки
                    return $num;
                }
            }
            
            /**
             * Функция выводит одну строку таблицы умножения
             */
            function outRow($n) {
                for ($i = 2; $i <= 9; $i++) {
                    $result = $i * $n;
                    
                    // Формируем строку с ссылками на все цифры (множители и результат, если он от 2 до 9)
                    echo outNumAsLink($n) . ' x ' . outNumAsLink($i) . ' = ' . outNumAsLink($result) . '<br>';
                }
            }
            
            // Вывод таблицы умножения в зависимости от параметров
            // Для обеспечения одинакового внешнего вида используем одинаковую структуру
            echo '<div class="multiplication-container ' . ($html_type == 'DIV' ? 'block-layout' : 'table-layout') . '">';
            
            if (!isset($_GET['content'])) {
                // Вся таблица (8 колонок)
                for ($col = 2; $col <= 9; $col++) {
                    echo '<div class="multiplication-column">';
                    echo "<div class=\"column-header\">Таблица умножения на $col</div>";
                    echo '<div class="column-content">';
                    outRow($col);
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                // Одна колонка (на выбранную цифру)
                $colNum = (int)$_GET['content'];
                echo '<div class="multiplication-column single-column">';
                echo "<div class=\"column-header\">Таблица умножения на $colNum</div>";
                echo '<div class="column-content">';
                outRow($colNum);
                echo '</div>';
                echo '</div>';
            }
            
            echo '</div>';
            ?>
        </main>
    </div>
    
    <!-- ПОДВАЛ С ИНФОРМАЦИЕЙ -->
    <footer>
        <div class="footer-content">
            <div class="footer-info">
                <?php
                // Определяем тип верстки
                if (!isset($_GET['html_type']) || $_GET['html_type'] == 'TABLE') {
                    echo 'Тип верстки: Табличная';
                } else {
                    echo 'Тип верстки: Блочная';
                }
                
                // Определяем содержание таблицы
                if (!isset($_GET['content'])) {
                    echo ' | Таблица умножения: полная';
                } else {
                    echo ' | Таблица умножения: на ' . $_GET['content'];
                }
                
                // Дата и время по Москве (UTC+3)
                echo ' | ' . date("d.m.Y H:i:s") . ' (МСК)';
                ?>
            </div>
            <span>© Ильина А.А., 241-352</span>
        </div>
    </footer>
</body>
</html>