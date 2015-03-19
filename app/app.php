<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Cuisine.php";
    require_once __DIR__."/../src/Restaurant.php";

    $app = new Silex\Application();

    $app['debug'] = true;

    $DB = new PDO('pgsql:host=localhost;dbname=restaurant');


    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //Takes us to the main page, shows us the listings of cuisines. Gives a form to list more cuisines.
    $app->get("/", function() use ($app) {
    return $app['twig']->render('index.twig', array('cuisines' => Cuisine::getAll()));
});

    //Allows us to enter the cuisine type, saves, returns the type onto the same page.
    $app->post("/", function() use ($app) {
        $new_cuisine=new Cuisine($_POST['type']);
        $new_cuisine->save();
        return $app['twig']->render('index.twig', array('cuisines' => Cuisine::getAll()));
    });


    //So this takes an id that we pass to it and puts it into the find method which searchs through all the cusine objects  and if the id we pass matches the id of an object it returns it.
    $app->get("/cuisine/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine.twig', array('cuisines' => $cuisine, 'restaurants'=>$cuisine->getRestaurants()));
    });
    //Will replace old cuisine type into the new cuisine type
    $app->patch("/cuisine/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        $type= $_POST['type'];
        $cuisine->update($type);

        return $app['twig']->render('cuisine.twig', array('cuisines' => $cuisine,'restaurants'=>$cuisine->getRestaurants()));
    });
    //Will go to edit page to enter the new cuisine type
    $app->post("/cuisine/{id}/edit", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        return $app['twig']->render('cuisine_edit.twig', array('cuisines' => $cuisine, 'restaurants'=>$cuisine->getRestaurants()));
    });


    //Will assign the cuisine id to restaurant name and address
    $app->post("/cuisine/{id}", function($id) use ($app) {
       $cuisine = Cuisine::find($id);
        $new_name_restaurant = $_POST['name'];
        $new_address_restaurant = $_POST['address'];
        $new_cuisine_id_restaurant = $_POST['cuisine_id'];
        $new_restaurant = new Restaurant(null,$new_name_restaurant,$new_address_restaurant,$new_cuisine_id_restaurant);
        $new_restaurant->save();
        return $app['twig']->render('cuisine.twig', array('cuisines' => $cuisine,'restaurants'=>$cuisine->getRestaurants()));
    });

    //Will delete listings of cuisine types from the main page
    $app->post("/delete_cuisines", function() use ($app){
            Cuisine::deleteAll();
            return $app['twig']->render('/index.twig', array('cuisines' => Cuisine::getAll()));
        });

        //Will delete listings with names and addresses from the restaurant page.
    $app->post("/delete_restaurants/{id}", function($id) use ($app){
        $cuisine = Cuisine::find($id);
        Restaurant::deleteAll();
        return $app['twig']->render('cuisine.twig', array('cuisines' => $cuisine,'restaurants'=>$cuisine->getRestaurants()));
        });

    $app->delete("/cuisine/{id}", function($id) use ($app) {
        $cuisine = Cuisine::find($id);
        $cuisine->delete();
        return $app['twig']->render('index.twig', array('cuisines' => Cuisine::getAll()));
    });


        return $app;

?>
