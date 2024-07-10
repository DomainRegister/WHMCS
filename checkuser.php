<?php
/**
 * check user data
 *
 * This hook checks user data, in order to prevent the user from registering
 * or later editing his data using:
 * - fake or disposable email addresses (using https://www.mailcheck.ai/)
 *   free API service
 * - special characters
 * - too long strings
 * @copyright  DomainRegister
 *             https://domainregister.international
 *             info@domainregister.it
 * License:    GNU General Public License v3.0
 * 
 */



if (!defined("WHMCS"))
    die("This file cannot be accessed directly");

function checkuserdata($vars) {
    $email = $vars['email'];
    $elements = ['firstname','lastname','companyname','address1','address2','city','state','postcode','country','phonenumber','tax_id'];
    $usererrors = [];
    
    // chesk disabled if operation is done in admin area
    if ($_SERVER['SCRIPT_NAME']=='/admin/clientsprofile.php'){
        return;
    }

// prevent registrations coming from the USA. You can edit this command in order to extend the mechanism to other specific countries    
    if ($vars['country']=='US'){
        array_push($usererrors, "Sorry, for safety reasons no registration is allowed from USA: please <a href='/contact.php'>contact us</a> for further details.");
    }  

  
    foreach($elements as $element){
        if (checkstring($vars[$element])){
          array_push($usererrors, "Your ".$element." contains invalid characters");
        } 
         if (strlen($vars[$element])>150){
          array_push($usererrors, "Your ".$element." is too long");
        }   
     }
  

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.mailcheck.ai/email/' . $email);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);
    $response2=json_decode($response);
    $debug = var_export($response2, true);  
    if ($response2->disposable OR !$response2->mx)
        { array_push($usererrors, "Your email address is not valid");
        }  
    
    return $usererrors;
}



function checkstring ($string1)
{
     $invalidchars=str_split("£$%&/()=!#@?^[]<>");
     foreach($invalidchars as $character){
            if (strchr($string1, $character))
               { return true;
               }
     }
     return; 
} 

add_hook("ClientDetailsValidation",1,"checkuserdata");
