<?php

namespace SimpleTodo;


abstract class Model
{
    private array $attributes = [];

    protected static string $table = '';

    /**
     * Todo constructor.
     *
     * @param $attributes
     */
    private function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            $this->attributes[$key] = $value;
        }
    }

    /**
     * Create a new todo entry
     *
     * @param array $attributes
     * @return mixed
     */
    public static function create(array $attributes)
    {
        Database::getInstance()
            ->prepare(
                sprintf(
                    'INSERT INTO %s (%s) VALUES (%s)',
                    static::$table,
                    implode(', ', array_keys($attributes)),
                    implode(', ', array_fill(0, count($attributes), '?'))
                )
            )
            ->execute(array_values($attributes));

        return self::get(Database::getInstance()->lastInsertId());
    }

    /**
     * Get todo by id
     *
     * @param int $id
     * @return mixed
     */
    public static function get(int $id)
    {
        $stmt = Database::getInstance()->prepare('SELECT * FROM ' . static::$table . ' WHERE id = ?');
        $stmt->execute([$id]);

        $stmt->setFetchMode(Database::FETCH_CLASS, static::class);

        return $stmt->fetch();
    }

    /**
     * Get all results
     *
     * @return array
     */
    public static function getAll(): array
    {
        $stmt = Database::getInstance()->prepare('SELECT * FROM ' . static::$table);
        $stmt->execute();

        return $stmt->fetchAll(Database::FETCH_CLASS, static::class);
    }

    /**
     * Get attribute
     *
     * @param $name
     * @return mixed|null
     */
    public function __get(string $name)
    {
        if (array_key_exists($name, $this->attributes)) {
            return $this->attributes[$name];
        }

        trigger_error("Undefined property: \${$name}", E_USER_NOTICE);

        return null;
    }

    /**
     * Set attribute
     *
     * @param $name
     * @param $value
     */
    public function __set(string $name, $value): void
    {
        $this->attributes[$name] = $value;
    }

    /**
     * Save the current model
     *
     * @return bool
     */
    public function save(): bool
    {
        return Database::getInstance()
            ->prepare(
                sprintf(
                    'UPDATE %s SET %s WHERE id = ?',
                    static::$table,
                    implode(
                        ', ',
                        array_map(function ($key) {
                            return "$key = ?";
                        }, array_keys($this->attributes))
                    )
                )
            )
            ->execute(
                array_merge(
                    array_values($this->attributes),
                    [
                        $this->attributes['id']
                    ]
                )
            );
    }

    /**
     * Delete todo by id
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        return Database::getInstance()
            ->prepare('DELETE FROM ' . static::$table . ' WHERE id = ?')
            ->execute([$id]);
    }
}
