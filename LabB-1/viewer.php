<?php
/**
 * Модуль viewer.php
 * Содержит класс для вывода записей из базы данных
 */

class Viewer {
    // Параметры подключения к БД
    private $host = 'localhost';
    private $user = 'labuser';
    private $password = 'labpass';
    private $dbname = 'notebook';
    private $conn;
    
    // Конструктор - подключаемся к БД
    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die('Ошибка подключения к БД: ' . $this->conn->connect_error);
        }
        $this->conn->set_charset('utf8');
    }
    
    // Деструктор - закрываем соединение
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
    
    /**
     * Получение списка контактов
     * @param string $sort Тип сортировки (byid, fam, birth)
     * @param int $page Номер страницы (0-индексация)
     * @return string HTML-код таблицы с контактами
     */
    public function getContactsList($sort = 'byid', $page = 0) {
        $recordsPerPage = 10;
        
        // Определяем поле сортировки
        switch ($sort) {
            case 'fam':
                $orderBy = 'surname, name';
                break;
            case 'birth':
                $orderBy = 'birth_date';
                break;
            default:
                $orderBy = 'id';
        }
        
        // Получаем общее количество записей
        $countResult = $this->conn->query("SELECT COUNT(*) as total FROM contacts");
        $totalRecords = $countResult->fetch_assoc()['total'];
        
        if ($totalRecords == 0) {
            return '<div class="message-error">В записной книжке пока нет записей.</div>';
        }
        
        // Вычисляем количество страниц
        $totalPages = ceil($totalRecords / $recordsPerPage);
        
        // Проверяем корректность номера страницы
        if ($page >= $totalPages) {
            $page = $totalPages - 1;
        }
        if ($page < 0) {
            $page = 0;
        }
        
        // Получаем записи для текущей страницы
        $offset = $page * $recordsPerPage;
        $sql = "SELECT * FROM contacts ORDER BY $orderBy LIMIT $offset, $recordsPerPage";
        $result = $this->conn->query($sql);
        
        // Формируем таблицу
        $html = '<table class="data-table">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>ID</th>';
        $html .= '<th>Фамилия</th>';
        $html .= '<th>Имя</th>';
        $html .= '<th>Отчество</th>';
        $html .= '<th>Пол</th>';
        $html .= '<th>Дата рождения</th>';
        $html .= '<th>Телефон</th>';
        $html .= '<th>Email</th>';
        $html .= '<th>Адрес</th>';
        $html .= '<th>Комментарий</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        
        while ($row = $result->fetch_assoc()) {
            $gender = $row['gender'] == 'm' ? 'Мужской' : 'Женский';
            $birthDate = date('d.m.Y', strtotime($row['birth_date']));
            
            $html .= '<tr>';
            $html .= '<td>' . $row['id'] . '</td>';
            $html .= '<td>' . htmlspecialchars($row['surname']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['name']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['patronymic']) . '</td>';
            $html .= '<td>' . $gender . '</td>';
            $html .= '<td>' . $birthDate . '</td>';
            $html .= '<td>' . htmlspecialchars($row['phone']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['address']) . '</td>';
            $html .= '<td>' . htmlspecialchars($row['comment']) . '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody>';
        $html .= '</table>';
        
        // Пагинация
        if ($totalPages > 1) {
            $html .= '<div class="pagination">';
            for ($i = 0; $i < $totalPages; $i++) {
                if ($i == $page) {
                    $html .= '<span>' . ($i + 1) . '</span>';
                } else {
                    $html .= '<a href="?p=viewer&sort=' . $sort . '&pg=' . $i . '">' . ($i + 1) . '</a>';
                }
            }
            $html .= '</div>';
        }
        
        return $html;
    }
}
?>