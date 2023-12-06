<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/wordle.css">
    <title>Document</title>
</head>
<body>
    <h1>wordle</h1>
    <form action="wordle.php" method="post">
        <?php
            session_start();
            if (!isset($_SESSION["text"])) {
                header("Location: tryWordle.php");
            }
            $text = $_SESSION["text"];
            $tried = $_SESSION["tried"];
            $_SESSION["current"] = $_POST["text"];
            $current = $_SESSION["current"];
            if (in_array($current, $tried) or strlen($current) != 5) {
                $duplicate = true;
            } else {
                $duplicate = false;
                $_SESSION["count"] += 1;
                array_push($tried, $current);
            }
            $count = $_SESSION["count"];
            echo "<p>Nombre d'essais : $count</p>";
            global $win;
            $win = $text == $current;
            $abc = $_SESSION["abc"];

        ?>
        <p class="mot">
            <?php

                function displayclass($letter, $color) {
                    return "<span class='$color'>$letter</span>";
                }

                $display = "";
                if ($duplicate) {
                    $display .= "<p class='duplicate'>Ce mot a déjà été essayé</p>";
                }
                else{                
                    for ($i = 0; $i < strlen($current); $i++) {
                        if (str_contains($text, $current[$i])) {
                            if ($current[$i] == $text[$i]) {
                                $display .= displayclass($current[$i], "green");
                                $abc[$current[$i]] = 1;
                            } else {
                                $display .= displayclass($current[$i], "orange");
                                $abc[$current[$i]] = 1;
                            }
                        } else {
                            $display .= displayclass($current[$i], "red");
                            $abc[$current[$i]] = -1;
                        }
                    }
                    echo $display;
                    $win = $text == $current;
                    if ($win) {
                        echo "<p class='win'>Vous avez gagné !</p>";
                    }
                }
            ?>
        </p>
        <div class="mother">
            <div class="abc">
                <?php
                $cnt = 0;
                foreach ($abc as $letter => $value) {
                    $cnt += 1;
                    if ($value == 0) {
                        echo "<span class='grey'>$letter</span>";
                    } elseif ($value == 1) {
                        echo "<span class='green'>$letter</span>";
                    } else {
                        echo "<span class='red'>$letter</span>";
                    }
                    if ($cnt % 9 == 0) {
                        echo "<br><br>";
                    }
                } 
                ?>
                <br><br><br>
                <div>
                    <label for="text" <?php echo ($win) ? "hidden" : ""; ?> >Texte à analyser</label>
                    <input name="text" maxlength="5" minlength="5" autofocus onfocus="this.select()" id="text" <?php echo ($win) ? "hidden" : ""; ?>></textarea>
                    <input type="submit" value="Envoyer" <?php echo ($win) ? "hidden" : ""; ?>>
                    <a href="index.php" class = "button">Reset</a>
                </div>
            </div>

            <div class="past">
                <?php
                    echo $_SESSION["oldDisplay"];
                    $display .= "<br> <br>";
                    $_SESSION["oldDisplay"] = $display . $_SESSION["oldDisplay"];
                    $_SESSION["abc"] = $abc;
                ?>
            </div>
        </div>
        <br>
    </form>

</body>
</html>