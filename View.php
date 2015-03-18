<?php
	/****/
	class View
	{

		private $file;

		public function __construct($file){
			$this->setFile($file);
		}

		public function setFile($file){
			$this->file = $file;
		}

		public function getFile(){
			return $this->file;
		}

		public function render($data){
			$callback = function ($matches) use($data){
				$words = explode(".", $matches[1]);

				foreach($words as $word)
					if(is_array($data)){
						$data = array_key_exists($word, $data) ? $data[$word] : "";
					}
					else{
						return "";
					}
				return $data;
			};

			return preg_replace_callback("/\{\{((?:[a-zA-Z]+)(?:\.(?:[a-zA-Z]+))*)\}\}/",$callback,file_get_contents($this->file));
		}
		
		public function renderList ( $list ) {			
			$code = '';
			foreach ( $list as $item )
				$code .= $this->render($item);
			return $code;			
		}
		
	}
?>