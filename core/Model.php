<?php

namespace Core;

class Model {
    // Common database handling methods
    public static function all() {
        $db = static::getDB();
        $stmt = $db->query('SELECT * FROM ' . static::getTableName());
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM ' . static::getTableName() . ' WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = static::getDB();
        $columns = static::getColumns();
        $columns = array_flip($columns);
        $data = array_intersect_key($data, $columns);
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_map(function($column) {
            return ':' . $column;
        }, array_keys($data)));
        $sql = "INSERT INTO " . static::getTableName() . " ($columns) VALUES ($placeholders)";
        $stmt = $db->prepare($sql);
        $stmt->execute($data);
        return $db->lastInsertId();
    }

    public static function update($id, $data) {
        $db = static::getDB();
        $columns = static::getColumns();
        $columns = array_flip($columns);
        $data = array_intersect_key($data, $columns);
        $placeholders = implode(', ', array_map(function($column) {
            return $column . ' = :' . $column;
        }, array_keys($data)));
        $sql = "UPDATE " . static::getTableName() . " SET $placeholders WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->execute(array_merge($data, ['id' => $id]));
        return $stmt->rowCount();
    }


    public static function destroy($id) {
        $db = static::getDB();
        $stmt = $db->prepare('DELETE FROM ' . static::getTableName() . ' WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount();
    }

    public static function search($keyword) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM ' . static::getTableName() . ' WHERE title LIKE :keyword');
        $stmt->execute(['keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function getTableName() {
        return strtolower(str_replace('App\\Models\\', '', get_called_class())) . 's';
    }

    public static function getColumns() {
        $db = static::getDB();
        $stmt = $db->prepare('DESCRIBE ' . static::getTableName());
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    public static function getDB() {
        return Database::getInstance()->getConnection();
    }

    public static function getClassName() {
        return get_called_class();
    }

    public static function getPrimaryKey() {
        return 'id';
    }

    public static function getPrimaryKeyValue($data) {
        return $data[static::getPrimaryKey()];
    }

    
}
