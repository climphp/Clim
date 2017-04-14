<?php

namespace Clim;

class Context
{
    /** @var array $_argv */
    protected $_argv;

    /** @var string $_current */
    protected $_current;

    /** @var array */
    protected $_options;

    /** @var array $_arguments */
    protected $_arguments;

    /** @var string hold tentative value */
    protected $_tentative;

    public function __construct(array $argv = [])
    {
        $this->_argv = $argv;
        $this->_options = [];
        $this->_arguments = [];
    }

    public function argv()
    {
        return array_slice($this->_argv, 0);
    }

    public function next()
    {
        $this->_current = array_shift($this->_argv);
        return $this->_current;
    }

    public function hasNext()
    {
        return count($this->_argv) > 0;
    }

    public function unshift($value)
    {
        array_unshift($this->_argv, $value);
    }

    public function current()
    {
        return $this->_current;
    }

    public function push($value, $name = null, $append = false)
    {
        array_push($this->_arguments, $value);

        if ($name) {
            if ($append) {
                if (isset($this->_arguments[$name])) {
                    $this->_arguments[] = $value;
                } else {
                    $this->_arguments[$name] = [$value];
                }
            } else {
                $this->_arguments[$name] = $value;
            }
        }
    }

    public function set($name, $value)
    {
        $this->_options[$name] = $value;
    }

    public function options()
    {
        return $this->_options;
    }

    public function arguments()
    {
        return array_merge($this->_arguments, $this->_argv);
    }

    public function tentative($value = null)
    {
        if (is_null($value)) {
            if (!is_null($this->_tentative)) {
                $value = $this->_tentative;
                $this->_tentative = null;
            }
            return $value;
        } else {
            $this->_tentative = $value;
        }
    }
}
