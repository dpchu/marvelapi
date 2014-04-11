<?php

class Marvel{
	
	function __construct()
	{
		$this->baseUrl = "http://gateway.marvel.com/";
		$this->version = "v1/public/";
	}
	
	private function _curlMarvel($urlDir,$urlParams = array())
	{
		$ch = curl_init();
		
		$pubKey = "your public key";
		$privKey = "your private key";
		$tStamp = time();
		
		$hash = md5($tStamp.$privKey.$pubKey);
		
		$mUrl = array(
			'ts' => $tStamp,
			'apikey' => $pubKey,
			'hash' => $hash,
			);
		$mParams = http_build_query($mUrl);
		$finalParams = http_build_query($urlParams);
		//final url w/ params
		$finalUrl = $this->baseUrl.$urlDir."?".$mParams."&".$finalParams;
		
		curl_setopt($ch,CURLOPT_URL,$finalUrl);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($ch);
		$info = curl_getinfo($ch);
		
		return json_decode($response);
	}
	
	function characters($charactersArray = array())
	{	/*	finds data based on character
			name = string
			nameStartsWith = string
			modifiedSince = date (YYYY-DD-MM)
			comics = int (wants ID's, separate with commas)
			series = int (wants ID's, separate with commas)
			events = int (wants ID's, separate with commas)
			stories = int (wants ID's, separate with commas)
			orderBy = string ("name" or "modified") precede with "-" for Desc.
			limit = int
			offset = int
		*/
		return $this->_curlMarvel($this->version."characters",$charactersArray);
	}
	function creators($creatorsArray = array())
	{	/*	finds data based on creators
		
			firstName = string
			middleName = string
			lastName = string
			suffix = string
			nameStartsWith = string
			firstNameStartsWith = string
			middleNameStartsWith = string
			lastNameStartsWith = string
			modifiedSince = date (YYYY-DD-MM)
			comics = int (wants ID's, separate with commas)
			series = int (wants ID's, separate with commas)
			events = int (wants ID's, separate with commas)
			stories = int (wants ID's, separate with commas)
			orderBy = any of the above strings (firstName to suffix) precede with "-" for Desc.
			limit = int
			offset = int
		*/
		return $this->_curlMarvel($this->version."creators",$creatorsArray);
	}
	function events($eventsArray = array())
	{	/* finds data based on events
			name = string
			nameStartsWith = string
			modifiedSince = date (YYYY-DD-MM)
			creators = int (wants ID's, separate with commas)
			characters = int (wants ID's, separate with commas)
			series = int (wants ID's, separate with commas)
			comics = int (wants ID's, separate with commas)
			stories = int (wants ID's, separate with commas)
			orderBy = string ("name", "startDate", or "modified"), precede with "-" for Desc.
			limit = int
			offset = int
		*/
		return $this->_curlMarvel($this->version."events",$eventsArray);
	}
	function series($seriesArray = array())
	{	/* finds data based on series
			title = string
			titleStartsWith = string
			startYear = int
			modifiedSince = date (YYYY-DD-MM)
			comics = int (wants ID's, separate with commas)
			stories = int (wants ID's, separate with commas)
			events = int (wants ID's, separate with commas)
			creators = int (wants ID's, separate with commas)
			characters = int (wants ID's, separate with commas)
			seriesType = string ("collection","one shot","limited", or "ongoing")
			contains = string ("comic","magazine","trade paperback","hardcover","digest",
					"graphic novel","digital comic", or "infinite comic")
			orderBy = string ("title","modified", or "startYear") precede with "-" for Desc
			limit = int
			offset = int
		*/
		return $this->_curlMarvel($this->version."series",$seriesArray);
	}
	function stories($storiesArray  = array())
	{	/* finds data based on stories
			modifiedSince = date (YYYY-DD-MM)
			comics = int (wants ID's, separate with commas)
			series = int (wants ID's, separate with commas)
			events = int (wants ID's, separate with commas)
			creators = int (wants ID's, separate with commas)
			characters = int (wants ID's, separate with commas)
			orderBy = string ("id" or "modified") preced with "-" for Desc
			limit = int
			offset = int
		*/
		return $this->_curlMarvel($this->version."stories",$storiesArray);
	}
}