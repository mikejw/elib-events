

{if sizeof($promos) > 0}
<div id="promos_wrapper">
<ul id="promos" class="jcarousel-skin-bbc">
{foreach from=$promos item=promo}
<li><a href="{$promo.url}"><img src="http://{$WEB_ROOT}{$PUBLIC_DIR}/uploads/{$promo.image}" alt="" /></a></li>
{/foreach}
</ul>
</div>
{/if}


<p>&nbsp;</p>

{if $category_id neq 0}
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/store/accepting_paypal"><img style="float: right;" src="http://{$WEB_ROOT}{$PUBLIC_DIR}/img/shopnow.gif" alt="Shop now using PayPal." /></a>
{/if}

<p id="breadcrumb">
{counter start=1 assign=i print=false}
{foreach from=$breadcrumb item=crumb}
{if $crumb.id eq $category_id}
<span>{$crumb.name}</span>
{else}
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/store{if $crumb.id neq 0}}/{$crumb.id}{/if}">{$crumb.name}</a>
{/if}
{if $i neq sizeof($breadcrumb)}
 / 
{/if}
{counter}
{/foreach}
{if isset($product)}
{if isset($product_view) || isset($mixed_view)}
/ <span>{$brand} {$product->name|replace:"&":"&amp;"}</span>
{else}
/ <a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/store/product/{$product->id}">{$product->name}</a>
{/if}
{/if}
{if isset($variant_name) && !isset($mixed_view)}
/ {$variant_name|replace:' / ':'-'}
{/if}
</p>




<div id="products_wrapper">
<div id="products" class="clear">
{if sizeof($buttons) > 0}
{foreach from=$buttons item=button}
<div class="button">
{if isset($button.product_id)}
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/store/{$category_name|lower|replace:" ":"-"}/{$button.name|lower|replace:" ":"-"|replace:"&":""|replace:"'":""|replace:"/":"-"}-{$button.product_id}.html">
{elseif isset($button.category_id)}
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/store/{$button.name|lower|replace:" ":"-"}/1">
{else}
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/?variant_id={$button.variant_id}">
{/if}
<span class="name">{$button.name|replace:"&":"&amp;"}</span>
<img src="http://{$WEB_ROOT}{$PUBLIC_DIR}/uploads/tn_{$button.image|replace:"&":"&amp;"}" alt="" />
{if isset($button.product_id)}
<span class="price">&pound;{$button.price}&nbsp;</span>
{/if}
</a>
</div>
{/foreach}
{/if}
</div>
<h1>&nbsp;</h1>
</div>


{if sizeof($p_nav) > 1}
<div id="p_nav">
<p>Page: 
{foreach from=$p_nav key=k item=v}
{if $v eq 1}<span>{$k}</span>
{else}
<a href="http://{$WEB_ROOT}{$PUBLIC_DIR}/store/{$category_name|lower|replace:" ":"-"}/{$k}">{$k}</a>
{/if}
{/foreach}
</p>
</div>
{else}
<p>&nbsp;</p>
{/if}

