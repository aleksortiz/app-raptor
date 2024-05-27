<h3>Se ha generado ticket de soporte</h3>
<p>Fecha: {{$ticket->fecha_format}}</p>
<p>Sistema: {{$ticket->app_name}}</p>
<p>Usuario: {{$ticket->user_name}}</p>
<p>Tipo: {{$ticket->type}}</p>
<p>Requerimiento:</p>
<pre>{{$ticket->description}}</pre>