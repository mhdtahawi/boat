<?php
function site_header()
{
    echo(<<<END_OF_TEXT
<header>
<nav>
     <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?action=create">Add</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
</nav>
    </header>   
END_OF_TEXT
    );
}



function boat_item($id, $length, $type, $propulsion, $even)
{
    $class = $even ? "even" : "odd";
    echo(<<<END_OF_TEXT

<div class="row $class">
<div class="col-xs-6 col-md-2">
$length
</div>

<div class="col-xs-6 col-md-4">
$propulsion
</div>

<div class="col-xs-6 col-md-4">
$type
</div>

<div class="col-xs-6 col-md-1">
<a href='index.php?action=update&boatid=$id'> Edit</a>
</div>

<div class="col-xs-6 col-md-1">
<a href='index.php?action=delete&boatid=$id'> Delete</a>
</div>


</div>

END_OF_TEXT
    );
}


function boat_table_header()
{
    echo(<<<END_OF_TEXT

<div class="row hidden-sm hidden-xs">
<div class="col-md-2">
Length
</div>
<div class="col-md-4">
Propulsion
</div>
<div class="col-md-4">
Type
</div>
<div class="col-md-1">
</div>
<div class="col-md-1">
</div>
</div>
END_OF_TEXT
    );
}