<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';


use PhpOffice\PhpSpreadsheet\IOFactory;

header('Content-Type: application/json; charset=utf-8');

class ExcelReader
{
  private string $filePath;
  private array $filterKeys;

  public function __construct(string $filePath, array $filterKeys = [])
  {
    $this->filePath = $filePath;
    $this->filterKeys = $filterKeys;
  }

  public function read(): array
  {
    if (!file_exists($this->filePath)) {
      throw new Exception('Excel-Datei nicht gefunden.');
    }

    $spreadsheet = IOFactory::load($this->filePath);
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray(null, true, true, true);

    if (empty($rows)) {
      return [];
    }

    $headers = array_shift($rows);
    array_pop($headers); // letzte Spalte entfernen

    $data = [];

    foreach ($rows as $row) {
      array_pop($row); // letzte Spalte entfernen

      if (!$this->passesFilters($row, $headers)) {
        continue;
      }

      $item = [];
      foreach ($headers as $col => $colName) {
        $item[$colName] = $row[$col] ?? '';
      }
      $data[] = $item;
    }

    return $data;
  }

  private function passesFilters(array $row, array $headers): bool
  {
    foreach ($this->filterKeys as $filterKey) {
      if (!empty($_GET[$filterKey])) {
        $filterVal = mb_strtolower(trim($_GET[$filterKey]));
        $colIndex = array_search($filterKey, $headers);

        if ($colIndex === false) {
          continue;
        }

        $cellVal = mb_strtolower($row[$colIndex] ?? '');

        if (strpos($cellVal, $filterVal) === false) {
          return false;
        }
      }
    }

    return true;
  }
}

try {
  $reader = new ExcelReader(__DIR__ . '/excel_php/file_example_XLS_1000.xls');
  $data = $reader->read();

  echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
} catch (Exception $e) {
  http_response_code(500);
  echo json_encode([
    'error' => 'Fehler beim Lesen der Excel-Datei',
    'message' => $e->getMessage()
  ]);
}
