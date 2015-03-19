<?php

class Cuisine
{
    private $id;
    private $type;

    function __construct($type,$id = null)
    {
        $this->type = $type;
        $this->id = $id;
    }

    function setType($new_type)
    {    $this->type = (string) $new_type;

    }

    function getType()
    {
        return $this->type;
    }

    function setId($new_id)
    {
        $this->id = (int) $new_id;
    }

    function getId()
    {
        return $this->id;
    }

     function save()
    {
        $statement= $GLOBALS['DB']->query("INSERT INTO  cuisine (type) VALUES ('{$this->getType()}')RETURNING id; ");

        $result=$statement->fetch(PDO::FETCH_ASSOC);
        $this->setId($result['id']);

    }
    static function getAll(){
        $returned_cuisine= $GLOBALS['DB']->query("SELECT * FROM cuisine;");

        $cuisines=array();

        foreach($returned_cuisine as $cuisine){

            $id=$cuisine['id'];
            $type=$cuisine['type'];
            $new_cuisine= new Cuisine ($type,$id);
            array_push ($cuisines,$new_cuisine);

        }

        return $cuisines;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM cuisine *;");
    }

    static function find($search_id)
    {
        $found_cuisine = null;
        $cuisines = Cuisine::getAll();
        foreach($cuisines as $food) {
            $cuisine_id = $food->getId();
            if ($cuisine_id == $search_id) {
                $found_cuisine = $food;
            }

        }
        return $found_cuisine;
    }

    function getRestaurants()
        {
            $restaurants = Array();
            $returned_restaurants= $GLOBALS['DB']->query("SELECT * FROM restaurants WHERE cuisine_id = {$this->getId()};");
            foreach($returned_restaurants as $restaurant) {
                $name = $restaurant['name'];
                $id = $restaurant['id'];
                $address = $restaurant['address'];
                $cuisine_id = $restaurant['cuisine_id'];
                $new_Restaurant = new Restaurant($id, $name, $address, $cuisine_id);
                array_push($restaurants, $new_Restaurant);
            }
            return $restaurants;
        }

}
?>
