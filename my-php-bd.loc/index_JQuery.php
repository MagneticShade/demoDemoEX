<?php 
error_reporting(E_ALL);
include_once('link.php');

?>

<h2>Фильтр по категориям</h2>
<select name="category" id="">
    <option value=""></option>
    <option value="laser">Лазерные принтеры</option>
    <option value="ink">Струйные принтеры</option>
    <option value="laser">Термо принтеры</option>
</select>
<br>
<br>

<!-- Сортировка с помощью JQuery -->

<table border="1" id='table_id'>
    
        <caption>Каталог принтеров</caption>
        <thead>
        <tr>
            <th>Фото</th>
            <th>Наименование</th>
            <th>Год производства</th>
            <th>Цена</th>
            <th>Категория</th>
        </tr>
        </thead>
        <tbody>
        <?php 
        $result = mysqli_query($link,
        // Выбираем всё. Если в связанных таблицах есть поля с одинковыми именами необходимо создать псевдоним 
        "SELECT *, category.names as categoryname         
        /* Из табцы product */
        FROM product
        /* присоединяем таблицу  category*/ 
        JOIN category 
        /* указываем поля для связи в первой и второй таблице */
        ON product.category_id = category.id
        /* создаем условие при котором количество принтеров должно быть больше 0 */ 
        WHERE count>0
        /* сортируем выборку по дате */ 
        ORDER BY date
        /* выводим по убыванию */ 
        DESC");
                while ($row = mysqli_fetch_assoc($result)) {                    
                    echo <<<EOD
<tr>
<td><img src="{$row['file']}" width="100" alt="принтер"></td>
<td>{$row['name']}</td>
<td>{$row['year']}</td>
<td>{$row['price']}</td>
<td>{$row['categoryname']}</td>
</tr>

EOD;
}
        ?>
    </tbody>
    
</table>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script>
    $(document).ready( function () {
        $('#table_id').DataTable();
    } );
</script>



