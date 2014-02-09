<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Registration Form</title>
        <style type="text/css">
            body { 
                background-color: #fff;
                border-top: solid 10px #000;
                color: #333;
                font-size: .85em;
                margin: 20;
                padding: 20;
                font-family: "Segoe UI",Verdana, Helvetica, sans-serif;
            }
            h1, h2, h3 { color: #000; margin-bottom: 0; padding-bottom: 0; }
            h1 { font-size: 2em; }
            h2 { font-size: 1.75em; }
            h3 { font-size: 1.2em; }
            table { margin-top: 0.75em; }
            th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
            td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
        </style>
    </head>
    <body>
        <h1>Register here!</h1>
        <p>Fill in your name and email address, then click <strong>Submit</strong> to register.</p>
        <form method="post" action="index.php" enctype="multipart/form-data">
            Name <input type="text" name="name" id="name" /><br/>
            Email <input type="text" name="email" id="email" /><br/>
            <input type="submit" name="submit" value="Submit" />
        </form>
    <?php
        // DB connection info
        $host="us-cdbr-azure-west-b.cleardb.com";
        $user="b103f0f030e2a1";
        $pwd="47b6f9d4";
        $db="cchiaroAZcNf65KZ";

        // Connect to the database
        try {
            $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (Exception $e) {
            die(var_dump($e));
        }

        // Insert registration info
        if (!empty($_POST)) {
            try {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $date = date("Y-m-d");

                // Insert data
                $sql_insert = "INSERT INTO registration_table (name, email, date) VALUES (?,?,?)";
                $stmt = $conn->prepare($sql_insert);
                $stmt->bindValue(1, $name);
                $stmt->bindValue(2, $email);
                $stmt->bindValue(3, $date);

                $stmt->execute();
            }
            catch (Exception $e) {
                die(var_dump($e));
            }

            echo "<h3>You're registered!</h3>";
        }

        // Retrieve data
        $sql_select = "SELECT * FROM registration_table";
        $stmt = $conn->query($sql_select);
        $registrants = $stmt->fetchAll();
        if (count($registrants) > 0) {
            echo "<h2>People who are registered:</h2>";
            echo "<table>";
            echo "<tr><th>Name</th><th>Email</th><th>Date</th></tr>";
            foreach ($registrants as $registrant) {
                echo "<tr><td>".$registrant['name']."</td><td>".$registrant['email']."</td><td>".$registrant['date']."</td></tr>";
            }
            echo "</table>";
        }
        else {
            echo "<h3>No one is currently registered.</h3>";
        }
    ?>
    </body>
</html>
