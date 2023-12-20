<footer>
<!-- Include font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <div class="container-fluid text-center">
        <hr>      
        <h3> CineTicket&copy <?php echo date("Y"); ?> </h3>
        <div class="social-media-links">
            <!-- Add social media icons/links here -->
            <a href="https://www.facebook.com/"><i class="fab fa-facebook"></i></a>
            <a href="https://twitter.com/"><i class="fab fa-twitter"></i></a>
            <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
        </div>
        <div class="footer-links">
            <a href="privacyPolicy.php">
              <i class="fa-solid fa-lock" style="color: orange;"></i> Privacy Policy
            </a>
            <a href="accountFAQ.php">Account FAQ</a>
            <a href="help.php">Help</a>
            <a href="contactUs.php">Contact Us</a>
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style>
    /* Footer style */
    footer {
        background-color: #063970;
        color: white;
        display: flex;   
        justify-content: space-between; 
        align-items: center; /* Center horizontally */
        padding: 20px 0;
    }

    .social-media-links a,
    .footer-links a {
        color: white;
        text-decoration: none;
        margin-right: 15px; /* Adjust margin as needed */
    }

    .social-media-links a:hover,
    .footer-links a:hover {
        text-decoration: underline;
    }

    .footer h3 {
        margin: 0;
        font-size: 24px;
    }

    .footer-links {
        display: flex;
        align-items: center;
        margin-top: 10px;
        flex-grow: 1; /* Allow the links to expand and center */
        justify-content: center; /* Center the links horizontally */
        
    }
</style>

