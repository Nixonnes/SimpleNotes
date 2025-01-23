<?php
require COMPONENTS .'/header.tpl.php';
?>
<main>
    <h1>Создание заметки</h1>
    <form class="form-group" action="/notes/create" method="post">
        <div>
            <input class="text-input" type="text" name="title" id="title" placeholder="О чем вы хотите написать?">
            <textarea class="textarea-input" placeholder="Напишите что-нибудь" name="content"></textarea>
            <button type="submit" class="crt_btn">Создать</button>
        </div>
</main>
