<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Payment_PayPal_SOAP is a package to easily use PayPal's SOAP API from PHP
 *
 * By itself, this package isn't very useful. It should be used in combination
 * with the documentation provided by PayPal at
 * {@link https://www.paypal.com/en_US/pdf/PP_APIReference.pdf}. This package
 * makes it easier to get up and running, and allows you to begin integration
 * by making requests rather than by figuring out how to set SOAP
 * authentication headers.
 *
 * PHP version 5
 *
 * LICENSE:
 *
 * Copyright (c) 2008-2011 silverorange
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008-2009 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @version   CVS: $Id$
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 * @link      https://www.paypal.com/en_US/pdf/PP_APIReference.pdf
 */

/**
 * Package-specific exceptions classes.
 */
require_once 'Payment/PayPal/SOAP/Exceptions.php';

/**
 * An easy to use SOAP client for the PayPal SOAP API
 *
 * By itself, this class isn't very useful. It should be used in combination
 * with the documentation provided by PayPal at
 * {@link https://www.paypal.com/en_US/pdf/PP_APIReference.pdf}. This class
 * makes it easier to get up and running, and allows you to begin integration by
 * making requests rather than by figuring out how to set SOAP authentication
 * headers.
 *
 * @category  Payment
 * @package   Payment_PayPal_SOAP
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2008-2011 silverorange
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Payment_PayPal_SOAP
 */
class Payment_PayPal_SOAP
{
    // {{{ class constants

    /**
     * Warning or informational error.
     */
    const ERROR_WARNING = 1;

    /**
     * Application-level error.
     */
    const ERROR_ERROR = 2;

    /**
     * Unknown error type reserved for future internal use by PayPal
     */
    const ERROR_UNKNOWN = 3;

    // }}}
    // {{{ protected properties

    /**
     * SOAP client used to make PayPal SOAP requests
     *
     * @var SoapClient
     *
     * @see Payment_PayPal_SOAP::getSoapClient()
     */
    protected $soapClient = null;

    /**
     * SOAP header values specific to PayPal SOAP API
     *
     * This contains PayPal authentication values.
     *
     * @var SoapHeader
     *
     * @see Payment_PayPal_SOAP::getSoapHeaders()
     */
    protected $soapHeader = null;

    /**
     * Options passed to the SOAP client when it is created
     *
     * PayPal's SOAP implementation uses SOAP 1.1 so the SOAP version option
     * is specified by default. If using local certificates for authentication,
     * the local certificate file is also included in these options.
     *
     * The API endpoint location is also specified in these options as the
     * endpoint in the WSDL file is not always correct depending on the
     * authentication mechanism used.
     *
     * @var array
     *
     * @see Payment_PayPal_SOAP::setCertificateFile()
     * @see Payment_PayPal_SOAP::__construct()
     */
    protected $soapOptions = array(
        'trace'        => true,
        'soap_version' => SOAP_1_1
    );

    /**
     * Whether or not to use a local copy of the PayPal WSDL
     *
     * If true, a local copy of the PayPal WSDL is used instead of the copy
     * hosted on PayPal's servers. This can be used if PayPal breaks the hosted
     * WSDL files, as has happened in the past.
     *
     * @var boolean
     *
     * @see Payment_PayPal_SOAP::__construct()
     * @see Payment_PayPal_SOAP::getWsdlFile()
     */
    protected $useLocalWsdl = false;

    // }}}
    // {{{ private properties

    /**
     * Mode to use for PayPal API
     *
     * Valid modes are:
     * - <kbd>sandbox</kbd> - for development and testing.
     * - <kbd>live</kbd>    - for processing live payments.
     *
     * Defaults to 'sandbox'.
     *
     * @var string
     *
     * @see Payment_PayPal_SOAP::__construct()
     * @see Payment_PayPal_SOAP::setMode()
     */
    private $_mode = 'sandbox';

    /**
     * PayPal API username
     *
     * @var string
     *
     * @see Payment_PayPal_SOAP::__construct()
     * @see Payment_PayPal_SOAP::setUsername()
     */
    private $_username = '';

    /**
     * PayPal API password
     *
     * @var string
     *
     * @see Payment_PayPal_SOAP::__construct()
     * @see Payment_PayPal_SOAP::setPassword()
     */
    private $_password = '';

    /**
     * PayPal signature
     *
     * Only set if using signature-based authentication instead of
     * local-certificate-based authentication.
     *
     * @var string
     *
     * @see Payment_PayPal_SOAP::__construct()
     * @see Payment_PayPal_SOAP::setSignature()
     */
    private $_signature = '';

    /**
     * PayPal subject used for making requests on behalf of a third-party
     *
     * This is the email address of the third-party the request should be made
     * on behalf of. Your API username may require explicit access from the
     * third-party before certain API actions will work.
     *
     * @var string
     *
     * @see Payment_PayPal_SOAP::__construct()
     * @see Payment_PayPal_SOAP::setSubject()
     */
    private $_subject = '';

    /**
     * API endpoints indexed by mode and security mode
     *
     * Certificate-based authentication uses a different API endpoint than
     * signature (3 token)-based authentication.
     *
     * @var array
     *
     * @see https://ppmts.custhelp.com/cgi-bin/ppdts.cfg/php/enduser/popup_adp.php?p_sid=undefined&p_lva=undefined&p_faqid=391&p_created=1169502818
     */
    static private $_apiEndpoints = array(
        'sandbox' => array(
            'certificate' => 'https://api.sandbox.paypal.com/2.0/',
            'signature'   => 'https://api-3t.sandbox.paypal.com/2.0/'
        ),
        'live'    => array(
            'certificate' => 'https://api.paypal.com/2.0/',
            'signature'   => 'https://api-3t.paypal.com/2.0/'
        )
    );

    // }}}
    // {{{ __construct()

    /**
     * Creates a new PayPal SOAP client
     *
     * Either signature-based or certificate-based authentication options
     * are required. The username, password and optional signature fields may
     * be retrieved from your PayPal account in the 'API Credentials' section.
     *
     * Sandbox and live modes require different PayPal accounts so all option
     * values will require changing if you select a different mode.
     *
     * The available options are:
     *
     * - <kbd>mode</kbd>         - optional. The mode to use for PayPal API
     *                             calls. Valid modes are <kbd>sandbox</kbd>
     *                             for development and testing, and
     *                             <kbd>live</kbd> for live payments. If not
     *                             specified, <em><kbd>sandbox</kbd></em> is
     *                             used.
     * - <kbd>username</kbd>     - the username used for authentication.
     * - <kbd>password</kbd>     - the password used for authentication.
     * - <kbd>subject</kbd>      - optional. The third-party on whose behalf
     *                             requests are to be made.
     * - <kbd>signature</kbd>    - optional. The signature used for signature-
     *                             based authentication. Not required if
     *                             certificate-based authentication is used.
     * - <kbd>certificate</kbd>  - optional. The local certificate filename used
     *                             for certificate-based authentication. Not
     *                             required if signature-based authentication is
     *                             used.
     * - <kbd>useLocalWsdl</kbd> - optional. When sepecified as true, a local
     *                             copy of the PayPal WSDL is used instead of
     *                             the copy hosted on PayPal's servers. This
     *                             can be used if PayPal breaks the hosted
     *                             WSDL files, as has happened in the past.
     *
     * @param array $options array of options.
     *
     * @throws InvalidArgumentException if neither a signature nor a
     *         certificate file is specified in the options array, or if the
     *         username or password options are not specified in the options
     *         array.
     */
    public function __construct(array $options)
    {
        $hasSignature   = false;
        $hasCertificate = false;

        foreach ($options as $key => $value) {
            switch ($key) {
            case 'mode':
                $this->setMode($value);
                break;

            case 'username':
                $this->setUsername($value);
                break;

            case 'password':
                $this->setPassword($value);
                break;

            case 'subject':
                $this->setSubject($value);
                break;

            case 'signature':
                $hasSignature = true;
                $this->setSignature($value);
                break;

            case 'certificate':
                $hasCertificate = true;
                $this->setCertificateFile($value);
                break;

            case 'useLocalWsdl':
                $this->useLocalWsdl = ($value) ? true : false;
                break;
            }
        }

        if (!$this->_username) {
            throw new InvalidArgumentException('A username is required.');
        }

        if (!$this->_password) {
            throw new InvalidArgumentException('A password is required.');
        }

        if (!$hasSignature && !$hasCertificate) {
            throw new InvalidArgumentException(
                'Either a signature or a local certificate file is required.');
        }

        // set appropriate API endpoint
        if ($this->_signature) {
            $this->soapOptions['location'] =
                self::$_apiEndpoints[$this->_mode]['signature'];
        } else {
            $this->soapOptions['location'] =
                self::$_apiEndpoints[$this->_mode]['certificate'];
        }
    }

    // }}}
    // {{{ call()

    /**
     * Makes a PayPal SOAP request
     *
     * If a structured array is used as the arguments, WSDL types with
     * attributes may be specified as:
     *
     * <code>
     * $arguments = array(
     *     'OrderTotal' => array(    // 'OrderTotal' is a type with attributes
     *         '_' => '1000.00',     // this is the element value
     *         'currencyID' => 'USD' // this is an attribute value
     *     )
     * );
     * </code>
     *
     * @param string $requestName the name of the request. This should be a
     *                            request documented in the PayPal SOAP API
     *                            reference manual. Sending a request of an
     *                            invalid type will cause a SoapFault to be
     *                            thrown.
     * @param mixed  $arguments   optional. Either a structured array or an
     *                            object representing the SOAP request
     *                            arguments. If the request requires no
     *                            arguments, this parameter may be ommitted.
     *
     * @return mixed the PayPal SOAP response. If only one value is returned
     *               for the request, a simple value (e.g. an integer, a
     *               string, etc) is returned. For requests that return multiple
     *               values or complex types, a data structure composed of
     *               stdClass objects is returned.
     *
     * @throws Payment_PayPal_SOAP_InvalidRequestNameException if the specified
     *         request name is not a valid PayPal SOAP API request name.
     *
     * @throws Payment_PayPal_SOAP_MissingPropertyException if a required
     *         property for a request type is not specified in the request
     *         arguments. Refer to the PayPal SOAP API documentation at
     *         {@link https://www.paypal.com/en_US/pdf/PP_APIReference.pdf} for
     *         information about required fields.
     *
     * @throws Payment_PayPal_SOAP_ErrorException if a SOAP response contains
     *         one or more Error elements. A detailed error message will be
     *         present in the exception message and the PayPal error code will
     *         be in the exception code.
     *
     * @throws Payment_PayPal_SOAP_FaultException if a SOAP initialization
     *         error occurs or an unknown SOAP error occurs.
     */
    public function call($requestName, $arguments = array())
    {
        $client = $this->getSoapClient();

        // Use a unique client. If an exception is thrown, state will be
        // preserved if subsequent requests are made.
        $client = clone $client;

        $headers = $this->getSoapHeaders();

        try {
            $response = $client->__soapCall(
                $requestName,
                array($arguments),
                null,
                $headers
            );

            if (isset($response->Errors)) {
                if (is_array($response->Errors)) {
                    $errors = $response->Errors;
                } else {
                    $errors = array($response->Errors);
                }

                $errorObjects = array();
                $messages     = array();
                $codes        = array();

                foreach ($errors as $error) {

                    $message = (isset($error->LongMessage))
                        ? $error->LongMessage
                        : $error->ShortMessage;

                    $messages[] = $message;

                    $code = intval($error->ErrorCode);
                    $codes[] = $code;

                    switch ($error->SeverityCode) {
                    case 'Warning':
                        $severity = Payment_PayPal_SOAP::ERROR_WARNING;
                        break;
                    case 'Error':
                        $severity = Payment_PayPal_SOAP::ERROR_ERROR;
                        break;
                    default:
                        $severity = Payment_PayPal_SOAP::ERROR_UNKNOWN;
                        break;
                    }

                    $expiredTokenExp = '/Token value is no longer valid\.$/';
                    if (preg_match($expiredTokenExp, $message) === 1) {
                        $type = Payment_PayPal_SOAP_Error::TYPE_EXPIRED_TOKEN;
                    } else {
                        $type = Payment_PayPal_SOAP_Error::TYPE_DEFAULT;
                    }

                    $errorObjects[] = new Payment_PayPal_SOAP_Error(
                        $message,
                        $code,
                        $severity,
                        $type
                    );

                }

                $exceptionMessage = sprintf(
                    "Error(s) present in PayPal SOAP response: %s\n" .
                    "Code(s): %s\n" .
                    "Username: %s\n",
                    implode(', ', $messages),
                    implode(', ', $codes),
                    $this->_username
                );

                if ($this->_subject) {
                    $exceptionMessage .= sprintf(
                        "Subject: %s\n",
                        $this->_subject
                    );
                }

                $errorException = new Payment_PayPal_SOAP_ErrorException(
                    $exceptionMessage,
                    0,
                    $response
                );

                foreach ($errorObjects as $error) {
                    $errorException->addError($error);
                }

                throw $errorException;
            }
        } catch (SoapFault $e) {
            $message = $e->getMessage();

            $badFunctionExp = '/^Function \(".*?"\) is not a valid method ' .
                'for this service$/';

            if (preg_match($badFunctionExp, $message) === 1) {
                throw new Payment_PayPal_SOAP_InvalidRequestNameException(
                    'Request name "' . $requestName . '" is not a valid ' .
                    'request name for the PayPal API.',
                    $e->getCode(), $requestName);
            }

            $badArgumentExp = '/^SOAP-ERROR: Encoding: object hasn\'t ' .
                '\'(.*?)\' property$/';

            $matches = array();
            if (preg_match($badArgumentExp, $message, $matches) === 1) {
                $propertyName = $matches[1];
                throw new Payment_PayPal_SOAP_MissingPropertyException(
                    'Arguments for "' . $requestName . '" request is missing ' .
                    'a "' . $propertyName . '" property. See the PayPal SOAP ' .
                    'API reference for details on required request properties.',
                    $e->getCode(), $propertyName);
            }

            // Unknown SOAP exception, pass it along.
            throw new Payment_PayPal_SOAP_FaultException('PayPal SOAP Error: ' .
                $e->getMessage(), $e->getCode(), $e, $client);
        }

        return $response;
    }

    // }}}
    // {{{ getLastRequest()

    /**
     * Gets the XML sent in the last SOAP request
     *
     * @return boolean|string the XML sent in the last SOAP request. If no
     *                        request has been performed, false is returned.
     */
    public function getLastRequest()
    {
        if ($this->soapClient === null) {
            $request = false;
        } else {
            $request = $this->soapClient->__getLastRequest();
        }

        return $request;
    }

    // }}}
    // {{{ getLastResponse()

    /**
     * Gets the XML returned in the last SOAP response
     *
     * @return boolean|string the XML used in the last SOAP response. If no
     *                        response has been retrieved, false is returned.
     */
    public function getLastResponse()
    {
        if ($this->soapClient === null) {
            $response = false;
        } else {
            $response = $this->soapClient->__getLastResponse();
        }

        return $response;
    }

    // }}}
    // {{{ getSoapHeaders()

    /**
     * Gets the SOAP headers required for PayPal authentication
     *
     * If the header doesn't exist, it is created and stored in the protected
     * property {@link PaymentPayPal_SOAP::$soapHeader}.
     *
     * This header is passed to all PayPal SOAP calls.
     *
     * @return SoapHeader the SOAP header required for PayPal authentication.
     *
     * @see Payment_PayPal_SOAP::call()
     * @see Payment_PayPal_SOAP::setUsername()
     * @see Payment_PayPal_SOAP::setPassword()
     * @see Payment_PayPal_SOAP::setSubject()
     * @see Payment_PayPal_SOAP::setSignature()
     */
    protected function getSoapHeaders()
    {
        if ($this->soapHeader === null) {
            $credentials = array(
                'Credentials' => array(
                    'Username'  => $this->_username,
                    'Password'  => $this->_password
                )
            );

            if ($this->_subject) {
                $credentials['Credentials']['Subject'] = $this->_subject;
            }

            if ($this->_signature) {
                $credentials['Credentials']['Signature'] = $this->_signature;
            }

            $this->soapHeader = new SoapHeader('urn:ebay:api:PayPalAPI',
                'RequesterCredentials', $credentials);
        }

        return $this->soapHeader;
    }

    // }}}
    // {{{ getSoapClient()

    /**
     * Gets the SOAP client used to make PayPal SOAP calls
     *
     * If the client doesn't exist, it is created and stored in the protected
     * property {@link PaymentPayPal_SOAP::$soapClient}.
     *
     * @return SoapClient the SOAP client used to make PayPal SOAP calls.
     *
     * @see Payment_PayPal_SOAP::call()
     * @see Payment_PayPal_SOAP::setSoapClient()
     */
    protected function getSoapClient()
    {
        if (!($this->soapClient instanceof SoapClient)) {
            $this->soapClient = new SoapClient(
                $this->getWsdlFile(),
                $this->soapOptions
            );
        }

        return $this->soapClient;
    }

    // }}}
    // {{{ setSoapClient()

    /**
     * Sets a SOAP client to use for SOAP requests
     *
     * This is useful for testing.
     *
     * @param SoapClient $client the SOAP client to use.
     *
     * @return Payment_PayPal_SOAP the current object, for fluent interface.
     */
    public function setSoapClient(SoapClient $client)
    {
        $this->soapClient = $client;
        return $this;
    }

    // }}}
    // {{{ setUsername()

    /**
     * Sets the API username used for authentication
     *
     * @param string $username the API username used for authentication.
     *
     * @return Payment_PayPal_SOAP the current object, for fluent interface.
     *
     * @see Payment_PayPal_SOAP::__construct()
     * @see Payment_PayPal_SOAP::$_username
     */
    protected function setUsername($username)
    {
        $this->_username = strval($username);
        return $this;
    }

    // }}}
    // {{{ setPassword()

    /**
     * Sets the API password used for authentication
     *
     * @param string $password the API password used for authentication.
     *
     * @return Payment_PayPal_SOAP the current object, for fluent interface.
     *
     * @see Payment_PayPal_SOAP::__construct()
     * @see Payment_PayPal_SOAP::$_password
     */
    protected function setPassword($password)
    {
        $this->_password = strval($password);
        return $this;
    }

    // }}}
    // {{{ setSignature()

    /**
     * Sets the API signature used for signature-based authentication
     *
     * @param string $signature the API signature used for signature-based
     *                          authentication.
     *
     * @return Payment_PayPal_SOAP the current object, for fluent interface.
     *
     * @see Payment_PayPal_SOAP::__construct()
     * @see Payment_PayPal_SOAP::$_signature
     */
    protected function setSignature($signature)
    {
        $this->_signature = strval($signature);
        return $this;
    }

    // }}}
    // {{{ setSubject()

    /**
     * Sets the subject used for making requests on behalf of a third-party
     *
     * For example, you may be running a marketplace where customers will
     * purchase goods directlry from your clients through your market. In this
     * case, you can use the client's PayPal email address as the subject to
     * initiate a checkout for the customer in your marketplace.
     *
     * @param string $subject the email address of the third-party. Your API
     *                        username may require explicit access be granted
     *                        from the third-party before certain API actions
     *                        will work.
     *
     * @return Payment_PayPal_SOAP the current object, for fluent interface.
     *
     * @see Payment_PayPal_SOAP::__construct()
     * @see Payment_PayPal_SOAP::$_subject
     */
    protected function setSubject($subject)
    {
        $this->_subject = strval($subject);
        return $this;
    }

    // }}}
    // {{{ setCertificateFile()

    /**
     * Sets the local certificate file used for certificate-based
     * authentication
     *
     * This file is downloaded from your API credentials page when logged into
     * your PayPal account.
     *
     * @param string $certificateFile the local certificate file used for
     *                                certificate-based authentication.
     *
     * @return Payment_PayPal_SOAP the current object, for fluent interface.
     *
     * @see Payment_PayPal_SOAP::__construct()
     * @see Payment_PayPal_SOAP::$soapOptions
     */
    protected function setCertificateFile($certificateFile)
    {
        $certificateFile = strval($certificateFile);
        if ($certificateFile) {
            $this->soapOptions['local_cert'] = $certificateFile;
        }
        return $this;
    }

    // }}}
    // {{{ setMode()

    /**
     * Sets the mode to use for API calls
     *
     * @param string $mode the mode to use for PayPal API calls. Valid modes
     *                     are:
     *                     - <kbd>sandbox</kbd> - for development and testing
     *                     - <kbd>live</kbd>    - for live payments.
     *
     * @return Payment_PayPal_SOAP the current object, for fluent interface.
     *
     * @throws Payment_PayPal_SOAP_InvalidModeException if an invalid mode is
     *         specified.
     *
     * @see Payment_PayPal_SOAP::__construct()
     */
    protected function setMode($mode)
    {
        $mode = strval($mode);

        $validModes = array('sandbox', 'live');
        if (!in_array($mode, $validModes)) {
            throw new Payment_PayPal_SOAP_InvalidModeException(
                'Mode "' . $mode . '" is invalid. Mode must be either ' .
                '"sandbox" or "live".', 0, $mode);
        }

        $this->_mode = $mode;

        return $this;
    }

    // }}}
    // {{{ getWsdlFile()

    /**
     * Gets the WSDL file to use when building the SOAP object
     *
     * @return string the WSDL file to use when building the SOAP object.
     */
    protected function getWsdlFile()
    {
        if ($this->useLocalWsdl) {
            $path = 'C:\php\pear\data/Payment_PayPal_SOAP/data/wsdl';
            if (substr($path, 0, 1) === '@') {
                $path = dirname(__FILE__) . '/../../data/wsdl';
            }

            switch ($this->_mode) {
            case 'live':
                $file = $path . '/live/PayPalSvc.wsdl';
                break;
            case 'sandbox':
            default:
                $file = $path . '/sandbox/PayPalSvc.wsdl';
                break;
            }
        } else {
            switch ($this->_mode) {
            case 'live':
                $file = 'https://www.paypal.com/wsdl/PayPalSvc.wsdl';
                break;
            case 'sandbox':
            default:
                $file = 'https://www.sandbox.paypal.com/wsdl/PayPalSvc.wsdl';
                break;
            }
        }

        return $file;
    }

    // }}}
}

?>
