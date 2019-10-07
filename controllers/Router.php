/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   Router.php                                         :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: guroux <guroux@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/10/02 18:05:20 by guroux            #+#    #+#             */
/*   Updated: 2019/10/02 18:19:26 by guroux           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

<?php

class Router
{
	private $_ctrl;
	private $_view;

	public function routeReq()
	{
		try
		{
			spl_autoload_register(function($class) {
				require_once('models/'.$class.'.php');
			});

			$url = '';

			if (isset($_GET['url']))
			{
				$url = explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));

				$controller = ucfirst(strtolower($url[0]));
				$controllerClass = 'Controller'.$controller;
				$controllerFile = 'controllers/'.$controllerClass.'.php';
				
				if (file_exists($controllerFile))
				{
					require_once($controllerFile);
					$this->_ctrl = new $controllerClass($url);
				}
				else
					throw new Exeption('Page introuvable');
			}
			else
			{
				require_once('controllers/ControllerAccueil.php');
				$this->_ctrl = new ControllerAcceuil($url);
			}
		}
		catch(Exeption $e)
		{
			$errMsg = $e->getMessage();
			require_once('views/viewErr.php');
		}
	}
}

?>