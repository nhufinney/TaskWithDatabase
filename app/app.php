<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Task.php";


    $app = new Silex\Application();

    //check the route of local host. It is in Guest.
    $DB = new PDO('pgsql:host=localhost;dbname=to_do');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app){
            return $app['twig']->render('tasks.twig', array('tasks' => Task::getAll()));

    });


    $app->post("/tasks", function() use ($app){
        $task = new Task($_POST['description']);
        $task->save();
        return $app['twig']->render('create_task.twig', array('newtask' => $task));
    });

     $app->post("/delete_tasks", function() use ($app){

         Task::deleteAll();
         return $app['twig']->render('delete_tasks.twig');
     });

    return $app;

?>
