# chtmltable

A HTML helper written in PHP to create a html table. Written for Anax-MVC.  
First version includes the class `SimpleHTMLTable.php` and an example file, `simplehtmltable.php`.

Move the example file into your Anax installation's webroot folder.

## How to build a table
Method `createTable($columns, $data)`    
Accepts a multiarray `$columns` representing the header row and the columns of the table.  
Accepts a multiarray or object `$data` which represents the rows of the table.  

**Example `$columns`**

    $columns = array([  
    'name' => 'name',   
    'label' => 'Name',     
    ],  
    [  
    'name' => 'id',     
     'label' => 'Id',    
    ]);
  
'name' - a value referring to a key in object or array `$data`   
'label' - the label to place in between the <th></th> tags.

**Example `$data`**  

    $data = array(  
    1 => [   
    'name' => 'Maria',  
    'id' => '1' 
    ],  
    2 => [  
    'name' => 'Anon',  
    'id' => '2'  
    ],  
    );  
    
Will result in a table:


| **Name**|  **Id**  |  
| Maria  |  1   |  
| Anon   |  2   |  


###Creating links for column data

It is possible to create links for all cells in a column according to a linkpattern given in 'linkbase' and 'linkkey'. 'linkbase' is a static base url for the links and 'linkkey' can be defined to locate a key in the array or object `$data`.

**Example**

    $columns = array([
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
  
    $data = array(
      1 => [
      'fruits' => 'Apple', 
      'animals' => 'Horse' 
       ],
      2 => [
      'fruits' => 'Banana', 
      'animals' => 'Monkey' 
       ],
    );
    
    
###Converting column data

With the help of the method `getDisplayVal($val, $displaytype, $format)` it is possible to convert values from the array/object `$data` into another display value. This version supports converting true/false, 1/0, emtpy/not empty into simply "Yes" or "No". It also supports converting a date string into another date format.


    $columns = array([
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
    ],
    );
    
    $data = array(
      1 => [
      'date' => '2015-05-15 12:14', 
      'title' => 'A blog post',
      'published' => true,
       ],
      2 => [
      'date' => '2015-05-16 13:15', 
      'title' => 'Another post',
      'published' => false,
       ],
    );
    
Have a look at the example file simplehtmltable.php to see what creating links and converting data looks like.
