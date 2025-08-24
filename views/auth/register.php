<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card shadow">
      <div class="card-body">
        <h3 class="mb-3">Реєстрація</h3>
        <?php if (!empty($error)): ?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif; ?>
        <?php if (!empty($errors)): ?>
          <div class="alert alert-danger">
            <ul class="mb-0"><?php foreach ($errors as $e): ?><li><?=htmlspecialchars($e)?></li><?php endforeach; ?></ul>
          </div>
        <?php endif; ?>
        <form method="post" action="/register">
          <input type="hidden" name="csrf" value="<?=$csrf?>">
          <div class="mb-3">
            <label class="form-label">Логін</label>
            <input class="form-control" name="username" maxlength="16" required>
            <div class="form-text">Латинські літери та цифри, 3–16 символів.</div>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Пароль</label>
            <input type="password" class="form-control" name="password" required>
            <div class="form-text">Мінімум 6 символів, великі/малі літери та цифри.</div>
          </div>
          <button class="btn btn-primary">Зареєструватися</button>
          <a class="btn btn-link" href="/login">Вже є акаунт?</a>
        </form>
      </div>
    </div>
  </div>
</div>
