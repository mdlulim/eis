<?php echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $language; ?>" xml:lang="<?php echo $language; ?>">
<head>
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<link rel="stylesheet" type="text/css" href="view/stylesheet/proorder.css" />
</head>
<body>
  <div class="datagrid">
    <button class="totalorder">Total Orders = <?php echo $count; ?></button>&nbsp&nbsp
    <button class="totalorder">Product Id = <?php echo $id; ?></button>&nbsp&nbsp
    <button class="totalorder">Product Name = <?php echo $name; ?></button>
    <table>
      <thead>
        <tr>
          <th>Order-Id</th>
          <th>Status</th>
          <th>Date Modified</th>
          <th>Name</th>
          <th>Email</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Total</th>
          <th>Tax</th>
          <th>Grand Total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data as $key => $value) { ?>
          <tr>
            <td><?php echo $value['order_id']; ?></td>
            <td><?php echo $value['order_status']; ?></td>
            <td><?php echo $value['date_modified']; ?></td>
            <td><?php echo $value['name']; ?></td>
            <td><?php echo $value['email']; ?></td>
            <td><?php echo $value['price']; ?></td>
            <td><?php echo $value['quantity']; ?></td>
            <td><?php echo $value['total']; ?></td>
            <td><?php echo $value['tax']; ?></td>
            <td><?php echo $value['gd']; ?> </td>
          </tr>
        <?php  } ?>
        <thead><tr><th colspan="9" style="text-align:right;">Revenue Generated</th><th><?php echo $md; ?></th></tr></thead>
      </tbody>
    </table>   
 </div>     
</body>
</html>