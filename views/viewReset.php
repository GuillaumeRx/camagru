<?php $this->_t = 'Reset Password'; ?>
<div id="login">
	<div class="form-box">
		<h2>Modification de mot de passe</h2>
		<form method="POST" action="/reset/<?= $token ?>" class="form">
			<input type="hidden" id="email" name="email" value="<?= $user['email'] ?>"/>
		<span>
			<label for="password">Mot de passe</label>	
			<input type="password" placeholder="Ça c'est un secret" id="password" name="password"/>
		</span>
			<button type="submit">Envoyer</button>
		</form>
	</div>
</div>