<?php
require COMPONENTS .'/header.tpl.php';
?>
<main>
    <h1>Редактирование заметки</h1>
    <form class="form-group" action="/notes/<?=$note['id']?>/edit" method="post">
        <div>
            <input class="text-input" type="text" name="title" id="title" placeholder="О чем вы хотите написать?" value="<?=$note['title']?>">
            <textarea class="textarea-input" placeholder="Напишите что-нибудь" name="content"><?= $note['content']?></textarea>
            <button type="submit" class="crt_btn">Сохранить</button>
        </div>
</main>
