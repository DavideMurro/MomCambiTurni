# MomCambiTurni
Web application to manage shifts in a transport company of treviso, it is possible to ask, search and exchange shifts each others.
It is written mostly in italian, is completely responsive and it uses:
- Front end: AngularJS, HTML, CSS
- Back end: PHP
- Database: MySQL

## File structure
- _root_
  HTML pages
- **ajax**
  PHP files, used as back end, these are the files called by JS to connect with the DB
- **config**
  Here are the files to configure the application
- **css**
  Only css files
- **img**
  All images, icons and logos of the site
- **js**
  Only javascript files
- **lib**
  All libraries used by the application
 
## Libraries
- **AngularJS**
  It is a JavaScript-based web framework for developing single-page applications.
- **AngularJS Material**
  It provides a set of reusable and accessible UI components for AngularJS
  
## Database
The database was designed for MySQL, it has these tables:
- **cambi**
  Table contains shifts users are asking or looking for 
- **utenti**
  All users registered on the web application

## Configuration
In the _config_ folder there are 2 files that are used to configure the application to connect correctly with the frontend, backend and DB
- **config.js**
  It is used to connect Javascript with PHP throw ajax calls. <br>
  It consider if the current url starts with http or https protocol, and if contains www or not, then add the backend address
  
  ```javascript
  var url_location = window.location; 
  var http_https = "https://";
  var www = "";
  
  if(url_location.protocol) {
    http_https = url_location.protocol + "//";
  }
  
  if(url_location.host.startsWith("www.")) {
    www = "www.";
  }
  
  var url = http_https + www + "momcambiturni.it/";  // modify this line: address url of the application
  ```
- **config.php**
  This file is inluded at the start of each php file. <br>
  It is used to configure general PHP settings and the connection with DB:
  - variables to connect to DB
  - connection to DB
  - start session
  
  ```php
  // connection data
  $server = "localhost";            // modify this line: server address
  $username = "momcambiturni";    // modify this line: username
  $password = "momcambiturni";    // modify this line: password
  $db = "momcambiturni";          // modify this line: name of the database

  // start connection to DB
  try {
      $dbh = new PDO("mysql:host=$server;dbname=$db", $username, $password);
      $dbh->exec("set names utf8");
  }
  catch (PDOException $e) {
      echo "Connessione database fallita: " . $e->getMessage() . "\n";
      exit;
  }
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  // start session
  if (session_status() == PHP_SESSION_NONE) {    
      session_start();
  }
  ```

## Summary
- Screenshots:
  ![momcambiturni altervista org_](https://github.com/DavideMurro/MomCambiTurni/assets/118051417/cba36d34-7553-4cbe-aa6f-34a8fa0fb6c3)
  ![momcambiturni altervista org_home html](https://github.com/DavideMurro/MomCambiTurni/assets/118051417/964d68a3-ee19-4785-a6ad-177a8655575d)
  ![momcambiturni altervista org_inserimento html](https://github.com/DavideMurro/MomCambiTurni/assets/118051417/738320df-a00e-45ce-9d64-bd09f8d39164)
  ![momcambiturni altervista org_inserimento_riposo html](https://github.com/DavideMurro/MomCambiTurni/assets/118051417/08f9895d-6f46-4263-965f-9549d1ee45f1)
  ![momcambiturni altervista org_visualizza html](https://github.com/DavideMurro/MomCambiTurni/assets/118051417/410e8ea3-464e-41f2-9351-f830fc2ab8fa)


    
