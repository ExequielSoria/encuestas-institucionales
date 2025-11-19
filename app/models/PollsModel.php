<?php

require_once './db/internDB.php';

//Clase encargada de la gestion de las encuestas en la base de datos
class PollsModel {

    public function isPollAvailable($pollId){
        global $pdo;
        $sql = "SELECT STATUS FROM POLLS WHERE ID_POLL = ? LIMIT 1;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$pollId]);
        $status = $stmt->fetchColumn();
        return $status;
    }

    public static function votesCountCandidate($idCandidate) {
    global $pdo;

    $sql = "SELECT COUNT(*) as total FROM VOTES 
            WHERE ID_CANDIDATE = ? AND STATUS = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idCandidate]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ? $row['total'] : 0;
}


public static function votesCountOption($idOption) {
    global $pdo;

    $sql = "SELECT COUNT(*) as total FROM VOTES 
            WHERE ID_OPTION = ? AND STATUS = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idOption]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ? $row['total'] : 0;
}

public static function publicVotesCandidate($idCandidate) {
    global $pdo;

    $sql = "SELECT USERNAME FROM VOTES WHERE ID_CANDIDATE = ? AND STATUS = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idCandidate]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public static function publicVotesOption($idOption) {
    global $pdo;

    $sql = "SELECT USERNAME FROM VOTES WHERE ID_OPTION = ? AND STATUS = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$idOption]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}



    public static function didUserVote($user,$pollId){
        global $pdo;

        //var_dump( $pollId );

        //Actualizo el STATE de 1 a 0
        $sql = "SELECT COUNT(*) FROM VOTES WHERE USER_IDENTIFIER = ? AND ID_POLL = ? AND STATUS !='0';";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user,$pollId]);
        return $stmt->fetchColumn() > 0;
    }

    public static function registVotes(array $votes) {

        //var_dump($votes);

        global $pdo;
        
        if (empty($votes)) {
            echo "<script>alert('No se enviaron votos');</script>";
            echo "<script>window.location.href='?controller=views&action=home';</script>";
        }
        
        $userId = $votes[0]['USER_IDENTIFIER'];
        $pollId = $votes[0]['ID_POLL'];

        // Verificar si ya votó en esa encuesta
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM VOTES
            WHERE USER_IDENTIFIER = :userId AND ID_POLL = :pollId AND STATUS = 1
        ");
        $stmt->execute([
            ':userId' => $userId,
            ':pollId' => $pollId
        ]);

        if ($stmt->fetchColumn() > 0) {
            echo "<script>alert('Ya se registra un voto en la encuesta');</script>";
            echo "<script>window.location.href='?controller=views&action=home';</script>";
            return false;

        }

        // Insertar los votos
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("
            INSERT INTO VOTES (ID_POLL, ID_CANDIDATE, ID_OPTION, USER_IDENTIFIER, STATUS, USERNAME)
            VALUES (:ID_POLL, :ID_CANDIDATE, :ID_OPTION, :USER_IDENTIFIER, :STATUS, :USERNAME)
        ");

        foreach ($votes as $vote) {
            $stmt->execute([
                ':ID_POLL' => $vote['ID_POLL'],
                ':ID_CANDIDATE' => $vote['ID_CANDIDATE'],
                ':ID_OPTION' => $vote['ID_OPTION'],
                ':USER_IDENTIFIER' => $vote['USER_IDENTIFIER'],
                ':STATUS' => $vote['STATUS'],
                ':USERNAME' => $vote['USERNAME']
            ]);
        }

        $pdo->commit();
        return $stmt;
    }


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

    public function getLastestPollsVoter($pollsCount,$data){
        global $pdo;

        //var_dump( $data );

        $career = $data['career'];
        $year = $data['year'];
        //Me aseguro que sea int la cantidad de encuestas a traer
        $pollsCount = (int)$pollsCount;

        $sql = "
        SELECT * FROM POLLS 
        WHERE STATUS != 0 AND STATUS !=2
        ORDER BY ID_POLL DESC 
        LIMIT $pollsCount;
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([$career,$year]);
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