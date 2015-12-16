1. Web Folders Guide
   - Index.php
     - Entry page. This page includes all other tab pages and rendered them into 1 single return HTML page
   - header.php
     - Include scripts to be loaded by default
     - use "require_once" on all other web pages
   - functions
     - all the backend functionalities codes
     - initialise.php
        - establish database connections and obtain all values from database or read from file
        - includes all necessary functions files and create global variable/objects
	- this should be included in all web pages using "require_once"
        
     - ulogin.php
        - login/logout functions using ulogon
   - config
     - config.inc.php
       - All the database credentials, any PATH and CONSTANT variable
   
