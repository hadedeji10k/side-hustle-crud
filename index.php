<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SIDE-HUSTLE - PHP-CRUD</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    </head>
    <body>
        <?php require_once 'process.php'; ?>

        <?php 

            if(isset($_SESSION['message'])): ?>

                    <div class="alert alert-<?=$_SESSION['msg_type']?>"> 
                        <?php 
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        ?>
                    </div>
            <?php endif ?>

                <br><br><br>
        <div class="container">
            <div class="row justify-content-center">
                <form action="process.php" method="POST">
                    <input type="hidden" name="id" value="<?php $id; ?>">
                    <div class="form-group">
                    <label>Name:</label>
                    <input class="form-control" type="text" name="name" value="<?php echo $name; ?>" placeholder="Enter Your Name:">
                    </div>

                    <div class="form-group">
                    <label>Side Hustle Level:</label>
                    <input class="form-control" type="text" name="level" value="<?php echo $level; ?>" placeholder="Enter Your Side Hustle Level:">
                    </div>

                    <div class="form-group">
                    <label>Your Gmail:</label>
                    <input class="form-control" type="email" name="gmail" value="<?php echo $address; ?>" placeholder="Enter Your Gmail:">
                    </div>

                    <div class="form-group">
                    <?php if($update == true): ?>
                    <button class="btn btn-primary" type="submit" name="update">Update</button>
                    <?php else: ?>
                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                    <?php endif; ?>
                    </div>
                </form>
            </div>

            <br><br>

            <?php 
                     
                $url = parse_url(getenv("CLEARDB_DATABASE_URL"));

                $server = $url["host"];
                $username = $url["user"];
                $password = $url["pass"];
                $db = substr($url["path"], 1);

                $mysqli = new mysqli($server, $username, $password, $db) or die(mysqli_error($mysqli));
                $result = $mysqli->query("SELECT * FROM data") or die($mysqli->error);
            ?>

            <div class="row justify-content-center">

                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Level</th>
                            <th>Gmail Address</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>

                    <?php 
                    while ($row = $result->fetch_assoc()): ?>

                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['level']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td>
                            <a class="btn btn-info" href="process.php?edit=<?php echo $row['id']; ?>">Edit</a>
                            <a class="btn btn-danger" href="process.php?delete=<?php echo $row['id']; ?>">Delete</a>
                        </td>
                    </tr>

                    <?php endwhile; ?>

                </table>

            </div>
        </div>

    </body>
</html>