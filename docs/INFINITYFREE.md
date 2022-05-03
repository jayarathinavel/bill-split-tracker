**For deploying to infinityfree.net**

<ul>
<li> Move the contents of public folder to root.</li>
<li> Change database credentials from local to server.</li>
<li>Delete Procfile and composer.json</li>
<li> <b> Change APPLICATION_PATH in index.php from '/../app' to '/app'</b></li>
</ul>


```
    Local :

    $dbservername = 'localhost';
    $dbusername = 'root';
    $dbpassword = 'Java&7890';
    $dbname = 'php-boilerplate';

    Server :
        
    $dbservername="sql207.epizy.com";
    $dbusername="epiz_29743151";
    $dbpassword="hZ8nAgMZV1M5g";
    $dbname="epiz_29743151_tuby_db";
```