<?php
    // Gain access to DB
    require_once "db.php";
    // Initialize session for page
    session_start();
    
    // Check if id was sent to the page, we need it to know what to edit
    if (isset($_GET['id']) === FALSE) {
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
    if ( isset($_POST['txtMake']) && 
         isset($_POST['txtModel']) && 
         isset($_POST['txtYear']) && 
         isset($_POST['txtMiles']) && 
         isset($_POST['txtPrice']) ) {
        // Came to this page because of the form submission.
        
        // Safeguard entered values 
        $make = trim(mysql_real_escape_string($_POST['txtMake']));
        $model = trim(mysql_real_escape_string($_POST['txtModel']));
        $year = trim(mysql_real_escape_string($_POST['txtYear']));
        $miles = trim(mysql_real_escape_string($_POST['txtMiles']));
        $price = trim(mysql_real_escape_string($_POST['txtPrice']));
        $id = mysql_real_escape_string($_POST['hdnID']);
        
        // Various checks of entered values
        if ( empty($make) )
            // Value for make is an empty string
            // Set error message to display in index page
            $_SESSION['sesError'] = "Edit Error: Make cannot be an empty string";
        elseif ( empty($model) )
            // Value for model is an empty string
            // Set error message to display in index page
            $_SESSION['sesError'] = "Edit Error: Model cannot be an empty string";
        elseif ( empty($year) )
            // Value for year is an empty string
            // Set error message to display in index page
            $_SESSION['sesError'] = "Edit Error: Year cannot be empty";
        elseif ( is_numeric($year) === False )
            // Value for year is not numeric
            // Set error message to display in index page
            $_SESSION['sesError'] = "Edit Error: Year must be an interger";
        elseif ( empty($miles) )
            // Value for miles is an empty string
            // Set error message to display in index page
            $_SESSION['sesError'] = "Edit Error: Miles cannot be empty";
        elseif ( is_numeric($miles) === False ) 
            // Value for miles is not numeric
            // Set error message to display in index page
            $_SESSION['sesError'] = "Edit Error: Miles must be an interger";
        elseif ( empty($price) )
            // Value for price is an empty string
            // Set error message to display in index page
            $_SESSION['sesError'] = "Edit Error: Price cannot be empty";
        elseif ( is_numeric($price) === False ) 
            // Value for price is not numeric
            // Set error message to display in index page
            $_SESSION['sesError'] = "Edit Error: Prices must be an interger";
        else {
            // Everything is ok so update record
            $sql = "UPDATE cars
                    SET make='$make', model='$model', year=$year, miles=$miles, price=$price 
                    WHERE id=$id";
            mysql_query($sql);
            
            // Set message to display back in index page
            $_SESSION['sesMessage'] = 'Record updated';
        }
        // Redirect to index page
        header( 'Location: index.php' );
        // Suspend further execution of this page and wait for redirect
        return;
    }

    // Came to this page because of clicking the link from the index page
        
    // Get ID of the track to edit
    $id = $_GET['id'];
        
    // Get data to pre-populate fields in the form.
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
        <title>Practical Midterm - Update car</title>
    </head>
    <body>
        <h1>Update car</h1>
        <form method="post">
            <table border="0">
                <tr>
                    <td align="right">Make</td>
                    <td>:</td>
                    <td>
                        <input type="text" 
                               name="txtMake" 
                               value="<?php echo $make; ?>">
                    </td>
                </tr>
                <tr>
                    <td align="right">Model</td>
                    <td>:</td>
                    <td>
                        <input type="text" 
                               name="txtModel" 
                               value="<?php echo $model; ?>">
                    </td>
                </tr>
                <tr>
                    <td align="right">Year</td>
                    <td>:</td>
                    <td>
                        <input type="text" 
                               name="txtYear" 
                               value="<?php echo $year; ?>">
                    </td>
                </tr>
                <tr>
                    <td align="right">Miles</td>
                    <td>:</td>
                    <td>
                        <input type="text" 
                               name="txtMiles" 
                               value="<?php echo $miles; ?>">
                    </td>
                </tr>
                <tr>
                    <td align="right">Price</td>
                    <td>:</td>
                    <td>
                        <input type="text" 
                               name="txtPrice" 
                               value="<?php echo $price; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <input type="hidden" 
                               name="hdnID" 
                               value="<?php echo $id; ?>"/>
                        <input type="submit" 
                               value="Update"/>
                        &nbsp;&nbsp;
                        <a href="index.php">Cancel</a>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>

