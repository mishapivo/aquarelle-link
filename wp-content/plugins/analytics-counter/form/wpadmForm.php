<?php
class wpadmForm {
    public $errors = array();
    protected $data = array();
    public function bind($data) {
        if(is_array($data)) {
            $this->setData($data);
        } elseif (is_object($data) && method_exists($data, 'getArrayCopy')) {
            $this->setData($data->getArrayCopy());
        }
    }

    public function setData(array $data) {

        if (!is_array($this->data)) {
            $this->data = array();
        }

        foreach($data as $k=>$v) {
            $this->data[$k] = $v;
        }

//        $this->data = $data;
    }

    public function addError($error, $element) {
        if (!$element) {
            return false;
        }
        if (!isset($this->errors[$element])) {
            $this->errors[$element] = array();
        }
        $this->errors[$element][] = $error;

        return true;
    }

    public function  clearError() {
        $this->errors = array();
    }

    public function get($element) {
        return array(
            'value' => $this->getValue($element),
            'errors' => $this->getErros($element),
        );
    }

    public function getValue($element) {
        return (isset($this->data[$element])) ? $this->data[$element] : null;
    }

    public function setValue($element, $value) {
        $this->data[$element] = $value;
        return $this;
    }

    /**
     * @param $element
     * @deprecated
     *
     * @return array
     */
    public function getErros($element) {
        return (isset($this->errors[$element])) ? $this->errors[$element] : array();
    }

    public function getErrors($element) {
        return (isset($this->errors[$element])) ? $this->errors[$element] : array();
    }

    public function isValid() {
        return true;
    }

} 