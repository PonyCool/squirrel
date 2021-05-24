<?php
declare(strict_types=1);

namespace PonyCool\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\{CLIRequest,
    IncomingRequest,
    RequestInterface,
    ResponseInterface
};
use OutOfRangeException;
use PonyCool\Library\Code;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{
    use ResponseTrait;

    /**
     * Instance of the main Request object.
     *
     * @var IncomingRequest|CLIRequest
     */
    protected $request;

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
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.: $this->session = \Config\Services::session();
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