<?php
if (php_sapi_name() === 'cli') {
    // La funzione readline permette di ottenere l'input dall'utente dalla console.
    $n = readline('Inserisci il numero di Regine: ');
} else {
    // quando PHP è eseguito in una richiesta HTTP
    $requestData = json_decode(file_get_contents('php://input'), true);
    $n = $requestData['numQueens'];
}

// La funzione intval converte la stringa inserita dall'utente in un intero.
$n = intval($n);

// controllo relativo all'input dell'utente - deve essere necessariamente un numero intero positivo.
if ($n <= 0) {
    if (php_sapi_name() === 'cli') {
        echo 'Il numero di regine deve essere un intero positivo. Riprova.' . PHP_EOL;
    } else {
        echo json_encode(array(
            'solutionsCount' => 0,
            'solutions' => null,
            'error' => 'Il numero di regine deve essere un intero positivo.'
        ));
    }
    exit;
}

// inizializzazione di una scacchiera vuota
$board = array();
for ($i = 0; $i < $n; $i++) {
    $board[] = array_fill(0, $n, 0);
}

// funzione per verificare se è sicuro posizionare una regina in una data cella
function isSafe($row, $col, $board, $n) {
    // Verifica la colonna
    for ($i = 0; $i < $row; $i++) {
        if ($board[$i][$col] === 1) {
            return false;
        }
    }

    // verifica la diagonale sinistra
    for ($i = $row, $j = $col; $i >= 0 && $j >= 0; $i--, $j--) {
        if ($board[$i][$j] === 1) {
            return false;
        }
    }

    // verifica la diagonale destra
    for ($i = $row, $j = $col; $i >= 0 && $j < $n; $i--, $j++) {
        if ($board[$i][$j] === 1) {
            return false;
        }
    }

    return true;
}

// funzione per posizionare le regine in modo ricorsivo e contare le soluzioni valide
function solveNQueens($n, &$solutions) {
    $board = array();
    for ($i = 0; $i < $n; $i++) {
        $board[] = array_fill(0, $n, 0);
    }

    $countSolutions = 0; // contatore per il numero di soluzioni valide

    $placeQueens = function ($row) use (&$solutions, &$board, $n, &$placeQueens, &$countSolutions) {
        if ($row === $n) {
            $solutions[] = $board;
            $countSolutions++; // incrementa il contatore di soluzioni valide
            return;
        }
        // backtracing
        for ($col = 0; $col < $n; $col++) {
            if (isSafe($row, $col, $board, $n)) {
                $board[$row][$col] = 1; // posiziona una regina
                $placeQueens($row + 1); // prosegui con la prossima riga
                $board[$row][$col] = 0; // backtrack
            }
        }
    };

    $placeQueens(0); // inizia la ricerca delle soluzioni dalla prima riga

    return $countSolutions; // return del numero di soluzioni valide
}

$solutions = array();
$solutionsCount = solveNQueens($n, $solutions);

if (php_sapi_name() === 'cli') {
    echo "Numero totale di soluzioni valide trovate: " . $solutionsCount . PHP_EOL;

    // funzione per stampare una soluzione sulla console
    function printSolution($solution) {
        foreach ($solution as $row) {
            foreach ($row as $cell) {
                if ($cell === 1) {
                    echo '♕ ';
                } else {
                    echo '◦ ';
                }
            }
            echo PHP_EOL;
        }
        echo PHP_EOL;
    }

    // stampa le soluzioni
    if ($solutionsCount > 0) {
        foreach ($solutions as $solution) {
            printSolution($solution);
        }
    }
} else {
    if ($solutionsCount > 0) {
        $formattedSolutions = array();
        foreach ($solutions as $solution) {
            $formattedSolution = array();
            foreach ($solution as $row) {
                $formattedSolution[] = $row;
            }
            $formattedSolutions[] = $formattedSolution;
        }

        echo json_encode(array(
            'solutionsCount' => $solutionsCount,
            'solutions' => $formattedSolutions,
            'error' => null
        ));
    } else {
        echo json_encode(array(
            'solutionsCount' => 0,
            'solutions' => null,
            'error' => 'Nessuna soluzione valida trovata.'
        ));
    }
}
