**weekly-bill-split**
<ul>
    <li>
        The idea is to have a table, displaying various bills which the user has entered, calculate and show their different totals. 
    </li>
    <li>
        User has different forms to add and modify the data. (Add New Person, Add New Bill, Create New Book, Change Book and Edit Data)
    </li>
    <li> 
        User needs to create a account, inorder to use the weekly bill split.
    </li>
</ul>

**Methods in Controller :**

**insertNewPerson()** - To add a new person to the biil 

**insertNewBill()** -  To add a new bill to existing person (One person at a time)

**insertNewMultiplePersonBill()** - To add new bill to all the persons 

**getDatas()** - To get the data (comma seperated) from database and render them in a proper way.

**deleteSinglePerson()** - To delete a person from the book.

**createNewBook()** - To create new book.

**changeBook()** - To change the book.

**View:**

<ul>
<li>
    Datatables API is used to render the data in HTML Table
</li>
<li>
    Bootstrap is used for theming.
</li>
<li>
    Bootstrap models are used for Form Pop-ups.
</li>
<li>
    The totals and other rendering are done in the sub methods in Controller
</li>
</ul>
