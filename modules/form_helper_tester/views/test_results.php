<!DOCTYPE html>
<html lang="en">

<head>
  <base href="<?= BASE_URL ?>">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Helper Tester - Test Results</title>
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
    <div class="card">
      <div class="card-heading">Form Helper Unit Tests</div>
      <div class="card-body">
        <p>Comprehensive tests for all <code>form_helper</code> functions.</p>

        <div class="col-header">
          <span>Test Description</span>
          <span>Expected</span>
          <span>Actual</span>
          <span>Result</span>
        </div>

        <?php
        // Group by helper key
        $grouped = [];
        foreach ($test_results as $row) {
          $grouped[$row['key']][] = $row;
        }

        // Sort by official docs order
        $docs_order = [
          'form_button', 'form_checkbox', 'form_close', 'form_date',
          'form_datetime_local', 'form_dropdown', 'form_email', 'form_file_select',
          'form_hidden', 'form_input', 'form_label', 'form_month', 'form_number',
          'form_open', 'form_open_upload', 'form_password', 'form_radio',
          'form_search', 'form_submit', 'form_textarea', 'form_time', 'form_week',
          'post', 'validation_errors',
        ];
        uksort($grouped, function ($a, $b) use ($docs_order) {
          $ai = array_search($a, $docs_order);
          $bi = array_search($b, $docs_order);
          $ai = $ai === false ? PHP_INT_MAX : $ai;
          $bi = $bi === false ? PHP_INT_MAX : $bi;
          return $ai <=> $bi;
        });

        foreach ($grouped as $key => $rows):
          // Skip-only tests don't count as failures
          $non_skip = array_filter($rows, fn($r) => !str_ends_with($r['label'], '(SKIPPED)'));
          $group_pass = empty($non_skip) || array_reduce($non_skip, fn($carry, $r) => $carry && $r['pass'], true);
        ?>
          <div class="test-group">
            <div class="test-group-heading" style="border-left-color: <?= $group_pass ? '#28a745' : '#dc3545' ?>">
              <?= out($key) ?>()
            </div>
            <?php foreach ($rows as $row):
              $is_skip = str_ends_with($row['label'], '(SKIPPED)');
              $cls = $is_skip ? 'skip' : ($row['pass'] ? 'pass' : 'fail');
              $badge_text = $is_skip ? '— SKIP' : ($row['pass'] ? '✓ PASS' : '✗ FAIL');
              $expected_str = is_bool($row['expected']) ? ($row['expected'] ? 'true' : 'false') : (string)$row['expected'];
              $actual_str   = is_bool($row['actual'])   ? ($row['actual']   ? 'true' : 'false') : (string)$row['actual'];
              if (strlen($expected_str) > 100) $expected_str = substr($expected_str, 0, 97) . '…';
              if (strlen($actual_str)   > 100) $actual_str   = substr($actual_str,   0, 97) . '…';
            ?>
              <div class="test-row <?= $cls ?>">
                <span class="test-label"><?= out($row['label']) ?></span>
                <span class="test-expected"><?= out($expected_str) ?></span>
                <span class="test-actual <?= $cls ?>"><?= out($actual_str) ?></span>
                <span class="badge <?= $cls ?>"><?= $badge_text ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>

        <?php
        $non_skip_results = array_filter($test_results, fn($r) => !str_ends_with($r['label'], '(SKIPPED)'));
        $total  = count($non_skip_results);
        $passed = count(array_filter($non_skip_results, fn($r) => $r['pass']));
        $skipped = count($test_results) - $total;
        $failed = $total - $passed;
        $all_ok = $failed === 0;
        ?>
        <div style="display:flex; align-items:center; gap:1em; margin-top:1.5em;">
          <div class="summary-bar <?= $all_ok ? 'all-pass' : 'has-fail' ?>">
            <?= $passed ?> / <?= $total ?> tests passed
            <?= $skipped > 0 ? " — {$skipped} skipped" : '' ?>
            <?= !$all_ok ? " — {$failed} failing" : ' — All tests passing ✓' ?>
          </div>
          <?= anchor('helper_testers', '← Back to Helper Testers', ['class' => 'button alt']) ?>
        </div>
      </div>
    </div>
  </div>
</body>

</html>