<!doctype html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Телефонна книга</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="/">Телефонна книга</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        <?php if (!empty($_SESSION['user_id'])): ?>
          <li class="nav-item"><span class="navbar-text me-3"><?=htmlspecialchars($_SESSION['username'] ?? '')?></span></li>
          <li class="nav-item"><a class="nav-link" href="/contacts">Контакти</a></li>
          <li class="nav-item"><a class="nav-link" href="/logout">Вийти</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="/login">Вхід</a></li>
          <li class="nav-item"><a class="nav-link" href="/register">Реєстрація</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<div class="container mt-4">
