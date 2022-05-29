<!DOCTYPE html>
<html lang="en">
<?php
    $weeklyBillSplitController = new WeeklyBillSplitController;
    $isEditMode = isset($_GET['query']) && ($_GET['query']) === 'editMode';
    $displayReloadMessage = $weeklyBillSplitController -> insertNewPerson($weeklyBillSplitModel, $conn) || $weeklyBillSplitController -> insertNewBill($weeklyBillSplitModel, $conn) || $weeklyBillSplitController -> insertNewMultiplePersonBill($weeklyBillSplitModel, $conn);
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        //For avoidinf Confirm Form Submission on reload
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</head>

<body>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addNewPersonModal">
        Add New Person
    </button>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addBillModal">
        Add New Bill
    </button>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMultipleBillModal">
        Add New Bill to All
    </button>
    <div class="btn-group">
        <button class="btn btn-primary dropdown-toggle" type="button" id="moreDropdownButton" data-bs-toggle="dropdown" aria-expanded="false">
            More
        </button>
        <ul class="dropdown-menu" aria-labelledby="moreDropdownButton">
            <li><a class="dropdown-item" href="/weekly-bill-split?query=editMode">Edit Mode</a></li>
        </ul>
    </div>
    <?php
    if ($isEditMode) {
        echo '<a class = "btn btn-danger" href="/weekly-bill-split"> Exit Edit Mode </a>';
    }
    ?>
    <?php if($displayReloadMessage) {
        echo '<p class="text-center"> Record added, updating please wait. </p>';
        echo '<meta http-equiv = "refresh" content = "0; url=/weekly-bill-split"/>';
    }?>

    <?php if(!$displayReloadMessage) { ?>
    <table class="table table-borderless">
        <thead>
            <tr>
                <?php
                if ($isEditMode) {
                    echo '
                            <th scope="col">
                                Action
                            </th>
                            ';
                }
                ?>
                <th scope="col">
                    Name
                </th>
                <th scope="col">
                    Monday
                </th>
                <th scope="col">
                    Tuesday
                </th>
                <th scope="col">
                    Wednesday
                </th>
                <th scope="col">
                    Thursday
                </th>
                <th scope="col">
                    Friday
                </th>
                <th scope="col">
                    Saturday
                </th>
                <th scope="col">
                    Sunday
                </th>
            </tr>
        </thead>
        <tbody>
            <?php $weeklyBillSplitController->getDatas($conn); ?>
        </tbody>
    </table>
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
                    <form action="<?php $weeklyBillSplitController->insertNewPerson($weeklyBillSplitModel, $conn); ?>" method="POST">
                        <input type="text" name="name" placeholder="Name of the Person"><br>
                        <input type="text" name="billName" placeholder="Name of the Bill"><br>
                        <select name="day">
                            <option value="monday" <?php echo strtolower(date('l')) == 'monday' ? 'selected' : '';?> >Monday</option>
                            <option value="tuesday" <?php echo strtolower(date('l')) == 'tuesday' ? 'selected' : '';?> >Tuesday</option>
                            <option value="wednesday" <?php echo strtolower(date('l')) == 'wednesday' ? 'selected' : '';?> >Wednesday</option>
                            <option value="thursday" <?php echo strtolower(date('l')) == 'thursday' ? 'selected' : '';?> >Thursday</option>
                            <option value="friday" <?php echo strtolower(date('l')) == 'friday' ? 'selected' : '';?> >Friday</option>
                            <option value="saturday" <?php echo strtolower(date('l')) == 'saturday' ? 'selected' : '';?> >Saturday</option>
                            <option value="sunday" <?php echo strtolower(date('l')) == 'sunday' ? 'selected' : '';?> >Sunday</option>
                        </select>
                        <input type="text" name="amount" placeholder="Amount"><br>
                        <input type="submit" class="btn btn-success" value="Add">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
                    <form action="<?php $weeklyBillSplitController->insertNewBill($weeklyBillSplitModel, $conn); ?>" method="POST">
                        <select name="personName">
                            <?php $weeklyBillSplitController->getPersonNamesInSelectOptions($conn); ?>
                        </select>
                        <input type="text" name="billName" placeholder="Name of the Bill"><br>
                        <select name="day">
                        <option value="monday" <?php echo strtolower(date('l')) == 'monday' ? 'selected' : '';?> >Monday</option>
                            <option value="tuesday" <?php echo strtolower(date('l')) == 'tuesday' ? 'selected' : '';?> >Tuesday</option>
                            <option value="wednesday" <?php echo strtolower(date('l')) == 'wednesday' ? 'selected' : '';?> >Wednesday</option>
                            <option value="thursday" <?php echo strtolower(date('l')) == 'thursday' ? 'selected' : '';?> >Thursday</option>
                            <option value="friday" <?php echo strtolower(date('l')) == 'friday' ? 'selected' : '';?> >Friday</option>
                            <option value="saturday" <?php echo strtolower(date('l')) == 'saturday' ? 'selected' : '';?> >Saturday</option>
                            <option value="sunday" <?php echo strtolower(date('l')) == 'sunday' ? 'selected' : '';?> >Sunday</option>
                        </select>
                        <input type="text" name="amount" placeholder="Amount"><br>
                        <input type="submit" class="btn btn-success" value="Add">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add New Bill to All Modal -->
    <div class="modal" tabindex="-1" id="addMultipleBillModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Bill to All</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?php $weeklyBillSplitController->insertNewMultiplePersonBill($weeklyBillSplitModel, $conn) ?>">
                        <input type="text" name="billName" placeholder="Bill Name" /> <br>
                        <select name="day">
                        <option value="monday" <?php echo strtolower(date('l')) == 'monday' ? 'selected' : '';?> >Monday</option>
                            <option value="tuesday" <?php echo strtolower(date('l')) == 'tuesday' ? 'selected' : '';?> >Tuesday</option>
                            <option value="wednesday" <?php echo strtolower(date('l')) == 'wednesday' ? 'selected' : '';?> >Wednesday</option>
                            <option value="thursday" <?php echo strtolower(date('l')) == 'thursday' ? 'selected' : '';?> >Thursday</option>
                            <option value="friday" <?php echo strtolower(date('l')) == 'friday' ? 'selected' : '';?> >Friday</option>
                            <option value="saturday" <?php echo strtolower(date('l')) == 'saturday' ? 'selected' : '';?> >Saturday</option>
                            <option value="sunday" <?php echo strtolower(date('l')) == 'sunday' ? 'selected' : '';?> >Sunday</option>
                        </select> <br>
                        <?php $weeklyBillSplitController->getPersonNamesInDisabledInput($conn); ?>
                        <input type="submit" class="btn btn-success" value="Add">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>