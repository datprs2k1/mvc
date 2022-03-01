<?php

class Request
{

    private $rules = [];
    private $messages = [];
    public $errors = [];

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function isPost()
    {
        return $this->getMethod() === 'POST';
    }

    public function isGet()
    {
        return $this->getMethod() === 'GET';
    }
    public function all()
    {
        $dataFiels = [];
        if ($this->isGet()) {
            if (isset($_GET)) {
                foreach ($_GET as $key => $value) {
                    if (is_array($value)) {
                        $dataFiels[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataFiels[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }

        if ($this->isPost()) {
            if (isset($_POST)) {
                foreach ($_POST as $key => $value) {
                    if (is_array($value)) {
                        $dataFiels[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
                    } else {
                        $dataFiels[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                    }
                }
            }
        }

        return $dataFiels;
    }

    public function rules($rules = [])
    {
        $this->rules = $rules;
    }

    public function message($messages = [])
    {
        $this->messages = $messages;
    }

    public function validate()
    {
        $this->rules = array_filter($this->rules);
        $checkValidate = true;

        if (!empty($this->rules)) {

            $dataFields = $this->all();

            foreach ($this->rules as $fieldName => $ruleItem) {
                $ruleItemArr = explode('|', $ruleItem);

                $ruleName = '';
                $ruleValue = '';

                foreach ($ruleItemArr as $rules) {
                    $rulesArr = explode(':', $rules);

                    $ruleName = reset($rulesArr);

                    if (count($rulesArr) > 1) {
                        $ruleValue = end($rulesArr);
                    }

                    if ($ruleName == 'required') {
                        if (empty($dataFields[$fieldName])) {
                            $this->setErrors($fieldName, $ruleName);
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'min') {
                        if (strlen($dataFields[$fieldName]) < $ruleValue) {
                            $this->errors[$fieldName][$ruleName] = $this->messages[$fieldName . '.' . $ruleName];
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'max') {
                        if (strlen($dataFields[$fieldName]) > $ruleValue) {
                            $this->errors[$fieldName][$ruleName] = $this->messages[$fieldName . '.' . $ruleName];
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'email') {
                        if (!filter_var($dataFields[$fieldName], FILTER_VALIDATE_EMAIL)) {
                            $this->errors[$fieldName][$ruleName] = $this->messages[$fieldName . '.' . $ruleName];
                            $checkValidate = false;
                        }
                    }

                    if ($ruleName == 'match') {
                        if ($dataFields[$fieldName] != $dataFields[$ruleValue]) {
                            $this->errors[$fieldName][$ruleName] = $this->messages[$fieldName . '.' . $ruleName];
                            $checkValidate = false;
                        }
                    }
                }
            }
        }
        return $checkValidate;
    }

    public function errors($fieldName = '')
    {
        if (!empty($this->errors)) {
            if (empty($fieldName)) {
                $errorsArr = [];
                foreach ($this->errors as $fieldName => $error) {
                    $errorsArr[$fieldName] = reset($error);
                }
                return $errorsArr;
            }
            return reset($this->errors[$fieldName]);
        }
    }

    public function setErrors($fieldName, $ruleName)
    {
        $this->errors[$fieldName][$ruleName] = $this->messages[$fieldName . '.' . $ruleName];
    }
}
