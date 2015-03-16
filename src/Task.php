<?php
class Task
{
    private $description;
    private $id;

    function __construct($description, $id = null)
    {
        $this->description = $description;
        $this->id = $id;
    }

    function setDescription($new_description)
    {
        $this->description = (string)$new_description;
    }

    function getDescription()
    {
        return $this->description;
    }

    function getId()
    {
        return $this->id;
    }

    function setId($new_id)
    {
        $this->id = (int)$new_id;
    }


    function save()
    {
        //array_push($_SESSION['list_of_tasks'], $this);
        $statement = $GLOBALS['DB']->exec("INSERT INTO tasks (description) VALUES ('{$this->getDescription()}') RETURNING id;");
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $this->setId($result['id']);
    }

    static function getAll(){
        //return $_SESSION['list_of_tasks'];
        $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
        $tasks = array();
        foreach($returned_tasks as $task)
        {
            $description = $task['description'];
            $id = $task['id'];
            $new_task = new Task($description. $id);
            array_push($tasks, $new_task);

        }
        return $tasks;
    }
    static function find($search_id)
    {
        $found_task = null;
        $tasks = Task::getAll();

    }

    static function deleteAll(){
         //$_SESSION['list_of_tasks'] = array();
         $GLOBALS['DB']->exec("DELETE FROM tasks *;");

    }

}

?>
