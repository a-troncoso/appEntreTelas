<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2013 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel_Reader
 * @copyright  Copyright (c) 2006 - 2013 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.9, 2013-06-02
 */


/** PHPExcel root directory */
if (!defined('PHPEXCEL_ROOT')) {
	/**
	 * @ignore
	 */
	define('PHPEXCEL_ROOT', dirname(__FILE__) . '/../../');
	require(PHPEXCEL_ROOT . 'PHPExcel/Autoloader.php');
}

/**
 * PHPExcel_Reader_Excel2003XML
 *
 * @category   PHPExcel
 * @package    PHPExcel_Reader
 * @copyright  Copyright (c) 2006 - 2013 PHPExcel (http://www.codeplex.com/PHPExcel)
 */
class PHPExcel_Reader_Excel2003XML extends PHPExcel_Reader_Abstract implements PHPExcel_Reader_IReader
{
	/**
	 * Formats
	 *
	 * @var array
	 */
	private $_styles = array();

	/**
	 * Character set used in the file
	 *
	 * @var string
	 */
	private $_charSet = 'UTF-8';


	/**
	 * Create a new PHPExcel_Reader_Excel2003XML
	 */
	public function __construct() {
		$this->_readFilter 	= new PHPExcel_Reader_DefaultReadFilter();
	}


	/**
	 * Can the current PHPExcel_Reader_IReader read the file?
	 *
	 * @param 	string 		$pFilename
	 * @return 	boolean
	 * @throws PHPExcel_Reader_Exception
	 */
	public function canRead($pFilename)
	{

		//	Office					xmlns:o="urn:schemas-microsoft-com:office:office"
		//	Excel					xmlns:x="urn:schemas-microsoft-com:office:excel"
		//	XML Spreadsheet			xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet"
		//	Spreadsheet component	xmlns:c="urn:schemas-microsoft-com:office:component:spreadsheet"
		//	XML schema 				xmlns:s="uuid:BDC6E3F0-6DA3-11d1-A2A3-00AA00C14882"
		//	XML data type			xmlns:dt="uuid:C2F41010-65B3-11d1-A29F-00AA00C14882"
		//	MS-persist recordset	xmlns:rs="urn:schemas-microsoft-com:rowset"
		//	Rowset					xmlns:z="#RowsetSchema"
		//

		$signature = array(
				'<?xml version="1.0"',
				'<?mso-application progid="Excel.Sheet"?>'
			);

		// Open file
		$this->_openFile($pFilename);
		$fileHandle = $this->_fileHandle;
		
		// Read sample data (first 2 KB will do)
		$data = fread($fileHandle, 2048);
		fclose($fileHandle);

		$valid = true;
		foreach($signature as $match) {
			// every part of the signature must be present
			if (strpos($data, $match) === false) {
				$valid = false;
				break;
			}
		}

		//	Retrieve charset encoding
		if(preg_match('/<?xml.*encoding=[\'"](.*?)[\'"].*?>/um',$data,$matches)) {
			$this->_charSet = strtoupper($matches[1]);
		}
//		echo 'Character Set is ',$this->_charSet,'<br />';

		return $valid;
	}


	/**
	 * Reads names of the worksheets from a file, without parsing the whole file to a PHPExcel object
	 *
	 * @param 	string 		$pFilename
	 * @throws 	PHPExcel_Reader_Exception
	 */
	public function listWorksheetNames($pFilename)
	{
		// Check if file exists
		if (!file_exists($pFilename)) {
			throw new PHPExcel_Reader_Exception("Could not open " . $pFilename . " for reading! File does not exist.");
		}
		if (!$this->canRead($pFilename)) {
			throw new PHPExcel_Reader_Exception($pFilename . " is an Invalid Spreadsheet file.");
		}

		$worksheetNames = array();

		$xml = simplexml_load_file($pFilename);
		$namespaces = $xml->getNamespaces(true);

		$xml_ss = $xml->children($namespaces['ss']);
		foreach($xml_ss->Worksheet as $worksheet) {
			$worksheet_ss = $worksheet->attributes($namespaces['ss']);
			$worksheetNames[] = self::_convertStringEncoding((string) $worksheet_ss['Name'],$this->_charSet);
		}

		return $worksheetNames;
	}


	/**
	 * Return worksheet info (Name, Last Column Letter, Last Column Index, Total Rows, Total Columns)
	 *
	 * @param   string     $pFilename
	 * @throws   PHPExcel_Reader_Exception
	 */
	public function listWorksheetInfo($pFilename)
	{
		// Check if file exists
		if (!file_exists($pFilename)) {
			throw new PHPExcel_Reader_Exception("Could not open " . $pFilename . " for reading! File does not exist.");
		}

		$worksheetInfo = array();

		$xml = simplexml_load_file($pFilename);
		$namespaces = $xml->getNamespaces(true);

		$worksheetID = 1;
		$xml_ss = $xml->children($namespaces['ss']);
		foreach($xml_ss->Worksheet as $worksheet) {
			$worksheet_ss = $worksheet->attributes($namespaces['ss']);

			$tmpInfo = array();
			$tmpInfo['worksheetName'] = '';
			$tmpInfo['lastColumnLetter'] = 'A';
			$tmpInfo['lastColumnIndex'] = 0;
			$tmpInfo['totalRows'] = 0;
			$tmpInfo['totalColumns'] = 0;

			if (isset($worksheet_ss['Name'])) {
				$tmpInfo['worksheetName'] = (string) $worksheet_ss['Name'];
			} else {
				$tmpInfo['worksheetName'] = "Worksheet_{$worksheetID}";
			}

			if (isset($worksheet->Table->Row)) {
				$rowIndex = 0;

				foreach($worksheet->Table->Row as $rowData) {
					$columnIndex = 0;
					$rowHasData = false;

					foreach($rowData->Cell as $cell) {
						if (isset($cell->Data)) {
							$tmpInfo['lastColumnIndex'] = max($tmpInfo['lastColumnIndex'], $columnIndex);
							$rowHasData = true;
						}

						++$columnIndex;
					}

					++$rowIndex;

					if ($rowHasData) {
						$tmpInfo['totalRows'] = max($tmpInfo['totalRows'], $rowIndex);
					}
				}
			}

			$tmpInfo['lastColumnLetter'] = PHPExcel_Cell::stringFromColumnIndex($tmpInfo['lastColumnIndex']);
			$tmpInfo['totalColumns'] = $tmpInfo['lastColumnIndex'] + 1;

			$worksheetInfo[] = $tmpInfo;
			++$worksheetID;
		}

		return $worksheetInfo;
	}


    /**
	 * Loads PHPExcel from file
	 *
	 * @param 	string 		$pFilename
	 * @return 	PHPExcel
	 * @throws 	PHPExcel_Reader_Exception
	 */
	public function load($pFilename)
	{
		// Create new PHPExcel
		$objPHPExcel = new PHPExcel();

		// Load into this instance
		return $this->loadIntoExisting($pFilename, $objPHPExcel);
	}


	private static function identifyFixedStyleValue($styleList,&$styleAttributeValue) {
		$styleAttributeValue = strtolower($styleAttributeValue);
		foreach($styleList as $style) {
			if ($styleAttributeValue == strtolower($style)) {
				$styleAttributeValue = $style;
				return true;
			}
		}
		return false;
	}


 	/**
 	 * pixel units to excel width units(units of 1/256th of a character width)
 	 * @param pxs
 	 * @return
 	 */
 	private static function _pixel2WidthUnits($pxs) {
		$UNIT_OFFSET_MAP = array(0, 36, 73, 109, 146, 182, 219);

		$widthUnits = 256 * ($pxs / 7);
		$widthUnits += $UNIT_OFFSET_MAP[($pxs % 7)];
		return $widthUnits;
	}


	/**
	 * excel width units(units of 1/256th of a character width) to pixel units
	 * @param widthUnits
	 * @return
	 */
	private static function _widthUnits2Pixel($widthUnits) {
		$pixels = ($widthUnits / 256) * 7;
		$offsetWidthUnits = $widthUnits % 256;
		$pixels += round($offsetWidthUnits / (256 / 7));
		return $pixels;
	}


	private static function _hex2str($hex) {
		return chr(hexdec($hex[1]));
	}


	/**
	 * Loads PHPExcel from file into PHPExcel instance
	 *
	 * @param 	string 		$pFilename
	 * @param	PHPExcel	$objPHPExcel
	 * @return 	PHPExcel
	 * @throws 	PHPExcel_Reader_Exception
	 */
	public function loadIntoExisting($pFilename, PHPExcel $objPHPExcel)
	{
		$fromFormats	= array('\-',	'\ ');
		$toFormats		= array('-',	' ');

		$underlineStyles = array (
				PHPExcel_Style_Font::UNDERLINE_NONE,
				PHPExcel_Style_Font::UNDERLINE_DOUBLE,
				PHPExcel_Style_Font::UNDERLINE_DOUBLEACCOUNTING,
				PHPExcel_Style_Font::UNDERLINE_SINGLE,
				PHPExcel_Style_Font::UNDERLINE_SINGLEACCOUNTING
			);
		$verticalAlignmentStyles = array (
				PHPExcel