<?php namespace Dulabs\Modular;


class Modular
{
    protected $directory;

    protected $modules;

    public function setDirectory($dir)
    {
        $this->directory = $dir;

        return $this;
    }

    public function load()
    {
        $path = $this->directory;

        $module = array();

        if($dir = opendir($path))
        {
            while($module_dir = readdir($dir))
            {
                $module_path = sprintf("%s/%s",$path,$module_dir);

                $file = sprintf("%s/module.json",$module_path);

                if(!file_exists($file)) continue;

                $info = json_decode(file_get_contents($file));

                if(!isset($info->active)) continue;
                if($info->active === 0) continue;

                if(!isset($info->type)) continue;
                if($info->type != "module") continue;

                $info->module_path = $module_path;
                $module[$info->alias] = $info;
            }

            closedir($dir);

        }

        $this->modules = $module;

        return $this;
    }

    public function activeModules()
    {
        return array_keys($this->modules);
    }

    public function getModules()
    {
        $modules = $this->activeModules();

        if(empty($modules)) return array();

        $registerModules = array();
        foreach($modules as $key)
        {
            $info = $this->modules[$key];
            $registerModules[$key] = ["className" => $info->bootstrap->className,
                                      "path" => sprintf("%s/%s",$info->module_path,$info->bootstrap->path)];
        }

        return $registerModules;
    }

    public function setRouter(&$router)
    {

        $modules = $this->activeModules();

        if(empty($modules)) return array();

        foreach($modules as $key)
        {
            $info = $this->modules[$key];
            $routes = sprintf("%s/Http/Routes.php",$info->module_path);

            if(file_exists($routes)){
                include $routes;
            }
        }

    }
}
