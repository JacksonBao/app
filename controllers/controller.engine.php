<?php

/**
 * ENGINE CONTROLLER
 */
class Engine extends \App\Wallet\Libraries\Controller
{

	function __construct()
	{
		parent::__construct('engine');
		$this->pageTitle =  ' Engine | Njofa Wallet';
		// load parent model
		include_once 'models/model.engine.php';
		$this->model = new EngineModel();
	}

	public function intHome()
	{
		$this->render('index');
	}

	public function admin(array $param = [])
	{
		include_once 'models/app.engine.models/admin.engine.php';

		$this->model = new AdminEngine();
		$response = $this->model->response;
		$method = $param[0] ?: '';
		$method = str_replace('-', ' ', $method);
		$method = str_replace(' ', '', lcfirst(ucwords($method)));


		if (count($param) > 0 && method_exists($this->model, $method)) {
			// load error
			$this->model->loadEngineErrors('admin', $method, lang);
			// load error
			array_splice($param, 0, 1);
			$response = $this->model->$method($param);
		} else {
			$response = $this->model->responseError();
		}
		echo json_encode($response);
	}

	public function notifications(array $param = [])
	{
		include_once 'models/app.engine.models/notifications.engine.php';

		$this->model = new NotificationsEngine();
		$response = $this->model->response;
		$method = $param[0] ?: '';
		$method = str_replace('-', ' ', $method);
		$method = str_replace(' ', '', lcfirst(ucwords($method)));

		if (count($param) > 0 && method_exists($this->model, $method)) {
			// load error
			$this->model->loadEngineErrors('notifications', $method, lang);
			// load error
			array_splice($param, 0, 1);
			$response = $this->model->$method($param);
		} else {
			$response = $this->model->responseError();
		}
		echo json_encode($response);
	}
	public function reviews(array $param = [])
	{
		include_once 'models/app.engine.models/review.engine.php';

		$this->model = new ReviewEngine();
		$response = $this->model->response;
		$method = $param[0] ?: '';
		$method = str_replace('-', ' ', $method);
		$method = str_replace(' ', '', lcfirst(ucwords($method)));

		if (count($param) > 0 && method_exists($this->model, $method)) {
			// load error
			$this->model->loadEngineErrors('reviews', $method, lang);
			// load error
			array_splice($param, 0, 1);
			$response = $this->model->$method($param);
		} else {
			$response = $this->model->responseError();
		}
		echo json_encode($response);
	}


	public function reports(array $param = [])
	{
		include_once 'models/app.engine.models/report.engine.php';

		$this->model = new ReportEngine();
		$response = $this->model->response;
		$method = $param[0] ?: '';
		$method = str_replace('-', ' ', $method);
		$method = str_replace(' ', '', lcfirst(ucwords($method)));

		if (count($param) > 0 && method_exists($this->model, $method)) {
			// load error
			$this->model->loadEngineErrors('report', $method, lang);
			// load error
			array_splice($param, 0, 1);
			$response = $this->model->$method($param);
		} else {
			$response = $this->model->responseError();
		}
		echo json_encode($response);
	}

	public function agentInteractions(array $param = [])
	{
		include_once 'models/app.engine.models/agent.interaction.engine.php';

		$this->model = new AgentInteractions();
		$response = $this->model->response;
		$method = $param[0] ?: '';
		$method = str_replace('-', ' ', $method);
		$method = str_replace(' ', '', lcfirst(ucwords($method)));

		if (count($param) > 0 && method_exists($this->model, $method)) {
			array_splice($param, 0, 1);
			// load error
			$this->model->loadEngineErrors('agentinteraction', $method, lang);
			// load error
			$response = $this->model->$method($param);
		} else {
			$response = $this->model->responseError();
		}
		echo json_encode($response);
	}

	public function moneyRequest(array $param = [])
	{
		include_once 'models/app.engine.models/money.request.engine.php';

		$this->model = new MoneyRequestEngine();
		$response = $this->model->response;
		$method = $param[0] ?: '';
		$method = str_replace('-', ' ', $method);
		$method = str_replace(' ', '', lcfirst(ucwords($method)));

		if (count($param) > 0 && method_exists($this->model, $method)) {
			array_splice($param, 0, 1);
			// load error
			$this->model->loadEngineErrors('moneyrequest', $method, lang);
			// load error
			$response = $this->model->$method($param);
		} else {
			$response = $this->model->responseError();
		}
		echo json_encode($response);
	}

	public function profile(array $param = [])
	{
		include_once 'models/app.engine.models/profile.engine.php';

		$this->model = new ProfileEngine();
		$response = $this->model->response;
		$method = $param[0] ?: '';
		$method = str_replace('-', ' ', $method);
		$method = str_replace(' ', '', lcfirst(ucwords($method)));

		if (count($param) > 0 && method_exists($this->model, $method)) {
			array_splice($param, 0, 1);
			// load error
			$this->model->loadEngineErrors('profile', $method, lang);
			// load error
			$response = $this->model->$method($param);
		} else {
			$response = $this->model->responseError();
		}
		echo json_encode($response);
	}

	public function walletAuth(array $param = [])
	{
		include_once 'models/app.engine.models/auth.engine.php';

		$this->model = new AuthEngine();
		$response = $this->model->response;
		$method = $param[0] ?: '';
		$method = str_replace('-', ' ', $method);
		$method = str_replace(' ', '', lcfirst(ucwords($method)));
		if (count($param) > 0 && method_exists($this->model, $method)) {
			// load error
			$this->model->loadEngineErrors('auth', $method, lang);
			// load error
			array_splice($param, 0, 1);
			$response = $this->model->$method($param);
		} else {
			$response = $this->model->responseError();
		}
		echo json_encode($response);
	}
	public function sendMoney(array $param = [])
	{
		include_once 'models/app.engine.models/send.money.engine.php';

		$this->model = new SendMoneyEngine();
		$response = $this->model->response;
		$method = $param[0] ?: '';
		$method = str_replace('-', ' ', $method);
		$method = str_replace(' ', '', lcfirst(ucwords($method)));

		if (count($param) > 0 && method_exists($this->model, $method)) {
			// load error
			$this->model->loadEngineErrors('sendmoney', $method, lang);
			// load error
			array_splice($param, 0, 1);
			$response = $this->model->$method($param);
		} else {
			$response = $this->model->responseError();
		}
		echo json_encode($response);
	}

	public function agent(array $param = [])
	{
		include_once 'models/app.engine.models/agent.engine.php';

		$this->model = new AgentEngine();
		$response = $this->model->response;
		$method = $param[0] ?: '';
		$method = str_replace('-', ' ', $method);
		$method = str_replace(' ', '', lcfirst(ucwords($method)));

		if (count($param) > 0 && method_exists($this->model, $method)) {
			array_splice($param, 0, 1);
			// load error
			$this->model->loadEngineErrors('agent', $method, lang);
			// load error
			$response = $this->model->$method($param);
		} else {
			$response = $this->model->responseError();
		}
		echo json_encode($response);
	}




	public function dashboard(array $param = [])
	{
		include_once 'models/app.engine.models/dashboard.engine.php';

		$this->model = new AgentEngine();
		$response = $this->model->response;
		$method = $param[0] ?: '';
		$method = str_replace('-', ' ', $method);
		$method = str_replace(' ', '', lcfirst(ucwords($method)));

		if (count($param) > 0 && method_exists($this->model, $method)) {
			array_splice($param, 0, 1);
			// load error
			$this->model->loadEngineErrors('dashboard', $method, lang);
			// load error
			$response = $this->model->$method($param);
		} else {
			$response = $this->model->responseError();
		}
		echo json_encode($response);
	}

	public function payMethods(array $param = [])
	{
		include_once 'models/app.engine.models/pay.method.engine.php';

		$this->model = new PayMethodEngine();
		$response = $this->model->response;
		$method = $param[0] ?: '';
		$method = str_replace('-', ' ', $method);
		$method = str_replace(' ', '', lcfirst(ucwords($method)));

		if (count($param) > 0 && method_exists($this->model, $method)) {
			array_splice($param, 0, 1);
			// load error
			$this->model->loadEngineErrors('paymethods', $method, lang);
			// load error
			$response = $this->model->$method($param);
		} else {
			$response = $this->model->responseError();
		}
		echo json_encode($response);
	}


	public function apps(array $param = [])
	{
		include_once 'models/app.engine.models/apps.engine.php';

		$this->model = new AppsEngine();
		$response = $this->model->response;
		$method = $param[0] ?: '';
		$method = str_replace('-', ' ', $method);
		$method = str_replace(' ', '', lcfirst(ucwords($method)));

		if (count($param) > 0 && method_exists($this->model, $method)) {
			// load error
			$this->model->loadEngineErrors('apps', $method, lang);
			// load error
			array_splice($param, 0, 1);
			$response = $this->model->$method($param);
		} else {
			$response = $this->model->responseError();
		}
		echo json_encode($response);
	}
}
