<?php

class Template
{
    private $vars = array();
    private $templatesPath = __DIR__ . '/templates';

    public function __construct($template, $parent = null) {
        $this->template = $template;
        $this->parent = $parent;
    }

    public function __get($name) {
        return $this->vars[$name];
    }

    public function __set($name, $value) {
        $this->vars[$name] = $value;
    }

    public function format() {
        extract($this->getVars());
        ob_start();
        include("$this->templatesPath/$this->template.php");
        return ob_get_clean();
    }

    private function getVars() {
        $vars = (is_null($this->parent) ? array() : $this->parent->getVars());
        return array_merge($vars, $this->vars);
    }
}

class Data
{
    private $types = array();
    private $items = array();
    private $byId = array();

    public function __construct($path) {
        $fp = fopen($path, 'r');
        $json = fread($fp, filesize($path));
        fclose($fp);

        $data = json_decode($json);
        if ($data === null) {
            throw new Exception('Decoding has failed');
        }
        $this->types = $data->types;
        $this->items = $data->items;

        foreach ($this->items as $item) {
            if (strpos($item->id, ' ') !== FALSE) {
                throw new Exception("Bad id: $item->id");
            }
            if (array_key_exists($item->id, $this->byId)) {
                throw new Exception("Duplicated id: $item->id");
            }
            $this->byId[$item->id] = $item;
        }
    }

    public function getAll() {
        return $this->items;
    }

    public function getItem($id) {
        return $this->byId[$id];
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

    public function getTypeDescription($type) {
        return $this->types->$type;
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

$descr = $data->getTypeDescription($type);
$main->descr = $descr;

$byCategories = new Template('by-categories', $main);
$byCategories->categories = $data->getByCategories($type);

$main->content = $byCategories->format();

print $main->format();

?>
