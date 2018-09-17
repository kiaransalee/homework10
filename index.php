<?php
define('DB_DRIVER', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'shop');
define('DB_USER', 'natasha');
define('DB_PASS', 'Alukard999');

$name = !empty($_POST['name']) ? $_POST['name'] : '';
$author = !empty($_POST['author'])  ?$_POST['author'] : '';
$isbn = !empty($_POST['isbn']) ? $_POST['isbn'] : '';

print_r($_POST['name']);

try {
    $connect_str = DB_DRIVER . ':host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
    $db = new PDO ($connect_str, DB_USER, DB_PASS);
    $sql = $db-> prepare ("SELECT * FROM books WHERE name LIKE ? AND author LIKE ? AND isbn LIKE ?");
    $sql->execute(["%$name%","%$author%","%$isbn%"]);
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
 
} catch (PDOExeption $e) {
    die("error: " . $e->getMessage());
}

?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Библиотека успешного человека</title>
</head>
<body>
<h1>Библиотека успешного человека</h1>
<form method="post">
    <input type="text" name="isbn" placeholder="ISBN" value="<?= $isbn ?>">
    <input type="text" name="name" placeholder="Название книги" value="<?= $name ?>">
    <input type="text" name="author" placeholder="Автор книги" value="<?= $author ?>">
    <button type="submit">Поиск</button>
</form>
<table border="1">
    <tr bgcolor="#DCDCDC" style="font-weight:bold;" align="center">
        <td>Название</td>
        <td>Автор</td>
        <td>Год выпуска</td>
        <td>Жанр</td>
        <td>ISBN</td>
    </tr>
    <?php if ($result): ?>
        <?php
        foreach ($result as $books) {
            echo "<tr>
            <td>{$books['name']}</td>
            <td>{$books['author']}</td>
            <td>{$books['year']}</td>
            <td>{$books['genre']}</td>
            <td>{$books['isbn']}</td>
            </tr>";
        } ?>
    <?php endif; ?>
</table>
</body>
</html>