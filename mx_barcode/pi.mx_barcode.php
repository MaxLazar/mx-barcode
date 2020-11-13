<?php
namespace MX\Barcode;

require_once __DIR__.'/vendor/autoload.php';

use Picqer\Barcode\BarcodeGeneratorSVG;
use Picqer\Barcode\BarcodeGeneratorPNG;

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * MX Barcode Plugin class.
 *
 * @author         Max Lazar <max@eec.ms>
 *
 * @see           http://eec.ms/
 *
 * @license        http://opensource.org/licenses/MIT
 */

class Mx_barcode
{
    // --------------------------------------------------------------------
    // PROPERTIES
    // --------------------------------------------------------------------

    /**
     * [$_cache_path description].
     *
     * @var bool
     */
    private $_cache_path = false;

    /**
     * Package name.
     *
     * @var string
     */
    protected $package;

    /**
     * Plugin return data.
     *
     * @var string
     */
    public $return_data;

    /**
     * Plugin return data.
     *
     * @var string
     */
    public $settings = array(
    );

    /**
     * Site id shortcut.
     *
     * @var int
     */
    protected $site_id;

    /**
     *  Barcode types.
     *
     * @var int
     */
    protected $types = [
            'C39' => 'CODE_39',
            'C39+' => 'CODE_39_CHECKSUM',
            'C39E' => 'CODE_39E',
            'C39E+' => 'CODE_39E_CHECKSUM',
            'C93' => 'CODE_93',
            'S25' => 'STANDARD_2_5',
            'S25+' => 'STANDARD_2_5_CHECKSUM',
            'I25' => 'INTERLEAVED_2_5',
            'I25+' => 'INTERLEAVED_2_5_CHECKSUM',
            'C128' => 'CODE_128',
            'C128A' => 'CODE_128_A',
            'C128B' => 'CODE_128_B',
            'C128C' => 'CODE_128_C',
            'EAN2' => 'EAN_2',
            'EAN5' => 'EAN_5',
            'EAN8' => 'EAN_8',
            'EAN13' => 'EAN_13',
            'UPCA' => 'UPC_A',
            'UPCE' => 'UPC_E',
            'MSI' => 'MSI',
            'MSI+' => 'MSI_CHECKSUM',
            'POSTNET' => 'POSTNET',
            'PLANET' => 'PLANET',
            'RMS4CC' => 'RMS4CC',
            'KIX' => 'KIX',
            'IMB' => 'IMB',
            'CODABAR' => 'CODABAR',
            'CODE11' => 'CODE_11',
            'PHARMA' => 'PHARMA_CODE',
            'PHARMA2T' => 'PHARMA_CODE_TWO_TRACKS',
    ];

    // --------------------------------------------------------------------
    // METHODS
    // --------------------------------------------------------------------

    /**
     * Constructor.
     *
     * @return string
     */
    public function __construct()
    {
        $this->_cache_path = (!$this->_cache_path) ? str_replace('\\', '/', PATH_CACHE).'/mx_barcode' : false;
        $this->package = basename(__DIR__);
        $this->info = ee('App')->get($this->package);
        $data['base64_encode'] = ee()->TMPL->fetch_param('base64_encode', 'yes');
        $data['type'] = ee()->TMPL->fetch_param('type', 'C128');
        $data['format'] = ee()->TMPL->fetch_param('format', 'png');
        $data['data'] = (!ee()->TMPL->fetch_param('data')) ? ee()->TMPL->tagdata : str_replace(SLASH, '/', ee()->TMPL->fetch_param('data'));
        $data['color'] = ee()->TMPL->fetch_param('color', '#000000');
        $data['width'] = ee()->TMPL->fetch_param('width', '2');
        $data['height'] = ee()->TMPL->fetch_param('height', '30');
        $data['filename'] = ee()->TMPL->fetch_param('filename', false);

        return $this->return_data = $this->doBarcode($data);
    }

    public function doBarcode($data)
    {
        $output = '';
        $base_path = (!ee()->TMPL->fetch_param('base_path')) ? $_SERVER['DOCUMENT_ROOT'].'/' : ee()->TMPL->fetch_param('base_path');
        $base_path = str_replace('\\', '/', $base_path);
        $base_path = reduce_double_slashes($base_path);
        $cache = (!ee()->TMPL->fetch_param('cache')) ? '' : ee()->TMPL->fetch_param('cache');

        $base_cache = reduce_double_slashes($base_path.'images/cache/');
        $base_cache = (!ee()->TMPL->fetch_param('base_cache')) ? $base_cache : ee()->TMPL->fetch_param('base_cache');
        $base_cache = reduce_double_slashes($base_cache);

        if (!is_dir($base_cache)) {
            // make the directory if we can
            if (!mkdir($base_cache, 0777, true)) {
                ee()->TMPL->log_item('Error: could not create cache directory '.$base_cache.' with 777 permissions');

                return ee()->TMPL->no_results();
            }
        }

        $file_ext = 'png' == $data['format'] ? '.png' : '.svg';
        $file_name = $data['filename'] ? $data['filename'] : md5(serialize($data));
        $file_name = $file_name.$file_ext;

        if ('png' == $data['format']) {
            $generator = new BarcodeGeneratorPNG();
            $data['color'] = sscanf($data['color'], '#%02x%02x%02x');
        }

        if ('svg' == $data['format']) {
            $generator = new BarcodeGeneratorSVG();
        }

        $output = $generator->getBarcode($data['data'], $data['type'], $data['width'], $data['height'], $data['color']);

        if ('yes' == $data['base64_encode']) {
            $output = ('png' == $data['format'] ? 'data:image/png;base64, ' : 'data:image/svg+xml;base64, ').base64_encode($output);
        } else {
            @file_put_contents($base_cache.$file_name, $output);
            $output = reduce_double_slashes('/'.str_replace($base_path, '', $base_cache.$file_name));
        }

        return $output;
    }

    /**
     * Simple method to log a debug message to the EE Debug console.
     *
     * @param string $method
     * @param string $message
     */
    protected function logDebugMessage($method = '', $message = '')
    {
        ee()->TMPL->log_item('&nbsp;&nbsp;***&nbsp;&nbsp;'.$this->package." - $method debug: ".$message);
    }

    // ----------------------------------------
    //  Plugin Usage
    // ----------------------------------------

    // This function describes how the plugin is used.
    //  Make sure and use output buffering

    public static function usage()
    {
        // for performance only load README if inside control panel
        return REQ === 'CP' ? file_get_contents(dirname(__FILE__).'/README.md') : null;
    }
}
// END CLASS

/* End of file pi.mx_barcode.php */
