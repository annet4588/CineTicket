<?php
$pageTitle = "Movie and User Management";
include "header.php";

# Check if user is logged in as an admin (you should implement user authentication)
session_start();  // Start the session (if not already started)
if (!isset($_SESSION['admin'])) {
    // Redirect to the login page or display an access denied message
    header("Location: login.php");
    exit();
}

# Include your database connection file
require('cineticket_db.php');

# Fetch and display movie records
$movieQuery = "SELECT * FROM movieTable";
$movieResult = mysqli_query($conn, $movieQuery);

if (!$movieResult) {
    die("Movie database query failed.");
}
?>

<div class="container mt-5">
    <h2>Movie Management</h2>

    <!-- Display movie records in a table -->
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Genre</th>
                <th>Showtimes</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($movieRow = mysqli_fetch_assoc($movieResult)) {
                echo "<tr>";
                echo "<td>{$movieRow['id']}</td>";
                echo "<td>{$movieRow['movie_title']}</td>";
                echo "<td>{$movieRow['movie_genre']}</td>";
                echo "<td>{$movieRow['show1']}, {$movieRow['show2']}, {$movieRow['show3']}</td>";
                echo "<td>{$movieRow['movie_price']}</td>";
                echo "<td>
                        <a href='edit_movie.php?id={$movieRow['id']}'>Edit</a> |
                        <a href='delete_movie.php?id={$movieRow['id']}'>Delete</a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <a href="create_movie.php" class="btn btn-primary">Add Movie</a>
</div>

<?php
# Close the movie database connection
mysqli_close($conn);

# You may also include the footer here
include "footer.php";
?>
