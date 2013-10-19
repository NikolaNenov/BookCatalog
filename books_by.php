<?php
include 'includes/header.php';
include 'includes/db_connect.php';
$author_exist = 0;

$sql = 'SELECT book_title,author_name FROM books LEFT JOIN books_authors 
           ON books_authors.book_id=books.book_id LEFT JOIN authors 
           ON authors.author_id=books_authors.author_id ';
$result = mysqli_query($connection, $sql);
$sort = array();
foreach ($result as $value) {
    if ($_GET['id'] == $value['author_name']) {
        $author_exist = 1;
    }
    $sort[$value['book_title']]['title'] = $value['book_title'];
    $sort[$value['book_title']]['author'][] = $value['author_name'];
}

?>
<ul class="nav nav-tabs nav-justified btn-lg">
    <li><a href="index.php">Книги</a></li>
    <li><a href="index.php">Добави автор</a></li>
    <li><a href="add_book.php">Добави книга</a></li>
</ul>

<br/><br/><br/><br/>

<div class="jumbotron">
    <div class="container">
        <table style="color:white">
            <tr>
                <td>
                    <b>Всички книги на <?php echo $_GET['id']; ?> </b>
                </td>
                <td></td>
            </tr>
            <tr><td></td><td></td></tr>

            <?php
            foreach ($sort as $value) {

                $selected_author = array_search($_GET['id'], $value['author']);

                if ($selected_author > -1) {
                    echo '<tr><td>' . $value['title'] . '</td><td>';
                    foreach ($value['author'] as $val) {
                        echo '<a href="books_by.php?id=' . $val . '" style="color:#999999">' . $val . '</a>&nbsp';
                    }
                    echo '</td></tr>';
                    $selected_author = -1;
                }
            }
            ?>      
        </table>
    </div>
</div>
<?php
if ($author_exist !== 1) {
    echo '<br/><p><div class="alert alert-danger">Несъществуващ автор!</div></p>';
}

include 'includes/footer.php';
