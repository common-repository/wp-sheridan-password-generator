<?php
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
    /**
     * Password generation class
     */
    class sheridanPasswordGenerator
	{
        /**
         * Length of password string to generate
         * @var int
         */
        private $length = 8;

        /**
         * Bit offset for checking to output lowercase
         * @var int
         */
        private $opt_lowercase = 1;

        /**
         * Bit offset for checking to output uppercase
         * @var int
         */
        private $opt_uppercase = 2;

        /**
         * Bit offset for checking to output numeric
         * @var int
         */
        private $opt_numericch = 4;

        /**
         * Bit offset for checking to output special chars
         * @var int
         */
        private $opt_specialch = 8;

        /**
         * Password stength identifier
         * @var int
         */
        var $strength = 0;

        /**
         * Number of passwords to generate
         * @var int
         */
        var $quantity = 1;

        /**
         * Omit disallowed characters
         * @var bool
         */
        var $disallowed = false;

        /**
         * Similar characters to ignore
         * @var string
         */
        var $disallowedChars = "io1l0IOL";

        /**
         * Identifies if an error has occurred
         * @var bool
         */
        var $error = false;

        /**
         * Any error messages if applicable
         * @var string|null
         */
        var $errorMsg = null;

        /**
         * Debug option, set to true to enable debuggimg
         * @var bool
         */
        var $debug = false;

		/**
		 * Specifies whether password should include lowercase chars
		 *
		 * @param bool $use_lowercase
		 */
		function useLowercase($use_lowercase = false)
		{
				if ($use_lowercase)
				{
					$this->strength = ($this->strength | $this->opt_lowercase);
				}
				else 
				{
					$this->strength = ($this->strength &~ $this->opt_lowercase);
				}
		}
		
		/**
		 * Specifies whether password should include uppercase chars
		 *
		 * @param bool $use_uppercase
		 */
		function useUppercase($use_uppercase = false)
		{
				if ($use_uppercase)
				{
					$this->strength = ($this->strength | $this->opt_uppercase);
				}
				else 
				{
					$this->strength = ($this->strength &~ $this->opt_uppercase);
				}
		}

		/**
		 * Specifies whether password should include numeric chars
		 *
		 * @param bool $use_uppercase
		 */
		function useNumeric($use_numeric = false)
		{
				if ($use_numeric)
				{
					$this->strength = ($this->strength | $this->opt_numericch);
				}
				else 
				{
					$this->strength = ($this->strength &~ $this->opt_numericch);
				}
		}
		
		/**
		 * Specifies whether password should include special chars
		 *
		 * @param bool $use_special
		 */
		function useSpecial($use_special = false)
		{
				if ($use_special)
				{
					$this->strength = ($this->strength | $this->opt_specialch);
				}
				else 
				{
					$this->strength = ($this->strength &~ $this->opt_specialch);
				}
		}
		
		function useSimilar($use_similar = false)
		{
			$this->disallowed = (bool)$use_similar;
		}

        /**
         * Specify number of passwords to generate
         * @param int $number the number of passwords to generate
         */
        function passwords($number)
		{
			$this->quantity = intval($number);
		}

        /**
         * Sets the length of the passwords to generate
         * @param int $length The length of the password
         */
        function setLength($length)
		{
			$this->length = intval($length);
			if ($this->length > 64) $this->length=64;
			if ($this->length < 6) $this->length=6;
		}

        /**
         * Generate lowercase char
         * @return string
         */
        function lower()
		{
			return chr(rand(0x61,0x79));
		}

        /**
         * Generate uppercase character
         * @return string
         */
        function upper()
		{
			return chr(rand(0x41,0x5a));
		}

        /**
         * Generate numeric character
         * @return string
         */
        function numeric()
		{
			return chr(rand(0x30,0x39));
		}

        /**
         * Generate special characters
         * @return mixed
         */
        function special()
		{
			$chars = '!#$%*+,-.:;=?@_';
			return ($chars[rand(0,strlen($chars)-1)]);
		}

        /**
         * Returns the phonetic values of the character
         * @param string $char The character to retrieve the phonetic value (e.g. A)
         * @return string
         */
        function phonetic($char)
		{
			switch ($char)
			{
				case 'a' : return 'alpha'; break;
				case 'b' : return 'bravo'; break;
				case 'c' : return 'charlie'; break;
				case 'd' : return 'delta'; break;
				case 'e' : return 'echo'; break;
				case 'f' : return 'foxtrot'; break;
				case 'g' : return 'golf'; break;
				case 'h' : return 'hotel'; break;
				case 'i' : return 'india'; break;
				case 'j' : return 'juliet'; break;
				case 'k' : return 'kilo'; break; 
				case 'l' : return 'lima'; break;
				case 'm' : return 'mike'; break;
				case 'n' : return 'november'; break;
				case 'o' : return 'oscar'; break;
				case 'p' : return 'papa'; break;
				case 'q' : return 'quebec'; break;
				case 'r' : return 'romeo'; break;
				case 's' : return 'sierra'; break;
				case 't' : return 'tango'; break;
				case 'u' : return 'uniform'; break;
				case 'v' : return 'victor'; break;
				case 'w' : return 'whisky'; break;
				case 'x' : return 'x-ray'; break;
				case 'y' : return 'yankee'; break;
				case 'z' : return 'zulu'; break;
				
				case 'A' : return 'ALPHA'; break;
				case 'B' : return 'BRAVO'; break;
				case 'C' : return 'CHARLIE'; break;
				case 'D' : return 'DELTA'; break;
				case 'E' : return 'ECHO'; break;
				case 'F' : return 'FOXTROT'; break;
				case 'G' : return 'GOLF'; break;
				case 'H' : return 'HOTEL'; break;
				case 'I' : return 'INDIA'; break;
				case 'J' : return 'JULIET'; break;
				case 'K' : return 'KILO'; break;
				case 'L' : return 'LIMA'; break;
				case 'M' : return 'MIKE'; break;
				case 'N' : return 'NOVEMBER'; break;
				case 'O' : return 'OSCAR'; break;
				case 'P' : return 'PAPA'; break;
				case 'Q' : return 'QUEBEC'; break;
				case 'R' : return 'ROMEO'; break;
				case 'S' : return 'SIERRA'; break;
				case 'T' : return 'TANGO'; break;
				case 'U' : return 'UNIFORM'; break;
				case 'V' : return 'VICTOR'; break;
				case 'W' : return 'WHISKY'; break;
				case 'X' : return 'X-RAY'; break;
				case 'Y' : return 'YANKEE'; break;
				case 'Z' : return 'ZULU'; break;
				
				case '0' : return 'Zero'; break;
				case '1' : return 'One'; break;
				case '2' : return 'Two'; break;
				case '3' : return 'Three'; break;
				case '4' : return 'Four'; break;
				case '5' : return 'Five'; break;
				case '6' : return 'Six'; break;
				case '7' : return 'Seven'; break;
				case '8' : return 'Eight'; break;
				case '9' : return 'Nine'; break;
				
				case '!' : return 'Exclamation'; break;
				case '"' : return 'Speechmark'; break;
				case '$' : return 'Dollar'; break;				
				case '%' : return 'Percent'; break;				
				case '&' : return 'Ampersand'; break;			
				case '\\' : return 'Backslash'; break;	
				case chr(0x27) : return 'Apostrophe'; break;				
				case '(' : return 'Open Bracket'; break;				
				case ')' : return 'Close Bracket'; break;				
				case '*' : return 'Asterisk'; break;				
				case '+' : return 'Plus'; break;		
				case '#' : return 'Hash'; break;			
				case ',' : return 'Comma'; break;				
				case '-' : return 'Minus'; break;				
				case '.' : return 'Period'; break;				
				
				case ':' : return 'Colon'; break;
				case ';' : return 'Semicolon'; break;
				case '<' : return 'Less Than'; break;
				case '=' : return 'Equals'; break;
				case '>' : return 'Greater Than'; break;
				case chr(0x3f) : return 'Question'; break;
				case '@' : return 'At'; break;
				case '_' : return 'Underscore'; break;
                case '?' : return 'Question'; break;
			}
            return null;
		}

        /**
         * Determine if character has readable phonetic if not produce -
         * @param $str
         * @return string
         */
        function readable($str)
		{
			$readable_string = "";
			
			for ($i=0; $i<strlen($str); $i++)
			{
				$readable_string .= $this->phonetic($str[$i]);
				if ($i != strlen($str)-1)
				{
					$readable_string .= " - ";
				}
			}
			return ($readable_string);
		}

        /**
         * Generate routine
         * @return array
         */
        function generate()
		{
			$pass="";
			$charFunctions = array();
			$passwords = array();
			$passwordList = array();
			$phonetics = array();
			
			if ($this->strength & $this->opt_lowercase) 
			{
				$charFunctions[] = "lower";
			}
			if ($this->strength & $this->opt_uppercase) 
			{
				$charFunctions[] = "upper";
			}
			if ($this->strength & $this->opt_numericch) 
			{
				$charFunctions[] = "numeric";
			}
			if ($this->strength & $this->opt_specialch) 
			{
				$charFunctions[] = "special";	
			}
			
			$options = count($charFunctions);		
			if ($this->debug)
			{
				echo "Using " . ($options) . " character generation functions:";
				echo "<pre>"; print_r($charFunctions); echo "</pre>";
				
			}
			
			if ($options <=0) return;
			for ($n=0; $n<$this->quantity; $n++)
			{
				$pass = null;
				for ($i=0; $i<$this->length; $i++)
				{
					$charFunction = $charFunctions[rand(0,$options-1)];
					$char = $this->$charFunction();
					if ($this->disallowed)
					{
						while (strpos($this->disallowedChars, $char))
						{
							$char = $this->$charFunction();
						}
					}
					$pass .= $char;
				}
			
				$passwordList[] = array('password' => $pass, 'phonetic' => $this->readable($pass));
			}
			return ($passwordList);
		}
	}
?>
