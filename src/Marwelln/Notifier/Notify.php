<?php namespace Marwelln\Notifier;

use Illuminate\Validation\Validator;
//use Session;

class Notify {
	/**
	 * @var array
	 */
	protected $attributes = [
		'autoclose' => true,
		'message' => array(),
		'type' => 'alert-success',
		'visible' => false,
	];

	/**
	 * @var SessionStore
	 */
	protected $session;

	public function __construct(array $attributes = [], SessionStore $session) {
		$this->attributes = array_merge($this->attributes, $attributes);

		$this->attributes['visible'] = ! empty($this->attributes['message']);

		$this->session = $session;
	}

	/**
	 * @return this
	 */
	public function success() {
		$this->attributes['type'] = 'alert-success';

		return $this;
	}

	/**
	 * @return this
	 */
	public function danger() {
		$this->attributes['type'] = 'alert-danger';

		return $this;
	}

	/**
	 * Set error messages from a validator instance.
	 *
	 * @param Validator
	 *
	 * @return $this
	 */
	public function validator(Validator $validator) {
		$this->attributes['message'] = $validator->errors()->all();

		return $this;
	}

	/**
	 * Set a specific message.
	 *
	 * @param str $message
	 *
	 * @return $this
	 */
	public function message($message) {
		$this->attributes['message'] = (array) $message;

		return $this;
	}

	/**
	 * Set wether or not to autoclose.
	 *
	 * @param bool $autoclose
	 *
	 * @return $this;
	 */
	public function autoclose($autoclose) {
		$this->attributes['autoclose'] = (bool) $autoclose;

		return $this;
	}

	/**
	 * Save the setup to a session flash.
	 *
	 * @return void
	 */
	public function flash($message = null, $type = null) {
		if ($message !== null) $this->attributes['message'] = (array) $message;
		if ($type !== null) $this->attributes['type'] = $type;

		$this->session->flash('notifier', $this->attributes);
	}

	public function getVisibleAttribute() {
		return ! $this->attributes['visible'] ? 'hide' : '';
	}

	public function getAutocloseAttribute() {
		return $this->attributes['autoclose'] ? 'autoclose' : '';
	}

	public function getMessageAttribute() {
		return '<p>' . implode('</p><p>', $this->attributes['message']) . '</p>';
	}

	public function __get($attribute) {
		if (method_exists($this, 'get' . $attribute . 'Attribute'))
			return $this->{"get" . $attribute . "Attribute"}();

		return $this->attributes[$attribute];
	}
}