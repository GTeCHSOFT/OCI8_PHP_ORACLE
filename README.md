# OCI8_PHP_ORACLE
Fast and simple way to connect,get_data,all query type from Oracle Database using OCI8/PHP from [@GTeCH+](https://github.com/GTeCHSOFT).

## Example:

```php
<?php

require_once 'oracle.php';

  // SELECT => return array of fetched data
  $db = new Oracle();
  $result = $db->query("SELECT * FROM PERSONNELS WHERE MAT = 'Gh1021'");
  echo json_encode($result);
  $db->close();
  
  // INSERT </1> => return true or false
  $db = new Oracle();
  $result = $db->query("INSERT INTO PERSONNELS VALUES('Val1','Val2','Val3')");
  echo json_encode($result);
  $db->close();
  
  // INSERT </2> => return true or false
  $db = new Oracle();
  $result = $db->query("INSERT INTO PERSONNELS VALUES(':v1',':v2',':v3')",['Val1','Val2','Val3']);
  echo json_encode($result);
  $db->close();
  
  // UPDATE AND DELETE like INSERT STATEMENT
```

## License
OCI8_PHP_ORACLE is [MTI Licensed](https://github.com/GTeCHSOFT/OCI8_PHP_ORACLE/blob/master/LICENSE).
