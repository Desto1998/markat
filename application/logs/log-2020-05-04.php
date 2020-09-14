<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-05-04 18:42:32 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-04 18:42:34 --> Severity: Notice --> Undefined variable: join /users/vbgenius/www/markat/application/views/admin/tables/wohnungen.php 31
ERROR - 2020-05-04 18:42:34 --> Severity: Notice --> Undefined offset: 13 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-04 18:42:34 --> Severity: Warning --> implode() [<a href='http://de.php.net/function.implode'>function.implode</a>]: Invalid arguments passed /users/vbgenius/www/markat/application/helpers/datatables_helper.php 209
ERROR - 2020-05-04 18:42:34 --> Severity: Notice --> Undefined property: App::$db /users/vbgenius/www/markat/application/views/admin/tables/wohnungen.php 83
ERROR - 2020-05-04 18:42:34 --> Severity: error --> Exception: Call to a member function where() on null /users/vbgenius/www/markat/application/views/admin/tables/wohnungen.php 83
ERROR - 2020-05-04 18:42:34 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /users/vbgenius/www/markat/system/core/Exceptions.php:271) /users/vbgenius/www/markat/system/core/Common.php 564
ERROR - 2020-05-04 18:43:22 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-04 18:43:24 --> Severity: Notice --> Undefined offset: 13 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-04 18:43:24 --> Severity: Notice --> Undefined property: App::$db /users/vbgenius/www/markat/application/views/admin/tables/wohnungen.php 83
ERROR - 2020-05-04 18:43:24 --> Severity: error --> Exception: Call to a member function where() on null /users/vbgenius/www/markat/application/views/admin/tables/wohnungen.php 83
ERROR - 2020-05-04 18:43:24 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /users/vbgenius/www/markat/system/core/Exceptions.php:271) /users/vbgenius/www/markat/system/core/Common.php 564
ERROR - 2020-05-04 18:45:50 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-04 18:45:51 --> Severity: Notice --> Undefined offset: 13 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-04 18:45:51 --> Severity: Notice --> Undefined property: App::$db /users/vbgenius/www/markat/application/views/admin/tables/wohnungen.php 84
ERROR - 2020-05-04 18:45:51 --> Severity: error --> Exception: Call to a member function where() on null /users/vbgenius/www/markat/application/views/admin/tables/wohnungen.php 84
ERROR - 2020-05-04 18:45:51 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /users/vbgenius/www/markat/system/core/Exceptions.php:271) /users/vbgenius/www/markat/system/core/Common.php 564
ERROR - 2020-05-04 18:46:50 --> Severity: Notice --> Undefined offset: 13 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-04 18:46:50 --> Severity: Notice --> Undefined offset: 14 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-04 18:46:50 --> Query error: Unknown column 'mieters' in 'field list' - Invalid query: 
    SELECT SQL_CALC_FOUND_ROWS tblwohnungen.id as id, strabe, belegt, hausnummer, etage, flugel, zimmer, mieter, schlaplatze, mobiliert, belegt_v, resttage, belegt_b, mobiliert, mieters ,tblwohnungen.id
    FROM tblwohnungen
    LEFT JOIN tblmieters ON tblwohnungen.mieter = tblmieters.id
    
    
    
    ORDER BY etage ASC
    LIMIT 0, 25
    
ERROR - 2020-05-04 18:46:50 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /users/vbgenius/www/markat/system/core/Exceptions.php:271) /users/vbgenius/www/markat/system/core/Common.php 564
ERROR - 2020-05-04 18:46:50 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-04 18:46:52 --> Severity: Notice --> Undefined offset: 13 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-04 18:46:52 --> Severity: Notice --> Undefined offset: 14 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-04 18:46:52 --> Query error: Unknown column 'mieters' in 'field list' - Invalid query: 
    SELECT SQL_CALC_FOUND_ROWS tblwohnungen.id as id, strabe, belegt, hausnummer, etage, flugel, zimmer, mieter, schlaplatze, mobiliert, belegt_v, resttage, belegt_b, mobiliert, mieters ,tblwohnungen.id
    FROM tblwohnungen
    LEFT JOIN tblmieters ON tblwohnungen.mieter = tblmieters.id
    
    
    
    ORDER BY tblwohnungen.id DESC
    LIMIT 0, 25
    
ERROR - 2020-05-04 18:46:52 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /users/vbgenius/www/markat/system/core/Exceptions.php:271) /users/vbgenius/www/markat/system/core/Common.php 564
ERROR - 2020-05-04 18:47:32 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-04 18:47:34 --> Severity: Notice --> Undefined offset: 13 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-04 18:47:34 --> Severity: Notice --> Undefined offset: 14 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-04 18:47:34 --> Query error: Unknown column 'mieters' in 'field list' - Invalid query: 
    SELECT SQL_CALC_FOUND_ROWS tblwohnungen.id as id, strabe, belegt, hausnummer, etage, flugel, zimmer, mieter, schlaplatze, mobiliert, belegt_v, resttage, belegt_b, mobiliert, mieters ,tblwohnungen.id
    FROM tblwohnungen
    LEFT JOIN tblmieters ON tblwohnungen.mieter = tblmieters.id
    
    
    
    ORDER BY tblwohnungen.id DESC
    LIMIT 0, 25
    
ERROR - 2020-05-04 18:47:34 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /users/vbgenius/www/markat/system/core/Exceptions.php:271) /users/vbgenius/www/markat/system/core/Common.php 564
ERROR - 2020-05-04 18:49:10 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-04 18:49:11 --> Severity: Notice --> Undefined offset: 13 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-04 18:49:11 --> Severity: Notice --> Undefined offset: 14 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-04 18:49:11 --> Severity: Notice --> Undefined property: App::$db /users/vbgenius/www/markat/application/views/admin/tables/wohnungen.php 84
ERROR - 2020-05-04 18:49:11 --> Severity: error --> Exception: Call to a member function where() on null /users/vbgenius/www/markat/application/views/admin/tables/wohnungen.php 84
ERROR - 2020-05-04 18:49:11 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /users/vbgenius/www/markat/system/core/Exceptions.php:271) /users/vbgenius/www/markat/system/core/Common.php 564
ERROR - 2020-05-04 18:50:42 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-04 18:50:44 --> Severity: Notice --> Undefined offset: 13 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-04 18:50:44 --> Severity: Notice --> Undefined offset: 14 /users/vbgenius/www/markat/application/helpers/datatables_helper.php 162
ERROR - 2020-05-04 18:50:44 --> Severity: Notice --> Undefined property: App::$db /users/vbgenius/www/markat/application/views/admin/tables/wohnungen.php 84
ERROR - 2020-05-04 18:50:44 --> Severity: error --> Exception: Call to a member function where() on null /users/vbgenius/www/markat/application/views/admin/tables/wohnungen.php 84
ERROR - 2020-05-04 18:50:44 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /users/vbgenius/www/markat/system/core/Exceptions.php:271) /users/vbgenius/www/markat/system/core/Common.php 564
