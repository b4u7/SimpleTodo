<?php

use SimpleTodo\Models\Todo;

require_once 'include.php';


if (!isset($_GET['id'])) {
    http_response_code(404);
    die('404: Not found');
}

$todo = Todo::get($_GET['id']);

if (!$todo) {
    http_response_code(404);
    die('404: Not found');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['title']) || !isset($_POST['body'])) {
        http_response_code(404);
        die('404: Not found');
    }

    $todo->title = $_POST['title'];
    $todo->body = $_POST['body'];

    $todo->save();

    header('Location: edit.php?id=' . $_GET['id']);
    die();
}
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SimpleTodo</title>

    <link rel="stylesheet" type="text/css" href="assets/styles/css/semantic.min.css">
    <link rel="stylesheet" href="assets/styles/css/core.css">

    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>
<body>
<section class="section">
    <div class="ui container">
        <div class="ui grid">
            <div class="right floated right aligned six wide column">
                <a class="ui primary button" href="/">
                    Go back
                </a>
            </div>
        </div>
        <div class="ui cards">
            <div class="card">
                <div class="content">
                    <div class="header">
                        Edit todo
                    </div>
                </div>
                <div class="content">
                    <form class="ui form" method="POST">
                        <div class="field">
                            <label>
                                Title
                            </label>
                            <input type="text" name="title" placeholder="Title" value="<?= $todo->title; ?>">
                        </div>
                        <div class="field">
                            <label>
                                Description
                            </label>
                            <textarea name="body" rows="2" placeholder="Description"><?= htmlspecialchars($todo->body ?? ''); ?></textarea>
                        </div>
                        <div class="field">
                            <div class="ui right floated">
                                <button class="ui inverted green button" type="submit">
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous">
</script>
<script src="assets/styles/css/semantic.min.js"></script>
</body>
</html>