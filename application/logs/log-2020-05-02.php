<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-05-02 20:54:53 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-02 20:54:53 --> Severity: Notice --> Undefined index: haustiere /users/vbgenius/www/markat/application/models/Mieter_model.php 41
ERROR - 2020-05-02 20:54:53 --> Query error: Unknown column 'email' in 'field list' - Invalid query: INSERT INTO `tblmieters` (`vorname`, `baubeginn`, `nachname`, `beraumung`, `email`, `ruckraumung`, `adresse`, `bauende`, `plz`, `fenstereinbau`, `stadt`, `k_baubeginn`, `telefon_1`, `k_ruckraumung`, `telefon_2`, `umsetzwohnung`, `telefon_3`, `raucher`, `created_at`, `updated_at`, `haustiere`, `userid`, `active`) VALUES ('mieter', 'mieter', 'mieter', 'mieter', 'mieter@gmail.com', 'mieter 41', 'mieter 4541', '541 mieter', '54 mieter', 'mieter ', 'mieter', 'mieter', '68454124', 'mieter 4154', '58449465', '6564874', '654874548', 1, '2020-05-02 20:54:53', '2020-05-02 20:54:53', 0, '3', 1)
ERROR - 2020-05-02 20:54:53 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /users/vbgenius/www/markat/system/core/Exceptions.php:271) /users/vbgenius/www/markat/system/core/Common.php 564
ERROR - 2020-05-02 20:56:34 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-02 20:57:32 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-02 20:57:32 --> Severity: Notice --> Undefined index: haustiere /users/vbgenius/www/markat/application/models/Mieter_model.php 41
ERROR - 2020-05-02 20:57:32 --> Severity: Notice --> Undefined index: mieters_id /users/vbgenius/www/markat/application/models/Mieter_model.php 52
ERROR - 2020-05-02 20:57:32 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /users/vbgenius/www/markat/system/core/Exceptions.php:271) /users/vbgenius/www/markat/system/helpers/url_helper.php 564
ERROR - 2020-05-02 21:45:28 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-02 21:45:29 --> Severity: Notice --> Undefined variable: join /users/vbgenius/www/markat/application/views/admin/tables/mieters.php 35
ERROR - 2020-05-02 21:45:29 --> Severity: Warning --> implode() [<a href='http://de.php.net/function.implode'>function.implode</a>]: Invalid arguments passed /users/vbgenius/www/markat/application/helpers/datatables_helper.php 209
ERROR - 2020-05-02 21:45:29 --> Query error: Table 'vbgenius_markat.tblmieter' doesn't exist - Invalid query: 
    SELECT SQL_CALC_FOUND_ROWS tblmieter.id as id, vorname, nachname, umsetzwohnung, telefon_1, email, active, updated_at ,tblmieter.id
    FROM tblmieter
    
    
    
    
    ORDER BY active DESC
    LIMIT 0, 25
    
ERROR - 2020-05-02 21:45:29 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at /users/vbgenius/www/markat/system/core/Exceptions.php:271) /users/vbgenius/www/markat/system/core/Common.php 564
ERROR - 2020-05-02 21:46:49 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-02 21:47:19 --> Query error: Unknown column 'tblmieter.id' in 'field list' - Invalid query: 
    SELECT SQL_CALC_FOUND_ROWS tblmieter.id as id, vorname, nachname, umsetzwohnung, telefon_1, email, active, updated_at ,tblmieter.id
    FROM tblmieters
    
    
    
    
    ORDER BY active DESC
    LIMIT 0, 25
    
ERROR - 2020-05-02 21:47:45 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-02 21:47:54 --> Query error: Unknown column 'tblmieter.id' in 'field list' - Invalid query: 
    SELECT SQL_CALC_FOUND_ROWS tblmieter.id as id, vorname, nachname, umsetzwohnung, telefon_1, email, active, updated_at ,tblmieter.id
    FROM tblmieters
    
    
    
    
    ORDER BY active DESC
    LIMIT 0, 25
    
ERROR - 2020-05-02 21:48:05 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-02 21:48:07 --> Query error: Unknown column 'tblmieter.id' in 'field list' - Invalid query: 
    SELECT SQL_CALC_FOUND_ROWS tblmieter.id as id, vorname, nachname, umsetzwohnung, telefon_1, email, active, updated_at ,tblmieter.id
    FROM tblmieters
    
    
    
    
    ORDER BY active DESC
    LIMIT 0, 25
    
ERROR - 2020-05-02 21:48:53 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-02 21:49:04 --> Severity: Notice --> Undefined index: belegt /users/vbgenius/www/markat/application/views/admin/tables/mieters.php 40
ERROR - 2020-05-02 21:49:04 --> Severity: Notice --> Undefined index: telefon /users/vbgenius/www/markat/application/views/admin/tables/mieters.php 70
ERROR - 2020-05-02 21:58:11 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-02 21:58:14 --> Severity: error --> Exception: syntax error, unexpected ';', expecting ',' or ')' /users/vbgenius/www/markat/application/views/admin/tables/mieters.php 78
ERROR - 2020-05-02 21:59:02 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-02 21:59:05 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-02 21:59:26 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-02 21:59:36 --> Severity: Notice --> Undefined variable: tickets /users/vbgenius/www/markat/application/core/AdminController.php 204
ERROR - 2020-05-02 21:59:39 --> Severity: Notice --> Undefined index: belegt /users/vbgenius/www/markat/application/views/admin/tables/mieters.php 40
ERROR - 2020-05-02 21:59:39 --> Severity: Notice --> Undefined index: telefon /users/vbgenius/www/markat/application/views/admin/tables/mieters.php 70
ERROR - 2020-05-02 21:59:39 --> Severity: Notice --> A non well formed numeric value encountered /users/vbgenius/www/markat/application/views/admin/tables/mieters.php 78
