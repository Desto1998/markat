<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2020-08-04 12:52:27 --> Could not find the language line "MEINE FIRMA"
ERROR - 2020-08-04 12:52:27 --> Could not find the language line "Räumung/Beräumung"
ERROR - 2020-08-04 12:52:27 --> Could not find the language line "Projekte"
ERROR - 2020-08-04 12:52:27 --> Could not find the language line "Rechnungen"
ERROR - 2020-08-04 12:52:27 --> Could not find the language line "Lieferanten"
ERROR - 2020-08-04 12:52:27 --> Could not find the language line "AQ"
ERROR - 2020-08-04 12:52:27 --> Could not find the language line "AQ"
ERROR - 2020-08-04 12:52:27 --> Could not find the language line "Inventar"
ERROR - 2020-08-04 12:52:27 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 12:52:27 --> Could not find the language line "Task-Planer"
ERROR - 2020-08-04 12:52:27 --> Could not find the language line "Belegungsplan"
ERROR - 2020-08-04 12:52:27 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 12:52:27 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 12:52:27 --> Could not find the language line "Mieter"
ERROR - 2020-08-04 12:52:27 --> Could not find the language line "Fahrzeugliste"
ERROR - 2020-08-04 12:52:27 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 12:52:27 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 12:52:27 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 12:52:27 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 12:52:27 --> Severity: Notice --> Undefined variable: project C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 47
ERROR - 2020-08-04 12:52:27 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 12:52:27 --> Severity: Notice --> Undefined variable: strabe C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 50
ERROR - 2020-08-04 12:52:27 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 12:52:27 --> Severity: Notice --> Undefined variable: etage C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 53
ERROR - 2020-08-04 12:52:27 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 12:52:27 --> Severity: Notice --> Undefined variable: flugel C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 56
ERROR - 2020-08-04 12:52:27 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 12:52:28 --> Severity: Notice --> Undefined variable: schlaplatze C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 59
ERROR - 2020-08-04 12:52:28 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 12:52:28 --> Could not find the language line "inventar"
ERROR - 2020-08-04 12:52:30 --> Could not find the language line "MEINE FIRMA"
ERROR - 2020-08-04 12:52:30 --> Could not find the language line "Räumung/Beräumung"
ERROR - 2020-08-04 12:52:30 --> Could not find the language line "Projekte"
ERROR - 2020-08-04 12:52:30 --> Could not find the language line "Rechnungen"
ERROR - 2020-08-04 12:52:30 --> Could not find the language line "Lieferanten"
ERROR - 2020-08-04 12:52:30 --> Could not find the language line "AQ"
ERROR - 2020-08-04 12:52:30 --> Could not find the language line "AQ"
ERROR - 2020-08-04 12:52:30 --> Could not find the language line "Inventar"
ERROR - 2020-08-04 12:52:30 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 12:52:30 --> Could not find the language line "Task-Planer"
ERROR - 2020-08-04 12:52:30 --> Could not find the language line "Belegungsplan"
ERROR - 2020-08-04 12:52:30 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 12:52:30 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 12:52:30 --> Could not find the language line "Mieter"
ERROR - 2020-08-04 12:52:30 --> Could not find the language line "Fahrzeugliste"
ERROR - 2020-08-04 12:52:30 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'from ON from.id = inventory_um.aq_from  LEFT JOIN tblwohnungen as to ON to.id...' at line 3 - Invalid query: 
    SELECT SQL_CALC_FOUND_ROWS tblinventory_um.id as id, strabe, hausnummer, etage, flugel, zimmer, schlaplatze, mobiliert, austattung, project, `tblwohnungen`.`active` AS `tblwohnungen.active` ,tblwohnungen.id
    FROM tblwohnungen
    LEFT JOIN tblwohnungen as from ON from.id = inventory_um.aq_from  LEFT JOIN tblwohnungen as to ON to.id = inventory_um.aq_to 
    
    
    
    ORDER BY tblinventory_um.id DESC
    LIMIT 0, 25
    
ERROR - 2020-08-04 12:52:31 --> Could not find the language line "MEINE FIRMA"
ERROR - 2020-08-04 12:52:31 --> Could not find the language line "Räumung/Beräumung"
ERROR - 2020-08-04 12:52:31 --> Could not find the language line "Projekte"
ERROR - 2020-08-04 12:52:31 --> Could not find the language line "Rechnungen"
ERROR - 2020-08-04 12:52:31 --> Could not find the language line "Lieferanten"
ERROR - 2020-08-04 12:52:31 --> Could not find the language line "AQ"
ERROR - 2020-08-04 12:52:31 --> Could not find the language line "AQ"
ERROR - 2020-08-04 12:52:31 --> Could not find the language line "Inventar"
ERROR - 2020-08-04 12:52:31 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 12:52:31 --> Could not find the language line "Task-Planer"
ERROR - 2020-08-04 12:52:32 --> Could not find the language line "Belegungsplan"
ERROR - 2020-08-04 12:52:32 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 12:52:32 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 12:52:32 --> Could not find the language line "Mieter"
ERROR - 2020-08-04 12:52:32 --> Could not find the language line "Fahrzeugliste"
ERROR - 2020-08-04 12:52:32 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'from ON from.id = inventory_um.aq_from  LEFT JOIN tblwohnungen as to ON to.id...' at line 3 - Invalid query: 
    SELECT SQL_CALC_FOUND_ROWS tblinventory_um.id as id, strabe, hausnummer, etage, flugel, zimmer, schlaplatze, mobiliert, austattung, project, `tblwohnungen`.`active` AS `tblwohnungen.active` ,tblwohnungen.id
    FROM tblwohnungen
    LEFT JOIN tblwohnungen as from ON from.id = inventory_um.aq_from  LEFT JOIN tblwohnungen as to ON to.id = inventory_um.aq_to 
    
    
    
    ORDER BY tblwohnungen.active ASC
    LIMIT 0, 25
    
ERROR - 2020-08-04 12:53:43 --> Could not find the language line "MEINE FIRMA"
ERROR - 2020-08-04 12:53:43 --> Could not find the language line "Räumung/Beräumung"
ERROR - 2020-08-04 12:53:43 --> Could not find the language line "Projekte"
ERROR - 2020-08-04 12:53:43 --> Could not find the language line "Rechnungen"
ERROR - 2020-08-04 12:53:43 --> Could not find the language line "Lieferanten"
ERROR - 2020-08-04 12:53:43 --> Could not find the language line "AQ"
ERROR - 2020-08-04 12:53:44 --> Could not find the language line "AQ"
ERROR - 2020-08-04 12:53:44 --> Could not find the language line "Inventar"
ERROR - 2020-08-04 12:53:44 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 12:53:44 --> Could not find the language line "Task-Planer"
ERROR - 2020-08-04 12:53:44 --> Could not find the language line "Belegungsplan"
ERROR - 2020-08-04 12:53:44 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 12:53:44 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 12:53:44 --> Could not find the language line "Mieter"
ERROR - 2020-08-04 12:53:44 --> Could not find the language line "Fahrzeugliste"
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Undefined index: columns C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Trying to access array offset on value of type null C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Undefined index: columns C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Trying to access array offset on value of type null C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Undefined index: columns C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Trying to access array offset on value of type null C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Undefined index: columns C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Trying to access array offset on value of type null C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Undefined index: columns C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Trying to access array offset on value of type null C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Undefined index: columns C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Trying to access array offset on value of type null C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Undefined index: columns C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Trying to access array offset on value of type null C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Undefined index: columns C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Trying to access array offset on value of type null C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Undefined index: columns C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Trying to access array offset on value of type null C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Undefined index: columns C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Trying to access array offset on value of type null C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Undefined index: columns C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Severity: Notice --> Trying to access array offset on value of type null C:\xampp\htdocs\markat\application\helpers\datatables_helper.php 163
ERROR - 2020-08-04 12:53:44 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'from ON from.id = inventory_um.aq_from  RIGHT JOIN tblwohnungen as to ON to.i...' at line 3 - Invalid query: 
    SELECT SQL_CALC_FOUND_ROWS tblinventory_um.id as id, strabe, hausnummer, etage, flugel, zimmer, schlaplatze, mobiliert, austattung, project, `tblwohnungen`.`active` AS `tblwohnungen.active` ,tblwohnungen.id
    FROM tblwohnungen
    LEFT JOIN tblwohnungen as from ON from.id = inventory_um.aq_from  RIGHT JOIN tblwohnungen as to ON to.id = inventory_um.aq_to 
    
    
    
    
    
    
ERROR - 2020-08-04 12:53:44 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\xampp\htdocs\markat\system\core\Exceptions.php:271) C:\xampp\htdocs\markat\system\core\Common.php 570
ERROR - 2020-08-04 13:07:31 --> Could not find the language line "MEINE FIRMA"
ERROR - 2020-08-04 13:07:31 --> Could not find the language line "Räumung/Beräumung"
ERROR - 2020-08-04 13:07:31 --> Could not find the language line "Projekte"
ERROR - 2020-08-04 13:07:31 --> Could not find the language line "Rechnungen"
ERROR - 2020-08-04 13:07:31 --> Could not find the language line "Lieferanten"
ERROR - 2020-08-04 13:07:31 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:07:32 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:07:32 --> Could not find the language line "Inventar"
ERROR - 2020-08-04 13:07:32 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 13:07:32 --> Could not find the language line "Task-Planer"
ERROR - 2020-08-04 13:07:32 --> Could not find the language line "Belegungsplan"
ERROR - 2020-08-04 13:07:32 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:07:32 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:07:32 --> Could not find the language line "Mieter"
ERROR - 2020-08-04 13:07:32 --> Could not find the language line "Fahrzeugliste"
ERROR - 2020-08-04 13:07:32 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 13:07:33 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 13:07:33 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 13:07:33 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 13:07:33 --> Severity: Notice --> Undefined variable: project C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 47
ERROR - 2020-08-04 13:07:33 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:07:33 --> Severity: Notice --> Undefined variable: strabe C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 50
ERROR - 2020-08-04 13:07:33 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:07:33 --> Severity: Notice --> Undefined variable: etage C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 53
ERROR - 2020-08-04 13:07:33 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:07:33 --> Severity: Notice --> Undefined variable: flugel C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 56
ERROR - 2020-08-04 13:07:33 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:07:33 --> Severity: Notice --> Undefined variable: schlaplatze C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 59
ERROR - 2020-08-04 13:07:33 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:07:33 --> Could not find the language line "inventar"
ERROR - 2020-08-04 13:07:39 --> Could not find the language line "MEINE FIRMA"
ERROR - 2020-08-04 13:07:39 --> Could not find the language line "Räumung/Beräumung"
ERROR - 2020-08-04 13:07:39 --> Could not find the language line "Projekte"
ERROR - 2020-08-04 13:07:39 --> Could not find the language line "Rechnungen"
ERROR - 2020-08-04 13:07:39 --> Could not find the language line "Lieferanten"
ERROR - 2020-08-04 13:07:39 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:07:39 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:07:39 --> Could not find the language line "Inventar"
ERROR - 2020-08-04 13:07:39 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 13:07:39 --> Could not find the language line "Task-Planer"
ERROR - 2020-08-04 13:07:39 --> Could not find the language line "Belegungsplan"
ERROR - 2020-08-04 13:07:39 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:07:39 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:07:39 --> Could not find the language line "Mieter"
ERROR - 2020-08-04 13:07:39 --> Could not find the language line "Fahrzeugliste"
ERROR - 2020-08-04 13:07:40 --> Query error: Unknown column 'tblinventory_um.id' in 'field list' - Invalid query: 
    SELECT SQL_CALC_FOUND_ROWS tblinventory_um.id as id, f.id as f_id, f.strabe as f_strabe, f.hausnummer as f_hausnummer, f.etage as f_etage, f.flugel as f_flugel, f.plz as f_plz, f.ort as f_ort, 1, t.id as t_id, t.strabe as t_strabe, t.hausnummer as t_hausnummer, t.etage as t_etage, t.flugel as t_flugel, t.plz as t_plz, t.ort as t_ort, 1 ,tblwohnungen.id
    FROM tblwohnungen
    LEFT JOIN tblinventory_um as f ON from.id =tblinventory_um.aq_from  RIGHT JOIN tblinventory_um as t ON to.id = tblinventory_um.aq_to 
    
    
    
    ORDER BY tblinventory_um.id DESC
    LIMIT 0, 25
    
ERROR - 2020-08-04 13:09:01 --> Could not find the language line "MEINE FIRMA"
ERROR - 2020-08-04 13:09:01 --> Could not find the language line "Räumung/Beräumung"
ERROR - 2020-08-04 13:09:01 --> Could not find the language line "Projekte"
ERROR - 2020-08-04 13:09:01 --> Could not find the language line "Rechnungen"
ERROR - 2020-08-04 13:09:01 --> Could not find the language line "Lieferanten"
ERROR - 2020-08-04 13:09:01 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:09:01 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:09:01 --> Could not find the language line "Inventar"
ERROR - 2020-08-04 13:09:01 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 13:09:01 --> Could not find the language line "Task-Planer"
ERROR - 2020-08-04 13:09:02 --> Could not find the language line "Belegungsplan"
ERROR - 2020-08-04 13:09:02 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:09:02 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:09:02 --> Could not find the language line "Mieter"
ERROR - 2020-08-04 13:09:02 --> Could not find the language line "Fahrzeugliste"
ERROR - 2020-08-04 13:09:02 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 13:09:02 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 13:09:02 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 13:09:02 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 13:09:02 --> Severity: Notice --> Undefined variable: project C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 47
ERROR - 2020-08-04 13:09:02 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:09:02 --> Severity: Notice --> Undefined variable: strabe C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 50
ERROR - 2020-08-04 13:09:02 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:09:02 --> Severity: Notice --> Undefined variable: etage C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 53
ERROR - 2020-08-04 13:09:02 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:09:02 --> Severity: Notice --> Undefined variable: flugel C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 56
ERROR - 2020-08-04 13:09:02 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:09:02 --> Severity: Notice --> Undefined variable: schlaplatze C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 59
ERROR - 2020-08-04 13:09:02 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:09:02 --> Could not find the language line "inventar"
ERROR - 2020-08-04 13:09:05 --> Could not find the language line "MEINE FIRMA"
ERROR - 2020-08-04 13:09:05 --> Could not find the language line "Räumung/Beräumung"
ERROR - 2020-08-04 13:09:05 --> Could not find the language line "Projekte"
ERROR - 2020-08-04 13:09:05 --> Could not find the language line "Rechnungen"
ERROR - 2020-08-04 13:09:05 --> Could not find the language line "Lieferanten"
ERROR - 2020-08-04 13:09:05 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:09:05 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:09:05 --> Could not find the language line "Inventar"
ERROR - 2020-08-04 13:09:05 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 13:09:05 --> Could not find the language line "Task-Planer"
ERROR - 2020-08-04 13:09:05 --> Could not find the language line "Belegungsplan"
ERROR - 2020-08-04 13:09:05 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:09:05 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:09:06 --> Could not find the language line "Mieter"
ERROR - 2020-08-04 13:09:06 --> Could not find the language line "Fahrzeugliste"
ERROR - 2020-08-04 13:09:06 --> Query error: Unknown column 'tblf.id' in 'field list' - Invalid query: 
    SELECT SQL_CALC_FOUND_ROWS tblf.id as id, f.id as f_id, f.strabe as f_strabe, f.hausnummer as f_hausnummer, f.etage as f_etage, f.flugel as f_flugel, f.plz as f_plz, f.ort as f_ort, 1, t.id as t_id, t.strabe as t_strabe, t.hausnummer as t_hausnummer, t.etage as t_etage, t.flugel as t_flugel, t.plz as t_plz, t.ort as t_ort, 1 ,tblwohnungen.id
    FROM tblwohnungen
    LEFT JOIN tblinventory_um as f ON from.id =tblinventory_um.aq_from  RIGHT JOIN tblinventory_um as t ON to.id = tblinventory_um.aq_to 
    
    
    
    ORDER BY tblf.id DESC
    LIMIT 0, 25
    
ERROR - 2020-08-04 13:09:37 --> Could not find the language line "MEINE FIRMA"
ERROR - 2020-08-04 13:09:37 --> Could not find the language line "Räumung/Beräumung"
ERROR - 2020-08-04 13:09:37 --> Could not find the language line "Projekte"
ERROR - 2020-08-04 13:09:37 --> Could not find the language line "Rechnungen"
ERROR - 2020-08-04 13:09:37 --> Could not find the language line "Lieferanten"
ERROR - 2020-08-04 13:09:37 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:09:37 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:09:37 --> Could not find the language line "Inventar"
ERROR - 2020-08-04 13:09:37 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 13:09:37 --> Could not find the language line "Task-Planer"
ERROR - 2020-08-04 13:09:37 --> Could not find the language line "Belegungsplan"
ERROR - 2020-08-04 13:09:37 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:09:37 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:09:37 --> Could not find the language line "Mieter"
ERROR - 2020-08-04 13:09:37 --> Could not find the language line "Fahrzeugliste"
ERROR - 2020-08-04 13:09:37 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 13:09:37 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 13:09:37 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 13:09:37 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 13:09:37 --> Severity: Notice --> Undefined variable: project C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 47
ERROR - 2020-08-04 13:09:37 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:09:37 --> Severity: Notice --> Undefined variable: strabe C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 50
ERROR - 2020-08-04 13:09:37 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:09:37 --> Severity: Notice --> Undefined variable: etage C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 53
ERROR - 2020-08-04 13:09:37 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:09:37 --> Severity: Notice --> Undefined variable: flugel C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 56
ERROR - 2020-08-04 13:09:37 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:09:37 --> Severity: Notice --> Undefined variable: schlaplatze C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 59
ERROR - 2020-08-04 13:09:37 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:09:37 --> Could not find the language line "inventar"
ERROR - 2020-08-04 13:09:41 --> Could not find the language line "MEINE FIRMA"
ERROR - 2020-08-04 13:09:41 --> Could not find the language line "Räumung/Beräumung"
ERROR - 2020-08-04 13:09:41 --> Could not find the language line "Projekte"
ERROR - 2020-08-04 13:09:41 --> Could not find the language line "Rechnungen"
ERROR - 2020-08-04 13:09:41 --> Could not find the language line "Lieferanten"
ERROR - 2020-08-04 13:09:41 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:09:41 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:09:41 --> Could not find the language line "Inventar"
ERROR - 2020-08-04 13:09:41 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 13:09:41 --> Could not find the language line "Task-Planer"
ERROR - 2020-08-04 13:09:41 --> Could not find the language line "Belegungsplan"
ERROR - 2020-08-04 13:09:41 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:09:41 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:09:41 --> Could not find the language line "Mieter"
ERROR - 2020-08-04 13:09:41 --> Could not find the language line "Fahrzeugliste"
ERROR - 2020-08-04 13:09:41 --> Query error: Unknown column 'f.strabe' in 'field list' - Invalid query: 
    SELECT SQL_CALC_FOUND_ROWS f.id as id, f.id as f_id, f.strabe as f_strabe, f.hausnummer as f_hausnummer, f.etage as f_etage, f.flugel as f_flugel, f.plz as f_plz, f.ort as f_ort, 1, t.id as t_id, t.strabe as t_strabe, t.hausnummer as t_hausnummer, t.etage as t_etage, t.flugel as t_flugel, t.plz as t_plz, t.ort as t_ort, 1 ,tblwohnungen.id
    FROM tblwohnungen
    LEFT JOIN tblinventory_um as f ON from.id =tblinventory_um.aq_from  RIGHT JOIN tblinventory_um as t ON to.id = tblinventory_um.aq_to 
    
    
    
    ORDER BY f.id DESC
    LIMIT 0, 25
    
ERROR - 2020-08-04 13:09:51 --> Could not find the language line "MEINE FIRMA"
ERROR - 2020-08-04 13:09:51 --> Could not find the language line "Räumung/Beräumung"
ERROR - 2020-08-04 13:09:51 --> Could not find the language line "Projekte"
ERROR - 2020-08-04 13:09:51 --> Could not find the language line "Rechnungen"
ERROR - 2020-08-04 13:09:51 --> Could not find the language line "Lieferanten"
ERROR - 2020-08-04 13:09:51 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:09:51 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:09:51 --> Could not find the language line "Inventar"
ERROR - 2020-08-04 13:09:51 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 13:09:51 --> Could not find the language line "Task-Planer"
ERROR - 2020-08-04 13:09:51 --> Could not find the language line "Belegungsplan"
ERROR - 2020-08-04 13:09:51 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:09:51 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:09:51 --> Could not find the language line "Mieter"
ERROR - 2020-08-04 13:09:51 --> Could not find the language line "Fahrzeugliste"
ERROR - 2020-08-04 13:09:51 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 13:09:51 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 13:09:51 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 13:09:51 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 13:09:51 --> Severity: Notice --> Undefined variable: project C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 47
ERROR - 2020-08-04 13:09:51 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:09:51 --> Severity: Notice --> Undefined variable: strabe C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 50
ERROR - 2020-08-04 13:09:51 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:09:51 --> Severity: Notice --> Undefined variable: etage C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 53
ERROR - 2020-08-04 13:09:51 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:09:51 --> Severity: Notice --> Undefined variable: flugel C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 56
ERROR - 2020-08-04 13:09:51 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:09:51 --> Severity: Notice --> Undefined variable: schlaplatze C:\xampp\htdocs\markat\application\views\admin\inventar-um\manage.php 59
ERROR - 2020-08-04 13:09:51 --> Severity: Warning --> Invalid argument supplied for foreach() C:\xampp\htdocs\markat\application\helpers\fields_helper.php 339
ERROR - 2020-08-04 13:09:51 --> Could not find the language line "inventar"
ERROR - 2020-08-04 13:09:54 --> Could not find the language line "MEINE FIRMA"
ERROR - 2020-08-04 13:09:54 --> Could not find the language line "Räumung/Beräumung"
ERROR - 2020-08-04 13:09:54 --> Could not find the language line "Projekte"
ERROR - 2020-08-04 13:09:54 --> Could not find the language line "Rechnungen"
ERROR - 2020-08-04 13:09:54 --> Could not find the language line "Lieferanten"
ERROR - 2020-08-04 13:09:54 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:09:54 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:09:54 --> Could not find the language line "Inventar"
ERROR - 2020-08-04 13:09:54 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 13:09:54 --> Could not find the language line "Task-Planer"
ERROR - 2020-08-04 13:09:54 --> Could not find the language line "Belegungsplan"
ERROR - 2020-08-04 13:09:54 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:09:54 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:09:54 --> Could not find the language line "Mieter"
ERROR - 2020-08-04 13:09:54 --> Could not find the language line "Fahrzeugliste"
ERROR - 2020-08-04 13:09:54 --> Query error: Unknown column 'f.strabe' in 'field list' - Invalid query: 
    SELECT SQL_CALC_FOUND_ROWS f.id as id, f.id as f_id, f.strabe as f_strabe, f.hausnummer as f_hausnummer, f.etage as f_etage, f.flugel as f_flugel, f.plz as f_plz, f.ort as f_ort, 1, t.id as t_id, t.strabe as t_strabe, t.hausnummer as t_hausnummer, t.etage as t_etage, t.flugel as t_flugel, t.plz as t_plz, t.ort as t_ort, 1 ,tblwohnungen.id
    FROM tblwohnungen
    LEFT JOIN tblinventory_um as f ON from.id =tblinventory_um.aq_from  RIGHT JOIN tblinventory_um as t ON to.id = tblinventory_um.aq_to 
    
    
    
    ORDER BY f.id DESC
    LIMIT 0, 25
    
ERROR - 2020-08-04 13:12:23 --> Could not find the language line "MEINE FIRMA"
ERROR - 2020-08-04 13:12:23 --> Could not find the language line "Räumung/Beräumung"
ERROR - 2020-08-04 13:12:23 --> Could not find the language line "Projekte"
ERROR - 2020-08-04 13:12:23 --> Could not find the language line "Rechnungen"
ERROR - 2020-08-04 13:12:23 --> Could not find the language line "Lieferanten"
ERROR - 2020-08-04 13:12:23 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:12:23 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:12:23 --> Could not find the language line "Inventar"
ERROR - 2020-08-04 13:12:23 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 13:12:23 --> Could not find the language line "Task-Planer"
ERROR - 2020-08-04 13:12:23 --> Could not find the language line "Belegungsplan"
ERROR - 2020-08-04 13:12:23 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:12:23 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:12:23 --> Could not find the language line "Mieter"
ERROR - 2020-08-04 13:12:23 --> Could not find the language line "Fahrzeugliste"
ERROR - 2020-08-04 13:12:24 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:12:24 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 13:12:24 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 13:12:24 --> Severity: Notice --> Undefined index: slug C:\xampp\htdocs\markat\application\views\admin\includes\aside.php 93
ERROR - 2020-08-04 13:12:24 --> Could not find the language line "Alle löschen"
ERROR - 2020-08-04 13:12:24 --> Could not find the language line "Kalender"
ERROR - 2020-08-04 13:12:24 --> Could not find the language line "Kalender"
ERROR - 2020-08-04 13:12:27 --> Could not find the language line "MEINE FIRMA"
ERROR - 2020-08-04 13:12:27 --> Could not find the language line "Räumung/Beräumung"
ERROR - 2020-08-04 13:12:27 --> Could not find the language line "Projekte"
ERROR - 2020-08-04 13:12:27 --> Could not find the language line "Rechnungen"
ERROR - 2020-08-04 13:12:27 --> Could not find the language line "Lieferanten"
ERROR - 2020-08-04 13:12:27 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:12:27 --> Could not find the language line "AQ"
ERROR - 2020-08-04 13:12:27 --> Could not find the language line "Inventar"
ERROR - 2020-08-04 13:12:27 --> Could not find the language line "Inventar-Umzugsliste"
ERROR - 2020-08-04 13:12:27 --> Could not find the language line "Task-Planer"
ERROR - 2020-08-04 13:12:27 --> Could not find the language line "Belegungsplan"
ERROR - 2020-08-04 13:12:27 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:12:27 --> Could not find the language line "Mitarbeiter"
ERROR - 2020-08-04 13:12:27 --> Could not find the language line "Mieter"
ERROR - 2020-08-04 13:12:27 --> Could not find the language line "Fahrzeugliste"
