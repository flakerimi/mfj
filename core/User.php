<?php

use Core\Model;

class User extends Model {

    protected static $tableName = 'users';
    protected static $columns = ['id', 'name', 'email', 'password'];

    public static function create($data) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        return parent::create($data);
    }

    public static function update($id, $data) {
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        return parent::update($id, $data);
    }

    public static function authenticate($email, $password) {
        $user = static::findByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public static function findByEmail($email) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM ' . static::getTableName() . ' WHERE email = :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findByToken($token) {
        $db = static::getDB();
        $stmt = $db->prepare('SELECT * FROM ' . static::getTableName() . ' WHERE token = :token');
        $stmt->execute(['token' => $token]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function sendPasswordReset($email) {
        $user = static::findByEmail($email);
        if ($user) {
            if ($user['token']) {
                $user['token'] = bin2hex(random_bytes(16));
            }
            $user['token_expiry'] = date('Y-m-d H:i:s', strtotime('+1 hour'));
            static::update($user['id'], $user);
            $link = 'http://' . $_SERVER['HTTP_HOST'] . '/password/reset/' . $user['token'];
            $message = "Click on the link below to reset your password:\n\n$link";
            mail($user['email'], 'Password reset', $message);
        }
    }

    public static function resetPassword($token, $password) {
        $user = static::findByToken($token);
        if ($user && $user['token_expiry'] > date('Y-m-d H:i:s')) {
            $user['password'] = password_hash($password, PASSWORD_DEFAULT);
            $user['token'] = null;
            $user['token_expiry'] = null;
            static::update($user['id'], $user);
            return true;
        } else {
            return false;
        }

        return false;

    }

}

