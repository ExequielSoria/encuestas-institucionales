<?php

require_once './db/internDB.php';

//Clase encargada de la gestion de las encuestas en la base de datos
class PollsModel {

    public function deletePoll($pollId) {
        global $pdo;

        //Actualizo el STATE de 1 a 0
        $sql = "UPDATE POLLS SET STATUS = 0 WHERE ID_POLL = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pollId]);
        return $stmt->rowCount() > 0; // Retorna true si se actualizó al menos una fila

    }

    public function getLastestPolls($pollsCount){
        global $pdo;

        //Me aseguro que sea int la cantidad de encuestas a traer
        $pollsCount = (int)$pollsCount;

        $sql = "SELECT * FROM POLLS WHERE STATUS != 0 ORDER BY ID_POLL DESC limit $pollsCount;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLastestPollsAdmin($pollsCount){
        global $pdo;

        //Me aseguro que sea int
        $pollsCount = (int)$pollsCount;

        $sql = "SELECT * FROM POLLS ORDER BY ID_POLL DESC limit $pollsCount;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserPollsAdmin($userId) {
        global $pdo;
        $sql = "SELECT * FROM POLLS WHERE ID_USER = ? ORDER BY ID_POLL DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    

    public function getUserPolls($userId) {
        global $pdo;
        $sql = "SELECT * FROM POLLS WHERE ID_USER = ? AND STATUS != 0 ORDER BY ID_POLL DESC";
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

public function editPoll($data){

        var_dump($data);
        global $pdo;
        // Preparo la sentencia sql
        $sql = "UPDATE POLLS SET TITLE = ?, DESCRIPTION = ?, START_DATE = ?, END_DATE = ?, VISIBILITY = ?, COLOUR = ?, MULTIPLE_CHOICE = ?, CAREERS = ?, YEARS = ? WHERE ID_POLL = ?";
        $stmt = $pdo->prepare($sql);
        // Ejecuto con la data proporcionada
        $stmt->execute([
            $data['title'],
            $data['description'],
            $data['startDate'],
            $data['endDate'],
            $data['visibility'],
            $data['colour'],
            $data['multipleChoice'],
            $data['careers'],
            $data['years'],
            $data['idPoll']
        ]);
        //Retorno el id de la encuesta editada
        return $data['idPoll'];

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