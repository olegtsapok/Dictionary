<?php

class ApiController extends CController
{
    public $raw;
    public $data;

    protected $checkedValues = array(
            'any' => array(
                'status' => array(0, 1),
            ),
            'User' => array(
                'role' => array(0, 1),
            ),
    );
    protected $errorCodes = array(
        'checkValues' => array(
            'type' => '450',
            'orderby' => '451',
        ),
        'required' => array(
            'type' => '300',
            'orderby' => '301',
            'offset' => '302',
            'rows' => '303',
            'id' => '326',
        ),
        'type' => array(
            'type' => '400',
            'orderby' => '401',
            'offset' => '402',
            'rows' => '403',
        ),
        'format' => array(
            'email' => '250',
            'date' => '251',
        ),
    );


    public function __construct($id, $module=null)
    {
        parent::__construct($id, $module);
        Yii::app()->theme = 'api';
        $this->checkVersion(Yii::app()->request->getParam('version'));
        $this->read_JSON();
    }

    // The function set_headers_for_JSON() sets head to send the response.
    public function set_headers_for_JSON() {
        header("HTTP/1.1 200 OK");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0");
        header('Content-Type: application/json; charset=utf-8');
        header("Pragma: no-cache");
    }

    // The function read_JSON() reads data from a action.
    public function read_JSON()
    {
        if (!isset($this->raw)) {
            if (isset($_SERVER['CONTENT_LENGTH'])) {
                $contentSize = (int) $_SERVER['CONTENT_LENGTH'];
                $post_max_size = ((int)ini_get('post_max_size')) * 1024 *1024;
                if ($contentSize > $post_max_size) {
                    $this->returnError(27, 'Content-Length of request exceeds the limit');
                }
            }

            if (!isset($_SERVER['CONTENT_TYPE'])) {
                $this->returnError(2, "Request Content-Type is required");
            }

            $contentType = $_SERVER['CONTENT_TYPE'];
            if (stripos($contentType, "application/json") === false) {
                    $this->returnError(2, "Request Content-Type must be application/json");
            }
            if (stripos($contentType, "UTF-8") === false and
                stripos($contentType, "UTF8") === false
            ) {
                    $this->returnError(4, "Request encoding must be UTF-8");
            }

            $this->raw = Yii::app()->request->getRawBody();
            if (empty($this->raw))
                    $this->returnError(5, 'Request body is empty');

            $this->data = json_decode($this->raw);
            if (empty($this->data))
                    $this->returnError(3, 'Wrong request');
        }
    }


    // The function returnResult(). It is formed in response if not error occurs.
    public function returnResult($mixed = null)
    {
        Yii::log('API successfully called by URL '.Yii::app()->request->getUrl().' with raw data: '.Yii::app()->request->getRawBody(),
                'info', 'api');

        $this->set_headers_for_JSON();

        if (!isset($mixed))
            $mixed = array();

        $mixed['status'] = array(
            'code' => 0,
            'message' => ''
        );

        $mixed = str_replace('\/', '/', json_encode($mixed));

        echo $mixed;

        Yii::log('API successful response: ' . $mixed . '. \n',
                'info', 'api');

        exit();
    }

    // The function returnError(). It is formed in response if an error occurs.
    public function returnError($code, $description)
    {
        Yii::log('API unsuccessfully called by URL '.Yii::app()->request->getUrl().' with raw data: '.Yii::app()->request->getRawBody(),
                'error', 'api');

        $this->set_headers_for_JSON();

        $response = array(
                'status' => array(
                    'code' => $code,
                    'message' => $description
                )
            );
        echo json_encode($response);

        Yii::log('API return error ' . $code . ': ' . $description . ". \n",
                'error', 'api');

        exit();
    }

    public function checkVersion($version)
    {
        if ($version != 1) {
            $this->returnError(100, 'Server support API with version 1');
        }

    }

    public function checkFormat($title, $pattern, $data = null)
    {
        if (!$data) {
            $data = $this->data;
        }

        $errorCode = 250;
        if (isset($this->errorCodes['format'][$title])) {
            $errorCode = $this->errorCodes['format'][$title];
        }


        if (!(preg_match('/' . $pattern . '/is', $data->$title))) {
            $this->returnError($errorCode, 'Parameter \'' . $title . '\' has wrong format \'' . $data->$title . '\'');
        }
    }

    public function checkRequired($title, $data = null)
    {
        if (is_array($title)) {
            $params = $title;
        } else {
            $params = array($title);
        }

        foreach ($params as $title) {
            $errorCodeMissed = 101;
            $errorCodeEmpty = 102;
            if (isset($this->errorCodes['required'][$title])) {
                $errorCodeMissed = $this->errorCodes['required'][$title];
                $errorCodeEmpty = $errorCodeMissed + 50;
            }

            if (!$data) {
                $data = $this->data;
            }

            if (!isset($data->$title)) {
                $this->returnError($errorCodeMissed, "Required parameter '{$title}' is missed");
            }

            if ($data->$title === 0
                or $data->$title === '0'
            ) {
                continue;
            }

            if (empty($data->$title))
                $this->returnError($errorCodeEmpty, "Required parameter '{$title}' is empty");
        }
    }

    /**
     *
     * @param array $params
     */
    public function checkRequiredOneOf($params)
    {
        $titleParams = implode(',', $params);

        $checked = false;
        foreach ($params as $paramName) {
            if (isset($this->data->$paramName)) {
                $checked = true;
                break;
            }
        }
        if (!$checked) {
            $this->returnError(104, "None of optional fields '{$titleParams}' is exists");
        }

        $checked = false;
        foreach ($params as $paramName) {
            if (isset($this->data->$paramName)) {
                if ($this->data->$paramName != '') {
                    $checked = true;
                    break;
                }
            }
        }
        if (!$checked) {
            $this->returnError(105, "None of optional fields '{$titleParams}' is filled");
        }

    }

    public function checkValue($title, $entity = 'any')
    {
        if (is_array($title)) {
            $params = $title;
        } else {
            $params = array($title);
        }

        foreach ($params as $title) {
            $errorCode = 450;
            if (isset($this->errorCodes['checkValues'][$title])) {
                $errorCode = $this->errorCodes['checkValues'][$title];
            }

            $values = $this->checkedValues;
            $checked = false;

            if (isset($values[$entity][$title])) {
                foreach ($values[$entity][$title] as $availableParameter) {
                    if (strpos((string)$availableParameter, (string)$this->data->$title) !== false) {
                        $checked = true;
                        break;
                    }
                }
            }

            if (!$checked)
                $this->returnError($errorCode, "It is invalid value '{$this->data->$title}' for '{$title}' parameter, according to documentation");
        }
    }

    public function checkType($type, $title, $data = null)
    {
        if (is_array($title)) {
            $params = $title;
        } else {
            $params = array($title);
        }

        foreach ($params as $title) {
            $errorCode = 400;
            if (isset($this->errorCodes['type'][$title])) {
                $errorCode = $this->errorCodes['type'][$title];
            }

            if (!$data) {
                $data = $this->data;
            }

            if ($type == 'int') {
                if (!is_int($data->$title)) {
                    $this->returnError($errorCode, "Parameter '{$title}' isn't number, string type also not accessed");
                }
            } elseif ($type == 'number') {
                if (!(is_int($data->$title) or is_float($data->$title))) {
                    $this->returnError($errorCode, "Parameter '{$title}' isn't number, string type also not accessed");
                }
            } elseif ($type == 'array') {
                if (!(is_array($data->$title))) {
                    $this->returnError($errorCode, "Parameter '{$title}' isn't array");
                }
            }
        }
    }

}
