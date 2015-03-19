<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Restaurant.php";
    require_once "src/Cuisine.php";

     $DB = new PDO('pgsql:host=localhost;dbname=restaurant');

    class RestaurantTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          Restaurant::deleteAll();
          Cuisine::deleteAll();
        }



        function test_getName()
        {
            //Arrange
            $name="Work Stuff";
            $id= null;
            $test_cuisine = new Cuisine($name, $id);
            $test_cuisine->save();
            $cuisine_id= $test_cuisine->getId();
            $name = "Olive Garden";
            $address = "Main Street";
            $test_restaurant = new Restaurant($id, $name,  $address, $cuisine_id);
            $test_restaurant->save();
            //Act
            $result = $test_restaurant->getName();
            //Assert
            $this->assertEquals($name, $result);
        }

        function test_save(){
            //Arrange
            $type="American";
            $id=null;
            $new_cuisine= new Cuisine($type,$id);
            $new_cuisine->save();
            $cuisine_id=$new_cuisine->getId();



            $name = "Olive Garden";
            $address = "Main Street";
            $test_restaurant = new Restaurant($id, $name,  $address, $cuisine_id);

            //Act
            $test_restaurant->save();
            $result = Restaurant::getAll();



            //Assert
            $this->assertEquals($test_restaurant, $result[0]);




        }

        function test_getAll()
        {   //Arrange
            $type="American";
            $id=null;
            $new_cuisine= new Cuisine($type,$id);
            $new_cuisine->save();
            $cuisine_id=$new_cuisine->getId();

            $name = "Olive Garden";
            $address = "Main Street";
            $test_restaurant = new Restaurant($id, $name,  $address, $cuisine_id);
            $test_restaurant->save();

            $name2 = "Burgerville";
            $address2 = "Hi Street";
            $test_restaurant2 = new Restaurant($id, $name2,  $address2, $cuisine_id);
            $test_restaurant2->save();

            //Act
             $result = Restaurant::getAll();

            //Assert
             $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
        }

        function test_find()
            {
                //Arrange
                $type="American";
                $id=null;
                $new_cuisine= new Cuisine($type,$id);
                $new_cuisine->save();
                $cuisine_id=$new_cuisine->getId();


                 $name = "Olive Garden";
                 $address = "Main Street";
                 $test_restaurant = new Restaurant($id, $name,  $address, $cuisine_id);
                 $test_restaurant->save();

                 $name2 = "Burgerville";
                 $address2 = "Hi Street";
                 $test_restaurant2 = new Restaurant($id, $name2,  $address2, $cuisine_id);
                 $test_restaurant2->save();

                //Act
                 $result= Restaurant::find($test_restaurant->getId());

                //Assert
                 $this->assertEquals($test_restaurant,$result);
        }



}
?>
