<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Ильина А.А. | Группа 241-352 | ЛР А-8</title>
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
        <div class="form-card">
            <h1>Анализ текста</h1>
            
            <form action="result.php" method="post" target="_blank">
                <div class="form-group">
                    <label for="text">Введите текст для анализа:</label>
                    <textarea name="data" id="text" rows="10" placeholder="Введите или вставьте текст здесь..."></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Анализировать</button>
            </form>
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