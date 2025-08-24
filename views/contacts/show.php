<div class="mb-3">
  <a href="/contacts" class="btn btn-light">&larr; Назад</a>
  <a href="#" class="btn btn-secondary" onclick="document.getElementById('edit-form').style.display='block';return false;">Редагувати</a>
</div>

<div class="card mb-4">
  <div class="card-body d-flex align-items-center">
    <?php if (!empty($c['image_path'])): ?>
      <img src="<?=htmlspecialchars($c['image_path'])?>" class="avatar me-3" alt="avatar">
    <?php endif; ?>
    <div>
      <h4 class="mb-1"><?=htmlspecialchars($c['last_name'].' '.$c['first_name'])?></h4>
      <div> <?=htmlspecialchars($c['phone'])?></div>
      <?php if ($c['email']): ?><div> <?=htmlspecialchars($c['email'])?></div><?php endif; ?>
    </div>
  </div>
</div>

<div id="edit-form" style="display:none">
  <div class="card">
    <div class="card-body">
      <h5>Редагування</h5>
      <?php if (!empty($error)): ?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif; ?>
      <form method="post" action="/contacts/update" enctype="multipart/form-data">
        <input type="hidden" name="csrf" value="<?=$csrf?>">
        <input type="hidden" name="id" value="<?=$c['id']?>">
        <div class="row g-3">
          <div class="col-md-6">
            <label class="form-label">Ім'я</label>
            <input class="form-control" name="first_name" value="<?=htmlspecialchars($c['first_name'])?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Прізвище</label>
            <input class="form-control" name="last_name" value="<?=htmlspecialchars($c['last_name'])?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Телефон</label>
            <input class="form-control" name="phone" value="<?=htmlspecialchars($c['phone'])?>" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?=htmlspecialchars($c['email'] ?? '')?>">
          </div>
          <div class="col-md-6">
            <label class="form-label">Нове зображення</label>
            <input type="file" name="image" class="form-control" accept="image/jpeg,image/png">
          </div>
        </div>
        <div class="mt-3">
          <button class="btn btn-primary">Зберегти</button>
        </div>
      </form>
    </div>
  </div>
</div>
