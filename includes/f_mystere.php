<?php





function customlevenshtein($c1, $c2) {
    $matrix = array();
    
    for ($x = 0; $x <= strlen($c2); $x++) {
        $matrix[0][$x] = $x;
    }
    
    for ($y = 0; $y <= strlen($c1); $y++) {
        $matrix[$y][0] = $y;
    }
    
    for ($y = 1; $y <= strlen($c1); $y++) {
        for ($x = 1; $x <= strlen($c2); $x++) {
            if ($c2[$x - 1] == $c1[$y - 1]) {
                $matrix[$y][$x] = $matrix[$y - 1][$x - 1];
            } else {
                $matrix[$y][$x] = min($matrix[$y - 1][$x] + 1, $matrix[$y][$x - 1] + 1, $matrix[$y - 1][$x - 1] + 1);
            }
        }
    }
    
    return $matrix[strlen($c1)][strlen($c2)];
}



?>