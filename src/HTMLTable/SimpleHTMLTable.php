<?php

namespace Meax\HTMLTable;

class SimpleHTMLTable {

  /**
   * Creates an HTML table from an array or object.
   *
   */
  
  public function __construct() {
  }

    /**
     * Build an html table
     *
     * @param array $columns containing label and corresponding name
     * @param array $values or @param object $values containing the data
     * @return string
     */

  public function createTable($columns, $values = null, $tablename = null) {

    $html = "<table id='".$tablename."'>";
    $html .= "<tr>";
    
    foreach ($columns as $column) {
      $html .= "<th>".$column['label']."</th>";
    }
    $html .= "</tr>";
    if (!empty($values)) 
    {
    foreach ($values as $value) {
      if (is_object($value)) {
	$value = get_object_vars($value);
      }
      $html .= $this->createRow($columns, $value);
    }
    }
    $html .= "</table>";
    return $html;
  }
  
    /**
     * Support for converting values 
     *
     * @param $val the value to convert
     * @param string $displaytype determines which switch case to go with
     * @param string $displayformat which format to convert to, if any
     * @return string
     */
	
  public function getDisplayVal($val, $displaytype = null, $displayformat = null, $column = null) {
  
  $format = isset($column['displayformat']) ? $column['displayformat'] : $displayformat;
  
  switch ($displaytype) {
    
    case 'yes-no':
      if ($val === false || $val === 0 || empty($val) || $val === null) {
        $displayval = "No";
      }
      else { 
        $displayval = "Yes";
      }
      break;
    case 'convert-datestr':
      if (isset($format)) {
        $displayval = date($format, strtotime($val));
      }
      else {
        $displayval = $val;
      }
      break;
  
    default:
      $displayval = $val;
    break;
  }
  return $displayval;
  }
  
  /**
     * Creating a row 
     *
     * @param array $columns containing column info
     * @param array $value data to go into the row
     * @return string
     */
  
  public function createRow($columns, $value) 
  {
  $html = "<tr>";
  foreach ($columns as $column) {
    $val = $this->getValue($value, $column);
	if (isset($column['display'])) {
	  $val = $this->getDisplayVal($val, $column['display'], null, $column);
	}
	
	$link = $this->createLink($value, $column, $val);

	$html .= "<td>".$link."</td>";
      } 
      $html .= "</tr>"; 
  return $html;
  }
  
  /**
     * Creating a link
     *
     * @param array $column containing column info
     * @param array $value data to go into the row
     * @param string $text the text for the link
     * @return string
     */
  
  public function createLink($value, $column, $text) 
  {
  $link = $text;
  if (isset($column['linkbase'])) 
  {
    $linkkey = $this->getLinkkey($value, $column);
    $link = '<a href="' .$column['linkbase'].$linkkey.'">'.$text.'</a>';
  }
  return $link;
  
  }
  
  /**
     * Get the link key to create the link
     *
     * @param array $column containing column info
     * @param array $row data to go into the row
     * 
     * @return string 
     */
  
  public function getLinkkey($row, $column) 
  {
  $linkkey = null;
      if (isset($column['linkkey'])) {
	if (isset($row[$column['linkkey']])) {
	  $linkkey = $row[$column['linkkey']];
	}
      }
  return $linkkey;
  
  }
  
   /**
     * Get the raw value to display
     *
     * @param array $columns containing column info
     * @param array $value data to go into the row
     * 
     * @return string 
     */
  
  public function getValue($value, $column)
  {
  $val='';
    if(isset($value[$column['name']])) {
      $val = $value[$column['name']];
    }
  return $val;
  }
 
}