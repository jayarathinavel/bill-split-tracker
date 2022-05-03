<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo $constants['APP_TITLE']; ?></title>
  </head>
  <body>
    <?php
      helloWorld();
      echo ' And this is from Model : '.$title;
    ?>
    <br>
    <?php echo 'A value from Variables.php : '. $variables['variableTest']; ?>
    <br>
    <a href="home?query=Hello"> Query String from URL </a>
    <?php echo isset($_GET['query']) ? 'The query string from URL is : ' . $_GET['query'] : ''; ?>
  </body>
</html>
