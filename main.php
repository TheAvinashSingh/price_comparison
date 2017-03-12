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
for ($i=1;$i<5;$i++){

    //echo $item_list[$i]; //this array is separated based on split string <div class="items-wrap">
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

    $item_link = $url_link2[0];
    $item_image_link = $image_link2[0];
    $item_id1 =explode("-",$item_link);
    $item_id = end($item_id1); //split with "-" and print last one after split i.e id

    echo $item_link."<br/>";
    echo $item_image_link."<br/>";
    echo $item_id."<br/>";

}
?>