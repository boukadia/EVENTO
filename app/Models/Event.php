<?php

namespace App\Models;

use App\Core\AuthService;
use App\Core\Database;

class Event extends Model
{
    protected $table = "events";

    public function getAll()
    {
        $query = "SELECT E.*, V.ville, C.name FROM events AS E JOIN users AS U ON U.id = E.organizer_id JOIN ville AS V ON V.id = E.villes_id JOIN categories AS C ON C.id = E.category_id WHERE E.status = 'approved'";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getLastTeenEvents()
    {
        $query = "SELECT E.*, V.ville, C.name FROM events AS E 
                  JOIN users AS U ON U.id = E.organizer_id 
                  JOIN ville AS V ON V.id = E.villes_id 
                  JOIN categories AS C ON C.id = E.category_id 
                  WHERE E.status = 'approved' 
                  ORDER BY E.created_at DESC 
                  LIMIT 6";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getLastFiveEvents()
    {
        $query = "SELECT E.*, V.ville, C.name FROM events AS E 
                  JOIN users AS U ON U.id = E.organizer_id 
                  JOIN ville AS V ON V.id = E.villes_id 
                  JOIN categories AS C ON C.id = E.category_id 
                  WHERE E.status = 'approved' 
                  ORDER BY E.created_at DESC 
                  LIMIT 5";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getWidthOrganisateur()
    {
        $userData = AuthService::isAuthenticated();

        $query = "SELECT E.*, V.ville, C.name FROM events AS E JOIN users AS U ON U.id = E.organizer_id JOIN ville AS V ON V.id = E.villes_id JOIN categories AS C ON C.id = E.category_id WHERE E.organizer_id =" . $userData['userid'];
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function create(array $request)
    {
        try {
            parent::create($request);

            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
