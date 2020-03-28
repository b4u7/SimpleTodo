<?php

namespace SimpleTodo\Models;

use SimpleTodo\Model;


/**
 * Class Todo
 * @package SimpleTodo
 *
 * @property-read int $id
 * @property string $title
 * @property string $body
 */
class Todo extends Model
{
    protected static string $table = 'todo';
}
