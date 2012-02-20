<?php
    // Gain access to DB
    require_once "db.php";
    // Initialize session for page
    session_start();
    
    // Check if id was sent to the page, we need it to know what to delete
    if (isset($_GET['id']) === FALSE) 
    {
        // No id wsa sent
        
        // Set error message
        $_SESSION['sesError'] = "Unknown identifier";
        // Redirect to index page
        header( 'Location: index.php' );
        // Suspend further execution of this page and wait for redirect
        return;
    }
    
    // Need to check whether the user came to this page because of clicking the
    // link from the index page or because of the form submission in this page.
    if ( isset($_POST['hdnID']) ) 
    {
        // Came to this page because of the form submission.
        
        // Safeguard entered values 
        $id = mysql_real_escape_string($_POST['hdnID']);
         
        // Everything is ok so delete record
        $sql = "DELETE FROM cars WHERE id = $id";
        mysql_query($sql);
        
        // Set message to display back in index page
        $_SESSION['sesMessage'] = 'Record deleted';
        
        // Redirect to index page
        header( 'Location: index.php' );
        // Suspend further execution of this page
        return;
    }
    
    // Came to this page because of clicking the link from the index page

    // Get id of the track to delete
    $id = $_GET['id'];
        
    // Get data of tracks to display in the page
    $sql = "SELECT id, make, model, year, miles, price FROM cars WHERE id=$id";
    $result = mysql_query($sql);

    // Make sure the SQL was a success and there is such a row with that id
    if ($result === false) {
        // No such row
        $_SESSION['sesError'] = "Unknown identifier";
        // Redirect to index page
        header( 'Location: index.php' );
        // Suspend further execution of this page and wait for redirect
        return;
    }

    // Because id is a primary key, SQL will return max 1 row
    $row = mysql_fetch_row($result);

    // Safeguard retrieved values
    $id = htmlentities($row[0]);
    $make = htmlentities($row[1]);
    $model = htmlentities($row[2]);
    $year = htmlentities($row[3]);
    $miles = htmlentities($row[4]);
    $price = htmlentities($row[5]);
?>
<html>
    <head>
        <title>Practical Midterm - Delete car</title>
    </head>
    <body>
        <h1>Delete car</h1>
        <form method="post">
            <table border="0">
                <tr>
                    <td align="right">Make</td>
                    <td>:</td>
                    <td><?php echo $make; ?></td>
                </tr>
                <tr>
                    <td align="right">Model</td>
                    <td>:</td>
                    <td><?php echo $model; ?></td>
                </tr>
                <tr>
                    <td align="right">Year</td>
                    <td>:</td>
                    <td><?php echo $year; ?></td>
                </tr>
                <tr>
                    <td align="right">Miles</td>
                    <td>:</td>
                    <td><?php echo $miles; ?></td>
                </tr>
                <tr>
                    <td align="right">Price</td>
                    <td>:</td>
                    <td><?php echo $price; ?></td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <input type="hidden" 
                               name="hdnID" 
                               value="<?php echo $id; ?>"/>
                        <input type="submit" 
                               value="Delete" 
                               name="btnDelete"/>
                        &nbsp;&nbsp;
                        <a href="index.php">Cancel</a>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>

