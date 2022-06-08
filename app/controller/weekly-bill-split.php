<?php
    $weeklyBillSplitModel = new WeeklyBillSplitModel;
    const TD_OPEN = '<td>';
    const TD_CLOSE = '</td>';
    const TR_OPEN = '<tr>';
    const TR_CLOSE = '</tr>';
    const BR_TAG = '<br>';
    const TOTAL_OPEN = '<b>';
    const TOTAL_CLOSE = '</b>';
    const DIV_OPEN = '<div>';
    const DIV_CLOSE = '</div>';
    const TD_YESTERDAY = '<td class="yesterday">';
    const TD_TODAY = '<td class="today">';
    const CURRENCY = ' ₹';


    class WeeklyBillSplitController{
        //Add New Person
        function insertNewPerson($weeklyBillSplitModel, $conn, $conn2){
            if(!empty($_POST["name"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
                $result = $this -> insertNewPersonToDatabase($weeklyBillSplitModel, $conn, $conn2);
            }
            return $result;
        }
        //Add New Bill to Single Person
        function insertNewBill($conn, $conn2){
            if(!empty($_POST["personName"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
                $result = $this -> insertNewSinglePersonBillToDatabase($conn, $conn2);
            }
            return $result;
        }
        //Add New Bill to Multiple Person
        function insertNewMultiplePersonBill($conn, $conn2){
            if(!empty($_POST["billName"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
                $result = $this -> insertNewMultiplePersonBillToDatabase($conn, $conn2);
            }
            return $result;
        }

        //To get and render the data for HTML
        function getDatas($conn, $conn2){
            $bookId = $this->getBook($conn2)['book-id'];
            $sql = "SELECT * FROM `weekly-bill-split` WHERE `book-id` = '$bookId'";
            $result = $conn2->query($sql);
            $isEditMode = isset($_GET['query']) && ($_GET['query']) === 'editMode';
            $today = strtolower(date('l')).'-amount';
            $yesterday = strtolower(date('l',strtotime("-1 days"))).'-amount';
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    $id = $row['id'];
                    $individualRecordEditButton = $isEditMode ? '<br><a class="ml-1 text-danger" href="/weekly-bill-split?query=editMode&id='.$id.'&day=#day"> <i class="bi bi-pencil-square"></i></a>' : '';
                    echo TR_OPEN;
                    if($isEditMode) {
                        echo '
                        <td>
                            <form action="'.$this->deleteSinglePerson($conn, $conn2).'" method="POST">
                                <input type="hidden" name="personForDeleting" value="'.$id.'">
                                <button title="Delete Person" class="btn btn-sm btn-danger"type="submit" onClick="return confirmSubmit()"> <i class="bi bi-trash-fill "></i></button>
                            </form>
                            <a title ="Edit Person Name" class="btn btn-sm btn-danger mt-1" href="/weekly-bill-split?query=editMode&id='.$id.'"> <i class="bi bi-pencil-square"></i></a>
                        </td>
                        ';
                    }
                    echo TD_OPEN, $row['name'], TD_CLOSE,
                    TD_TODAY, DIV_OPEN, $this -> removeSymbolsAndFormatData($row[$today]), DIV_CLOSE, TOTAL_OPEN, $this ->  individualDayTotal($row[$today]), TOTAL_CLOSE, TD_CLOSE,
                    TD_YESTERDAY, DIV_OPEN, $this -> removeSymbolsAndFormatData($row[$yesterday]), DIV_CLOSE, TOTAL_OPEN, $this ->  individualDayTotal($row[$yesterday]), TOTAL_CLOSE, TD_CLOSE,

                    TD_OPEN, DIV_OPEN, $this -> removeSymbolsAndFormatData($row['monday-amount']), DIV_CLOSE, TOTAL_OPEN, $this ->  individualDayTotal($row['monday-amount']), TOTAL_CLOSE, str_replace("#day", "monday-amount", $individualRecordEditButton), TD_CLOSE,
                    TD_OPEN, DIV_OPEN, $this -> removeSymbolsAndFormatData($row['tuesday-amount']), DIV_CLOSE, TOTAL_OPEN, $this ->  individualDayTotal($row['tuesday-amount']), TOTAL_CLOSE, str_replace("#day", "tuesday-amount", $individualRecordEditButton), TD_CLOSE,
                    TD_OPEN, DIV_OPEN, $this -> removeSymbolsAndFormatData($row['wednesday-amount']), DIV_CLOSE, TOTAL_OPEN, $this ->  individualDayTotal($row['wednesday-amount']), TOTAL_CLOSE, str_replace("#day", "wednesday-amount", $individualRecordEditButton), TD_CLOSE,
                    TD_OPEN, DIV_OPEN, $this -> removeSymbolsAndFormatData($row['thursday-amount']), DIV_CLOSE, TOTAL_OPEN, $this ->  individualDayTotal($row['thursday-amount']), TOTAL_CLOSE, str_replace("#day", "thursday-amount", $individualRecordEditButton), TD_CLOSE,
                    TD_OPEN, DIV_OPEN, $this -> removeSymbolsAndFormatData($row['friday-amount']), DIV_CLOSE, TOTAL_OPEN, $this ->  individualDayTotal($row['friday-amount']), TOTAL_CLOSE, str_replace("#day", "friday-amount", $individualRecordEditButton), TD_CLOSE,
                    TD_OPEN, DIV_OPEN, $this -> removeSymbolsAndFormatData($row['saturday-amount']), DIV_CLOSE, TOTAL_OPEN, $this ->  individualDayTotal($row['saturday-amount']), TOTAL_CLOSE, str_replace("#day", "saturday-amount", $individualRecordEditButton), TD_CLOSE,
                    TD_OPEN, DIV_OPEN, $this -> removeSymbolsAndFormatData($row['sunday-amount']), DIV_CLOSE, TOTAL_OPEN, $this ->  individualDayTotal($row['sunday-amount']), TOTAL_CLOSE, str_replace("#day", "sunday-amount", $individualRecordEditButton), TD_CLOSE,
                    TD_OPEN, DIV_OPEN, $this -> findIndividualWeekTotal($row), CURRENCY, TD_CLOSE,
                    TR_CLOSE;
                }
            }
        }

        function findRecords($conn, $conn2){
            $bookId = $this->getBook($conn2)['book-id'];
            $sql = "SELECT * FROM `weekly-bill-split` WHERE `book-id` = '$bookId'";
            $result = $conn2->query($sql);
            if ($result->num_rows>0) {
                return $result->num_rows . ' rows found';
            }
            else{
                return "No Records";
            }
        }

        //To delete a person from the book
        function deleteSinglePerson($conn, $conn2){
            if(!empty($_POST["personForDeleting"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
                $bookId = $this->getBook($conn2)['book-id'];
                $person = trim($_POST["personForDeleting"]);
                $sql = "DELETE FROM `weekly-bill-split` WHERE `id` = '$person' AND `book-id` = '$bookId'";
                $result =  $conn->query($sql);
            }
            return $result;
        }

        //To create new book
        function createNewBook($conn, $conn2){
            if(!empty($_POST["bookName"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
                $bookName = trim($_POST["bookName"]);
                $user = $_SESSION["username"];
                //To Deselect old book
                {
                    $currentBookId = $this -> getBook($conn2)['book-id'];
                    $sqlToDeselectOldBook = "UPDATE `books` SET `is_selected_book` = null WHERE `book-id` = '$currentBookId'";
                    $conn->query($sqlToDeselectOldBook);
                }
                $sql = "INSERT into `books` (`book-name`, `user`, is_selected_book) VALUES ('$bookName', '$user', 1)";
                $result = $conn->query($sql);
                $conn->close();
            }
            return $result;
        }
        
        //To change the book
        function changeBook($conn, $conn2){
            if(!empty($_POST["bookIdToChange"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
                $bookToChange = trim($_POST["bookIdToChange"]);
                $currentBookId = $this -> getBook($conn2)['book-id'];
                $sqlToDeselectOldBook = "UPDATE `books` SET `is_selected_book` = null WHERE `book-id` = '$currentBookId'";
                $isOldBookDeselected = $conn->query($sqlToDeselectOldBook);
                if($isOldBookDeselected){
                    $sql = "UPDATE `books` SET `is_selected_book` = 1 WHERE `book-id` = '$bookToChange'";
                    $result = $conn->query($sql);
                    $conn->close();
                }
            }
            return $result;
        }

        //Sub methods goes below
        function insertNewPersonToDatabase($weeklyBillSplitModel, $conn, $conn2){
            $weeklyBillSplitModel -> setName(trim($_POST["name"]));
            $bookId = $this->getBook($conn2)['book-id'];
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

        function insertNewSinglePersonBillToDatabase($conn, $conn2){
            $personName = trim($_POST["personName"]);
            $day = trim($_POST["day"]).'-amount';
            $bookId = $this->getBook($conn2)['book-id'];
            $existingRecordSql = "SELECT `$day` FROM `weekly-bill-split` WHERE `name` = '$personName' AND `book-id` = '$bookId'";
            $result = $conn2->query($existingRecordSql)->fetch_assoc();
            $existingRecord = $result[$day];
            $newRecord = trim($_POST["billName"]) .':'. trim($_POST["amount"]) .'; ';
            $modifiedRecord = $existingRecord . $newRecord;
            $sql = "UPDATE `weekly-bill-split` SET `$day` = '$modifiedRecord' WHERE `book-id` = '$bookId' AND `name` = '$personName'";
            $result = $conn->query($sql);
            $conn->close();
            return $result;
        }

        function insertNewMultiplePersonBillToDatabase($conn, $conn2){
            $bookId = $this->getBook($conn2)['book-id'];
            $sqlToSelectNames = "SELECT name FROM `weekly-bill-split` WHERE `book-id` = '$bookId'";
            $names = $conn2->query($sqlToSelectNames);
            if ($names->num_rows>0) {
                while ($row = $names->fetch_assoc()) {
                    $personName = $row['name'];
                    $day = trim($_POST["day"]).'-amount';
                    $existingRecordSql = "SELECT `$day` FROM `weekly-bill-split` WHERE `name` = '$personName' AND `book-id` = '$bookId'";
                    $result = $conn2->query($existingRecordSql)->fetch_assoc();
                    $existingRecord = $result[$day];
                    $newRecord = trim($_POST["amount-for-$personName"]) == '' ? '' : trim($_POST["billName"]) .':'. trim($_POST["amount-for-$personName"]) .'; ';
                    $modifiedRecord = $existingRecord . $newRecord;
                    $sql = "UPDATE `weekly-bill-split` SET `$day` = '$modifiedRecord' WHERE `book-id` = '$bookId' AND `name` = '$personName'";
                    $result = $conn->query($sql);
                }
                $conn->close();
            }
            return $result;                        
        }

        function removeSymbolsAndFormatData($data){
            $data = str_replace(':', ' : ', $data);
            $data = str_replace(';','<br>', $data);
            return $data; 
        }

        function individualDayTotal($data){
            $amountArray = array();
            $amountValuesArray = array();
            $amountBillNameArray = explode(';', trim($data));
            foreach($amountBillNameArray as $amountBillName){
                $amountArray[] = explode(':', trim($amountBillName));
            }
            foreach($amountArray as $amount){
                $amountValuesArray[] = $amount[1];
            }
            $total = array_sum($amountValuesArray).CURRENCY;
            if($total == '0'.CURRENCY){
                $total = "-";
            }
            return $total;
        }

        function findIndividualWeekTotal($row) {
            $days = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday');
            $daysAmount = array();
            foreach($days as $day){
                $day = $day.'-amount';
                $daysAmount[] = $this -> individualDayTotal($row[$day]);
            }
            return array_sum($daysAmount);
        }

        function findAndRenderDayTotal($conn, $conn2){
            $bookId = $this->getBook($conn2)['book-id'];
            $sql = "SELECT * FROM `weekly-bill-split` WHERE `book-id` = '$bookId'";
            $result = $conn2->query($sql);
            $isEditMode = isset($_GET['query']) && ($_GET['query']) === 'editMode';
            $today = strtolower(date('l')).'-amount';
            $yesterday = strtolower(date('l',strtotime("-1 days"))).'-amount';
            $mondayAmount = array();
            $tuesdayAmount = array();
            $wednesdayAmount = array();
            $thursdayAmount = array();
            $fridayAmount = array();
            $saturdayAmount = array();
            $sundayAmount = array();
            $todayAmount = array();
            $yesterdayAmount = array();
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    $todayAmount[] = $this -> individualDayTotal($row[$today]);
                    $yesterdayAmount[] = $this -> individualDayTotal($row[$yesterday]);
                    $mondayAmount[] = $this -> individualDayTotal($row['monday-amount']);
                    $tuesdayAmount[] = $this -> individualDayTotal($row['tuesday-amount']);
                    $wednesdayAmount[] = $this -> individualDayTotal($row['wednesday-amount']);
                    $thursdayAmount[] = $this -> individualDayTotal($row['thursday-amount']);
                    $fridayAmount[] = $this -> individualDayTotal($row['friday-amount']);
                    $saturdayAmount[] = $this -> individualDayTotal($row['saturday-amount']);
                    $sundayAmount[] = $this -> individualDayTotal($row['sunday-amount']);
                }
            }
            echo TR_OPEN;
            if($isEditMode){
                echo TD_OPEN, TD_CLOSE;
            }
                echo TD_OPEN, '<b> Day total </b>' , TD_CLOSE, //For Name Column
                TD_TODAY, array_sum($todayAmount), CURRENCY, TD_CLOSE, 
                TD_YESTERDAY, array_sum($yesterdayAmount), CURRENCY, TD_CLOSE,
                TD_OPEN, array_sum($mondayAmount), CURRENCY, TD_CLOSE,
                TD_OPEN, array_sum($tuesdayAmount), CURRENCY, TD_CLOSE,
                TD_OPEN, array_sum($wednesdayAmount), CURRENCY, TD_CLOSE,
                TD_OPEN, array_sum($thursdayAmount), CURRENCY, TD_CLOSE,
                TD_OPEN, array_sum($fridayAmount), CURRENCY, TD_CLOSE,
                TD_OPEN, array_sum($saturdayAmount), CURRENCY, TD_CLOSE,
                TD_OPEN, array_sum($sundayAmount), CURRENCY, TD_CLOSE,
                TD_OPEN, TD_CLOSE, //For Person Total Column
            TR_CLOSE;
        }

        function getPersonNamesInSelectOptions($conn, $conn2){
            $bookId = $this -> getBook($conn2)['book-id'];
            $sql = "SELECT name FROM `weekly-bill-split` WHERE `book-id` = '$bookId'";
            $result = $conn2->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<option value = "'.$row['name'].'">'.
                    $row['name'].
                    '</option>';
                }
            }
        }

        function getPersonNamesInDisabledInput($conn, $conn2){
            $bookId = $this -> getBook($conn2)['book-id'];
            $sql = "SELECT name FROM `weekly-bill-split` WHERE `book-id` = '$bookId'";
            $result = $conn2->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                        <label for="'.$row['id'].'" class="form-label labelForAddBillToAll">'.$row['name'].'</label>
                        <input type="number" class="form-control mb-2 inputForAddBillToAll" value="" name = "amount-for-'.$row['name'].'" placeholder="Amount" id="'.$row['id'].'" />
                    ';
                }
            }
        }        

        function getBook($conn2){
            $user =  $_SESSION["username"];
            $sql = "SELECT `book-id`, `book-name` FROM `books` WHERE user = '$user' AND is_selected_book = 1";
            $result = $conn2->query($sql);
            $row = $result->fetch_assoc();
            return $row;
        }

        function showListOfBooksInSelect($conn, $conn2){
            $user =  $_SESSION["username"];
            $currentBookId = $this -> getBook($conn2)['book-id'];
            $sql = "SELECT `book-name`, `book-id` FROM `books` WHERE user = '$user'";
            $result = $conn2->query($sql);
            if ($result->num_rows>0) {
                while ($row = $result->fetch_assoc()) {
                    $selected = $row['book-id'] == $currentBookId ? ' selected' : '';
                    echo '<option value = "'.$row['book-id'].'" '.$selected.'>'.
                    $row['book-name'].
                    '</option>';
                }
            }
        }

        function renderEditFormForPersonName($id, $conn, $conn2){
            $sql = "SELECT `name` FROM `weekly-bill-split` WHERE id = '$id' ";
            $result = $conn2->query($sql);
            $row = $result->fetch_assoc();
            $isEditFormDisplayed = isset($_GET['query']) && ($_GET['query']) === 'editMode' && isset($_GET['id']);
            if($isEditFormDisplayed){
                echo '
                    <form action = "" method = "POST">
                        <input type = "text" class="form-control mb-2" name="personNameForEdit" value="'.$row['name'].'">
                        <input type = "submit" name="EditPerson" class="btn btn-success float-end" value = "Edit">
                    </form>
                ';
            }
            $this -> executeEditPerson($id, $conn, $conn2);
        }

        function executeEditPerson($id, $conn, $conn2){
            if(isset($_POST['EditPerson'])){
                $bookId = $this -> getBook($conn2)['book-id'];
                $personName = $_POST['personNameForEdit'];
                $sql = "UPDATE `weekly-bill-split` SET `name` = '$personName' WHERE `book-id` = '$bookId' AND `id` = '$id'";
                $updateResult = $conn->query($sql);
            }
            return $updateResult;
        }

        function renderEditFormForIndividualAmounts($id, $conn, $conn2){
            $sql = "SELECT * FROM `weekly-bill-split` WHERE id = '$id' ";
            $result = $conn2->query($sql);
            $row = $result->fetch_assoc();
            $isEditFormDisplayedForIndividualAmounts = isset($_GET['query']) && ($_GET['query']) === 'editMode' && isset($_GET['id']) && isset($_GET['day']);
            if($isEditFormDisplayedForIndividualAmounts){
                $day = $_GET['day'];
                echo '
                    <form action = "" method = "POST">
                    <p class="text-muted"> ** Please maintain the Comma Seperated Format ** </p>
                    <span>Name</span><input type = "text" class="form-control mb-2" name="personNameForEdit" value="'.$row['name'].'">
                    <span>'.str_replace('-amount','',ucfirst($day)).' </span><input type = "text" class="form-control mb-2" name = "monday-amount" value="'.$row[$day].'">
                    <input type = "submit" class="btn btn-success float-end" name="EditIndividual" value = "Edit">
                    </form>
                ';
            }
            $this -> executeEditForIndividualAmounts($id, $conn, $conn2);
        }

        function executeEditForIndividualAmounts($id, $conn, $conn2){
            if(isset($_POST['EditIndividual'])){
                $personName = $_POST['personNameForEdit'];
                $mondayAmount = $_POST['monday-amount'];
                $tuesdayAmount = $_POST['tuesday-amount'];
                $wednesdayAmount = $_POST['wednesday-amount'];
                $thursdayAmount = $_POST['thursday-amount'];
                $fridayAmount = $_POST['friday-amount'];
                $saturdayAmount = $_POST['saturday-amount'];
                $sundayAmount = $_POST['sunday-amount'];
                $sql = "UPDATE `weekly-bill-split` SET `name` = '$personName', `monday-amount` = '$mondayAmount',`tuesday-amount` = '$tuesdayAmount', `wednesday-amount` = '$wednesdayAmount', `thursday-amount` = '$thursdayAmount',`friday-amount` = '$fridayAmount', `saturday-amount` = '$saturdayAmount', `sunday-amount` = '$sundayAmount'  WHERE `id` = '$id'";
                $updateResult = $conn->query($sql);
            }
            return $updateResult;
        }
    }
?>
