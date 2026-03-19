<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Ильина А.А. | Группа 241-352 | ЛР А-4</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="logo.png" alt="Логотип университета" class="logo">
            <span class="header-title">Ильина А.А. | Группа 241-352 | ЛР А-4</span>
        </div>
    </header>
    
    <main>
        <h1>Лабораторная работа № А-4</h1>
        <h2>Пользовательские функции. Вывод таблиц</h2>
        
        <?php
        /**
         * Функция getTR() - формирует HTML-код одной строки таблицы
         */
        function getTR($data, $requiredCols) {
            $cells = explode('*', $data);
            $ret = '<tr>';
            
            for ($i = 0; $i < $requiredCols; $i++) {
                $ret .= '<td>';
                if ($i < count($cells) && trim($cells[$i]) !== '') {
                    $ret .= htmlspecialchars($cells[$i]);
                } else {
                    $ret .= '&nbsp;';
                }
                $ret .= '</td>';
            }
            
            return $ret . '</tr>';
        }

        /**
         * Функция outTable() - выводит таблицу
         */
        function outTable($structure, $tableNum, $requiredCols) {
            echo "<h2>Таблица №{$tableNum}</h2>";
            
            // ПРИМЕР 1: Ошибка - неправильное число колонок
            if ($requiredCols <= 0) {
                echo '<p class="error-message">❌ Неправильное число колонок</p>';
                return;
            }
            
            $rows = explode('#', $structure);
            
            // ПРИМЕР 2: Ошибка - нет строк
            if (count($rows) == 0 || (count($rows) == 1 && trim($rows[0]) === '')) {
                echo '<p class="error-message">❌ В таблице нет строк</p>';
                return;
            }
            
            $hasCells = false;
            $tableContent = '';
            
            foreach ($rows as $row) {
                $row = trim($row);
                if ($row === '') continue;
                
                $cells = explode('*', $row);
                $nonEmptyCells = array_filter($cells, function($cell) {
                    return trim($cell) !== '';
                });
                
                if (count($nonEmptyCells) > 0) {
                    $hasCells = true;
                    $tableContent .= getTR($row, $requiredCols);
                }
            }
            
            // ПРИМЕР 3: Ошибка - нет ячеек
            if (!$hasCells) {
                echo '<p class="error-message">❌ В таблице нет строк с ячейками</p>';
            } else {
                echo '<table class="data-table">';
                echo $tableContent;
                echo '</table>';
            }
        }

        // ========== ОСНОВНАЯ ПРОГРАММА ==========
        echo "<h2>КОРРЕКТНЫЕ ТАБЛИЦЫ (10 штук)</h2>";
        
        // Корректные таблицы
        $requiredCols = 3;
        echo '<p class="info-message">✓ Количество колонок: <strong>' . $requiredCols . '</strong> </p>';

        $tables = array(
            "ФИО*Возраст*Город#Иванов*25*Москва#Петрова*30*СПб#Сидоров*22*Казань",
            "Товар*Цена*Количество#Хлеб*45*2#Молоко*80*1#Яйца*90*10#Сахар*60*3",
            "Студент*Группа*Оценка#Нина*241-352*5#Иван*241-351*4#Мария*241-352*5",
            "Книга*Автор*Год#Война и мир*Толстой*1869#Идиот*Достоевский*1868",
            "Страна*Столица*Население#Россия*Москва*146млн#Франция*Париж*68млн",
            "Дисциплина*Часы*Преподаватель#PHP*72*Иванов#HTML*36*Петрова",
            "Модель*Процессор*RAM#ThinkPad*i5*8#MacBook*M1*16#ZenBook*R7*16",
            "Фильм*Режиссер*Год#Матрица*Вачовски*1999#Интерстеллар*Нолан*2014",
            "Сотрудник*Должность*Оклад#Петров*инженер*50000#Сидорова*бухгалтер*45000",
            "Спортсмен*Вид*Разряд#Иванов*футбол*1#Петрова*теннис*КМС#Сидоров*хоккей*МС"
        );

        for ($i = 0; $i < count($tables); $i++) {
            outTable($tables[$i], $i+1, $requiredCols);
        }

        echo "<h2>ЕЩЕ ПРИМЕРЫ РАБОТЫ</h2>";
        
        // ПРИМЕР 1: Ошибка - неправильное число колонок
        // Количество колонок = 0
        outTable("ФИО*Возраст*Город#Иванов*25*Москва", 11, 0);
        
        // ПРИМЕР 2: Ошибка - пустая структура (нет строк)
        outTable("", 12, 3);
        
        // ПРИМЕР 3: Ошибка - только разделители (нет ячеек)
        outTable("# # #", 13, 3);
        
        // ПРИМЕР 4: Ошибка - двойной разделитель (нет строк с ячейками)
        outTable("##", 14, 3);
        
        // ПРИМЕР 5: Ошибка - строка без разделителей (не формат)
        outTable("Просто строка без звездочек и решеток", 15, 3);
        ?>
    </main>
    
    <footer>
        <div class="footer-content">
            <span>© Ильина А.А., 241-352</span>
        </div>
    </footer>
</body>
</html>


<!-- function debugFunction($param) {
    echo "<div style='color:blue;'>Вызвана debugFunction с параметром: $param</div>";
    return strtoupper($param);
}

echo debugFunction("test"); 
Выведет синий текст и потом "TEST" -->
