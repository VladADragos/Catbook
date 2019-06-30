
<?php
function errorExist($err)
{
    if (isset($_SESSION['errors'][$err]) && $_SESSION['errors'][$err] != false) {
        echo ('<p class="error">' . $_SESSION['errors'][$err] . '</p>');
    }
}