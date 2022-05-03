<?php
    //Fetches a values from 'varibales' table. eg : varibales['key'] results in 'value'
    $variablesSql = "SELECT `name`,`value` FROM `variables`";
    $variablesResult = $conn->query($variablesSql);
    if ($variablesResult->num_rows > 0) {
        while ($row = $variablesResult->fetch_assoc()) {
            $name = $row['name'];
            $value = $row['value'];
            $variables[$name] = $value;
        }
    }
?>