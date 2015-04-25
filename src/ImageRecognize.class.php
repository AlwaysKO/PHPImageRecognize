<?php

class ImageRecognize {

	/**
	* The source path of the image
	*/
	private $imgpath;

	/**
	* The information of the new image which has been clear
	*/
	public $imgsize;

	/**
	* The index of the width which is in the result value of the build-in function getimagesize
	*/
	const IMG_WIDTH = 0;

	/**
	* The index of the height which is in the result value of the build-in function getimagesize
	*/
	const IMG_HEIGHT = 1;

	/**
	* The x-offset of the first word
	*/
	const OFFSET_X = 8;

	/*
	* The f-offset of the words
	*/
	const OFFSET_Y = 2;

	/**
	* The max width of the word
	*/
	const WORD_WIDTH = 16;
	
	/**
	* The max height of the word
	*/
	const WORD_HEIGHT = 17;

	/**
	* The distance of the each of word
	*/
	const WORD_DISTANCE = 0;

	/**
	* The references table of the words
	*/
	const REFERENCES_WORDS = [
		'0',
		'1',
		'2',
		'3',
		'4',
		'5',
		'6',
		'7',
		'8' => '000011110000000000111111000000001110011100000001110011100000001110011100000000111111000000000111111000000001110011100000001110011100000001110011100000000111111000000000011110000000000000000000000000000000000000000000000000000',
		'9',
		'a',
		'b',
		'c',
		'd',
		'e',
		'f',
		'g',
		'h',
		'i',
		'j',
		'k',
		'l',
		'm' => '000000000000000000000000000000000000000000000001110111001110001111111111111001110011100111001110011100111001110011100111001110011100111001110011100111001110011100111001110011100111000000000000000000000000000000000000000000000',
		'n',
		'o',
		'p',
		'q',
		'r',
		's',
		't',
		'u',
		'v',
		'w' => '000000000000000000000000000000000000000000000000011100011100011100111001110011100011100111001110001110011100111000011011011011000001111101111100000111100011110000001110001110000000110000011000000000000000000000000000000000000000000000000000',
		'x',
		'y',
		'z'
	];

	/**
	* Pass throught the source image to the instance
	*/
	public function __construct($imgpath) {
		$this->imgpath = $imgpath;
	}

	/**
	* Recognizing the source image
	*
	* @return the string of the verification code which in the image
	*/
	public function recognize() {
		$res = $this->imgclean();
		// Setting the information for the new image
		$this->imgsize = getimagesize($dest);

		$dataArray = $this->imgbinary($res);
	}

	/**
	* Clear the border of the image
	*
	* @param $border Specify the size of the border
	* @return The new image data
	*/
	public function imgclean($border = 1) {
		$dec = $border + 1;

		// Give the information of the source image
		$size = getimagesize($this->imgpath);
		$res = imagecreatefromjpeg($this->imgpath);
		// Create the new image without the border
		$dest = imagecreatetruecolor($size[self::IMG_WIDTH] - $dec, $size[self::IMG_HEIGHT] - $dec);
		imagecopy($dest, $res, 0, 0, $border, $border, $size[self::IMG_WIDTH] - $dec, $size[self::IMG_HEIGHT] - $dec);

		imagedestroy($res);

		return $dest;
	}

	/**
	* Clear the background color and the interferential pixel of the image
	*
	* @return the two-dimension array data which has the filter data
	*/
	public function imgbinary($image) {
		$data = [];
		for($i = 0; $i < $this->imgsize[self::IMG_HEIGHT]; ++$i)
		{
			for($j = 0; $j < $this->imgsize[self::IMG_WIDTH]; ++$j)
			{
				$rgb = imagecolorat($image, $j, $i);
				$rgbarray = imagecolorsforindex($image, $rgb);

				if($rgbarray['red'] > 200 || $rgbarray['green'] > 200 || $rgbarray['blue'] > 200)
				{
					$data[$i][$j] = 0;
				} else {
					$data[$i][$j] = 1;
				}
			}
		}

		// Clear the interferential pixel
		for($i = 0; $i < $this->imgsize[self::IMG_HEIGHT]; ++$i)
		{
			for($j = 0; $j < $this->imgsize[self::IMG_WIDTH]; ++$j)
			{
				$channel = 0;
				if ($data[$i][$j] == 1) {
				 	// Top
				 	if(isset($data[$i - 1][$j])){
						$channel = $channel + $data[$i - 1][$j];
					}
					// Bottom
					if(isset($data[$i + 1][$j])){
						$channel = $channel + $data[$i + 1][$j];
					}
					// Left
					if(isset($data[$i][$j - 1])){
						$channel = $channel + $data[$i][$j - 1];
					}
					// Right
					if(isset($data[$i][$j + 1])){
						$channel = $channel + $data[$i][$j + 1];
					}
					if($channel == 0){
						$data[$i][$j] = 0;
					}
				}
			}
		}

		return $data;
	}


	/**
	* Find out the each of the element in the filter data
	*/
	public function imgmatch() {

	}

}