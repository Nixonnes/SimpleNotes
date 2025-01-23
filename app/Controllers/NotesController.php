<?php

namespace App\Controllers;

use App\Classes\MySQLConnection;
use App\Models\Note;
use Exception;
use JetBrains\PhpStorm\NoReturn;

class NotesController
{
    public function index(): void
    {
        Note::initialize(new MySQLConnection());
        $notes = Note::findAll();
        require VIEWS . '/notes/index.tpl.php';
    }
    public function create():void
    {
        require VIEWS . '/notes/create.tpl.php';
    }

    /**
     * @throws Exception
     */
    public function store(): array|null
    {
        $errors = [];
        $data = $this->getRequestData();

        // Валидация данных
        if (empty($data['title'])) {
            $errors['title'] = 'Поле обязательно для заполнения';
        }
        if (strlen($data['title']) < 3) {
            $errors['title'] = "Поле должно содержать не менее 3 символов";
        }

        // Если есть ошибки, возвращаем их
        if (!empty($errors)) {
            return ['status' => 'error', 'messages' => $errors];
        }

        try {
            // Инициализация модели
            Note::initialize(new MySQLConnection());
            Note::create($data);

            // Редирект после успешного создания
            header('Location: /');
            exit; // Прерываем выполнение после редиректа
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Ошибка сохранения данных: ' . $e->getMessage()];
        }
    }

    /**
     * @throws Exception
     */
    public function show($id): void
    {
        Note::initialize(new MySQLConnection());
        $note = Note::find($id);
        require VIEWS . '/notes/show.tpl.php';
    }
    public function edit($id) : void
    {
        Note::initialize(new MySQLConnection());
        $note = Note::find($id);
        require VIEWS . '/notes/edit.tpl.php';
    }

    /**
     * @throws Exception
     */
    #[NoReturn] public function update($id): void
    {
        $data = $this->getRequestData();
        Note::initialize(new MySQLConnection());
        Note::update($data, ['id' => $id]);
        header('Location: /');
        exit;
    }
    public function delete($id): void
    {
        header('Content-Type: application/json'); // Устанавливаем заголовок для JSON
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
        Note::initialize(new MySQLConnection());
        Note::delete(['id' => $id]);
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Note deleted successfully.'];
            echo json_encode(['status' => 'success', 'message' => 'Note deleted successfully.']);
            return;
    } else {
        $_SESSION['flash'] = ['type' => 'error', 'message' => 'Note not found.'];
            echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
    }
exit;
    }
    private function getRequestData(): array
    {
        return [
            'title' => $_POST['title'] ?? null,
            'content' => $_POST['content'] ?? null,
        ];
    }
}