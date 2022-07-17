<!DOCTYPE html>
<html lang="en">
<?php
    $functions -> loginRequired('weekly-bill-split');
    $weeklyBillSplitController = new WeeklyBillSplitController;
    $isEditMode = isset($_GET['query']) && ($_GET['query']) === 'editMode';
    $displayReloadMessage = $weeklyBillSplitController -> insertNewPerson($weeklyBillSplitModel, $conn, $conn2) || $weeklyBillSplitController -> insertNewBill($conn, $conn2) || $weeklyBillSplitController -> insertNewMultiplePersonBill($conn, $conn2) || $weeklyBillSplitController -> createNewBook($conn, $conn2) || $weeklyBillSplitController -> changeBook($conn, $conn2) || $weeklyBillSplitController -> executeEditPerson($id, $conn, $conn2) || $weeklyBillSplitController -> deleteSinglePerson($conn, $conn2) || $weeklyBillSplitController -> executeEditForIndividualAmounts($id, $conn, $conn2) || $weeklyBillSplitController -> markAsPaidFormAction($conn, $conn2);
    $isEditFormDisplayed = isset($_GET['query']) && ($_GET['query']) === 'editMode' && isset($_GET['id'])  && !isset($_GET['day']);
    $isEditFormDisplayedForIndividualAmounts = isset($_GET['query']) && ($_GET['query']) === 'editMode' && isset($_GET['id']) && isset($_GET['day']);
    $records = $weeklyBillSplitController -> findRecords($conn, $conn2);
?>

<head>
    <title>Weekly Bill Split Tracker</title>
    <script>
        //For avoidinf Confirm Form Submission on reload
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body>
    <?php
        if(isset($weeklyBillSplitController->getBook($conn2)['book-name'])){
    ?>
    <button  title="Add New Person" type="button" class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#addNewPersonModal">
        <i class="bi bi-person-plus-fill"></i>
    </button>
    <?php if($records != "No Records") { ?>
    <button type="button" title="Add New Bill "class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#addBillModal">
        <i class="bi bi-plus-circle"></i>
    </button>
    <button type="button"  title="Add New Bill to All" class="btn btn-success mt-2" data-bs-toggle="modal" data-bs-target="#addMultipleBillModal">
        <i class="bi bi-plus-lg"></i><i class="bi bi-people-fill"></i>
    </button>
    <?php } ?>
    <button type="button"  title="Open Calculator" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#calculatorModal">
        <i class="bi bi-calculator"></i>
    </button>
    <div class="btn-group mt-2">
        <button class="btn btn-primary dropdown-toggle" type="button" id="moreDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
            More
        </button>
        <ul class="dropdown-menu" aria-labelledby="moreDropdownButton">
            <li><a class="dropdown-item" href="/weekly-bill-split?query=editMode">Edit Mode</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#createNewBookModal">Create New Book</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changeBookModal">Change Book</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#markAsPaid">Mark as Paid</a></li>          
        </ul>
    </div>
    <?php
        }
    ?>
    <?php
    if ($isEditMode) {
        echo '<a class = "btn btn-danger mt-2" href="/weekly-bill-split"> Exit Edit Mode </a>';
    }

    if($displayReloadMessage) {
        echo '
        <div class="alignCenter">
            <p class="displayInline"> Updating please wait. </p>
            <div class="spinner-border spinner-border-sm displayInline" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        ' ;
        if(isset($_GET['query']) && ($_GET['query']) === 'editMode'){
            echo '<meta http-equiv = "refresh" content = "0; url=/weekly-bill-split?query=editMode"/>';
        }
        else{
            echo '<meta http-equiv = "refresh" content = "0; url=/weekly-bill-split"/>';
        }
    }

    if ($isEditFormDisplayed || $isEditFormDisplayedForIndividualAmounts) { ?>
        <?php if(!$displayReloadMessage) { ?>
            <div class="editSection alignCenter mt-3">
                <div class="card" style="width: 50rem;">
                <div class="card-body">
                    <h5 class="card-title">Edit</h5>
        <?php } ?>
                    <?php
                        if($isEditFormDisplayed && !$isEditFormDisplayedForIndividualAmounts){
                            $weeklyBillSplitController->renderEditFormForPersonName($_GET['id'], $conn, $conn2, $displayReloadMessage);
                        }
                        elseif(!$isEditFormDisplayed && $isEditFormDisplayedForIndividualAmounts){
                            $weeklyBillSplitController->renderEditFormForIndividualAmounts($_GET['id'], $conn, $conn2, $displayReloadMessage);
                        }
                    ?>
        <?php if(!$displayReloadMessage) { ?>
                </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

    <?php if(!$displayReloadMessage) { ?>
    <?php echo isset($weeklyBillSplitController->getBook($conn2)['book-name']) ? '<p class="mt-3">Book Name : <b>'. $weeklyBillSplitController->getBook($conn2)['book-name'].'</b></p>' : '<p class="text-center mt-2 mb-2"><b>No books found ! </b><a class="text-decoration-none" href="#" data-bs-toggle="modal" data-bs-target="#createNewBookModal">Create New Book</a></p>'; ?>
    <div style="overflow-x: auto;">
        <table class="table table-striped table-borderless center" id="weeklyBillSplitTable">
        <thead>
            <tr>
                <?php
                if ($isEditMode) {
                    echo '
                            <th scope="col" class="text-center min-width-for-td">
                                Action
                            </th>
                            ';
                }
                ?>
                <th scope="col" class="text-center min-width-for-td">
                    Name
                </th>
                <th scope="col" class="text-center today min-width-for-td">
                    Today
                </th>
                <th scope="col" class="text-center yesterday min-width-for-td">
                    Yesterday
                </th>
                <th scope="col" class="text-center min-width-for-td">
                    Monday
                </th>
                <th scope="col" class="text-center min-width-for-td">
                    Tuesday
                </th>
                <th scope="col" class="text-center min-width-for-td">
                    Wednesday
                </th>
                <th scope="col" class="text-center min-width-for-td">
                    Thursday
                </th>
                <th scope="col" class="text-center min-width-for-td">
                    Friday
                </th>
                <th scope="col" class="text-center min-width-for-td">
                    Saturday
                </th>
                <th scope="col" class="text-center min-width-for-td">
                    Sunday
                </th>
                <th scope="col" class="text-center min-width-for-td">
                    Person total
                </th>
            </tr>
        </thead>
        <tbody>
            <?php $weeklyBillSplitController->getDatas($conn, $conn2); ?>
        </tbody>
        <tfoot>
            <?php $weeklyBillSplitController->findAndRenderDayTotal($conn, $conn2); ?>
        </tfoot>
    </table>
    </div>
    <?php } ?>

    <!-- Modals -->
    <!-- Add new person modal -->
    <div class="modal" tabindex="-1" id="addNewPersonModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Person</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php $weeklyBillSplitController->insertNewPerson($weeklyBillSplitModel, $conn, $conn2); ?>" method="POST">
                        <input type="text" class="form-control mb-2" name="name" placeholder="Name of the Person" required>
                        <input type="submit" class="btn btn-success float-end" value="Add">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add New Bill Modal -->
    <div class="modal" tabindex="-1" id="addBillModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Bill to Individuals </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?php $weeklyBillSplitController->insertNewBill($conn, $conn2); ?>" method="POST">
                        <select name="personName" class="form-select mb-2">
                            <?php $weeklyBillSplitController->getPersonNamesInSelectOptions($conn, $conn2); ?>
                        </select>
                        <input type="text" class="form-control mb-2" name="billName" placeholder="Name of the Bill" required>
                        <input type="text" class="form-control mb-2" name="billDesc" placeholder="Description">
                        <input type="text" class="form-control mb-2" name="paymentMode" placeholder="Payment Mode">
                        <select name="day" class="form-select mb-2">
                        <option value="monday" <?php echo strtolower(date('l')) == 'monday' ? 'selected' : '';?> >Monday</option>
                            <option value="tuesday" <?php echo strtolower(date('l')) == 'tuesday' ? 'selected' : '';?> >Tuesday</option>
                            <option value="wednesday" <?php echo strtolower(date('l')) == 'wednesday' ? 'selected' : '';?> >Wednesday</option>
                            <option value="thursday" <?php echo strtolower(date('l')) == 'thursday' ? 'selected' : '';?> >Thursday</option>
                            <option value="friday" <?php echo strtolower(date('l')) == 'friday' ? 'selected' : '';?> >Friday</option>
                            <option value="saturday" <?php echo strtolower(date('l')) == 'saturday' ? 'selected' : '';?> >Saturday</option>
                            <option value="sunday" <?php echo strtolower(date('l')) == 'sunday' ? 'selected' : '';?> >Sunday</option>
                        </select>
                        <input type="number" step="any" class="form-control mb-2" name="amount" placeholder="Amount" required>
                        <input type="submit" class="btn btn-success float-end" value="Add">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add New Bill to All Modal -->
    <div class="modal" tabindex="-1" id="addMultipleBillModal">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Bill to All</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addMultipleBill" method="POST" action="<?php $weeklyBillSplitController->insertNewMultiplePersonBill($weeklyBillSplitModel, $conn) ?>">
                        <input type="text" class="form-control mb-2" name="billName" placeholder="Bill Name" required>
                        <input type="text" class="form-control mb-2" name="billDesc" placeholder="Description">
                        <input type="text" class="form-control mb-2" name="paymentMode" placeholder="Payment Mode">
                        <select name="day" class="form-select mb-2">
                            <option value="monday" <?php echo strtolower(date('l')) == 'monday' ? 'selected' : '';?> >Monday</option>
                            <option value="tuesday" <?php echo strtolower(date('l')) == 'tuesday' ? 'selected' : '';?> >Tuesday</option>
                            <option value="wednesday" <?php echo strtolower(date('l')) == 'wednesday' ? 'selected' : '';?> >Wednesday</option>
                            <option value="thursday" <?php echo strtolower(date('l')) == 'thursday' ? 'selected' : '';?> >Thursday</option>
                            <option value="friday" <?php echo strtolower(date('l')) == 'friday' ? 'selected' : '';?> >Friday</option>
                            <option value="saturday" <?php echo strtolower(date('l')) == 'saturday' ? 'selected' : '';?> >Saturday</option>
                            <option value="sunday" <?php echo strtolower(date('l')) == 'sunday' ? 'selected' : '';?> >Sunday</option>
                        </select>
                        <p class="fw-bold text-center">Split Equally</p>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" id="splitEqualField" placeholder="Amount" aria-label="Amount" aria-describedby="splitEqual">
                            <button class="btn btn-primary" type="button" id="splitEqual" onclick="hideInputFieldsInAddBillToAll()">Split Equally</button>
                        </div>
                        <p class="text-center" id="orInAddToAll"> (or) </p>
                        <p id="individualAmountInAddToAll" class="fw-bold text-center">Split Individually</p>
                        <?php $weeklyBillSplitController->getPersonNamesInDisabledInput($conn, $conn2); ?>
                        <div id="amountSplittedEqually" class="text-success fw-bold"></div>
                        <div id="splitValues"></div>
                        <span class="mt-1 mb-1 me-1"><strong>Total : </strong></span><span id="sumForAddBillToAll">0</span>
                        <input type="number" step="any" id="amountForBillDetails" name="amount" value="" hidden>
                    </form>
                </div>
                <div class="modal-footer">
                    <input type="submit" form="addMultipleBill" class="btn btn-success float-end ms-1" value="Add"> 
                    <input type="reset" form="addMultipleBill" onclick="showInputFieldsInAddBillToAll()" value="Reset" class="btn btn-danger float-end">
                </div>
            </div>
        </div>
    </div>

    <!-- Create New Book Modal -->
    <div class="modal" tabindex="-1" id="createNewBookModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php $weeklyBillSplitController->createNewBook($conn, $conn2) ?>">
                        <input type="text" class="form-control mb-2" name="bookName" placeholder="Book Name" />
                        <input type="submit" class="btn btn-success float-end" value="Create">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Change Book Modal -->
    <div class="modal" tabindex="-1" id="changeBookModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Change Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php $weeklyBillSplitController->changeBook($conn, $conn2) ?>">
                        <select name = "bookIdToChange" class="form-select mb-2">
                            <?php $weeklyBillSplitController->showListOfBooksInSelect($conn, $conn2); ?>
                        </select>
                        <input type="submit" class="btn btn-success float-end" value="Change">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Mark as Paid Modal -->
    <div class="modal" tabindex="-1" id="markAsPaid">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Mark as Paid</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted"> ** Once Marked as Paid could not be reverted back ** </p>
                    <form method="POST" action="<?php $weeklyBillSplitController->markAsPaidFormAction($conn, $conn2) ?>">
                        <?php $weeklyBillSplitController->markAsPaid($conn2); ?>
                        <input type="submit" class="btn btn-success float-end" value="Change">
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>