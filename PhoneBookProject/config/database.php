<?php
$cnf['default']['connection_url'] = 'odbc:Driver={SQL Server Native Client 11.0};Server=.;Database=PhoneBook';
$cnf['default']['username'] = 'root';
$cnf['default']['password'] = '';
$cnf['default']['pdo_options'][PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;

return $cnf;