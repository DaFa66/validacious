<!DOCTYPE html>
<html lang="en">

<head>
  <base href="<?= BASE_URL ?>">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>String Helper Tester - Test Results</title>
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
      <div class="card-heading">String Helper Unit Tests</div>
      <div class="card-body">
        <p>Comprehensive tests for all <code>string_helper</code> functions.</p>

        <div class="col-header">
          <span>Test Description</span>
          <span>Expected</span>
          <span>Actual</span>
          <span>Result</span>
        </div>

        <?php
        // Group results by helper key
        $grouped = [];
        foreach ($test_results as $row) {
          $grouped[$row['key']][] = $row;
        }

        // Sort groups by official Trongate docs order (alphabetical as listed).
        // filter_string is a deprecated alias not in the docs — appended after filter_str.
        $docs_order = [
          'extract_content', 'filter_name', 'filter_str', 'filter_string',
          'get_last_part', 'make_rand_str', 'nice_price', 'out',
          'remove_html_code', 'remove_substr_between', 'replace_html_tags',
          'sanitize_filename', 'truncate_str', 'truncate_words', 'url_title',
        ];
        uksort($grouped, function ($a, $b) use ($docs_order) {
          $ai = array_search($a, $docs_order);
          $bi = array_search($b, $docs_order);
          $ai = $ai === false ? PHP_INT_MAX : $ai;
          $bi = $bi === false ? PHP_INT_MAX : $bi;
          return $ai <=> $bi;
        });

        foreach ($grouped as $key => $rows):
          $group_pass = array_reduce($rows, fn($carry, $r) => $carry && $r['pass'], true);
        ?>
          <div class="test-group">
            <div class="test-group-heading" style="border-left-color: <?= $group_pass ? '#28a745' : '#dc3545' ?>">
              <?= out($key) ?>()
            </div>
            <?php foreach ($rows as $row):
              $cls = $row['pass'] ? 'pass' : 'fail';
              $expected_str = is_bool($row['expected']) ? ($row['expected'] ? 'true' : 'false') : (string)$row['expected'];
              $actual_str   = is_bool($row['actual'])   ? ($row['actual']   ? 'true' : 'false') : (string)$row['actual'];
              // Truncate long raw values for display
              if (strlen($expected_str) > 120) $expected_str = substr($expected_str, 0, 117) . '…';
              if (strlen($actual_str)   > 120) $actual_str   = substr($actual_str,   0, 117) . '…';
            ?>
              <div class="test-row <?= $cls ?>">
                <span class="test-label"><?= out($row['label']) ?></span>
                <span class="test-expected"><?= out($expected_str) ?></span>
                <span class="test-actual <?= $cls ?>"><?= out($actual_str) ?></span>
                <span class="badge <?= $cls ?>"><?= $row['pass'] ? '✓ PASS' : '✗ FAIL' ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endforeach; ?>

        <?php
        $total  = count($test_results);
        $passed = count(array_filter($test_results, fn($r) => $r['pass']));
        $failed = $total - $passed;
        $all_ok = $failed === 0;
        ?>
        <div style="display:flex; align-items:center; gap:1em; margin-top:1.5em;">
          <div class="summary-bar <?= $all_ok ? 'all-pass' : 'has-fail' ?>" style="margin-top:0; flex:1;">
            <?= $passed ?> / <?= $total ?> tests passed
            <?= !$all_ok ? " — {$failed} failing" : ' — All tests passing ✓' ?>
          </div>
          <?= anchor('helper_testers', '← Back to Helper Testers', ['class' => 'button alt']) ?>
        </div>
      </div>
    </div>
  </div>
</body>

</html>