<?php
namespace Repositories;

use Config\Database as ConfigDatabase;
use Database\Database;

abstract class Repository {
    protected $db;

    public function __construct()
    {
        $this->db = ConfigDatabase::getInstance()->getConnection();
    }
    public function beginTransaction() {
        $this->db->beginTransaction();
    }

    public function commit() {
        $this->db->commit();
    }

    public function rollback(){
        if($this->db->inTransaction())
            $this->db->rollBack();
    }
}