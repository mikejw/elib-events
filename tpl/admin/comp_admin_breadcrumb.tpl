

<h1>

{* admin *}
{if $class eq 'admin' && $event eq 'default_event'}Admin{else}
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/">Admin</a>{/if}



{* store *}
{if $class eq 'admin' && $event eq 'store'} &raquo; Store
{elseif $class eq 'brand' || $class eq 'artist' || $class eq 'orders' || $class eq 'category' || $class eq 'properties' || $class eq 'product' || $class eq 'promo_category'}
&raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/store">Store</a>{/if}



{* products *}
{if $class eq 'category'} &raquo; Products
{elseif $class eq 'artist'}
  {if $event eq 'default_event'} &raquo; Artists
  {else} &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/artist">Artists</a>
    {if $event neq 'add'}&raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/artist/{$artist->id}">{if $artist->artist_alias neq ''}{$artist->artist_alias}{else}{$artist->forename} {$artist->surname}{/if}</a> {/if}{/if}
  {if $event eq 'upload_image'} &raquo; Upload Image
  {elseif $event eq 'add'} &raquo; Add New Artist
  {elseif $event eq 'edit_bio'} &raquo; Edit Artist Biography
  {/if}
{elseif $class eq 'product'} &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/category">Products</a>
  {if $event eq 'default_event'} &raquo; {$product->name}
  {elseif $event eq 'upload_image'} &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/{$product->id}">{$product->name}</a> &raquo; Upload Image
  {elseif $event eq 'edit'} &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/{$product->id}">{if isset($old_product_name)}{$old_product_name}{else}{$product->name}{/if}</a> &raquo; Edit
  {elseif $event eq 'edit_variant'} &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/{$product->id}">{$product->name}</a> &raquo; Edit Variant ({$variant->id})
  {elseif $event eq 'upload_variant_image'} &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/{$product->id}">{$product->name}</a> &raquo; Upload Variant Image ({$variant->id})
  {elseif $event eq 'variant_properties'} &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/product/{$product->id}">{$product->name}</a> &raquo; Variant Properties ({$variant->id})
  {elseif $event eq 'resize_images'} &raquo; Resize Product Images
  {/if}
{elseif $class eq 'properties'}
  {if $event eq 'rename'} &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/category">Products</a> &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/properties">Properties</a> &raquo; Rename ({$property->id})
  {else}
 &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/category">Products</a> &raquo; Properties
  {/if}
{elseif $class eq 'brand'} &raquo; Brands
{/if}


{* blog *}
{if $class eq 'blog'} &raquo; 
  {if $event eq 'default_event'}Blog{else}<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/blog">Blog</a>{/if}
  {if $event eq 'edit_blog'} &raquo; Edit Blog Item{elseif $event eq 'create'} &raquo; Create Blog Item{/if}
  {if $event eq 'view'} &raquo; View Blog Item{/if}
{elseif $class eq 'blog_cat'} &raquo;
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/blog">Blog</a> &raquo; Edit Categories
{/if}

{* cms *}
{if $class eq 'dsection'}
  {if $event eq 'default_event' || $event eq 'data_item'}
  &raquo; Generic Sections  
  {else}
  &raquo; <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/admin/dsection">Generic Sections</a>
  {/if}

  {if $event eq 'containers'} &raquo; Edit Containers
  {elseif $event eq 'rename_container'} &raquo; Rename Container
  {elseif $event eq 'image_sizes'} &raquo; Edit Image Sizes
  {/if}
{/if}




{* password *}
{if $class eq 'admin' && $event eq 'password'}
 &raquo; Change My Password
{/if}

</h1>