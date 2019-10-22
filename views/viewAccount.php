<?php $this->_t = 'Your Account'; ?>
<div id="account">
	<div class="form-box">
		<div class="profile-header">
			<img src="<?= ($account->pic()) ? $account->pic() : 'http://via.placeholder.com/100' ?>"/>
			<div class="username">
				<p><?= $account->username() ?></p>
				<a href="#">Modifier la photo de profil</a>
			</div>
		</div>
		<form method="POST" action="/register">
		<span>
			<label for="username">Nom d’utilisateur</label>	
			<input type="text" placeholder="Ton nom d'utilisateur"  value="<?= $account->username() ?>" id="username" name="username"/>
		</span>
		<span>
			<label for="email">Adresse e-mail</label>	
			<input type="text" placeholder="Tom e-mail" value="<?= $account->email() ?>" id="email" name="email"/>
		</span>
		<span>
			<label for="bio">Bio</label>	
			<textarea id="bio" name="bio">
				<?= $account->bio() ?>
			</textarea>		
		</span>
		<span>
		<label for="password">Mot de passe</label>	
			<input type="password" placeholder="Ça c'est un secret" id="password" name="password"/>
		</span>
		<button type="submit">Envoyer</button>
		<a href="/logout">Déconnexion</a>
		</form>
		
	</div>
</div>