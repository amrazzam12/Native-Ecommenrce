<?php 

function lang($phrase){

    static $lang =  array(


        // Navbar 
        "HOME" => "Home" , 
        "CATEGORIES" => "Categories" , 
        "ITEMS" => "Items" , 
        "MEMBERS" => "Members" , 
        "STATISTICS" => "Statisitics" ,   
        "LOGS" => "Logs",
        "LOGOUT" => "Log out",
        "EDIT" => "Edit Profile",
        "COMMENTS" => "Comments"
        // Navbar
    );

    return $lang[$phrase];

}
