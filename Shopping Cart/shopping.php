<?php 
    session_start();
    require_once 'connect.php';
    if(isset($_POST['add_to_cart'])) {
        if(isset($_SESSION['shopping_cart'])) {
            $item_array_id = array_column($_SESSION['shopping_cart'], 'item_id');
            if(!in_array($_GET['id'], $item_array_id)) {
                $count = count($_SESSION['shopping_cart']);
                $item_array = array(
                    'item_id' => $_GET['id'],
                    'item_name' => $_POST['hidden_name'],
                    'item_price' => $_POST['hidden_price'],
                    'item_quantity' => $_POST['quantity']
                );
                $_SESSION['shopping_cart'][$count] = $item_array;
            }
            else {
                echo '<script>window.location="shopping.php"</script>';
            }
        }
        else {
            $item_array = array(
                'item_id' => $_GET['id'],
                'item_name' => $_GET['hidden_name'],
                'item_price' => $_GET['hidden_price'],
                'item_quantity' => $_GET['quantity']
            );
            $_SESSION['shopping_cart'][0] = $item_array;
        }
    }
    if(isset($_GET['action'])) {
        if($_GET['action'] == 'delete') {
            foreach($_SESSION['shopping_cart'] as $keys => $values) {
                if($values['item_id'] == $_GET['id']) {
                    unset($_SESSION['shopping_cart'][$keys]);
                    echo '<script>window.location="shopping.php"</script>';
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping Center</title>
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>
    <br>
    <div class="container jumbotron" style="width:700px;">
        <h3 align="center">Shopping Center</h3><br>
        <?php
            $query = "SELECT * FROM tbl_product ORDER BY id ASC";
            $result = mysqli_query($connect, $query);
            
            if(mysqli_num_rows($result) > 0) {
               
            while($row = mysqli_fetch_array($result)) {
                
        ?>
        <div align="center">
            <hr>
            <form method="POST" action="shopping.php?action=add&id=<?php echo $row['id']?>">
                    <img width="140px" height="<?php echo $row[0]['image'] ? 'height=150px' : '100px' ?>" src="<?php echo $row['image']?>" class="img-responsive"/>
                    <h4 class="text-info"><?php echo $row['name'] ?></h4>
                    <h4 class="text-danger"><?php echo $row['price'] ?></h4>
                    <input type="text" name="quantity" class="form-control text-center" value="1">
                    <input type="hidden" name="hidden_name" value="<?php echo $row['name'] ?>">
                    <input type="hidden" name="hidden_price" value="<?php echo $row['price'] ?>">
                    <input type="submit" name="add_to_cart" style="margin-top:5px" class="btn btn-success" value="Add to Basket"><br>
            </form>
        </div>
        <?php
                }
            }
        ?>
        <div style="clear:both" class="slideDown">
            <br><br>
            <h4 align="center" class="order"><a href="#order">Order Details</a></h4><br>
            <table class="table table-bordered">
                <tr>
                    <th width="40%">Item Name</th>
                    <th width="10%">Quantity</th>
                    <th width="20%">Price</th>
                    <th width="15%">Total</th>
                    <th width="5%">Action</th>
                </tr>
                <?php
                    if(!empty($_SESSION['shopping_cart'])) {
                        $total = 0;
                        foreach($_SESSION['shopping_cart'] as $keys => $values) {
                ?>
                <tr>
                    <td><?php echo $values['item_name']; ?></td>
                    <td><?php echo $values['item_quantity']; ?></td>
                    <td><?php echo $values['item_price']; ?></td>
                    <td><?php echo number_format($values['item_quantity'] * $values['item_price'], 2); ?></td>
                    <td><a href="shopping.php?action=delete&id=<?php echo $values['item_id'] ?>"><span class="text-danger">Remove</span></a></td>
                </tr>
                <?php
                    $total = $total + ($values['item_quantity'] * $values['item_price']);
                        }
                ?>
                <tr>
                    <td colspan="3" align="right">Total</td>
                    <td align="center">$<?php echo number_format($total, 2) ?></td>
                    <td><a href="#endorse"><span class="text-success" id="endorse">Endorse</span></a></td>
                </tr>
                    <?php } ?>
            </table>
        </div>
    </div>

</body>
</html>