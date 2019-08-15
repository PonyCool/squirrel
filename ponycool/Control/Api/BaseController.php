<?php
declare(strict_types=1);

namespace PonyCool\Control\Api;

use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\{RequestInterface, ResponseInterface};
use Psr\Log\LoggerInterface;
use PonyCool\Library\Code;
use OutOfRangeException;

class BaseController extends Controller
{
    use ResponseTrait;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Constructor.
     *
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        // $this->session = \Config\Services::session();

    }

    /**
     * 渲染数据
     * @param null $data
     * @return ResponseInterface
     */
    protected function render($data = null): ResponseInterface
    {
        $resp = [
            'status' => 'success',
            'code' => 0,
            'message' => '',
            'data' => []
        ];
        if (is_string($data)) {
            $resp['message'] = $data;
        }
        if (is_array($data)) {
            $code = $data['code'] ?? Code::FAIL();
            try {
                if (!is_object($code)) {
                    throw new OutOfRangeException();
                }
                $resp['code'] = $code->getValue();
            } catch (OutOfRangeException $exception) {
                $resp['code'] = Code::FAIL()->getValue();
            }
            $resp['status'] = $resp['code'] ? 'unsuccess' : 'success';
            $resp['message'] = $data['message'] ?? '';
            unset($data['code']);
            unset($data['message']);
            if (!empty($data) && 0 === $resp['code']) {
                $resp['data'] = $data;
            }
        }
        return $this->respond($resp, 200);
    }
}