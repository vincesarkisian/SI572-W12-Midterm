<?php
    // Gain access to DB
    require_once "db.php";
    // Initialize session for page
    session_start();
?>
<html>
    <head>
        <title>Practical Midterm - Cars</title>
    </head>
    <body>
        <h1>Cars</h1>
<?php
    // Show messages, if any
    if ( isset($_SESSION['sesMessage'] ) ) 
    {
        // Informative message, e.g. Record Added, etc.
        echo '<p style="color:green">' . $_SESSION['sesMessage'] . "</p>\n";
        // Once message has been displayed once clear session
        unset($_SESSION['sesMessage']);
    }
    if ( isset($_SESSION['sesError'] ) ) 
    {
        // Error message, e.g. Value must bu integer, etc.
        echo '<p style="color:red">' . $_SESSION['sesError'] . "</p>\n";
        // Once message has been displayed once clear session
        unset($_SESSION['sesError']);
    } 
?>
        <table border="1">
            <tr>
                <th>Make</th>
                <th>Model</th>
                <th>Year</th>
                <th>Miles</th>
                <th>Price</th>
            </tr>
<?php
    // Create sql command
    $sql = "SELECT id, make, model, year, miles, price FROM cars";
    // Retrieve all records
    $result = mysql_query($sql);
    
    // Iterate for each row retrieved from database
    while ( $row = mysql_fetch_row($result) ) 
    {
        // Display one record per HTML row
?>
            <tr>
                <td><?php echo(htmlentities($row[1])); ?></td>                
                <td align="center"><?php echo(htmlentities($row[2])); ?></td> <!-- Column 2 in table = column 3 in SQL -->
                <td align="center"><?php echo(htmlentities($row[3])); ?></td> <!-- Column 3 in table = column 4 in SQL -->
                <td align="center"><?php echo(htmlentities($row[4])); ?></td> <!-- Column 4 in table = column 5 in SQL -->
                <td align="center"><?php echo(htmlentities($row[5])); ?></td> <!-- Column 5 in table = column 6 in SQL -->
                <td>
                    <!-- Edit/Delete page need to know which data to delete so need to send the id to these page (column 1 in SQL)  -->
                    <a href="delete.php?id=<?php echo(htmlentities($row[0])); ?>">Delete</a> / 
                    <a href="edit.php?id=<?php echo(htmlentities($row[0])); ?>">Edit</a>
                </td>
            </tr>
<?php
    }
?>
        </table>
        <a href="add.php">Add new</a>
    </body>
</html>

