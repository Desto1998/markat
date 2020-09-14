<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-05-17 12:42:50 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-17 12:42:52 --> Severity: Notice --> Undefined offset: 13 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-17 12:42:52 --> Severity: Notice --> Undefined offset: 14 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-17 12:42:52 --> Query error: Column 'strabe' in field list is ambiguous - Invalid query: 
    SELECT SQL_CALC_FOUND_ROWS tblwohnungen.id as id, strabe, belegt, hausnummer, etage, flugel, zimmer, schlaplatze, mobiliert, belegt_v, belegt_b, resttage, mobiliert, tblmieters.vorname as mieter, tblmieters.id as mieter_id ,tblwohnungen.id
    FROM tblwohnungen
    LEFT JOIN tblmieters ON tblwohnungen.mieter = tblmieters.id
    
    
    
    ORDER BY tblwohnungen.id DESC
    LIMIT 0, 25
    
ERROR - 2020-05-17 12:42:52 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /users/vbgenius/www/markat/system/core/Exceptions.php:271) /users/vbgenius/www/markat/system/core/Common.php 564
ERROR - 2020-05-17 12:44:44 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-17 12:44:46 --> Severity: Notice --> Undefined offset: 13 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-17 12:44:46 --> Severity: Notice --> Undefined offset: 14 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-17 12:44:46 --> Query error: Column 'hausnummer' in field list is ambiguous - Invalid query: 
    SELECT SQL_CALC_FOUND_ROWS tblwohnungen.id as id, strabe, belegt, hausnummer, etage, flugel, zimmer, schlaplatze, mobiliert, belegt_v, belegt_b, resttage, mobiliert, tblmieters.vorname as mieter, tblmieters.id as mieter_id ,tblwohnungen.id
    FROM tblwohnungen
    LEFT JOIN tblmieters ON tblwohnungen.mieter = tblmieters.id
    
    
    
    ORDER BY tblwohnungen.id DESC
    LIMIT 0, 25
    
ERROR - 2020-05-17 12:44:46 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /users/vbgenius/www/markat/system/core/Exceptions.php:271) /users/vbgenius/www/markat/system/core/Common.php 564
ERROR - 2020-05-17 12:45:37 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-17 12:45:39 --> Severity: Notice --> Undefined offset: 13 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-17 12:45:39 --> Severity: Notice --> Undefined offset: 14 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
