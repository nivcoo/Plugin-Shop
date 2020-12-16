<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="callout callout-info"><h4><?= $Lang->get('SHOP__CATEGORIES') ?></h4><?= $Lang->get('SHOP__CATEGORIES_TIP') ?></div>
        </div>
        <div class="col-md-6">
            <div class="callout callout-warning"><h4><?= $Lang->get('SHOP__SECTION') ?></h4><?= $Lang->get('SHOP__SECTION_TIP') ?></div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get('SHOP__SECTION_AND_CATEGORIES') ?></h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th><?= $Lang->get('SHOP__SECTIONS') ?> <a style="display: inline;" href="<?= $this->Html->url(array('controller' => 'categories', 'action' => 'add_section', 'admin' => true)) ?>" class="btn btn-sm btn-success"><?= $Lang->get('GLOBAL__ADD') ?></a></th>
                            <th><?= $Lang->get('SHOP__CATEGORIES') ?></th>
                            <th><?= $Lang->get('SHOP__CATEGORY_NUMBER') ?></th>
                            <th class="right"><?= $Lang->get('GLOBAL__ACTIONS') ?></th>
                        </tr>
                        </thead>
                        <tbody id="sortable">
                        <?php if(!empty($search_sections)) foreach ($search_sections as $value => $va) {?>
                            <tr class="item fixed">
                                <th>
                                    <form action="<?= $this->Html->url(array('controller' => 'categories', 'action' => 'edit_section')) ?>" data-redirect-url="<?= $this->Html->url(array('controller' => 'categories', 'action' => 'index', 'admin' => true)) ?>" method="post" data-ajax="true">
                                        <input class="form-control transparent-input" name="name" autocomplete="off" type="text" value="<?=  $va["Section"]["name"] ?>">
                                        <input type="hidden" name="id" value="<?= $va["Section"]["id"] ?>">
                                </th>
                                <th><a href="<?php if(!empty($search_sections)) echo $this->Html->url(array('controller' => 'categories', 'action' => 'add_category/'.$va["Section"]["id"], 'admin' => true)); ?>" class="btn btn-success <?php if(empty($search_sections)) { echo ' disabled'; } ?>"><?= $Lang->get('GLOBAL__ADD') ?></a></th>
                                <th></th>
                                <th class="right">
                                    <button class="btn btn-primary" type="submit"><?= $Lang->get('GLOBAL__SUBMIT') ?></button>
                                    <a onClick="confirmDel('<?= $this->Html->url(array('controller' => 'shop', 'action' => 'delete/section/'.$va["Section"]["id"], 'admin' => true)) ?>')" class="btn btn-danger"><?= $Lang->get('GLOBAL__DELETE') ?></a>
                                    </form>
                                </th>
                            </tr>
                            <?php $a=0; if(!empty($search_categories)) foreach ($search_categories[$va["Section"]["id"]] as $value => $v) { $a++;?>
                                <tr class="item" style="cursor:move;" id="<?= $v["Category"]["id"] ?>-<?= $a ?>">
                                    <td></td>
                                    <td>
                                        <?=  $v["Category"]["name"] ?>
                                    </td>
                                    <td><?= $categories_count[$v['Category']['id']] ?></td>
                                    <td class="right">
                                        <a href="<?= $this->Html->url(array('controller' => 'categories', 'action' => 'edit/'.$v["Category"]["id"], 'admin' => true)) ?>" class="btn btn-info"><?= $Lang->get('GLOBAL__EDIT') ?></a>
                                        <a onClick="confirmDel('<?= $this->Html->url(array('controller' => 'shop', 'action' => 'delete/category/'.$v["Category"]["id"], 'admin' => true)) ?>')" class="btn btn-danger"><?= $Lang->get('GLOBAL__DELETE') ?></a>
                                    </td>
                                </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                    <br>
                    <div class="ajax-msg"></div>
                    <button id="save" class="btn btn-success pull-right active" disabled="disabled"><?= $Lang->get('SHOP__SAVE_SUCCESS') ?></button>
                </div>
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get('SHOP__CATEGORIES_NO') ?></h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th><?= $Lang->get('SHOP__CATEGORIES') ?> <a style="display: inline;" href="<?= $this->Html->url(array('controller' => 'categories', 'action' => 'add_category', 'admin' => true)); ?>" class="btn btn-sm btn-success "><?= $Lang->get('GLOBAL__ADD') ?></a></th>
                            <th><?= $Lang->get('SHOP__CATEGORY_NUMBER') ?></th>
                            <th class="right"><?= $Lang->get('GLOBAL__ACTIONS') ?></th>
                        </tr>
                        </thead>
                        <tbody id="sortable-2">
                        <?php $i=0; if(!empty($search_categories_no)) foreach ($search_categories_no as $value => $v) { $i++;?>
                            <tr class="item" style="cursor:move;" id="<?= $v["Category"]["id"] ?>-<?= $i ?>">
                                <td>
                                    <?=  $v["Category"]["name"] ?>
                                </td>
                                <td><?= $categories_count[$v['Category']['id']] ?></td>
                                <td class="right">
                                    <a href="<?= $this->Html->url(array('controller' => 'categories', 'action' => 'edit/'.$v["Category"]["id"], 'admin' => true)) ?>" class="btn btn-info"><?= $Lang->get('GLOBAL__EDIT') ?></a>
                                    <a onClick="confirmDel('<?= $this->Html->url(array('controller' => 'shop', 'action' => 'delete/category/'.$v["Category"]["id"], 'admin' => true)) ?>')" class="btn btn-danger"><?= $Lang->get('GLOBAL__DELETE') ?></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <div class="ajax-msg"></div>
                    <button id="save-2" class="btn btn-success pull-right active" disabled="disabled"><?= $Lang->get('SHOP__SAVE_SUCCESS') ?></button>
                </div>
            </div>
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get('SHOP__CATEGORIES_OTHER') ?></h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th><?= $Lang->get('SHOP__CATEGORIES') ?></th>
                            <th><?= $Lang->get('SHOP__CATEGORY_NUMBER') ?></th>
                            <th class="right"><?= $Lang->get('GLOBAL__ACTIONS') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php  if(!empty($search_categories_other)) foreach ($search_categories_other as $value => $v) { ?>
                            <tr>
                                <td>
                                    <?=  $v[0]["Category"]["name"] ?>
                                </td>
                                <td><?= $categories_count_other[$v[0]['Category']['id']] ?></td>
                                <td class="right">
                                    <a href="<?= $this->Html->url(array('controller' => 'categories', 'action' => 'edit/'.$v[0]["Category"]["id"], 'admin' => true)) ?>" class="btn btn-info"><?= $Lang->get('GLOBAL__EDIT') ?></a>
                                    <a onClick="confirmDel('<?= $this->Html->url(array('controller' => 'shop', 'action' => 'delete/category/'.$v[0]["Category"]["id"], 'admin' => true)) ?>')" class="btn btn-danger"><?= $Lang->get('GLOBAL__DELETE') ?></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function() {
        $( "#sortable" ).sortable({
            axis: 'y',
            items: '.item:not(.fixed)',
            stop: function (event, ui) {
                $('#save').empty().html('<?= $Lang->get('SHOP__SAVE_IN_PROGRESS') ?>');
                var inputs = {};
                var shop_item_order = $(this).sortable('serialize');
                inputs['shop_item_order'] = shop_item_order;
                $('#shop_item_order').text(shop_item_order);
                inputs['data[_Token][key]'] = '<?= $csrfToken ?>';
                $.post("<?= $this->Html->url(array('controller' => 'categories', 'action' => 'save_ajax', 'admin' => true)) ?>", inputs, function(data) {
                    if(data.statut) {
                        $('#save').empty().html('<?= $Lang->get('SHOP__SAVE_SUCCESS') ?>');
                    } else if(!data.statut) {
                        $('.ajax-msg').empty().html('<div class="alert alert-danger" style="margin-top:10px;margin-right:10px;margin-left:10px;"><a class="close" data-dismiss="alert">×</a><i class="icon icon-warning-sign"></i> <b><?= $Lang->get('GLOBAL__ERROR') ?> :</b> '+data.msg+'</i></div>').fadeIn(500);
                    } else {
                        $('.ajax-msg').empty().html('<div class="alert alert-danger" style="margin-top:10px;margin-right:10px;margin-left:10px;"><a class="close" data-dismiss="alert">×</a><i class="icon icon-warning-sign"></i> <b><?= $Lang->get('GLOBAL__ERROR') ?> :</b> <?= $Lang->get('ERROR__INTERNAL_ERROR') ?></i></div>');
                    }
                });
            }
        });
    });
    $(function() {
        $( "#sortable-2" ).sortable({
            axis: 'y',
            items: '.item:not(.fixed)',
            stop: function (event, ui) {
                $('#save-2').empty().html('<?= $Lang->get('SHOP__SAVE_IN_PROGRESS') ?>');
                var inputs = {};
                var shop_item_order = $(this).sortable('serialize');
                inputs['shop_item_order'] = shop_item_order;
                $('#shop_item_order').text(shop_item_order);
                inputs['data[_Token][key]'] = '<?= $csrfToken ?>';
                $.post("<?= $this->Html->url(array('controller' => 'categories', 'action' => 'save_ajax', 'admin' => true)) ?>", inputs, function(data) {
                    if(data.statut) {
                        $('#save-2').empty().html('<?= $Lang->get('SHOP__SAVE_SUCCESS') ?>');
                    } else if(!data.statut) {
                        $('.ajax-msg').empty().html('<div class="alert alert-danger" style="margin-top:10px;margin-right:10px;margin-left:10px;"><a class="close" data-dismiss="alert">×</a><i class="icon icon-warning-sign"></i> <b><?= $Lang->get('GLOBAL__ERROR') ?> :</b> '+data.msg+'</i></div>').fadeIn(500);
                    } else {
                        $('.ajax-msg').empty().html('<div class="alert alert-danger" style="margin-top:10px;margin-right:10px;margin-left:10px;"><a class="close" data-dismiss="alert">×</a><i class="icon icon-warning-sign"></i> <b><?= $Lang->get('GLOBAL__ERROR') ?> :</b> <?= $Lang->get('ERROR__INTERNAL_ERROR') ?></i></div>');
                    }
                });
            }
        });
    });
</script>