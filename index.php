<?php

use SimpleTodo\Models\Todo;

require_once 'include.php';


$params = [
    'index' => 'todos',
    'body' => [
        'query' => [
            'wildcard' => [
                'title' => [
                    'value' => '*' . (isset($_GET['search']) ? mb_strtolower($_GET['search']) : '') . '*'
                ]
            ]
        ]
    ]
];

$chunkedTodos = array_chunk($esClient->search($params)['hits']['hits'], 4, true);
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
        <form class="ui form search" method="GET">
            <div class="field">
                <div class="ui fluid action input">
                    <input type="text" name="search" placeholder="Search">
                    <button class="ui button" type="submit">
                        <i class="search icon"></i>
                    </button>
                </div>
            </div>
        </form>
        <div class="ui grid">
            <div class="left floated six wide column">
                <h1>
                    Your todo list
                </h1>
            </div>
            <div class="right floated right aligned six wide column">
                <a class="ui primary button" href="create.php">
                    Create
                </a>
            </div>
        </div>
        <!--- Rows -->
        <?php foreach ($chunkedTodos as $todos) { ?>
            <div class="ui cards">
                <!--- Columns -->
                <?php foreach ($todos as $todo) { ?>
                    <div class="card">
                        <div class="content">
                            <div class="right floated">
                                <a class="icon" href="delete.php?id=<?= $todo['_source']['id'] ?>">
                                    <i class="fas fa-times"></i>
                                </a>
                            </div>
                            <div class="header">
                                <?= $todo['_source']['title']; ?>
                            </div>
                        </div>
                        <div class="content">
                            <div class="description">
                                <?= $todo['_source']['body'] ?? '' ?>
                            </div>
                        </div>
                        <div class="extra content">
                            <div class="ui right floated">
                                <a class="ui inverted green button" href="edit.php?id=<?= $todo['_source']['id'] ?>">
                                    Edit
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous">
</script>
<script src="assets/styles/css/semantic.min.js"></script>
</body>
</html>
