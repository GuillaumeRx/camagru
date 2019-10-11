<?php foreach($articles as $article): ?>
<h2><?= $article->title() ?></h2>
<time><?= $picture->date() ?> </time>
<?php endforeach; ?>