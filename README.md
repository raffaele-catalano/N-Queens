# Peaceful N Queens
> Dato `n`, trovare tutte le possibili posizioni di `n` regine, su una scacchiera `n x n` , in modo tale da non potersi mangiare l’una con le altre.<br>
Il programma prende in input `n` e stampa sia in console che in interfaccia grafica le varie rappresentazioni della scacchiera.

## Tecnologie: 
<p>
  <a href="https://skillicons.dev">
    <img src="https://skillicons.dev/icons?i=php,js,css,html,md,github&perline=7" />
  </a>
</p>

## Requisiti:
- Server web locale per eseguire l'applicazione;
- PHP 8.0 o versioni successive installate sul server.

## Struttura del Progetto:
| File | Descrizione |
| ---     | ---   |
| `index.html` | Pagina dell'applicazione che visualizza un form di *input* di una per un numero intero e mostra le soluzioni|
| `solver.php` | Script PHP che riceve il numero intero dall'applicazione, risolve il problema delle N regine e restituisce le soluzioni |
| `script.js` | Script JavaScript che gestisce l'interazione utente sulla pagina web e richiama il server PHP per ottenere le soluzioni |
| `assets/style.css` | Foglio di stile CSS che definisce l'aspetto visivo dell'applicazione web, incluso il design della scacchiera e dello sfondo |