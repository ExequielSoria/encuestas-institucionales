<?php

require_once './db/internDB.php';

//Clase encargada de gestionar las acciones sobre los usuarios en la base de datos
class UsersModel {

    public function updatePassword($id, $newPassword) {
        global $pdo;
        $sql = "UPDATE USERS SET PASSWORD_HASH = ? WHERE ID_USER = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([password_hash($newPassword, PASSWORD_BCRYPT), $id]);
        return $stmt->rowCount() > 0;
    }

    public function userExists($username, $id) {
        global $pdo;
        $sql = "SELECT * FROM USERS WHERE USERNAME = ? AND ID_USER !=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function updateUser($id, $username, $state, $role) {
        global $pdo;
        $sql = "UPDATE USERS SET USERNAME = ?, STATUS = ?, ROLE = ? WHERE ID_USER = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, $state, $role, $id]);
        return $stmt->rowCount() > 0;
    }

    public function howManyUsers() {
        global $pdo;
        $sql = "SELECT COUNT(*) FROM USERS";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getUserInfoById($id) {
        global $pdo;
        $sql = "SELECT USERNAME, ROLE, STATUS, ID_USER FROM USERS WHERE ID_USER = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function searchForUsername($username) {
        global $pdo;
        $sql = "SELECT * FROM USERS WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function loginInternDB($username, $password) {
        global $pdo;
        $sql = "SELECT * FROM USERS WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['PASSWORD_HASH'])) {
            echo "Usuario verificado";
            return $user;
        } else {
            return false;
        }
    }

    public static function loginExternDB($username, $password) {
        global $pdo;
        $sql = "SELECT * FROM USERS WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['PASSWORD_HASH'])) {
            return $user;
        } else {
            return false;
        }
    }

    public static function createUser($username, $password, $role) {

        var_dump($username, $password, $role);
        
        global $pdo;
        $sql = "INSERT INTO USERS (USERNAME, PASSWORD_HASH, ROLE) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username, password_hash($password, PASSWORD_BCRYPT), $role]);
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }


}