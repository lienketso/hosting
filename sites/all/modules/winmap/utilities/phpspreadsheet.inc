<?php

require_once(DRUPAL_ROOT . "/sites/all/libraries/PhpOffice/autoload.php");

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


function phpspreadsheet_import ($path,$nullValue = null, $calculateFormulas = true, $formatData = true, $returnCellRef = false) {
  $data = null;
  $inputFileType = null;
  $inputFileName = $path;
  $extension = pathinfo($path, PATHINFO_EXTENSION);
  if (strtolower($extension) == 'xls') {
    $inputFileType = 'Xls';
  }if (strtolower($extension) == 'html') {
    $inputFileType = 'Html';
  }elseif (strtolower($extension) == 'xlsx') {
    $inputFileType = 'Xlsx';
  }
  if ($inputFileType != null) {
    try {
      $reader = IOFactory::createReader($inputFileType);
//      $reader->setReadDataOnly(false);
      $reader->setReadEmptyCells(false);
      $spreadsheet = $reader->load($inputFileName);
      $data = $spreadsheet->getActiveSheet()->toArray($nullValue, $calculateFormulas, $formatData, $returnCellRef);
//      print_r($spreadsheet->getActiveSheet()->getMergeCells());
//      print_r($data);
//      exit();
    }catch (Exception $e) {
    }
  }
  return $data;
}

function phpspreadsheet_export ($worksheets = array(), $filename = null, $header = true) {
  if (empty($filename)) {
    $filename = date("Y-m-d");
  }
  $_spreadsheet_ = new Spreadsheet();

// delete the default active sheet
  $_spreadsheet_->removeSheetByIndex(0);

  $_worksheet_index_ = 0;
  $_worksheets_ = array();
  foreach ($worksheets as $_worksheet_) {
    $__worksheet__ = new Worksheet($_spreadsheet_, $_worksheet_['title']);
    $_spreadsheet_->addSheet($__worksheet__, $_worksheet_index_);
    $__worksheet__->fromArray($_worksheet_['data']);
    foreach ($_worksheet_['data'] as $key => $value) {
      $highestColumn = $__worksheet__->getHighestColumn();
      $__worksheet__->getStyle('A'.($key+1).':' . $highestColumn . ($key+1) )->getAlignment()->setVertical('top');
    }
    $_worksheets_[$_worksheet_index_] = $__worksheet__;

    if ($header) {
      $highestColumn = $__worksheet__->getHighestColumn();
      //set first row bold
      $__worksheet__->getStyle('A1:' . $highestColumn . '1' )->applyFromArray(array(
        'font' => array(
          'bold' => true,
        )
      ));
    }
    if (!empty($_worksheet_['merge_cells'])) {
      foreach ($_worksheet_['merge_cells'] as $merge_cells) {
        $__worksheet__->mergeCells($merge_cells);
      }
    }
    $_worksheet_index_  = $_worksheet_index_ +1;
  }
  foreach ($_worksheets_ as $_worksheet_)
  {
    foreach ($_worksheet_->getColumnIterator() as $column) {
      $_worksheet_->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
    }
  }

  header('Content-Encoding: UTF-8');
  header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
  header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');

  $writer = new Xlsx($_spreadsheet_);
  ob_end_clean();
  $writer->save('php://output');
  exit();
}
