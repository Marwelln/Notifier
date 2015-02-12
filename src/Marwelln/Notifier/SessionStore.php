<?php namespace Marwelln\Notifier;

use Illuminate\Session\Store;

class SessionStore implements SessionStore {
	/**
	 * @var Store
	 */
	protected $session;

	/**
	 * @param Store $session
	 */
	function __construct(Store $session) {
		$this->session = $session;
	}

	/**
	 * Flash a message to the session.
	 *
	 * @param $name
	 * @param $data
	 */
	public function flash($name, $data) {
		$this->session->flash($name, $data);
	}
}