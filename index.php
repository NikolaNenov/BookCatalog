<?php
include 'includes/header.php';
include 'includes/db_connect.php';
?>

<ul class="nav nav-tabs nav-justified btn-lg">
    <li class="active"><a href="index.php"><span class="glyphicon glyphicon-chevron-down"></span></a></li>
    <li><a href="add_author.php">Добави автор</a></li>
    <li><a href="add_book.php">Добави книга</a></li>
</ul>

<br/><br/><br/><br/>

<div class="jumbotron">
    <div class="container">
        <div style="float: left;">
            <table style="color:white">
                <tr style="font-weight: bold">
                    <td>заглавие:&nbsp &nbsp &nbsp &nbsp &nbsp</td>
                    <td>автори:</td>
                </tr>
                <tr>
                    <td></td><td></td>
                </tr>
                <?php
                $sql = 'SELECT book_title,author_name FROM books LEFT JOIN books_authors 
                        ON books_authors.book_id=books.book_id LEFT JOIN authors 
                        ON authors.author_id=books_authors.author_id';
                $result = mysqli_query($connection, $sql);

                $sort = array();

                foreach ($result as $value) {

                    $sort[$value['book_title']]['title'] = $value['book_title'];
                    $sort[$value['book_title']]['author'][] = $value['author_name'];
                }
                foreach ($sort as $value) {
                    echo '<tr><td>' . $value['title'] . '</td><td>';
                    foreach ($value['author'] as $val) {
                        echo '<a href="books_by.php?id=' . $val . '" style="color:#999999">' . $val . '</a>&nbsp &nbsp';
                    }

                    echo '</td></tr>';
                }
                ?>      
            </table>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';