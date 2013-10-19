<?php
include 'includes/header.php';
include 'includes/functions.php';
include 'includes/db_connect.php';

if ($_POST) {
    if (isset($_POST['title'])) {
        $title = trim($_POST['title']);
        $title = mysqli_real_escape_string($connection,$title);
        $sql = 'SELECT COUNT(book_title) FROM books WHERE book_title =\'' . $title . '\'';
        $result = mysqli_query($connection, $sql);
        $row = $result->fetch_assoc();

        if (!$row['COUNT(book_title)'] > 0) {
            if (preg_match("/^[a-zA-Zа-яА-Я\ \-`\.]{3,50}$/u", $title) === 1) {
                if (isset($_POST['selected_authors'])) {
                    $sql = 'INSERT INTO books (book_title) VALUE (\'' . $title . '\')';
                    $result = mysqli_query($connection, $sql);
                    $book_id = mysqli_insert_id($connection);
                    $selected_authors = $_POST['selected_authors'];
                    
                    foreach ($selected_authors as $value) {
                        $sql = 'INSERT INTO books_authors( author_id,book_id) VALUES (\'' . $value . '\',\'' . $book_id . '\')';
                        $result = mysqli_query($connection, $sql);
                    }
                    if (!$result) {
                        $_POST['error'] = 6;
                    }
                } else {
                    $_POST['error'] = 5;
                }
            } else {
                $_POST['error'] = 3;
            }
        } else {
            $_POST['error'] = 4;
        }
    } else {
        $_POST['error'] = 3;
    }
}
?>

<ul class="nav nav-tabs nav-justified btn-lg">
    <li><a href="index.php">Книги</a></li>
    <li><a href="index.php">Добави автор</a></li>
    <li class="active"><a href="add_book.php"><span class="glyphicon glyphicon-chevron-down"></span></a></li>
</ul>

<br/><br/><br/><br/>

<div class="jumbotron">
    <div class="container">
        <div style="float: left">

            <form method="POST" action="add_book.php" name="add author">
                <div class="form-group"><input type="text" class="form-control" name="title" placeholder="Заглавие"/></div>
                <div class="form-group">
                    <select multiple="multiple" name="selected_authors[]" class="form-control">
                        <?php
                        $sql = 'SELECT * FROM authors ORDER BY author_name ASC';
                        $result = mysqli_query($connection, $sql);
                        while ($author = $result->fetch_assoc()) {
                            echo '<option value=' . $author['author_id'] . '>' . $author['author_name'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div><input type="submit" value="Добави" class="form-control"/></div>
            </form>        
        </div>
        <div style="float: left; width: 200px">&nbsp</div>
        <div style="float: left; text-align: center">
            <table style="color: white">
                <tr>
                    <td>
                        <b>книги:</b>
                    </td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <?php
               BooksList($connection);
                ?>
            </table>
        </div>
    </div>
</div>

<?php
if (isset($_POST['error'])) {
    ErrorCodes($_POST['error']);
}

include 'includes/footer.php';