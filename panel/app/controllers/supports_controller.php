<?php
/*Panel-GZW is a web hosting panel for Unix/Linux platforms.
Copyright (C) 2005 - 2011  GoldZone Web - gaetan.trellu@goldzoneweb.info

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

class SupportsController extends AppController {

	/**
	 * Controller Name
	 * @access public
	 * @var string
	 */
	var $name = 'Supports';

	/**
	 * The "support" controller use the "support" model.
	 * There is no table "support" in the database.
	 * @var array
	 */
	var $uses = 'Support';

	/**
	 * Helpers that are used in this controller
	 * @access public
	 * @var array
	 */
	var $helpers = array('Html', 'Form', 'Javascript');

	/**
	 * Components that are used in this controller
	 * @access public
	 * @var array
	 */
	var $components = array('Email', 'Session');

	/**
	 * This function display a contact form.
	 */
	function index() {

		if (isset($this->data)) {

			$this->Support->create($this->data);

			/**
			 * There is no save(), so we need to validate manually.
			 */ 
			if ($this->Support->validates()) {

				/**
				 * Support address.
				 */
				$this->Email->to = $this->data['Support']['email'];

				/**
				 * ReplyTo address.
				 */
				$this->Email->replyTo = $this->data['Support']['emailUser'];

				/**
				 * Email sender.
				 */
				$this->Email->from = $this->data['Support']['gzwId'] . ' <' . $this->data['Support']['emailUser'] . '>';

				/**
				 * Email subject.
				 */
				$this->Email->subject = $this->data['Support']['subject'];

				/**
				 * We used the "simple_message" template.
				 * The templates are in views/layout/email/
				 */
				$this->Email->template = 'simple_message';

				/**
				 * Choose which templates that it will be used.
				 * 'html' = HTML template
				 * 'text" = TEXT template
				 * 'both' = HTML and TEXT templates
				 */
    			$this->Email->sendAs = 'html';

    			/**
				 * Put the member name in "name".
				 * $name will be available in the email template.
				 */
    			$this->set('name', $this->data['Support']['name']);

    			/**
				 * Put the email subject in "subject".
				 * $subject will be available in the email template.
				 */
    			$this->set('subject', $this->data['Support']['subject']);
   
    			/**
				 * Put the email message in "message".
				 * $message will be available in the email template.
				 */
    			$this->set('message', $this->data['Support']['message']);
 
    			/**
    			 * Send the email.
    			 */
				if ($this->Email->send()) {

					/**
					 * If the email is sent, a success message is displayed.
					 * Redirect to the index page.
					 */
					$this->Session->setFlash(__d('core', 'The message has been sent.', true));
					$this->redirect(array('action' => 'index'));

				} else {
					/**
					 * If the email is not sent, an error message is displayed.
					 */
					$this->Session->setFlash(__d('core', 'The message has not been sent.', true), 'default', array('class' => 'error'));
				}
			}
			else {
				/**
				 * If the email is not sent, an error message is displayed.
				 */
				$this->Session->setFlash(__d('core', 'The message has not been sent.', true), 'default', array('class' => 'error'));
			}
		}

	}

}

?>