<?php


define('HTML_ELEM_FILE',   1);
define('HTML_ELEM_SUBMIT', 2);


// i_html_attribs()
//   glues html attribs for tags
//   makes basic checks, like empty string
// parameters:
//   $data - array
//           ['alt']   - string - element id
//           ['title'] - string - element id
//           ['style'] - string - tag style
//           ['class'] - string - tag class
//           ['name']  - string - name attribute
//           ['add']   - string - concat additional parametrs 
//           ['src']   - string - for input
//           ['id']    - string - id attribute
// return:
//   string - html part
 

function i_html_basic_attribs(&$data){
    
    $res = '';
    
    $keys = array_keys($data);
    $values = array_values($data);
    $ci = count($keys);
    for( $i = 0; $i < $ci; $i++ ){
    
        $key = $keys[$i];
        $value = $values[$i];
        
        switch( $key ){

            case 'title':
                    if( $value !== '' ){ 
                        $value = htmlescape($value);
                        $res .= ' title="' . $value . '" ';  
                    }
                break;
            case 'alt':
                    if( $value !== '' ){ 
                        $value = htmlescape($value);
                        $res .= ' alt="' . $value . '" ';  
                    }
                break;
            
            case 'class': if( $value !== '' ){ $res .= ' class="' . $value . '" ';  }  break;
            case 'style': if( $value !== '' ){ $res .= ' style="' . $value . '" ';  }  break;
            case 'src':   if( $value !== '' ){ $res .= ' src="'   . $value . '" ';  }  break;
            case 'name':  if( $value !== '' ){ $res .= ' name="'  . $value . '" ';  }  break;
            case 'id':    if( $value !== '' ){ $res .= ' id="'    . $value . '" ';  }  break;
            case 'value': if( $value !== '' ){ $res .= ' value="' . $value . '" ';  }  break;
            case 'add':   if( $value !== '' ){ $res .= $value . ' ';  }               break;
            
            default: break;
        }
    }
    
    return $res;
} // i_html_basic_attribs


// i_html_field_file()
//   draw file upload element
// parameters:
//   &$params - array  - params
//      ['id']       - string - html id
//      ['name']     - string - element name
//      ['multiple'] - mixed  - enable hml5 multi select, upload for files
// return:        
//   $data - mixed(string) - html
// dependancies:  
//   -

//   See html5 info for atribute - multiple
//   Warning - for multiple upload name must be an array for post - name[]
//   multiple support - FF 3.6+, GHrome 8+, Opera 10.62+, Safari 5+
function i_html_field_file(&$params){
    
    // http://www.mysite.com/upload.php
    
    // = '<form action="' . $action . '" method="post" enctype="multipart/form-data">
    $id    = ( isset($params['id']) ) ? ' id="' . $params['id'] . '"' : '';
    $name  = ( isset($params['name']) ) ? ' name="' . $params['name'] . '"' : '';
    $multi = ( isset($params['multiple']) && $params['multiple'] ) ? ' multiple="multiple"' : '';
    $class = ( isset($params['class']) ) ? ' class="' . $params['class'] . '"' : '';
    $style = empty($params['style']) ? '' : ' style="' . $params['style'] . '"';
    
    $buf  = '<input type="file"' . $id .  $name . $multi . $class . $style . '>';
    
    if( isset($params['obj_js_file']) && $params['obj_js_file'] ) $buf .= '<div id="res"></div>';
    
    return $buf;

} // i_html_field_file

?>