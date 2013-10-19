<?php

function ErrorCodes($error) {
    if ($error > 0) {
        switch ($error):
            case 1: {
                    echo '<br/><p><div class="alert alert-danger">Въведете име на автор с дължина от 3 до 50 символа като използвате само [a-zA-Zа-яА-Я -`.]</div></p>';
                    break;
                }
            case 2: {
                    echo '<br/><p><div class="alert alert-danger">Съществуващ автор</div></p>';
                    break;
                }
            case 3: {
                    echo '<br/><p><div class="alert alert-danger">Въведете заглавие като използвате само [a-zA-Zа-яА-Я -`.]</div></p>';
                    break;
                }
            case 4: {
                    echo '<br/><p><div class="alert alert-danger">Съществуваща книга</div></p>';
                    break;
                }
            case 5: {
                    echo '<br/><p><div class="alert alert-danger">Изберете автор</div></p>';
                    break;
                }
            case 6: {
                    echo '<br/><p><div class="alert alert-danger">Грешка</div></p>';
                    break;
                }

        endswitch;
    }
}

;

function AuthorsList($connection) {
    $sql = 'SELECT author_name FROM authors ORDER By author_name ASC';
    $result = mysqli_query($connection, $sql);
    while ($author = $result->fetch_assoc()) {
        echo '<tr><td><a href="books_by.php?id=' . $author['author_name'] . '" style="color: #999999">' . $author['author_name'] . '</td></tr>';
    }
}

;

function BooksList($connection) {
    $sql = 'SELECT book_title FROM books';
    $result = mysqli_query($connection, $sql);
    while ($row = $result->fetch_assoc()) {
        echo '<tr style="color: #999999"><td>' . $row['book_title'] . '</td></tr>';
    }
}