<?php
define( 'DB_HOST', 'localhost' ); // set database host
define( 'DB_NAME', 'GTeCH_DB' ); // set database name
 class Oracle {

    private $con ;

    public function __construct($param = null){
        $db = "(DESCRIPTION =(ADDRESS = (PROTOCOL = TCP)(HOST = ".DB_HOST.")(PORT = 1521))(CONNECT_DATA =(SERVER = DEDICATED)(SERVICE_NAME = ".DB_NAME.")))";
        if(strtolower($param) == null){ //Default connection
            $this->con = oci_connect('system', 'manager', $db,'UTF8'); 
        }elseif(strtolower($param) == "database2"){ // connection to another database
            $this->con = oci_connect('dbuser', 'dbuserpass', $db,'UTF8'); 
        }      
        if (!$this->con){
            die("Database Connection Failed" . oci_error($this->con));
        }
    }

    /**
    * query {SELECT,DELETE,UPDATE,INSERT} Database connection
    *
    * @access public
    * @param string
    * @param array
    * @return string
    * @return bool
    * @return array
    */
    public function query($query,$parameters=[]){
        $req = oci_parse($this->con,$query) or die(oci_error());
        if (count($parameters) == 0){
            if(strtolower(substr($query, 0, 6)) !== "select"){
                $data = oci_execute($req , OCI_NO_AUTO_COMMIT) or die(oci_error());
            }else{
                oci_execute($req , OCI_NO_AUTO_COMMIT) or die(oci_error());
                oci_fetch_all($req,$data);
            }
            oci_free_statement($req);
            return $data;
        }else{
            $i = 0;
            foreach ($parameters as &$value) {
                $i += 1;
                oci_bind_by_name($req, ":v".$i, $value);
            }
            if(strtolower(substr($query, 0, 6)) !== "select"){
                $data = oci_execute($req , OCI_NO_AUTO_COMMIT) or die(oci_error());
            }else{
                oci_execute($req , OCI_NO_AUTO_COMMIT) or die(oci_error());
                oci_fetch_all($req,$data);
            }
            oci_free_statement($req);
            return $data;
        }
    }


    /**
    * Commit Database connection
    *
    * @access public
    * @return bool
    */
    public function commit(){
        return oci_commit($this->con);
    }


    /**
    * rollback Database connection
    *
    * @access public
    * @return bool
    */
    public function rollback(){
        return oci_rollback($this->con);
    }

    /**
    * Close Database connection
    *
    * @access public
    * @param boolean $auto_commit default true
    * @return bool
    */
    public function close($auto_commit = true){
        if($auto_commit){
            oci_commit($this->con);
        }
        return oci_close($this->con);
    }
}
?>
