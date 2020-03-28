<?php
// exemple http://localhost/projets/ecommerce-solidaire.fr/www/affiche.php?url=https://tartines-et-gourmandises.ecommerce-solidaire.fr/

$url = (isset($_GET['url']) && $_GET['url'])?$_GET['url']:'';

if (!$url) {
    echo '<h1>Une erreur est survenue</h1>';
    echo 'Rajoutez l\'url ?url=';
    echo '<br>';
    echo 'Exemple : https://www.ecommerce-solidaire.fr/affiche.php?url=https://tartines-et-gourmandises.ecommerce-solidaire.fr/';
    exit;
}

?>
<!doctype html>
<html class="no-js h-100" lang="fr">

<head>
    <meta charset="utf-8">
    <title>Affiche du site <?php echo htmlentities($url)?></title>
    
    <!-- Matomo -->
    <script type="text/javascript">
        var _paq = window._paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
        var u="https://analytics.mediacom87.net/";
        _paq.push(['setTrackerUrl', u+'piwik.php']);
        _paq.push(['setSiteId', '7']);
        var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
        g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
        })();
    </script>
    <!-- End Matomo Code -->
  
</head>

<body>
    <div style="text-align:center;">
        <h1>Commandez nos produits en ligne</h1>
        <h2>sur <?php echo htmlentities(trim(str_replace('https://','', $url),'/'))?></h2>
        <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=<?php echo urlencode($url)?>&choe=UTF-8"/>
        <p>Site ecommerce proposé gratuitement par l'initiative e-Commerce Solidaire<br> par Friends-of-Presta ecommerce-solidaire.fr
    </div>
</body>
