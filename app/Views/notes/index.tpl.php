<?php
require_once COMPONENTS . '/header.tpl.php';
?>
    <div class="wrapper">
<main>
    <h1 class="top_header">Заметки</h1>
    <div class="create_btn">
        <button class="primary_btn"><a href="/notes/create">Создать новую заметку +</a></button>
    </div>
    <div>
        <?php foreach($notes as $note): ?>
        <div class="note_block note" data-id="<?=$note['id']?>">
            <div class="note_block__time"><?= $note['created_at']?></div>
            <div class="note_block__title">
            <h1><a href="/notes/<?= $note['id']?>"><?= $note['title']?></a></h1>
            </div>
            <div class="note_block__content">
            <p><?= $note['content']?></p>
            </div>
            <div>
                <button class="danger_btn delete-note" data-id="<?=$note['id']?>">Удалить</button>
            </div>
        </div>
<?php endforeach;?>
    </div>
</main>
    </div>
<?php
require_once COMPONENTS . '/footer.tpl.php';