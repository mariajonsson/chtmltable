# chtmltable

A HTML helper to create a html table.  
First version includes the class `SimpleHTMLTable.php` and an example file, `simplehtmltable.php`.

### `createTable($columns, $data)`    
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

Options for `$columns` are:  

'name'  
'label'  
'linkbase'  
'linkkey'  
'display'  
'displayformat'  

It is possible to create links for all cells in a column according to a linkpattern given in 'linkbase' and 'linkkey'. 'linkbase' is a static base url for the links and 'linkkey' can be defined to locate a key in the array or object `$data`.

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
