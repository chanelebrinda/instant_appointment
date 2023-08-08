<?php
    $args = array('taxonomy'   => "product_cat",'hide_empty'=> false);
    $categories = get_terms( $args);
?>
<div class="row">
    <div class="col-lg-12 col-md-12 col-12 mt-5">
        <!-- Page header -->
        <div class="my-5">
            <h3 class="mt-5">
                <?php _e('Modifier un service','instant_Appointement') ?>
            </h3>
        </div>
    </div>
</div>
<form action="" class="insapp_update_service">
    <div class="row">
        <div class="col-md-12 col-12">
            <!-- card -->
            <div class="card mb-4">
                <!-- card body -->
                <div class="card-body">
                    <div class="mb-5 col-lg-12 col-12 ">
                        <label for="insapp_update_service_name" class="form-label">
                            <?php _e("Nom","instant_Appointement") ?>
                        </label>
                        <input type="text" id="insapp_update_service_name" class="form-control" placeholder="<?php _e("
                            Entrez le nom du service","instant_Appointement") ?>"
                        required="" />
                    </div>

                    <div class="mb-5 col-lg-12 col-12">
                        <label class="form-label">
                            <?php _e("Description","instant_Appointement") ?>
                        </label>

                        <div class="pb-8 ql-container ql-snow">
                            <div class="ql-editor ql-blank" id="insapp_update_service_editor" data-gramm="false"
                                contenteditable="true">
                                <p><br></p>
                            </div>
                            <div class="ql-clipboard" contenteditable="true" tabindex="-1"></div>
                            <div class="ql-tooltip ql-hidden">
                                <a class="ql-preview" rel="noopener noreferrer" target="_blank" href="about:blank"></a>
                                <input type="text" data-formula="e=mc^2" maxlength="15" data-link="https://quilljs.com"
                                    data-video="Embed URL">
                                <a class="ql-action"></a>
                                <a class="ql-remove"></a>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- <div class="card-footer">
                        <div class="row">
                            <div class="mb-5 col-lg-6 col-6">
                                <label class="form-label">
                                    <?php _e("Date debut","instant_Appointement") ?><span
                                        class="text-danger">*</span>
                                </label>
                                <div class="input-group me-3 flatpickr rounded flatpickr-input" readonly="readonly">
                                    <input class="form-control insapp_flatpickr" id="insapp-date-start"
                                        type="text" placeholder="<?php _e(" Choisir la date","instant_Appointement") ?>" aria-describedby="basic-addon2">
                                </div>
                            </div>
                            <div class="mb-5 col-lg-6 col-6">
                                <label class="form-label">
                                    <?php _e("Date fin","instant_Appointement") ?><span
                                        class="text-danger">*</span>
                                </label>
                                <div class="input-group me-3 flatpickr rounded flatpickr-input" readonly="readonly">
                                    <input class="form-control insapp_flatpickr" id="insapp-date-end"
                                        type="text" placeholder="<?php _e(" Choisir la date","instant_Appointement") ?>" aria-describedby="basic-addon3">
                                </div>
                            </div>
                        </div>
                    </div> -->
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-12">
                <div class="card mb-4">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- input -->
                        <div class="mb-3">
                            <label class="form-label">
                                <?php _e('Prix Regulier','instant_Appointement') ?>
                            </label>
                            <input type="text" class="form-control" id="insapp_update_price_reg"
                                placeholder="$ 49.00" />
                        </div>
                        <!-- input -->
                        <div class="mb-3">
                            <label class="form-label">
                                <?php _e('Prix promotionnel','instant_Appointement') ?>
                            </label>
                            <input type="text" class="form-control" id="insapp_update_price_sale" placeholder="$ 49.00"
                                required />
                        </div>
                        <!-- input -->
                        <!-- <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="priceIncluded" checked="">
                                <label class="form-check-label" for="priceIncluded">
                                    <?php _e(' Price includes taxes','instant_Appointement') ?></label>
                            </div> -->
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card mb-4">
                    <!-- card body -->
                    <div class="card-body">
                        <!-- input -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <label class="form-label">
                                    <?php _e('Categorie','instant_Appointement') ?>
                                </label>
                            </div>
                            <!-- select menu -->
                            <select class="form-select" id="insapp_update_category" aria-label="Default select example"
                                required>
                                <?php foreach($categories as $category){?>
                                <option value="<?php echo $category->slug ;?>">
                                    <?php echo $category->name ;?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- tag -->
                        <div class="mb-3">
                            <label class="form-label">
                                <?php _e('Durée du service','instant_Appointement') ?>
                            </label>
                            <input name='insapp_duree' id="insapp_update_duree" type="time" class="form-control"
                                placeholder='<?php _e(" Choisir la durée du service","instant_Appointement") ?>'
                                required />

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mt-3 table-responsive">
                            <table class="table table-bordered" style="border-color : #cbd5e1; border-raduis: 5px">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <?php _e("Extra") ?>
                                        </th>
                                        <th class="text-center">
                                            <?php _e("Cout") ?>
                                        </th>
                                        <th class="text-center">
                                            <?php _e("Action") ?>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody id="tab_update_extra"></tbody>
                            </table>
                        </div>

                        <div class="col-5">
                            <label class="form-label">
                                <?php _e("Nom de l'extra") ?>
                            </label>
                            <input type="text" class="form-control" id="nom_extra_update" />
                        </div>

                        <div class="col-3">
                            <label class="form-label">
                                <?php _e("Cout de l'extra") ?>
                            </label>
                            <input type='number' class="form-control" id='cout_extra_update' />
                        </div>

                        <div class="col-4">
                            <br />
                            <a class="btn btn-success" id="btn_update_exta">
                                <?php _e("Ajouter") ?>
                            </a>
                        </div>

                    </div>
               </div>
            </div>
        </div>
        
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="mb-4">
                <h5 class="mb-1">
                    <?php _e('Image du service')?>
                </h5>
                <p>
                    <?php _e('Ajouter la photo principale.')?>
                </p>
                <div id="insapp_img_preview"></div>
                <input type="file" class="form-control" id="update_product_img" value="">
            </div>
            <input type="hidden" class="insapp_update_img_service_url" value="" />
            <div id="preview"></div>
        </div>
    </div>

    <div class="row">
        <div class="card px-5">
            <div class="card-body">
                <input type="hidden" name="product_id" id="product_id">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary" style="padding: 10px 40px;">
                        <?php _e('Modifier le service')?>
                    </button>
                </div>

            </div>
        </div>
    </div>
</form>