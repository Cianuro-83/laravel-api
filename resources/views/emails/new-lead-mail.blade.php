<h1>
    Ciao {{env('APP_NAME')}}
</h1>

<p>
    Hai ricevuto una nuova richiesta di contatto <br>
    da: {{$lead->name}} <br>
    Email: {{$lead->email}} <br>
    con il seguente testo: <br>
    {{$lead->message}}
</p>


<footer>
    il team di {{env('APP_NAME')}}.
</footer>