<?php
/**
 * Created by PhpStorm.
 * User: vicki
 * Date: 16/02/2017
 * Time
/* initialize Propel, etc. */

require_once(dirname(__DIR__, 1) . "/global_init.php");
require_once(dirname(__DIR__, 1) . "/helper/su17_func.php");
require_once(dirname(__DIR__, 1) . "/helper/DbTask.class.php");
echo "Hello World!";
$all = ! isset($_GET['type']);

function createPostal($col, $con = null){
    PostalQuery::create()->deleteAll($con);
    $posts = new Propel\Runtime\Collection\ObjectCollection();
    $posts->setModel('Postal');
    foreach ($col as $key => $value) {
        //echo $key . ' : ' . $value;
        //echo '<br>';
        $p = new Postal();
        $p->setPostcode((int)$key);
        $p->setCity($value);
        //echo 'object => ' . $p->getPostcode() . ' : ' . $p->getCity();
        //echo '<br>';
        $posts->append($p);
    }
    //$posts->save($con);
    return $posts;
}
$obj=null;
if($all || $_GET['type']=='postal') {

    $str = file_get_contents('postal.json');
    $json = json_decode($str, true);

    $obj = createPostal($json);
    if ($obj != null && $obj->count() > 0) {

       // $con = Propel\Runtime\Propel::getWriteConnection(\Map\UserTableMap::DATABASE_NAME);
        //$con->beginTransaction();

        try {
            // set Validated = true
            $obj->save();

            //$con->commit();

        } catch (Exception $e) {
           // $con->rollback();
            echo "<html><body></html><br><h1>Error!";
            echo "Transaction was rolled back.</h1>";
            echo "<br>Propel is so easy!</body></html>";
        }

    }

    echo "<html><body></html><br><h1>All done!";
    echo "<br>" .$obj->count() . " rows were inserted.</h1>";
    echo "<br>Propel is so easy!</body></html>";

    exit();
}




