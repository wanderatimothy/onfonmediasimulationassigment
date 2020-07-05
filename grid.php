<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grid simulation</title>
    <style>
        .cyan {
            background-color: cyan;
        }

        .yellow {
            background-color: yellow;
        }

        .orange {
            background-color: orange;
        }

        .red {
            background-color: red;
        }

        .black {
            background-color: black;
            color: white;
        }
    </style>
</head>

<body>

    <?php


    function check_quare($var)
    {
        for ($i = 1; $i < $var; $i++) {
            if (($i * $i) === $var) {
                return true;
            }
        }
        return false;
    }

    function prime_number($var)
    {
        $check = 0;
        if ($var != 1) {
            for ($i = 2; $i < $var / 2; ++$i) {
                if (($var % $i) == 0) {
                    $check = 1;
                    break;
                }
            }
            if ($check == 0) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }




    $max_column = 25;
    $max_row = 40;
    $interval = 40;

    ?>
    <table>
        <?php
        for ($i = 0; $i < $max_row; $i++) {
        ?>
            <tr class="<?php
                        // first row yellow
                        if ($i == 0) {
                            echo "yellow";
                        } ?>">
                <?php

                for ($c = 0; $c < $max_column; $c++) {

                    $var = $i + $c * $interval;
                ?>
                    <td class=" <?php
                                //  first column cyan
                                if ($c == 0) {
                                    echo "cyan";
                                }
                                // multiples of eight
                                if ((($var % 8) == 0)) {
                                    echo "orange";
                                }
                                // square numbers
                                if (check_quare($var)) {
                                    echo "red";
                                }
                                // prime numbers
                                if (prime_number($var)) {
                                    echo "black";
                                }
                                ?> 
                                
                                
                                ">
                        <?= $var ?>
                    </td>
                <?php
                }

                ?>
            </tr>
        <?php
        }

        ?>
    </table>



</body>

</html>