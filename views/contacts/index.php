<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Моя телефонна книга</h3>
  <span>Вітаю, <strong><?=htmlspecialchars($username)?></strong></span>
</div>

<div id="ajax-alert" class="alert" style="display:none"></div>

<div class="card mb-4">
  <div class="card-body">
    <h5 class="card-title mb-3">Додати контакт (AJAX)</h5>
    <form id="add-contact-form" enctype="multipart/form-data">
      <input type="hidden" name="csrf" value="<?=$csrf?>">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Ім'я</label>
          <input name="first_name" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Прізвище</label>
          <input name="last_name" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Телефон</label>
          <input name="phone" class="form-control" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control">
        </div>
        <div class="col-md-6">
          <label class="form-label">Зображення (jpg/png, ≤5 МБ)</label>
          <input type="file" name="image" class="form-control" accept="image/jpeg,image/png">
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-success">Додати</button>
      </div>
    </form>
  </div>
</div>

<?php if (!$contacts): ?>
  <div class="alert alert-secondary">Поки що немає контактів.</div>
<?php else: ?>
  <div class="table-responsive">
    <table class="table align-middle">
      <thead><tr><th>Фото</th><th>Ім'я</th><th>Телефон</th><th>Email</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($contacts as $c): ?>
        <tr>
          <td><?php if (!empty($c['image_path'])): ?>
            <img src="<?=htmlspecialchars($c['image_path'])?>" class="avatar" alt="avatar">
          <?php endif; ?></td>
          <td><?=htmlspecialchars($c['last_name'].' '.$c['first_name'])?></td>
          <td><?=htmlspecialchars($c['phone'])?></td>
          <td><?=htmlspecialchars($c['email'] ?? '')?></td>
          <td class="text-end">
            <a class="btn btn-sm btn-primary" href="/contacts/view?id=<?=$c['id']?>">Переглянути</a>
            <form method="post" action="/contacts/delete" class="d-inline" onsubmit="return confirm('Видалити контакт?')">
              <input type="hidden" name="csrf" value="<?=$csrf?>">
              <input type="hidden" name="id" value="<?=$c['id']?>">
              <button class="btn btn-sm btn-danger">Видалити</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
<?php endif; ?>
