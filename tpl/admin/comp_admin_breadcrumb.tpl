

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