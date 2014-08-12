<?php

namespace Wypok;

/**
 * Api class container
 *
 * @package     Skypebot
 * @version     $Id$
 * @copyright   2014 SMT Software S.A.
 * @filesource
 */
use Skypebot\ErrorHandlerInstaller;

/**
 * Wypok API
 *
 * @package     Skypebot
 * @author      Daniel Jeznach <djeznach@gmail.com>
 */
class Api
{
    use ErrorHandlerInstaller;

    protected $userAgent = 'WykopAPI';
    protected $apiDomain = 'http://a.wykop.pl/';
    protected $key = null;
    protected $secret = null;
    protected $userKey = null;
    protected $format = 'json';
    protected $output = 'clear';
    protected $isValid;
    protected $error;

    /**
     * Kontruktor
     *
     * @param string $key - appkey
     * @param string $secret - appsecret
     * @param string $output - output format
     *
     */
    public function __construct($key, $secret, $output = null)
    {
        $this->key = $key;
        $this->secret = $secret;

        if ($output !== null) {
            $this->output = $output;
        }
    }

    /**
     * Wykonanie requestu do API
     *
     * @param string $action - zasób, np. "links/upcoming"
     * @param array  $postData - post
     * @param array  $filesData - pliki, np array('embed' => "@plik.jpg;type=image/jpeg")
     *
     * @return array - odpowiedź API
     */

    public function doRequest($action, $postData = null, $filesData = null)
    {
        $url = $this->apiDomain . $action .= (strpos($action, ',') ? ','
                    : '/') . $this->getKey() . $this->getFormat() . $this->getOutput() . $this->getUserKey();

        if ($postData === null) {
            $result = $this->curl($url);
        } else {
            if ($filesData !== null) {
                $postData = $filesData + $postData;
            }

            $result = $this->curl($url, $postData);
        }

        $this->checkIsValid($result);

        return $this->isValid ? json_decode($result['content'], true) : array();
    }

    /**
     * Czy zapytanie było poprawne
     *
     * @return bool - poprawna odpowiedź
     */

    protected function getKey()
    {
        if (! empty($this->key)) {
            return 'appkey/' . $this->key . '/';
        }
    }

    /**
     * Błąd ostatniego zapytania
     *
     * @return string - komunikat błędu
     */
    protected function getFormat()
    {
        if (! empty($this->format)) {
            return 'format/' . $this->format . '/';
        }
    }

    /**
     * Ustawienie klucza użytkownika - kolejne requesty będą wykonywane jako wybrany użytkownik
     *
     * @param string $userKey - klucz użytkownika
     */
    protected function getOutput()
    {
        if (! empty($this->output)) {
            return 'output/' . $this->output . '/';
        }
    }

    /**
     * Generuje link do Wykop Connect
     *
     * @param string $redirectUrl - opcjonalny adres przekierowania po zalogowaniu
     * @return string - link do Wykop Connect
     */
    protected function getUserKey()
    {
        if (! empty($this->userKey)) {
            return 'userkey/' . $this->userKey . '/';
        }
    }

    /**
     * Dekoduje dane connecta
     *
     * @return array - tablica z danymi connecta (appkey, login, token) - wykorzystywane później do logowania
     */
    protected function curl($url, $post = null)
    {

        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER         => false,
            CURLOPT_ENCODING       => '',
            CURLOPT_USERAGENT      => $this->userAgent,
            CURLOPT_AUTOREFERER    => true,
            CURLOPT_CONNECTTIMEOUT => 15,
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_HTTPHEADER     => array('apisign:' . $this->sign($url, $post))
        );

        if ($post !== null) {
            $post_value = is_array($post)
                ? http_build_query($post, 'f_', '&')
                : '';

            $options[CURLOPT_POST] = 1;
            $options[CURLOPT_POSTFIELDS] = $post;
        }

        $ch = curl_init($url);
        curl_setopt_array($ch, $options);

        $content = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        $result = curl_getinfo($ch);

        curl_close($ch);

        $result['errno'] = $err;
        $result['errmsg'] = $errmsg;
        $result['content'] = $content;

        return $result;
    }

    protected function sign($url, $post = null)
    {
        if ($post !== null) {
            ksort($post);
        }

        return
            md5($this->secret . $url . ($post === null
            ? ''
            : implode(',', $post)));
    }

    protected function checkIsValid(&$result)
    {

        $this->error = null;

        if (empty($result['content'])) {
            $this->isValid = false;
        } else {
            $json = json_decode($result['content'], true);

            if (! empty($json['error'])) {
                $this->isValid = false;
                $this->error = $json['error']['message'];
            } else {
                $this->isValid = true;
            }
        }
    }

    public function isValid()
    {
        return $this->isValid;
    }

    public function getError()
    {
        return $this->error;
    }

    public function setUserKey($userKey)
    {
        $this->userKey = $userKey;
    }

    public function getConnectUrl($redirectUrl = null)
    {
        $url = $this->apiDomain . 'user/connect/' . $this->getKey();

        if ($redirectUrl !== null) {
            $url .= 'redirect/' . urlencode(base64_encode($redirectUrl)) . '/';
            $url .= 'secure/' . md5($this->secret . $redirectUrl);
        }

        return $url;
    }

    public function handleConnectData()
    {
        if (! empty($_GET['connectData'])) {
            $data = base64_decode($_GET['connectData']);
            return json_decode($data, true);
        }
    }
}
