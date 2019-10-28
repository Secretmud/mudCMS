<div class="header header-space">
Velkommen: <?php echo $_SESSION['user'];?><br>
Privilegier: <?php echo $_SESSION['rights'];?><br>
</div>
<?php
if($_SESSION['rights'] == 'admin'){
    echo '<div class="header header-space">
        <div class="header-content">
            <i class="fal fa-home"></i>
            <a class="" href="adminPanel.php">Hjem</a>
        </div>
        <div class="header-content">
            <i class="fal fa-database"></i>
            <a class="list-parent" href="adminDatabase.php">Database:</a>
            <div class="">
                <ul class="list">
                    <li class="list-item">
                        <a href="adminContent.php">Add content</a>
                    </li>
                </ul>
            </div>
        </div>
       
    </div>';
}
?>
<div class="header header-space">
    <a href="logout.php">Logg ut!</a>
</div>
