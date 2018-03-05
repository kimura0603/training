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
 * @package       app.View.Emails.text
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>

<?php echo $name;?>様

お問い合わせ頂き誠にありがとうございました。
お問い合わせ内容を確認させていただき、後ほど担当者よりご回答をさせていただきます。
恐れ入りますが、今しばらくお待ちいただけますよう、宜しくお願い申し上げます。

====================
お問い合わせ内容
====================
Name:<?php echo $name. "\n";?>
Department:<?php echo $department. "\n";?>
Company:<?php echo $company. "\n";?>
Email:<?php echo $email. "\n";?>
Message:<?php echo $message. "\n";?>




