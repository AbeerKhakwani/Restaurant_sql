<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Cuisine.php";

     $DB = new PDO('pgsql:host=localhost;dbname=restaurant');

    class CuisineTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
          Cuisine::deleteAll();
        }


        function test_getType()
        {
            //Arrange
            $type = "Italian";
            $id = null;
            $test_Cuisine = new Cuisine($type,$id);

            //Act
            $result = $test_Cuisine->getType();

            //Assert
            $this->assertEquals($type, $result);
        }

        function test_setType()
        {
            //Arrange
            $type = "Italian";
            $id = null;
            $test_Cuisine = new Cuisine($type, $id);

            //Act
            $test_Cuisine->setType("American");

            //Assert
            $result = $test_Cuisine->getType();
            $this->assertEquals("American", $result);

        }

        function test_getId()
        {
            //Arrange
            $type = "Italian";
            $id = 1;
            $test_id = new Cuisine($type, $id);

            //Act
            $result = $test_id->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //Arrange
            $type = "Italian";
            $id = null;
            $test_id = new Cuisine($type, $id);

            //Act
            $test_id->setId(1);

            //Assert
            $result = $test_id->getId();
            $this->assertEquals(1, $result);
        }


        function test_save(){
            //Arrange
            $type = "Italian";
            $id = null;
            $test_cuisine = new Cuisine($type, $id);

            //Act
            $test_cuisine->save();
            $result = Cuisine::getAll();




            $this->assertEquals($test_cuisine, $result[0]);




        }


        function test_getAll()  // instantiates two new instances of Category, calls the getAll method and checks to be sure the objects entered match those in getAll
        {
            //Arrange
            $name = "Work stuff";
            $id = null;
            $name2 = "Home stuff";
            $id2 = null;
            $test_Cuisine = new Cuisine($name, $id);
            $test_Cuisine->save();
            $test_Cuisine2 = new Cuisine($name2, $id2);
            $test_Cuisine2->save();
            //Act
            $result = Cuisine::getAll();
            //Assert
            $this->assertEquals([$test_Cuisine, $test_Cuisine2], $result);
        }



        function test_find() //Adds and saves new categories.  Then calls the find method on Category (by calling the getId method on the first Category object) and    stores it in the variable $result.  Compares with inital instance of the Category ($test_Category)
               {
                   //Arrange
                   $name = "american";
                   $id = null;
                   $name2 = "italian";
                   $id2 = 2;

                   $test_cuisine = new Cuisine($name, $id);
                   $test_cuisine->save();
                   $test_cuisine2 = new Cuisine($name2, $id2);
                  $test_cuisine2->save();
                   //Act
                   $id_to_find=$test_cuisine2->getId();
                   $result = Cuisine::find($id_to_find);

                   //Assert
                   $this->assertEquals($test_cuisine2, $result);
               }


               function testGetRestaurants(){
                 //Arrange
                 $name = "Work stuff";
                 $id = null;
                 $test_cuisine= new Cuisine($name, $id);
                 $test_cuisine->save();

                 $cuisine_id = $test_cuisine->getId();
                 $name = "Email client";
                 $address = "main street";
                 $test_restaurant = new Restaurant($id, $name, $address, $cuisine_id);
                 $test_restaurant->save();

                 $name2 = "Meet with boss";
                 $address2 = "main stress";
                 $test_restaurant2 = new Restaurant($id, $name2, $address2, $cuisine_id);
                 $test_restaurant2->save();

                 //Act
                 $result = $test_cuisine->getRestaurants();

                 //Assert
                 $this->assertEquals([$test_restaurant, $test_restaurant2], $result);
             }

                 function testUpdate()
                {
                    //Arrange
                    $type = "Work stuff";
                    $id = 1;
                    $test_cuisine = new Cuisine($type, $id);
                    $test_cuisine->save();

                    $new_type = "Home stuff";

                    //Act
                    $test_cuisine->update($new_type);

                    //Assert
                    $this->assertEquals("Home stuff", $test_cuisine->getType());
                }






    }
?>
