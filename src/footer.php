<footer>
    <p>
        &copy; 2026 CNSS Tech. Driving Business Forward with Technology.
    </p>

    <p>
    <?php
    $filename = basename($_SERVER['PHP_SELF']);
    $modified = date("F d Y H:i:s", filemtime($filename));
    echo "<p>Last Modified: $modified</p>";
    ?>
    All rights reserved.
    </p>
    
</footer>
</div>
</body>
</html>