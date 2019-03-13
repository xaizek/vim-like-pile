<?php

$webRoot = '/vim';

if (file_exists(__DIR__ . '/config.php')) {
    include(__DIR__ . '/config.php');
}

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
        $data = json_decode($this->getData($path));
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

        usort($this->items, function ($a, $b) {
            $result = strcasecmp($a->name, $b->name);
            if ($result == 0) {
                $result = strcasecmp($a->id, $b->id);
            }
            return $result;
        });
    }

    private function getData($path) {
        global $webRoot;

        $fp = fopen("$path.cached", 'r');
        if ($fp !== FALSE) {
            $json = fread($fp, filesize("$path.cached"));
            fclose($fp);
            return $json;
        }

        $fp = fopen($path, 'r');
        $json = fread($fp, filesize($path));
        fclose($fp);
        if ($json === FALSE) {
            return $json;
        }

        $data = json_decode($json);
        if ($data === null) {
            throw new Exception('Decoding has failed');
        }

        $predef_urls = array();
        foreach ($data->items as $item) {
            $predef_urls[$item->id] = "$webRoot/item/$item->id";
        }

        include(__DIR__ . '/markdown.php');
        $markdown = new MarkdownExtra();
        $markdown->no_markup = true;
        $markdown->predef_urls = $predef_urls;

        foreach ($data->items as $item) {
            $item->descr = $markdown->transform($item->descr);
            foreach ($item->comments as &$comment) {
                $comment = $markdown->transform($comment);
            }
        }

        $json = json_encode($data);
        $fp = fopen("$path.cached", 'w');
        fwrite($fp, $json);
        fclose($fp);

        return $json;
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

        uksort($byCategories, function ($a, $b) {
            if (strcasecmp($a, "other") == 0) {
                return 1;
            }
            if (strcasecmp($b, "other") == 0) {
                return -1;
            }
            return strcasecmp($a, $b);
        });
        return $byCategories;
    }

    public function getTypeDescription($type) {
        return $this->types->$type;
    }
}

$params = explode('/', $_GET['url']);
$type = (sizeof($params) > 1 && !empty($params[1]) ? $params[1] : 'apps');
$id = (sizeof($params) > 2 && !empty($params[2]) ? $params[2] : '');

$main = new Template('main');
$main->title = 'Big Pile of Vim-like';
$main->webRoot = $webRoot;
$main->type = $type;
$main->id = $id;

if ($type == 'about') {
    $about = new Template('about', $main);
    $main->content = $about->format();
    print $main->format();
    exit;
}

try {
    $data = new Data('data.json');
} catch (Exception $e) {
    $main->content = 'FAILED TO LOAD DATA: ' . $e->getMessage();
    print $main->format();
    exit;
}

if ($type == 'search') {
    $query = (isset($_GET['q']) ? $_GET['q'] : '');

    $search = new Template('search', $main);
    $search->query = $query;

    $matches = array();
    if (!empty($query)) {
        foreach ($data->getAll() as $item) {
            if (stripos($item->name, $query) !== FALSE ||
                stripos($item->descr, $query) !== FALSE) {
                $matches[] = $item;
            }
        }
    }
    $search->matches = $matches;

    $main->content = $search->format();
    print $main->format();
    exit;
}

if (!empty($id)) {
    $item = $data->getItem($id);
    $type = $item->type;
    $main->type = $type;
}

$descr = $data->getTypeDescription($type);
$main->descr = $descr;

if (empty($id)) {
    $byCategories = new Template('by-categories', $main);
    $byCategories->categories = $data->getByCategories($type);
    $byCategories->makeHeaderId = function ($header) {
        $id = strtolower($header);
        return preg_replace('/\W+/', '-', $id);
    };

    $main->content = $byCategories->format();
} else {
    $itemInfo = new Template('item', $main);
    $itemInfo->item = $item;
    $itemInfo->category = $data->getByCategories($type)[$item->category];
    $main->content = $itemInfo->format();
}

print $main->format();

?>
