<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Ильина А.А. | Группа 241-352 | ЛР А-7</title>
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
        <div class="form-card">
            <h1>Сортировка массива</h1>
            
            <form action="sort.php" method="post" target="_blank">
                <input type="hidden" name="arrLength" id="arrLength" value="1">
                
                <table class="elements-table" id="elementsTable">
                    <tr>
                        <td class="element-row">
                            <span>0:</span>
                            <input type="text" name="element0" placeholder="Введите число">
                        </td>
                    </tr>
                </table>
                
                <button type="button" class="btn" onclick="addElement()">+ Добавить еще один элемент</button>
                <button type="submit" class="btn btn-primary">Сортировать массив</button>
                
                <br><br>
                
                <label><strong>Выберите алгоритм сортировки:</strong></label><br>
                <select name="algorithm" class="algorithm-select">
                    <option value="0">Сортировка выбором</option>
                    <option value="1">Пузырьковый алгоритм</option>
                    <option value="2">Алгоритм Шелла</option>
                    <option value="3">Алгоритм садового гнома</option>
                    <option value="4">Быстрая сортировка</option>
                    <option value="5">Встроенная функция PHP (sort)</option>
                </select>
            </form>
        </div>
    </div>

    <footer>
        <div class="footer-content">
            <div class="footer-info">
                © Ильина А.А., 241-352 | Сортировка массивов
            </div>
        </div>
    </footer>

    <script>
        let elementCounter = 1;
        
        function addElement() {
            const table = document.getElementById('elementsTable');
            const row = table.insertRow();
            const cell = row.insertCell(0);
            cell.className = 'element-row';
            cell.innerHTML = '<span>' + elementCounter + ':</span> ' +
                             '<input type="text" name="element' + elementCounter + 
                             '" placeholder="Введите число">';
            elementCounter++;
            document.getElementById('arrLength').value = elementCounter;
        }
    </script>
</body>
</html>