<?php
// Ajout des tables pour la MAJ
$db = ConnectionManager::getDataSource('default');
/*
// 0.2
$verif_02 = $db->query('SHOW COLUMNS FROM items;');
$execute_02 = true;
foreach ($verif_02 as $k => $v) {
  	if($v['COLUMNS']['Field'] == 'timedCommand') {
		$execute_02 = false;
		break;
	}
}
if($execute_02) {
	$db->query('ALTER TABLE `items` ADD `timedCommand` int(1) NOT NULL DEFAULT \'0\';');
	$db->query('ALTER TABLE `items` ADD `timedCommand_cmd` text;');
	$db->query('ALTER TABLE `items` ADD `timedCommand_time` int(11) DEFAULT NULL;');
	$db->query('ALTER TABLE `items` ADD `servers` text DEFAULT NULL;');
}

// 0.3
$verif_03 = $db->query('SHOW COLUMNS FROM vouchers;');
$execute_03 = true;
foreach ($verif_03 as $k => $v) {
  	if($v['COLUMNS']['Field'] == 'used') {
		$execute_03 = false;
		break;
	}
}
if($execute_03) {
	$db->query('ALTER TABLE `vouchers` ADD `used` text;');
}

// 0.3.1
$verif_03_1 = $db->query('SELECT * FROM vouchers;');
if(!empty($verif_03_1)) {
	foreach ($verif_03_1 as $key => $value) {
		$effective_on = unserialize($value['vouchers']['effective_on']);
		if($effective_on['type'] == "items") {
			$new_effective_on['type'] = "items";
			$new_effective_on['value'] = array();
			foreach ($effective_on['value'] as $k => $v) {
				if(!is_int($v)) {
					$item_id = $db->query('SELECT * FROM items WHERE name=\''.$v.'\';');
					if(!empty($item_id)) {
						$new_effective_on['value'][] = $item_id[0]['items']['id'];
					}
				}
			}
			// on re-set l'effective_on avec les id
			$new_effective_on = serialize($new_effective_on);
			$db->query('UPDATE vouchers SET effective_on=\''.$new_effective_on.'\' WHERE id='.$value['vouchers']['id'].';');
		}
		unset($effective_on);
	}
}
*/
// 0.4

function switch_table_name($old_table, $new_table) {

  $db = ConnectionManager::getDataSource('default');

  $execute = true;

  try {
    $verif = $db->query('SHOW COLUMNS FROM '.$old_table.';');
  } catch(Exception $e) {
    $execute = false;
  }
  if(!isset($verif) || empty($verif)) {
    $execute = false;
  }

  if($execute) {

    @$db->query('RENAME TABLE `'.$old_table.'` TO `'.$new_table.'`;');

  }

}
function add_column($table, $name, $sql) {

  $db = ConnectionManager::getDataSource('default');

  $verif = $db->query('SHOW COLUMNS FROM '.$table.';');
  $execute = true;
  foreach ($verif as $k => $v) {
    if($v['COLUMNS']['Field'] == $name) {
      $execute = false;
      break;
    }
  }
  if($execute) {
    @$query = $db->query('ALTER TABLE `'.$table.'` ADD `'.$name.'` '.$sql.';');
  }
}
function remove_column($table, $name) {

  $db = ConnectionManager::getDataSource('default');

  $verif = $db->query('SHOW COLUMNS FROM '.$table.';');
  $execute = false;
  foreach ($verif as $k => $v) {
    if($v['COLUMNS']['Field'] == $name) {
      $execute = true;
      break;
    }
  }
  if($execute) {
    @$query = $db->query('ALTER TABLE `'.$table.'` DROP COLUMN `'.$name.'`;');
  }
}
$_SESSION['users'] = array();
function author_to_userid($table, $column = 'author') {

  $db = ConnectionManager::getDataSource('default');

  $verif = $db->query('SHOW COLUMNS FROM '.$table.';');
  $execute = false;
  foreach ($verif as $k => $v) {
    if($v['COLUMNS']['Field'] == $column) {
      $execute = true;
      break;
    }
  }
  if($execute) {

    $data = $db->query('SELECT * FROM '.$table);
    foreach ($data as $key => $value) {

      $table_author_id = $value[$table]['id'];
      $author_name = $value[$table][$column];

      if(isset($_SESSION['users'][$author_name])) {
        $author_id = $_SESSION['users'][$author_name];
      } else {
        // on le cherche
        $search_author = $db->query('SELECT id FROM users WHERE pseudo=\''.$author_name.'\'');
        if(!empty($search_author)) {
          $author_id = $_SESSION['users'][$author_name] = $search_author[0]['users']['id'];
        } else {
          $author_id = $_SESSION['users'][$author_name] = 0;
        }
      }

      // On leur met l'id
      $db->query('UPDATE '.$table.' SET user_id='.$author_id.' WHERE id='.$table_author_id);

      unset($table_author_id);
      unset($author_name);
      unset($author_id);
      unset($search_author);

    }
    unset($data);

    remove_column($table, $column);

  }
}


  // Categories
    switch_table_name('categories', 'shop__categories');

  // Dédipass config
    @$db->query("CREATE TABLE IF NOT EXISTS `shop__dedipass_configs` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `public_key` varchar(50) DEFAULT NULL,
      `status` int(1) NOT NULL DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

  // Dédipass histories
    @$db->query("CREATE TABLE IF NOT EXISTS `shop__dedipass_histories` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `user_id` int(11) NOT NULL,
      `code` varchar(8) DEFAULT NULL,
      `rate` varchar(30) DEFAULT NULL,
      `credits_gived` varchar(5) DEFAULT NULL,
      `created` datetime NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

  // Items
    switch_table_name('items', 'shop__items');
    @$db->query('ALTER TABLE `shop__items` CHANGE `price` `price` VARCHAR(20)  NOT NULL  DEFAULT \'\'');
    add_column('shop__items', 'display_server', "int(1) DEFAULT '1'");
    add_column('shop__items', 'need_connect', "int(1) DEFAULT '0'");
    add_column('shop__items', 'display', "int(1) DEFAULT '1'");
    add_column('shop__items', 'multiple_buy', "int(1) DEFAULT '0'");
    add_column('shop__items', 'broadcast_global', "int(1) DEFAULT '1'");
    add_column('shop__items', 'cart', "int(1) DEFAULT '0'");
    add_column('shop__items', 'prerequisites_type', "int(1) DEFAULT NULL COMMENT '1= tous les articles, 2 = au moins 1 des articles'");
    add_column('shop__items', 'prerequisites', "text");
    add_column('shop__items', 'reductional_items', "text");
    add_column('shop__items', 'give_skin', "int(1) DEFAULT '0'");
    add_column('shop__items', 'give_cape', "int(1) DEFAULT '0'");

  // items_buy_histories
    @$db->query("CREATE TABLE IF NOT EXISTS `shop__items_buy_histories` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `item_id` int(11) NOT NULL,
      `user_id` int(11) NOT NULL,
      `created` datetime NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

    // on ajoute dans l'historique si la table est vide (donc première mise à jour)
    $first_update = $db->query('SELECT * FROM shop__items_buy_histories');
    if(empty($first_update)) {

      $items_buy_histories = $db->query('SELECT * FROM histories WHERE action=\'BUY_ITEM\'');
      $items = array();
      foreach ($items_buy_histories as $key => $value) {

        $user_id = $value['histories']['user_id'];
        $item_name = $value['histories']['other'];
        $date = $value['histories']['created'];

        // on cherche l'id de l'article
        if(!isset($items[$item_name])) {
          $search_item_id = $db->query('SELECT id FROM shop__items WHERE name=\''.$item_name.'\'');
          if(!empty($search_item_id)) {
            $item_id = $search_item_id[0]['shop__items']['id'];
            $items[$item_name] = $search_item_id[0]['shop__items']['id'];
          } else {
            $item_id = 0;
            $items[$item_name] = 0;
          }
        } else {
          $item_id = $items[$item_name];
        }

        // on l'ajoute
        $db->query("INSERT INTO `shop__items_buy_histories` (`id`, `item_id`, `user_id`, `created`)
          VALUES ('', $item_id, $user_id, '$date');
        ");

        unset($date);
        unset($user_id);
        unset($item_id);
        unset($item_name);
        unset($search_item_id);

      }

    }
    unset($first_update);

  // items_configs

    @$db->query("CREATE TABLE IF NOT EXISTS `shop__items_configs` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `broadcast_global` text,
      `sort_by_server` int(1) DEFAULT '0',
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

  // paypal_histories

    @$db->query("CREATE TABLE IF NOT EXISTS `shop__paypal_histories` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `payment_id` varchar(20) NOT NULL DEFAULT '',
      `user_id` int(11) NOT NULL,
      `offer_id` int(11) NOT NULL,
      `payment_amount` varchar(20) NOT NULL DEFAULT '',
      `credits_gived` varchar(5) DEFAULT NULL,
      `created` datetime NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

    // on ajoute dans l'historique si la table est vide (donc première mise à jour)
    $first_update = $db->query('SELECT * FROM shop__paypal_histories');
    if(empty($first_update)) {

      $paypal_histories = $db->query('SELECT * FROM histories WHERE action=\'BUY_MONEY\' AND action LIKE \'paypal|%\'');
      $items = array();
      foreach ($paypal_histories as $key => $value) {

        $user_id = $value['histories']['user_id'];
        $other = $value['histories']['other'];
        $other = explode('|', $other);
        $payment_amount = $other[1];
        $credits_gived = $other[2];
        $date = $value['histories']['created'];

        // on l'ajoute
        $db->query("INSERT INTO `shop__paypal_histories` (`id`, `payment_id`, `user_id`, `offer_id`, `payment_amount`, `credits_gived`, `created`)
          VALUES ('', '', $user_id, 0, '$payment_amount', '$credits_gived', '$date');
        ");

        unset($date);
        unset($user_id);
        unset($item_id);
        unset($item_name);

      }

    }
    unset($first_update);

  // shop__paypals
    switch_table_name('paypals', 'shop__paypals');

  // paysafecard_histories

    @$db->query("CREATE TABLE IF NOT EXISTS `shop__paysafecard_histories` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `code` varchar(20) NOT NULL DEFAULT '',
      `amount` varchar(3) NOT NULL DEFAULT '',
      `credits_gived` varchar(5) NOT NULL DEFAULT '',
      `user_id` int(11) NOT NULL,
      `created` datetime NOT NULL,
      `author_id` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

    // on ajoute dans l'historique si la table est vide (donc première mise à jour)
    $first_update = $db->query('SELECT * FROM shop__paysafecard_histories');
    if(empty($first_update)) {

      $psc_history = $db->query('SELECT * FROM histories WHERE action=\'BUY_MONEY\' AND action LIKE \'paysafecard|%\'');
      $items = array();
      foreach ($psc_history as $key => $value) {

        $user_id = $value['histories']['user_id'];
        $other = $value['histories']['other'];
        $other = explode('|', $other);
        $payment_amount = $other[2];
        $credits_gived = $other[1];
        $date = $value['histories']['created'];

        // on l'ajoute
        $db->query("INSERT INTO `shop__paysafecard_histories` (`id`, `code`, `amount`, `credits_gived`, `user_id`, `created`, `author_id`)
          VALUES ('', '', '$payment_amount', '$credits_gived', $user_id, '$date', 0);
        ");

        unset($date);
        unset($user_id);
        unset($item_id);
        unset($item_name);

      }

    }
    unset($first_update);

  // paysafecards
    switch_table_name('paysafecards', 'shop__paysafecards');
    add_column('shop__paysafecards', 'user_id', 'int(20) NOT NULL');
    author_to_userid('shop__paysafecards');

  // paysafecards
    switch_table_name('paysafecard_messages', 'shop__paysafecard_messages');
    add_column('shop__paysafecard_messages', 'user_id', 'int(20) NOT NULL');
    author_to_userid('shop__paysafecard_messages', 'to');

  // starpass_histories
    @$db->query("CREATE TABLE IF NOT EXISTS `shop__starpass_histories` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `code` varchar(40) NOT NULL DEFAULT '',
      `user_id` int(11) NOT NULL,
      `offer_id` int(11) NOT NULL,
      `credits_gived` varchar(5) DEFAULT NULL,
      `created` datetime DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");

    // on ajoute dans l'historique si la table est vide (donc première mise à jour)
    $first_update = $db->query('SELECT * FROM shop__starpass_histories');
    if(empty($first_update)) {

      $starpass_history = $db->query('SELECT * FROM histories WHERE action=\'BUY_MONEY\' AND action LIKE \'starpass|%\'');
      $items = array();
      foreach ($starpass_history as $key => $value) {

        $user_id = $value['histories']['user_id'];
        $other = $value['histories']['other'];
        $other = explode('|', $other);
        $credits_gived = $other[1];
        $date = $value['histories']['created'];

        // on l'ajoute
        $db->query("INSERT INTO `shop__starpass_histories` (`id`, `code`, `user_id`, `offer_id`, `credits_gived`, `created`)
          VALUES ('', '', $user_id, 0, '$credits_gived', '$date');
        ");

        unset($date);
        unset($user_id);
        unset($item_id);
        unset($item_name);

      }

    }
    unset($first_update);

  // starpasses
    switch_table_name('starpasses', 'shop__starpasses');

  // vouchers
    switch_table_name('vouchers', 'shop__vouchers');

  // vouchers history
    @$db->query("CREATE TABLE IF NOT EXISTS `shop__vouchers_histories` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `code` varchar(20) NOT NULL DEFAULT '',
      `user_id` int(11) NOT NULL,
      `reduction` varchar(3) NOT NULL DEFAULT '',
      `created` datetime NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;");
