<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get('SHOP__CONFIG') ?></h3>
                </div>
                <div class="box-body">
                    <form action="<?= $this->Html->url(array('action' => 'config_items')) ?>" method="post"
                          data-ajax="true">

                        <div class="form-group">
                            <label><?= $Lang->get('SHOP__CONFIG_BROADCAST_GLOBAL') ?></label>
                            <input name="broadcast_global" class="form-control"
                                   type="text"<?= (isset($config['broadcast_global'])) ? ' value="' . $config['broadcast_global'] . '"' : '' ?>>
                        </div>
                        <div class="form-group">
                            <label><?= $Lang->get('SHOP__CONFIG_GOAL_TITLE') ?></label>
                            <p><?= $Lang->get('SHOP__CONFIG_GOAL_DESC') ?></p>
                            <input name="goal" class="form-control"
                                   type="text"<?= (isset($config['goal'])) ? ' value="' . $config['goal'] . '"' : '' ?>>
                        </div>

                        <!--<div class="form-group">
              <div class="checkbox">
                <input name="disabled-sort_by_server" type="checkbox"<?= (isset($config['sort_by_server']) && $config['sort_by_server']) ? ' checked=""' : '' ?> disabled>
                <label><?= $Lang->get('SHOP__CONFIG_SORT_BY_SERVER') ?></label>
              </div>
              <small><?= $Lang->get('GLOBAL__TEMPORALY_DISABLED') ?></small>
            </div>-->

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><?= $Lang->get('GLOBAL__SUBMIT') ?></button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><?= $Lang->get('SHOP__CONFIG_EXPLAIN_TITLE') ?></h3>
                </div>
                <div class="box-body">
                    <blockquote>
                        <p><?= $Lang->get('SHOP__CONFIG_EXPLAIN') ?></p>
                    </blockquote>
                    <p><b><?= $Lang->get('SHOP__CONFIG_VARIABLES') ?> : </b></p>
                    <p><em>{ITEM_NAME}</em> : <?= $Lang->get('SHOP__CONFIG_VARIABLE_ITEM') ?></p>
                    <p><em>{QUANTITY}</em> : <?= $Lang->get('SHOP__CONFIG_VARIABLE_QUANTITY') ?></p>
                    <p><em>{PLAYER}</em> : <?= $Lang->get('SHOP__CONFIG_VARIABLE_PLAYER') ?></p>
                    <p><em>{SERVERNAME}</em> : <?= $Lang->get('SHOP__CONFIG_VARIABLE_SERVERNAME') ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-12">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#category_other" data-toggle="tab"
                                          aria-expanded="true"><?= $Lang->get('SHOP__ITEMS_AVAILABLE_OTHER') ?></a></li>
                    <?php if (!empty($search_sections)) foreach ($search_sections as $value) { ?>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                <?= $value['Section']['name'] ?> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if (!empty($search_categories)) foreach ($search_categories["section-id-" . $value['Section']['id']] as $v) { ?>
                                    <li class=""><a href="#category_<?= $v['Category']['id'] ?>" data-toggle="tab"
                                                    aria-expanded="false"><?= $v['Category']['name'] ?></a></li>
                                <?php } ?>
                            </ul>
                        </li>
                    <?php } ?>
                    <?php if (!empty($search_categories_without_section)) foreach ($search_categories_without_section as $value) {
                         ?>
                        <li><a href="#category_<?= $value['Category']['id'] ?>" data-toggle="tab"
                               aria-expanded="true"><?= $value['Category']['name'] ?></a></li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="category_other">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th><?= $Lang->get('SHOP__ITEMS_AVAILABLE') ?></th>
                                <th><?= $Lang->get('SERVER__TITLE') ?></th>
                                <th><?= $Lang->get('SHOP__ITEM_PRICE') ?></th>
                                <th class="right"><?= $Lang->get('GLOBAL__ACTIONS') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($search_items_other)) foreach ($search_items_other as $val => $va) {
                                ?>
                                <tr>
                                    <td><?= $va["Item"]["name"] ?></td>
                                    <td><?= $item_server[$va['Item']['id']] ?></td>
                                    <td><?= $va["Item"]["price"] ?> <?= $Configuration->getMoneyName() ?></td>
                                    <td class="right">
                                        <a onClick="confirmDuplicate('<?= $this->Html->url(array('controller' => 'shop', 'action' => 'duplicate/' . $va["Item"]["id"], 'admin' => true)) ?>')"
                                           class="btn bg-olive"><?= $Lang->get('SHOP__DUPLICATE') ?></a>
                                        <a href="<?= $this->Html->url(array('controller' => 'shop', 'action' => 'edit/' . $va["Item"]["id"], 'admin' => true)) ?>"
                                           class="btn btn-info"><?= $Lang->get('GLOBAL__EDIT') ?></a>
                                        <a onClick="confirmDel('<?= $this->Html->url(array('controller' => 'shop', 'action' => 'delete/item/' . $va["Item"]["id"], 'admin' => true)) ?>')"
                                           class="btn btn-danger"><?= $Lang->get('GLOBAL__DELETE') ?></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php if (!empty($search_categories)) foreach ($search_categories as $v) { ?>
                        <div class="tab-pane" id="category_<?= $v['Category']['id'] ?>">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th><?= $Lang->get('SHOP__ITEMS_AVAILABLE') ?>
                                        &nbsp;&nbsp;
                                        <a style="display:inline"
                                           href="<?php if (!empty($search_categories)) { ?><?= $this->Html->url(array('controller' => 'shop', 'action' => 'add_item', 'admin' => true)) ?><?php } ?>"
                                           class="btn btn-sm btn-success
                                           <?php if (empty($search_categories)) {
                                               echo ' disabled';
                                           } ?>">
                                            <?= $Lang->get('GLOBAL__ADD') ?>
                                        </a>
                                    </th>
                                    <th><?= $Lang->get('SERVER__TITLE') ?></th>
                                    <th><?= $Lang->get('SHOP__ITEM_PRICE') ?></th>
                                    <th class="right"><?= $Lang->get('GLOBAL__ACTIONS') ?></th>
                                </tr>
                                </thead>
                                <tbody id="sortable-<?= $v['Category']['id'] ?>">
                                <?php if (!empty($search_items)) foreach ($search_items[$v['Category']['id']] as $va) { ?>
                                    <tr class="item" style="cursor:move;" id="<?= $va["Item"]["id"] ?>-<?= $i ?>">
                                        <td><?= $va["Item"]["name"] ?></td>
                                        <td><?= $item_server[$va['Item']['id']] ?></td>
                                        <td><?= $va["Item"]["price"] ?> <?= $Configuration->getMoneyName() ?></td>
                                        <td class="right">
                                            <a onClick="confirmDuplicate('<?= $this->Html->url(array('controller' => 'shop', 'action' => 'duplicate/' . $va["Item"]["id"], 'admin' => true)) ?>')"
                                               class="btn bg-olive"><?= $Lang->get('SHOP__DUPLICATE') ?></a>
                                            <a href="<?= $this->Html->url(array('controller' => 'shop', 'action' => 'edit/' . $va["Item"]["id"], 'admin' => true)) ?>"
                                               class="btn btn-info"><?= $Lang->get('GLOBAL__EDIT') ?></a>
                                            <a onClick="confirmDel('<?= $this->Html->url(array('controller' => 'shop', 'action' => 'delete/item/' . $va["Item"]["id"], 'admin' => true)) ?>')"
                                               class="btn btn-danger"><?= $Lang->get('GLOBAL__DELETE') ?></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <div class="ajax-msg"></div>
                            <button id="save" class="btn btn-success pull-right active"
                                    disabled="disabled"><?= $Lang->get('SHOP__SAVE_SUCCESS') ?></button>
                            <br><br>
                        </div>
                        <script type="text/javascript">
                            function confirmDuplicate(url) {
                                if (confirm("<?= $Lang->get('SHOP__CONFIRM_DUPLICATE') ?>"))
                                    window.location.href = '' + url + '';
                                else
                                    return false;
                            }
                        </script>
                    <?php } ?>
                    <script>
                        $(function () {
                            $("<?= implode(', ', array_map(function ($category) {
                                return "#sortable-" . $category['Category']['id'];
                            }, $search_categories)); ?>").sortable({
                                axis: 'y',
                                items: '.item:not(.fixed)',
                                stop: function (event, ui) {
                                    $('#save').empty().html('<?= $Lang->get('SHOP__SAVE_IN_PROGRESS') ?>');
                                    var inputs = {};
                                    var shop_item_order = $(this).sortable('serialize');
                                    inputs['shop_item_order'] = shop_item_order;
                                    $('#shop_item_order').text(shop_item_order);
                                    inputs['data[_Token][key]'] = '<?= $csrfToken ?>';
                                    $.post("<?= $this->Html->url(array('controller' => 'shop', 'action' => 'save_ajax', 'admin' => true)) ?>", inputs, function (data) {
                                        if (data.statut) {
                                            $('#save').empty().html('<?= $Lang->get('SHOP__SAVE_SUCCESS') ?>');
                                        } else if (!data.statut) {
                                            $('.ajax-msg').empty().html('<div class="alert alert-danger" style="margin-top:10px;margin-right:10px;margin-left:10px;"><a class="close" data-dismiss="alert">×</a><i class="icon icon-warning-sign"></i> <b><?= $Lang->get('GLOBAL__ERROR') ?> :</b> ' + data.msg + '</i></div>').fadeIn(500);
                                        } else {
                                            $('.ajax-msg').empty().html('<div class="alert alert-danger" style="margin-top:10px;margin-right:10px;margin-left:10px;"><a class="close" data-dismiss="alert">×</a><i class="icon icon-warning-sign"></i> <b><?= $Lang->get('GLOBAL__ERROR') ?> :</b> <?= $Lang->get('ERROR__INTERNAL_ERROR') ?></i></div>');
                                        }
                                    });
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get('SHOP__HISTORY_PURCHASES') ?></h3>
                </div>
                <div class="box-body">

                    <table class="table table-bordered dataTable" id="histories_buy">
                        <thead>
                        <tr>
                            <th><?= $Lang->get('SHOP__ITEM') ?></th>
                            <th>Pseudo</th>
                            <th><?= $Lang->get('GLOBAL__CREATED') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function () {
        $('#histories_buy').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            'searching': true,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "<?= $this->Html->url(array('action' => 'get_histories_buy')) ?>",
            "aoColumns": [
                {mData: "Item.name"},
                {mData: "User.pseudo"},
                {mData: "ItemsBuyHistory.created"}
            ],
        });
    });
</script>
