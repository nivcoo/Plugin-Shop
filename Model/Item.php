<?php
class Item extends ShopAppModel {

  public function checkPrerequisites($item, $user_id) {
    $prerequisites = (isset($item['prerequisites_type']) && ($item['prerequisites_type'] == 1 || $item['prerequisites_type'] == 2)) ? true : false;
    if($prerequisites) {
      $prerequisites_type = $item['prerequisites_type'];
      $prerequisites = @unserialize($item['prerequisites']);

      if(!is_bool($prerequisites) && !empty($prerequisites)) {

        $this->ItemsBuyHistory = ClassRegistry::init('Shop.ItemsBuyHistory');
        $prerequisites_items = array();
        $prerequisites_items_buyed = array();

        foreach ($prerequisites as $key => $value) {

          $findItemRequired = $this->find('first', array('conditions' => array('id' => $value)));
          if(empty($findItemRequired)) {
            continue;
          }

          $findHistory = $this->ItemsBuyHistory->find('first', array('conditions' => array('user_id' => $user_id, 'item_id' => $findItemRequired['Item']['id'])));
          if(empty($findHistory)) {
            $prerequisites_items[] = $findItemRequired['Item']['name'];
            $prerequisites_items_buyed[] = false;
            continue;
          }

          $prerequisites_items_buyed[] = true;

        }

        if($prerequisites_type == 1 && in_array(false, $prerequisites_items_buyed)) {
          $prerequisites_items_list = '<i>'.implode('</i>, <i>', $prerequisites_items).'</i>';
          return array('error' => 1, 'items_list' => $prerequisites_items_list);
        }

        if($prerequisites_type == 2 && !in_array(true, $prerequisites_items_buyed)) {
          $prerequisites_items_list = '<i>'.implode('</i>, <i>', $prerequisites_items).'</i>';
          return array('error' => 2, 'items_list' => $prerequisites_items_list);
        }

      }

    }
    return true;
  }

  public function getReductionWithReductionalItems($item, $user_id) {
    $reductional_items_func = (!empty($item['reductional_items']) && !is_bool(unserialize($item['reductional_items']))) ? true : false;
    $reductional_items = false;
    $reduction = 0;
    if($reductional_items_func) {

      $reductional_items_list = unserialize($item['reductional_items']);
      // on parcours tous les articles pour voir si ils ont été achetés
        $reduction = 0; // 0 de réduction
      foreach ($reductional_items_list as $key => $value) {

        $findItem = $this->find('first', array('conditions' => array('id' => $value)));
        if(empty($findItem)) {
          continue;
        }

        $this->ItemsBuyHistory = ClassRegistry::init('Shop.ItemsBuyHistory');
        $findHistory = $this->ItemsBuyHistory->find('first', array('conditions' => array('user_id' => $user_id, 'item_id' => $item['id'])));
        if(empty($findHistory)) {
          continue;
        }

        $reduction =+ $item['price'];

        unset($findItem);

      }
    }
    return $reduction;
  }

}
