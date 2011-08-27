<?php

$strAddrLogin = generateLink(array(
    'page' => 'login',
    'proceed' => '1'
));
$strAddrLogout = generateLink(array(
    'page' => 'logout',
));
$strAddrPeople = generateLink(array(
    'page' => 'people',
));

$headerAuth =<<<EOT
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="$strAddrPeople">Personen</a></li>
        <li><a href="#">Rollen</a></li>
        <li><a href="#">Zugriff</a></li>
        <li><a href="#">Server</a></li>
        <li><a href="#">Daemons</a></li>
        <li><a href="$strAddrLogout">Logout</a></li>
    </ul>
EOT;

$headerUnauth =<<<EOT
    <ul>
        <li><a href="$strAddrLogin">Login</a></li>
    </ul>
EOT;

$contentUnauth =<<<EOT
    <h1>Bitte Anmelden</h1>
    <p>Melden Sie sich über den Button rechts oben an.</p>
EOT;

$footer =<<<EOT
    &copy; 2011 - Alexander Philipp Lintenhofer (Backend), Florian Staudacher (Frontent)
EOT;

$header  = $headerUnauth;
$content = $contentUnauth;

if( loggedIn() )
{
    $header  = $headerAuth;
    $pageContent = fetchContent( page() );
    $content = $pageContent['content'];
    $scripts = $pageContent['scripts'];
}


/**
 * get the content from the coresponing file(s).
 * 
 * the seperate files put all their output in the $content variable,
 * which is being returned by this function
 */
function fetchContent($page=null)
{
    $file = '';
    
    switch($page)
    {
        /*
        TODO: actually make the pages
        */

        case 'people':
            $file = 'people';
            break;

        case 'login':
        default:
            $file = 'start';
            break;
    }

    include("$file.content.php");
    
    return array(
        'content' => $content,
        'scripts' => $scripts,
    );
}


?>