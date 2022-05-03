**index.php** : <br>
<ul>
<p>
Takes the value after the URL and includes the particular Model View and Controller PHP files, if present in the corresponding folders under same name, else shows 404 Page.</p>

**Example** : <p>
```http://example.com/home```
<br>
In this the value after URL is home. The corresponding files ***home.php***, ***home.phtml***, ***home.php*** should be present in the folders Model View Controller respectively
<br> 
***Atleast view file should exist.*** 
</p>
</ul>

**variables.php** :
<p>
<ul>
Holds the the variable values in an array, from the database table variables. The is mainly for dev, to quickly change a value without any need for code modifications. <br> At any place in the project it can be used as <b> $variables['variableName'] </b> to fetch the corresponding value for the provided variable name.
<br> <b> Example : </b> Main theme
</ul>
</p>

**constants.php** :
<p><ul>
<li>
Holds the constant variables.
</li>
<li>
Simply use <b> $variableName</b> to use at any point in the project.
<br> <b> Example : </b> Project Title
</ul>
</p>

SQL Query for ***variables*** table :

```
CREATE TABLE `variables` (
  `name` varchar(100) NOT NULL,
  `value` varchar(100) NOT NULL
);
```

SQL Query for ***users*** table :

```
CREATE TABLE users (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `theme` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
);
```
