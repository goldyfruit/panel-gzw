<?php
/**
 * @desc simple shell for generating and storing a user's md5 credentials
 * @tutorial add hash.php to app/vendors/shells and run /cake/console/cake hash
 * @author joshskeen josh@joshskeen.com
 *
 */
class PasswordShell extends Shell {

    function main() {
    
		$length = 10;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$string = '';

		for ($p = 0; $p < $length; $p++) {
			@$string .= $characters[mt_rand(0, strlen($characters))];
		}
   

        App::import('Component','Auth');
        $this->Auth = new AuthComponent(null);

        $hash = $this->Auth->password($string);

        $this->out('HASH ' . $hash);
        $this->out('NOHASH ' . $string);

    }

}