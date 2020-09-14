<div class="row">

    <div class="col-md-6">
        <?php $value = (isset($stock_manager) ? $stock_manager->sku : ''); ?>
        <?php $attrs = (isset($stock_manager) ? array() : array('autofocus' => true)); ?>
        <?php echo render_input('sku', 'SKU', $value, 'text', $attrs); ?>
        <div id="sku_exists_info" class="hide"></div>
        <!-- <?php /*$value = (isset($stock_manager) ? $stock_manager->address : ''); */ ?>
                        --><?php /*echo render_textarea('address', 'client_address', $value); */ ?>
        
        <?php $value = (isset($stock_manager) ? $stock_manager->product_type : ''); ?>
        <?php echo render_input('product_type', 'Product Type', $value); ?>
        
        <?php $value = (isset($stock_manager) ? $stock_manager->price : ''); ?>
        <?php echo render_input('price', 'Price', $value); ?>
       
        <?php
        $selected = isset($stock_manager) ? $stock_manager->stock_status : 1;
        $datas = array(array('id' => 0, 'value' => 'Out of Stock'), array('id' => 1, 'value' => 'In Stock'));
        echo render_select('stock_status', $datas, array('id', 'value'), 'Stock status', $selected, array()); ?>
    
       <?php $value = (isset($stock_manager) ? $stock_manager->stock : ''); ?>
        <?php echo render_input('stock', 'Stock', $value); ?>
       

    </div>
    <div class="col-md-6">
    <?php $value = (isset($stock_manager) ? $stock_manager->name : ''); ?>
        <?php echo render_input('Name', 'name', $value); ?>
        <?php $value = (isset($stock_manager) ? $stock_manager->parent_id : ''); ?>
        <?php echo render_input('parent_id', 'Parent Id', $value); ?>

        <?php
        $selected = isset($stock_manager) ? $stock_manager->manage_stock : 1;
        $datas = array(array('id' => 0, 'value' => 'No'), array('id' => 1, 'value' => 'Yes'));
        echo render_select('manage_stock', $datas, array('id', 'value'), 'Manage Stock', $selected, array()); ?>
        <?php
        $selected = isset($stock_manager) ? $stock_manager->backorders : 1;
        $datas = array(array('id' => 0, 'value' => 'No'), array('id' => 1, 'value' => 'Yes'));
        echo render_select('backorders', $datas, array('id', 'value'), 'Backorders', $selected, array()); ?>
    </div>

  
</div>

<div class="text-right">
    <button type="submit" class="btn btn-info"><?php echo _l('submit'); ?></button>
</div>
