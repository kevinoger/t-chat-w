<?php 


namespace Model;

use \PDO;
use \W\Model\Model;


class MessagesModel extends Model {
    public function searchAllWithUserinfo($idSalon) {
        $query = "SELECT * FROM $this->table"
            . " JOIN utilisateurs ON $this->table.id_utilisateur = utilisateurs.id"
            . " WHERE id_salon = :id_salon";
        
        $stmt = $this->dbh->prepare($query);
        $stmt->bindParam(':id_salon', $idSalon, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}