<?php

/**
 * Created by PhpStorm.
 * User: dell
 * Date: 28/02/2019
 * Time: 04:47 م
 */
class Tree
{

    private $con;

    public function __construct()
    {
        $this->Connectdatabase();
    }

    function Connectdatabase()
    {
        $this->con = mysqli_connect("localhost", "root", "", "task");
        // Check connection
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        mysqli_query($this->con,"SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

    }


    public function Createchild($name,$title,$parnet_id){
        $sql=" INSERT INTO `items`(`name`, `title`, `parent_id`) VALUES ('$name','$title',$parnet_id) ";

        if (mysqli_query($this->con, $sql)) {

            return true;
        } else {

            return false;
        }
    }

    public function getdata_all(){
        $query = "SELECT * FROM `items` ";

        if ($result = mysqli_query($this->con, $query)) {
            // Fetch one and one row

            $i = 0;
            $getcustomercodes = NULL;

            while ($row = mysqli_fetch_row($result)) {

                for ($j = 0; $j < 3; $j++) {
                    $getcustomercodes[$i][$j] = $row[$j];
                }
                $i++;

            }
            // Free result set
            mysqli_free_result($result);

            return $getcustomercodes;
        }
    }

    public function intializeItems(){

        $query = "SELECT * FROM `items` ";

        if ($result = mysqli_query($this->con, $query)) {
            // Fetch one and one row

            $i = 0;
            $getcustomercodes = NULL;
            $arrayCategories = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $arrayCategories[$row['id']] = array("parent_id" => $row['parent_id'], "name" =>
                    $row['name']);
            }
            // Free result set
            mysqli_free_result($result);

            return $arrayCategories;
        }
    }

    function createTreeView($array, $currentParent, $currLevel = 0, $prevLevel = -1) {

        foreach ($array as $categoryId => $category) {

            if ($currentParent == $category['parent_id']) {
                if ($currLevel > $prevLevel) echo " <ol class='tree'> ";

                if ($currLevel == $prevLevel) echo " </li> ";

                echo '<li> <label for="subfolder2">'.$category['name'].'<form style="margin-top: 0px;margin-left: 50px;" action="../controller/ControllerTree.php" method="post">
                    <input style="width: 50px;" type="text" name="child">
                    <input type="hidden" name="parent_id" value='.$categoryId.'>
                    <input type="submit" name="submit" class="btn btn-default" value="add">
                     </form>';


                if ($currLevel > $prevLevel) { $prevLevel = $currLevel; }

                $currLevel++;

                $this->createTreeView($array, $categoryId, $currLevel, $prevLevel);

                $currLevel--;
            }

        }

        if ($currLevel == $prevLevel) echo " </li>  </ol> ";

    }


}