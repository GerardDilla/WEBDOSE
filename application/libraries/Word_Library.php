<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
// require_once APPPATH.'\third_party\PhpWord\PhpWord.php';

// require_once('PhpWord.php');
// require_once('PhpWord/Settings.php');
// require_once('PhpWord/Media.php');
// require_once('PhpWord/Style.php');
// require_once('PhpWord/Collection/Bookmarks.php');
// require_once('vendor/autoload.php');
// require_once APPPATH.'/libraries/PhpWord/PhpWord.php';
// use PhpOffice\PhpWord\Autoloader as Autoloader;
// require_once('vendor/Autoload.php');
// use PhpOffice\PhpWord\Media;
// use PhpOffice\PhpWord\Autoloader as Autoloader;
// use PhpOffice\PhpWord\Settings as Settings;
// use PhpOffice\PhpWord\PhpWord as PhpWord;

require_once  APPPATH . '/third_party/PhpWord/Autoloader.php';
use PhpOffice\PhpWord\Autoloader;
use PhpOffice\PhpWord\Settings;
Autoloader::register();
Settings::loadConfig();
class Word_Library extends Autoloader
{
    public function __construct()
    {
        // parent::__construct();
    }
}
