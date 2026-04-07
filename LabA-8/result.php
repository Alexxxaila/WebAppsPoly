<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Результат анализа текста | Ильина А.А. | ЛР А-8</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="header-content">
            <img src="logo.png" alt="Логотип университета" class="logo">
            <span class="header-title">Ильина А.А. | Группа 241-352 | ЛР А-8</span>
        </div>
    </header>

    <div class="container">
        <div class="result-card">
            <?php
            // Проверка наличия текста
            if (!isset($_POST['data']) || trim($_POST['data']) === '') {
                echo '<div class="error-box">';
                echo '<strong>Ошибка:</strong> Нет текста для анализа.';
                echo '<br><a href="index.php" class="back-link">← Вернуться к форме</a>';
                echo '</div>';
                exit();
            }
            
            // Перекодировка (UTF-8 -> CP1251 для корректной обработки)
            $originalText = $_POST['data'];
            $text = iconv("UTF-8", "CP1251//IGNORE", $originalText);
            
            function toUtf8($str) {
                return iconv("CP1251", "UTF-8//IGNORE", $str);
            }
            
            // Функции для определения типов символов
            function isLetter($char) {
                $code = ord($char);
                // Русские буквы в CP1251
                if ($code >= 192 && $code <= 223) return true;  // А-Я
                if ($code >= 224 && $code <= 255) return true;  // а-я
                if ($code == 168 || $code == 184) return true;  // Ё, ё
                // Английские буквы
                if ($code >= 65 && $code <= 90) return true;   // A-Z
                if ($code >= 97 && $code <= 122) return true;  // a-z
                return false;
            }
            
            function isUpperCase($char) {
                $code = ord($char);
                if ($code >= 192 && $code <= 223) return true;  // А-Я
                if ($code == 168) return true;                   // Ё
                if ($code >= 65 && $code <= 90) return true;    // A-Z
                return false;
            }
            
            function isPunctuation($char) {
                $punctuation = ['.', ',', '!', '?', ';', ':', '-', '—', '(', ')', '[', ']', '{', '}', '"', "'", '«', '»', '…'];
                return in_array($char, $punctuation);
            }
            
            function isWordDelimiter($char) {
                $delimiters = [' ', "\n", "\r", "\t", '.', ',', '!', '?', ';', ':', '-', '—', '(', ')', '[', ']', '{', '}', '"', "'", '«', '»'];
                return in_array($char, $delimiters);
            }
            
            // Анализ текста
            $totalChars = strlen($text);
            $letterCount = 0;
            $upperCount = 0;
            $lowerCount = 0;
            $punctuationCount = 0;
            $digitCount = 0;
            $charCount = [];
            $words = [];
            $currentWord = '';
            
            for ($i = 0; $i < $totalChars; $i++) {
                $char = $text[$i];
                
                if (ctype_digit($char)) $digitCount++;
                if (isPunctuation($char)) $punctuationCount++;
                
                if (isLetter($char)) {
                    $letterCount++;
                    if (isUpperCase($char)) $upperCount++;
                    else $lowerCount++;
                }
                
                // Подсчет символов (без учета регистра)
                $lowerChar = strtolower($char);
                if (isset($charCount[$lowerChar])) $charCount[$lowerChar]++;
                else $charCount[$lowerChar] = 1;
                
                // Разбор на слова
                if (isWordDelimiter($char)) {
                    if ($currentWord !== '') {
                        $wordLower = strtolower($currentWord);
                        if (isset($words[$wordLower])) $words[$wordLower]++;
                        else $words[$wordLower] = 1;
                        $currentWord = '';
                    }
                } else {
                    $currentWord .= $char;
                }
            }
            
            // Последнее слово
            if ($currentWord !== '') {
                $wordLower = strtolower($currentWord);
                if (isset($words[$wordLower])) $words[$wordLower]++;
                else $words[$wordLower] = 1;
            }
            
            // Общее количество слов (с учетом повторений)
            $totalWordCount = array_sum($words);
            
            // Сортировка
            ksort($charCount);
            ksort($words);
            
            // Вывод результатов
            echo '<h1>Результат анализа текста</h1>';
            
            echo '<h2>Исходный текст</h2>';
            echo '<div class="source-text">' . nl2br(htmlspecialchars($originalText)) . '</div>';
            
            echo '<h2>Информация о тексте</h2>';
            echo '<div class="stats-grid">';
            echo '<div class="stat-item"><span class="stat-label">Количество символов (вкл пробелы):</span> ' . $totalChars . '</div>';
            echo '<div class="stat-item"><span class="stat-label">Количество букв:</span> ' . $letterCount . '</div>';
            echo '<div class="stat-item"><span class="stat-label">Количество заглавных букв:</span> ' . $upperCount . '</div>';
            echo '<div class="stat-item"><span class="stat-label">Количество строчных букв:</span> ' . $lowerCount . '</div>';
            echo '<div class="stat-item"><span class="stat-label">Количество знаков препинания:</span> ' . $punctuationCount . '</div>';
            echo '<div class="stat-item"><span class="stat-label">Количество цифр:</span> ' . $digitCount . '</div>';
            echo '<div class="stat-item"><span class="stat-label">Количество слов (с учетом повторений):</span> ' . $totalWordCount . '</div>';
            echo '</div>';
            
            echo '<h2>Количество вхождений символов</h2>';
            echo '<table class="result-table">';
            echo '<thead><tr><th>Символ</th><th>Количество вхождений</th></tr></thead>';
            echo '<tbody>';
            foreach ($charCount as $char => $count) {
                if ($char === "\n") $displayChar = '\\n (новая строка)';
                elseif ($char === "\r") $displayChar = '\\r (возврат каретки)';
                elseif ($char === "\t") $displayChar = '\\t (табуляция)';
                elseif ($char === ' ') $displayChar = '(пробел)';
                else $displayChar = toUtf8($char);
                echo '<tr><td>' . htmlspecialchars($displayChar) . '</td><td>' . $count . '</td></tr>';
            }
            echo '</tbody></table>';
            
            echo '<h2>Список слов и количество вхождений</h2>';
            if (count($words) > 0) {
                echo '<table class="result-table">';
                echo '<thead><tr><th>Слово</th><th>Количество вхождений</th></tr></thead>';
                echo '<tbody>';
                foreach ($words as $word => $count) {
                    echo '<tr><td>' . htmlspecialchars(toUtf8($word)) . '</td><td>' . $count . '</td></tr>';
                }
                echo '</tbody></table>';
            } else {
                echo '<p>Слова не найдены.</p>';
            }
            
            echo '<div style="text-align: center; margin-top: 30px;">';
            echo '<a href="index.php" class="back-link">Другой анализ</a>';
            echo '</div>';
            ?>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-info">
                © Ильина А.А., 241-352 | Анализ текста
            </div>
        </div>
    </footer>
</body>
</html>