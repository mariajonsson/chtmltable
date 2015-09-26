<?php

namespace Meax\HTMLTable;

  /**
   * Creates an HTML table from an array or object.
   *
   */
class SimpleHTMLTableTest extends \PHPUnit_Framework_TestCase
{



  public function setUp() 
  {
  $this->tbl = new \Meax\HTMLTable\SimpleHTMLTable();
  $this->twocolumns = array([ 
    'name' => 'fruits', 
    'label' => 'Fruits'
    ], 
    [
    'name' => 'animals', 
    'label' => 'Animals'
    ]);
    $this->twocolslinks = array([
      'name' => 'fruits',
      'label' => 'Fruits',
      
    ],
    [
      'name' => 'animals',
      'label' => 'Animals',
      'linkbase' => 'https://en.wikipedia.org/wiki/',
      'linkkey' => 'animals',
      
    ],
    );
  $this->valtwocols = array([
    'fruits' => 'Apple', 
    'animals' => 'Horse'
    ], 
    [
    'fruits' => 'Banana', 
    'animals' => 'Monkey'
    ]);
    $this->valtwocolsMissingval = array([
    'fruits' => 'Apple', 
    'animals' => 'Horse'
    ], 
    [
    'animals' => 'Monkey'
    ]);
    $this->twocolsDisplay = array([
      'name' => 'date',
      'label' => 'Date',
      'display' => 'convert-datestr',
      'displayformat' => 'Y-m-d',
    ],
    [
      'name' => 'title',
      'label' => 'Title',
            
    ],
    [
      'name' => 'published',
      'label' => 'Published',
      'display' => 'yes-no',     
    ]);
    $this->valtwocolsDisplay = array(
      [
      'date' => '2015-05-15 12:14', 
      'title' => 'A blog post',
      'published' => true,
        ],
      [
      'date' => '2015-05-16 13:15', 
      'title' => 'Another post',
      'published' => false,
        ],
    );
    
    $object1 = new \stdClass();
    $object1->fruits = 'Apple';
    $object1->animals = 'Horse';
    
    $object2 = new \stdClass();
    $object2->fruits = 'Banana';
    $object2->animals = 'Monkey';
    
    $object3 = new \stdClass();
    $object3->animals = 'Monkey';
    
    $this->valtwocolsObject = array($object1, $object2);
    $this->valtwocolsObjectmissing = array($object1, $object3);
   
 
  }
 

  
  /**
   * Test table headers with column data
   *
   * @return void
   *
   */
  public function testCreateTable_thtd()
  {
  
  //Test just headers
  $table = $this->tbl->createTable($this->twocolumns, null, "tablename");
  $this->assertEquals($table, "<table id='tablename'><tr><th>Fruits</th><th>Animals</th></tr></table>");  
 
  //Test headers and column data
  $table = $this->tbl->createTable($this->twocolumns, $this->valtwocols);
  $this->assertEquals($table, "<table id=''><tr><th>Fruits</th><th>Animals</th></tr><tr><td>Apple</td><td>Horse</td></tr><tr><td>Banana</td><td>Monkey</td></tr></table>");
  
  //Test table with links, insert array
  $table = $this->tbl->createTable($this->twocolslinks, $this->valtwocols);
  $this->assertEquals($table, '<table id=\'\'><tr><th>Fruits</th><th>Animals</th></tr><tr><td>Apple</td><td><a href="https://en.wikipedia.org/wiki/Horse">Horse</a></td></tr><tr><td>Banana</td><td><a href="https://en.wikipedia.org/wiki/Monkey">Monkey</a></td></tr></table>');
  
  //Test table with links, insert object
  $table = $this->tbl->createTable($this->twocolslinks, $this->valtwocolsObject);
  $this->assertEquals($table, '<table id=\'\'><tr><th>Fruits</th><th>Animals</th></tr><tr><td>Apple</td><td><a href="https://en.wikipedia.org/wiki/Horse">Horse</a></td></tr><tr><td>Banana</td><td><a href="https://en.wikipedia.org/wiki/Monkey">Monkey</a></td></tr></table>');
  
  //Test table with links, insert object with missing value
  $table = $this->tbl->createTable($this->twocolslinks, $this->valtwocolsObjectmissing);
  $this->assertEquals($table, '<table id=\'\'><tr><th>Fruits</th><th>Animals</th></tr><tr><td>Apple</td><td><a href="https://en.wikipedia.org/wiki/Horse">Horse</a></td></tr><tr><td></td><td><a href="https://en.wikipedia.org/wiki/Monkey">Monkey</a></td></tr></table>');
  
  //Test a table where some data is missing
  $table = $this->tbl->createTable($this->twocolumns, $this->valtwocolsMissingval);
  $this->assertEquals($table, "<table id=''><tr><th>Fruits</th><th>Animals</th></tr><tr><td>Apple</td><td>Horse</td></tr><tr><td></td><td>Monkey</td></tr></table>");
  
  //Test a table with display
  $table = $this->tbl->createTable($this->twocolsDisplay, $this->valtwocolsDisplay);
  $this->assertEquals($table, "<table id=''><tr><th>Date</th><th>Title</th><th>Published</th></tr><tr><td>2015-05-15</td><td>A blog post</td><td>Yes</td></tr><tr><td>2015-05-16</td><td>Another post</td><td>No</td></tr></table>");
  
  }
  
    /**
     * Test case default for DisplayVal
     *
     * @return void
     *
     */
  
  public function testGetDisplayVal() 
  {
  
    $display = $this->tbl->getDisplayVal('Hello');
    $this->assertEquals($display, 'Hello');
  
  }
  
  /**
   * Test case 'yes-no' for DisplayVal with result "Yes"
   *
   * @return void
   *
   */
  
  public function testGetDisplayVal_yn_yes() 
  {
  
    $display = $this->tbl->getDisplayVal(true, 'yes-no');
    $this->assertEquals($display, 'Yes');
    $display = $this->tbl->getDisplayVal('Yes', 'yes-no');
    $this->assertEquals($display, 'Yes');
    $display = $this->tbl->getDisplayVal(1, 'yes-no');
    $this->assertEquals($display, 'Yes');
  
  }
  
/**
 * Test case 'yes-no' for DisplayVal with result "No"
 *
 * @return void
 *
 */
  
    public function testGetDisplayVal_yn_no() 
  {
  
    $display = $this->tbl->getDisplayVal(false, 'yes-no');
    $this->assertEquals( $display, 'No');
    $display = $this->tbl->getDisplayVal(null, 'yes-no');
    $this->assertEquals( $display, 'No');
      $display = $this->tbl->getDisplayVal(0, 'yes-no');
    $this->assertEquals( $display, 'No');
    $display = $this->tbl->getDisplayVal('', 'yes-no');
    $this->assertEquals( $display, 'No');
  
  }
  
  /**
   * Test case 'convert-datestr' for DisplayVal
   *
   * @return void
   *
   */
  
  public function testGetDisplayVal_convertdatestr() 
  {
  
    $display = $this->tbl->getDisplayVal('2015-05-15', 'convert-datestr', 'Y-m-d H:i');
    $this->assertEquals($display, '2015-05-15 00:00');
  
    $display = $this->tbl->getDisplayVal('2015-05-15', 'convert-datestr');
    $this->assertEquals($display, '2015-05-15');
  }
  
  }