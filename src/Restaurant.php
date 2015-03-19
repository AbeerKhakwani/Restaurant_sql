<?php
class Restaurant
{
    private $id;
    private $name;
    private $address;
    private $cuisine_id;
    function __construct($id = null, $name, $address, $cuisine_id)
    {
        $this->id         = $id;
        $this->name       = $name;
        $this->address    = $address;
        $this->cuisine_id = $cuisine_id;
    }
    function getId()
    {
        return $this->id;
    }
    function setId($new_id)
    {
        $this->id = (int) $new_id;
    }
    function getName()
    {
        return $this->name;
    }
    function setName($new_name)
    {
        $this->name = (string) $new_name;
    }
    function getAddress()
    {
        return $this->address;
    }
    function setAddress($new_address)
    {
        $this->address = (string) $new_addresss;
    }
    function setCuisineId($new_cuisineId)
    {
        $this->cuisine_Id = (int) $new_cuisineId;
    }
    function getCuisineId()
    {
        return $this->cuisine_id;
    }
    function save()
    {
        $statement = $GLOBALS['DB']->query("INSERT INTO restaurants (name, cuisine_id, address) VALUES ('{$this->getName()}', {$this->getCuisineId()}, '{$this->getAddress()}') RETURNING id;");
        // $statement= $GLOBALS['DB']->query("INSERT INTO restaurants (name, address, cuisine_id) VALUES
        // ('{$this->getName()}', {$this->getCuisineId()}, '{$this->getAddress()}') RETURNING id;");
        $result    = $statement->fetch(PDO::FETCH_ASSOC);
        $this->setId($result['id']);
    }
    
    static function getAll()
    {
        $result_food = $GLOBALS['DB']->query("SELECT * FROM restaurants;");
        $foods       = array();
        foreach ($result_food as $food) {
            $id         = $food['id'];
            $name       = $food['name'];
            $address    = $food['address'];
            $cuisine_id = $food['cuisine_id'];
            $new_food   = new Restaurant($id, $name, $address, $cuisine_id);
            array_push($foods, $new_food);
        }
        return $foods;
    }
    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM restaurants *;");
    }
    static function find($id_search)
    {
        $found_id = null;
        $ids      = Restaurant::getAll();
        foreach ($ids as $id) {
            $rest_id = $id->getId();
            if ($rest_id == $id_search) {
                $found_id = $id;
            }
        }
        return $found_id;
    }
}
?>
