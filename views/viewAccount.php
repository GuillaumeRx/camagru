<?php $this->_t = 'Your Account'; ?>
<div id="account">
	<div class="form-box">
		<div class="profile-header">
			<img src="<?= ($account->pic()) ? $account->pic() : 'http://via.placeholder.com/100' ?>"/>
			<div class="username">
				<p><?= $account->username() ?></p>
				<form action="/account" method="POST">
					<label class="pic-picker" for="pic">Modifier la photo de profil</label>	
					<input type="file" accept="image/*" id="pic" name="pic" type="submit"/>
				</form>
			</div>
		</div>
		<form method="POST" action="/account" class="form">
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
			<textarea id="bio" name="bio"><?= $account->bio() ?></textarea>		
		</span>
		<button type="submit">Envoyer</button>
		<a href="/logout">Déconnexion</a>
		</form>
		
	</div>
</div>