# DOIT
Progetto per il corso di Tecnologie Web UNIPD A.A. 2019/20, tenuto dai professori Ombretta Gaggi e Matteo Ciman.

Si è scelto di realizzare un piccolo social network per la condivisione e partecipazione ad attività di volontariato.

Il progetto è stato realizzato da Alessandro Chimetto, Francesco De Salvador, Stefano Biotto e Daniele Bresciani.

## Requisiti
- Il sito web deve essere realizzato con lo standard XHTML 1.0 Strict, eventuali pagine in HTML5 sono permesse, ma queste devono essere giustificate e degradare in modo elegante (devono rispettare le regole XHTML);
- il layout deve essere realizzato con CSS puri (CSS2 o CSS3);
- il sito web deve rispettare la completa separazione tra contenuto, presentazione e comportamento;
- il sito web deve essere accessibile a tutte le categorie di utenti;
- il sito web deve organizzare i propri contenuti in modo da poter essere facilmente reperiti da qualsiasi utente;
- il sito web deve contenere pagine che utilizzino script PHP per collezionare e pubblicare dati inseriti dagli utenti (deve essere sviluppata anche la possibilità di modifica e cancellazione dei dati stessi);
- deve essere presente una forma di controllo dell’input inserito dall’utente, sia lato client che lato server
- i dati inseriti dagli utenti devono essere salvati in un database;
- è preferibile che il database sia in forma normale.

Il progetto deve essere accompagnato da una relazione che ne illustri le fasi di progettazione, realizzazione e test ed evidenzi il ruolo svolto dai singoli componenti del gruppo.

Viene richiesta un'analisi iniziale delle caratteristiche degli utenti che il sito si propone di raggiungere. Le pagine web devono essere accessibili indipendentemente dal browser e dalle dimensioni dello schermo del dispositivo degli utenti. Considerazioni riguardanti diversi dispositivi (laddove possibile) verranno valutate positivamente.

## Relazione
È possibile prenderne visione consultando il file [RELAZIONE.pdf](RELAZIONE.pdf).

## Feedback
Il progetto è stato valutato positivamente con un voto di 27/30.

Sono state segnalate le seguenti problematiche:
- La gerarchia degli headings dovrebbe essere più precisa nelle varie pagine; per esempio, nelle pagine post, "sezione relazioni" doveva essere _h2_, mentre i commenti _h3_.
- I tag _meta_, soprattutto keywords, dovrebbero essere diversi per ogni pagina, per esempio nelle pagine di profilo doveva esserci la keyword "profilo utente".
- Sono stati usati dei tag _br_ non necessari che potrebbero essere sostituiti con un unico tag _dl_.
- Riguardo ai controlli javascript nei form, quando un utente inserisce dei dati in un _input_ non gli si dovrebbe dare la possibilità di inserire solo spazi vuoti, ma esclusivamente caratteri alfanumerici.
- Alcune immagini necessiterebbero di testi alternativi più esplicativi, per esempio l'immagine di profilo dovrebbe avere alt="Immagine profilo di Mario Rossi".
- Il titolo del sito DOIT è un tag _abbr_ per questioni di accessibilità ma, non essendo una abbreviazione, sarebbe stato più corretto l'utilizzo del tag _title_.
