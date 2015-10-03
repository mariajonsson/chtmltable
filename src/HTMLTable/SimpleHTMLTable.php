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
     * @param string $tablename - a css id for the html table
     * @param array $values containing the data
     * @return string
     */

  public function createTable($columns, $values = [], $tablename = '') {

    $html = "<table id='".$tablename."'>";
    
    $html .= $this->createHeader($columns);
    
    $html .= $this->createRows($columns, $values);
   
    $html .= "</table>";
    return $html;
  }
  
    /**
     * Support for converting values 
     *
     * @param mixed $val the value to convert
     * @param string $displaytype determines which switch case to go with
     * @param string $format which format to convert to, if any
     * @return string
     */
	
  public function getDisplayVal($val, $displaytype = null, $format = null) {
  
   
  switch ($displaytype) {
    

    case 'yes-no':
      $displayval = $this->getDisplayYesNoType($val);
      break;
    case 'convert-datestr':
      $displayval = $this->getDisplayDatestrType($val, $format);
      break;
  
    default:
      $displayval = $val;
    break;
  }
  return $displayval;
  }
  
  /**
   * Get displayformat 
   *
   * @param array $column containing column info
   *
   * @return string
   */

  public function getDisplayFormat($column) 
  {
  $format = null;
  if (isset($column['displayformat'])) 
  {
    $format = $column['displayformat'];
  }
  return $format;
  }
  
  /**
   * Get displayvalue of type yes or no 
   *
   * @param mixed $val the value to modify
   *
   * @return string
   */
  
  public function getDisplayYesNoType($val)
  {
  if (empty($val)) {
        $displayval = "No";
      } else { 
        $displayval = "Yes";
      }
      
    return $displayval;
  }
  
  /**
   * Get displayvalue of type date string 
   *
   * @param mixed $val the value to modify
   * @param string $format the format to convert string into
   *
   * @return string
   */
  public function getDisplayDatestrType($val, $format)
  {
  if (isset($format)) {
        $displayval = date($format, strtotime($val));
      } else {
        $displayval = $val;
      }
  return $displayval;
  }
  
  
  /**
   * Creating a header row 
   *
   * @param array $columns containing column info
   *
   * @return string
   */
  public function createHeader($columns)
  {
  $html = "<tr>";

    
    foreach ($columns as $column) {
      $html .= "<th>".$column['label']."</th>";
    }
    $html .= "</tr>";
  return $html;  
  }
  
  /**
   * Creating rows 
   *
   * @param array $columns containing column info
   * @param array $values data to go into the row
   * @return string
   */
  
  public function createRows($columns, $values)
  {
    $html = '';
    if (!empty($values)) 
    {
    foreach ($values as $value) {
      
      if (is_object($value)) {
  $value = get_object_vars($value);
      }
      
      $html .= $this->createRow($columns, $value);
    }
    }
    return $html;
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
      $format = $this->getDisplayFormat($column);
      $val = $this->getDisplayVal($val, $column['display'], $format);
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
    $link = '<a href="'.$column['linkbase'].$linkkey.'">'.$text.'</a>';
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
     * @param array $column containing column info
     * @param array $value data to go into the row
     * 
     * @return string 
     */
  
  public function getValue($value, $column)
  {
  $val = '';
    if (isset($value[$column['name']])) {
      $val = $value[$column['name']];
    }
  return $val;
  }
 
}