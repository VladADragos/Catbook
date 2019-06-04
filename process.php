<?php
require "./connect.php";

function validate($in)
{
    if (isset($in) && ((strlen(strip_tags($in)) > 3) && (strlen(strip_tags($in)) <= 15))) {
        // Kollar om det finns HTML-taggar
        if (strlen($in) != strlen(strip_tags($in))) {
            $_SESSION['errors'] = "HTML taggar hittades";
            return false;
        }
        // Matchar mot ett regulgärt uttryck
        if (preg_match("/[\s \\ \/]/", $in)) {
            // Om det matchar, hittas
            $_SESSION['errors'] = "Förbjudna tecken hitades";
            return false;
        }
    } else {
        $_SESSION['errors'] = "Antal tecken " . strlen($in) . " vilket inte är tillåtet";
        return false;
    }
    return true;
}

function logOutUser()
{
    if (isset($_POST['logout-button'])) {

        session_start();
        if ($_SESSION["isLoggedIn"]) {
            session_destroy();
            header('Location: ./index.php');
        }

    }
}

function logInUser()
{
    session_start();

    if (validate($_POST['username']) && validate($_POST['password'])) {

        try {

            $connection = connect();

            $username = htmlentities($_POST['username']);
            $password = $_POST['password'];

            $sql = "SELECT username,`password`,id,email,phoneNumber,profilePicture FROM users WHERE username=:username";

            $stmt = $connection->prepare($sql);

            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch();

            if (password_verify($password, $user->password)) {

                $_SESSION["username"]       = $user->username;
                $_SESSION["isLoggedIn"]     = true;
                $_SESSION["userId"]         = $user->id;
                $_SESSION["email"]          = $user->email;
                $_SESSION["phoneNumber"]    = $user->phoneNumber;
                $_SESSION["profilePicture"] = $user->profilePicture;

                unset($_SESSION['errors']);

                header('Location: logged.php');

            } else {
                header('Location: index.php');

                $_SESSION['errors'] = "Wrong password or username";

            }
            $connection = null;

        } catch (PDOException $e) {
            echo "<br>" . $e->getMessage();
        }
    }
}

function registerUser()
{
    try {
        session_start();

        $connection     = connect();
        $profilePicture = $_POST['profile-picture'];
        $username       = htmlentities($_POST['username']);
        $email          = $_POST['email'];
        $phoneNumber    = $_POST['phoneNumber'];
        $password       = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = 'INSERT INTO users (`id`, `username`, `password`, `email`, `phoneNumber`, `profilePicture`)
        VALUES (:id, :username, :password, :email, :phoneNumber, :profilePicture)';

        $stmt = $connection->prepare($sql);

        $stmt->execute(['id' => null, 'username' => $username, 'password' => $password, 'email' => $email, 'phoneNumber' => $phoneNumber, 'profilePicture' => $profilePicture]);

        $sql = "SELECT username,`password`,id,email,phoneNumber, profilePicture FROM users WHERE username=:username";

        $stmt = $connection->prepare($sql);

        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        $_SESSION["username"]       = $user->username;
        $_SESSION["userId"]         = $user->id;
        $_SESSION["email"]          = $user->email;
        $_SESSION["phoneNumber"]    = $user->phoneNumber;
        $_SESSION["profilePicture"] = $user->profilePicture;
        $_SESSION["isLoggedIn"]     = true;

        unset($_SESSION['errors']);
        $connection = null;
        header('Location: ./logged.php');

    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

}

function search()
{

    try {

        $connection = connect();

        $username = $_GET['q'];

        $sql = "SELECT * FROM users WHERE username LIKE :username";

        $stmt = $connection->prepare($sql);
        $stmt->execute(['username' =>
            "%$username%"]);
        $users = $stmt->fetchAll();

        $res = "";
        foreach ($users as $user) {
            $res .= "$user->username, ";
        }
        echo $res;
        //var_dump($stmt);
        $connection = null;

    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }

}

function befriend()
{
    try {

        $connection   = connect();
        $requester    = $_POST['userId'];
        $receiver     = $_POST['friendId'];
        $receiverName = $_POST['friendName'];

        $sql = 'INSERT INTO `friends` (`id`, `userId`, `friendId`, `friendName`) VALUES (:id, :userId, :friendId,:friendName)';

        $stmt = $connection->prepare($sql);

        $stmt->execute(['id' => null, 'userId' => $requester, 'friendId' => $receiver, 'friendName' => $receiverName]);

        header('Location: ./logged.php');

        $connection = null;

    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $connection = null;

}

function edit()
{

    // UPDATE `users` SET `username` = 'vlad1', `phoneNumber` = '705172458', `email` = 'vlad66@yahoo.com' WHERE `users`.`id` = 14;

    try {
        session_start();

        $connection  = connect();
        $id          = $_POST['id'];
        $username    = htmlentities($_POST['username']);
        $email       = $_POST['email'];
        $phoneNumber = $_POST['phoneNumber'];
        $password    = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "UPDATE `users`  SET username=:username, password=:password, email=:email, phoneNumber=:phoneNumber WHERE `users`.`id`=:id";

        $stmt = $connection->prepare($sql);

        $stmt->execute(['username' => $username, 'password' => $password, 'email' => $email, 'phoneNumber' => $phoneNumber, 'id' => $id]);

        $sql  = "SELECT username,`password`,id,email,phoneNumber FROM users WHERE username=:username";
        $stmt = $connection->prepare($sql);

        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        $_SESSION["username"]    = $user->username;
        $_SESSION["userId"]      = $user->id;
        $_SESSION["email"]       = $user->email;
        $_SESSION["phoneNumber"] = $user->phoneNumber;
        $_SESSION["isLoggedIn"]  = true;

        unset($_SESSION['errors']);
        $connection = null;
        header('Location: ./logged.php');

    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

}

function post()
{
    try {
        session_start();

        $connection = connect();

        $posterId = $_POST['id'];
        $content  = $_POST['text'];
        $postId   = uniqid("", true);

        $storageDirectory = "./images/post/";
        $file             = $_FILES['image'];
        $fileName         = $file['name'];
        $fileTmpName      = $file['tmp_name'];
        $fileSize         = $file['size'];
        $fileError        = $file['error'];
        $fileType         = $file['type'];

        $fileExt       = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $allowedSize   = 500000;

        $allowedExts = array('jpg', 'jpeg', 'png', 'pdf');

        if (in_array($fileActualExt, $allowedExts)) {
            if ($fileError === 0) {
                if ($fileSize < $allowedSize) {
                    $imageName       = uniqid("", true);
                    $uploadFileName  = $imageName . "." . $fileActualExt;
                    $fileDestination = $storageDirectory . $uploadFileName;
                    $sql             = 'INSERT INTO `posts` (`id`, `posterId`, `content`, `timestamp`, `pictureName`) VALUES (:id, :posterId, :content, :timestamp, :pictureName)';

                    $stmt = $connection->prepare($sql);

                    $stmt->execute(['id' => null, 'posterId' => $posterId, 'content' => $content, 'timestamp' => null, 'pictureName' => $uploadFileName]);

                    $connection = null;

                    move_uploaded_file($fileTmpName, $fileDestination);
                    echo ("sucess");
                    header('Location: ./logged.php');

                } else {
                    echo ("error file to big");
                }
            } else {
                echo ("error uploading");
            }

        } else {
            echo ("error wrong extension");
        }

    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}

end($_REQUEST);
$request = key($_REQUEST);

var_dump($request);
switch ($request) {
    case 'login-button':
        logInUser();
        break;
    case 'q':
        search();
        break;
    case 'logout-button':
        logOutUser();
        break;
    case 'register-button':
        registerUser();
        break;
    case 'befriend-button':
        befriend();
        break;
    case 'post-button':
        post();
        break;
    case 'edit-button':
        edit();
        break;
    default;
        //header('Location: ./index.php');
        break;

}
