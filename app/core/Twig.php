<?php

class Twig {

	protected $_registry = NULL;


	public function __construct($registry) {
		$this->_registry = $registry;

		// TEMPLATE ENGINE
		$TwigLoader = new Twig_Loader_Filesystem(ABS_PATH.'/themes/'.$this->_registry->get('config')->get('app_theme'));

		// HANDLE TWIG DEBUG
		if ( $this->_registry->get('config')->get('twig_debug') === true ):
			$this->_registry->set('twig', new Twig_Environment($TwigLoader, array('debug' => true)));
			$this->_registry->get('twig')->addExtension(new Twig_Extension_Debug());
		else:
			$this->_registry->set('twig', new Twig_Environment($TwigLoader));
		endif;
	}
}

?>