<?php
    // Gain access to DB
    require_once "db.php";
    // Initialize session for page
    session_start();
    
    // Need to check whether the user came to this page because of clicking the
    // link from the index page or because of the form submission in this page.
    if ( isset($_POST['txtMake']) && 
         isset($_POST['txtModel']) && 
         isset($_POST['txtYear']) && 
         isset($_POST['txtMiles']) && 
         isset($_POST['txtPrice']) ) 
    {
        // Came to this page because of the form submission.

        // Safeguard entered values 
        $make = trim(mysql_real_escape_string($_POST['txtMake']));
        $model = trim(mysql_real_escape_string($_POST['txtModel']));
        $year = trim(mysql_real_escape_string($_POST['txtYear']));
        $miles = trim(mysql_real_escape_string($_POST['txtMiles']));
        $price = trim(mysql_real_escape_string($_POST['txtPrice']));
        
        // Various checks of entered values
        if ( empty($make) )
            // Value for make is an empty string
            // Set error message to display in index page
            $_SESSION['sesError'] = "Add Error: Make cannot be an empty string";
        elseif ( empty($model) )
            // Value for model is an empty string
            // Set error message to display in index page
            $_SESSION['sesError'] = "Add Error: Model cannot be an empty string";
        elseif ( empty($year) )
            // Value for year is an empty string
            // Set error message to display in index page
            $_SESSION['sesError'] = "Add Error: Year cannot be empty";
        elseif ( is_numeric($year) === False )
            // Value for year is not numeric
            // Set error message to display in index page
            $_SESSION['sesError'] = "Add Error: Year must be an interger";
        elseif ( empty($miles) )
            // Value for miles is an empty string
            // Set error message to display in index page
            $_SESSION['sesError'] = "Add Error: Miles cannot be empty";
        elseif ( is_numeric($miles) === False ) 
            // Value for miles is not numeric
            // Set error message to display in index page
            $_SESSION['sesError'] = "Add Error: Miles must be an interger";
        elseif ( empty($price) )
            // Value for price is an empty string
            // Set error message to display in index page
            $_SESSION['sesError'] = "Add Error: Price cannot be empty";
        elseif ( is_numeric($price) === False ) 
            // Value for price is not numeric
            // Set error message to display in index page
            $_SESSION['sesError'] = "Add Error: Prices must be an interger";
        else 
        {
            // Everything is ok so insert new record
            $sql = "INSERT INTO cars (make, model, year, miles, price)
                    VALUES ('$make', '$model', $year, $miles, $price)";
            mysql_query($sql);
            
            // Set message to display in index page
            $_SESSION['sesMessage'] = 'Record Added';
        }
        // Redirect to index page
        header( 'Location: index.php' );        
        // Suspend further execution of this page and wait for redirect
        return;
    }
?>
<html>
    <head>
        <title>Practical Midterm - Add a new car</title>
    </head>
    <body>
        <h1>Add a new car</h1>
        <form method="post">
            <table border="0">
                <tr>
                    <td align="right">Make</td>
                    <td>:</td>
                    <td><input type="text" name="txtMake"></td>
                </tr>
                <tr>
                    <td align="right">Model</td>
                    <td>:</td>
                    <td><input type="text" name="txtModel"></td>
                </tr>
                <tr>
                    <td align="right">Year</td>
                    <td>:</td>
                    <td><input type="text" name="txtYear"></td>
                </tr>
                <tr>
                    <td align="right">Miles</td>
                    <td>:</td>
                    <td><input type="text" name="txtMiles"></td>
                </tr>
                <tr>
                    <td align="right">Price</td>
                    <td>:</td>
                    <td><input type="text" name="txtPrice"></td>
                </tr>
                <tr>
                    <td colspan="3" align="center">
                        <input type="submit" value="Add New"/>
                        &nbsp;&nbsp;
                        <a href="index.php">Cancel</a>
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>

