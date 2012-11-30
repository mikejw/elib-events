<?php

namespace Empathy\ELib\Mongo;

class Instance
{

    /**
     * The element/field name (transformed to uppercase).
     * @var Mongo
     */
    private $connection;

    /**
     * The mongo database reference array.
     * @var array
     */
    private $db;

    /**
     * The last used mongo cursor object.
     * @var MongoCursor
     */
    private $cursor;


    /**
     * Connects to a mongo database.
     */
    public function __construct(
        $user=ELIB_DB_USER,
        $pass=ELIB_DB_PASS,
        $host=ELIB_DB_HOST,
        $db=ELIB_DB_NAME)
    {
        $this->connection = new \Mongo("mongodb://${user}:${pass}@${host}");
        $this->selectDB($db);
    }


    /**
     * Select mongo database.
     * @param string
     */
    private function selectDB($db_name)
    {
        $this->db = $this->connection->$db_name;
    }


    /**
     * Get all data from a collection.
     * @return array
     */
    public function getAllData($collection, $cursor=null)
    {
        $data = array();

        if ($cursor !== null) {
            $this->cursor = $cursor;
        } else {
            $c = $this->db->$collection;
            $this->cursor = $c->find();
        }

        return(iterator_to_array($this->cursor));
    }

    public function getCollection($name)
    {
        return $this->db->$name;
    }
}
