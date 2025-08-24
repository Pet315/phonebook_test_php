<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Models\Contact;
use App\Validation\Validator;

class ContactController extends Controller
{
    private function handleUpload(?array $file): ?string
    {
        if (!$file || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) return null;
        if ($file['error'] !== UPLOAD_ERR_OK) return null;

        $maxBytes = (int)$this->config['max_upload_mb'] * 1024 * 1024;
        if ($file['size'] > $maxBytes) return null;

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        $ext = $mime === 'image/jpeg' ? 'jpg' : ($mime === 'image/png' ? 'png' : null);
        if (!$ext) return null;

        $name = bin2hex(random_bytes(8)) . '.' . $ext;
        $destDir = $this->config['upload_dir'];
        if (!is_dir($destDir)) @mkdir($destDir, 0775, true);
        $dest = rtrim($destDir, '/').'/'.$name;
        if (!move_uploaded_file($file['tmp_name'], $dest)) return null;
        return rtrim($this->config['upload_url'],'/').'/'.$name;
    }

    public function index(): void
    {
        $contacts = (new Contact($this->config))->allByUser((int)$_SESSION['user_id']);
        $this->view('contacts/index', ['contacts'=>$contacts, 'csrf'=>Csrf::token(), 'username'=>$_SESSION['username'] ?? '']);
    }

    public function show(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $contact = (new Contact($this->config))->find($id, (int)$_SESSION['user_id']);
        if (!$contact){ http_response_code(404); echo 'Not found'; return; }
        $this->view('contacts/show', ['c'=>$contact, 'csrf'=>Csrf::token()]);
    }

    public function create(): void
    {
        if (!Csrf::check($_POST['csrf'] ?? null)){
            $this->json(['success'=>false,'error'=>'Invalid CSRF'], 400); return;
        }

        $data = [
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name'  => trim($_POST['last_name'] ?? ''),
            'phone'      => trim($_POST['phone'] ?? ''),
            'email'      => trim($_POST['email'] ?? '')
        ];

        if (!Validator::name($data['first_name']) || !Validator::name($data['last_name'])){
            $this->json(['success'=>false,'error'=>'Некоректне ім\'я або прізвище'], 422); return;
        }
        if (!Validator::phone($data['phone'])){
            $this->json(['success'=>false,'error'=>'Некоректний номер телефону'], 422); return;
        }
        if ($data['email'] !== '' && !Validator::email($data['email'])){
            $this->json(['success'=>false,'error'=>'Некоректна адреса email'], 422); return;
        }

        $img = $this->handleUpload($_FILES['image'] ?? null);
        if (isset($_FILES['image']) && !$img){
            $this->json(['success'=>false,'error'=>'Проблема із зображенням (тип або розмір)'], 422); return;
        }

        $data['image_path'] = $img;
        $data['user_id'] = (int)$_SESSION['user_id'];

        $id = (new Contact($this->config))->create($data);
        $this->json(['success'=>true,'id'=>$id]);
    }

    public function update(): void
    {
        if (!Csrf::check($_POST['csrf'] ?? null)){
            $this->view('contacts/edit', ['error'=>'Invalid CSRF', 'csrf'=>Csrf::token()]); return;
        }

        $id = (int)($_POST['id'] ?? 0);
        $model = new Contact($this->config);
        $existing = $model->find($id, (int)$_SESSION['user_id']);
        if (!$existing){ http_response_code(404); echo 'Not found'; return; }

        $data = [
            'first_name' => trim($_POST['first_name'] ?? ''),
            'last_name'  => trim($_POST['last_name'] ?? ''),
            'phone'      => trim($_POST['phone'] ?? ''),
            'email'      => trim($_POST['email'] ?? '')
        ];

        if (!Validator::name($data['first_name']) || !Validator::name($data['last_name'])){
            $this->view('contacts/edit', ['error'=>'Некоректне ім\'я або прізвище','c'=>$existing,'csrf'=>Csrf::token()]); return;
        }
        if (!Validator::phone($data['phone'])){
            $this->view('contacts/edit', ['error'=>'Некоректний телефон','c'=>$existing,'csrf'=>Csrf::token()]); return;
        }
        if ($data['email'] !== '' && !Validator::email($data['email'])){
            $this->view('contacts/edit', ['error'=>'Некоректний email','c'=>$existing,'csrf'=>Csrf::token()]); return;
        }

        $img = $this->handleUpload($_FILES['image'] ?? null);
        $data['image_path'] = $img ?: ($existing['image_path'] ?? null);

        $model->update($id, (int)$_SESSION['user_id'], $data);
        header('Location: /contacts/view?id='.$id);
    }

    public function delete(): void
    {
        if (!Csrf::check($_POST['csrf'] ?? null)){
            http_response_code(400); echo 'Invalid CSRF'; return;
        }
        $id = (int)($_POST['id'] ?? 0);
        (new Contact($this->config))->delete($id, (int)$_SESSION['user_id']);
        header('Location: /contacts');
    }
}
