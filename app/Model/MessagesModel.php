<?php


namespace Model;

use \PDO;
use \W\Model\Model;

/**
 * Description of MessagesModel
 *
 * @author Admin
 */
class MessagesModel extends Model {
	
	/**
	 * Cette fonction sélectionne tous les messages d'un salon en les associant
	 * avec les infos de leur utilisateur respectif
	 * @param int $idSalon l'id du salon dont on souhaite récupérer les messages
	 * @return array la liste des messages avec les infos utilisateur
	 */
	public function searchAllWithUserInfos($idSalon) {
		$query = "SELECT * FROM $this->table"
				. " JOIN utilisateurs ON $this->table.id_utilisateur = utilisateurs.id"
				. " WHERE id_salon = :id_salon";
		
		$stmt = $this->dbh->prepare($query);
		$stmt->bindParam(':id_salon', $idSalon, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}
