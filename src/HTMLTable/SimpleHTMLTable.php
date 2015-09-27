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
     * 
     */

  public function createTable($columns, $values = null, $tablename = null) {

    $html = "<table id='".$tablename."'>";
    $html .= "<tr>";
    
    foreach ($columns as $column) {
      $html .= "<th>".$column['label']."</th>";
    }
    $html .= "</tr>";
    
    $html .= $this->createRows($columns, $values);
    
    $html .= "</table>";
    return $html;
  }
  
    /**
     * Support for converting values 
     *
     * @param $val the value to convert
     * @param string $displaytype determines which switch case to go with
     * @param string $format which format to convert to, if any
     */
	
  public function getDisplayVal($val, $displaytype = null, $format = null) {
  
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
  
  
  public function createRows($columns, $values) 
  {
  $html = '';
  if (!empty($values)) 
  {
    foreach ($values as $value) {
      $html .= "<tr>";
      foreach ($columns as $column) {
      $link = null;
      $val='';
	if (is_object($value)) {
	  $value = get_object_vars($value);
	}
	if(isset($value[$column['name']])) {
	    $val = $value[$column['name']];	  
	}
	$link = $this->createLink($value, $column);
    
	if (isset($column['display'])) {
	  $displayformat = isset($column['displayformat']) ? $column['displayformat'] : null;
	  $val = $this->getDisplayVal($val, $column['display'], $displayformat);
	}
	$endlink = !empty($link) ? "</a>" : null;
	$html .= "<td>".$link.$val.$endlink."</td>";
      } 
      $html .= "</tr>"; 
    }
  }
  return $html;
  }
  
  public function createLink($value, $column) 
  {
  $link = null;
  if (isset($column['linkbase'])) {

    $linkkey = $this->getLinkkey($value, $column);
    $link = '<a href="' .$column['linkbase'].$linkkey.'">';
  }
  return $link;
  
  }
  
  public function getLinkkey($value, $column) 
  {
  $linkkey = null;
      if (isset($column['linkkey'])) {
	if (isset($value[$column['linkkey']])) {
	  $linkkey = $value[$column['linkkey']];
	}
      }
  return $linkkey;
  
  }
 
}