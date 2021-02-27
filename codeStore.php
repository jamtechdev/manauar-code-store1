<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Important Plugins ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
1. Adv. Custom Filed ACF  ->> Add Custom field post,page and user
2. Gravity Form ->> Add custom field
3. Theme My Login ->> Change wp login page
4. WP Email Users ->> Send user email
5. WP SMS ->> Send user sms
6. Paid Memberships Pro ->> Set user membership plan
7. CPT UI ->> Create custom post and taxonomy
8. Post SMTP
9. Clock Time
10. WP User avtar ->> User Change profile image
11.WPFront User Role Editor --| User Role
12.User Role Editor         --|
13. Auto Post Scheduler ->> Set Sechdule time post publish
14.WordFence Security
15.WPBakery Page Builder & Elementer
16.Composer
17.Instagram Feed Gallery  --> Show Instagram Feed
18.Slider Revolution --> Normal Slider
19.WP Maintenance Mode --| Maintenance Mode
20.Maintenance Mode   --|
21.Popup maker
22.WP Contact Slider --> Show Side popup (Contact Form 7)
23.WP Display Header --> Header Image
25.WP Mail SMTP --> Connect contact form webmail
26.RoyalSlider --> Stylish Slider
26.LayerSlide WP --> Stylish Slider
27.WTI Like Post --> Post Like
28.Gravity Forms --> Add On(Views-> member active,  User Registration Add-On-> create user);
29.CM Tooltip Glossary Pro+ --> Set grossery dictionary


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Get Current URL & Timezone Set  ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
global $wpdb;
$currentPageUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI];

if(function_exists('date_default_timezone_set')) {
    date_default_timezone_set("Asia/Kolkata");
}
?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Enqeue Script & Bootstrap ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
define('THEMEDIR', get_theme_file_uri());
define('IMG', THEMEDIR.'/include/images/');
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_script('bootstrap',get_stylesheet_directory_uri() . '/bootstrap/js/bootstrap.min.js');
    wp_enqueue_style('slick', THEMEDIR.'/include/css/slick.css',array(),'1.5.9', 'all');
    wp_enqueue_script('bootstrap', THEMEDIR.'/include/js/bootstrap.min.js',array('jquery'),'3.3.7',true);
}
require_once get_parent_theme_file_path('wp-bootstrap-navwalker.php');
?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Upload Image on Server ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
    if ( ($_FILES[ff_profileImg]['size'] !== 0) ){ 
    $tmp_name = $_FILES["ff_profileImg"]["tmp_name"];
    $uploadfilename = $_FILES["ff_profileImg"]["name"];
    $saveddate = date("mdy-Hms");
    $newfilename = "img/".$saveddate."_".$uploadfilename;
    $uploadurl = 'http://'.$_SERVER['SERVER_NAME'].'/'.$newfilename;
      if (move_uploaded_file($tmp_name, $newfilename)):
          $logins_profile_img_url = $uploadurl;
      else:
          echo "error in uploading file to server.";
      endif; //move uploaded file
    }else{
    $logins_profile_img_url = 'http://gardenpalaceinfra.com/img/test.jpg';
    }
?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Send Mail ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
    $to = $logins_emil;
    $subject = "Your Garden Palace Membership(ID: " . $gotMemberId . ") details";
    $txt = "Welcome to Garden Palace Membership.\r\nLogin: http://gardenpalaceinfra.com/logins/\r\nYour mobile number is below\r\n" . $logins_mobile . "\r\nYour password is below\r\n" . $logins_password;
    $headers = "From: info@gardenpalaceinfra.com" . "\r\n" .
    "CC: nischint.pal@gmail.com";

    mail($to,$subject,$txt,$headers);
?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Table Export into Excel(JS) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<script>
//script to export html table into excel 
function exportTableToExcel(tableID, filename = ''){
    var downloadLink;
    var dataType = 'application/vnd.ms-excel';
    var tableSelect = document.getElementById(tableID);
    var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
    
    // Specify file name
    filename = filename?filename+'.xls':'excel_data.xls';
    
    // Create download link element
    downloadLink = document.createElement("a");
    
    document.body.appendChild(downloadLink);
    
    if(navigator.msSaveOrOpenBlob){
        var blob = new Blob(['\ufeff', tableHTML], {
            type: dataType
        });
        navigator.msSaveOrOpenBlob( blob, filename);
    }else{
        // Create a link to the file
        downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
    
        // Setting the file name
        downloadLink.download = filename;
        
        //triggering the function
        downloadLink.click();
    }
}
</script>
<button class="searchBoxSubmit" onclick="exportTableToExcel('tableExlExpt', 'clientsEmiDetails')">Export Table Data To Excel File</button>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Print Table(JS) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<button class="searchBoxSubmit" onclick="printContentCopy('printEmiTable')" >Print EMI Table</button>
<script>
    function printContentCopy(el){
        document.getElementById('clientCopyDiv').style.display = "block";
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;
        document.getElementById('clientCopyDiv').style.display = "none";
}  
</script>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Table Convert in PDF(JS) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <table id="tblCustomers" cellspacing="0" cellpadding="0"></table>
    <input type="button" id="btnExport" value="Export" onclick="Export()" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.22/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
    <script type="text/javascript">
        function Export() {
            html2canvas(document.getElementById('tblCustomers'), {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("Table.pdf");
                }
            });
        }
    </script>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Change Url(JS) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<script>
	jQuery('#set_url').click(function(){
		window.history.pushState({}, document.title, "/" + "wp/view-edit-load-plan/");
	});
</script>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Navbar add active class(php & JS) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
add_filter('nav_menu_css_class' , 'bhj_active_nav_class' , 10 , 2);
function bhj_active_nav_class ($classes, $item) {
    if (in_array('current-post-ancestor', $classes) || in_array('current-page-ancestor', $classes) || in_array('current-menu-item', $classes) ){
        $classes[] = 'active ';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'bhj_add_active_class', 10, 2 );
function bhj_add_active_class($classes, $item) {
    if(is_singular('post') && in_array('menu-item-47', $classes)){
        $classes[] = "active";
    }
    if(is_singular('events') && in_array('menu-item-46', $classes)){
        $classes[] = "active";
    }
    if(is_singular('expertise') && in_array('menu-item-45', $classes)){
        $classes[] = "active";
    }
    return $classes;
}

add_filter('wp_nav_menu_objects', 'bhj_wp_nav_menu_objects', 10, 2);
function bhj_wp_nav_menu_objects($items,$args){
    foreach($items as &$item){
        $img = get_field('menu_image', $item);
        $img2 = get_field('menu_image_white', $item);
        if($img){
            $item->title .= '<img class="menu-img" src="'.$img.'" alt="" /><img class="menu-img-white" src="'.$img2.'" alt="" />';
        }   
    }
    return $items;   
}
?>
<script type="text/javascript">
    jQuery(function() { 
        var url = window.location;
        jQuery('#menu-main-menu li a').filter(function() {
            return this.href == url;
        }).addClass('active');
    });   
</script>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Page Slug Body Class ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
function bhj_add_slug_body_class( $classes ) {
global $wpdb, $post;
if ( isset( $post ) ) {
    $classes[] = $post->post_name;
}
if (is_page()) {
    if ($post->post_parent) {
        $parent  = end(get_post_ancestors($current_page_id));
    } else {
        $parent = $post->ID;
    }
    $post_data = get_post($parent, ARRAY_A);
    $classes[] = $post_data['post_name'];
}
return $classes;
}
add_filter( 'body_class', 'bhj_add_slug_body_class' );

add_filter( 'body_class', 'bhj_body_class');
function bhj_body_class($classes){
    if (is_page_template(array('templates/expertise.php','templates/events.php')) || is_home() || is_front_page()){
        $classes[] = 'transparent';
    }elseif(is_page_template('tpl-single-post.php')){
        $classes[] = 'post-tpl-2';
    }
    return $classes; 
}
?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~ Page Template display on dashboard ~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
add_filter('manage_edit-page_columns','bhj_columns',100,1);
function bhj_columns( $columns ) {
    $columns['page_template'] = 'Page Template';
    return $columns;
}
add_action('manage_pages_custom_column','bhj_populate_columns',10,2);
function bhj_populate_columns( $column ) {
    if ( 'page_template' == $column ) {
        $p = basename(get_page_template_slug( $page_id ));
        $p = ucwords(str_replace(array('.php','-'), array('',' '), $p));
        echo ($p == '' ? 'Default Template' : $p);
    }
}
?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Register Google Map API ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
// AIzaSyCe08f8acji-xKySnXw83ggk7LLych77vk
function tb_acf_google_map_api( $api ){
    $api['key'] = 'AIzaSyCe08f8acji-xKySnXw83ggk7LLych77vk';
    return $api;
}
add_filter('acf/fields/google_map/api', 'tb_acf_google_map_api');
function tb_acf_init() {
    acf_update_setting('google_api_key', 'AIzaSyCe08f8acji-xKySnXw83ggk7LLych77vk');
}
add_action('acf/init', 'tb_acf_init');
?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Function for map setting ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
function mapSetting(){
?>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCe08f8acji-xKySnXw83ggk7LLych77vk"></script>
<script type="text/javascript">
(function($) {
function new_map( $el ) {
    var $markers = $el.find('.marker');
    var args = {
        zoom        : 16,
        center      : new google.maps.LatLng(0, 0),
        mapTypeId   : google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map( $el[0], args);
    map.markers = [];
    $markers.each(function(){        
        add_marker( $(this), map );
    });
    center_map( map );
    return map;
}
function add_marker( $marker, map ) {
    var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
    var marker = new google.maps.Marker({
        position    : latlng,
        map         : map,
        //icon      : '<?php echo IMG.'marker.png'; ?>'
    });
    map.markers.push( marker );
    if( $marker.html() )
    {
        var infowindow = new google.maps.InfoWindow({
            content     : $marker.html()
        });
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open( map, marker );
        });
    }
}
function center_map( map ) {
    var bounds = new google.maps.LatLngBounds();
    $.each( map.markers, function( i, marker ){
        var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );
        bounds.extend( latlng );
    });
    if( map.markers.length == 1 )
    {
        map.setCenter( bounds.getCenter() );
        map.setZoom( 18 );
    }
    else
    {
        map.fitBounds( bounds );
    }
}
var map = null;
$(document).ready(function(){
    $('.acf-map').each(function(){
        map = new_map( $(this) );
    });
});
})(jQuery);
</script>
<?php
}
?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Copy Content(JS) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
    function copyToClipboard(element) {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();
     }
</script>
<p id="p1">I am paragraph 1</p>
<button onclick="copyToClipboard('#p1')">Copy P1</button>
<input type="text" placeholder="Paste here for test" />


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Add 1 Month Only And Days ~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
    $date_difference = strtotime($currentDate) - strtotime($latePayDate);
    $fixed_days =  round( $date_difference / (60 * 60 * 24) );
    echo 'Total Days: '.$fixed_days;
?>

<?php    
    if($dateNo == 29 || $dateNo ==  30 || $dateNo ==  31){
        
        //if month feb
        if($monthNo == 2){
            if($yearNo % 4 == 0){  
                $dateNo = 29;
                //echo $dateNo;
            }else{
                $dateNo = 28;
                //echo $dateNo;
            }
        }
        
        //if date is 31 and months are 04, 06, 09 and 11
        if($dateNo == 31 ){
            //echo "<br>inside 31 loop part a.";
            if($monthNo==4 OR $monthNo==6 OR $monthNo==9 OR $monthNo==11){
                //echo "<br>inside 31 loop part b";
                $dateNo = 30;
            }
            
        }
    }

    $crtDate = "$yearNo-$monthNo-$dateNo";
    echo "<br>default <b>$crtDate</b>.";
    
    //////adding 1 month
    $convertToFirstDatexl = date('Y-m-01', strtotime($crtDate));
    $loopCrtNextMonthWith1stxl = date('Y-m-01', strtotime('+1 month' , strtotime($convertToFirstDatexl)));
     //echo "<br>adding one month and converting date to 1st : $loopCrtNextMonthWith1stxl";

            
//        add1MonthOnly - (end) **********************************
    $dateNo = $dateNoPermanent;
    $dateNoPermanent = date('d', strtotime($_POST['ff_transfer2SaleDate']));
    $monthNo= date('m', strtotime($loopCrtNextMonthWith1stxl));
    $yearNo= date('Y', strtotime($loopCrtNextMonthWith1stxl));
    echo "<br>default date give is $dateNo-$monthNo-$yearNo";       
          
            
        
     for ($emiNo = 1; $emiNo <= $sales_emi_months; $emiNo++){
        echo "<br><b><u>$emiNo</u></b>";
        //echo '<br><b>***' . $loopdate . "***</b>";
        //echo "<br>in starting of loop value of date is $dateNo";
        //echo "<br>in starting of loop value of month is $monthNo";
        //echo "<br>in starting of loop value of year is $yearNo";
        if($dateNo == 29 || $dateNo ==  30 || $dateNo ==  31){

                    //if month feb
                    if($monthNo == 2){
                        if($yearNo % 4 == 0){  
                            $dateNo = 29;
                            //echo $dateNo;
                        }else{
                            $dateNo = 28;
                            //echo $dateNo;
                        }
                    }

                    //if date is 31 and months are 04, 06, 09 and 11
                    if($dateNo == 31 ){
                        //echo "<br>inside 31 loop part a.";
                        if($monthNo==4 OR $monthNo==6 OR $monthNo==9 OR $monthNo==11){
                            //echo "<br>inside 31 loop part b";
                            $dateNo = 30;
                        }

                    }
                }
            $loopCrtDate = "$yearNo-$monthNo-$dateNo";
            //echo "<br>date in loop is <b>$loopCrtDate</b>. Insert this date in table";
?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Different days by two date ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
    $from=date_create(date('Y-m-d'));
    $to=date_create("2019-03-15");
    $diff=date_diff($to,$from);
        echo '<pre>';
        print_r($diff);
        echo '</pre>';
        echo '<br>'.$diff->format('%R%a days');

        //different month
     $date1 = '2010-01-25';
     $date2 = '2010-02-25';
     $d1=new DateTime($date2); 
     $d2=new DateTime($date1);                                  
     $Months = $d2->diff($d1); 
     $howeverManyMonths = (($Months->y) * 12) + ($Months->m);
     echo '<br>Month '. $howeverManyMonths;
?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ SQL Query ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
     // join two table
    $Query = "SELECT e1.name FROM login e1 JOIN emi e2 ON (e1.login_id = e2.emi_login_id) group by e2.emi_login_id";

     // join three table
     $Query = "SELECT * FROM `asb_user_logins_2` join `asb_sales_plan` ON (`user_id` = `sales_plan_membId`) join `asb_members_parent_2` ON  (`user_id`= `trad_downMem_id`)";
         
         // delete
        $query="delete from wp_favourite_artists where user_id=".$param['loggedinuserid']." and artist_id=".$param['artistid'];
             if($wpdb->query($query)){
                $data['status']='Success';
                $data['msg']='Done successfully';
              }

        // insert
        $insert_data =  array(
            'id'        => NULL,   
            'album_id'  => $param['album_id'],
            'user_id'   => $user_id,
            'date'      => NULL
    );
    $flag =   $wpdb->insert('wp_playlist_album',$insert_data);
?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Open New window Tab ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
 $crtUrl = 'http://gardenpalaceinfra.com/dashboard-staff/staff-u2-presale-print/?printSalesId='.$loopR_allTransClientId['saleT_id'];
 echo '<td><a href ="" ' . "onclick='" . 'window.open("' . $crtUrl . '", "", "width=700,height=330,top=200,left=300,location=no,menubar=no,resizable=no,scrollbars=no,status=no,titlebar=no,toolbar=no"' . ");'><abbr title='Presale Print'>" . $loopR_allTransClientId['saleT_id']. "</abbr> </td>";           
?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Change Amount in word ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
   $number = $totalAmt;
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'ONE', '2' => 'TWO',
    '3' => 'THREE', '4' => 'FOUR', '5' => 'FIVE', '6' => 'SIX',
    '7' => 'SEVEN', '8' => 'EIGHT', '9' => 'NINE',
    '10' => 'TEN', '11' => 'ELEVEN', '12' => 'TWELVE',
    '13' => 'THIRTEEN', '14' => 'FOURTEEN',
    '15' => 'FIFTEEN', '16' => 'SIXTEEN', '17' => 'SEVENTEEN',
    '18' => 'EIGHTEEN', '19' =>'NINETEEN', '20' => 'TWENTY',
    '30' => 'THIRTY', '40' => 'FORTY', '50' => 'FIFTY',
    '60' => 'SIXTY', '70' => 'SEVENTY',
    '80' => 'EIGHTY', '90' => 'NINETY');
   $digits = array('', 'HUNDRED', 'THOUSAND', 'LAKH', 'CRORE');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 'S' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
  echo $result . "RUPEES" . $points . " /- ";
?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Redirect WhatsApp ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<a href="https://api.whatsapp.com/send?phone=+919415313134">WhatsApp</a>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Rest API Intigration ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php        
   function addtoarchivecallback($request){
        global $wpdb;
        $data  = array(
            "status"    => "ok",
            "errormsg"  => "",
            'error_code'=> ""
        );
        $param = $request->get_params();
        $token = $param['token'];
        $user_id = GetMobileAPIUserByIdToken($token);
            if($user_id){
                
                if(!isset($param['status']) || !isset($param['track_id']) || empty($param['track_id']) ){
                    $data  = array(
                        "status"    => "error",
                        "errormsg"  => "missing_parameters('status','track_id')",
                        "msg"       => "Missing parameters. Please check it.",
                        'error_code'=> "403"
                    );
                    return new WP_REST_Response($data, 403);  
                }
                
                
                $status = $param['status'];
                
                if($status == true){
                    
                    if(!checkarchivedifalready($param['track_id'],$user_id)){
                        $insert_data = array(
                            'id'        => NULL,   
                            'track_id'  => $param['track_id'],
                            'user_id'   => $user_id,
                            'date'      => NULL
                        );
                        $flag = $wpdb->insert('wp_favorite_song',$insert_data);
                        if($flag) {
                            $data['msg'] = "Track Added to Favorite List.";
                            return new WP_REST_Response($data, 200);
                        }else{
                            $data  = array(
                                "status"    => "error",
                                "errormsg"  => "Some Error Occurd",
                                "msg"       => "Track Not Added to Favorite",
                                'error_code'=> "403"
                            );
                            return new WP_REST_Response($data, 403);
                        } 
                    }else{
                        $data  = array(
                            "status" => "error",
                            "errormsg" => "Already Added to Favorite List",
                            "msg" => "Already Added to Favorite List",
                            'error_code' => "403"
                        );
                        return new WP_REST_Response($data, 403);  
                    }
                    
                    
                }elseif($status == false){
                    $flag = $wpdb->delete("wp_favorite_song", array('track_id' => $param['track_id'], 'user_id' => $user_id) ); 
                    if($flag){
                        $data['msg'] = "Song is removed from Favorite list.";
                        return new WP_REST_Response($data, 200);
                    }else{
                        $data  = array(
                            'error_code'=> "403",
                            "status"    => "error",
                            "errormsg"  => "something_went_wrong_(remove songs from songs.)",
                            "msg"       => "Song is not remove from favorite list."
                        );
                        return new WP_REST_Response($data, 403);
                    }
                }else{
                    $data  = array(
                        'error_code'=> "403",
                        "status"    => "error",
                        "errormsg"  => "invalid_status_value",
                        "msg"       => "Invalid 'status' value. Please check and try again.",
                    );
                    return new WP_REST_Response($data, 403);
                }
        }else{
            $data  = array(
                "status"    => "error",
                "errormsg"  => "User token expired",
                "msg"       => "User token expired",
                'error_code'=> "403"
            );
            return new WP_REST_Response($data, 403);
        }
    } 

    ?>



<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Add option page ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
add_action('init', 'service_costs');
function service_costs() {
    if (function_exists('service_costs')) {
        acf_add_options_page(array(
            'page_title'    => 'Service Costs dashboard',
            'menu_title'    => 'Service Costs',
            'menu_slug'     => 'service_costs',
            'capability'    => 'edit_posts',
            'redirect'      => false
        ));    
    } 
}
?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Add post field (ACF) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php acf_form_head(); ?>
<div id="primary" class="content-area">
    <div id="content" class="site-content" role="main">
    <?php while ( have_posts() ) : the_post(); ?>
    <?php acf_form(array(
        'post_id'       => 125,
        'post_title'    => 'ali',
        'post_content'  => 'khan',
        'submit_value'  => __('Update meta')
    )); ?>
    <?php endwhile; ?>
    </div><!-- #content -->
</div><!-- #primary -->


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Get image onlt id (ACF) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php echo wp_get_attachment_image( $image2, 'full' ); ?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Add textarea with edit tools ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
 <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
  </head>
  <body>
  <textarea>Next, get a free Tiny Cloud API key!</textarea>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Add extra column show user table ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
function new_contact_methods( $contactmethods ) {
    $contactmethods['phone'] = 'Phone';
    return $contactmethods;
}
add_filter( 'user_contactmethods', 'new_contact_methods', 10, 1 );

function new_modify_user_table( $column ) {
    $column['phone'] = 'Phone';
    return $column;
}
add_filter( 'manage_users_columns', 'new_modify_user_table' );

function new_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'phone' :
            return get_the_author_meta( 'phone', $user_id );
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );
?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~ Add extra field in edit user profile ~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) { ?>
    <h3><?php _e("Extra profile information", "blank"); ?></h3>

    <table class="form-table">
    <tr>
        <th><label for="address"><?php _e("Address"); ?></label></th>
        <td>
            <input type="text" name="address" id="address" value="<?php echo esc_attr( get_the_author_meta( 'address', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php _e("Please enter your address."); ?></span>
        </td>
    </tr>
    <tr>
        <th><label for="city"><?php _e("City"); ?></label></th>
        <td>
            <input type="text" name="city" id="city" value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php _e("Please enter your city."); ?></span>
        </td>
    </tr>
    <tr>
    <th><label for="postalcode"><?php _e("Postal Code"); ?></label></th>
        <td>
            <input type="text" name="postalcode" id="postalcode" value="<?php echo esc_attr( get_the_author_meta( 'postalcode', $user->ID ) ); ?>" class="regular-text" /><br />
            <span class="description"><?php _e("Please enter your postal code."); ?></span>
        </td>
    </tr>
    </table>
<?php }

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );
function save_extra_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id ) ) { 
        return false; 
    }
    update_user_meta( $user_id, 'address', $_POST['address'] );
    update_user_meta( $user_id, 'city', $_POST['city'] );
    update_user_meta( $user_id, 'postalcode', $_POST['postalcode'] );
}
?>

      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~ Add profile image user edit section ~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
// 1. Enqueue the needed scripts.
add_action( "admin_enqueue_scripts", "ayecode_enqueue" );
function ayecode_enqueue( $hook ){
    // Load scripts only on the profile page.
    if( $hook === 'profile.php' || $hook === 'user-edit.php' ){
        add_thickbox();
        wp_enqueue_script( 'media-upload' );
        wp_enqueue_media();
    }
}

// 2. Scripts for Media Uploader.
function ayecode_admin_media_scripts() {
    ?>
    <script>
        jQuery(document).ready(function ($) {
            $(document).on('click', '.avatar-image-upload', function (e) {
                e.preventDefault();
                var $button = $(this);
                var file_frame = wp.media.frames.file_frame = wp.media({
                    title: 'Select or Upload an Custom Avatar',
                    library: {
                        type: 'image' // mime type
                    },
                    button: {
                        text: 'Select Avatar'
                    },
                    multiple: false
                });
                file_frame.on('select', function() {
                    var attachment = file_frame.state().get('selection').first().toJSON();
                    $button.siblings('#ayecode-custom-avatar').val( attachment.sizes.thumbnail.url );
                    $button.siblings('.custom-avatar-preview').attr( 'src', attachment.sizes.thumbnail.url );
                });
                file_frame.open();
            });
        });
    </script>
    <?php
}
add_action( 'admin_print_footer_scripts-profile.php', 'ayecode_admin_media_scripts' );
add_action( 'admin_print_footer_scripts-user-edit.php', 'ayecode_admin_media_scripts' );


// 3. Adding the Custom Image section for avatar.
function custom_user_profile_fields( $profileuser ) {
    ?>
    <h3><?php _e('Custom Profile Image', 'ayecode'); ?></h3>
    <table class="form-table ayecode-avatar-upload-options">
        <tr>
            <th>
                <label for="image"><?php _e('Custom Profile Image', 'ayecode'); ?></label>
            </th>
            <td>
                <?php
                // Check whether we saved the custom avatar, else return the default avatar.
                $custom_avatar = get_the_author_meta( 'ayecode-custom-avatar', $profileuser->ID );
                if ( $custom_avatar == '' ){
                    $custom_avatar = get_avatar_url( $profileuser->ID );
                }else{
                    $custom_avatar = esc_url_raw( $custom_avatar );
                }
                ?>
                <img style="width: 96px; height: 96px; display: block; margin-bottom: 15px;" class="custom-avatar-preview" src="<?php echo $custom_avatar; ?>">
                <input type="hidden" name="ayecode-custom-avatar" id="ayecode-custom-avatar" value="<?php echo esc_attr( esc_url_raw( get_the_author_meta( 'ayecode-custom-avatar', $profileuser->ID ) ) ); ?>" class="regular-text" />
                <input type='button' class="avatar-image-upload button-primary" value="<?php esc_attr_e("Upload Image","ayecode");?>" id="uploadimage"/><br />
                <span class="description">
                    <?php // _e('Please upload a custom avatar for your profile, to remove the avatar simple delete the URL and click update.', 'ayecode'); ?>
                </span>
            </td>
        </tr>
    </table>
    <?php
}
add_action( 'show_user_profile', 'custom_user_profile_fields', 10, 1 );
add_action( 'edit_user_profile', 'custom_user_profile_fields', 10, 1 );


// 4. Saving the values.
add_action( 'personal_options_update', 'ayecode_save_local_avatar_fields' );
add_action( 'edit_user_profile_update', 'ayecode_save_local_avatar_fields' );
function ayecode_save_local_avatar_fields( $user_id ) {
    if ( current_user_can( 'edit_user', $user_id ) ) {
        if( isset($_POST[ 'ayecode-custom-avatar' ]) ){
            $avatar = esc_url_raw( $_POST[ 'ayecode-custom-avatar' ] );
            update_user_meta( $user_id, 'ayecode-custom-avatar', $avatar );
        }
    }
}


// 5. Set the uploaded image as default gravatar.
add_filter( 'get_avatar_url', 'ayecode_get_avatar_url', 10, 3 );
function ayecode_get_avatar_url( $url, $id_or_email, $args ) {
    $id = '';
    if ( is_numeric( $id_or_email ) ) {
        $id = (int) $id_or_email;
    } elseif ( is_object( $id_or_email ) ) {
        if ( ! empty( $id_or_email->user_id ) ) {
            $id = (int) $id_or_email->user_id;
        }
    } else {
        $user = get_user_by( 'email', $id_or_email );
        $id = !empty( $user ) ?  $user->data->ID : '';
    }
    //Preparing for the launch.
    $custom_url = $id ?  get_user_meta( $id, 'ayecode-custom-avatar', true ) : '';
    
    // If there is no custom avatar set, return the normal one.
    if( $custom_url == '' || !empty($args['force_default'])) {
        return esc_url_raw( 'https://wpgd-jzgngzymm1v50s3e3fqotwtenpjxuqsmvkua.netdna-ssl.com/wp-content/uploads/sites/12/2020/07/blm-avatar.png' ); 
    }else{
        return esc_url_raw($custom_url);
    }
}
?>

      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~ Show post in wp-table by condition ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
add_action( 'pre_get_posts', 'show_featured_posts' );
function show_featured_posts ( $query ) {
    if ( $query->is_main_query() ) {
       $query->set( 'meta_key', 'custom-field-name' );
       $query->set( 'meta_value', 'product-Ali' );
    }
}
?>
      
      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Remove menu option in dashboard ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
add_action( 'admin_menu', 'custom_menu_page_removing' );
function custom_menu_page_removing(){
if(is_user_logged_in()){
    echo '<br>User Loggedin';
            remove_menu_page( 'tools.php' );            
            remove_menu_page( 'options-general.php' );
  }
}
?>

      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Show all order add column (wc) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
add_filter( 'manage_edit-shop_order_columns', 'add_new_order_admin_list_column' );
function add_new_order_admin_list_column( $columns ) {
    
   // if(isset($_GET['_customer_user']) && $_GET['_customer_user'] != "" ){
        $columns['assign_services'] = 'Assign Services';
        $columns['staff_assigned']  = 'Staff Assigned';
       
    //}
    return $columns;
}
                 
add_action( 'manage_shop_order_posts_custom_column', 'add_new_order_admin_list_column_content' );
function add_new_order_admin_list_column_content($column) {
    
    global $post;
    $current_supervisor = get_current_user_id();
    
    // if(isset($_GET['_customer_user']) && $_GET['_customer_user'] != "" ){
        $user_id = $_GET['_customer_user'];
    
        if ( 'assign_services' === $column ) {
            
            $args  = array('role' => 'staff');
            $staffs = get_users($args);

            echo "<a href='https://armoire.betaplanets.com/wp-admin/admin.php?page=assign-closet&user-id=".$user_id."&order_id=".$post->ID."&supervisor_id=".$current_supervisor." '>Assign staff</a>";
        }
        
        if ( 'staff_assigned' === $column ) {
            
            global $wpdb;
            $args  = array('role' => 'staff');
            $staffs = get_users($args);
            $product_id = $post->ID;
            
            $press_staff = get_post_meta($product_id,'press-job',true);
            $press = get_user_meta($press_staff,'first_name',true);
            $press_name = get_userdata($press_staff);
            if(isset($press_name) && $press_name != ""){
            $nicename_press = $press_name->data->user_nicename;
            }
            
            $dry_clean_staff = get_post_meta($product_id,'dry-clean-job',true);
            $dry_clean = get_user_meta($dry_clean_staff,'first_name',true);
            $dry_clean_name = get_userdata($dry_clean_staff);
            if(isset($dry_clean_name) && $dry_clean_name != ""){
            $nicename_dry_clean = $dry_clean_name->data->user_nicename;
            }
            
            $dropoff_staff = get_post_meta($product_id,'dropoff-job',true);
            $dropoff = get_user_meta($dropoff_staff,'first_name',true);
            $dropoff_name = get_userdata($dropoff_staff);
            if(isset($dropoff_name) && $dropoff_name != ""){
            $nicename_dropoff = $dropoff_name->data->user_nicename;
            }
            
            if(isset($press) && $press != ""){
                
                echo "Press :<a href='https://armoire.betaplanets.com/author/".$nicename_press."/'>".$press."</a><br>";
            }else{
                echo "Press : Not assigned<br>";
            }
            if(isset($dry_clean) && $dry_clean != ""){
                
                echo "Dry Clean :<a href='https://armoire.betaplanets.com/author/".$nicename_dry_clean."/'>".$dry_clean."</a><br>";
            }else{
                echo "Dry Clean : Not assigned<br>";
            }
            if(isset($dropoff) && $dropoff != ""){
                
                echo "Dropoff :<a href='https://armoire.betaplanets.com/author/".$nicename_dropoff."/'>".$dropoff."</a><br>";
            }else{
                echo "Dropoff : Not assigned<br>";
            }
            
        }
    // }
}
?>

      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~ send_Desktop_push_Notification(Desktop) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
add_action( 'wp_enqueue_scripts', 'callback_wp_enqueue_scripts_onesignal' );
function callback_wp_enqueue_scripts_onesignal() {
wp_enqueue_script( 'onesignal-script', 'https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js', false );
wp_enqueue_script('onesignal-sdk', 'https://cdn.onesignal.com/sdks/OneSignalSDK.js');
}

function send_Desktop_push_Notification($player_id,$msg) { //
    
    $content = array(
        "en" => $msg
    );
    $headings = array(
        "en" => 'Membership Expire Notification'
    );
    $fields = array(
        'app_id' => "42cfbc21-c04e-4754-be0b-f7f0596f646f",
        'safari_web_id' => "web.onesignal.auto.08e72fe8-7d9e-49e9-8aad-204d649fdf9c",
        'include_player_ids' => array($player_id),
        'contents' => $content,
        'headings' => $headings
    );

    $fields = json_encode($fields);
    $ch =   curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

    $response = curl_exec($ch);
            curl_close($ch);

    return $response;
}

add_action('wp_footer', 'my_admin_footer_function');
function my_admin_footer_function() { ?>

    <script type="text/javascript">
        var OneSignal = window.OneSignal || [];
        // window.OneSignal = window.OneSignal || [];
        OneSignal.push(function(){
            OneSignal.init({
            appId : "42cfbc21-c04e-4754-be0b-f7f0596f646f",
            safari_web_id: "web.onesignal.auto.08e72fe8-7d9e-49e9-8aad-204d649fdf9c"
            });
            OneSignal.getUserId(function(userId) {
            set_player_id(userId);
            });
        });
        // OneSignal.push(function(){
        // });
        
    function set_player_id(userid){

        jQuery.ajax({
        url : "<?php echo admin_url('admin-ajax.php'); ?>",
        method: 'POST',
        data:{'action':'callback_set_playerid_in_db','player_id':userid},
        success : function(response){
        console.log("Player Id inserted for user is : "+userid);
        }
        });
    }

    </script>
<?php
}

add_action("wp_ajax_callback_set_playerid_in_db", "callback_set_playerid_in_db");
add_action("wp_ajax_nopriv_callback_set_playerid_in_db", "callback_set_playerid_in_db");

function callback_set_playerid_in_db(){

    global $wpdb;
    $staff_player_id = $_POST['player_id'];
    $staff_id = get_current_user_id();

    $staff_meta = get_userdata($staff_id);
    $staff_roles = $staff_meta->roles;

    if (in_array("pmpro_restapi_access_role", $staff_roles)){

        update_user_meta($staff_id,'player_id',$staff_player_id);
        $date = date('Y-m-d H:i:s');

        $staff_device_exists = $wpdb->get_results('SELECT * FROM `wp_users_device_details` WHERE `user_id` = '.$staff_id.' AND `device_uuid` = '.$staff_player_id.' ');
        if(isset($staff_device_exists) && $staff_device_exists != "" ){

            $tablename = 'wp_users_device_details';
            $data = array('isuserloggedin' => '1','logindate' => $date);
            $where = array('user_id' => $staff_id , 'device_uuid' =>$staff_player_id);
            $updated = $wpdb->update($tablename , $data, $where);
            
        }else{

            $wpdb->insert('wp_users_device_details', array( // `user_id``device_uuid``isuserloggedin`
            'user_id' => $staff_id,
            'device_uuid' => $staff_player_id,
            'isuserloggedin' => '1', // ... and so on
            'logindate' => $date
            ));

            }
    }
    exit;
}
?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~ sendPushNotification(Mobile) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
        register_rest_route('mobileapi/v1', '/sendPushNotification', array(
            'methods'   => 'POST',
            'callback'  => 'sendPushNotification',
        )); 

        register_rest_route( 'mobileapi/v1/', '/updateDeviceToken', array(
            'methods' => 'POST', 
            'callback' => 'updateDeviceToken' 
        ));        



function updateDeviceToken($request){
    $data=array("status"=>"ok","errormsg"=>"",'error_code'=>"");
    $param = $request->get_params();
    $user_id = GetMobileAPIUserByIdToken($param['token']);
    $deviceID=$param['deviceID'];
    $deviceData=$param['deviceData'];
    $status=$param['status'];
    switch($status){
    case 'login':
        $res = saveDeviceDetails($user_id,$deviceData);
        
    break;
    case 'logout':
        $res = removeDeviceDetails($user_id,$deviceData);
    break;
    }
    return new WP_REST_Response($res, 200);
}

function saveDeviceDetails($user_id,$device){
    global $wpdb;
    $uuid=$device[0]['uuid'];
        $results = $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->prefix}users_device_details WHERE user_id =$user_id  and device_uuid='".$uuid."'");
        $numberofcounts = $results;
        if($numberofcounts==0){
         $response = $wpdb->insert('wp_users_device_details', array(
            'user_id' => (int) $user_id,
            'device_uuid' =>$device[0]['uuid'],
            'device_model' =>$device[0]['model'],
            'deviceplatform' =>$device[0]['platform'],
            'deviceversion' =>$device[0]['version'],
            'timezone' =>$device[0]['offset'],
            'device_token' =>$device[0]['deviceToken'],
            'isuserloggedin' =>1,
            'logindate' =>$device[0]['logindate'],
            'device_token' =>$device[0]['deviceToken'],
             'change_password'=>0
        ));
        }else{
               $response =  $wpdb->update( 
                        'wp_users_device_details',
                        array(     
                            'device_model' =>$device[0]['model'],
                            'deviceplatform' =>$device[0]['platform'],
                            'deviceversion' =>$device[0]['version'],
                            'timezone' =>$device[0]['offset'],
                            'device_token' =>$device[0]['deviceToken'],
                            'isuserloggedin' =>1,
                            'logindate' =>$device[0]['logindate'],
                            'device_token' =>$device[0]['deviceToken'],
                            'change_password'=>0
                        ),
                     array( 
                             'device_uuid' =>$device[0]['uuid'],
                             'user_id' => (int) $user_id
                        )
                    );
        }

        return $response;
}
function removeDeviceDetails($user_id,$device){
    global $wpdb;
               $response =  $wpdb->update( 
                        'wp_users_device_details', 
 
                        array(     
                          'isuserloggedin' =>0,
                        ),
                     array( 
                             'device_uuid' =>$device[0]['uuid'],
                             'user_id' => (int) $user_id
                        )
                    );
        return $response;
}

function sendPushNotification($request){
    global $wpdb;
    $param = $request->get_params();
    $id=$param['id'];
    $name=$param['name'];
    $user_id=$param['senderID'];
     $status= get_user_meta( $id, 'notificationStatus', true );
     $msg=sanitize_text_field($param['msg']);
     $msgData="New Message From ".ucfirst($name);
     $device = getDeviceIDS($id);
                       $wpdb->insert( 
            'wp_save_notification', 
                array( 
                   'reciver_id' => (int)$id,
                    'sender_id' => (int)$user_id,
                    'notification_msg' => $msgData,
                    'status'=>0
               )
        );
     //if($status==1){
     send_push_notification($msgData,$device);
   //  }
     $data['device']=$device;
     $data['status']=$status;
     return new WP_REST_Response($data, 200);
}

function send_push_notification($msg_title,$devide_ids,$id=''){ 
        $content      = array(
              "en" => $msg_title
    );
    $hashes_array = array();

    $fields = array(
        'app_id' => "c04a760e-c951-4413-a5a0-ac14e18b9d87",
        'include_player_ids' => $devide_ids,
        'data' => array(
            "msg" => $msg_title,
        ),
        'contents' => $content,
        'buttons' => $hashes_array,
    );
    
    $fields = json_encode($fields);
    // print("\nJSON sent:\n");
    echo '<pre>';
    print($fields);
     
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic NWIxMDhjNTEtNTIyYS00OWYwLWE1ZmItNjZkYjRmNDQ2MTIw'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return $response;
    

}


function send_push_notification($msg_title,$devide_ids){ 
        $content      = array(
              "en" => $msg_title
             );
        $headers = array(
            "en"  => 'testing header'
        );

        $fields = array(
            'app_id' => "579e7e69-aca3-44ed-9f3f-a4b985972268",
            'include_player_ids' => array($devide_ids),
            'data' => array(
                "msg" => $msg_title,
            ),
            'contents' => $content,
            'headers' => $headers
        );
    
    $fields = json_encode($fields);
     
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic NzY4YThkN2MtNzU3My00MzUyLThkZmItM2ZmYThiMzlhZjQ4'
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }




function getDeviceIDS($userid){
    global $wpdb;
    $device=array();
            $result = $wpdb->get_results( "SELECT device_token FROM wp_users_device_details WHERE user_id = $userid AND isuserloggedin = 1",ARRAY_A);
                 foreach ( $result as $data ) 
                    {
                        $device[] =  $data['device_token'];
                    }


    return $request = array_unique($device);
}
?>
      
      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~ sendPushNotification with Firebase(Mobile) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
function send_event_release_notification($post_id, $post){
    
    global $wpdb;
    $select_query="SELECT meta_value from wp_usermeta where meta_key='device_id'";
    $devide_id=$wpdb->get_results($select_query,ARRAY_A);
    $devide_ids=array();
    foreach ($devide_id as $key => $value) {
        $devide_ids[]=$value['meta_value'];
    }
    $category_name=get_the_terms($post_id, 'product_cat')[0]->name;
    //echo "<pre>"; print_r($devide_ids);
    $data = array(
        'source' => 'Lilly Ann',
        'msgshow' => $category_name,
    );

    $fcmMsg = array(
        'body' => 'New '.$category_name.' added. Please have a look',
        'title' => the_title($post_id),
        'sound' => "default",
        'color' => "#8e2c93",
    );
    $fcmFields = array(
        'registration_ids' => $devide_ids,
        'priority' => 'high',
        'notification' => $fcmMsg,
        'data' => $data
    );
    
    $headers = array(
        'Authorization: key=AAAAqXkgU7I:APA91bHz9sWA4HUfvh8ekkKYYzQwlV7LgP-rfGwFDf-STj8KWM8nJ573RpnJnxurxui5MJfIGIrTJ0M4h6zMlMKQc1FtnRAlW4AKoBctvicmpWEZ-vwN_vaVndl4P-Zr7Vu4dy4-G5NB',
        'Content-Type: application/json'
    );
    $ch = curl_init();
    curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
    curl_setopt( $ch,CURLOPT_POST, true );
    curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch,CURLOPT_POSTFIELDS,json_encode($fcmFields));
    $result = curl_exec($ch);
    curl_close( $ch );
}

?>
      

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ set corn job url ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    php -q /home2/idpknwa/public_html/wp-pushnotification.php
    /usr/local/bin/php  /home2/armoire/public_html/notify-evnt.php  > /dev/null 2>&1
    php -q /home2/thallthl/public_html/notify-evnt.php


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ gravity form ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    form licence key: 1246ff7794a48774daa16fa22d3d25f1


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ rest api url ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    http://localhost/wordpress//wp-json/jwt-auth/v1/token
    http://localhost/wordpress/wp-json/mobileapi/v1/changePassword


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ taxonomy update ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
//insert taxonamy
$inseretdID =  wp_insert_term($playlistTitle, 'playlist', array('slug'=>$slug, 'parent'=>0) ); 
update_term_meta( $inseretdID['term_id'], 'user_id', $user_id );

    //get taxonamy
    $terms = get_terms([
        'taxonomy' => 'playlist',
        'hide_empty' => false,

      'meta_query' => array(
        array(
        'key' => 'user_id',
        'value' => $user_id,
        'compare' => '='
    
          )
        )
    ]);

    //update taxonamy meta
    update_term_meta( $inseretdID['term_id'], 'user_id', $user_id );
    $inseretdID['term_id'];
    
    //update taxonamy image
    $url = wp_get_attachment_url($param['pictureid']);
    update_option('z_taxonomy_image'.$term['term_id'], $url, NULL);



// add extra taxonomy column
function add_track_columns( $columns ) {
    $columns['foo'] = 'Foo';
    return $columns;
}
add_filter( 'manage_edit-feature_top_columns', 'add_track_columns' );


function add_book_place_column_content($content,$column_name,$term_id){
    $term= get_term($term_id, 'feature_top');
    switch ($column_name) {
        case 'foo':
            //do your stuff here with $term or $term_id
            $content = $term;
            break;
        default:
            break;
    }
    return $content;
}
add_filter('manage_feature_top_custom_column', 'add_book_place_column_content',10,3);


$term = get_term( $term_id, 'feature_top' );
        $slug = $term->slug;


// your taxonomy name
$tax = 'feature_top';
$terms = get_terms( $tax, $args = array(
  'hide_empty' => false, // do not hide empty terms
));

// loop through all terms
foreach( $terms as $term ) {
    $term_link = get_term_link( $term );
    if( $term->count > 0 )
        echo '<a href="' . esc_url( $term_link ) . '">' . $term->name .'</a>';
    elseif( $term->count !== 0 )
        echo '' . $term->name .'';
}


$myposts = get_posts(array(
    'showposts' => -1,
    'post_type' => 'track',
    'tax_query' => array(
        array(
        'taxonomy' => 'feature_top',
        'field' => 'slug',
        'terms' => array('1990s_songs'))
    ))
);
 
foreach ($myposts as $mypost) {
      echo $mypost->post_title . '<br/>';
      echo $mypost->post_content . '<br/>';
      echo  $mypost->ID . '<br/><br/>';
}
?>
  
      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~ Restriction user on login time ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
function myplugin_authenticate_on_hold($user)
{
    // username and password are correct
    if ($user instanceof WP_User) {
        $on_hold = get_user_meta($user->ID, 'Approve', true);

        if ($on_hold == 'Disapprove') {
            return new WP_Error('on_hold_error', 'You are on hold');
        }
    }

    return $user;
}

add_filter('authenticate', 'myplugin_authenticate_on_hold', 21);

?>
      
      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Ajax in wp ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<script>
jQuery(document).ready(function(){
 jQuery('select[name="approveDisapprove"]').on('change', function(){
 var userId = (jQuery(this).attr("data-id"));
 var approves = jQuery(this).val();
// alert(approves);
 
jQuery.ajax({
    url : 'admin-ajax.php',
    type : 'post',
    data : { action : 'create_user_label', user_id : userId, approve:approves },
    success: function(response) {
    // alert(response);
    }
   });
 });
}); 
</script>

<?php
add_action( 'wp_ajax_nopriv_create_user_label', 'create_user_label' );
add_action( 'wp_ajax_create_user_label', 'create_user_label' );

function create_user_label(){
    $userId = $_POST['user_id'];
    $approve = $_POST['approve'];
    update_user_meta( $userId, 'Approve',  $approve);
    exit;
}
?>

 
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Change date formate(JS) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<script>
    jQuery('#changeDaterecent').change( function(){
   var changeLastDate2 = jQuery(this).val();
  var date    = new Date(changeLastDate2),
    yr      = date.getFullYear(),
    month   = date.getMonth() < 10 ? '0' + date.getMonth() : date.getMonth(),
    day     = date.getDate()  < 10 ? '0' + date.getDate()  : date.getDate(),
    newDate2 = month + '/' + day + '/' + yr;
  jQuery(this).prev('.dateFilter2').val(newDate2);

});
</script>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Upload Image (Attachment) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
function upload_profile_image($request){
    $param = $request->get_params();
    $token = trim($param['token']);
    
    $user_id = GetMobileAPIUserByIdToken($token);
    
    $basepath=$_SERVER['DOCUMENT_ROOT']."/profile_images/".$param['filename'];
        
    file_put_contents($basepath, base64_decode($param['profile_image']));
            
    chmod($basepath,0777);
 
    $uploaddir = wp_upload_dir();
        
    $basepath=$_SERVER['DOCUMENT_ROOT'];
    
    $filename = $basepath.'/profile_images/'.$param['filename'];
    
    $wp_filetype = wp_check_filetype(basename($filename), null );
    $uploadfile = $uploaddir["path"] .'/'. basename( $filename );
    
    copy($filename,$uploadfile);
    
    $mime_type=$wp_filetype["type"];
    
    $type_file = explode('/', $mime_type);
    $avatar = time() . '.' . $type_file[1];
     
    $attachment = array(
                         "post_mime_type" => $wp_filetype["type"],
                         "post_title" => preg_replace("/\.[^.]+$/", "" , basename( $filename )),
                         "post_content" => "",
                         "post_status" => "inherit",
                         'guid' => $uploadfile,
                      ); 
                      
    $attachment_id = wp_insert_attachment( $attachment, $uploadfile );
   /*
    $attach_data = wp_generate_attachment_metadata( $attachment_id, $uploadfile );
    wp_update_attachment_metadata( $attachment_id, $attach_data );
    */
   
    unlink($filename);
    
    update_user_meta($user_id,'wp_user_avatar',$attachment_id);
    
    $useravatar = get_user_meta($user_id,'wp_user_avatar',true); 
    
    $img = wp_get_attachment_image_src($useravatar, array('150','150'), true );
    
    $data['profile_image']=$img[0];
    
    return new WP_REST_Response($data, 200);
 }
?>

      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Add widget in dashboard ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
/* add widget */
function add_customDashboardWidget() {
  wp_add_dashboard_widget('wp_dashboard_widget', 'Custom Content', 'customContent');
}

/* add action */
add_action('wp_dashboard_setup', 'add_customDashboardWidget', 2,2 );

function customContent(){
    echo '<input type="text">';
}
?>
   
      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Upadte fearture product in wc ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
    $postss =  126925;
    $terms = array( 'featured' );
    $test = wp_set_object_terms( $postss, $terms, 'product_visibility');

    wp_remove_object_terms(126955, $terms, 'product_visibility');
    print_r($test);
?>

      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ get product in wc ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        <?php
        $orders_list = get_posts( array(
            'numberposts' => -1,
            'meta_key'    => '_customer_user',
            'meta_value'  => 24,
            'post_type'   => wc_get_order_types(),
            'post_status' => array_keys( wc_get_order_statuses() ),
        ) );
        ?>


<?php
 if(!isset($param['status']) || !isset($param['track_id']) || empty($param['track_id']) ){
                $data  = array(
                    "status"    => "error",
                    "errormsg"  => "missing_parameters('status','track_id')",
                    "msg"       => "Missing parameters. Please check it.",
                    'error_code'=> "403"
                );
                return new WP_REST_Response($data, 403);  
            }

?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ unset role user ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
    add_filter('editable_roles','wdm_user_role_dropdown');
    function wdm_user_role_dropdown($all_roles) {
        
        global $pagenow, $current_user, $wp_taxonomies;
        if($current_user->roles[0] == "community_admin"){
            unset($all_roles['moderator1']);
            unset($all_roles['moderator']); 
        } else if($current_user->roles[0] == "page_admin"){
            unset($all_roles['moderator1']);
            unset($all_roles['moderator']);
        }
        return $all_roles;
    }
?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~ Get Current latitude & longitude(JS) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
    <script>
          if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
          } else { 
            x.innerHTML = "Geolocation is not supported by this browser.";
          }

        function showPosition(position) {
          var Latitude = position.coords.latitude;
          document.getElementById("Latitude").value = Latitude;
          var Longitude = position.coords.longitude;
          document.getElementById("Longitude").value = Longitude;
        }
    </script>

<?php
// location -start 
     $findPRoduct = 0;
    if(isset($get_data['product_search_distance']) && !empty($get_data['product_search_distance'])){
        $range = $get_data['product_search_distance'];
    }else{
       $range =50;
    }
    global $wpdb;
    if(isset($get_data['product_search_distance'])){
    $latitude = $get_data['Latitude_distance'];
    // $latitude = 26.90515;
    $longitude = $get_data['Longitude_distance'];
    // $longitude = 80.9479913;

    $lat_range = $range/69.172;  
    $lon_range = abs($range/(cos($latitude) * 69.172));  
    $min_lat = number_format($latitude - $lat_range, "4", ".", "");  
    $max_lat = number_format($latitude + $lat_range, "4", ".", "");  
    $min_lon = number_format($longitude - $lon_range, "4", ".", "");  
    $max_lon = number_format($longitude + $lon_range, "4", ".", "");

    $sql = "select wp_posts.*, pm1.meta_value as lat, pm2.meta_value as lon,ACOS(SIN(RADIANS($latitude))*SIN(RADIANS(pm1.meta_value))+COS(RADIANS($latitude))*COS(RADIANS(pm1.meta_value))*COS(RADIANS(pm2.meta_value)-RADIANS($longitude))) * 3959 AS distance from wp_posts INNER JOIN wp_postmeta pm1 ON wp_posts.ID = pm1.post_id AND pm1.meta_key = 'latitude' INNER JOIN wp_postmeta as pm2 ON wp_posts.ID = pm2.post_id AND pm2.meta_key = 'longitude'  having distance<=".$range;

$sqls = "select wp_posts.*, pm1.meta_value as lat, pm2.meta_value as lon,ACOS(SIN(RADIANS(26.90515))*SIN(RADIANS(pm1.meta_value))+COS(RADIANS(26.90515))*COS(RADIANS(pm1.meta_value))*COS(RADIANS(pm2.meta_value)-RADIANS(80.9479913))) * 3959 AS distance from wp_posts INNER JOIN wp_postmeta pm1 ON wp_posts.ID = pm1.post_id AND pm1.meta_key = 'latitude' INNER JOIN wp_postmeta as pm2 ON wp_posts.ID = pm2.post_id AND pm2.meta_key = 'longitude' having distance < ".$range;
// var_dump($sql);
     $product_query1 = $wpdb->get_results($sqls);
     // print_r($product_query1);
    // echo 'query: '.$query;
// location -end
     if($product_query1){
        $findPRoduct = 1;
     }
$original_post = $post;
      foreach ($product_query1 as $value) {
          // echo $value->ID;
           $product = wc_get_product( $value->ID );

                    $row_args = array(
                        'post' => $post,
                        'product' => $product,
                        'tr_class' => $tr_class,
                        'row_actions' => $row_actions,
                    );

                dokan_get_template_part( 'products/products-listing-row', '', $row_args );
                do_action( 'dokan_product_list_table_after_row', $product, $post );
      }
 }
?>

      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~ WC Prodcut And Order Detail api endpoint ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
https://site.org/wp-json/wc/v2/products?category=20&consumer_key=ck_d8474e840e7c1065c1aeb8b6606887487b35b179&consumer_secret=cs_9124276557551e5b157cd383138ee74a93c63a8e&per_page1&page=1

https://site.betaplanets.com/wp-json/wc/v3/orders/126147?consumer_key=ck_b69a904ed5f126d3e76e622480cdf9b21e5d2769&consumer_secret=cs_224d7648e5470c3bd9fd6694789d8abda0142006

https://site.betaplanets.com/wp-json/wc/v3/products/

https://site.betaplanets.com/wp-json/wc/v3/products/?consumer_key=ck_b69a904ed5f126d3e76e622480cdf9b21e5d2769&consumer_secret=cs_224d7648e5470c3bd9fd6694789d8abda0142006

https://site.betaplanets.com/wp-json/wc/v3/orders/125307?consumer_key=ck_b69a904ed5f126d3e76e622480cdf9b21e5d2769&consumer_secret=cs_224d7648e5470c3bd9fd6694789d8abda0142006

redstitch api credential -
Consumer key: ck_b69a904ed5f126d3e76e622480cdf9b21e5d2769
Consumer secret: cs_224d7648e5470c3bd9fd6694789d8abda0142006
      
https://site.betaplanets.com/wp-json/wc/v3/orders/?consumer_key=ck_b69a904ed5f126d3e76e622480cdf9b21e5d2769&consumer_secret=cs_224d7648e5470c3bd9fd6694789d8abda0142006


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ WC Order Hook API ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
add_filter( 'woocommerce_rest_prepare_shop_order_object', 'my_wc_rest_prepare_order', 10, 3 );
function my_wc_rest_prepare_order( $response, $order, $request ) {

  if( empty( $response->data ) )
    return $response;

  $order_id = $order->get_id();

  // Get an instance of the WC_Order object
  $order = wc_get_order($order_id);

  // Get the user ID from WC_Order methods
  $user_id = $order->get_customer_id(); // $order->get_user_id(); // or $order->get_customer_id();

  // check for WooCommerce Social Login User Avatar
  if( class_exists( 'WC_Social_Login' ) ) {

    $fb_avatar = get_user_meta( $user_id, '_wc_social_login_facebook_profile_image', true );
    $gplus_avatar = get_user_meta( $user_id, '_wc_social_login_google_profile_image', true );

  }

  $social_data = array();
  $avatar_url  = array();

  $customer_picture = array(
    'default'   => get_avatar_url( $user_id ),
    'facebook'  => ( $fb_avatar ) ? esc_url( $fb_avatar ) : '',
    'google'    => ( $gplus_avatar ) ? esc_url( $gplus_avatar ) : ''
  );

  $response->data['social_data']['avatar_url'] = $customer_picture;
  return $response;
}
?>
      
      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Hide sidebar in custom Post ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
add_action('init', 'my_rem_editor_from_post_type');
function my_rem_editor_from_post_type() {
    remove_post_type_support( 'custom_choices', 'editor' );
}

add_action('do_meta_boxes', 'remove_thumbnail_box');
function remove_thumbnail_box() {
    remove_meta_box( 'postimagediv','custom_choices','side' );
    remove_meta_box( 'wpseo_meta', 'custom_choices', 'normal' );
    remove_meta_box('slugdiv', 'custom_choices', 'normal');
    remove_meta_box( 'minor-publishing', 'custom_choices', 'side' );
}
?>
      
      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~ file_put_contents (create new file) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
add_action( 'pmpro_after_change_membership_level', 'test_function' );
function test_function(int $level_id, int $level_id, int $cancel_level){
    echo '<pre>';
   $wer1 = array($level_id,$level_id,$cancel_level);
    echo '</pre>';
    
    
    $wer1 = json_encode($wer1);
$txt = "user id date";
$myfile = file_put_contents('wp-content/plugins/web-custom-work/template/inc/logs.php', $wer1.PHP_EOL , FILE_APPEND | LOCK_EX);
    
}
?>
      
      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Add ip Address ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
    $ip = $_SERVER['REMOTE_ADDR'];
    if($ip == '103.251.221.98'){ }
?>
      
      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Video Upload on fb by api ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
      public function post_video_on_fb(){ 
            $data = array('error'=>false, 'msg'=> '', 'data'=> array());
            // $object_id = '2049854628654913';
            $object_id = '228461128278329';
            $access_token = 'EAAnr55NzTKsBAEO2horfHecvmBgWg0ruZBDWazhRpzaqZAAasL9aE3C7RZC5HGU9GpT0ZA9tiXXZC3dpyK38ZBqLYReaqjP07gz9eGwV9jB2bQbzs7RiSmOxdFf3FEddB2x2aysgGA2BSVLwlZB7vYwELpCxdZBOKyFXc97USbOrqwZDZD';
            $post_data = array(
                'upload_phase'  => 'start',
                'file_size'     => '152043520',
            );
            try {
                // Returns a `FacebookFacebookResponse` object
                $res1 = $this->fb->post('/'.$object_id.'/videos', $post_data,$access_token);
                $result1 = json_decode($res1->getBody(),true);
            } catch(FacebookExceptionsFacebookResponseException $e) {
                $data['error'] = true;
                $data['msg'] = 'Step-1 Graph error: ' . $e->getMessage();
            }catch(FacebookExceptionsFacebookSDKException $e) {
                $data['error'] = true;
                $data['msg'] = 'Step-1 Facebook SDK error: ' . $e->getMessage();
            }catch(Exception $e) {
                $data['error'] = true;
                $data['msg'] = 'Step-1 Facebook SDK error=>: ' . $e->getMessage();
            }
            
            if(isset($result1['video_id']) && !empty($result1['video_id']) && isset($result1['upload_session_id']) && !empty($result1['upload_session_id']) ){
                $core_file_path = '/home2/actshvt/public_html/wp-content/uploads/2020/06/Pexels Videos.mp4';
                
                // $core_file_path = 'https://activityshare.betaplanets.com/wp-content/uploads/2020/06/SampleVideo_1280x720_1mb.mp4';
                // "https://graph-video.facebook.com/{object-id}/videos"  \
                // -F "access_token={your-access-token}" \
                // -F "upload_phase=transfer" \
                // -F "start_offset=0" \                                //Start byte position of this chunk, which is `0`.
                // -F "upload_session_id={your-upload-sesson-id}" \     //The session id returned in the `start` phase.
                // -F "video_file_chunk=@chunk1.mp4"  
                
                $video_chunks_data = array(
                     'title' => 'My Video Pexels',
                     'description' => 'This video is full of foo and bar action Pexels.',
                     'source' => $this->fb->videoToUpload("$core_file_path"),
                );
                
                print_r($video_chunks_data);
                
                try {
                    // $res2 = $fb->post('/' . $object_id . '/videos', $data, $access_token);
                    $res2 = $this->fb->post('/me/videos', $video_chunks_data, $access_token);
                    $result2 = $res2->getGraphNode();
                    // $result2 = json_decode($res2->getBody(), true);
                    // print_r($res2);
                    // print_r($result2);
                } catch(FacebookExceptionsFacebookResponseException $e) {
                    $data['error'] = true;
                    $data['msg'] = 'Step-2 Graph error: ' . $e->getMessage();
                }catch(FacebookExceptionsFacebookSDKException $e) {
                    $data['error'] = true;
                    $data['msg'] = 'Step-3 Facebook SDK error: ' . $e->getMessage();
                }catch(Exception $e) {
                    $data['error'] = true;
                    $data['msg'] = 'Step-4 Facebook SDK error=>: ' . $e->getMessage();
                }
                
                print_r($result1);
            }
            print_r($data);
         }

?>


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~ Video Upload on twitter by api ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
 public function post_video_on_twitter(){
$data = array('error'=> false, 'data'=>"test..");

$oauth_token = '1263743159336603648-R1Xu0j5KRWps3x4bP2RcWPLEXg3MZU';
$oauth_token_secret = 'Y49aCp2WlQVvEXG9XSYYcwxlvoDsgZZYdLqDF4UEZ7381';
$core_file_path = '/home2/actshvt/public_html/wp-content/uploads/2020/06/Pexels Videos.mp4';

if(isset($oauth_token) && !empty($oauth_token) && isset($oauth_token_secret) && !empty($oauth_token_secret) ){
    $this->auth($oauth_token, $oauth_token_secret);
}
$result = $this->connection->get("account/verify_credentials", ['include_email' => 'true']);
$tweetWM = $this->connection->upload('media/upload',['media' => $core_file_path , 'media_type' => 'video/mp4'],true);
$tweet = $this->connection->post('statuses/update',['media_ids' => $tweetWM->media_id , 'status' => 'tweeting with video file']);
  
         return $tweet;
    }
?>
    
      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~ error_reporting off [start] ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
  <?php    
    ini_set('display_errors','Off');
    ini_set('error_reporting', E_ALL );
  ?>

      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ create WP_list_table ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
 <?php
if(is_admin()){
    new Paulund_Wp_List_Table();
}

class Paulund_Wp_List_Table{

    public function __construct(){
        add_action( 'admin_menu', array($this, 'add_menu_example_list_table_page' ));
    }


    public function add_menu_example_list_table_page(){
        add_menu_page( 'User Subscription Data', 'User Subscription', 'manage_options', 'user-subscription', array($this, 'list_table_page'),'dashicons-admin-users',6 );
    }


    public function list_table_page(){
        $exampleListTable = new Example_List_Table();
        $exampleListTable->prepare_items();
        ?>
            <div class="wrap">
                <div id="icon-users" class="icon32"></div>
                <h2>User Subscription</h2>
                <?php $exampleListTable->display(); ?>
            </div>
        <?php
    }
}


if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}


class Example_List_Table extends WP_List_Table{

    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();
        usort( $data, array( &$this, 'sort_data' ) );

        $perPage = 8;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );

        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }


    public function get_columns(){
        
         $columns = array(
            'id'                  => 'ID',
            'user_name'           => 'User Name',
            'subscription'        => 'Subscription',
            'transaction_id'      => 'Transcation Id',
            'subscription_device' => 'Sub Device',
            'created'             => 'Created',
            'modified'            => 'Modified'
        );
        return $columns;
    }

    public function get_hidden_columns(){
        return array();
    }

    public function get_sortable_columns(){
        return array('user_name' => array('user_name', false));
    }

    private function table_data(){
        $data = array();
        global $wpdb;
        $subscription_users = $wpdb->get_results('SELECT * FROM `user_subscriptions`', ARRAY_A);
        $countId = 1;
        foreach($subscription_users as $subscription_user){
            
        $userName = get_user_meta($subscription_user['user_id'],'first_name', true) .' '. get_user_meta($subscription_user['user_id'],'last_name', true);
        $subscriptions = explode('.',$subscription_user['Subscription']);
        
        $data[] = array(
                    'id'                  => $countId,
                    'user_name'           => $userName,
                    'subscription'        => ucfirst($subscriptions[2]),
                    'transaction_id'      => $subscription_user['transcation_id'],
                    'subscription_device' => $subscription_user['subscription_device'],
                    'created'             => $subscription_user['created'],
                    'modified'            => $subscription_user['modified']
                    
                    );
                    
               $countId++;     
                }

        return $data;
    }


    public function column_default( $item, $column_name ) {
        switch( $column_name ) {
            case 'id':
            case 'user_name':
            case 'subscription':
            case 'transaction_id':
            case 'subscription_device':
            case 'created':
            case 'modified':
                return $item[ $column_name ];

            default:
                return print_r( $item, true ) ;
        }
    }


    private function sort_data( $a, $b ){
        // Set defaults
        $orderby = 'user_name';
        $order = 'asc';

        if(!empty($_GET['orderby'])){
            $orderby = $_GET['orderby'];
        }
        
        if(!empty($_GET['order'])){
            $order = $_GET['order'];
        }

        $result = strcmp( $a[$orderby], $b[$orderby] );

        if($order === 'asc'){
            return $result;
        }
        
        return -$result;
    }
}    
?> 
      
      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Add Menu in Wp Settings ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<?php
    function custom_plugin_setting_page() {
        add_options_page('App Setting', 'App Setting', 'manage_options', 'custom-plugin-setting-url', 'custom_page_html_form');
        }
        add_action('admin_menu', 'custom_plugin_setting_page');
?>
      
      
      
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ Upload Attachment(Image) ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->    
     <?php
    $file_name = $_FILES['fileToUpload']['name'];
                $file_temp = $_FILES['fileToUpload']['tmp_name'];

                $upload_dir = wp_upload_dir();
                $image_data = file_get_contents( $file_temp );
                $filename = basename( $file_name );
                $filetype = wp_check_filetype($file_name);
                $filename = time().'.'.$filetype['ext'];

                if ( wp_mkdir_p( $upload_dir['path'] ) ) {
                  $file = $upload_dir['path'] . '/' . $filename;
                }
                else {
                  $file = $upload_dir['basedir'] . '/' . $filename;
                }

                file_put_contents( $file, $image_data );
                $wp_filetype = wp_check_filetype( $filename, null );
                $attachment = array(
                  'post_mime_type' => $wp_filetype['type'],
                  'post_title' => sanitize_file_name( $filename ),
                  'post_content' => '',
                  'post_status' => 'inherit'
                );

                $attach_id = wp_insert_attachment( $attachment, $file );
                require_once( ABSPATH . 'wp-admin/includes/image.php' );
                $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
                wp_update_attachment_metadata( $attach_id, $attach_data );

                echo $attach_id;
         ?>
