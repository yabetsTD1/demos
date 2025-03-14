<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    table {
        border: 2px, solid, yellow;
    }
    thead td {
        background-color: yellow;
        color: aqua;
    }
    tr td {
        border: 2px, solid;
    }
</style>
<body>
    <table>
        <thead>
            <td>First Name</td>
            <td>Last Name</td>
            <td>Phone</td>
            <td>User Name</td>
            <td>Email</td>
            <td>Password</td>
        </thead>
        <?php
        $con = new mysqli('localhost', 'root', '', 'user_system');
        $sql = "select * from users";
        $result = mysqli_query($con, $sql);
        if ($result) {

            foreach ($result as $row) {
        ?>
                <tr>
                    <td><?= $row['first_name'] ?></td>;
                    <td><?= $row['last_name'] ?></td>;
                    <td><?= $row['phone'] ?></td>;
                    <td><?= $row['username'] ?></td>;
                    <td><?= $row['email'] ?></td>;
                    <td><?= $row['password'] ?></td>;
                </tr>
        <?php
            }
        }

        ?>
    </table>
</body>
</html>