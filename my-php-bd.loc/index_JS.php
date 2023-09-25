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

<!-- Сортировка с помощью JS -->

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

<script>
let table = document.querySelector("#table_id");
let th = table.querySelectorAll("th");
let tbody = table.querySelector("tbody");
let rows = [...tbody.rows];

th.forEach((header) => {
  header.addEventListener("click", function () {
    let columnIndex = header.cellIndex;
    let sortDirection =
      header.getAttribute("data-sort-direction") === "asc" ? "desc" : "asc";
    header.setAttribute("data-sort-direction", sortDirection);

    rows.sort((a, b) => {
      let aValue = a.cells[columnIndex].textContent;
      let bValue = b.cells[columnIndex].textContent;

      if (sortDirection === "asc") {
        return aValue > bValue ? 1 : -1;
      } else {
        return bValue > aValue ? 1 : -1;
      }
    });

    tbody.remove();
    tbody = document.createElement("tbody");
    rows.forEach((row) => tbody.appendChild(row));
    table.appendChild(tbody);
  });
});

</script>

