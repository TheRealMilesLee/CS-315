<!DOCTYPE html>
<html lang='en'>
<head>
  <meta charset='utf-8' />
  <title>Echo Data</title>
  <meta name='author' content='Jon Beck' />
</head>
<body>
<h1>Echoing Data Sent to This URL</h1>
<?php if (isset($_GET)): ?>
  <p> GET Data Sent to This PHP Program <p>
  <p>
    <pre>
      <?php foreach ($_GET as $parameter => $value): ?>
        $_GET[<?= $parameter ?>]: <?= $value . PHP_EOL ?>
      <?php endforeach; ?>
    </pre>
  </p>
<?php endif; ?>

<?php if (isset($_POST)): ?>
  <p>POST Data Sent to This PHP Program</p>
  <p>
    <pre>
      <?php
      foreach ($_POST as $parameter => $value): ?>
        $_POST[<?= $parameter ?>]: <?= $value . PHP_EOL ?>
      <?php endforeach; ?>
    </pre>
  </p>
<?php endif; ?>
</body>
</html>