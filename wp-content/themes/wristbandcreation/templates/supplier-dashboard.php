<?php

//Template Name: Supplier Dashboard

include ('custom-header.php');
// get_header();

?>


<div>
  <h2>My Orders</h2>
</div>
<div class="row">
  <div class="col-md-2">
    <ul>
      <li>
        <a>My Orders</a>
      </li>
      <li>
        <a>My Profile</a>
      </li>
      <li>
        <a>Notification</a>
      </li>
    </ul>
  </div>
  <div class="col-md-10">
    <!-- //table here -->
    <div class="table-1">
      <table width="100%">
        <thead>
          <tr>
            <th>Column 1</th>
            <th>Column 2</th>
            <th>Column 3</th>
            <th>Column 4</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Item #1</td>
            <td>Description</td>
            <td>Subtotal:</td>
            <td>$1.00</td>
          </tr>
          <tr>
            <td>Item #2</td>
            <td>Description</td>
            <td>Discount:</td>
            <td>$2.00</td>
          </tr>
          <tr>
            <td>Item #3</td>
            <td>Description</td>
            <td>Shipping:</td>
            <td>$3.00</td>
          </tr>
          <tr>
            <td>Item #4</td>
            <td>Description</td>
            <td>Tax:</td>
            <td>$4.00</td>
          </tr>
          <tr>
            <td><strong>All Items</strong></td>
            <td><strong>Description</strong></td>
            <td><strong>Your Total:</strong></td>
            <td><strong>$10.00</strong></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>


<?php

include ('custom-footer.php');

