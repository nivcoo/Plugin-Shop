<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title"><?= $Lang->get('SHOP__CATEGORY_EDIT') ?></h3>
                </div>
                <div class="card-body">
                    <form action="" method="post" data-ajax="false">

                        <div class="ajax-msg"></div>

                        <div class="form-group">
                            <label><?= $Lang->get('GLOBAL__NAME') ?></label>
                            <input name="name" value="<?= $category['Category']['name'] ?>" class="form-control"
                                   type="text">
                        </div>


                        <div class="form-group">
                            <div class="checkbox">
                                <input type="hidden" id="section" name="section"
                                       value="<?= $category['Category']['section'] ?>">
                                <input id="section_checkbox" value="true" name="section_checkbox"
                                       type="checkbox" <?= $category['Category']['section'] == '0' ? 'checked' : '' ?>>
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

                        <div class="form-group" id="section_id"
                             style="display:<?= ($category['Category']['section'] == 0) ? 'none' : '' ?>">
                            <label><?= $Lang->get('SHOP__SECTION') ?></label>
                            <p><?= $Lang->get('SHOP__CATEGORY_EDIT_MESSAGE') ?> <a
                                        href="<?= $this->Html->url(array('controller' => 'categories', 'action' => 'add_section', 'admin' => true)) ?>"><?= $Lang->get('SHOP__SECTIONS') ?></a>
                            </p>
                            <select class="form-control" name="section_id">
                                <?php foreach ($search_sections as $v) { ?>
                                    <option value="<?= $v['Section']['id'] ?>" <?= ($category['Category']['section_id'] == $v['Section']['id']) ? 'selected' : '' ?>><?= $v['Section']['name'] ?></option>
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
