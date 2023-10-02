    
<script>
function cancelOrder(order_id) {
    // Send an AJAX request to delete the row with the matching order_id column
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'process_cancelorder.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            // Reload the page to show the updated list of orders
            location.reload();
        } else {
            alert('Error: ' + xhr.statusText);
        }
    };
    xhr.send('order_id=' + encodeURIComponent(order_id));
}
</script>
