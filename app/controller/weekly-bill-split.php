<?php
    $weeklyBillSplitModel = new WeeklyBillSplitModel;
    const TD_OPEN = '<td>';
    const TD_CLOSE = '</td>';
    const TR_OPEN = '<tr>';
    const TR_CLOSE = '</tr>';

    class WeeklyBillSplitController{
        //Add New Person
        function insertNewPerson($weeklyBillSplitModel, $conn){
            if(!empty($_POST["name"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
                $result = $this -> insertNewPersonToDatabase($weeklyBillSplitModel, $conn);
            }
            return $result;
        }
        //Add New Bill to Single Person
        function insertNewBill($weeklyBillSplitModel, $conn){
            if(!empty($_POST["personName"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
                $result = $this -> insertNewSinglePersonBillToDatabase($weeklyBillSplitModel, $conn);
            }
            return $result;
        }
        //Add New Bill to Multiple Person
        function insertNewMultiplePersonBill($weeklyBillSplitModel, $conn){
            if(!empty($_POST["billName"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
                $result = $this -> insertNewMultiplePersonBillToDatabase($weeklyBillSplitModel, $conn);
            }
            return $result;
        }

        function insertNewPersonToDatabase($weeklyBillSplitModel, $conn){
            $weeklyBillSplitModel -> setName(trim($_POST["name"]));
            $bookId = 0;
            $name = ($weeklyBillSplitModel -> getName()) != null ? $weeklyBillSplitModel -> getName() : '';
            $billName = trim($_POST["billName"]);
            switch (trim($_POST["day"])) {
                case 'monday':
                    $weeklyBillSplitModel -> setMondayAmount($billName .':'. trim($_POST["amount"]) .'; ' );
                    break;
                case 'tuesday':
                    $weeklyBillSplitModel -> setTuesdayAmount($billName .':'. trim($_POST["amount"]) .'; ' );
                    break;
                case 'wednesday':
                    $weeklyBillSplitModel -> setWednesdayAmount($billName .':'. trim($_POST["amount"]) .'; ' );
                    break;
                case 'thursday':
                    $weeklyBillSplitModel -> setThursdayAmount($billName .':'. trim($_POST["amount"]) .'; ' );
                    break;
                case 'friday':
                    $weeklyBillSplitModel -> setFridayAmount($billName .':'. trim($_POST["amount"]) .'; ' );
                    break;
                case 'saturday':
                    $weeklyBillSplitModel -> setSaturdayAmount($billName .':'. trim($_POST["amount"]) .'; ' );
                    break;
                case 'sunday':
                    $weeklyBillSplitModel -> setSundayAmount($billName .':'. trim($_POST["amount"]) .'; ' );
                    break;
                default :
                    $weeklyBillSplitModel = null;
            }
            $mondayAmount = $weeklyBillSplitModel -> getMondayAmount();
            $tuesdayAmount = $weeklyBillSplitModel -> getTuesdayAmount();
            $wednesdayAmount = $weeklyBillSplitModel -> getWednesdayAmount(); 
            $thursdayAmount = $weeklyBillSplitModel -> getThursdayAmount();
            $fridayAmount = $weeklyBillSplitModel -> getFridayAmount();
            $saturdayAmount = $weeklyBillSplitModel -> getSaturdayAmount();
            $sundayAmount = $weeklyBillSplitModel -> getSundayAmount();
            $sql = "INSERT INTO `weekly-bill-split` (`book-id`, `name`, `monday-amount`, `tuesday-amount`, `wednesday-amount`, `thursday-amount`, `friday-amount`, `saturday-amount`, `sunday-amount`)
            VALUES ('$bookId', '$name', '$mondayAmount', '$tuesdayAmount', '$wednesdayAmount', '$thursdayAmount', '$fridayAmount', '$saturdayAmount', '$sundayAmount')";
            $result = $conn->query($sql);
            $conn->close();
            return $result;
        }

        function insertNewSinglePersonBillToDatabase($weeklyBillSplitModel, $conn){
            $personName = trim($_POST["personName"]);
            $day = trim($_POST["day"]).'-amount';
            $bookId = 0;
            $existingRecordSql = "SELECT `$day` FROM `weekly-bill-split` WHERE name = '$personName'";
            $result = $conn->query($existingRecordSql)->fetch_assoc();
            $existingRecord = $result[$day];
            $newRecord = trim($_POST["billName"]) .':'. trim($_POST["amount"]) .'; ';
            $modifiedRecord = $existingRecord . $newRecord;
            $sql = "UPDATE `weekly-bill-split` SET `$day` = '$modifiedRecord' WHERE `book-id` = '$bookId' AND `name` = '$personName'";
            $result = $conn->query($sql);
            $conn->close();
            return $result;
        }

        function insertNewMultiplePersonBillToDatabase($weeklyBillSplitModel, $conn){
            $sqlToSelectNames = "SELECT name FROM `weekly-bill-split`";
            $names = $conn->query($sqlToSelectNames);
            if ($names->num_rows>0) {
                while ($row = $names->fetch_assoc()) {
                    $personName = $row['name'];
                    $day = trim($_POST["day"]).'-amount';
                    $bookId = 0;
                    $existingRecordSql = "SELECT `$day` FROM `weekly-bill-split` WHERE name = '$personName'";
                    $result = $conn->query($existingRecordSql)->fetch_assoc();
                    $existingRecord = $result[$day];
                    $newRecord = trim($_POST["billName"]) .':'. trim($_POST["amount-for-$personName"]) .'; ';
                    $modifiedRecord = $existingRecord . $newRecord;
                    $sql = "UPDATE `weekly-bill-split` SET `$day` = '$modifiedRecord' WHERE `book-id` = '$bookId' AND `name` = '$personName'";
                    $result = $conn->query($sql);
                }
            }
            $conn->close();
            return $result;                        
        }

        function getDatas($conn){
            $sql = "SELECT * FROM `weekly-bill-split`";
            $result = $conn->query($sql);
            $isEditMode = isset($_GET['query']) && ($_GET['query']) === 'editMode';
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    echo TR_OPEN;
                    if($isEditMode) {
                        echo '
                        <td>
                            <form action="'.$this->deleteSinglePerson($conn).'" method="POST" >
                                <input type="hidden" name="personNameForDeleting" value="'.$row['name'].'">
                                <input type="submit" value="Delete" onClick="return confirmSubmit()">
                            </form> 
                        </td>
                        ';
                    }
                    echo TD_OPEN, $row['name'], TD_CLOSE,
                    TD_OPEN, $row['monday-amount'], TD_CLOSE,
                    TD_OPEN, $row['tuesday-amount'], TD_CLOSE,
                    TD_OPEN, $row['wednesday-amount'], TD_CLOSE,
                    TD_OPEN, $row['thursday-amount'], TD_CLOSE,
                    TD_OPEN, $row['friday-amount'], TD_CLOSE,
                    TD_OPEN, $row['saturday-amount'], TD_CLOSE,
                    TD_OPEN, $row['sunday-amount'], TD_CLOSE,
                    TR_CLOSE;
                }
            }
        }

        function getPersonNamesInSelectOptions($conn){
            $sql = "SELECT name FROM `weekly-bill-split`";
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value = "'.$row['name'].'">'.
                    $row['name'].
                    '</option>';
                }
            }
        }

        function getPersonNamesInDisabledInput($conn){
            $sql = "SELECT name FROM `weekly-bill-split`";
            $result = $conn->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                        <span>'.$row['name'].'</span>
                        <input type="number" name = "amount-for-'.$row['name'].'" placeholder="Amount" /> <br>
                    ';
                }
            }
        }

        function deleteSinglePerson($conn){
            if(!empty($_POST["personNameForDeleting"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
                $personName = trim($_POST["personNameForDeleting"]);
                $sql = "DELETE FROM `weekly-bill-split` WHERE name = '$personName'";
                $result =  $conn->query($sql);
                if($result){
                    echo '<meta http-equiv = "refresh" content = "0; url=/weekly-bill-split?query=editMode"/>';
                }
            }
        }
    }
