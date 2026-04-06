<!DOCTYPE html>
<html lang="en">

<head>
  <base href="<?= BASE_URL ?>">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Helper Testers Overview</title>
  <link rel="stylesheet" href="css/trongate.css">
  <link rel="stylesheet" href="helper_testers_module/css/custom.css">
  <script src="helper_testers_module/js/custom.js"></script>
</head>

<body>
  <div class="container">
    <div class="toggle-container">
      <label class="toggle-switch">
        <input type="checkbox" id="darkModeToggle">
        <span class="slider"></span>
      </label>
    </div>
    <div class="text-center">
      <h1>Helper Testers Overview</h1>
      <p>Comprehensive testing suite for all Trongate helper functions</p>
    </div>

    <?php foreach ($testers as $tester): ?>
      <div class="card">
        <div class="card-heading">
          <?= $tester['name'] ?>
        </div>
        <div class="card-body">
          <p><?= $tester['description'] ?></p>
          <?= anchor($tester['url'], 'Run Tests', ['class' => 'button']); ?>
          <?= anchor($tester['readme'], 'View README', ['class' => 'button alt']); ?>
        </div>
      </div>
    <?php endforeach; ?>

    <div class="card">
      <div class="card-heading">
        Suite Overview & Statistics
      </div>
      <div class="card-body">
        <p>This testing suite runs rigorous per-attribute assertions across all core helper functions to map regressions against the defined framework behaviour.</p>
        
        <table>
          <thead>
            <tr>
              <th class="text-left">Target Module</th>
              <th class="text-center">Active Asserts</th>
              <th class="text-center">Skipped</th>
              <th class="text-center">Total Validations</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>String Helper</td>
              <td class="text-center">93</td>
              <td class="text-center">0</td>
              <td class="text-center" style="font-weight: bold;">93</td>
            </tr>
            <tr>
              <td>Flashdata Helper</td>
              <td class="text-center">13</td>
              <td class="text-center">0</td>
              <td class="text-center" style="font-weight: bold;">13</td>
            </tr>
            <tr>
              <td>Form Helper</td>
              <td class="text-center">113</td>
              <td class="text-center">5</td>
              <td class="text-center" style="font-weight: bold;">118</td>
            </tr>
            <tr>
              <td>URL Helper</td>
              <td class="text-center">33</td>
              <td class="text-center">3</td>
              <td class="text-center" style="font-weight: bold;">36</td>
            </tr>
            <tr>
              <td>Utilities Helper</td>
              <td class="text-center">20</td>
              <td class="text-center">4</td>
              <td class="text-center" style="font-weight: bold;">24</td>
            </tr>
            <tr style="font-weight: bold;">
              <td>Total Operations</td>
              <td class="text-center" style="color: #28a745;">272</td>
              <td class="text-center" style="color: #6c757d;">12</td>
              <td class="text-center">284</td>
            </tr>
          </tbody>
        </table>

        <div style="margin-top: 15px; font-size: 0.9em; color: #555;">
          <strong>Total Test Modules: <?= count($testers); ?></strong>
        </div>
      </div>
    </div>
</body>

</html>