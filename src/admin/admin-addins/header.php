<div class="header header-space">
Welcome: <?php echo $_SESSION['user'];?><br>
Rights: <?php echo $_SESSION['rights'];?><br>
</div>
<?php
if($_SESSION['rights'] == 'admin'){
    echo '<div class="header header-space">
        <div class="header-content">
            <i class="fal fa-home"></i>
            <a class="" href="adminPanel.php">Dashboard</a>
        </div>
        <div class="header-content">
            <i class="fal fa-home"></i>
            <a class="" href="adminAbout.php">About page</a>
        </div>
        <div class="header-content">
            <i class="fal fa-database"></i>
            <a class="list-parent" href="adminDatabase.php">Database:</a>
            <div class="">
                <ul class="list">
                    <li class="list-item">
                        <a href="makeContent.php">Add content</a>
                    </li>
                    <li class="list-item">
                        <a href="EditContent.php">Edit content</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>';
}
?>
<div class="header header-space">
    <a href="logout.php" onClick="alert('Are you sure you want to logout?')">Sign out!</a>
</div>
