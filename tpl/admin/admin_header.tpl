<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>{$TITLE}</title>
<link rel="stylesheet" href="http://{$WEB_ROOT}{$PUBLIC_DIR}/css/init.css" type="text/css" media="all" />

<link rel="stylesheet" href="http://{$WEB_ROOT}{$PUBLIC_DIR}/elib/admin.css" type="text/css" media="all" />

<script type="text/javascript" src="http://{$WEB_ROOT}{$PUBLIC_DIR}/js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="http://{$WEB_ROOT}{$PUBLIC_DIR}/js/common.js"></script>
<script type="text/javascript" src="http://{$WEB_ROOT}{$PUBLIC_DIR}/elib/admin.js"></script>
<script type="text/javascript" src="http://{$WEB_ROOT}{$PUBLIC_DIR}/elib/tiny_mce/tiny_mce.js"></script>

</head>

<body>
<div id="page">

<div id="admin_head">
<form action="http://{$WEB_ROOT}{$PUBLIC_DIR}/misc/logout" method="post">
<p>{$current_user} <button type="submit" name="logout">Logout</button></p>
</form>

<p><a href="http://{$WEB_ROOT}{$PUBLIC_DIR}"><img src="http://{$WEB_ROOT}{$PUBLIC_DIR}/img/new_twitter.png" alt="" /></a></p>

<h1>
{if $class eq 'admin' && $event eq 'default_event'}Admin{else}<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/">Admin</a>{/if}
{if $class eq 'section' || $class eq 'data_item'} &raquo; Generic Sections
{elseif $class eq 'category'} &raquo; Products
{elseif $class eq 'product'} &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/category">Products</a>
{if $event eq 'default_event'} &raquo; {$product->name}
{elseif $event eq 'upload_image'} &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/{$product->id}">{$product->name}</a> &raquo; Upload Image
{elseif $event eq 'edit'} &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/{$product->id}">{if isset($old_product_name)}{$old_product_name}{else}{$product->name}{/if}</a> &raquo; Edit
{elseif $event eq 'edit_variant'} &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/{$product->id}">{$product->name}</a> &raquo; Edit Variant ({$variant->id})
{elseif $event eq 'upload_variant_image'} &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/{$product->id}">{$product->name}</a> &raquo; Upload Variant Image ({$variant->id})
{elseif $event eq 'variant_properties'} &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/{$product->id}">{$product->name}</a> &raquo; Variant Properties ({$variant->id})
{/if}
{elseif $class eq 'properties'}
{if $event eq 'rename'} &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/category">Products</a> &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/properties">Properties</a> &raquo; Rename ({$property->id})
{else}
 &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/category">Products</a> &raquo; Properties
{/if}
{elseif $class eq 'blog'} &raquo; 
  {if $event eq 'default_event'}Blog{else}<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/blog">Blog</a>{/if}
  {if $event eq 'edit_blog'} &raquo; Edit Blog Item{elseif $event eq 'create'} &raquo; Create Blog Item{/if}
  {if $event eq 'view'} &raquo; View Blog Item{/if}
{elseif $class eq 'blog_cat'} &raquo;
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/blog">Blog</a> &raquo; Edit Categories
{elseif $class eq 'ban_dir' || $class eq 'banner'}
 &raquo; Banners
{/if}
{if $class eq 'admin' && $event eq 'password'}
 &raquo; Change My Password
{elseif $class eq 'containers'} &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/section">Generic Sections</a> &raquo;
{if $event eq 'default_event'} Edit Containers{elseif $event eq 'rename'}Rename Container{/if}
{elseif $class eq 'image_sizes'} &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/section">Generic Sections</a> &raquo; Edit Image Sizes


{/if}
</h1>
</div>


{if isset($help_file)}
<div id="help_wrapper1">
  <div id="help_wrapper2">
    <div class="grey{if $help_shown eq true} shown{/if}" id="help">
      <a href="#" id="help_tab"><span>Help</span></a>
      <div id="help_inner"><div>
          {include file=$help_file}
        </div>
      </div>
    </div>
  </div>
</div>
<p style="line-height: 0.5em;">&nbsp;</p>
{/if}

