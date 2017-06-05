<?php
namespace Core\Database;

class Database
{
    private $db;

    function __construct()
    {
        $this->db = Connection::getInstance();

        if (substr(strtolower(get_called_class()), 0, 8 ) === "entities") {
            $this->table = substr(strtolower(get_called_class()), strrpos(strtolower(get_called_class()), '\\') + 1);

            $objectVars = get_class_vars(get_called_class());
            $sqlVars = get_class_vars(get_class());
            $this->columns = array_diff_key($objectVars, $sqlVars);
        }
    }

    /**
     * @param array $donnees
     */
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set'.ucfirst($key);

            if (substr($method, strrpos($method, '_') + 1) === "second") {
                $new_method = substr($method, 0, strpos($method, "_"));
                $this->$new_method($value);
            } elseif (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }


    /**
     * Save an entity.
     */
    public function save()
    {
        if( $this->id == -1) {
            unset($this->columns['id']);

            $sqlCol = null;
            $sqlKey = null;

            foreach ($this->columns as $column => $value) {
                $data[$column] = $this->$column;
                $sqlCol .= ",". $column;
                $sqlKey .= ",:". $column;
            }
            $sqlCol = ltrim($sqlCol, ",");
            $sqlKey = ltrim($sqlKey, ",");

            $query = $this->db->prepare("INSERT INTO ". $this->table .
                " (" . $sqlCol." )
					VALUES
					(".$sqlKey.");"
            );

            $query->execute($data);

        } else {
            $sqlSet = null;
            foreach ($this->columns as $column => $value) {
                $data[$column] = $this->$column;
                $sqlSet[]= $column ."=:". $column;
            }

            $query = $this->db->prepare("UPDATE ". $this->table .
                " SET date_updated = sysdate(), ".implode(",",$sqlSet).
                " WHERE id=:id;"
            );

            $query->execute($data);
        }
        $this->populate($data);
    }

    /**
     * @param array $search
     * @return mixed
     */
    public function populate($search = ["id" => 1] )
    {
        $query = $this->getOneBy($search, true);
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->table);
        $object = $query->fetch();

        return $object;
    }

    /**
     * @param array $search
     * @param bool $returnQuery
     * @return mixed|PDOStatement
     */
    public function getOneBy($search = [], $returnQuery = false)
    {
        foreach ($search as $key => $value) {
            $where[] = $key.'=:'.$key;
        }

        $query = $this->db->prepare("SELECT * FROM ".$this->table." WHERE ".implode(" AND ", $where));

        $query->execute($search);

        if($returnQuery) {
            return $query;
        }

        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    public function isUnique($value, $col, $entity)
    {
        $query = $this->db->prepare("SELECT 1 FROM ".$entity." WHERE ".$col."='".$value."'");
        $query->execute();

        if ($query->rowCount() >= 1) {
            return false;
        }

        return true;
    }
}