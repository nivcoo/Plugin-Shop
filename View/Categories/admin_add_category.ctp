<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= $Lang->get('SHOP__CATEGORY_ADD') ?></h3>
                </div>
                <div class="box-body">
                    <form action="" method="post" data-ajax="false">

                        <div class="ajax-msg"></div>

                        <div class="form-group">
                            <label><?= $Lang->get('GLOBAL__NAME') ?></label>
                            <input name="name" class="form-control" type="text">
                        </div>

                        <div class="form-group">
                            <div class="checkbox">
                                <input type="hidden" id="section" name="section"
                                       value="<?= (!isset($section_id)) ? "0" : "1" ?>">
                                <input <?= (!isset($section_id)) ? "checked" : "" ?> id="section_checkbox" value="true"
                                                                                     name="section_checkbox"
                                                                                     type="checkbox">
                                <label for="section_checkbox"><?= $Lang->get('SHOP__CATEGORY_ADD_NO') ?></label>
                            </div>
                        </div>

                        <script type="text/javascript">
                            $('#section_checkbox').change(function (e) {
                                if ($('#section_checkbox').is(':checked')) {
                                    $('#section_id').slideUp();
                                    $("#section").attr('value', '0');
                                } else {
                                    $('#section_id').slideDown();
                                    $("#section").attr('value', '1');

                                }
                            });
                        </script>

                        <div class="form-group"
                             id="section_id" <?= (!isset($section_id)) ? "style='display:none'" : "" ?>>
                            <label><?= $Lang->get('SHOP__SECTION') ?></label>
                            <p><?= $Lang->get('SHOP__CATEGORY_EDIT_MESSAGE') ?> <a
                                        href="<?= $this->Html->url(array('controller' => 'categories', 'action' => 'add_section', 'admin' => true)) ?>"><?= $Lang->get('SHOP__SECTIONS') ?></a>
                            </p>
                            <select class="form-control" name="section_id">
                                <?php foreach ($search_sections as $v) { ?>
                                    <option <?= ($section_id == $v['Section']['id']) ? "selected" : "" ?>
                                            value="<?= $v['Section']['id'] ?>"><?= $v['Section']['name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <input type="hidden" name="data[_Token][key]" value="<?= $csrfToken ?>">

                        <div class="pull-right">
                            <a href="<?= $this->Html->url(array('controller' => 'categories', 'action' => 'index', 'admin' => true)) ?>"
                               class="btn btn-default"><?= $Lang->get('GLOBAL__CANCEL') ?></a>
                            <button class="btn btn-primary" type="submit"><?= $Lang->get('GLOBAL__SUBMIT') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
