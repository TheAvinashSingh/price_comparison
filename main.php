<?php
// Get Web Page Data using URL

$web_page_data =  file_get_contents("http://www.pricetree.com/search.aspx?q=moto+g4");

echo "Data Output of above link"."<br/>";
echo "--------------------------------"."<br/>";

// We need particular data from the page and not the whole content
$item_list =explode('<div class="items-wrap">', $web_page_data); //from entire webpage it will split based on word <div class="items-wrap">

//Item list is an array so print_r
//print_r($item_list);

//array 0 contains un necessary info so avoid it adn loop of 4
for ($i=1;$i<=4;$i++){

    //echo $item_list[$i]; //this array is separated based on split string <div class="items-wrap">
    //i want title and another information
    // it is printing 4 items and without link and image
    // i want image url and item link
    // for list item split based on href=" and then " because i want url between them

    $url_link1 =explode('href="',$item_list[$i]);
    $url_link2 = explode('"',$url_link1[1]); // $url_link1[0] will be before http=" data
    //echo $url_link2[0]."<br/>"; // split by " and before that

    //now image url, same as above with data-original=" and "

    $image_link1 =explode('data-original="',$item_list[$i]);
    $image_link2 = explode('"',$image_link1[1]); // $image_link1[0] will be before data-original="
    //echo $image_link2[0]."<br/>"; // split by " and before that

    // I want title which contain name and the status about which store
    //getting title and split between title=" and "

    $title1 =explode('<div class="item-tag">',$item_list[$i]);
    $title2 = explode('</div>',$title1[1]);

    // get only avilable items
    //split between - avail-stores">  and   </div>

    $available1= explode('avail-stores">',$item_list[$i]);
    $available = explode('</div>',$available1[1]);
    if (strcmp($available[0],"Not available") == 0) {
        // means product not available
        continue;

        // goto next product in "for loop"
    }

    $item_title = $title2[0];
    $item_link = $url_link2[0];
    $item_image_link = $image_link2[0];
    $item_id1 =explode("-",$item_link);
    $item_id = end($item_id1); //split with "-" and print last one after split i.e id
    echo $item_title."<br/>";
    echo $item_link."<br/>";
    echo $item_image_link."<br/>";
    echo $item_id."<br/>";


    // go to pricetree access api to get price list
    // price list will be accessible based on $item_id
    $request = "http://www.pricetree.com/dev/api.ashx?pricetreeId=".$item_id."&apikey=7770AD31-382F-4D32-8C36-3743C0271699";
    $response = file_get_contents($request);
    $results = json_decode($response, TRUE);

    //print_r($results);
    //echo "-----------------";
    //echo $results['count'];
    /*
     I want these details
                    [Seller_Name] => Amazon
                    [Best_Price] => 13,499.00
                    [In_Stock] => Yes
                    [Product_Name] => Moto G Plus, 4Th Gen (White, 16 Gb)
                    [Product_Color] =>
                    [Uri] => http://www.amazon.in/dp/product/B01DDP85KU/



     */

    foreach ($results['data'] as $key => $itemdata) {
        $seller = $itemdata['Seller_Name'];
        $price = $itemdata['Best_Price'];
        $product_link = $itemdata['Uri'];

        echo $seller."<br/>".$price."<br/>".$product_link."<br/><br/>";
    }



}
?>
