<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow">
      <div class="card-body">
        <h3 class="mb-3">Вхід</h3>
        <?php if (!empty($error)): ?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif; ?>
        <form method="post" action="/login">
          <input type="hidden" name="csrf" value="<?=$csrf?>">
          <div class="mb-3">
            <label class="form-label">Логін або Email</label>
            <input class="form-control" name="login" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Пароль</label>
            <input type="password" class="form-control" name="password" required>
          </div>
          <button class="btn btn-primary">Увійти</button>
          <a class="btn btn-link" href="/register">Реєстрація</a>
        </form>
      </div>
    </div>
  </div>
</div>
