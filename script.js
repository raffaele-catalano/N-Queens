document.getElementById('queensForm').addEventListener('submit', function (event) {
    event.preventDefault();

    // Disabilita il modulo durante l'elaborazione
    document.getElementById('NQueens').disabled = true;
    document.getElementById('loader').style.display = 'block';

    const numQueens = document.getElementById('NQueens').value;
    fetch('solver.php', {
        method: 'POST',
        body: JSON.stringify({ numQueens }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json()) // parse la risposta JSON
        .then(data => {
            // Abilita nuovamente il modulo
            document.getElementById('NQueens').disabled = false;
            document.getElementById('loader').style.display = 'none';

            // elabora la risposta e visualizza le soluzioni nella tua pagina HTML
            const solutionsContainer = document.getElementById('solutions');
            solutionsContainer.innerHTML = ''; // Cancella eventuali soluzioni precedenti

            if (data.solutionsCount > 0) {
                data.solutions.forEach(solution => {
                    const board = document.createElement('div');
                    board.className = 'board';
                    board.style.setProperty('--n', numQueens);

                    solution.forEach(row => {
                        row.forEach(cell => {
                            const cellElement = document.createElement('div');
                            cellElement.className = 'cell';
                            if (cell === 1) {
                                cellElement.innerHTML = '<i class="fa-solid fa-chess-queen"></i>'; // simbolo di una regina stilizzata
                                cellElement.classList.add('queen');
                            }
                            board.appendChild(cellElement);
                        });
                    });

                    solutionsContainer.appendChild(board);
                });
            } else {
                // Nessuna soluzione trovata
                solutionsContainer.innerHTML = '<h3 class="mt-3 text-danger">Nessuna soluzione valida trovata per ' + numQueens + ' regine <i class="fa-solid fa-chess-queen fa-bounce text-warning"></i></h3>';
            }
        });
});
