<?php
/*
Plugin Name: WP Sheridan Password Generator
Plugin URI: http://www.sheridaninternet.co.uk
Description: Allows for a random password generator to be embedded in to your pages with a shortcode
Version: 1.02
Author: Sheridan Internet
Author URI: http://www.sheridaninternet.co.uk/
WordPress version support: 3.0 and above
*/

/*
 * Copyright 2013 Sheridan Internet (email: sam@sheridaninternet.com)
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the license or
 * later.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, 5 Floor, Boston, MA 02110-1301,
 * USA.
 */

    /* Include generation class */
    require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "classes" . DIRECTORY_SEPARATOR . "class.password.php");


    /**
    * Wordpress plugin wrapper for password generation class
    */
    class wpSheridanPasswordGenerator {
        protected $pluginPath;
        protected $pluginUrl;

        protected $showPhonetics = false;

        /**
         * Constructor, setup plugin path and url, add shortcode.
         */
        public function __construct()
        {

            /* set plugin path */
            $this->pluginPath = dirname(__FILE__);

            /* set plugin url */
            $this->pluginUrl = WP_PLUGIN_URL . '/sheridan-password-generator';

            /* Added short code */
            add_shortcode('password_generator', array($this, 'shortcode'));
            add_filter('widget_text', 'do_shortcode');
        }

        /**
         * Generate passwords, checks the $_POST superglobal for user submitted options and returns an
         * array of passwords based on those options.
         * @return array list of passwords
         */
        public function generatePasswords()
        {
            $pg = new sheridanPasswordGenerator();
            if (isset($_POST['lowercase'])) $pg->useLowercase(true);
            if (isset($_POST['uppercase'])) $pg->useUppercase(true);
            if (isset($_POST['numerics'])) $pg->useNumeric(true);
            if (isset($_POST['specialchars'])) $pg->useSpecial(true);

            if (isset($_POST['quantity'])) $pg->passwords(intval($_POST['quantity']));
            if (isset($_POST['length'])) $pg->setLength(intval($_POST['length']));
            if (isset($_POST['phonetics'])) $this->showPhonetics = true; else  $this->$showPhonetics = false;
            if (isset($_POST['similar'])) $pg->useSimilar(true); else $pg->useSimilar(false);
            $passwords = $pg->generate();
            return ($passwords);
        }

        /* Produce output when shortcode is found */
        public function shortcode()
        {
            $html = "";
            if (empty($_POST))
            {
                /* No post vars so display options form */
                $formUrl = 'http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
                $html .= file_get_contents($this->pluginPath . DIRECTORY_SEPARATOR . 'html' . DIRECTORY_SEPARATOR . 'form.html');
                $html = str_replace('SHERIDAN_FORM_URL', $formUrl, $html);
            }
            else
            {
                /* Otherwise if post variables found, generate passwords */
                $passwords = $this->generatePasswords();

                /* if passwords generated, return the html */
                if ($passwords)
                {
                    $html .= '<p>We have successfully created the password(s), please keep a copy in a safe place as they can not be recreated. </p>';
                    $html .= '<div id="passwordList"><table style="display: block; width: 100%; padding: 5px;">';
                    $html .= '<tr style="font-weight: bold"><td style="padding: 5px;">Passwords</td>';
                    if ($this->showPhonetics) $html .= '<td style="padding: 5px">Phonetic Pronunciation</td>';
                    $html .= '</tr>';

                    foreach ($passwords as $password)
                    {
                            $html .= '<tr>';
                            $html .= '<td style="padding: 5px; ">' . $password['password'] . '</td>';
                            if ($this->showPhonetics)
                            {
                                    $html .= '<td style="padding: 5px; padding-left: 15px;">(' . $password['phonetic'] . ')</td>';
                            }
                            $html .= '</tr>';
                    }
                    $html .= '</table></div>';
                }
                else
                {
                    $html = "An error ocurred generating the passwords";
                }
            }
            return $html;
        }
    }

    /* Instantiate class */
    $wpSheridanPasswordGenerator = new wpSheridanPasswordGenerator();
