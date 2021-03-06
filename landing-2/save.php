<?php

require_once('pest/Pest.php');

/**
 *
 * @category Landing page
 * @package Landing page
 * @author Anna Buniatova
 * @copyright 2018 (c) Teamgate
 * @license http://www.teamgate.com Exclusive rights
 * @link http://www.teamgate.com
 */
class Request {

    const DEBUG = false;

    private $_baseUrl = ''; 
    private $_apiKey = '';
    private $_userToken = '';

    private $_gwUrl = 'https://api.teamgate.com/';
    private $_name;
    private $_email;
    private $_phone;
    private $_date;
    private $_comment;
    private $_pest;
    private $_buyerId;
    private $_headers = [];

    /**
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->_pest = new Pest($this->_gwUrl);
        $this->_headers = [
                'X-App-Key: ' . $this->_apiKey,
                'X-Auth-Token: '. $this->_userToken
        ];
        $this->_pest->throw_exceptions = false;

        $this->_log($data, 'post data');
        try {
            if (empty($data['name'])) {
                throw new Exception('Fill name and surname');
            }

            if (empty($data['email'])) {
                throw new Exception('Fill email');
            }

            if (empty($data['phone'])) {
                throw new Exception('Fill phone number');
            }

            if (empty($data['date'])) {
                throw new Exception('Select date');
            }

            $this->_name = ucwords(trim($data['name']));
            $this->_email = trim($data['email']);
            $this->_phone = str_replace(' ', '', $data['phone']);
            $this->_date = $data['date'];
            $this->_comment = $data['comment'];

        } catch (Exception $exc) {
            $this->_exception($exc);
        }
    }

    /**
     *
     * @return null
     */
    public function create()
    {
        try {
            $leadId = $this->_createLead();

            if (!self::DEBUG) {
                header("Location: {$this->_baseUrl}/success.html", true, 302);
                die;
            }
        } catch (Exception $exc) {
            $this->_exception($exc);
        }
    }

    /**
     *
     * @param integer $buyerId
     * @param integer $contactId
     * @return integer
     */
    private function _createLead()
    {
        $this->_buyerId = $this->_searchCompanyContact();

        if (empty($this->_buyerId)) {
            $this->_buyerId = $this->_createPerson();
        }

        $response = $this->_post(
            'v4/leads', array(
                'name' => $this->_name,
                'buyerId' => $this->_buyerId,
                'emails' => array(
                    array(
                        'value' => $this->_email,
                        'type' => 'personal'
                    )
                ),
                'phones' => array(
                    array(
                        'value' => $this->_phone,
                        'type' => 'mobile'
                    )
                )
            )
        );

        $data = $this->_checkResponse($response);

        $eventData = array(
            'leads' => array($data['id']),
            'name' => 'Visit registration ',
            'type' => 'appointment',
            'time' => $this->_date,
        );

        $this->_post("v4/events", $eventData);

        $commentData = array(
            'leads' => array($data['id']),
            'type' => 'note',
            'value' => $this->_comment,
        );

        $this->_post("v4/events", $commentData);

        return $data['id'];
    }

    /**
     *
     * @return integer id
     */
    private function _createPerson()
    {
        $response = $this->_post(
            'v4/people', array(
                'name' => $this->_name,
                'emails' => array(
                    array(
                        'value' => $this->_email,
                        'type' => 'personal'
                    )
                ),
                'phones' => array(
                    array(
                        'value' => $this->_phone,
                        'type' => 'mobile'
                    )
                )
            )
        );

        $data = $this->_checkResponse($response);

        return $data['id'];
    }

    private function _searchCompanyContact()
    {
        $response = $this->_get(
            'v4/people', array(
                'name' => array(
                    'like' => $this->_name
                )
            )
        );
        $data = $this->_checkResponse($response);
        return array_shift($data)['id'];
    }

	/**
	 *
	 * @param string $url
     * @param array $data
	 * @return string
	 */
	private function _get($url, array $data = [])
	{
		return $this->_pest->get($url, $data, $this->_headers);
	}

	/**
	 *
	 * @param string $url
	 * @param array $data
	 * @return string
	 */
	private function _post($url, array $data)
	{
		return $this->_pest->post($url, $data, $this->_headers);
	}

	/**
	 *
	 * @param string $url
	 * @param array $data
	 * @return string
	 */
	private function _put($url, array $data = [])
	{
		return $this->_pest->put($url, $data, $this->_headers);
	}

	/**
	 *
	 * @param string $url
	 * @return string
	 */
	private function _delete($url)
	{
		return $this->_pest->delete($url, $this->_headers);
	}

	/**
	 *
	 * @param string $url
	 * @param array $data
	 * @return string
	 */
	private function _patch($url, array $data = [])
	{
		return $this->_pest->patch($url, $data, $this->_headers);
	}

    /**
     *
     * @param string $response
     * @return mixed
     * @throws Exception
     */
    private function _checkResponse($response)
    {
        try {

            $data = json_decode($response, true);
            $this->_log($data, 'gw data');
            if (empty($data) || (boolean) $data['success'] === false || !isset($data['data'])) {
                throw new Exception('Exception error, please try again later!');
            }
        } catch (Exception $exc) {
            $this->_exception($exc);
        }

        return $data['data'];
    }

    /**
     *
     * @param mixed $data
     * @param string $label
     * @return null
     */
    private function _log($data, $label = '')
    {
        if (self::DEBUG) {
            echo '<pre>';
            if (!empty($label)) {
                echo $label . ':<br />';
            }
            print_r($data);
            echo '</pre>';
        }
        return;
    }

    /**
     *
     * @param Exception $exc
     * @return null
     */
    private function _exception(Exception $exc)
    {
        if (self::DEBUG) {
            die($exc->getMessage());
        }

        header("Location: {$this->_baseUrl}/error.html", true, 302);
        die();
    }

}

//var_dump($_POST);
//exit;
$res = new Request($_POST);
$res->create();
