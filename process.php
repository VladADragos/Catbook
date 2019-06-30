<?php
require "./connect.php";
$maxUserLen    = 20;
$maxPassLen    = 30;
$maxCommentLen = 80;
$maxPostLen    = 150;

function validate($in, $field, $length = 20, $strict = true)
{
    $patern = $strict ? "/[\s\\\/\<\>]/" : "/[\\\/\<\>]/";

    if (isset($in)) {
        if (strlen(strip_tags($in)) > $length) {
            $_SESSION['errors'][$field] = "To long, max length is " . $length;

            return false;
        }

        if (preg_match($patern, $in) || strlen($in) != strlen(strip_tags($in))) {
            $_SESSION['errors'][$field] = "s \ / < > or spaces not allowed";

            return false;
        }
    } else {
        $_SESSION['errors'][$field] = "Field can not be empty";
        return false;
    }
    return true;
}

function logOutUser()
{

    session_start();
    if (isset($_SESSION["isLoggedIn"]) && $_SESSION["isLoggedIn"]) {
        session_destroy();
    }

    header('Location: ./index.php');

}

function logInUser()
{
    global $maxPassLen, $maxUserLen;
    session_start();
    if (validate($_POST['username'], 'loginUsername', $maxUserLen)) {
        $_POST['errors']['loginUsername'] = false;
        if (validate($_POST['password'], 'loginPassword', $maxPassLen)) {
            try {

                $connection = connect();

                $username = htmlentities($_POST['username']);
                $password = $_POST['password'];

                $sql = "SELECT username,`password`,id,profilePicture FROM users WHERE username=:username";

                $stmt = $connection->prepare($sql);

                $stmt->execute(['username' => $username]);
                $user = $stmt->fetch();
                if ($user == null) {
                    $_SESSION['errors']['loginUsername'] = "User does not exist";
                } else {

                    if (password_verify($password, $user->password)) {
                        $_SESSION['errors']         = null;
                        $_SESSION["username"]       = $user->username;
                        $_SESSION["isLoggedIn"]     = true;
                        $_SESSION["userId"]         = $user->id;
                        $_SESSION["profilePicture"] = $user->profilePicture;

                        var_dump($_SESSION['errors']);
                        header('Location: logged.php');
                        return;
                    } else {
                        $_SESSION['errors']['loginUsername'] = "Wrong password or username";

                    }
                    $connection = null;

                }

            } catch (PDOException $e) {
                echo "<br>" . $e->getMessage();
            }
        }

    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

function registerUser()
{
    global $maxPassLen, $maxUserLen;
    try {
        session_start();

        $connection     = connect();
        $profilePicture = $_POST['profile-picture'];
        $username       = htmlentities($_POST['username']);
        $password       = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "SELECT username FROM users WHERE username=:username";

        $stmt = $connection->prepare($sql);

        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user == null) {
            $_SESSION['errors']['userExists'] = false;
            if (validate($_POST['username'], 'username', $maxUserLen)) {

                $_SESSION['errors']['username'] = false;
                echo ("pass valid");
                var_dump(validate($_POST['password'], 'password'));

                if (validate($_POST['password'], 'password', $maxPassLen)) {

                    unset($_SESSION['errors']);

                    $sql = 'INSERT INTO users (`id`, `username`, `password`, `profilePicture`)
                            VALUES (:id, :username, :password,  :profilePicture)';

                    $stmt = $connection->prepare($sql);

                    $stmt->execute(['id' => null, 'username' => $username, 'password' => $password, 'profilePicture' => $profilePicture]);

                    $sql = "SELECT username,`password`,id, profilePicture FROM users WHERE username=:username";

                    $stmt = $connection->prepare($sql);

                    $stmt->execute(['username' => $username]);
                    $user = $stmt->fetch();

                    $_SESSION["username"]       = $user->username;
                    $_SESSION["userId"]         = $user->id;
                    $_SESSION["profilePicture"] = $user->profilePicture;
                    $_SESSION["isLoggedIn"]     = true;

                    $connection = null;
                    header("Location: " . $_SERVER['HTTP_REFERER']);

                }
            }
        } else {
            $_SESSION['errors']['userExists'] = 'user already exists';
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
        header("Location: " . $_SERVER['HTTP_REFERER']);

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
        $connection = null;

    } catch (PDOException $e) {
        echo "<br>" . $e->getMessage();
    }

}

function befriend()
{
    try {

        $connection = connect();
        $requester  = $_POST['userId'];
        $receiver   = $_POST['friendId'];
        $sql        = 'INSERT INTO `friends` (`id`, `userId`, `friendId`) VALUES (:id, :userId, :friendId)';

        $stmt = $connection->prepare($sql);

        $stmt->execute(['id' => null, 'userId' => $requester, 'friendId' => $receiver]);
        var_dump($_POST);

        $connection = null;
        header("Location: ./search.php");

    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

}

function edit()
{

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
        header("Location: " . $_SERVER['HTTP_REFERER']);

    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

}

function post()
{
    global $maxPostLen;
    try {
        session_start();
        $connection = connect();

        $posterId         = $_POST['id'];
        $content          = $_POST['text'];
        $postId           = uniqid("", true);
        $storageDirectory = "./images/post/";
        $file             = $_FILES['image'];

        $_SESSION['errors']['postImage'] = false;
        if (validate($_POST['text'], "post", $maxPostLen, false)) {
            $_SESSION['errors']['post'] = false;
            if (isset($file) && $file['size'] !== 0) {
                $fileName    = $file['name'];
                $fileTmpName = $file['tmp_name'];
                $fileSize    = $file['size'];
                $fileError   = $file['error'];
                $fileType    = $file['type'];

                $fileExt       = explode('.', $fileName);
                $fileActualExt = strtolower(end($fileExt));
                $allowedSize   = 500000;

                $allowedExts = array('jpg', 'jpeg', 'png', 'pdf', 'webp');
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
                            unset($_SESSION['errors']);
                            echo ("sucess");
                        } else {
                            $_SESSION['errors']['postImage'] = "Image to big, max allowed size " . $allowedSize / 1000 . "kB / " . ($allowedSize / 10 ** 6) . " MB";
                        }
                    } else {
                        echo ("error uploading");
                    }

                } else {
                    $_SESSION['errors']['postImage'] = "Image type not allowed, use jpg, jpeg, png or pdf";
                }
            } else {

                $_SESSION['errors']['postImage'] = "Image not selected";
            }
        }
        header("Location: " . $_SERVER['HTTP_REFERER']);

    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}

function comment()
{
    global $maxCommentLen;
    session_start();

    if (validate($_POST['comment'], "comment", $maxCommentLen, false)) {
        $_SESSION['errors']['comment'] = false;
        try {

            $connection  = connect();
            $commenterId = $_POST['commenterId'];
            $postId      = $_POST['postId'];
            $comment     = $_POST['comment'];

            $sql = 'INSERT INTO `comments` (`id`, `commenterId`, `postId`, `comment`, `timestamp`) VALUES (:id, :commenterId, :postId, :comment, :timestamp)';

            $stmt = $connection->prepare($sql);

            $stmt->execute(['id' => null, 'commenterId' => $commenterId, 'postId' => $postId, 'comment' => $comment, 'timestamp' => null]);
            header("Location: " . $_SERVER['HTTP_REFERER']);
            // var_dump();

        } catch (PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }
    } else {
        header("Location: " . $_SERVER['HTTP_REFERER']);

    }
}

function deleteComment()
{
    try {
        session_start();
        $connection  = connect();
        $commenterId = $_POST['commentId'];

        $sql = "DELETE FROM `comments` WHERE `comments`.`id` =:id";

        $stmt = $connection->prepare($sql);

        $stmt->execute(['id' => $commenterId]);
        header("Location: " . $_SERVER['HTTP_REFERER']);

    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}

function deletePost()
{
    try {
        session_start();
        $connection = connect();
        $postId     = $_POST['postId'];
        $image      = $_POST['pictureName'];

        unlink("./images/post/" . $image);

        $sql = "DELETE FROM `posts` WHERE `posts`.`id` =:id";

        $stmt = $connection->prepare($sql);

        $stmt->execute(['id' => $postId]);
        header("Location: " . $_SERVER['HTTP_REFERER']);

    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}

function deleteUser()
{
    try {
        session_start();
        $connection = connect();
        $userId     = $_POST['userId'];

        $sql  = "SELECT * FROM posts WHERE posterId=:id";
        $stmt = $connection->prepare($sql);
        $stmt->execute(['id' => $userId]);
        $posts = $stmt->fetchAll();

        $ids = "";
        foreach ($posts as $post) {
            $ids .= "$post->id,";
            unlink("./images/post/" . $post->pictureName);
        }

        $ids = "(" . rtrim($ids, ',') . ")";
        var_dump($ids);
        $sql = "DELETE  FROM `comments` WHERE `comments`.`postId` IN $ids";

        $stmt = $connection->prepare($sql);

        $stmt->execute();

        $sql_posts   = "DELETE FROM `posts` WHERE `posts`.`posterId` =:id;";
        $sql_friends = "DELETE FROM `friends` WHERE `friends`.`userId` =:id OR `friends`.`friendId` =:id;";
        $sql_user    = "DELETE FROM `users` WHERE `users`.`id` =:id;";

        $sql  = $sql_posts . $sql_friends . $sql_user;
        $stmt = $connection->prepare($sql);

        $stmt->execute(['id' => $userId]);

        logOutUser();

    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }
}

function unfriend(){

    try {
        session_start();
        $id = $_POST['id'];
        $connection = connect();
        $sql = "DELETE FROM `friends` WHERE `friends`.`id` =:id";

        $stmt = $connection->prepare($sql);

        $stmt->execute(['id' => $id]);
        header("Location: " . $_SERVER['HTTP_REFERER']);

    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }


}

end($_REQUEST);
$request = key($_REQUEST);

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
    case 'unfriend-button':
        unfriend();
        break;
    case 'post-button':
        post();
        break;
    case 'edit-button':
        edit();
        break;
    case 'comment-button':
        comment();
        break;
    case 'delete-comment-button':
        deleteComment();
        break;
    case 'delete-post-button':
        deletePost();
        break;
    case 'delete-user-button':
        deleteUser();
        break;
    default;
        header('Location: ./index.php');
        break;

}
