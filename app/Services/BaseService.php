<?php
/**
 * Created by PhpStorm.
 * User: Kyron Bao
 * Date: 19-3-25
 * Time: 下午11:05
 */

namespace App\Services;


class BaseService
{
    const OUTPUT_SUCCESS = 20000;
    const OUTPUT_ERROR = 13000;

    public $code = self::OUTPUT_SUCCESS;
    public $msg;
    public $data;

    protected static $_classServer;

    /**
     * @suppress PhanParamTooManyUnpack
     * @return static
     */
    public static function server()
    {
        $params = func_get_args();
        if ($params) {
            return new static(...$params);
        }

        return new static();
    }

    /**
     * @return bool
     */
    public function isError()
    {
        if ($this->code != self::OUTPUT_SUCCESS) {
            return true;
        }
        return false;
    }


    protected function outputSuccess($data = [], $msg = '')
    {
        return $this->output(self::OUTPUT_SUCCESS, $msg, $data);
    }


    protected function outputError($error = ['code'=>11000,'msg'=>'Logic error'])
    {
        $this->code = $error['code'];
        $this->msg = $error['msg'];

        return response([
            'code'  => $this->code,
            'msg'   => $this->msg,
        ]);
    }


    public function getMsg()
    {
        return $this->msg;
    }

    public function getData()
    {
        return $this->data;
    }


    protected function output($code, $msg = '', $data = [])
    {
        $this->code = $code;
        $this->msg = $msg;
        $this->data = $data;

        return response([
            'code'  => $code,
            'msg'   => $msg,
            'data'  => $data,
        ]);
    }
}