<?php
require("db.php");
?>
# add user to table user(id,nom,prenom,email,password,age)
<?php
#query
$sql = "INSERT INTO `users`(`nom`, `prenom`, `age`, `login`, `password`) VALUES ('Doe', 'John', 30, 'john.doe@example.com', 'password123')";
$conn->exec($sql);
echo "New record created successfully";
?>