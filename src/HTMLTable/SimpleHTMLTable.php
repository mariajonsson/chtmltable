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

    public function createTable($columns, $values=null, $tablename=null) {
    	
    $html = "<table id='".$tablename."'>";
    $html .= "<tr>";
    
    foreach ($columns as $column) {
    	$html .= "<th>".$column['label']."</th>";
    }
    $html .= "</tr>";
    
    if (!empty($values)) {
    foreach ($values as $value) {
    $html .= "<tr>";
    
    	foreach ($columns as $column) {
    		$linkkey = null;
    		$val = '';
    		if (is_object($value)) {
		  if(isset($value->{$column['name']})) {
		    $val = $value->{$column['name']};
		  }
		  else $val = '';
    		if (isset($column['linkkey'])) {
		  if (isset($value->{$column['linkkey']})) {
		  $linkkey = $value->{$column['linkkey']};
		  }
    		}
    		}
    		elseif (is_array($value)) {
    		
		if(isset($value[$column['name']])) {
		  $val = $value[$column['name']];
    		}
    		else $val = '';
    		if (isset($column['linkkey'])) {
		  $linkkey = $value[$column['linkkey']];
    		}
    		}
    		if (isset($column['display']) && isset($column['displayformat'])) {
    		$val = $this->getDisplayVal($val, $column['display'], $column['displayformat']);
    		}
    		elseif (isset($column['display'])) {
    		$val = $this->getDisplayVal($val, $column['display']);
    		}
    		
    		$link = (isset($column['linkbase'])) ? '<a href="' .$column['linkbase'].$linkkey.'">' : null;
    		$endlink = !empty($link) ? "</a>" : null;
    		
    		$html .= "<td>".$link.$val.$endlink."</td>";
    		
    	}
    
    $html .= "</tr>";
     
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
    * @param string $format which format to convert to, if any
    */
	
  public function getDisplayVal($val, $displaytype=null, $format=null) {
  	  	
  	switch ($displaytype) {
  	  
	case 'yes-no':
	    if ($val === false || $val === 0) {
  	    $displayval = "No";
  	}
  	  elseif (empty($val) || $val === null) {
	    $displayval = "No";
  	  }

  	  else $displayval = "Yes";
  	  break;
  	  	  
  	  case 'convert-datestr':
	    if (isset($format)) {
	      $displayval = date($format, strtotime($val));
  	    }
  	    else $displayval = $val;
  	    break;
  	  
  	  default:
  	  
	    $displayval = $val;
	    break;
	    
  	  }
  	  return $displayval;
  }
  
  


  
}