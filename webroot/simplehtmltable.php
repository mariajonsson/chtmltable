<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 


$di->set('table', '\Meax\HTMLTable\SimpleHTMLTable');


$app->router->add('', function() use ($app) {

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
      $columns[0]['name'] => 'Apple', 
      $columns[1]['name'] => 'Horse' 
       ],
      2 => [
      $columns[0]['name'] => 'Banana', 
      $columns[1]['name'] => 'Monkey' 
       ],
    );

    $html = $app->table->createTable($columns, $data);
    
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
    
    $html2 = $app->table->createTable($columns, $data);
 
    $app->theme->setTitle("Simple HTMLTable");
 
    $app->views->add('default/page', [
        'title' => "SimpleHTMLTable example",
        'content' => "<p>SimpleHTMLTable is a module that helps create simple html tables.</p><h4>Example 1</h4>" . $html ."<h4>Example 2</h4>". $html2
    ]);
    
});

 
$app->router->handle();
$app->theme->render();
