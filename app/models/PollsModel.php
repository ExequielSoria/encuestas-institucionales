<?php

require_once './db/internDB.php';

//Clase encargada de la gestion de las encuestas en la base de datos
class PollsModel {

    public function getLastestPollsAdmin($pollsCount){
            global $pdo;
        $sql = "SELECT * FROM POLLS ORDER BY ID_POLL DESC limit 6;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pollsCount]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserPolls($userId) {
        global $pdo;
        $sql = "SELECT * FROM POLLS WHERE ID_USER = ? ORDER BY ID_POLL DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function howManyPolls(){
        global $pdo;
        $sql = "SELECT COUNT(*) FROM POLLS";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getPollById($id){
        global $pdo;
        $sql = "SELECT * FROM POLLS WHERE ID_POLL = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function createPoll($data) {
        //echo "Creando encuesta...";
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

    public static function createCandidate($candidateData) {
        //echo "Creando Candidato...";
        global $pdo;


        // Preparo la sentencia sql
        $sql = "INSERT INTO CANDIDATES (NAME_CANDIDATE, INFO_CANDIDATE, ID_POLL, AGE_CANDIDATE, CAREER_CANDIDATE) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        // Ejecuto con la data proporcionada
        $stmt->execute([
            $candidateData['candidateName'],
            $candidateData['candidateInfo'],
            $candidateData['idPoll'],
            $candidateData['candidateAge'],
            $candidateData['candidateCareer']
        ]);

        return $pdo->lastInsertId();

    }


    public static function createOption($data) {
        //echo "Creando encuesta...";
        global $pdo;

        // Preparo la sentencia sql
        $sql = "INSERT INTO OPTIONS (TITLE_OPTION, INFO_OPTION, ID_POLL) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        // Ejecuto con la data proporcionada
        $stmt->execute([
            $data['optionTitle'],
            $data['optionInfo'],
            $data['idPoll']
        ]);

        return $pdo->lastInsertId();

    }

    public function getOptionsByPollId($id){
        global $pdo;
        $sql = "SELECT * FROM OPTIONS WHERE ID_POLL = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCandidatesByPollId($id){
        global $pdo;
        $sql = "SELECT * FROM CANDIDATES WHERE ID_POLL = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}