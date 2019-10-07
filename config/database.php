/* ************************************************************************** */
/*                                                                            */
/*                                                        :::      ::::::::   */
/*   database.php                                       :+:      :+:    :+:   */
/*                                                    +:+ +:+         +:+     */
/*   By: guroux <guroux@student.42.fr>              +#+  +:+       +#+        */
/*                                                +#+#+#+#+#+   +#+           */
/*   Created: 2019/10/02 18:58:06 by guroux            #+#    #+#             */
/*   Updated: 2019/10/02 18:58:07 by guroux           ###   ########.fr       */
/*                                                                            */
/* ************************************************************************** */

<?php

$DB_DSN = 'mysql:host=localhost;dbname=camagru';
$DB_USER = 'camagru';
$DB_PASSWORD = '42';
$DB_OPT = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAME utf8');

?>