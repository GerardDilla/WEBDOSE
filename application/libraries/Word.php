<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('PhpWord/PhpWord.php');
// require_once('PhpWord/Settings.php');
// require_once('PhpWord/Media.php');
// require_once('PhpWord/Style.php');
// require_once('PhpWord/Collection/Bookmarks.php');
// require_once('PhpWord/Collection/AbstractCollection.php');
// require_once APPPATH.'/libraries/PhpWord/PhpWord.php';
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Settings;
class Word extends PhpWord
{
 public function __construct()
 {
  parent::__construct();
 }
}

?>
