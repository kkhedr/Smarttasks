<?php


if($_POST) {

    if (isset($_POST['submit']) AND $_POST['submit'] == "Additem") {
        $name = $_POST['name'];
        $title = $_POST['title'];
        $parent_id = $_POST['parent_id'];

        if(empty($parent_id)){
            $parent_id = 0;
        }

        require_once ('../model/Tree.php');
        $tree=new Tree();
        $tree->Createchild($name,$title,$parent_id);

        require_once ('../view/index.php');


    }else if(isset($_POST['submit']) AND $_POST['submit'] == "add") {
        $name = $_POST['child'];
        $parent_id = $_POST['parent_id'];

        require_once ('../model/Tree.php');
        $tree=new Tree();
        $tree->Createchild($name," ",$parent_id);
        require_once ('../view/index.php');
    }
}else{
    require_once ('../view/index.php');
}