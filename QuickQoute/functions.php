<?php
function getOrders() {
    global $conn;

    $sql = "
        SELECT o.order_id, c.customer_name, s.name AS service_name, p.package_name, 
               o.ceremony_date, o.ceremony_venue
        FROM orders o
        JOIN customers c ON o.customer_id = c.customer_id
        JOIN packages p ON o.package_id = p.package_id
        JOIN services s ON p.service_id = s.service_id
        ORDER BY o.order_id DESC
    ";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        return $orders;
    } else {
        return [];
    }
}
?>
