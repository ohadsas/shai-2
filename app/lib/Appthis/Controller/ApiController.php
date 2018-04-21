<?php

namespace Appthis\Controller;
use Appthis\Exception\ApiException;
use Appthis\Helper\Config;
use Appthis\Helper\Logger;
use Appthis\Model\Country;
use Appthis\Model\Platform;
use Appthis\Model\Publisher;
use Appthis\Model\Stat;
use \Slim\Http\Response as SlimResponse;
use Psr\Http\Message\RequestInterface as Request;

class ApiController extends AbstractController {
	private $logger;

	public function __construct() {
		$this->logger = Config::getLogger();
	}

	/**
	 * Wrapper method for all api methods
	 *
	 * @param $method api method name
	 * @param $arguments api method args
	 * @return SlimResponse
	 */
	public function __call($method, $arguments)
	{
		/* @var $request Request */
		$request = $arguments[0];
		if ($request->getMethod() == 'GET'){
			$requestArgs = json_decode(urldecode($request->getUri()->getQuery()), true);
			if (empty($requestArgs)) {
				$requestArgs = [];
			}
		} else {
			// Extract arguments from url params or body
			$bodyArgs = json_decode($request->getBody()->getContents(), true);
			$requestArgs = !empty($bodyArgs) ? $bodyArgs : [];
		}

		// Start preparing response
		/* @var $response SlimResponse */
		$response = new SlimResponse();
		$code = 200;
		$status = "OK";
		$result = [];

		// Call the requested method
		try {
			if (method_exists($this, $method)) {
				// Throw exception if failed to call API method
				if (($result = call_user_func(array($this, $method), $requestArgs)) === false) {
					throw new ApiException('Wrong method arguments');
				}
			} else {
				throw new ApiException('Invalid api method');
			}
		} catch (\Exception $e) {
			$error = Logger::formatError($e);
			$this->logger->error(json_encode($error));
			// Prepare response error format in case of exception
			$result = [ 'error' => $error ];
			$code = 500;
			$status = "NOK";
		} finally {
			$finalResponse = [
				"status" => $status,
				"code" => $code,
				"data" => $result
			];
			// Send response
			return $response->withStatus($code)
				->withHeader('Content-Type', 'application/json')
				->write(json_encode($finalResponse, JSON_NUMERIC_CHECK));
		}
	}

	protected function getPublishers() {
		$model = new Publisher();
		return $model->getAll();
	}

	protected function getCountries() {
		$model = new Country();
		return $model->getAll();
	}

	protected function getPlatforms() {
		$model = new Platform();
		return $model->getAll();
	}

	protected function getStatsByPublishers(array $params){
		$model = new Stat();
		return $model->getByPublishers();
	}

        protected function getStatsByDates(array $params) {
		// Check params
		$start = $end = null;
		if (isset($params['start'])) {
			if (\DateTime::createFromFormat('Y-m-d', $params['start']) !== false) {
				$start = $params['start'];
			} else {
				throw new ApiException('Invalid param: start');
			}
		}
		if (isset($params['end'])) {
			if (\DateTime::createFromFormat('Y-m-d', $params['end']) !== false) {
				$end = $params['end'];
			} else {
				throw new ApiException('Invalid param: end');
			}
		}

		// Get data
		$model = new Stat();
		return $model->getByDate($start, $end);
	}

	protected function getStatsByPlatform(array $params) {
		$publisherId = null;
		// Check params
		if (isset($params['publisherId'])) {
			$publisherId = intval($params['publisherId']);
			if ($publisherId<=0) {
				throw new ApiException('Invalid param: publisherId');
			}
		}

		// Get data
		$model = new Stat();
		return $model->getByPlatform($publisherId);
	}

}