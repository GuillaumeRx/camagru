<?php $this->_t = 'Your Account'; ?>
<form>
<input value="<?= $account->username() ?>" type="text" />
<input value="<?= $account->email() ?>" type="text" />
<input type="text" />
<form>
<a href="/logout">Logout</a>