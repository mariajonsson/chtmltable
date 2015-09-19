<?php 
/**
 * This is a Anax pagecontroller.
 *
 */

// Get environment & autoloader and the $app-object.
require __DIR__.'/config_with_app.php'; 


// $app->url->setUrlType(\Anax\Url\CUrl::URL_CLEAN); 

$app->theme->configure(ANAX_APP_PATH . 'config/theme-grid.php');
//$app->navbar->configure(ANAX_APP_PATH . 'config/navbar_theme.php');

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
 
    $app->theme->setTitle("Simple HTMLTable");
 
    $app->views->add('default/page', [
        'title' => "SimpleHTMLTable example",
        'content' => "<p>SimpleHTMLTable is a module that helps create simple html tables.</p>" . $html
    ]);
    
});

 
$app->router->handle();
$app->theme->render();
