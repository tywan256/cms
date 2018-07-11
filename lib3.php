<?php

    require_once('dbconfig.php');

    /*
         * Check if User is logged in
         *
         */

        function isUserLoggedIn(){
                $status = false;
        if(isset($_SESSION['userSession'])){
            $status = true;
        }
        return $status;
        }
/*
         * Check if User is logged out
         *
         */
        function logout()
    {
        $_SESSION['userSession'] = null;
        session_destroy();
    }

    /*
     * Check if user is logged in
     *
     */

    function getSearchedAssets($phrase){


            $datarow = NULL;
            try
            {
                $db = new Database();
                $db->connect();

                $sql = "SELECT assets.id,assets.type,assets.filename,left(from_unixtime(creationDate),10) AS creationDate,GROUP_CONCAT(assets_metadata.data) AS data FROM assets LEFT JOIN assets_metadata ON assets.id=assets_metadata.cid WHERE assets.filename like '%$phrase%' AND assets_metadata.cid=assets.id GROUP BY assets_metadata.cid";

                $params = array(":phrase" => $phrase);
                $results = $db->runSelect($sql,$params);

                if ($results != null){
                    $datarow = $results;
                }
            }
            catch(PDOException $ex) {
                echo $ex->getMessage();
            }
            return $datarow;
    }

 ?>
