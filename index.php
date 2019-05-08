<?php

// INIT APP
require_once 'app/init.php';

// REGISTRY
$Registry = new Registry;

// REQUEST
$Request = new Request;
$Registry->set('request', $Request);

// CONFIGS
$Config = new Config;
$Config->load('default');
$Registry->set('config', $Config);

// SESSION
$Session = new Session($Registry);
$Registry->set('session', $Session);

// LOADER
$Loader = new Loader($Registry);
$Registry->set('load', $Loader);

// DOCUMENT
$Document = new Document($Registry);
$Registry->set('document', $Document);

// TWIG
$Twig = new Twig($Registry);

// DATABASE
$Database = new Database($Registry);

// INIT APP
$App = new App($Registry);

?>