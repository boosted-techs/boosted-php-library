<?php
/* Smarty version 3.1.34-dev-7, created on 2020-09-22 14:01:57
  from '/Applications/MAMP/htdocs/boosted-php-library/app/views/templates/test.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f6a03d5a3e7b4_85754359',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd39a1cbdbecf5d89ba0de6ad9f375cd18a627e82' => 
    array (
      0 => '/Applications/MAMP/htdocs/boosted-php-library/app/views/templates/test.tpl',
      1 => 1600783317,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6a03d5a3e7b4_85754359 (Smarty_Internal_Template $_smarty_tpl) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['array']->value, 'list');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['list']->value) {
?>
    <?php echo $_smarty_tpl->tpl_vars['list']->value['greet'];?>

<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
