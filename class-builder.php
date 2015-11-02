<?php
require_once(dirname(__FILE__).'/dzs_functions.php');

class DZSprg_Builder{
    public $frontend_errors = array();
    public $db_skins = array();
    public $db_skin_data = array();
    public $currSkin = 'custom';
    function __construct(){
        
        
        if(isset($_GET['skin'])==false || $_GET['skin']==''){
            $this->currSkin = 'custom';
        }else{
            $this->currSkin = $_GET['skin'];
        }
        
        
        $db_skins_aux = file_get_contents('db/db_skins.txt');
        
        if($db_skins_aux == ''){
            $this->db_skins = array();
        }else{
            $this->db_skins = unserialize($db_skins_aux);
        }
        
        $db_skin_data_aux = file_get_contents('db/skin-'.$this->currSkin.'.txt');
        
        if($db_skin_data_aux == ''){
            $this->db_skin_data = array();
        }else{
            $this->db_skin_data = unserialize($db_skin_data_aux);
        }
        
//        print_r($this->db_skin_data);
        
        
        if(isset($_POST['builder_skin_name']) && $_POST['builder_skin_name']!=''){
            $this->post_receive_new_skin();
        }
        
        if(isset($_POST['action']) && $_POST['action']=='dzsprg_saveskin'){
            $this->post_save_skin();
        }
    }
    
    
    function post_save_skin(){
        
        if(is_dir(dirname(__FILE__).'/db') == false){
            mkdir(dirname(__FILE__).'/db', 0755, true);
        }
        
        $this->currSkin = $_POST['currSkin'];
        
        $file = (dirname(__FILE__)).'/db/skin-'.$this->currSkin.'.txt';
        
        
        parse_str($_POST['postdata'], $auxarray);
        
//        print_r($auxarray);
        
        
        
        $mainarray_s = serialize($auxarray);
        $fp = file_put_contents($file, $mainarray_s);
//        echo $file.' '.$mainarray_s;
        
        if($fp){
            echo 'success - file saved';
        }else{
            
            echo 'error - file not saved';
        }
        
        die();
    }
    function post_receive_new_skin(){
        
        
        //custom is the default custom skin
        if ($_POST['builder_skin_name']=='custom' || in_array($_POST['builder_skin_name'], $this->db_skins)) {
            array_push($this->frontend_errors, '<div class="error">skin already exists</div>');
            return;
        }
        
//        print_r($this->db_skins);
        
        array_push($this->db_skins, $_POST['builder_skin_name']);
        $file = (dirname(__FILE__)).'/db/db_skins.txt';
        
        $current = serialize($this->db_skins);
        
        $fp = null;
        if(file_exists($file)){
            
            $fp = file_put_contents($file, $current);
        }else{
            if(is_dir(dirname(__FILE__).'/db') == false){
                mkdir(dirname(__FILE__).'/db', 0755, true);
            }
            $fp = fopen($file,"wb");
            fwrite($fp,$current);
            fclose($fp);
        }
        
        
        if($fp){
            
        }else{
            
            array_push($this->frontend_errors, '<div class="error">file not saved</div>');
        }
//        die();
    }
    
    
    
    function generate_layer_item($pargs = array()) {

        $margs = array(
            'position_type' => 'relative',
            'index' => '0',
            'width' => '100%',
            'height' => '40',
            'top' => '0',
            'right' => 'auto',
            'bottom' => 'auto',
            'left' => '0',
            'margin_top' => '0',
            'margin_right' => '0',
            'margin_bottom' => '0',
            'margin_left' => '0',
            'border_radius' => '0',
            'border' => '0',
            'color' => '#eeeeee',
            'background_color' => '#285e8e',
            'type' => 'rect',
            'animation_brake' => '',
            'font_size' => '12',
            'text_align' => 'left',
            'color' => '#ffffff',
            'opacity' => '1',
            'text' => '',
            'font_size' => '12',
            'circle_outside_fill' => '#fb1919',
            'circle_inside_fill' => 'transparent',
            'circle_outer_width' => '{{perc-decimal}}',
            'circle_line_width' => '10',
            'extra_classes' => '',
        );

        $margs = array_merge($margs, $pargs);

        $struct_item = '';


        $struct_item = '<div class="builder-layer type-'.$margs['type'].'"><div class="builder-layer--head">'
                . '<input type="hidden" name="bars['.$margs['index'].'][type]" value="'.$margs['type'].'"/>'
                . '<span class="the-title">'.$margs['type'].'</span><span class="sortable-handle-con"><span class="sortable-handle"></span></span>'
                . '</div>';
        
        $struct_item.='<div class="builder-layer--inside">';

        $struct_item.= '<div class="dzs-tabs skin-box">';
            
            if($margs['type']=='text'){
                $struct_item.='<div class="setting type-text">
<textarea class="builder-field with-tinymce" name="bars['.$margs['index'].'][text]">'.$margs['text'].'</textarea>
</div>';
            }
        $struct_item.='<div class="dzs-tab-tobe">
            <div class="tab-menu with-tooltip">
            Position
            </div>
            <div class="tab-content">
            <div class="setting">
            <div class="setting-label">Type</div>';
            $lab = 'position_type';
            $struct_item.=DZSHelpers::generate_select('bars['.$margs['index'].']['.$lab.']', array('options' => array('relative','absolute'), 'class' => 'styleme builder-field', 'seekval' => $margs[$lab]));
            
            $struct_item.='</div>
            <div class="one-half">
            <div class="setting">
            <div class="setting-label">Width</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][width]" value="'.$margs['width'].'">
                </div>
                </div>
            <div class="one-half">
            <div class="setting">
            <div class="setting-label">Height</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][height]" value="'.$margs['height'].'">
                </div>
                </div>
    <div class="clear"></div>


            <hr>
            <div class="one-half" style="float:none; margin: 0 auto;">
            <div class="setting">
            <div class="setting-label">Top</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][top]" value="'.$margs['top'].'">
                </div>
                </div>
    <div class="clear"></div>

            <div class="one-half">
            <div class="setting">
            <div class="setting-label">Left</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][left]" value="'.$margs['left'].'">
                </div>
                </div>
            <div class="one-half">
            <div class="setting">
            <div class="setting-label">Right</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][right]" value="'.$margs['right'].'">
                </div>
                </div>
    <div class="clear"></div>

            <div class="one-half" style="float:none; margin: 0 auto;">
            <div class="setting">
            <div class="setting-label">Bottom</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][bottom]" value="'.$margs['bottom'].'">
                </div>
                </div>
    <div class="clear"></div>

            <hr>
            <div class="one-half" style="float:none; margin: 0 auto;">
            <div class="setting">
            <div class="setting-label">Margin Top</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][margin_top]" value="'.$margs['margin_top'].'">
                </div>
                </div>
    <div class="clear"></div>
            <div class="one-half">
            <div class="setting">
            <div class="setting-label">Margin Left</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][margin_left]" value="'.$margs['margin_left'].'">
                </div>
                </div>
            <div class="one-half">
            <div class="setting">
            <div class="setting-label">Margin Right</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][margin_right]" value="'.$margs['margin_right'].'">
                </div>
                </div>
    <div class="clear"></div>

            <div class="one-half" style="float:none; margin: 0 auto;">
            <div class="setting">
            <div class="setting-label">Margin Bottom</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][margin_bottom]" value="'.$margs['margin_bottom'].'">
                </div>
                </div>
    <div class="clear"></div>

            </div>


        </div>

            <div class="dzs-tab-tobe">
                <div class="tab-menu with-tooltip">
                Styling
                </div>
                <div class="tab-content">
                <div class="setting ">
            <div class="setting-label">Background Color</div>
            <input class="builder-field with-colorpicker" type="text" name="bars[' . $margs['index'] . '][background_color]" value="'.$margs['background_color'].'"><span class="picker-con picker-left"><span class="the-icon"></span><span class="picker"></span></span>
                </div>
                <div class="setting type-text">
            <div class="setting-label">Color</div>
            <input class="builder-field with-colorpicker" type="text" name="bars[' . $margs['index'] . '][color]" value="'.$margs['color'].'"><span class="picker-con picker-left"><span class="the-icon"></span><span class="picker"></span></span>
                </div>
                <div class="setting type-circ">
            <div class="setting-label">Outer Circle Color</div>
            <input class="builder-field with-colorpicker" type="text" name="bars[' . $margs['index'] . '][circle_outside_fill]" value="'.$margs['circle_outside_fill'].'"><span class="picker-con picker-left"><span class="the-icon"></span><span class="picker"></span></span>
                </div>
                <div class="setting type-circ">
            <div class="setting-label">Inner Circle Color</div>
            <input class="builder-field with-colorpicker" type="text" name="bars[' . $margs['index'] . '][circle_inside_fill]" value="'.$margs['circle_inside_fill'].'"><span class="picker-con picker-left"><span class="the-icon"></span><span class="picker"></span></span>
                </div>
                
                <div class="setting type-circ">
            <div class="setting-label">Arc Percentage</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][circle_outer_width]" value="'.$margs['circle_outer_width'].'">
                </div>
                <div class="setting type-circ">
            <div class="setting-label">Outer Circle Width</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][circle_line_width]" value="'.$margs['circle_line_width'].'">
                </div>
                <div class="setting type-rect">
            <div class="setting-label">Border Radius</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][border_radius]" value="'.$margs['border_radius'].'">
                </div>
                <div class="setting">
            <div class="setting-label">Border</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][border]" value="'.$margs['border'].'">
                </div>
                <div class="setting">
            <div class="setting-label">Opacity</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][opacity]" value="'.$margs['opacity'].'">
                </div>
                <div class="setting">
            <div class="setting-label">Font Size</div>
            <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][font_size]" value="'.$margs['font_size'].'">
                <div class="jqueryui-slider for-fontsize"></div>
                </div>
                <div class="setting ">
                    <div class="setting-label">Extra Classes</div>
                    <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][extra_classes]" value="'.$margs['extra_classes'].'">
                </div>
                <!--
            <div class="setting type-text">
            <div class="setting-label">Text Align</div>';
            $lab = 'text_align';
            $struct_item.=DZSHelpers::generate_select('bars['.$margs['index'].']['.$lab.']', array('options' => array('left','center','right'), 'class' => 'styleme builder-field', 'seekval' => $margs[$lab]));
            
            $struct_item.='</div>
-->
                <br>
                </div>
            </div>
            <div class="dzs-tab-tobe">
                <div class="tab-menu with-tooltip">
                Animation
                </div>
                <div class="tab-content">
                
                <div class="setting">
                    <div class="setting-label">Animation Brake</div>
                    <input class="builder-field" type="text" name="bars[' . $margs['index'] . '][animation_brake]" value="'.$margs['animation_brake'].'">
                    <div class="sidenote">'.__('Test', 'dzsprg').'</div>
                </div>
            
                </div>
            </div>

        </div>';
        
        $struct_item.='<a href="#" class="builder-layer--btn-delete">Delete Item</a>';
        $struct_item.='</div>';
        $struct_item.='</div>';
        return $struct_item;
    }
    
    
}

if(!function_exists('__')){
    function __($arg1, $arg2=''){
        return $arg1;
    }
}