<?php
include 'includes/header.php';
include 'includes/functions.php';
include 'includes/db_connect.php';

if ($_POST) {
    if (isset($_POST['name'])) {
        $name = trim($_POST['name']);
        $name = mysqli_real_escape_string($connection,$name);
        $result = mysqli_query($connection, 'SELECT COUNT(author_name) FROM authors WHERE author_name =\'' . $name . '\'');
        $row = $result->fetch_assoc();

        if (!$row['COUNT(author_name)'] > 0) {
            if (preg_match("/^[a-zA-Zа-яА-Я\ \-`\.]{3,50}$/u", $name) === 1) {
                $sql = 'INSERT INTO authors (author_name) VALUE (\'' . $name . '\')';
                $result = mysqli_query($connection, $sql);
                $result = mysqli_real_escape_string($connection, $result);


                if (!$result) {
                    $_POST['error'] = 6;
                }
            } else {
                $_POST['error'] = 1;
            }
        } else {
            $_POST['error'] = 2;
        }
    } else {
        $_POST['error'] = 1;
    }
}
?>
<ul class="nav nav-tabs nav-justified btn-lg">

    <li><a href="index.php">Книги</a></li>
    <li class="active"><a href="index.php"><span class="glyphicon glyphicon-chevron-down"></span></a></li>
    <li><a href="add_book.php">Добави книга</a></li>
</ul>

<br/><br/><br/><br/>

<div class="jumbotron">
    <div class="container">
        <div style="float: left">
            <form method="POST" action="add_author.php" name="add author">
                <div class="form-group"><input type="text"  class="form-control" name="name" placeholder="Име" style="width:200px"/></div>
                <div class="form-group"><input type="submit" class="form-control" value="Добави" style="width:200px"/></div>
            </form>
        </div>
        <div style="float: left; width: 200px">&nbsp</div>
        <div style="float: left; text-align: center">
            <table style="color: white">
                <tr>
                    <td>
                        <b>автори:</b>
                    </td>
                </tr>
                <tr>
                    <td></td>
                </tr>
                <?php
                AuthorsList($connection);
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