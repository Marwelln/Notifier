<div id='notifier' class='alert {{ $notifier->visible }} {{ $notifier->type }} alert-dismissible {{ $notifier->autoclose }}'>
	<button class='close hide'><i class='fa fa-remove'></i></button>
	{!! $notifier->message !!}
</div>