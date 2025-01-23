<?php
require_once COMPONENTS .'/header.tpl.php';
?>

<main>
    <div class="note_page">

        <div class="note_page__title">
        <h1><?= $note['title']?></h1>
        </div>
        <div>
            <button class="primary_btn"><a href="/notes/<?=$note['id']?>/edit">Редактировать</a></button>
        </div>
        <div class="note_page__content">
            <p><?= $note['content']?></p>
        </div>
    </div>

</main>
