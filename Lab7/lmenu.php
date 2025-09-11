<?php
include "data.php";
?>
<ul>
    <?php foreach ($data as $menuitem => $value)
        echo "<li><a href='?gr=" . $menuitem . "'>" . $menuitem . "</a></li>";
    ?>
</ul>