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
      $val='';
	if (is_object($value)) {
	  if(isset($value->{$column['name']})) {
	    $val = $value->{$column['name']};
	  }
	}
	elseif (is_array($value)) {
	  if(isset($value[$column['name']])) {
	    $val = $value[$column['name']];
	  }
	}
	$link = $this->createLink($value, $column);
      

	$display = isset($column['display']) ? $column['display'] : null;
	$displayformat = isset($column['displayformat']) ? $column['displayformat'] : null;
	$val = $this->getDisplayVal($val, $display, $displayformat);
	
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
    $linkkey = null;
    if (is_object($value)) {
      if (isset($column['linkkey'])) {
	if (isset($value->{$column['linkkey']})) {
	  $linkkey = $value->{$column['linkkey']};
	}
      }
    }
    elseif (is_array($value)) {
      if (isset($column['linkkey'])) {
	if (isset($value[$column['linkkey']])) {
	  $linkkey = $value[$column['linkkey']];
	}
      }
    }
    $link = '<a href="' .$column['linkbase'].$linkkey.'">';
  }
  return $link;
  
  }
 
}