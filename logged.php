
<?php
session_start();

if (!isset($_SESSION["isLoggedIn"])) {
    header('Location: ./index.php');
}
$name   = $_SESSION["username"];
$userId = $_SESSION["userId"];
require "./connect.php";
$connection = connect();
$sql        = "SELECT friendId,friendName FROM friends WHERE userId=$userId";

$stmt = $connection->prepare($sql);

$stmt->execute();
$friends    = $stmt->fetchAll();
$connection = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Logged in</title>
    <?php require "./partials/_head.php"; ?>



</head>
<body>
<?php require "./partials/navbar.php" ?>
<div class="logged-wrapper">
<aside class="user-profile">
    <section class="user">
        <h2 class="user__header"><?php echo $name; ?></h2>
        <a href="./edit.php?user=<?php echo ($_SESSION["userId"]); ?>">edit</a>
        <img class="user__image" src="./images/profile-image.jpeg" alt="Profile picture">
    </section>
    <section class="friends">
        <h3 class="friends__header">Friends</h3>
        <?php foreach ($friends as $friend) { ?>

        <?php require "./partials/_friend.php"; ?>
        <?php }
; ?>
        <?php if (count($friends) === 0) {echo ("<p>No friends found<p>");} ?>




    </section>

</aside>
<main class="main">
<?php require "./partials/post-form.php"; ?>

<section class="posts">

    <?php require "./partials/post.php"; ?>
</section>




</main>

<main class="feed">



</main>

</div>
<script>
const count = (e) => {
    let input = e.target.value;
    let length = input.length;
    return length;
}

const write=(target,length)=>{

    let output = document.querySelector(`.${target}`);
    output.innerText = length;
}

const handleCounting = (e)=>{
    console.log(e.target.name);
    let output = `${e.target.name}__counter`;
    let length = count(e);
    write(output,length);
}
</script>

</body>
</html>
