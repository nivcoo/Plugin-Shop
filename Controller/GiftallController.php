<?php
class GiftallController extends ShopAppController
{
	public function admin_index()
	{
<<<<<<< HEAD
		if ($this->isConnected AND $this->Permissions->can('SHOP__ADMIN_MANAGE_ITEMS')) {
=======
		if ($this->isConnected AND $this->Permissions->can('SHOP__ADMIN_GIFTALL')) {
>>>>>>> upstream/master
			
			if($this->request->is('post')){
				$this->layout = null;
				$this->autoRender = false;
				
				$number = $this->request->data['number'];
				
				if(!empty($number) && is_numeric($number)){
					
					$db = ConnectionManager::getDataSource('default');
					$number = $db->value($number, 'integer');
					$db->query("UPDATE Users SET money = money + $number");
					
					$this->History->set("GIFTALL_$number", "shop");
					
					return $this->response->body(json_encode(array('statut' => true, 'msg' => $this->Lang->get('SHOP__GIFTALL_SUCCESS'))));
				}else{
					return $this->response->body(json_encode(array('statut' => false, 'msg' => $this->Lang->get('ERROR__FILL_ALL_FIELDS'))));
				}
			}else {
				$this->set('title_for_layout', $this->Lang->get('SHOP__TITLE'));
				$this->layout = 'admin';
			}
<<<<<<< HEAD
=======
		}else{
			throw new ForbiddenException();
>>>>>>> upstream/master
		}
	}
}