<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php init_head(); ?>

<div id="wrapper">

    <div class="content">


        <div class="row">
          
            <div class="col-md-10 col-md-offset-1">

                <h4 class="customer-profile-group-heading" style="margin: 0">For link Open Please Enter Your Password</h4>

            </div>

        </div>

        <div class="row" id="protected">

            <div class="col-md-10 col-md-offset-1">

                <div class="panel_s" id="cars">

                    <div class="panel-body">
                         <?php if($this->session->flashdata('message-warning')){ ?>
    <div class="col-lg-12" id="alerts">
      <div class="text-center alert alert-warning">
        <?php
        echo $this->session->flashdata('message-warning');
        ?>
      </div>
    </div>
  <?php } ?>
                        <?php echo form_open('/admin/utilities/check_password/'.$this->uri->segment(4), array('class' => '', 'id' => 'password-form')); ?>

                       
                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group" app-field-wrapper="password"><label for="password" class="control-label">Password</label><input type="text" id="password" required name="password" class="form-control" value=""></div>
                                

                            </div>



                        </div>



                        <div class="text-left">

                            <!--<button type="submit" class="btn btn-info"><?php // echo _l('submit'); ?></button>-->
                            <button type="submit" id="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>

                        </div>

                        <?php echo form_close(); ?>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<style>

    .d-inline {

        display: inline-table;

    }


    .onoffswitch-label {

        margin-bottom: 0;

    }


    .swichable span {

        font-size: 18px;

    }

</style>



<script>

    appValidateForm($('#password-form'), {password: 'required'});

</script>
<script src="<?= base_url() ?>modules/prchat/assets/js/pr-chat.js?v=2.4.4"></script>


</body>

</html>

