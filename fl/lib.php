<?php



// -------------------------------------------->
//  calc_exp()
//    calcs level and exp to next level
//  parameters:
//    $exp     (int) - current player experiance
//    $opp_exp (int) - current opponent experiance
//  return
//    (array) - gained exp info
//  notes:  -
//
// -------------------------------------------->
function calc_exp($exp, $modificator = 1, $dmg){

    $p1 = calc_level($exp);
    // $p2 = calc_level($opp_exp);
    $experiance = round($dmg*$modificator);
    
    if( $experiance < 0 ) $experiance = 1;
    $exp_summ = $experiance + $exp;
    $p1_new = calc_level($exp_summ);
    
    $res = array();
    $res['dmg'] = $dmg;
    $res['exp'] = $exp_summ;
    $res['exp_earned'] = $experiance;
    $res['up']  = $p1_new['lvl'] - $p1['lvl'];
    $res['lvl'] =  $p1['lvl'];
    $res['new_lvl']  = $p1_new['lvl'];
    $res['bonus'] = 0;

    return $res;
}




// -------------------------------------------->
//  calc_level()
//    calcs level and exp to next level
//  parameters:
//    $exp (int) - current experiance
//  return
//    array
//     ['lvl']      - int -  current level
//     ['to_level'] - int -  exp to next level
//  notes:  -
//
// -------------------------------------------->
function calc_level($exp){

    $level = 1;
    $to_level = 0;
    $exp_level = 0;

    if( !$exp ){ $exp = 1; } // if 0 - will tell us 0 level

    // Lebel_exp = 500 * (LEVEL-1)^2 - 500 * (LEVEL-1)
    // calc level - its epic simple =D
    $level = floor(( 500 + sqrt(250000 + 2000 * $exp) ) / 1000);
    
    
    $current_level_exp = 0;
    // calc exp
    $ci = $level + 1; // calc exp to next level
    for( $i = 1; $i < $ci; $i++ ){
        $current_level_exp = ($i-1)*1000 + $current_level_exp;
    }

    $to_level = $current_level_exp + $level*1000;
    $guage = round((($exp - $current_level_exp) / ($level*1000))*100); // procents

    $data = array();
    $data['lvl']      = $level;
    $data['exp']      = $exp;
    $data['to_level'] = $to_level;
    $data['progress'] = $guage;

    return $data;

}


function go_back(){
    $link = $_SERVER['HTTP_REFERER'];
    Header("Location:$link");
}


function qdm_level_up($player, $level){

    // d_echo($player);
    $pts = 1;
    $skill = 0;

    switch( $level ){
        default:{
            // TODO: decide in which levels

            break;
        }
    }
    // each 3 levels
    if( !($level % 3) ) $skill = 1;
    if( !($level % 3) ) $pts = 1;

    qdm_add_pts($player['id'], $pts);
    qdm_add_pts_skill($player['id'], $skill);
}


// i_ufsi_image_resize()
//   resize and saves image.
// parameters:
//   $imagename         - string - image filename
//   $max_new_w         - int    - new maximal width
//   $max_new_h         - int    - new maximal height
//   $dir               - string - dir were file will be saved
//   $file              - string - image name 
//   $can_become_bigger - int    - allow image resize, to fit into max width or height as much as possible
// return:
//   true  - ok
//   false - error
 
//    resizing PNG, GIF formats.
//    we currently don't need JPEG, so it's disabled, if needed check if php build has jpg support
function ufsi_image_resize($imagename, $max_new_w = 200, $max_new_h = 200, $dir = '', $file, $can_become_bigger = false){
    
    
    // get image data --------------------------------------------------------->
    $img_data = getimagesize($imagename);
    
    if( $img_data === false ) return false;
    
    list($w, $h, $type) = $img_data;
    $mime = $img_data['mime'];
    // ------------------------------------------------------------------------>
    
    
    // check if --------------------------------------------------------------->
    $out_full_name = $dir . '/' . $file;
    
    $dir_exists   = file_exists($dir);
    $dir_writable = is_writable($dir);
    
    
    // check if directory exists, and we can write to it
    if( !$dir_exists || !$dir_writable ) return false;
    
    $file_exists   = file_exists($out_full_name);
    $file_writable = is_writable($out_full_name);
    
    // check if file exists and if we can overwrite it
    if( $file_exists === true && $file_writable == false ) return false;
    //------------------------------------------------------------------------->
    
    
    // calculate selected image size and parameters for 
    // images that will be created -------------------------------------------->
    
    // destination dimensions
    $dst_w = $w;
    $dst_h = $h;
    
    // make image proportionaly bigger ---------------------------------------->
    if( $can_become_bigger === true ){
        
        if( $dst_w < $max_new_w ){
            $hw_ratio = $dst_h / $dst_w;
            $dst_w = $max_new_w;
            $dst_h = (int)($max_new_w  * $hw_ratio);
        }
        
        if( $dst_h < $max_new_h ){
            $wh_ratio = $dst_w / $dst_h;
            $dst_h = $max_new_h;
            $dst_w = (int)($max_new_h  * $wh_ratio);
        }
        
    }
    // ------------------------------------------------------------------------>
    
    
    // make picture proportionaly smaller to fit max size --------------------->
    if( $dst_w > $max_new_w ){
        $hw_ratio = $dst_h / $dst_w;
        $dst_w = $max_new_w;
        $dst_h = (int)($max_new_w  * $hw_ratio);
    }
    
    if( $dst_h > $max_new_h ){
        $wh_ratio = $dst_w / $dst_h;
        $dst_h = $max_new_h;
        $dst_w = (int)($max_new_h  * $wh_ratio);
    }
    // ------------------------------------------------------------------------>
    
    
    //source dimensions ------------------------------------------------------->
    $src_w = $w;
    $src_h = $h;
    
    //destination position
    $dst_x = 0;
    $dst_y = 0;
    
    //source position
    $src_x = 0;
    $src_y = 0;
    //------------------------------------------------------------------------->
    
    
    // create images using GD2 ------------------------------------------------>
    $tpl            = imagecreatetruecolor($dst_w, $dst_h);
    $color_transp   = imagecolorallocatealpha($tpl, 255, 255, 255, 127);
    imagefill($tpl, 0, 0, $color_transp);
    
    
    switch( $type ){
    
        case IMAGETYPE_GIF:{
            
            if( !function_exists('imagecreatefromgif') ){
                return false;
            }
            
            $img = imagecreatefromgif($imagename);
            break;
        }
        
        
        case IMAGETYPE_JPEG:{
            
            if( !function_exists('imagecreatefromjpeg') ){
                return false;
            }
            
            $img = imagecreatefromjpeg($imagename);
            break;
        }
        
        
        case IMAGETYPE_PNG:{
            
            if( !function_exists('imagecreatefrompng') ){
                return false;
            }
            
            $img = imagecreatefrompng($imagename);
            break;
        }
        
        
        default:{
            return false;
            break;
       }
    }
    
    if( $img === false ) return false;
    
    imagesavealpha($tpl, true);
    imagesavealpha($img, true);
    
    $copied = imagecopyresampled($tpl, $img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
    
    if( $copied === false ) return false;
    //------------------------------------------------------------------------->
    
    
    // save file -------------------------------------------------------------->
    switch($mime){
        case 'image/jpeg':
        case 'image/pjpeg':{
            
            if( !function_exists('imagejpeg') ){
                return false;
            }
            
            $result = imagejpeg($tpl, $out_full_name, 100);
            break;
        }
        
        case 'image/gif':{
            
            if( !function_exists('imagegif') ){
                return false;
            }
            
            $result = imagegif($tpl, $out_full_name);
            break;
        }
        
        
        case 'image/png':    
        case 'image/x-png':{
            
            if( !function_exists('imagepng') ){
                return false;
            }
            
            $result = imagepng($tpl, $out_full_name, 0);
            break;
        }
        
        default:{
            return false;
            break;
        }
    }
    //------------------------------------------------------------------------->
    
    
    if( $result === false ) return false;
    
    return true;
    
} // ufsi_image_resize

?>