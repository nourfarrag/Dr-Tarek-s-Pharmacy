<?php
    session_start();
    require "connectionpdo.php";
?>
<html>
    <head>
        <title>Suppliers</title>
        <link rel="stylesheet" href="/Dr. Tarek's Pharmacy/CSS/Suppliers.css">
    </head>
    <body>
        <h1>Suppliers</h1>
        <div id="suppbox">
            <table id="supptbl">
                <tr><th>Number</th> <th>Name</th> <th>Phone</th> <th>E-mail</th> <th>Address</th> <th>Payment Terms</th></tr>
                <?php
                
                class Suppliers
                {
                  
                   
                   public function try1()
                   {
                     $suppliers=array();
                    require "connectionpdo.php";
                    try{
                        $sql = "SELECT * FROM suppliers";
                        $stmt = $conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                        $stmt->execute();
                        while ($row = $stmt->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
                            array_push($suppliers, $row[0]);
                        }
                        foreach($suppliers as $c)
                        {
                            $sql2 = "SELECT * FROM suppliers WHERE SupplierID=$c";
                            $stmt2 = $conn->prepare($sql2, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
                            $stmt2->execute();
                            $info = $stmt2->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT);
                            $num = $info[0] ?? 'Number';
                            $name = $info[1] ?? 'Name';
                            $phone = $info[2] ?? 'Phone';
                            $email = $info[3] ?? 'E-Mail';
                            $address = $info[4] ?? 'Address';
                            $payterms = $info[5] ?? 'Payment Terms';
                            echo ("<tr>" . "<td>" .  $num . "</td>" . "<td>" . $name . "</td>" . "<td>" . $phone . "</td>" . "<td>" . $email . "</td>" . "<td>" . $address . "</td>" . "<td>" . $payterms . "</td>" . "</tr>");
                        }
                    }
                    catch(PDOException $e){
                    
                    }  
                   } 
                }
                $obj = new Suppliers($conn);
                $obj->try1();
                ?>
            </table>
        </div>
    </body>
</html>