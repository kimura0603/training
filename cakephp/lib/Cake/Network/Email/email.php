<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 2.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

/**
 * This is email configuration file.
 *
 * Use it to configure email transports of CakePHP.
 *
 * Email configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * transport => The name of a supported transport; valid options are as follows:
 *  Mail - Send using PHP mail function
 *  Smtp - Send using SMTP
 *  Debug - Do not send the email, just return the result
 *
 * You can add custom transports (or override existing transports) by adding the
 * appropriate file to app/Network/Email. Transports should be named 'YourTransport.php',
 * where 'Your' is the name of the transport.
 *
 * from =>
 * The origin email. See CakeEmail::from() about the valid values
 */
class EmailConfig {

	public $default = array(
		'transport' => 'Mail',
		'from' => 'you@localhost',
		//'charset' => 'utf-8',
		//'headerCharset' => 'utf-8',
	);

	public $smtp = array(
		'transport' => 'Smtp',
		'from' => array('site@localhost' => 'My Site'),
		'host' => 'localhost',
		'port' => 25,
		'timeout' => 30,
		'username' => 'user',
		'password' => 'secret',
		'client' => null,
		'log' => false,
		//'charset' => 'utf-8',
		//'headerCharset' => 'utf-8',
	);

	public $fast = array(
		'from' => 'you@localhost',
		'sender' => null,
		'to' => null,
		'cc' => null,
		'bcc' => null,
		'replyTo' => null,
		'readReceipt' => null,
		'returnPath' => null,
		'messageId' => true,
		'subject' => null,
		'message' => null,
		'headers' => null,
		'viewRender' => null,
		'template' => false,
		'layout' => false,
		'viewVars' => null,
		'attachments' => null,
		'emailFormat' => null,
		'transport' => 'Smtp',
		'host' => 'localhost',
		'port' => 25,
		'timeout' => 30,
		'username' => 'user',
		'password' => 'secret',
		'client' => null,
		'log' => true,
		//'charset' => 'utf-8',
		//'headerCharset' => 'utf-8',
	);

	// Gmailの設定を追加
	public $gmail = array(
		'host' => 'ssl://smtp.gmail.com',
		'port' => 465,
		'username' => 'funteam.kimuratest@gmail.com', // ユーザ名
		'password' => 'kimurakimura',           // パスワード
		'transport' => 'Smtp',
                'timeout' => 30
	);

        public $gmail2 = array(
                'host' => 'ssl://smtp.gmail.com',
                //'host' => 'nrt12s12-in-f14.1e100.net',
                'port' => 465,
                'username' => 'funteam.kimuratest@gmail.com', // ユーザ名
                'password' => 'kimurakimura',           // パスワード
                'transport' => 'Smtp',
                'timeout' => 30
        );

				public $fast2 = array(
					'from' => 'funteam.kimuratest@gmail.com',
					'sender' => null,
					'cc' => null,
					'bcc' => null,
					'replyTo' => null,
					'readReceipt' => null,
					'returnPath' => null,
					'messageId' => true,
					'subject' => null,
					'message' => null,
					'headers' => null,
					'viewRender' => null,
					'template' => false,
					'layout' => false,
					'viewVars' => null,
					'attachments' => null,
					'emailFormat' => null,
					'transport' => 'Smtp',
					'host' => 'ssl://smtp.gmail.com',
					'port' => 465,
					'timeout' => 30,
					'username' => 'funteam.kimuratest@gmail.com',
					'password' => 'kimurakimura',
					'client' => null,
					'log' => true,
					//'charset' => 'utf-8',
					//'headerCharset' => 'utf-8',
				);

        public $servername = array(
                'host' => 'nrt12s12-in-f14.1e100.net',
                'port' => 465,
                'username' => 'funteam.kimuratest@gmail.com', // ユーザ名
                'password' => 'kimurakimura',           // パスワード
                'transport' => 'Smtp',
                'timeout' => 30
        );
}
