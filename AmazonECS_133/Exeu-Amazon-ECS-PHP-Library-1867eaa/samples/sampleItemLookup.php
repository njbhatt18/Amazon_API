<?php
/**
 * For a running Search Demo see: http://amazonecs.pixel-web.org
 */

if ("cli" !== PHP_SAPI)
{
    echo "<pre>";
}


if (is_file('sampleSettings.php'))
{
  include 'sampleSettings.php';
}

defined('AWS_API_KEY') or define('AWS_API_KEY', 'AKIAIBRJIITU7TN6QCEQ');
defined('AWS_API_SECRET_KEY') or define('AWS_API_SECRET_KEY', '3ncwjvPcDx9cmf/MxxSIeAhKziuJ2zn4R2MoxupT');
defined('AWS_ASSOCIATE_TAG') or define('AWS_ASSOCIATE_TAG', 'be011-20');

require '../lib/AmazonECS.class.php';

try
{
    $amazonEcs = new AmazonECS(AWS_API_KEY, AWS_API_SECRET_KEY, 'com', AWS_ASSOCIATE_TAG);

    // for the new version of the wsdl its required to provide a associate Tag
    // @see https://affiliate-program.amazon.com/gp/advertising/api/detail/api-changes.html?ie=UTF8&pf_rd_t=501&ref_=amb_link_83957571_2&pf_rd_m=ATVPDKIKX0DER&pf_rd_p=&pf_rd_s=assoc-center-1&pf_rd_r=&pf_rd_i=assoc-api-detail-2-v2
    // you can set it with the setter function or as the fourth paramameter of ther constructor above
    $amazonEcs->associateTag(AWS_ASSOCIATE_TAG);

    // Looking up multiple items
    $response = $amazonEcs->responseGroup('Large')->optionalParameters(array('Condition' => 'New'))->lookup('B0017TZY5Y', 'B004DULNPY');
    //var_dump($response);

    $response = $amazonEcs->responseGroup('Images')->lookup('B0017TZY5Y');
    //var_dump($response);

}
catch(Exception $e)
{
  echo $e->getMessage();
}

if ("cli" !== PHP_SAPI)
{
    echo "</pre>";
}
