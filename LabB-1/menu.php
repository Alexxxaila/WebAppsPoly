<?php
/**
 * Модуль menu.php
 * Формирует основное меню и подменю сайта
 * Возвращает HTML-код меню
 */

function renderMenu() {
    // Определяем текущий пункт меню
    $currentPage = isset($_GET['p']) ? $_GET['p'] : 'viewer';
    $currentSort = isset($_GET['sort']) ? $_GET['sort'] : 'byid';
    
    $html = '<div id="menu">';
    
    // Пункт "Просмотр"
    $html .= '<a href="?p=viewer"';
    if ($currentPage == 'viewer') {
        $html .= ' class="selected"';
    }
    $html .= '>Просмотр</a>';
    
    // Пункт "Добавление записи"
    $html .= '<a href="?p=add"';
    if ($currentPage == 'add') {
        $html .= ' class="selected"';
    }
    $html .= '>Добавление записи</a>';
    
    // Пункт "Редактирование записи"
    $html .= '<a href="?p=edit"';
    if ($currentPage == 'edit') {
        $html .= ' class="selected"';
    }
    $html .= '>Редактирование записи</a>';
    
    // Пункт "Удаление записи"
    $html .= '<a href="?p=delete"';
    if ($currentPage == 'delete') {
        $html .= ' class="selected"';
    }
    $html .= '>Удаление записи</a>';
    
    $html .= '</div>';
    
    // Подменю для раздела "Просмотр"
    if ($currentPage == 'viewer') {
        $html .= '<div id="submenu">';
        
        // Сортировка по умолчанию (по id)
        $html .= '<a href="?p=viewer&sort=byid"';
        if ($currentSort == 'byid') {
            $html .= ' class="selected"';
        }
        $html .= '>По умолчанию</a>';
        
        // Сортировка по фамилии
        $html .= '<a href="?p=viewer&sort=fam"';
        if ($currentSort == 'fam') {
            $html .= ' class="selected"';
        }
        $html .= '>По фамилии</a>';
        
        // Сортировка по дате рождения
        $html .= '<a href="?p=viewer&sort=birth"';
        if ($currentSort == 'birth') {
            $html .= ' class="selected"';
        }
        $html .= '>По дате рождения</a>';
        
        $html .= '</div>';
    }
    
    return $html;
}

// Выводим меню
echo renderMenu();
?>