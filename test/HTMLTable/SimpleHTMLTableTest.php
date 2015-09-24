<?php

namespace Meax\HTMLTable;

 /**
  * Creates an HTML table from an array or object.
  *
  */

class SimpleHTMLTableTest extends \PHPUnit_Framework_TestCase
{

 
  /**
 * Test 
 *
 * @return void
 *
 */
  public function testCreateTable_th()
  {
  
  $tbl = new \Meax\HTMLTable\SimpleHTMLTable('test');
  
  $table = $tbl->createTable(array([ 'name' => 'fruits', 'label' => 'Fruits'], ['name' => 'animals', 'label' => 'Animals']),null,"tablename");
  $this->assertEquals( $table, "<table id='tablename'><tr><th>Fruits</th><th>Animals</th></tr></table>" );
  
 
  
  }
  public function testCreateTable_thtd()
  {
  
  $tbl = new \Meax\HTMLTable\SimpleHTMLTable('test');
  
  $table = $tbl->createTable(array([ 'name' => 'fruits', 'label' => 'Fruits'], ['name' => 'animals', 'label' => 'Animals']), array(['fruits' => 'Apple', 'animals' => 'Horse'], ['fruits' => 'Banana', 'animals' => 'Monkey']));
  $this->assertEquals( $table, "<table id=''><tr><th>Fruits</th><th>Animals</th></tr><tr><td>Apple</td><td>Horse</td></tr><tr><td>Banana</td><td>Monkey</td></tr></table>" );
  
  }
  
  }