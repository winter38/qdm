<?php



function ft_shop(&$player){

    global $ui;

    $items = qdm_shop_list($player['location']);
    $style = '';
    $buf   = '';

    $ci = count($items);

    $buf .= '<div class="gold_limit"><span class="gold_coin"></span><span class="gold_val">'.$player['gold'].'</dspan></div>';
    $buf .= '<div class="store_header_buy">Купить</div>';
    $buf .= '<div class="buy_block">';
    // $buf .= '<div><input type="submit" value="Подтвердить сделку"></div>';
    
    for( $i = 0; $i < $ci; $i++ ){ 

        $price = $items[$i]['price_max'];
        $style .= '.item_'.$items[$i]['id'].'{background-image: url(' . $ui['items'] . $items[$i]['id'] . '.png);}';
        $descr = $items[$i]['name'] . '. Цена: ' . $price . ' з' . "\n". $items[$i]['descr'];
        $buf .= '<div name="'.$items[$i]['name'].'" price="'.$price.'" class="div_items item_'.$items[$i]['id'].' js_item_buy" title="'. $descr.'" item_id="'.$items[$i]['id'].'">';
        $buf .= '<span class="div_items_price"><span class="gold_coin"></span>'.$price.'</span>';
        $buf .= '</div>';
        // $res .= '<tr>';
        // $res .= '<td class="items_img"><img src="'. $ui['items'] . $items[$i]['item_id'] . '.png"></td>';
        // $res .= '<td>' . $items[$i]['name'] . '</td>';
        // $res .= '<td>' . $items[$i]['count'] . '</td>';
        // $res .= '</tr>';
    }
    $buf .= '<div class="clear"></div>';
    $buf .= '</div>';


    $buf .= '<div class="clear"></div>';
    $buf .= '<div class="store_header_sell">Продать</div>';
    $buf .= '<div class="sell_block">';
    $items_for_sale = qdm_player_items($player['id']);
    if( !$items_for_sale ) $buf .= '<div>Инвентарь пуст</div>';
    else{

        // $buf .= '<table class="table_items">';
        // $res .= '<tr><th>I</th><th>Наименование</th><th>Количество</th></tr>';
        $ci = count($items_for_sale);
        for( $i = 0; $i < $ci; $i++ ){ 
            // $buf .= '<tr>';
            $style .= '.item_'.$items_for_sale[$i]['item_id'].'{background-image: url(' . $ui['items'] . $items_for_sale[$i]['item_id'] . '.png);}';
            //$buf .= '<td class="sell_item_icon_td">';
            $title = $items_for_sale[$i]['name'] . "\n" . 'Стоимость продажи: ' . $items_for_sale[$i]['price_min'] . 'з';
            $buf .= '<div class="div_items item_'.$items_for_sale[$i]['item_id'].' js_item_sell" item_id="'.$items_for_sale[$i]['item_id'].'" title="'. $title .'">';
            $buf .= '<span class="div_items_count">'.$items_for_sale[$i]['count'].'</span>';
            $buf .= '<span class="div_items_price"><span class="gold_coin"></span>'.$items_for_sale[$i]['price_min'].'</span>';
            $buf .= '</div>';
            //$buf .= '</td>';

            // $buf .= '<td>';
            // $buf .= qdm_shop_item_price($items_for_sale[$i]['item_id']);
            // $buf .= '</td>';
            // $buf .= '<td>';
            // $buf .= '<input type="text" value="0" name="item['.$items_for_sale[$i]['item_id'].']">';
            // $buf .= '</td>';
            // $buf .= '</div>';
            
            // $res .= '<td class="items_img"><img src="'. $ui['items'] . $items[$i]['item_id'] . '.png"></td>';
            // $res .= '<td>' . $items[$i]['name'] . '</td>';
            // $res .= '<td>' . $items[$i]['count'] . '</td>';
            // $buf .= '</tr>';
        }
        // $buf .= '</table>';
    }
    $buf .= '<div class="clear"></div>';
    //$buf .= '<div><input type="submit" value="Подтвердить сделку"></div>';
    $buf .= '</div>';

    $style = '<style>' . $style . '</style>';

    $res = $style . '
    <div class="data_block">
        <table class="store_table">
            <tr>
                <td class="trader_td">
                    <div class="trader">
                        <div class="trader_cloud"> Не желаешь прикупиться?</div>
                        <div><img src="' .$ui['trader'] . $player['location']. '.png"></div>
                    </div>
                </td>
                <td>
                    <div class="store">' . $buf . '</div>

                    <div class="clear"></div>
                </td>
            </tr>
        </table>
    </div>';



    return $res;
}



?>