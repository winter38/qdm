<?php



// i_check_picture()
//   checks if image exists
//   if not - replace by default
// parameters:
//   $filename - files name
// return:
//   string - filename
function i_check_picture($filename){
    
    //$file_path = I_SYS_PATH_ROOT . '/' . $filename;
    $exist = file_exists($file_path);
    
    //if file exists in requested directory show it
    if( $exist ){ return $filename; } 
    else {
        return false;
    }  
} // i_check_picture()


// i_html_but_aimg
//    draw image inside link button
// parameters:
//    $params - array of params
// return:        
//    string - html
function i_html_but_aimg($params){
    
    $params['value']  = ( isset($params['value']) )   ?  $params['value'] : ''; 
    $params['atribs'] = ( isset($params['atribs']) ) ? $params['atribs'] : '';
    $params['title']  = ( isset($params['title']) )  ? $params['title']  : '';
    
    $res  = '<a href="'.$action_script.'" target="'.$target.'">';
    $res .=  '<img align="middle" '; 
    
    $atr = array();

    $atr['title'] = $title;
    $atr['alt']   = $title;
    $atr['src']   = i_check_picture($src_pic);
    $atr['add']   = $attribs . $onMouseOver . $onMouseOut;
    $atr['style'] = 'float: left; border: none; margin: 0px 1px 0px 1px;'; //add it to class?
    
    $atr = i_html_basic_attribs($atr);
    
    $res .= $atr .'>';
    $res .= '</a>';
    
    return $res;
} // i_html_but_aimg


// i_html_but_img
//    draw image inside link button
// parameters:
//    $params - array of params
// return:        
//    string - html
function i_html_but_img($params){
    
    $params['value']  = ( isset($params['value']) )   ?  $params['value'] : ''; 
    $params['atribs'] = ( isset($params['atribs']) ) ? $params['atribs'] : '';
    $params['title']  = ( isset($params['title']) )  ? $params['title']  : '';
    
    $res =  '<input type="image" align="middle" ' . $src;
                
    $atr = array();
    $atr['title'] = $title;
    $atr['alt']   = $title;
    $atr['add']   = $onMouseOut . $onMouseOver . $attribs;
    $atr['name']  = $butt_name;
    
    $atr['style'] = 'float: left; margin: 0px 1px 0px 1px;';
    
    $atr = i_html_basic_attribs($atr); 
    $res .=  $atr  . '>';
    
    return $res;
} // i_html_but_img


// i_html_but_link()
//    draw link button
// parameters:
//    $params - array of params
// return:        
//    string - html
function i_html_but_link($params){
    
    $params['value']  = ( isset($params['value']) )  ?  $params['value'] : ''; 
    $params['atribs'] = ( isset($params['atribs']) ) ? $params['atribs'] : '';
    $params['title']  = ( isset($params['title']) )  ? $params['title']  : '';
    $params['style']  = ( isset($params['style']) )  ? $params['style']  : '';
    
    // open in new window or not
    if( isset($params['target']) ){ $params['atribs'] .= ' target="' . $params['target'] . '"'; }
    
    $params['href'] = ( isset($params['href']) ) ? $params['href'] : '';
    
    if( !isset($params['title']) ){ $title = ''; }
    else{ $title = $params['title']; }
    
    
    $atr = array();

    $atr['title'] = $title;
    $atr['class'] = 'button';
    $atr['style'] = $params['style'];
    $atr['class'] = ( isset($params['class']) )  ? $params['class'] . ' button'  : 'button';
    $atr['add']   = $params['atribs'];
    if( isset($params['left_text']) ){
         $atr['class'] .= ' padl_16';
    }
    $atr = i_html_basic_attribs($atr);
    if( empty($params['href']) ) $res = i_html_tag('div', $params['value'], $atr);
    else  $res = i_html_link($params['href'], $params['value'], $atr);
    
    if( isset($params['before']) ){
        $res = $params['before'] . $res;
    }
    
    if( isset($params['add']) ){
        $res .= $params['add'];
    }
    
    if( isset($params['after']) ){
        $res .= $params['after'];
    }
    
    return $res;
} // i_html_but_link


// i_html_but_submit()
//    draw link button
// parameters:
//    $params - array of params
// return:        
//    string - html
function i_html_but_submit($params=array()){
    
    $params['value']  = ( isset($params['value']) )   ?  $params['value'] : ''; 
    $params['atribs'] = ( isset($params['atribs']) ) ? $params['atribs'] : '';
    $params['title']  = ( isset($params['title']) )  ? $params['title']  : '';
    $params['name']  = ( isset($params['name']) )  ? $params['name']  : 'rnd_' . mt_rand(0,10000) ;
    
    $class = 'input_button';
    $res =  '<input type="submit" ';
    if( isset($params['img']) ){ 
        // check pic
        $src = 'src="/visuals/images/' . $params['img'] . '"';
        $res =  '<input type="image" ' . $src; 
        $class = 'input_image';
    }
    
    $atr = array();
    $atr['title'] = $params['title'];
    $atr['alt']   = ' ';
    $atr['id']    = ( !empty($params['id']) )    ? $params['id'] : '';
    $atr['style'] = ( !empty($params['style']) ) ? $params['style'] : '';
    $atr['class'] = ( !empty($params['class']) ) ? $params['class'] . ' ' . $class : $class;
    $atr['add']   = $params['atribs'];
    $atr['name']  = ( !empty($params['name']) )? $params['name'] : $params['type'] . '_butt';
    $atr['value'] = $params['value'];
    
    $img_folder = '/visuals/tab_buts/';
    $onmouseout = '';
    $onmouseover = '';
    $image = false;
    
    // ------------------------------------------------------------------------>
    
    $draw_image = 0;
    
    
    // If we must draw input image - make changes ----------------------------->
    // if( $image && !$draw_image ){
        
    //     $pic = $img_folder . $name . '_n.png';
    //     $pic_out = $img_folder . $name . '_n.png';
    //     $pic_over  = $img_folder . $name . '_m.png';
    //     $res =  '<input type="image" src="' . i_check_picture($pic) . '" ';
    //     if( i_check_picture($pic_out) ) $onmouseout = ' onmouseout="src=\'' . i_check_picture($pic_out) . '\';"';
    //     if( i_check_picture($pic_over) )  $onmouseover = ' onmouseover="src=\'' . i_check_picture($pic_over) . '\';"';
    //     $res .= $onmouseout . $onmouseover;
    //     // <input type="image" align="middle" >
    //     $atr['class'] .= ' but_img ' . $name;
    //     $atr['value'] = '';
    // }
    // ------------------------------------------------------------------------>
    
    
    $atr = i_html_basic_attribs($atr); 
    $res .=  $atr  . '>';
    
    return $res;
} // i_html_but_submit


// i_tpl_but_add()
//   create add button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_add($href = ''){

    $hint = i_ses_hint();

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = $hint['add']; // add label
    $res['name']  = 'add';
    $res['class'] = 'add';
    $res['href']  = $href;    

    return $res;

} // i_tpl_but_add()


// i_tpl_but_add_group()
//   create add group button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_add_group($href = ''){

    $hint = i_ses_hint();

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = $hint['add_group']; // add label
    $res['name']  = 'add';
    $res['class'] = 'add';
    $res['href']  = $href;    

    return $res;

} // i_tpl_but_add_group()


// i_tpl_but_add_object()
//   create add group button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_add_object($href = ''){

    $hint = i_ses_hint();

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = $hint['add_object']; // add label
    $res['name']  = 'add';
    $res['class'] = 'add';
    $res['href']  = $href;    

    return $res;

} // i_tpl_but_add_object()


// i_tpl_but_recycle()
//   create add group button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_recycle($href = ''){

    $hint = i_ses_hint();

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = $hint['recycle_object']; // add label
    $res['name']  = 'delete';
    $res['class'] = 'delete';
    $res['href']  = $href;    

    return $res;

} // i_tpl_but_recycle()


// i_tpl_but_cancel()
//   create cancel button template structure
// parameters:
//   $href - string - url to processor
// return:
//   array - button struction
function i_tpl_but_cancel($href = ''){
    
    $hint = i_ses_hint();

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = $hint['cancel'];
    $res['href']  = $href;
    $res['class'] = 'cancel';

    return $res;

} // i_tpl_but_cancel()

// i_tpl_but_config()
//   create config button template structure
// parameters:
//   $script - string - path to script
//   $title  - string - Name (hint) of the button
// return:
//   array - button struction
function i_tpl_but_config($script = '', $title = ''){
    
    $hint = i_ses_hint();
    
    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['href']  = $script;
    $res['title'] = $hint['cfg'];
    $res['class'] = 'setup';

    return $res;

} // i_tpl_but_config

// i_tpl_but_confirm_link()
//   create cancel button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_confirm_link(){

    $hint = i_ses_hint();
    
    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = $hint['confirm'];
    $res['class'] = 'save';

    return $res;

} // i_tpl_but_confirm_link()


// i_tpl_but_confirm_submit()
//   create cancel button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_confirm_submit(){

    $hint = i_ses_hint();
    
    $res = array();
    $res['type']  = I_FL_ELEM_BUT_SUBMIT;
    $res['title'] = $hint['confirm']; // confirm label
    $res['name']  = 'save';
    $res['value'] = 'save';

    return $res;

} // i_tpl_but_confirm_submit()

// i_tpl_but_copy()
//   create cancel button template structure
// parameters:
//   $href - string - url to processor
// return:
//   array - button struction
function i_tpl_but_copy($href = ''){

    $params['type'] = I_FL_LABEL_TYPE_HINT;
    $params['mode'] = I_FL_SYS_WIN;
    $params['tab']  = 0;

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = i_label(46, $params);
    $res['href']  = $href;
    $res['class'] = 'copy';

    return $res;

} // i_tpl_but_copy()

// i_tpl_but_delete()
//   create delete button template structure
// parameters:
//   $script - string - path to script
// return:
//   array - button struction
function i_tpl_but_delete($script = '', $class = ''){

    $hint = i_ses_hint();

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['href']  = $script;
    $res['title'] = $hint['delete']; // delete label
    if($class) $res['class'] = 'delete ' . $class;
    else       $res['class'] = 'delete';

    return $res;

} // i_tpl_but_delete


// i_tpl_but_edit()
//   create edit button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_edit(){

    $hint = i_ses_hint();

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = $hint['edit']; // edit label
    $res['class'] = 'edit';
    
    return $res;

} // i_tpl_but_edit


// i_tpl_but_exp_csv()
//   create delete button template structure
// parameters:
//   $script - string - path to script
// return:
//   array - button struction
function i_tpl_but_exp_csv($script = ''){

    $params['type'] = I_FL_LABEL_TYPE_HINT;
    $params['mode'] = I_FL_SYS_WIN;
    $params['tab'] = 0;

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = i_label(43, $params);
    $res['name']  = 'export_csv';
    $res['class'] = 'vcb_csv';
    $res['href']  = $script;

    return $res;

} // i_tpl_but_exp_csv  


// i_tpl_but_exp_csv_submit()
//   create delete button template structure
// parameters:
//   $script - string - path to script
// return:
//   array - button struction
function i_tpl_but_exp_csv_submit(){

    $params['type'] = I_FL_LABEL_TYPE_HINT;
    $params['mode'] = I_FL_SYS_WIN;
    $params['tab'] = 0;

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_SUBMIT;
    $res['title'] = i_label(43, $params);
    $res['name']  = 'export_csv';
    $res['value'] = 'export_csv';
    
    return $res;

} // i_tpl_but_exp_csv_submit 

// i_tpl_but_exp_html_submit()
//   create submit html button template structure
// parameters:
//   $script - string - path to script
// return:
//   array - button struction
function i_tpl_but_exp_html_submit(){

    $params['type'] = I_FL_LABEL_TYPE_HINT; // 20000
    $params['mode'] = I_FL_SYS_WIN;         // 9999
    $params['tab']  = 0;

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_SUBMIT;
    $res['title'] = i_label(60 ,$params); // Экспортировать HTML
    $res['name']  = 'export_html';
    $res['value'] = 'export_html';
    
    return $res;

} // i_tpl_but_exp_html_submit 

// i_tpl_but_exp_pdf()
//   create delete button template structure
// parameters:
//   $script - string - path to script
// return:
//   array - button struction
function i_tpl_but_exp_pdf($script = ''){

    $params['type'] = I_FL_LABEL_TYPE_HINT;
    $params['mode'] = I_FL_SYS_WIN;
    $params['tab'] = 0;

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = i_label(44, $params);
    $res['name']  = 'export_pdf';
    $res['class'] = 'vcb_pdf';
    $res['href']  = $script;

    return $res;

} // i_tpl_but_exp_pdf


// i_tpl_but_exp_bpmn()
//   create delete button template structure
// parameters:
//   $script - string - path to script
// return:
//   array - button struction
function i_tpl_but_exp_bpmn($script = ''){

    $params['type'] = I_FL_LABEL_TYPE_HINT;
    $params['mode'] = I_FL_SYS_WIN;
    $params['tab'] = 0;

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = i_label(44, $params);
    $res['name']  = 'export_bpmn';
    $res['class'] = 'export_bpmn';
    $res['href']  = $script;

    return $res;

} // i_tpl_but_exp_bpmn



// i_tpl_but_exp_pdf_submit()
//   create delete button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_exp_pdf_submit(){

    $params['type'] = I_FL_LABEL_TYPE_HINT;
    $params['mode'] = I_FL_SYS_WIN;
    $params['tab'] = 0;

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_SUBMIT;
    $res['title'] = i_label(44, $params);
    $res['name']  = 'export_pdf';
    $res['value'] = 'export_pdf';
    
    return $res;

} // i_tpl_but_exp_pdf_submit


// i_tpl_but_list_exp()
//   create delete button template structure
// parameters:
//   $script - string - path to script
// return:
//   array - button struction
function i_tpl_but_list_exp($script = ''){

    $params['type'] = I_FL_LABEL_TYPE_HINT;
    $params['mode'] = I_FL_SYS_WIN;
    $params['tab'] = 0;

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['href']  = $script;
    $res['title'] = 'Export*';//i_label(3, $params);
    $res['class'] = 'list_exp';
    $res['class'] = 'calue';

    return $res;

} // i_tpl_but_list_exp


// i_tpl_but_mass_op()
//   create mass operation button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_mass_op(){
    
    $hint = i_ses_hint();
    
    $res = array();
    $res['type']  = I_FL_ELEM_BUT_SUBMIT;
    $res['title'] = $hint['mass_op'];
    $res['name']  = 'mass_op';
    $res['value'] = 'mass_op';
    $res['class'] = '';
    
    return $res;
    
} // i_tpl_but_mass_read()

// i_tpl_but_mass_op()
//   create mass operation button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_mass_read(){
    
    $res = array();
    $res['type']  = I_FL_ELEM_BUT_SUBMIT;
    $res['name']  = 'mass_read';
    $res['value']  = 'mass_read';
    $res['class'] = 'mass_read';
    
    return $res;
    
} // i_tpl_but_mass_read()

// i_tpl_but_no()
//   create edit button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_no(){

    $hint = i_ses_hint();

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = $hint['no']; // no label
    $res['class'] = 'cancel';

    return $res;

} // i_tpl_but_no


// i_tpl_but_preview()
//   create preview button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_preview($class = ''){

    $params['type'] = I_FL_LABEL_TYPE_HINT;
    $params['mode'] = I_FL_SYS_WIN;
    $params['tab'] = 0;

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_SUBMIT;
    $res['title'] = i_label(39, $params); // simple save label
    $res['name']  = 'preview';
    $res['value'] = 'preview';
    $res['class'] = $class;

    return $res;

} // i_tpl_but_preview()

// i_tpl_but_reply()
//   create reply button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_reply(){

    
    $params['type'] = I_FL_LABEL_TYPE_HINT;
    $params['mode'] = I_FL_MOD_MSG_A;
    $params['tab']  = I_FL_TAB_CARD;
    
    $res = array();
    $res['type']  = I_FL_ELEM_BUT_SUBMIT;
    $res['title'] = i_label(2, $params);
    $res['name']  = 'reply';
    $res['value'] = 'reply';

    return $res;

} // i_tpl_but_reply()


// i_tpl_but_reply_2()
//   create reply button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_reply_2(){

    
    $params['type'] = I_FL_LABEL_TYPE_HINT;
    $params['mode'] = I_FL_MOD_MSG_A;
    $params['tab']  = I_FL_TAB_CARD;
    
    $res = array();
    $res['type']  = I_FL_ELEM_BUT_SUBMIT;
    $res['title'] = i_label(2, $params);
    $res['name']  = 'reply_btn';
    $res['value'] = '';

    return $res;

} // i_tpl_but_reply_2()


// i_tpl_but_save()
//   create cancel button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_save(){

    $hint = i_ses_hint();

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_SUBMIT;
    $res['title'] = $hint['save']; // simple save label
    $res['name']  = 'save';
    $res['value'] = 'save';

    return $res;

} // i_tpl_but_save()


// i_tpl_but_vcb_hist()
//   create history button template structure
// parameters:
//   $script - string - path to script
// return:
//   array - button struction
function i_tpl_but_vcb_hist($script = ''){


    $params['type'] = I_FL_LABEL_TYPE_HINT;
    $params['mode'] = I_FL_SYS_WIN;
    $params['tab'] = 0;

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = i_label(40, $params); // no label
    $res['href']  = $script;
    $res['class'] = 'vcb_hist';

    return $res;
    
} // i_tpl_but_vcb_hist


// i_tpl_but_yes()
//   create edit button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_yes(){

    $hint = i_ses_hint();

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = $hint['yes'];
    $res['class'] = 'save';

    return $res;

} // i_tpl_but_yes


// i_tpl_but_back()
//   create edit button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_back(){

    $hint = i_ses_hint();

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = $hint['back'];
    $res['class'] = 'list_prev';

    return $res;

} // i_tpl_but_back


// i_tpl_but_right_blue()
//   create edit button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_right_blue(){

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = '';
    $res['class'] = 'list_prev';

    return $res;

} // i_tpl_but_right_blue



// i_tpl_but_reset()
//   create edit button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_reset(){

    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = '';
    $res['class'] = 'list_prev';

    return $res;

} // i_tpl_but_reset


// i_tpl_but_restore()
//   create edit button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_restore(){
    
    $hint = i_ses_hint();
    
    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = $hint['restore'];
    $res['class'] = 'restore';

    return $res;

} // i_tpl_but_restore


// i_tpl_but_archive()
//   create edit button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_archive(){
    
    $hint = i_ses_hint();
    
    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = $hint['archive'];
    $res['class'] = 'bt_archive';

    return $res;

} // i_tpl_but_archive


// i_tpl_but_blue_next()
//   create edit button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_blue_next(){
    
    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = '';
    $res['class'] = 'bt_blue_next';

    return $res;

} // i_tpl_but_blue_next


// i_tpl_but_blue_next()
//   create edit button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_import(){
    
    $hint = i_ses_hint();
    
    $res = array();
    $res['type']  = I_FL_ELEM_BUT_SUBMIT;
    $res['title'] = $hint['import'];
    $res['name']  = 'import';
    $res['class'] = 'bt_blue_up bps_submit';
    
    return $res;

} // i_tpl_but_blue_next


// i_tpl_but_blue_next()
//   create edit button template structure
// parameters:
//   -
// return:
//   array - button struction
function i_tpl_but_export(){
    
    $hint = i_ses_hint();
    
    $res = array();
    $res['type']  = I_FL_ELEM_BUT_SUBMIT;
    $res['title'] = $hint['export'];
    $res['name']  = 'export';
    $res['class'] = 'bt_blue_down bps_submit';

    return $res;

} // i_tpl_but_blue_next


// i_tpl_but_blue_reset()
//   create edit button template structure
// parameters:
//   -
// return:
//   array - button struction

function i_tpl_but_blue_reset(){
    
    $res = array();
    $res['type']  = I_FL_ELEM_BUT_A;
    $res['title'] = '';
    $res['class'] = 'bt_blue_reset';

    return $res;

} // i_tpl_but_blue_reset
?>