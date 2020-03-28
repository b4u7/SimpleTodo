<?php

use SimpleTodo\Models\Todo;

require_once 'include.php';


// Todo: rewrite this
if (empty($_GET['id'])) {
    http_response_code(404);
    die('404: Not found');
}

if (!Todo::get($_GET['id'])) {
    http_response_code(404);
    die('404: Not found');
}

Todo::delete($_GET['id']);

$esClient->delete([
    'index' => 'todos',
    'id' => $_GET['id']
]);

sleep(2);
header('Location: /');
