<?php

require_once './db/internDB.php';

//Clase encargada de la gestion de las encuestas en la base de datos
class PollsModel {

    public static function createPoll($data) {
        var_dump($data);
        echo "Creando encuesta...";
        global $pdo;

        // Preparo la sentencia sql
        $sql = "INSERT INTO POLLS (TITLE, DESCRIPTION, START_DATE, END_DATE, VISIBILITY, COLOUR, ID_USER, MULTIPLE_CHOICE, CAREERS, YEARS) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        // Ejecuto con la data proporcionada
        $stmt->execute([
            $data['title'],
            $data['description'],
            $data['startDate'],
            $data['endDate'],
            $data['visibility'],
            $data['colour'],
            $_SESSION['id'],
            $data['multipleChoice'],
            $data['careers'],
            $data['years']
        ]);

        return $pdo->lastInsertId();

    }
}