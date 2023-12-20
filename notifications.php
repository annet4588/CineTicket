<?php
include "header.php";
require "cineticket_db.php";
$pageTitle = "Notifications";
?>

<!DOCTYPE html>
<html>
<body>
    <div class="container">
        <h1>Notifications</h1>
        <!-- Display notifications from the session -->
        <?php
        if (isset($_SESSION['notification']) && is_array($_SESSION['notification']) && !empty($_SESSION['notification'])) {
            echo "<ul>";
            foreach ($_SESSION['notification'] as $notification) {
                echo "<li>" . $notification . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>You have no new notifications.</p>";
        }
        ?>
    </div>
<!-- Include Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
include "footer.php";
?>
