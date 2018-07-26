<?php

namespace Merconis\Custom;

if (TL_MODE == 'BE') {
	$GLOBALS['TL_CSS'][] = 'bundles/leadingsystemsmerconiscustom/be/css/style.css';
}

$GLOBALS['BE_MOD']['merconis_custom'] = array(
	'merconis_custom_dummy' => array(
		'tables' => array('tl_merconis_custom_dummy')
	)
);

$GLOBALS['FE_MOD']['merconis_custom'] = array(
	'mod_merconis_custom_dummy' => 'Merconis\Custom\mod_merconis_custom_dummy'
);


//$GLOBALS['MERCONIS_HOOKS']['preparingOrderDataToStore'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_preparingOrderDataToStore');
//$GLOBALS['MERCONIS_HOOKS']['replaceWidgetTemplateForReview'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_replaceWidgetTemplateForReview');
//$GLOBALS['MERCONIS_HOOKS']['storeCartItemInOrder'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_storeCartItemInOrder');
//$GLOBALS['MERCONIS_HOOKS']['beforeProductlistOutputBeforePagination'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_beforeProductlistOutputBeforePagination');
//$GLOBALS['MERCONIS_HOOKS']['customAjaxHook'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_customAjaxHook');
//$GLOBALS['MERCONIS_HOOKS']['callingHookedProductOrVariantFunction'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_callingHookedProductOrVariantFunction');
//$GLOBALS['MERCONIS_HOOKS']['prepareProductTemplate'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_prepareProductTemplate');
//$GLOBALS['MERCONIS_HOOKS']['onReceivingConfiguratorInput'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_onReceivingConfiguratorInput');
//$GLOBALS['MERCONIS_HOOKS']['manipulateProductOrVariantData'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_manipulateProductOrVariantData');
//$GLOBALS['MERCONIS_HOOKS']['modifyPaymentModuleTypes'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_modifyPaymentModuleTypes');
//$GLOBALS['MERCONIS_HOOKS']['import_begin'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_import_begin');
//$GLOBALS['MERCONIS_HOOKS']['import_finished'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_import_finished');
//$GLOBALS['MERCONIS_HOOKS']['import_beforeProcessingProductData'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_import_beforeProcessingProductData');
//$GLOBALS['MERCONIS_HOOKS']['import_beforeWritingProductData'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_import_beforeWritingProductData');
//$GLOBALS['MERCONIS_HOOKS']['import_afterUpdatingProductData'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_import_afterUpdatingProductData');
//$GLOBALS['MERCONIS_HOOKS']['import_afterInsertingProductData'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_import_afterInsertingProductData');
//$GLOBALS['MERCONIS_HOOKS']['import_beforeProcessingVariantData'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_import_beforeProcessingVariantData');
//$GLOBALS['MERCONIS_HOOKS']['import_beforeWritingVariantData'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_import_beforeWritingVariantData');
//$GLOBALS['MERCONIS_HOOKS']['import_afterUpdatingVariantData'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_import_afterUpdatingVariantData');
//$GLOBALS['MERCONIS_HOOKS']['import_afterInsertingVariantData'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_import_afterInsertingVariantData');
//$GLOBALS['MERCONIS_HOOKS']['import_beforeProcessingProductLanguageData'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_import_beforeProcessingProductLanguageData');
//$GLOBALS['MERCONIS_HOOKS']['import_beforeWritingProductLanguageData'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_import_beforeWritingProductLanguageData');
//$GLOBALS['MERCONIS_HOOKS']['import_afterWritingProductLanguageData'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_import_afterWritingProductLanguageData');
//$GLOBALS['MERCONIS_HOOKS']['import_beforeProcessingVariantLanguageData'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_import_beforeProcessingVariantLanguageData');
//$GLOBALS['MERCONIS_HOOKS']['import_beforeWritingVariantLanguageData'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_import_beforeWritingVariantLanguageData');
//$GLOBALS['MERCONIS_HOOKS']['import_afterWritingVariantLanguageData'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_import_afterWritingVariantLanguageData');
//$GLOBALS['MERCONIS_HOOKS']['beforeSendingOrderMessage'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_beforeSendingOrderMessage');
//$GLOBALS['MERCONIS_HOOKS']['beforeAddToCart'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_beforeAddToCart');
//$GLOBALS['MERCONIS_HOOKS']['getScalePriceQuantity'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_getScalePriceQuantity');
//$GLOBALS['MERCONIS_HOOKS']['calculateScaledPrice'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_calculateScaledPrice');
//$GLOBALS['MERCONIS_HOOKS']['afterCheckout'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_afterCheckout');
//$GLOBALS['MERCONIS_HOOKS']['beforeAjaxSearch'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_beforeAjaxSearch');
//$GLOBALS['MERCONIS_HOOKS']['afterAjaxSearch'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_afterAjaxSearch');
//$GLOBALS['MERCONIS_HOOKS']['beforeSearch'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_beforeSearch');
//$GLOBALS['MERCONIS_HOOKS']['afterSearch'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_afterSearch');
//$GLOBALS['MERCONIS_HOOKS']['beforeProductlistOutput'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_beforeProductlistOutput');
//$GLOBALS['MERCONIS_HOOKS']['beforeProductSingleviewOutput'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_beforeProductSingleviewOutput');
//$GLOBALS['MERCONIS_HOOKS']['addToCart'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_addToCart');
//$GLOBALS['MERCONIS_HOOKS']['beforeRedirectionToSeparateDataEntryPage'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_beforeRedirectionToSeparateDataEntryPage');
//$GLOBALS['MERCONIS_HOOKS']['beforeRedirectionBackToCart'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_beforeRedirectionBackToCart');
//$GLOBALS['MERCONIS_HOOKS']['beforeRedirectionToReviewOrderPage'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_beforeRedirectionToReviewOrderPage');
//$GLOBALS['MERCONIS_HOOKS']['paymentOptionSelected'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_paymentOptionSelected');
//$GLOBALS['MERCONIS_HOOKS']['shippingOptionSelected'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_shippingOptionSelected');
//$GLOBALS['MERCONIS_HOOKS']['initializeCartController'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_initializeCartController');
//$GLOBALS['MERCONIS_HOOKS']['modifyPaymentOrShippingMethodInfo'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_modifyPaymentOrShippingMethodInfo');
//$GLOBALS['MERCONIS_HOOKS']['checkIfPaymentOrShippingMethodIsAllowed'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_checkIfPaymentOrShippingMethodIsAllowed');
//$GLOBALS['MERCONIS_HOOKS']['sortPaymentOrShippingMethods'][] = array('Merconis\Custom\merconis_custom_helper', 'merconis_hook_sortPaymentOrShippingMethods');