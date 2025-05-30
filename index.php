<!DOCTYPE html>
<html lang="de">

<head>
  <meta charset="UTF-8" />
  <title>📘 Aufsatzsuche – Excel-Tabelle</title>

  <link rel="stylesheet" href="assets/css/01_bootstrap.min.css"> <!-- boostrap -->
  <link href="assets/css/01_bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/02_mermaid.min.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />

</head>

<body>

  <div class="table-container">
    <div class="table-controls">
      <label for="pageSize">Beiträge pro Seite:</label>
      <select id="pageSize">
        <option value="10" selected>10</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
      </select>
    </div>


    <div id="table-wrapper"></div>
  </div>

  <script src="assets/js/01_jquery-3.7.0.min.js"></script>
  <script src="assets/js/02_gridjs.umd.js"></script>
  <script src="assets/js/z_custom.js"></script>


</body>

</html>