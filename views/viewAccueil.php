<?php $this->_t = 'Accueil';
foreach($pictures as $picture): ?>
<h2><?= $picture->title() ?></h2>
<time><?= $picture->date() ?> </time>
<?php endforeach; ?>