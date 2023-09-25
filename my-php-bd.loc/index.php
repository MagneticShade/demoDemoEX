<?php 
error_reporting(E_ALL);
include_once('link.php');

?>



<!-- Сортировка с помощью JS ajax php -->

        <?php 
        if (empty ($_GET)) {
            echo <<<DFE
<h2>Фильтр по категориям</h2>
<select name="category" id="">
    <option value=""></option>
    <option value="laser">Лазерные принтеры</option>
    <option value="ink">Струйные принтеры</option>
    <option value="laser">Термо принтеры</option>
</select>
<br>
<br>
            <table border="1" id='table_id'>
            
                <caption>Каталог принтеров</caption>
                <thead>
                <tr>
                    <th id = "file">Фото</th>
                    <th id = "name">Наименование</th>
                    <th id = "year">Год производства</th>
                    <th id = "price">Цена</th>
                    <th id = "category_id">Категория</th>
                </tr>
                </thead>
                <tbody>
DFE;             
        $result = mysqli_query($link,
        "SELECT *, category.names as categoryname         
        FROM product
        JOIN category 
        ON product.category_id = category.id
        WHERE count>0
        ORDER BY date
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
}else {
    $column = $_GET['column'];
    $order = $_GET['order'];
        $result = mysqli_query($link,
        "SELECT *, category.names as categoryname         
        FROM product       
        JOIN category        
        ON product.category_id = category.id       
        WHERE count>0       
        ORDER BY $column $order");
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
}    
    ?>
    </tbody>
   
</table>

<script>

let sortColumn = '';
let sortOrder = 'ASC';

document.getElementById("file").addEventListener("click", function() {
    sortTable('file');
});
document.getElementById("name").addEventListener("click", function() {
    sortTable('name');
});
document.getElementById("year").addEventListener("click", function() {
    sortTable('year');
});
document.getElementById("price").addEventListener("click", function() {
    sortTable('price');
});
document.getElementById("category_id").addEventListener("click", function() {
    sortTable('category_id');
});

function sortTable(columnName) {
    if (columnName === sortColumn) {
        sortOrder = (sortOrder === 'ASC') ? 'DESC' : 'ASC';
    } else {
        sortColumn = columnName;
        sortOrder = 'ASC';
    }

    fetch('index.php?column=' + columnName + '&order=' + sortOrder)
    .then(response => response.text())
    .then(data => {
        document.querySelector("tbody").innerHTML = data;
    });
}
</script>

