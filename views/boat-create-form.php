<?php

if (!isset($_SESSION['loggedin'])) {
    $_SESSION['redirect'] = "index.php";
    header("Location: ../log-in.php");
    exit();

}
require_once("header.php")
?>


<!DOCTYPE html>
<html>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="css/main.css">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>
        <?php print htmlentities($title) ?>
    </title>
</head>
<body>
<?php
site_header();
?>
<div class="container">
    <div class="row vertical-center">
        <div class="col-md-4 col-md-offset-4 text-center">
            <h2 class="text-center"><?php echo ($title);?></h2>
            <form method="post" class="form-horizontal"
                  action="index.php?action=<?php print(isset($length_val) ? "update" : "create"); ?>">

                <div class="form-group">
                    <label class="col-sm-3 control-label" for="length">Length</label>
<div class="col-sm-9">                    <input type="number" step="0.01" id="length" min="1" max="100"
                        <?php if (isset($length_val)): printf("value='%s'", $length_val); endif ?>
                           name="length" class="form-control" placeholder="00.00"/></div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3" for="type">Type</label>
                    <div class="col-sm-9"><select  id="type" name="type" class="form-control col-sm-10">
                        <?php
                        foreach ($type_list as $t) {
                            print "<option value=\"$t\" ";

                            if (isset($type_val) && $t == $type_val)
                                print ("selected");


                            print(">$t</option>");
                        }
                        ?>
                    </select></div>
                </div>
                <div class="form-group">
                    <label for="propulsion" class="col-sm-3">Propulsion</label>
                    <div class="col-sm-9"><select id="propulsion" name="propulsion" class="form-control">
                        <?php
                        foreach ($propulsion_list as $p) {
                            print "<option value=\"$p\" ";

                            if (isset($propulsion_val) && $p == $propulsion_val)
                                print ("selected");
                            print(">$p</option>");
                        }
                        ?>
                    </select></div>
                </div>
                <?php
                if (isset($type_val)):
                    printf("<input type=\"hidden\"  name=\"boatid\" value=\"%s\">", $boat_id);
                endif;
                ?>
                <div class="col-sm-9 col-sm-offset-3"><input type="submit" id="submit" name="submit" class="form-control" value="Submit"></div>
        </div>
        </form>

    </div>
</div>
</div>

</body>


</html>
