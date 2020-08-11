<?php
	class Session{
		public static function init(){
		if (version_compare(phpversion(), '5.4.0', '<')) {
				if (session_id() == '') {
					session_start();
				}
			} else {
				if (session_status() == PHP_SESSION_NONE) {
					session_start();
				}
			}
		}

		public static function set($key, $val){
		  $_SESSION[$key] = $val;
		}

		 public static function get($key){
			if (isset($_SESSION[$key])) {
			    return $_SESSION[$key];
			} 
			else {
			    return false;
			}
		}

		public static function checkAdminSession(){
		    self::init();
			if (self::get("adminLogin")!= true) {
			     self::destroy();
			     header("Location: login.php");
			} 
		}

		public static function checkAdminLogin(){
		  self::init();
			if (self::get("adminLogin")== true) {
			   header("Location: dashboard.php");
			}
		}
		
		public static function checkUserLogin(){
		  self::init();
			if (self::get("usrlgn")== true) {
			   header("Location: dashboard.php");
			}
		}
		public static function checkUserSession(){
		    self::init();
			if (self::get("usrlgn")!= true) {
			     self::destroy();
			     header('Location: sign_in.php');
			} 
		}

		public static function destroy(){
		     session_destroy();
		     header("Location: sign_in.php");
		}		
		
	}