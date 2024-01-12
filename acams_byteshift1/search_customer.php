<?php
include('dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = mysqli_real_escape_string($con, $_POST['search_term']);

    $sql = "SELECT * FROM tb_customer 
            WHERE c_id LIKE '%$searchTerm%' 
            OR c_name LIKE '%$searchTerm%' 
            OR c_phone LIKE '%$searchTerm%' 
            OR c_email LIKE '%$searchTerm%'";

    $result = mysqli_query($con, $sql);

    $count = 0;
    while ($row = mysqli_fetch_array($result)) {
        $count++;
        ?>
        <tr>
            <th scope="row">
                <?php echo $count; ?>
            </th>
            <td>
                <?php echo $row['c_id']; ?>
            </td>
            <td>
                <?php echo $row['c_name']; ?>
            </td>
            <td>
                <?php echo $row['c_email']; ?>
            </td>
            <td>
                <?php echo $row['c_phone']; ?>
            </td>
            <!-- Add more columns if needed -->
        </tr>
        <?php
    }
    mysqli_close($con);
}
?>