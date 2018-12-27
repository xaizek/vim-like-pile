<?php

class Template
{
    private $vars = array();
    private $templatesPath = __DIR__ . '/templates';

    public function __construct($template) {
        $this->template = $template;
    }

    public function __get($name) {
        return $this->vars[$name];
    }

    public function __set($name, $value) {
        $this->vars[$name] = $value;
    }

    public function format() {
        extract($this->vars);
        ob_start();
        include("$this->templatesPath/$this->template.php");
        return ob_get_clean();
    }
}

class Data
{
    private $items = array();

    public function __construct($path) {
        $fp = fopen($path, 'r');
        $json = fread($fp, filesize($path));
        fclose($fp);

        $this->items = json_decode($json);
        if ($this->items === NULL) {
            throw new Exception();
        }
    }

    public function getAll() {
        return $this->items;
    }

    public function getByCategories($type) {
        $byCategories = array();
        foreach ($this->items as $item) {
            if ($item->type == $type) {
                $byCategories[$item->category][] = $item;
            }
        }
        return $byCategories;
    }
}

$params = explode('/', $_GET['url']);
$type = (sizeof($params) > 1 && !empty($params[1]) ? $params[1] : "apps");

$main = new Template('main');
$main->title = "Big List of Vim-like";
$main->webRoot = "/vim";
$main->type = $type;

try {
    $data = new Data('data.json');
} catch (Exception $e) {
    $main->content = "FAILED TO LOAD DATA";
    print $main->format();
    exit;
}

$byCategories = new Template('by-categories');
$byCategories->categories = $data->getByCategories($type);

$main->content = $byCategories->format();

print $main->format();

?>
